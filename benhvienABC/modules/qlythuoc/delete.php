<?php
if (!defined('_CODE')) {
    die('Access denied ...');
}

include_Object('thuoc');
$database = new Database();
$db = $database->getConnection();

if (!isLogin($database)){
    redirect('?module=auth&action=login');
}

$thuoc = new thuoc($database);

$filterAll = filter();

if (!empty($filterAll['id'])) {
    $thuoc->setId($filterAll['id']);    
    $query = $thuoc->readOne();
    
    if (!empty($query)) {
        if ($thuoc->delete()) {
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
} else {
    setFlashData('msg', 'Liên kết không tồn tại');
    setFlashData('type', 'danger');
}
redirect('?module=qlythuoc&action=index');
