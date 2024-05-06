<?php
if (!defined('_CODE')) {
    die('Access denied ...');
}

include_Object('nhanvien');
$database = new Database();
$db = $database->getConnection();

if (!isLogin($database)){
    redirect('?module=auth&action=login');
}

$nhanvien = new Nhanvien($database);

$filterAll = filter();

if (!empty($filterAll['id'])) {
    $nhanvien->setId($filterAll['id']);    
    $query = $nhanvien->readOne();
    
    if (!empty($query)) {
        if ($nhanvien->delete()) {
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
redirect('?module=nhanvien&action=index');
