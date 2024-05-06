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
    <h2>Quản lý kho thuốc</h2>
    <p>
        <a href="?module=qlythuoc&action=add_thuoc" class="btn btn-success btn-sm">Thêm Loại Thuốc<i class="fa-solid fa-plus"></i></a>
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
            <th>id</th>
            <th>Tên Thuốc</th>
            <th>Tác Dụng</th>
            <th>Số lượng</th>
            <th>Giá</th>
            <th>Mã nhân viên quản lý</th>
            <th>Cập nhật lần cuối</th>
            <th width="5%">Đọc</th>
            <th width="5%">Thêm</th>
            <th width="5%">Sửa</th>
            <th width="5%">Xóa</th>
        </thead>
        <tbody>
            <?php
            if (!empty($listUsers)) :
                foreach ($listUsers as $item) :
            ?>
                    <tr>
                        <td><?php echo $item['id']; ?></td>
                        <td><?php echo $item['ten']; ?></td>
                        <td><?php echo $item['TacDung']; ?></td>
                        <td><?php echo $item['soluong']; ?></td>
                        <td><?php echo $item['gia']; ?></td>
                        <td><?php echo $item['ql_id']; ?></td>
                        <td><?php echo $item['update_at']; ?></td>
                        <td><a href= "<?php echo _WEB_HOST; ?>?module=qlythuoc&action=read_one&id=<?php echo $item['id']; ?>" class="btn btn-warming btn-sm"><i class="fa-solid fa-folder-open"></i></a></td>
                        <td><a href= "<?php echo _WEB_HOST; ?>?module=qlythuoc&action=add_lothuoc&id=<?php echo $item['id']; ?>" class="btn btn-warming btn-sm"><i class="fa-solid fa-plus"></i></a></td>
                        <td><a href= "<?php echo _WEB_HOST; ?>?module=qlythuoc&action=edit_thuoc&id=<?php echo $item['id']; ?>" class="btn btn-warming btn-sm"><i class="fa-solid fa-pen-to-square"></i></a></td>
                        <td><a href= "<?php echo _WEB_HOST; ?>?module=qlythuoc&action=delete&id=<?php echo $item['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa.')" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a></td>
                    </tr>
                <?php
                endforeach;
            else :
                ?>
                <tr>
                    <td colspan="7">
                        <div class="alert alert-danger text-center">Không có Loại thuốc. Hãy thêm.</div>
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


