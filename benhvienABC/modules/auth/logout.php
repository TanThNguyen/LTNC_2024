<?php
if (!defined('_CODE')) {
    die('Access denied ...');
}
$data = [
    'pageTitle'=>''
];
layouts('header_page',$data);

$database = new Database();
$database->getConnection();

if (isLogin($database)) {
    $token = getSession('loginToken');
    $database->delete('tokenlogin',"token='$token'");
    removeSession('loginToken');
    redirect('?module=auth&action=login');
}

?>

<?php
layouts('footer_page');
?>