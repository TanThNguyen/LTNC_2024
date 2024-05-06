
<?php
if (!defined('_CODE')) {
    die('Access denied ...');
}

$data = [
    'pageTitle' => 'Quản lý người dùng'
];
layouts('header_page', $data);

include_Object('user');

$database = new Database();
$database->getConnection();

if (!isLogin($database)){
    redirect('?module=auth&action=login');
}


$user = new User($database);

$filterAll = filter();

if (!empty($filterAll['keyword'])){
    $listUsers = $user->search($filterAll['keyword'], $from_record_num, $records_per_page);
    $total_rows=$user->countAll($filterAll['keyword']);
} else {
    $listUsers = $user->readAll($from_record_num, $records_per_page);
    $total_rows=$user->countAll();
}
  
// specify the page where paging is used
$page_url = "?module=users&action=index&";
  


include_once "list.php";

layouts('footer_page');

?>