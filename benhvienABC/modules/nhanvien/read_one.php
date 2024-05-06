<?php
if (!defined('_CODE')) {
    die('Access denied ...');
}
$data = [
    'pageTitle' => 'Thông tin nhân viên'
];
layouts('header_page',$data);
include_once 'objects/nhanvien.php';
$database = new Database();
$db = $database->getConnection();

if (!isLogin($database)){
    redirect('?module=auth&action=login');
}

$nhanvien = new Nhanvien($database);

$filterAll = filter();

if (!empty($filterAll['id'])) {
    $nhanvien->setId($filterAll['id']);
    $query = $nhanvien->readOne();
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
            <td>CCCD</td>
            <td><?php echo $query['CCCD']; ?></td>
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
            <td><?php echo ($query['gioitinh'] == 0 ? 'Nam' : 'Nữ'); ?></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><?php echo $query['email']; ?></td>
        </tr>
        <tr>
            <td>Số điện thoại</td>
            <td><?php echo $query['SDT']; ?></td>
        </tr>
        <tr>
            <td>Chuyên môn</td>
            <td><?php echo $query['chuyenmon']; ?></td>
        </tr>
        <tr>
            <td>Ngày vào làm</td>
            <td><?php echo $query['ngayvaolam']; ?></td>
        </tr>
        <tr>
            <td>Lương</td>
            <td><?php echo $query['luong']; ?></td>
        </tr>
        <tr>
            <td>Trạng thái</td>
            <td><?php echo $query['status'] == 1 ? '<button class="btn btn-success btn-sm">Còn làm việc</button>' : '<button class="btn btn-danger btn-sm">Đã nghỉ</button>'; ?></td>
        </tr>
        <tr>
            <td>Cập nhật lần cuối</td>
            <td><?php echo $query['update_at']; ?></td>
        </tr>
        <a href="?module=nhanvien&action=index" type="submit" class="mg-btn btn btn-success btn-block">Quay lại</a>
<?php
    } else {
        setFlashData('msg', 'Nhân viên không tồn tại');
        setFlashData('type', 'danger');
        redirect('?module=nhanvien&action=index');
    }
}