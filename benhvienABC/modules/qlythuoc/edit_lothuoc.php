<?php
if (!defined('_CODE')) {
    die('Access denied ...');
}
$data = [
    'pageTitle' => 'Chỉnh sửa thông tin bệnh nhân'
];
layouts('header_page',$data);

include_Object('thuoc');
include_Object('lothuoc'); 

$database = new Database();
$db = $database->getConnection();

if (!isLogin($database)){
    redirect('?module=auth&action=login');
}

$thuoc = new thuoc($database);
$lothuoc = new lothuoc($database);

$filterAll = filter();
$query1 = null;
$query2 = null;


if (!empty($filterAll['id'])) {
    $thuoc->setId($filterAll['thuoc_id']);
    $query1 = $thuoc->readOne();
    $lothuoc->setId($filterAll['id']);
    $query2 = $lothuoc->readOne();
    if (!empty($query1) AND !empty($query2)) {
        setFlashData('user_edit', $query2);
    } else {
        setFlashData('msg', 'Lô thuốc không hợp lệ');
        setFlashData('type', 'danger');
        redirect('?module=qlythuoc&action=index');
    }
}



if (isPost()) {
    $filterAll = filter();
    $errors = [];           //Mảng chứa lỗi

    //Validate nhaphanphoi: Bắt buộc phải nhập, đúng định dạng nhaphanphoi
    if (empty($filterAll['nhaphanphoi'])) {
        $errors['nhaphanphoi']['required'] = 'nhaphanphoi bắt buộc phải nhập.';
    }

    //Validate NSX
    if (empty($filterAll['NSX'])) {
        $errors['NSX']['required'] = 'Ngày sản xuất bắt buộc phải nhập.';
    }else{
        if (strtotime($filterAll['NSX']) == false){
            $errors['NSX']['format'] = 'Ngày sản xuất không hợp lệ';
        }
    }

    //Validate HSD:
    if (empty($filterAll['HSD'])) {
        $errors['HSD']['required'] = 'hạn sử dụng bắt buộc phải nhập.';
    }else{
        if (strtotime($filterAll['HSD']) == false){
            $errors['HSD']['format'] = 'hạn sử dụng không hợp lệ';
        }
    }

    if (empty($filterAll['soluong'])) {
        $errors['soluong']['required'] = 'Số lượng bắt buộc phải nhập.';
    } else {
        if($filterAll['soluong'] < 0) {
            $errors['soluong']['format'] = 'Số lượng không hợp lệ';
        }
    }

    //Validate gia
    if (empty($filterAll['gia'])) {
        $errors['gia']['required'] = 'Giá bắt buộc phải nhập.';
    } else {
        if($filterAll['gia'] < 0) {
            $errors['gia']['format'] = 'Giá không hợp lệ';
        }
    }

    if (empty($errors)) {

        $lothuoc->setId($filterAll['id']);
        $lothuoc->setThuoc_id($filterAll['thuoc_id']);
        $lothuoc->setNhaPhanPhoi($filterAll['nhaphanphoi']);
        $lothuoc->setNSX($filterAll['NSX']);
        $lothuoc->setHSD($filterAll['HSD']);
        $lothuoc->setSoLuong($filterAll['soluong']);
        $lothuoc->setGia($filterAll['gia']);

        $updStatus = $lothuoc->update();
        if ($updStatus) {
            
            $SL = $query1['soluong'] - $query2['soluong'] + $lothuoc->getSoLuong();
            if ($thuoc->update_SL($SL)){
                setFlashData('msg', 'Cập nhật thành công');
                setFlashData('type', 'success');
                redirect('?module=qlythuoc&action=read_one&id='.$thuoc->getId());
            }   else {
                setFlashData('msg', 'Hệ thống đang gặp sự cố, vui lòng thử lại sau.');
                setFlashData('type', 'danger');
                redirect('?module=qlythuoc&action=edit_lothuoc&thuoc_id='.$thuoc->getId().'&id='.$lothuoc->getId());
            }
        }
    } else {
        setFlashData('msg', 'Vui lòng kiểm tra lại dữ liệu.');
        setFlashData('type', 'danger');
        setFlashData('errors', $errors);
        setFlashData('old', $filterAll);
    }
    redirect('?module=qlythuoc&action=edit_lothuoc&thuoc_id='.$thuoc->getId().'&id='.$lothuoc->getId());
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
                        <label for="">Mã số thuốc</label>
                        <input name="thuoc_id" type="thuoc_id" class="form-control" value="<?php echo old_data('thuoc_id', $old); ?>" readonly>

                    </div>
                    <div class="form-group mg-form">
                        <label for="">Nhà phân phối</label>
                        <input name="nhaphanphoi" type="nhaphanphoi" class="form-control" placeholder="nhaphanphoi" value="<?php echo old_data('nhaphanphoi', $old); ?>">
                        <?php
                        echo form_error("nhaphanphoi", '<span class= "error" >', '</span>', $errors);
                        ?>
                    </div>
                    <div class="form-group mg-form">
                        <label for="">Ngày sản xuất</label>
                        <input name="NSX" type="NSX" class="form-control" placeholder="yyyy-mm-dd" value="<?php echo old_data('NSX', $old); ?>">
                        <?php
                        echo form_error("NSX", '<span class= "error" >', '</span>', $errors);
                        ?>
                    </div>
                    <div class="form-group mg-form">
                        <label for="">Hạn sử dụng</label>
                        <input name="HSD" type="HSD" class="form-control" placeholder="yyyy-mm-dd" value="<?php echo old_data('HSD', $old); ?>">
                        <?php
                        echo form_error("HSD", '<span class= "error" >', '</span>', $errors);
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
                </div>
            </div>

            <input type="hidden" name="id" value="<?php echo $lothuoc->getId(); ?>">
            <button type="submit" class="mg-btn btn btn-primary btn-block">Sửa</button>
            <a href="?module=qlythuoc&action=read_one&id=<?php echo $thuoc->getId(); ?>" type="submit" class="mg-btn btn btn-success btn-block">Quay lại</a>
            <hr>
        </form>
    </div>

</div>

<?php
layouts('footer_page');
?>