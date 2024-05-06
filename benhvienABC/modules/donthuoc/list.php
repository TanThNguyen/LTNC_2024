<?php
if (!defined('_CODE')) {
    die('Access denied ...');
}

if (!isLogin($database)){
    redirect('?module=auth&action=login');
}

?>

<div class="container">
    <hr>
    <h2>Quản lý đơn thuốc</h2>
    <p>
        <a href="?module=donthuoc&action=add_donthuoc" class="btn btn-success btn-sm">Thêm đơn thuốc<i class="fa-solid fa-plus"></i></a>
    </p>
    <?php
    $msg = getFlashData('msg');
    $type = getFlashData('type');
    if (!empty($msg)) {
        getMsg($msg, $type);
    }
    ?>
    <form role="search" method='post'>
        <div class='input-group col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3'>
        <input type="search" class="form-control" placeholder="Search..." aria-label="Search" name='keyword'>
            <div class='input-group-btn'>
            <button class='btn btn-primary' type='submit'><i class='glyphicon glyphicon-search'></i>Tìm kiếm</button>
            </div>
        </div>
    </form>
    <table class="table table-bordered">
        <thead>
            <th>Mã số đơn thuốc</th>
            <th>Mã số bác sĩ</th>
            <th>Mã số bệnh nhân</th>
            <th>Mã bệnh án</th>
            <th>Chi phí điều trị</th>
            <th>Thời gian tạo</th>
            <th width="5%">Thêm thuốc</th>
            <th width="5%">Xóa</th>
        </thead>
        <tbody>
            <?php
            if (!empty($listUsers)) :
                foreach ($listUsers as $item) :
            ?>
                    <tr>
                        <td><?php echo $item['id']; ?></td>
                        <td><?php echo $item['nv_id']; ?></td>
                        <td><?php echo $item['bn_id']; ?></td>
                        <td><?php echo $item['ba_id']; ?></td>
                        <td><?php echo $item['chiphidieutri']; ?></td>
                        <td><?php echo $item['create_at']; ?></td>
                        <td><a href= "<?php echo _WEB_HOST; ?>?module=donthuoc&action=add_thuoc&id=<?php echo $item['id']; ?>" class="btn btn-warming btn-sm"><i class="fa-solid fa-pen-to-square"></i></a></td>
                        <td><a href= "<?php echo _WEB_HOST; ?>?module=donthuoc&action=delete&id=<?php echo $item['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa.')" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a></td>
                        
                    </tr>
                <?php
                endforeach;
            else :
                ?>
                <tr>
                    <td colspan="7">
                        <div class="alert alert-danger text-center">Chưa có đơn thuốc.</div>
                    </td>
                </tr>
            <?php
            endif;
            ?>
        </tbody>
    </table>
    <?php
        require_once 'paging.php';

    ?>
</div>


