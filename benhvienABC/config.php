<?php

//Check module
const _CODE = true;
const _MODULE ='auth';
const _ACTION ='login';

//Thông tin kết nối
const _HOST = 'sql203.infinityfree.com';
const _DB   = 'if0_36322954_project';
const _USER = 'if0_36322954';
const _PASS = 'Hoctap';

//Thiết lập host
define('_WEB_HOST','http://'.$_SERVER['HTTP_HOST'].'/benhvienABC/');
define('_WEB_HOST_TEMPLATES',_WEB_HOST.'/templates');
define('_WEB_HOST_OBJECTS',_WEB_HOST.'/objects');



//Thiết lập path
define('_WEB_PATH',__DIR__);
define('_WEB_PATH_TEMPLATES',_WEB_PATH.'/templates');
define('_WEB_PATH_OBJECTS',_WEB_PATH.'/objects');


//Thiết lập thời gian
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>