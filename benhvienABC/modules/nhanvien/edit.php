<?php
if (!defined('_CODE')) {
    die('Access denied ...');
}
$data = [
    'pageTitle' => 'Chỉnh sửa thông tin nhân viên'
];
layouts('header_page',$data);

include_once 'objects/nhanvien.php';
$database = new Database();
$db = $database->getConnection();

if (!isLogin($database)){
    redirect('?module=auth&action=login');
}

$nhanvien = new Nhanvien($database);


$filterAll = filter();

if (!empty($filterAll['id'])) {
    $nhanvien->setId($filterAll['id']);
    $query = $nhanvien->readOne();
    if (!empty($query)) {
        setFlashData('user_edit', $query);
    } else {
        setFlashData('msg', 'Người dùng không hợp lệ');
        setFlashData('type', 'danger');
        redirect('?module=nhanvien&action=index');
    }
}

if (isPost()) {
    $filterAll = filter();
    $errors = [];           //Mảng chứa lỗi

    if (empty($filterAll['id'])) {
        $errors['id']['required'] = 'Họ tên bắt buộc phải nhập.';
    }

    //Validate ten: bắt buộc phải nhập
    if (empty($filterAll['ten'])) {
        $errors['ten']['required'] = 'Họ tên bắt buộc phải nhập.';
    }

    //Validate CCCD: Bắt buộc phải nhập, đúng định dạng CCCD
    if (empty($filterAll['CCCD'])) {
        $errors['CCCD']['required'] = 'CCCD bắt buộc phải nhập.';
    } else {
        if (!isCCCD($filterAll['CCCD'])) {
            $errors['CCCD']['isCCCD'] = 'CCCD không hợp lệ.';
        }
    }

    //Validate Ngaysinh
    if (empty($filterAll['ngaysinh'])) {
        $errors['ngaysinh']['required'] = 'Ngày sinh bắt buộc phải nhập.';
    }else{
        if (strtotime($filterAll['ngaysinh']) == false){
            $errors['ngaysinh']['format'] = 'Ngày sinh không hợp lệ';
        }
        else{
            if(strtotime($filterAll['ngaysinh']) > strtotime('20 year ago')){
                $errors['ngaysinh']['18'] = 'Nhân viên chưa đủ 18 tuổi.';
            }
        }
    }

    //Validate dia chi:
    if (empty($filterAll['diachi'])) {
        $errors['diachi']['required'] = 'Địa chỉ bắt buộc phải nhập.';
    }

    //Validate email: Bắt buộc phải nhập, đúng định dạng email, kiểm tra email đã tồn tại hay chưa
    if (empty($filterAll['email'])) {
        $errors['email']['required'] = 'Email bắt buộc phải nhập.';
    } else {
        $email = $filterAll['email'];
        $tmp_id = $nhanvien->getId();
        $sql = "SELECT id FROM nhanvien WHERE email = '$email' AND id <> '$tmp_id';";
        if ($nhanvien->check_exist($sql) > 0) {
            $errors['email']['unique'] = 'Email đã tồn tại.';
        }
    }

    //Validate SDT: Bắt buộc phải nhập, kiểm tra định dạng
    if (empty($filterAll['SDT'])) {
        $errors['SDT']['required'] = 'Số điện thoại bắt buộc phải nhập.';
    } else {
        if (!isphone($filterAll['SDT'])) {
            $errors['SDT']['isSDT'] = 'Số điện thoại không hợp lệ.';
        }
    }


    //Validate chuyên môn:
    if (empty($filterAll['chuyenmon'])) {
        $errors['chuyenmon']['required'] = 'Chuyên môn bắt buộc phải nhập.';
    }

    //Validate ngayvaolam
    if (!empty($filterAll['ngayvaolam'])) {
        if (strtotime($filterAll['ngayvaolam']) == false){
            $errors['ngayvaolam']['format'] = 'Ngày sinh không hợp lệ';
        }
        else{
            if(strtotime($filterAll['ngayvaolam']) < (strtotime($filterAll['ngaysinh']) + 568024668)){
                $errors['ngayvaolam']['18'] = 'Nhân viên chưa đủ 18 tuổi.';
            }
        }
    }


    if (empty($errors)) {
        $nhanvien->setId($filterAll['id']);
        $nhanvien->setName($filterAll['ten']);
        $nhanvien->setCCCD($filterAll['CCCD']);
        $nhanvien->setNgaySinh($filterAll['ngaysinh']);
        $nhanvien->setDiaChi($filterAll['diachi']);
        $nhanvien->setGioiTinh($filterAll['gioitinh']);
        $nhanvien->setEmail($filterAll['email']);
        $nhanvien->setPhone($filterAll['SDT']);
        $nhanvien->setChuyenMon($filterAll['chuyenmon']);
        $nhanvien->setNgayVaoLam($filterAll['ngayvaolam']);
        $nhanvien->setLuong($filterAll['luong']);
        $nhanvien->setStatus($filterAll['status']);

        $updStatus = $nhanvien->update();
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
    redirect('?module=nhanvien&action=edit&id=' . $nhanvien->getId());
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
                        <input name="ten" type="ten" class="form-control" placeholder="Họ và tên" value="<?php echo old_data('ten', $old); ?>">
                        <?php
                        echo form_error("ten", '<span class= "error" >', '</span>', $errors);
                        ?>
                    </div>
                    <div class="form-group mg-form">
                        <label for="">CCCD</label>
                        <input name="CCCD" type="CCCD" class="form-control" placeholder="CCCD" value="<?php echo old_data('CCCD', $old); ?>">
                        <?php
                        echo form_error("CCCD", '<span class= "error" >', '</span>', $errors);
                        ?>
                    </div>
                    <div class="form-group mg-form">
                        <label for="">Ngày sinh</label>
                        <input name="ngaysinh" type="ngaysinh" class="form-control" placeholder="yyyy-mm-dd" value="<?php echo old_data('ngaysinh', $old); ?>">
                        <?php
                        echo form_error("ngaysinh", '<span class= "error" >', '</span>', $errors);
                        ?>
                    </div>
                    <div class="form-group mg-form">
                        <label for="">Địa chỉ</label>
                        <input name="diachi" type="diachi" class="form-control" placeholder="Địa chỉ" value="<?php echo old_data('diachi', $old); ?>">
                        <?php
                        echo form_error("diachi", '<span class= "error" >', '</span>', $errors);
                        ?>
                    </div>
                    <div class="form-group mg-form">
                        <label for="">Giới tính</label>
                        <select name="gioitinh" id="form-control">
                            <option value="0" <?php echo (old_data('gioitinh', $old) == 0) ? 'selected' : false; ?>>Nam</option>
                            <option value="1" <?php echo (old_data('gioitinh', $old) == 1) ? 'selected' : false; ?>>Nữ</option>
                        </select>
                    </div>

 
                </div>
                <div class="col">
                   <div class="form-group mg-form">
                        <label for="">Email</label>
                        <input name="email" type="email" class="form-control" placeholder="Địa chỉ email" value="<?php echo old_data('email', $old); ?>">
                        <?php
                        echo form_error("email", '<span class= "error" >', '</span>', $errors);
                        ?>
                    </div>
                    <div class="form-group mg-form">
                        <label for="">Số điện thoại</label>
                        <input name="SDT" type="SDT" class="form-control" placeholder="Số điện thoại" value="<?php echo old_data('SDT', $old); ?>">
                        <?php
                        echo form_error("SDT", '<span class= "error" >', '</span>', $errors);
                        ?>
                    </div>
                    <div class="form-group mg-form">
                        <label for="">Chuyên môn</label>
                        <input name="chuyenmon" type="chuyenmon" class="form-control" placeholder="Chuyên môn" value="<?php echo old_data('chuyenmon', $old); ?>">
                        <?php
                        echo form_error("chuyenmon", '<span class= "error" >', '</span>', $errors);
                        ?>
                    </div>
                    <div class="form-group mg-form">
                        <label for="">Ngày vào làm</label>
                        <input name="ngayvaolam" type="ngayvaolam" class="form-control" placeholder="yyyy-mm-dd" value="<?php echo old_data('ngayvaolam', $old); ?>">
                        <?php
                        echo form_error("ngayvaolam", '<span class= "error" >', '</span>', $errors);
                        ?>
                    </div>
                    <div class="form-group mg-form">
                        <label for="">Lương</label>
                        <input name="luong" type="luong" class="form-control" placeholder="Lương" value="<?php echo old_data('luong', $old); ?>">
                        <?php
                        echo form_error("luong", '<span class= "error" >', '</span>', $errors);
                        ?>
                    </div>
                    <div class="form-group mg-form">
                        <label for="">Trạng thái</label>
                        <select name="status" id="form-control">
                            <option value="0" <?php echo (old_data('status', $old) == 0) ? 'selected' : false; ?>>Đã nghỉ</option>
                            <option value="1" <?php echo (old_data('status', $old) == 1) ? 'selected' : false; ?>>Đang làm</option>
                        </select>
                    </div>
                </div>
            </div>

            <input type="hidden" name="id" value="<?php echo $nhanvien->getId(); ?>">
            <button type="submit" class="mg-btn btn btn-primary btn-block">Sửa</button>
            <a href="?module=nhanvien&action=index" type="submit" class="mg-btn btn btn-success btn-block">Quay lại</a>
            <hr>
        </form>
    </div>

</div>

<?php
layouts('footer_page');
?>