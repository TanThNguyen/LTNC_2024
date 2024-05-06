<?php
if (!defined('_CODE')) {
    die('Access denied ...');
}


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function layouts($layoutName='header',$data =[]){
    if(file_exists(_WEB_PATH_TEMPLATES.'/layout/'.$layoutName.'.php'))
    {
        require_once(_WEB_PATH_TEMPLATES.'/layout/'.$layoutName.'.php');
    }
}

function include_Object($objectName='index'){
    if(file_exists(_WEB_PATH_OBJECTS.'/'.$objectName.'.php'))
    {
        require_once(_WEB_PATH_OBJECTS.'/'.$objectName.'.php');
    }
}


function sendMail($to, $subject, $content) {




//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = '0no0name1@gmail.com';                     //SMTP username
    $mail->Password   = 'qxlb iawe zdhp haed';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('0no0name1@gmail.com', 'Mailer');
    $mail->addAddress($to);     //Add a recipient


    //Content
    $mail -> CharSet = "UTF-8";
    $mail->isHTML(true);                                  //Set email format to HTML

    $mail->Subject = $subject;
    $mail->Body    = $content;

    $sendM = $mail->send();
    if($sendM){
        return $sendM;
    }
    //echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
}


//Kiểm tra phương thức
function isGet() {
    if ($_SERVER['REQUEST_METHOD']=='GET') {
        return true;
    }
    return false;
}

function isPost() {
    if ($_SERVER['REQUEST_METHOD']=='POST') {
        return true;
    }
    return false;
}

//Hàm Filter lọc dữ liệu
function filter() {
    $filterArr=[];
    if (isGet()) {
        if (!empty($_GET)) {
            foreach ($_GET as $key => $value) {
                $key = strip_tags($key);
                if(is_array($value)){
                    $filterArr[$key] = filter_input(INPUT_GET,$key,FILTER_SANITIZE_FULL_SPECIAL_CHARS,FILTER_REQUIRE_ARRAY);
                }else {
                    $filterArr[$key] = filter_input(INPUT_GET,$key,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                }
                
            }
        }
    }

    if (isPost()) {
        if (!empty($_POST)) {
            foreach ($_POST as $key => $value) {
                $key = strip_tags($key);
                if(is_array($value)){
                    $filterArr[$key] = filter_input(INPUT_POST,$key,FILTER_SANITIZE_FULL_SPECIAL_CHARS,FILTER_REQUIRE_ARRAY);
                }else {
                    $filterArr[$key] = filter_input(INPUT_POST,$key,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                }
            }
        }
    }

    return $filterArr;
}




function isInt($number) {
    return filter_var($number,FILTER_VALIDATE_INT);
}

function isFloat($number) {
    return filter_var($number,FILTER_VALIDATE_FLOAT);
}


//Kiểm tra phone number
function isPhone($phone) {
    $subphone = substr($phone,1);
    return $phone[0]=='0' && isInt($subphone) && strlen($subphone) == 9;
}

//Kiểm tra CCCD
function isCCCD($CCCD) {
    return strlen($CCCD) == 12;
}

//Thông báo
function getMsg($msg, $type='success') {      
    echo '<div class = "alert alert-'.$type.'">';
    echo $msg;
    echo '</div>'; 
}

//Hàm thông báo lỗi
function form_error($name, $beforeHtml='', $afterHtml='', $errors) {
    return (!empty($errors[$name])) ? $beforeHtml.reset($errors[$name]).$afterHtml : null;
}

//Hàm chuyển hướng
function redirect($path='index.php') {
    $path = _WEB_HOST.$path;
    header("Location: $path");
    exit;
}

//Hiển thị dữ liệu cũ
function old_data($name, $old, $default=null) {
    return (!empty($old[$name])) ? $old[$name] : $default;
}

//Hàm kiểm tra trạng thái
function isLogin($db) {
    if (getSession('loginToken')) {
        $tokenLogin = getSession('loginToken');
        $query = $db->oneRow("SELECT user_id FROM tokenlogin WHERE token = '$tokenLogin';");
        if (!empty($query)) {
            return true;
        } else {
            removeSession('loginToken');
        }
    }
    return false;
}



