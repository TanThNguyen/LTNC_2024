
<?php
if (!defined('_CODE')) {
    die('Access denied ...');
}

$data = [
    'pageTitle' => 'Danh sách thuốc'
];
layouts('header_page', $data);

include_Object('donthuoc');

$database = new Database();
$database->getConnection();

if (!isLogin($database)){
    redirect('?module=auth&action=login');
}


$donthuoc = new donthuoc($database);

$filterAll = filter();

if (!empty($filterAll['keyword'])){
    $listUsers = $donthuoc->search($filterAll['keyword'], $from_record_num, $records_per_page);
    $total_rows=$donthuoc->countAll($filterAll['keyword']);
} else {
    $listUsers = $donthuoc->readAll($from_record_num, $records_per_page);
    $total_rows=$donthuoc->countAll();
}
// specify the page where paging is used
$page_url = "?module=donthuoc&action=index&";
  


include_once "list.php";

layouts('footer_page');

?>