<?php

$data = [
    'pageTitle' => 'Thêm đơn thuốc'
];
layouts('header_page', $data);

include_Object('donthuoc');
include_Object('nhanvien');
include_Object('benhan');

$database = new Database();
$db = $database->getConnection();

$sql = "SELECT ten FROM khothuoc";
$queryXX = $database->getRow($sql);

if (!isLogin($database)) {
    redirect('?module=auth&action=login');
}

$benhan = new benhan($database);
$nhanvien = new nhanvien($database);
$donthuoc = new donthuoc($database);

$filterAll = filter();

if (!empty($filterAll['id'])) {

    $donthuoc->setId($filterAll['id']);
    $query = $donthuoc->readOne();

    if (!empty($query)) {
        setFlashData('user_edit', $query);
    } else {
        setFlashData('msg', 'Đơn thuốc không hợp lệ');
        setFlashData('type', 'danger');
        redirect('?module=donthuoc&action=index');
    }
}

if (isPost()) {
    $filterAll = filter();
        foreach ($filterAll['tenthuoc'] as $key => $value) {
            $dataIns = [
                'donthuoc_id'=>$donthuoc->getId(),
                'tenthuoc' => $value,
                'soluong'  => $filterAll['soluong'][$key]
            ];

            $insStatus = $donthuoc->add_thuoc($dataIns);
            if(!$insStatus){
                setFlashData('msg', 'Hệ thống đang gặp sự cố, vui lòng thử lại sau.');
                setFlashData('type', 'danger');
                break;
            }
            if(!$donthuoc->update_chiphidieutri($dataIns['soluong'], $dataIns['tenthuoc'])){
                setFlashData('msg', 'Hệ thống đang gặp sự cố, vui lòng thử lại sau.');
                setFlashData('type', 'danger');
                break;
            }
            if($filterAll['tenthuoc'][$key + 1] == NULL){
                setFlashData('msg', 'Thêm thành công.');
                setFlashData('type', 'success');
            }
        }

    redirect('?module=donthuoc&action=add_thuoc&id=' . $donthuoc->getId());
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
        <div class="dynamic-wrap">
            <form action="" method="post">
                <div class="row">
                    <div class="form-group mg-form">
                        <label for="">Mã số nhân viên</label>
                        <input name="nv_id" type="nv_id" class="form-control" placeholder="Mã số nhân viên" value="<?php echo old_data('nv_id', $old); ?>" readonly>

                    </div>
                    <div class="form-group mg-form">
                        <label for="">Mã số bệnh nhân</label>
                        <input name="bn_id" type="bn_id" class="form-control" placeholder="Mã số bệnh nhân" value="<?php echo old_data('bn_id', $old); ?>" readonly>

                    </div>
                    <div class="form-group mg-form">
                        <label for="">Mã số bệnh án</label>
                        <input name="ba_id" type="ba_id" class="form-control" placeholder="Mã số bệnh án" value="<?php echo old_data('ba_id', $old); ?>" readonly>

                    </div>

                    <div>
                        <input type="submit" value="Thêm" class="btn btn-primary w-25" id="add_btn">
                    </div>
                    
                        <div class="entry input-group">
                            <div class="col-md-4 mb-4">
                                <select name="tenthuoc[]" class="searchddl">
                                    <?php
                                    if (!empty($queryXX)) :
                                        foreach ($queryXX as $item) :
                                            echo "<option> $item[ten] </option>";
                                        endforeach;
                                    endif;

                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <input type="number" name="soluong[]" class="form-control" placeholder="Số lượng" required>
                            </div>
                            <span class="input-group-btn">
                                <button class="btn btn-success btn-add" type="button">
                                    <span class="glyphicon glyphicon-plus">ADD MORE</span>
                                </button>
                            </span>
                        </div>
                </div>
                <input type="hidden" name="id" value="<?php echo $donthuoc->getId(); ?>">
            </form>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css"/>

<script>
        // $(".searchddl").chosen({
        //     width: '100%',
        //     search_contains: true,
        //     no_results_text: 'Không tìm thấy kết quả'
        // });
        //LỖI FIX ĐƯỢC THÌ BỎ VÀO


    $(document).ready(function() {
        // Khởi tạo Chosen cho các dropdown có class là "searchddl"


        // Sự kiện click cho nút "Thêm"
        $(document).on('click', '.btn-add', function(e) {
            e.preventDefault();

            // Lấy form dynamic-wrap và entry hiện tại
            var dynaForm = $('.dynamic-wrap form:first'),
                currentEntry = $(this).parents('.entry:first');

            // Clone entry hiện tại và thêm vào cuối form
            var newEntry = currentEntry.clone().appendTo(dynaForm);

            currentEntry.find('input').val('');

            // Xóa class btn-add và thêm class btn-remove cho nút thêm mới
            newEntry.find('.btn-add')
                .removeClass('btn-add').addClass('btn-remove')
                .removeClass('btn-success').addClass('btn-danger')
                .html('<span class="glyphicon glyphicon-minus">Remove</span>');

            // Refresh Chosen cho dropdown mới
            currentEntry.find('.searchddl').chosen({
                width: '100%',
                search_contains: true,
                no_results_text: 'Không tìm thấy kết quả'
            });
        });

        // Sự kiện click cho nút "Xóa"
        $(document).on('click', '.btn-remove', function(e) {
            e.preventDefault();
            $(this).parents('.entry:first').remove();
        });
    });
</script>



<?php
layouts('footer_page');
?>