<?php
if (!defined('_CODE')) {
    die('Access denied ...');
}
$data = [
    'pageTitle' => 'Chỉnh sửa thông tin bệnh nhân'
];
layouts('header_page',$data);

include_Object('benhnhan');
$database = new Database();
$db = $database->getConnection();

if (!isLogin($database)){
    redirect('?module=auth&action=login');
}

$benhnhan = new benhnhan($database);


$filterAll = filter();

if (!empty($filterAll['id'])) {
    $benhnhan->setId($filterAll['id']);
    $query = $benhnhan->readOne();
    if (!empty($query)) {
        setFlashData('user_edit', $query);
    } else {
        setFlashData('msg', 'Người dùng không hợp lệ');
        setFlashData('type', 'danger');
        redirect('?module=benhnhan&action=index');
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

    //Validate BaoHiem: Bắt buộc phải nhập, đúng định dạng BaoHiem
    if (empty($filterAll['BaoHiem'])) {
        $errors['BaoHiem']['required'] = 'BaoHiem bắt buộc phải nhập.';
    }

    //Validate Ngaysinh
    if (empty($filterAll['ngaysinh'])) {
        $errors['ngaysinh']['required'] = 'Ngày sinh bắt buộc phải nhập.';
    }else{
        if (strtotime($filterAll['ngaysinh']) == false){
            $errors['ngaysinh']['format'] = 'Ngày sinh không hợp lệ';
        }
    }

    //Validate dia chi:
    if (empty($filterAll['diachi'])) {
        $errors['diachi']['required'] = 'Địa chỉ bắt buộc phải nhập.';
    }

    //Validate SDT: Bắt buộc phải nhập, kiểm tra định dạng
    if (empty($filterAll['SDT'])) {
        $errors['SDT']['required'] = 'Số điện thoại bắt buộc phải nhập.';
    } else {
        if (!isphone($filterAll['SDT'])) {
            $errors['SDT']['isSDT'] = 'Số điện thoại không hợp lệ.';
        }
    }


    if (empty($errors)) {
        $benhnhan->setId($filterAll['id']);
        $benhnhan->setName($filterAll['ten']);
        $benhnhan->setBaoHiem($filterAll['BaoHiem']);
        $benhnhan->setNgaySinh($filterAll['ngaysinh']);
        $benhnhan->setDiaChi($filterAll['diachi']);
        $benhnhan->setGioiTinh($filterAll['gioitinh']);
        $benhnhan->setPhone($filterAll['SDT']);
        $benhnhan->setStatus($filterAll['status']);

        $updStatus = $benhnhan->update();
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
    redirect('?module=benhnhan&action=edit&id=' . $benhnhan->getId());
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
        <h2 class="text-center text-uppercase">Thêm</h2>
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
                        <label for="">Mã số</label>
                        <input name="id" type="id" class="form-control" value="<?php echo old_data('id', $old); ?>" readonly>
                    </div>
                    <div class="form-group mg-form">
                        <label for="">Họ và tên</label>
                        <input name="ten" type="ten" class="form-control" placeholder="Họ và tên" value="<?php echo old_data('ten', $old); ?>">
                        <?php
                        echo form_error("ten", '<span class= "error" >', '</span>', $errors);
                        ?>
                    </div>
                    <div class="form-group mg-form">
                        <label for="">BaoHiem</label>
                        <input name="BaoHiem" type="BaoHiem" class="form-control" placeholder="BaoHiem" value="<?php echo old_data('BaoHiem', $old); ?>">
                        <?php
                        echo form_error("BaoHiem", '<span class= "error" >', '</span>', $errors);
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
                        <label for="">Số điện thoại</label>
                        <input name="SDT" type="SDT" class="form-control" placeholder="Số điện thoại" value="<?php echo old_data('SDT', $old); ?>">
                        <?php
                        echo form_error("SDT", '<span class= "error" >', '</span>', $errors);
                        ?>
                    </div>
                    <div class="form-group mg-form">
                        <label for="">Trạng thái</label>
                        <select name="status" id="form-control">
                            <option value="0" <?php echo (old_data('status', $old) == 0) ? 'selected' : false; ?>>Không sử dụng</option>
                            <option value="1" <?php echo (old_data('status', $old) == 1) ? 'selected' : false; ?>>Đang sử dụng</option>
                        </select>
                    </div>
                </div>
            </div>

            <input type="hidden" name="id" value="<?php echo $benhnhan->getId(); ?>">
            <button type="submit" class="mg-btn btn btn-primary btn-block">Sửa</button>
            <a href="?module=benhnhan&action=index" type="submit" class="mg-btn btn btn-success btn-block">Quay lại</a>
            <hr>
        </form>
    </div>

</div>

<?php
layouts('footer_page');
?>