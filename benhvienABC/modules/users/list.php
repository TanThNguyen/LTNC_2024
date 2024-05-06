<?php
if (!defined('_CODE')) {
    die('Access denied ...');
}

if (!isLogin($database)){
    redirect('?module=auth&action=login');
}

?>

<div class="container">

    <div class="login-header">
        <header>Quản lý người dùng</header>
        <p>
            <a href="?module=users&action=add" class="btn btn-success btn-sm">Thêm người dùng<i class="fa-solid fa-plus"></i></a>
        </p>
        <?php
            $msg = getFlashData('msg');
            $type = getFlashData('type');
            if (!empty($msg)) {
                getMsg($msg, $type);
            }
        ?>
    </div>

    
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
            <th>STT</th>
            <th>Họ tên</th>
            <th>Email</th>
            <th>Số điện thoại</th>
            <th>Trạng thái</th>
            <th width="5%">Sửa</th>
            <th width="5%">Xóa</th>
        </thead>
        <tbody>
            <?php
            if (!empty($listUsers)) :
                $count = $from_record_num;
                foreach ($listUsers as $item) :
                    $count++;
            ?>
                    <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $item['fullname']; ?></td>
                        <td><?php echo $item['email']; ?></td>
                        <td><?php echo $item['phone']; ?></td>
                        <td><?php echo $item['status'] == 1 ? '<button class="btn btn-success btn-sm">Đã kích hoạt</button>' : '<button class="btn btn-danger btn-sm">Chưa kích hoạt</button>'; ?></td>
                        <td><a href= "<?php echo _WEB_HOST; ?>?module=users&action=edit&id=<?php echo $item['id']; ?>" class="btn btn-warming btn-sm"><i class="fa-solid fa-pen-to-square"></i></a></td>
                        <td><a href= "<?php echo _WEB_HOST; ?>?module=users&action=delete&id=<?php echo $item['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa.')" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a></td>
                    </tr>
                <?php
                endforeach;
            else :
                ?>
                <tr>
                    <td colspan="7">
                        <div class="alert alert-danger text-center">Không có người dùng nào</div>
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


