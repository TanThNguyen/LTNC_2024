<?php
if (!defined('_CODE')) {
    die('Access denied ...');
}

$data = [
    'pageTitle' => 'Xác thực tài khoản'
];
layouts('header', $data);

$database = new Database();
$database->getConnection();

$token = filter()['token'];


if (!empty($token)) {
    $query = $database->oneRow("SELECT id FROM users WHERE activeToken='$token';");

    if (!empty($query)) {
        $userId = $query['id'];
        $dataUpd = [
            'activeToken' => null,
            'status' => 1
        ];
        $updStatus = $database->update('users', $dataUpd, "id=$userId");
        if ($updStatus) {
            setFlashData('msg', 'Xác thực thành công');
            setFlashData('type', 'success');
            
        } else {
            setFlashData('msg', 'Kích hoạt thất bại, vui lòng liên hệ quản trị viên.');
            setFlashData('type', 'danger');
        }
    } else {
        getMsg('Liên kết không tồn tại hoặc đã hết hạn.', 'danger');
    }
} else {
    getMsg('Liên kết không tồn tại hoặc đã hết hạn.', 'danger');
}
redirect('?module=auth&action=login');
