<?php
if (!defined('_CODE')) {
    die('Access denied ...');
}
$data = [
    'pageTitle' => 'Chỉnh sửa thông tin thuốc'
];
layouts('header_page',$data);

include_Object('thuoc');
include_Object('nhanvien');
$database = new Database();
$db = $database->getConnection();

if (!isLogin($database)){
    redirect('?module=auth&action=login');
}

$thuoc = new thuoc($database);
$nhanvien = new nhanvien($database);


$filterAll = filter();

if (!empty($filterAll['id'])) {
    $thuoc->setId($filterAll['id']);
    $query = $thuoc->readOne();
    if (!empty($query)) {
        setFlashData('user_edit', $query);
    } else {
        setFlashData('msg', 'Thuốc không hợp lệ');
        setFlashData('type', 'danger');
        redirect('?module=qlythuoc&action=index');
    }
}

if (isPost()) {
    $filterAll = filter();
    $errors = [];           //Mảng chứa lỗi


    //Validate ten: bắt buộc phải nhập
    if (empty($filterAll['ten'])) {
        $errors['ten']['required'] = 'Họ tên bắt buộc phải nhập.';
    }

    if (empty($filterAll['TacDung'])) {
        $errors['TacDung']['required'] = 'Họ tên bắt buộc phải nhập.';
    }

    //Validate gia
    if (!empty($filterAll['soluong']) && ($filterAll['soluong'] < 0)) {
        $errors['soluong']['format'] = 'Số lượng không hợp lệ';
    }

    //Validate gia
    if (!empty($filterAll['gia']) && ($filterAll['gia'] < 0)) {
        $errors['gia']['format'] = 'Giá không hợp lệ';
    }


    //Validate ql_id
    if (empty($filterAll['ql_id'])) {
        $errors['ql_id']['required'] = 'Mã nhân viên quản lý bắt buộc phải nhập.';
    } else {
        $nhanvien->setId($filterAll['ql_id']);
        $query = $nhanvien->readOne();
        if (empty($query)) {
            $errors['ql_id']['unique'] = 'Nhân viên không tồn tại.';
        } else {
            if ($query['status'] != 1) {
            $errors['ql_id']['unique'] = 'Nhân viên đã nghỉ. Vui lòng chọn nhân viên khác'; 
            }
        }
    }


    if (empty($errors)) {
        $thuoc->setId($filterAll['id']);
        $thuoc->setName($filterAll['ten']);
        $thuoc->setTacDung($filterAll['TacDung']);
        $thuoc->setSoLuong($filterAll['soluong']);
        $thuoc->setGia($filterAll['gia']);
        $thuoc->setQL_ID($filterAll['ql_id']);

        $updStatus = $thuoc->update();
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
    redirect('?module=qlythuoc&action=edit_thuoc&id=' . $thuoc->getId());
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
                    <div class="form-group mg-form">
                        <label for="">Mã số</label>
                        <input name="id" type="id" class="form-control" value="<?php echo old_data('id', $old); ?>" readonly>
                    </div>
                    <div class="form-group mg-form">
                        <label for="">Tên thuốc</label>
                        <input name="ten" type="ten" class="form-control" placeholder="Tên thuốc" value="<?php echo old_data('ten', $old); ?>">
                        <?php
                        echo form_error("ten", '<span class= "error" >', '</span>', $errors);
                        ?>
                    </div>

                    <div class="form-group mg-form">
                        <label for="">Tác dụng</label>
                        <input name="TacDung" type="TacDung" class="form-control" placeholder="Tác dụng" value="<?php echo old_data('TacDung', $old); ?>">
                        <?php
                        echo form_error("ten", '<span class= "error" >', '</span>', $errors);
                        ?>
                    </div>

                    <div class="form-group mg-form">
                        <label for="">Số lượng</label>
                        <input name="soluong" type="soluong" class="form-control" placeholder="Số lượng" value="<?php echo old_data('soluong', $old); ?>">
                        <?php
                        echo form_error("soluong", '<span class= "error" >', '</span>', $errors);
                        ?>
                    </div>
                    <div class="form-group mg-form">
                        <label for="">Giá</label>
                        <input name="gia" type="gia" class="form-control" placeholder="Giá" value="<?php echo old_data('gia', $old); ?>">
                        <?php
                        echo form_error("gia", '<span class= "error" >', '</span>', $errors);
                        ?>
                    </div>
                    <div class="form-group mg-form">
                        <label for="">Mã Nhân viên quản lý</label>
                        <input name="ql_id" type="ql_id" class="form-control" placeholder="Mã nhân viên quản lý" value="<?php echo old_data('ql_id', $old); ?>">
                        <?php
                        echo form_error("ql_id", '<span class= "error" >', '</span>', $errors);
                        ?>
                    </div>
            </div>

            <input type="hidden" name="id" value="<?php echo $thuoc->getId(); ?>">
            <button type="submit" class="mg-btn btn btn-primary btn-block">Sửa</button>
            <a href="?module=qlythuoc&action=index" type="submit" class="mg-btn btn btn-success btn-block">Quay lại</a>
            <hr>
        </form>
    </div>

</div>

<?php
layouts('footer_page');
?>