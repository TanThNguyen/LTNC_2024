<?php
if (!defined('_CODE')) {
    die('Access denied ...');
}
$data = [
    'pageTitle' => 'Thông tin thuốc'
];
layouts('header_page',$data);
include_Object('thuoc');
include_Object('nhanvien');
include_Object('lothuoc');

$database = new Database();
$db = $database->getConnection();

if (!isLogin($database)){
    redirect('?module=auth&action=login');
}

$thuoc = new thuoc($database);
$nhanvien = new nhanvien($database);
$lothuoc = new lothuoc($database);

$filterAll = filter();

if (!empty($filterAll['id'])) {
    $thuoc->setId($filterAll['id']);
    $query = $thuoc->readOne();
    if (!empty($query)) {
?>
        <a href="?module=qlythuoc&action=index" type="submit" class="mg-btn btn btn-success btn-block">Quay lại</a>
        <table class="table table-bordered">
        <tr>
            <td>Mã số</td>
            <td><?php echo $query['id']; ?></td>
        </tr>
        <tr>
            <td>Tên thuốc</td>
            <td><?php echo $query['ten']; ?></td>
        </tr>
                <tr>
            <td>Tác dụng</td>
            <td><?php echo $query['TacDung']; ?></td>
        </tr>
        <tr>
            <td>Số lượng</td>
            <td><?php echo $query['soluong']; ?></td>
        </tr>
        <tr>
            <td>Giá</td>
            <td><?php echo $query['gia']; ?></td>
        </tr>
        <tr>
            <td>Mã số nhân viên quản lý</td>
            <td><?php echo $query['ql_id']; ?></td>
        </tr>
        <tr>
            <td>Cập nhật lần cuối</td>
            <td><?php echo $query['update_at']; ?></td>
        </tr>
        </table>

<?php

    $lothuoc->setThuoc_id($thuoc->getId());
    if (!empty($filterAll['keyword'])){
        // echo"hello<br>";
        // die();
    $listUsers = $lothuoc->search($filterAll['keyword'], $from_record_num, $records_per_page);
    $total_rows=$lothuoc->countAll($filterAll['keyword']);
    $page_url = "?module=qlythuoc&action=read_one&id=".$thuoc->getId()."&keyword=".$filterAll['keyword']."&";
} else {
    $listUsers = $lothuoc->readAll($from_record_num, $records_per_page);
    $total_rows=$lothuoc->countAll();
    $page_url = "?module=qlythuoc&action=read_one&id=".$thuoc->getId()."&";
}

?>
    <div class="container">
    <?php
    $msg = getFlashData('msg');
    $type = getFlashData('type');
    if (!empty($msg)) {
        getMsg($msg, $type);
    }
    ?>
    <form role="search" method='post'>
        <a href="?module=qlythuoc&action=add_lothuoc&id=<?php echo $thuoc->getId(); ?>" class="btn btn-success btn-sm">Thêm lô thuốc<i class="fa-solid fa-plus"></i></a>
        <div class='input-group col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3'>
        <input type="search" class="form-control" placeholder="Vui long nhap khong dau" aria-label="Search" name='keyword'>
            <div class='input-group-btn'>
            <input type="hidden" name="id" value="<?php echo $thuoc->getId(); ?>">
            <button class='btn btn-primary' type='submit'><i class='glyphicon glyphicon-search'></i>Tìm kiếm</button>
            </div>
        </div>
    </form>
    <table class="table table-bordered">
        <thead>
            <th>STT</th>
            <th>Nhà Phân Phối</th>
            <th>NSX</th>
            <th>HSD</th>
            <th>Số lượng</th>
            <th>Giá</th>
            <th width="5%">Sửa</th>
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
                        <td><?php echo $item['nhaphanphoi']; ?></td>
                        <td><?php echo $item['NSX']; ?></td>
                        <td><?php echo $item['HSD']; ?></td>
                        <td><?php echo $item['soluong']; ?></td>
                        <td><?php echo $item['gia']; ?></td>
                        <td><a href= "<?php echo _WEB_HOST; ?>?module=qlythuoc&action=edit_lothuoc&thuoc_id=<?php echo $item['thuoc_id']; ?>&id=<?php echo $item['id']; ?>" class="btn btn-warming btn-sm"><i class="fa-solid fa-pen-to-square"></i></a></td>
                        
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
<?php
    } else {
        setFlashData('msg', 'Thuốc không tồn tại');
        setFlashData('type', 'danger');
        redirect('?module=qlythuoc&action=index');
    }
}