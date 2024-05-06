<?php
if (!defined('_CODE')) {
    die('Access denied ...');
}

$dataTitle = [
    'pageTitle'=>'Đăng ký tài khoản'
];

layouts('header',$dataTitle);

$database = new Database();
$database->getConnection();
//Kiểm tra trạng thái đăng nhập
if (isLogin($database)) {
    redirect('?module=home&action=dashboard');
}

if (isPost()) {
    $filterAll = filter();
    $errors = [];           //Mảng chứa lỗi

    //Validate fullname: bắt buộc phải nhập và >5 ký tự
    if (empty($filterAll['fullname'])) {        
        $errors['fullname']['required']='Họ tên bắt buộc phải nhập.';
    }
    
    //Validate email: Bắt buộc phải nhập, đúng định dạng email, kiểm tra email đã tồn tại hay chưa
    if (empty($filterAll['email'])) {        
        $errors['email']['required']='Email bắt buộc phải nhập.';
    }else {
        $email = $filterAll['email'];
        $sql = "SELECT id FROM users WHERE email = '$email';";
        if ($database->countRow($sql)>0) {
            $errors['email']['unique']='Email đã tồn tại.';
        }
    }

    //Validate phone: Bắt buộc phải nhập, kiểm tra định dạng
    if (empty($filterAll['phone'])) {        
        $errors['phone']['required']='Số điện thoại bắt buộc phải nhập.';
    }else {
        if (!isPhone($filterAll['phone'])){
            $errors['phone']['isPhone']='Số điện thoại không hợp lệ.';
        }   
    }

    //Validate password: Bắt buộc phải nhập, số ký tự >=8
    if (empty($filterAll['password'])) {        
        $errors['password']['required']='Mật khẩu bắt buộc phải nhập.';
    }else {
        if (strlen($filterAll['password']) < 8){
            $errors['password']['min']='Mật khẩu phải có ít nhất 8 ký tự.';
        }   
    }

    //Validate password-confirm: Bắt buộc phải nhập, giống password
    if (empty($filterAll['password_confirm'])) {        
        $errors['password_confirm']['required']='Bạn bắt buộc phải nhập lại mật khẩu.';
    }else {
        if ($filterAll['password_confirm'] != $filterAll['password']){
            $errors['password_confirm']['match']='Sai mật khẩu.';
        }   
    }


    if(empty($errors)) {
        $activeToken = sha1(uniqid().time());
        $dataIns = [
            'fullname' => $filterAll['fullname'],
            'email' => $filterAll['email'],
            'phone' => $filterAll['phone'],
            'password' => password_hash($filterAll['password'], PASSWORD_DEFAULT),
            'activeToken' => $activeToken,
            'create_at' => date('Y-m-d H:i:s'),
            'update_at' => date('Y-m-d H:i:s')
        ];
        $insStatus = $database->insert('users',$dataIns);
        if ($insStatus) {
            
            $linkActive = _WEB_HOST.'?module=auth&action=active&token='.$activeToken;
            $subject = $filterAll['fullname'].', Vui lòng kích hoạt tài khoản';
            $content = 'Xin chào '.$filterAll['fullname'].', <br>';
            $content .= 'Vui lòng click vào link dưới đây để kích hoạt tài khoản:<br>';
            $content .= $linkActive.'<br> Trân trọng cảm ơn';

            $sendM = sendMail($filterAll['email'],$subject,$content);
 
            if($sendM){
                setFlashData('msg','Đăng ký thàng công, vui lòng kiểm tra email để kích hoạt tài khoản');
                setFlashData('type','success');
                redirect('?module=auth&action=login');
            } else {
                setFlashData('msg','Hệ thống đang gặp sự cố, vui lòng thử lại sau.');
                setFlashData('type','danger');
            }
        } else{
            setFlashData('msg','Đăng ký thất bại.');
            setFlashData('type','danger');
        }

        redirect('?module=auth&action=register');
    }else {
        setFlashData('msg','Vui lòng kiểm tra lại dữ liệu.');
        setFlashData('type','danger');
        setFlashData('errors',$errors);
        setFlashData('old',$filterAll);
        redirect('?module=auth&action=register');
    }
}
$errors = getFlashData('errors');
$old = getFlashData('old');

?>




    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap');
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins',sans-serif;
        }
        body{
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #dfdfdf;
        }
        .login-box{
            display: flex;
            justify-content: center;
            flex-direction: column;
            width: 440px;
            height: 480px;
            padding: 30px;
        }
        .login-header{
            text-align: center;
            margin: 20px 0 40px 0;
        }
        .login-header header{
            color: #333;
            font-size: 30px;
            font-weight: 600;
        }
        .input-box .input-field{
            width: 100%;
            height: 60px;
            font-size: 17px;
            padding: 0 25px;
            margin-bottom: 15px;
            border-radius: 30px;
            border: none;
            box-shadow: 0px 5px 10px 1px rgba(0,0,0, 0.05);
            outline: none;
            transition: .3s;
        }
        ::placeholder{
            font-weight: 500;
            color: #222;
        }
        .input-field:focus{
            width: 105%;
        }
        .forgot{
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
        }
        section{
            display: flex;
            align-items: center;
            font-size: 14px;
            color: #555;
        }
        #check{
            margin-right: 10px;
        }
        a{
            text-decoration: none;
        }
        a:hover{
            text-decoration: underline;
        }
        section a{
            color: #555;
        }
        .input-submit{
            position: relative;
        }
        .submit-btn{
            width: 100%;
            height: 60px;
            background: #222;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            transition: .3s;
        }
        .input-submit label{
            position: absolute;
            top: 45%;
            left: 50%;
            color: #fff;
            -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
            cursor: pointer;
        }
        .submit-btn:hover{
            background: #000;
            transform: scale(1.05,1);
        }
        .sign-up-link{
            text-align: center;
            font-size: 15px;
            margin-top: 20px;
        }
        .sign-up-link a{
            color: #000;
            font-weight: 600;
        }
    </style>
    <div class="login-box">
        <div class="login-header">
            <header>REGISTER</header>
            <?php
                $msg = getFlashData('msg');
                $type = getFlashData('type');
                if(!empty($msg)){
                    getMsg($msg,$type);
                }
            ?>
        </div>
        <form action="" method="post"> 
            <div class="input-box">
                <label for="">Họ và tên</label>
                <input name ="fullname" type="fullname" class="input-field"  autocomplete="off" required placeholder="Họ và tên" value="<?php echo old_data('fullname',$old); ?>">
                <?php
                echo form_error("fullname", '<span class= "error" >', '</span>', $errors);
                ?>
            </div>
            <div class="input-box">
                <label for="">Email</label>
                <input name = "email" type="email" class="input-field"  autocomplete="off" required placeholder="Địa chỉ email" value="<?php echo old_data('email',$old); ?>">
                <?php
                echo form_error("email", '<span class= "error" >', '</span>', $errors);
                ?>
            </div>
            <div class="input-box">
                <label for="">Số điện thoại</label>
                <input name = "phone" type="phone" class="input-field"  autocomplete="off" required placeholder="Số điện thoại" value="<?php echo old_data('phone',$old); ?>">
                <?php
                echo form_error("phone", '<span class= "error" >', '</span>', $errors);
                ?>
            </div>
            <div class="input-box">
                <label for="">Password</label>
                <input name = "password" type="password" class="input-field"  autocomplete="off" required placeholder="Mật khẩu">
                <?php
                echo form_error("password", '<span class= "error" >', '</span>', $errors);
                ?>
            </div>

            <div class="input-box">
                <label for="">Nhập lại mật khẩu</label>
                <input name = "password_confirm" type="password" class="input-field"  autocomplete="off" required placeholder="Nhập lại mật khẩu">
                <?php
                echo form_error("password_confirm", '<span class= "error" >', '</span>', $errors);
                ?>
            </div>

            <div class="forgot">
            </div>
            <div class="input-submit">
                <button type="submit" class="submit-btn" id="submit"></button>
                <label for="submit">Create Now</label>
            </div>
            <div class="sign-up-link">
                <p>Have an Account? <a href="?module=auth&action=login">Sign In</a></p>
            </div>
        </form>


        
    </div>

<?php
layouts('footer');
?>