<?php
if (!defined('_CODE')) {
    die('Access denied ...');
}
$data = [
    'pageTitle' => 'Thêm đơn thuốc'
];
layouts('header_page',$data);

include_Object('donthuoc');
include_Object('nhanvien');
include_Object('benhan');

$database = new Database();
$db = $database->getConnection();

if (!isLogin($database)){
    redirect('?module=auth&action=login');
}

$donthuoc = new donthuoc($database);
$nhanvien = new nhanvien($database);
$benhan = new benhan($database);


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

    $benhan->setId($filterAll['ba_id']);
    $query = $benhan->readOne();

    if (empty($filterAll['bn_id'])) {
        $errors['bn_id']['required'] = 'Mã bệnh nhân bắt buộc phải nhập.';
    } else {
        if ($filterAll['bn_id'] != $query['bn_id']) {
            $errors['bn_id']['unique'] = 'Bệnh nhân không tồn tại hoặc không khớp bệnh án';
        }
    }

    if (empty($filterAll['ba_id'])) {
        $errors['ba_id']['required'] = 'Mã bệnh án bắt buộc phải nhập.';
    } else {
        
        if (empty($query)) {
            $errors['ba_id']['unique'] = 'Bệnh án không tồn tại.';
        }
    }

    if (empty($errors)) {

        $donthuoc->setnv_id($filterAll['nv_id']);
        $donthuoc->setbn_id($filterAll['bn_id']);
        $donthuoc->setba_id($filterAll['ba_id']);

        $insStatus = $donthuoc->add();
        if ($insStatus) {
            setFlashData('msg', 'Thêm thành công');
            setFlashData('type', 'success');
            redirect('?module=donthuoc&action=index');
        } else {
            setFlashData('msg', 'Hệ thống đang gặp sự cố, vui lòng thử lại sau.');
            setFlashData('type', 'danger');
            redirect('?module=donthuoc&action=add_donthuoc');
        }

    } else {
        setFlashData('msg', 'Vui lòng kiểm tra lại dữ liệu.');
        setFlashData('type', 'danger');
        setFlashData('errors', $errors);
        setFlashData('old', $filterAll);
        redirect('?module=donthuoc&action=add_donthuoc');
    }
}
$errors = getFlashData('errors');
$old = getFlashData('old');

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
                        <label for="">Mã số nhân viên</label>
                        <input name="nv_id" type="nv_id" class="form-control" placeholder="Mã số nhân viên" value="<?php echo old_data('nv_id', $old); ?>">
                        <?php
                        echo form_error("nv_id", '<span class= "error" >', '</span>', $errors);
                        ?>
                    </div>
                    <div class="form-group mg-form">
                        <label for="">Mã số bệnh nhân</label>
                        <input name="bn_id" type="bn_id" class="form-control" placeholder="Mã số bệnh nhân" value="<?php echo old_data('bn_id', $old); ?>">
                        <?php
                        echo form_error("bn_id", '<span class= "error" >', '</span>', $errors);
                        ?>
                    </div>
                    <div class="form-group mg-form">
                        <label for="">Mã số bệnh án</label>
                        <input name="ba_id" type="ba_id" class="form-control" placeholder="Mã số bệnh án" value="<?php echo old_data('ba_id', $old); ?>">
                        <?php
                        echo form_error("ba_id", '<span class= "error" >', '</span>', $errors);
                        ?>
                    </div>


            </div>

            <button type="submit" class="mg-btn btn btn-primary btn-block">Thêm</button>
            <a href="?module=donthuoc&action=index" type="submit" class="mg-btn btn btn-success btn-block">Quay lại</a>
            <hr>
        </form>
    </div>

</div>

<?php
layouts('footer_page');
?>