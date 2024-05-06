<?php
if (!defined('_CODE')) {
    die('Access denied ...');
}

$data = [
    'pageTitle' => 'Đặt lại mật khẩu'
];
layouts('header', $data);

$database = new Database();
$database->getConnection();
//Kiểm tra trạng thái đăng nhập
if (isLogin($database)) {
    redirect('?module=home&action=dashboard');
}

$token = filter()['token'];

if (!empty($token)) {
    $query = $database->oneRow("SELECT id FROM users WHERE forgotToken='$token';");

    if (!empty($query)) {
        $userId = $query['id'];
        if (isPost()) {
            $filterAll = filter();
            $errors = [];           //Mảng chứa lỗi

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


            if (empty($errors)) {
                $dataUpd = [
                    'password' => password_hash($filterAll['password'], PASSWORD_DEFAULT),
                    'forgotToken' => null,
                    'update_at' => date('Y-m-d H:i:s')
                ];
                $updStatus = $database->update('users', $dataUpd, "id=$userId");
                if ($updStatus) {
                    setFlashData('msg', 'Thay đổi mật khẩu thành công');
                    setFlashData('type', 'success');
                    redirect('?module=auth&action=login');
                } else {
                    setFlashData('msg', 'Hệ thống đang gặp sự cố, vui lòng thử lại sau.');
                    setFlashData('type', 'danger');
                }
            } else {
                setFlashData('msg', 'Vui lòng kiểm tra lại dữ liệu.');
                setFlashData('type', 'danger');
                setFlashData('errors', $errors);
                redirect('?module=auth&action=reset&token=' . $token);
            }
        }

        $errors = getFlashData('errors');

?>



        <div class="row">
            <div class="col-4" style="margin: 50px auto">
                <h2 class="text-center text-uppercase">Đặt lại mật khẩu</h2>
                <?php
                $msg = getFlashData('msg');
                $type = getFlashData('type');
                if (!empty($msg)) {
                    getMsg($msg, $type);
                }
                ?>
                <form action="" method="post">
                    <div class="form-group mg-form">
                        <label for="">Password</label>
                        <input name="password" type="password" class="form-control" placeholder="Mật khẩu">
                        <?php
                        echo form_error("password", '<span class= "error" >', '</span>', $errors);
                        ?>
                    </div>
                    <div class="form-group mg-form">
                        <label for="">Nhập lại mật khẩu</label>
                        <input name="password_confirm" type="password" class="form-control" placeholder="Nhập lại mật khẩu">
                        <?php
                        echo form_error("password_confirm", '<span class= "error" >', '</span>', $errors);
                        ?>
                    </div>
                    <input type="hidden" name="token" value="<?php echo $token; ?>">
                    <button type="submit" class="mg-btn btn btn-primary btn-block">Gửi</button>
                    <hr>
                    <p class="text-center"><a href="?module=auth&action=login">Đăng Nhập</a></p>
                </form>
            </div>

        </div>

<?php
    } else {
        getMsg('Liên kết không tồn tại hoặc đã hết hạn.', 'danger');
    }
} else {
    getMsg('Liên kết không tồn tại hoặc đã hết hạn.', 'danger');
}
