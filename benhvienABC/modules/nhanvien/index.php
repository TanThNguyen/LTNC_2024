
<?php
if (!defined('_CODE')) {
    die('Access denied ...');
}
include_once 'objects/nhanvien.php';

$data = [
    'pageTitle' => 'Quản lý người dùng'
];
layouts('header_page', $data);

$database = new Database();
$database->getConnection();

if (!isLogin($database)){
    redirect('?module=auth&action=login');
}


$nhanvien = new Nhanvien($database);

$filterAll = filter();

if (!empty($filterAll['keyword'])){
    $listUsers = $nhanvien->search($filterAll['keyword'], $from_record_num, $records_per_page);
    $total_rows=$nhanvien->countAll($filterAll['keyword']);
} else {
    $listUsers = $nhanvien->readAll($from_record_num, $records_per_page);
    $total_rows=$nhanvien->countAll();
}
  
// specify the page where paging is used
$page_url = "?module=nhanvien&action=index&";
  


include_once "list.php";

layouts('footer_page');

?>