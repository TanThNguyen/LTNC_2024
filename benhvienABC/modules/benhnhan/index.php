
<?php
if (!defined('_CODE')) {
    die('Access denied ...');
}


$data = [
    'pageTitle' => 'Quản lý bệnh nhân'
];
layouts('header_page', $data);

include_Object('benhnhan');
$database = new Database();
$database->getConnection();

if (!isLogin($database)){
    redirect('?module=auth&action=login');
}


$benhnhan = new benhnhan($database);

$filterAll = filter();

if (!empty($filterAll['keyword'])){
    $listUsers = $benhnhan->search($filterAll['keyword'], $from_record_num, $records_per_page);
    $total_rows=$benhnhan->countAll($filterAll['keyword']);
} else {
    $listUsers = $benhnhan->readAll($from_record_num, $records_per_page);
    $total_rows=$benhnhan->countAll();
}
  
// specify the page where paging is used
$page_url = "?module=benhnhan&action=index&";
  


include_once "list.php";

layouts('footer_page');

?>