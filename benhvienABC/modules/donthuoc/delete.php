<?php
if (!defined('_CODE')) {
    die('Access denied ...');
}

include_Object('donthuoc');
$database = new Database();
$db = $database->getConnection();

if (!isLogin($database)){
    redirect('?module=auth&action=login');
}

$donthuoc = new donthuoc($database);

$filterAll = filter();
$query = null;

if (!empty($filterAll['id'])) {
    $donthuoc->setId($filterAll['id']);    
    $query = $donthuoc->readOne();
    
    if (!empty($query)) {
        if ($donthuoc->delete()) {
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
redirect('?module=benhnhan&action=read_one&id='.$query['bn_id']);
