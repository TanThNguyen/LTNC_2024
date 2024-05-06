<?php
if (!defined('_CODE')) {
    die('Access denied ...');
}
$data = [
    'pageTitle' => 'Thông tin nhân viên'
];
layouts('header_page',$data);

include_Object('benhnhan');
include_Object('benhan');

$database = new Database();
$db = $database->getConnection();

if (!isLogin($database)){
    redirect('?module=auth&action=login');
}

$benhnhan = new benhnhan($database);
$benhan = new benhan($database);

$filterAll = filter();
// var_dump($filterAll);
// die();
if (!empty($filterAll['id'])) {
    $benhnhan->setId($filterAll['id']);
    $query = $benhnhan->readOne();
    if (!empty($query)) {
?>
        <table class="table table-bordered">
        <tr>
            <td>id</td>
            <td><?php echo $query['id']; ?></td>
        </tr>
        <tr>
            <td>Họ tên</td>
            <td><?php echo $query['ten']; ?></td>
        </tr>
                <tr>
            <td>Mã số bảo hiểm</td>
            <td><?php echo $query['BaoHiem']; ?></td>
        </tr>
        <tr>
            <td>Ngày sinh</td>
            <td><?php echo $query['ngaysinh']; ?></td>
        </tr>
        <tr>
            <td>Địa chỉ</td>
            <td><?php echo $query['diachi']; ?></td>
        </tr>
        <tr>
            <td>Giới tính</td>
            <td><?php echo $query['status'] == 0 ? 'Nam' : 'Nữ'; ?></td>
        </tr>
        <tr>
            <td>Số điện thoại</td>
            <td><?php echo $query['SDT']; ?></td>
        </tr>
        <tr>
            <td>Trạng thái</td>
            <td><?php echo $query['status'] == 1 ? '<button class="btn btn-success btn-sm">Đang sử dụng</button>' : '<button class="btn btn-danger btn-sm">Dừng sử dụng</button>'; ?></td>
        </tr>
        <tr>
            <td>Cập nhật lần cuối</td>
            <td><?php echo $query['update_at']; ?></td>
        </tr>
        <a href="?module=benhnhan&action=index" type="submit" class="mg-btn btn btn-success btn-block">Quay lại</a>
        </table>
        
<?php
    $benhan->setbn_id($benhnhan->getId());
    if (!empty($filterAll['keyword'])){
    $listUsers = $benhan->search($filterAll['keyword'], $from_record_num, $records_per_page);
    $total_rows=$benhan->countAll($filterAll['keyword']);
    $page_url = "?module=benhnhan&action=read_one&id=".$benhnhan->getId()."&keyword=".$filterAll['keyword']."&";
    } else {
        $listUsers = $benhan->readAll($from_record_num, $records_per_page);
        $total_rows=$benhan->countAll();
        $page_url = "?module=benhnhan&action=read_one&id=".$benhnhan->getId()."&";
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
    <a href="?module=benhnhan&action=add_benhan&id=<?php echo $benhnhan->getId(); ?>" class="btn btn-success btn-sm">Thêm bệnh án<i class="fa-solid fa-plus"></i></a>
    <form role="search" method='post'>

        <div class='input-group col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3'>
        <input type="search" class="form-control" placeholder="Vui long nhap khong dau" aria-label="Search" name='keyword'>
            <div class='input-group-btn'>
            <input type="hidden" name="id" value="<?php echo $benhnhan->getId(); ?>">
            <button class='btn btn-primary' type='submit'><i class='glyphicon glyphicon-search'></i>Tìm kiếm</button>
            </div>
        </div>
    </form>
    <table class="table table-bordered">
        <thead>
            <th>STT</th>
            <th>Mã bệnh án</th>
            <th>Tên bệnh</th>
            <th>Phương pháp kiểm tra</th>
            <th>Thời điểm bắt đầu</th>
            <th>Thời điểm kết thúc</th>
            <th>Trạng thái</th>
            <th width="5%">Sửa</th>
            <th width="5%">Xóa</th>
            <th> Đơn thuốc</th>
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
                        <td><?php echo $item['id']; ?></td>
                        <td><?php echo $item['tenbenh']; ?></td>
                        <td><?php echo $item['phuongphapKT']; ?></td>
                        <td><?php echo $item['start']; ?></td>
                        <td><?php echo $item['end']; ?></td>
                        <td><?php echo $item['status']; ?></td>
                        <td><a href= "<?php echo _WEB_HOST; ?>?module=benhnhan&action=edit_benhan&bn_id=<?php echo $item['bn_id']; ?>&id=<?php echo $item['id']; ?>" class="btn btn-warming btn-sm"><i class="fa-solid fa-pen-to-square"></i></a></td>
                        
                        <td><a href= "<?php echo _WEB_HOST; ?>?module=benhnhan&action=delete_benhan&bn_id=<?php echo $item['bn_id']; ?>&id=<?php echo $item['id']; ?>" class="btn btn-warming btn-sm"><i class="fa-solid fa-trash"></i></a></td>
                                                <td><a href= "<?php echo _WEB_HOST; ?>?module=benhnhan&action=read_one_benhan&bn_id=<?php echo $item['bn_id']; ?>&id=<?php echo $item['id']; ?>" class="btn btn-warming btn-sm"><i class="fa-solid fa-pen-to-square"></i></a></td>
                        
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
        setFlashData('msg', 'Bệnh nhân không tồn tại');
        setFlashData('type', 'danger');
        redirect('?module=benhnhan&action=index');
    }
}