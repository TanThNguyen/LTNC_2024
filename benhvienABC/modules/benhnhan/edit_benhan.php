<?php
if (!defined('_CODE')) {
    die('Access denied ...');
}
$data = [
    'pageTitle' => 'Chỉnh sửa thông tin bệnh nhân'
];
layouts('header_page',$data);

include_Object('benhnhan');
include_Object('benhan'); 
include_Object('nhanvien');

$database = new Database();
$db = $database->getConnection();

if (!isLogin($database)){
    redirect('?module=auth&action=login');
}

$benhnhan = new benhnhan($database);
$benhan = new benhan($database);
$nhanvien = new nhanvien($database);

$filterAll = filter();
$query1 = null;
$query2 = null;

if (!empty($filterAll['id'])) {
    $benhnhan->setId($filterAll['bn_id']);
    $query1 = $benhnhan->readOne();
    $benhan->setId($filterAll['id']);
    $benhan->setbn_id($filterAll['bn_id']);
    $query2 = $benhan->readOne();
    if (!empty($query1) AND !empty($query2)) {
        setFlashData('user_edit', $query2);
    } else {
        setFlashData('msg', 'Lô thuốc không hợp lệ');
        setFlashData('type', 'danger');
        redirect('?module=benhnhan&action=index');
    }
}



if (isPost()) {
    $filterAll = filter();
    $errors = [];           //Mảng chứa lỗi

    //Validate nv_id: bắt buộc phải nhập
    if (empty($filterAll['nv_id'])) {
        $errors['nv_id']['required'] = 'Mã nhân viên bắt buộc phải nhập.';
    } else {
        $nhanvien->setId($filterAll['nv_id']);
        $query = $nhanvien->readOne();
        if (empty($query)) {
            $errors['nv_id']['unique'] = 'Nhân viên không tồn tại.';
        } else {
            if ($query['status'] != 1) {
            $errors['nv_id']['unique'] = 'Nhân viên đã nghỉ. Vui lòng chọn nhân viên khác';
            }
        }
    }

    if (empty($filterAll['tenbenh'])) {
        $errors['tenbenh']['required'] = 'Tên bệnh bắt buộc phải nhập.';
    }

    if (empty($errors)) {

        $benhan->setnv_id($filterAll['nv_id']);
        $benhan->settenbenh($filterAll['tenbenh']);
        $benhan->setphuongphapKT($filterAll['phuongphapKT']);
        $benhan->setstatus($filterAll['status']);
        $benhan->setstart($query2['start']);

        $updStatus = $benhan->update();
        if ($updStatus) {
            setFlashData('msg', 'Cập nhật thành công');
            setFlashData('type', 'success');
            redirect('?module=benhnhan&action=read_one&id='.$benhnhan->getId());
        }   else {
                setFlashData('msg', 'Hệ thống đang gặp sự cố, vui lòng thử lại sau.');
                setFlashData('type', 'danger');
                redirect('?module=benhnhan&action=edit_benhan&bn_id=' . $benhnhan->getId() . '&id='.$benhan->getId());
        }
    } else {
        setFlashData('msg', 'Vui lòng kiểm tra lại dữ liệu.');
        setFlashData('type', 'danger');
        setFlashData('errors', $errors);
        setFlashData('old', $filterAll);
    }
    redirect('?module=benhnhan&action=edit_benhan&bn_id='.$benhnhan->getId().'&id='.$benhan->getId());
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
        <h2 class="text-center text-uppercase">Sửa</h2>
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
                        <label for="">Mã số bệnh nhân</label>
                        <input name="bn_id" type="bn_id" class="form-control" value="<?php echo old_data('bn_id', $old); ?>" readonly>

                    </div>
                    <div class="form-group mg-form">
                        <label for="">Mã số nhân viên</label>
                        <input name="nv_id" type="nv_id" class="form-control" placeholder="Mã số nhân viên" value="<?php echo old_data('nv_id', $old); ?>">
                        <?php
                        echo form_error("nv_id", '<span class= "error" >', '</span>', $errors);
                        ?>
                    </div>
                    <div class="form-group mg-form">
                        <label for="">Tên bệnh</label>
                        <input name="tenbenh" type="tenbenh" class="form-control" placeholder="Tên bệnh" value="<?php echo old_data('tenbenh', $old); ?>">
                        <?php
                        echo form_error("tenbenh", '<span class= "error" >', '</span>', $errors);
                        ?>
                    </div>
                    <div class="form-group mg-form">
                        <label for="">Phương pháp Kiểm tra</label>
                        <input name="phuongphapKT" type="phuongphapKT" class="form-control" placeholder="PPKT" value="<?php echo old_data('phuongphapKT', $old); ?>">
                    </div>
                    <div class="form-group mg-form">
                        <label for="">Trạng Thái</label>
                        <select name="status" id="form-control">
                            <option value="Da xong" <?php echo (old_data('status', $old) == 'Da xong') ? 'selected' : false; ?>>Đã xong</option>
                            <option value="Dang kham" <?php echo (old_data('status', $old) == 'Dang kham') ? 'selected' : false; ?>>Đang khám</option>
                            <option value="Nhap vien" <?php echo (old_data('status', $old) == 'Nhap vien') ? 'selected' : false; ?>>Nhập viện</option>
                        </select>
                    </div>
                </div>
            </div>

            <input type="hidden" name="id" value="<?php echo $benhan->getId(); ?>">
            <button type="submit" class="mg-btn btn btn-primary btn-block">Sửa</button>
            <a href="?module=benhnhan&action=read_one&id=<?php echo $benhnhan->getId(); ?>" type="submit" class="mg-btn btn btn-success btn-block">Quay lại</a>
            <hr>
        </form>
    </div>

</div>

<?php
layouts('footer_page');
?>