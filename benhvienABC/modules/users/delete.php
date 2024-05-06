<?php
if (!defined('_CODE')) {
    die('Access denied ...');
}

include_Object('user');
$database = new Database();
$db = $database->getConnection();

if (!isLogin($database)){
    redirect('?module=auth&action=login');
}

$user = new User($database);

$filterAll = filter();

if (!empty($filterAll['id'])) {
    $user->setId($filterAll['id']);    
    $query = $user->readOne();
    
    if (!empty($query)) {
        //Xóa ở bảng token login
        $confirm = $database->delete('tokenlogin', "user_id='$user->getId()'");
        if ($confirm) {
            //Xóa user
            if ($user->delete()) {
                setFlashData('msg', 'Xóa thành công.');
                setFlashData('type', 'success');
            } else {
                setFlashData('msg', 'Lỗi hệ thống.');
                setFlashData('type', 'danger');
            }
        } else {
            setFlashData('msg', 'Lỗi hệ thống.');
            setFlashData('type', 'danger');
        }
    }
} else {
    setFlashData('msg', 'Liên kết không tồn tại');
    setFlashData('type', 'danger');
}
redirect('?module=users&action=index');
