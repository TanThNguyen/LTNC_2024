<?php
if (!defined('_CODE')) {
    die('Access denied ...');
}
$data = [
    'pageTitle' => 'Chỉnh sửa thông tin người dùng'
];
layouts('header_page',$data);

include_Object('user');
$database = new Database();
$db = $database->getConnection();

if (!isLogin($database)){
    redirect('?module=auth&action=login');
}

$user = new User($database);


$filterAll = filter();

if (!empty($filterAll['id'])) {
    $user->setId($filterAll['id']);
    $query = $user->readOne();
    if (!empty($query)) {
        setFlashData('user_edit', $query);
    } else {
        setFlashData('msg', 'Người dùng không hợp lệ');
        setFlashData('type', 'danger');
        redirect('?module=users&action=index');
    }
}

if (isPost()) {
    $filterAll = filter();
    $errors = [];           //Mảng chứa lỗi

    //Validate fullname: bắt buộc phải nhập 
    if (empty($filterAll['fullname'])) {
        $errors['fullname']['required'] = 'Họ tên bắt buộc phải nhập.';
    }

    //Validate email: Bắt buộc phải nhập, đúng định dạng email, kiểm tra email đã tồn tại hay chưa
    if (empty($filterAll['email'])) {
        $errors['email']['required'] = 'Email bắt buộc phải nhập.';
    } else {
        $email = $filterAll['email'];
        $tmp_id = $user->getId();
        $sql = "SELECT id FROM users WHERE email = '$email' AND id <> '$tmp_id';";
        if ($user->check_exist($sql) > 0) {
            $errors['email']['unique'] = 'Email đã tồn tại.';
        }
    }

    //Validate phone: Bắt buộc phải nhập, kiểm tra định dạng
    if (empty($filterAll['phone'])) {
        $errors['phone']['required'] = 'Số điện thoại bắt buộc phải nhập.';
    } else {
        if (!isPhone($filterAll['phone'])) {
            $errors['phone']['isPhone'] = 'Số điện thoại không hợp lệ.';
        }
    }


    if (!empty($filterAll['password'])) {

        //Validate password: Bắt buộc phải nhập, số ký tự >=8
        if (empty($filterAll['password'])) {
            $errors['password']['required'] = 'Mật khẩu bắt buộc phải nhập.';
        } else {
            if (strlen($filterAll['password']) < 8) {
                $errors['password']['min'] = 'Mật khẩu phải có ít nhất 8 ký tự.';
            }
        }

        //Validate password-confirm: Bắt buộc phải nhập, giống password
        if (empty($filterAll['password_confirm'])) {
            $errors['password_confirm']['required'] = 'Bạn bắt buộc phải nhập lại mật khẩu.';
        } else {
            if ($filterAll['password_confirm'] != $filterAll['password']) {
                $errors['password_confirm']['match'] = 'Sai mật khẩu.';
            }
        }
    }


    if (empty($errors)) {
        $user->setName($filterAll['fullname']);
        $user->setEmail($filterAll['email']);
        $user->setPhone($filterAll['phone']);
        $user->setStatus($filterAll['status']);

        if (!empty($filterAll['password'])) {
            $user->setPassword($filterAll['password']);

        }

        $updStatus = $user->update();
        if ($updStatus) {
            setFlashData('msg', 'Sửa thành công');
            setFlashData('type', 'success');
        } else {
            setFlashData('msg', 'Hệ thống đang gặp sự cố, vui lòng thử lại sau.');
            setFlashData('type', 'danger');
        }
    } else {
        setFlashData('msg', 'Vui lòng kiểm tra lại dữ liệu.');
        setFlashData('type', 'danger');
        setFlashData('errors', $errors);
        setFlashData('old', $filterAll);
    }
    redirect('?module=users&action=edit&id=' . $user->getId());
}
$errors = getFlashData('errors');
$old = getFlashData('old');
$user_edit = getFlashData('user_edit');
if (!empty($user_edit)) {
    $old = $user_edit;
}


?>
<div class="row">
    <div class="col-8" style="margin: 50px auto">
        <h2 class="text-center text-uppercase">Chỉnh sửa</h2>
        <?php
        $msg = getFlashData('msg');
        $type = getFlashData('type');
        if (!empty($msg)) {
            getMsg($msg, $type);
        }
        ?>
        <form action="" method="post">
            <div class="row">
                <div class="col">
                    <div class="form-group mg-form">
                        <label for="">Họ và tên</label>
                        <input name="fullname" type="fullname" class="form-control" placeholder="Họ và tên" value="<?php echo old_data('fullname', $old); ?>">
                        <?php
                        echo form_error("fullname", '<span class= "error" >', '</span>', $errors);
                        ?>
                    </div>
                    <div class="form-group mg-form">
                        <label for="">Email</label>
                        <input name="email" type="email" class="form-control" placeholder="Địa chỉ email" value="<?php echo old_data('email', $old); ?>">
                        <?php
                        echo form_error("email", '<span class= "error" >', '</span>', $errors);
                        ?>
                    </div>
                    <div class="form-group mg-form">
                        <label for="">Số điện thoại</label>
                        <input name="phone" type="phone" class="form-control" placeholder="Số điện thoại" value="<?php echo old_data('phone', $old); ?>">
                        <?php
                        echo form_error("phone", '<span class= "error" >', '</span>', $errors);
                        ?>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group mg-form">
                        <label for="">Password</label>
                        <input name="password" type="text" class="form-control" placeholder="Mật khẩu (Không nhập khi không đổi)">
                        <?php
                        echo form_error("password", '<span class= "error" >', '</span>', $errors);
                        ?>
                    </div>
                    <div class="form-group mg-form">
                        <label for="">Nhập lại mật khẩu</label>
                        <input name="password_confirm" type="password" class="form-control" placeholder="Nhập lại mật khẩu (Không nhập khi không đổi)">
                        <?php
                        echo form_error("password_confirm", '<span class= "error" >', '</span>', $errors);
                        ?>
                    </div>
                    <div class="form-group mg-form">
                        <label for="">Trạng thái</label>
                        <select name="status" id="form-control">
                            <option value="0" <?php echo (old_data('status', $old) == 0) ? 'selected' : false; ?>>Chưa kích hoạt</option>
                            <option value="1" <?php echo (old_data('status', $old) == 1) ? 'selected' : false; ?>>Đã kích hoạt</option>
                        </select>
                    </div>
                </div>
            </div>

            <input type="hidden" name="id" value="<?php echo $user->getId(); ?>">
            <button type="submit" class="mg-btn btn btn-primary btn-block">Sửa</button>
            <a href="?module=users&action=index" type="submit" class="mg-btn btn btn-success btn-block">Quay lại</a>
            <hr>
        </form>
    </div>

</div>

<?php
layouts('footer_page');
?>