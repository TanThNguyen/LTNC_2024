<?php
if (!defined('_CODE')) {
    die('Access denied ...');
}

include_Object('benhan');
$database = new Database();
$db = $database->getConnection();

if (!isLogin($database)){
    redirect('?module=auth&action=login');
}

$benhan = new benhan($database);

$filterAll = filter();

if (!empty($filterAll['id'])) {
    $benhan->setId($filterAll['id']);    
    $query = $benhan->readOne();
    
    if (!empty($query)) {
        if ($benhan->delete()) {
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
redirect('?module=benhnhan&action=read_one&id='.$filterAll['bn_id']);
