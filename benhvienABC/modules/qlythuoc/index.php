
<?php
if (!defined('_CODE')) {
    die('Access denied ...');
}

$data = [
    'pageTitle' => 'Danh sách thuốc'
];
layouts('header_page', $data);

include_Object('thuoc');
include_Object('lothuoc'); 

$database = new Database();
$database->getConnection();

if (!isLogin($database)){
    redirect('?module=auth&action=login');
}


$thuoc = new thuoc($database);

$filterAll = filter();

if (!empty($filterAll['keyword'])){
    $listUsers = $thuoc->search($filterAll['keyword'], $from_record_num, $records_per_page);
    $total_rows=$thuoc->countAll($filterAll['keyword']);
} else {
    $listUsers = $thuoc->readAll($from_record_num, $records_per_page);
    $total_rows=$thuoc->countAll();
}
  
// specify the page where paging is used
$page_url = "?module=qlythuoc&action=index&";
  


include_once "list.php";

layouts('footer_page');

?>