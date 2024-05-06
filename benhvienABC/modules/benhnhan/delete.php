<?php
if (!defined('_CODE')) {
    die('Access denied ...');
}

include_Object('benhnhan');
$database = new Database();
$db = $database->getConnection();

if (!isLogin($database)){
    redirect('?module=auth&action=login');
}

$benhnhan = new benhnhan($database);

$filterAll = filter();

if (!empty($filterAll['id'])) {
    $benhnhan->setId($filterAll['id']);    
    $query = $benhnhan->readOne();
    
    if (!empty($query)) {
        if ($benhnhan->delete()) {
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
redirect('?module=benhnhan&action=index');
