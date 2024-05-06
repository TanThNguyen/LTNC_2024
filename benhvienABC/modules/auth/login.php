<?php
if (!defined('_CODE')) {
    die('Access denied ...');
}
$data = [
    'pageTitle'=>'Đăng nhập tài khoản'
];
layouts('header',$data);

$database = new Database();
$database->getConnection();
//Kiểm tra trạng thái đăng nhập
if (isLogin($database)) {
    redirect('?module=home&action=dashboard');
}

//Kiểm tra thông tin đăng nhập
if (isPost()) {
    $filterAll = filter();
    if (!empty(trim($filterAll['email'])) && !empty(trim($filterAll['password']))) {
        $email = $filterAll['email'];
        $password = $filterAll['password'];
        $query = $database->oneRow("SELECT password, id, status FROM users WHERE email = '$email';");
        if((!empty($query)) && ($query['status'] == 1)){
            $passwordHash = $query['password'];
            if (password_verify($password, $passwordHash)) {
                // Tạo token login
                $tokenLogin = sha1(uniqid().time());
                $dataIns = [
                    'user_id' => $query['id'],
                    'token' => $tokenLogin,
                    'create_at' => date('Y-m-d H:i:s')
                ];
                $insStatus = $database->insert('tokenlogin',$dataIns);
                if ($insStatus) {
                    setSession('loginToken', $tokenLogin);
                    redirect('?module=home&action=dashboard');
                } else {
                    setFlashData('msg','Không thể đăng nhập, vui lòng thử lại sau.');
                    setFlashData('type','danger');
                }    
            } else {
                setFlashData('msg','Mật khẩu không chính xác.');
                setFlashData('type','danger');
                setFlashData('old',$filterAll);
            }
        }else {
            setFlashData('msg','Email không tồn tại hoặc chưa kích hoạt. Vui lòng đăng ký hoặc kích hoạt trước.');
            setFlashData('type','danger');
            setFlashData('old',$filterAll);
        }

    }else {
        setFlashData('msg','Vui lòng kiểm tra lại dữ liệu.');
        setFlashData('type','danger');
        if (!empty(trim($filterAll['email']))){
            setFlashData('old',$filterAll);
        }
    }
    redirect('?module=auth&action=login');
}

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
            <header>Login</header>
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
                <input type="text" class="input-field" placeholder="Email" autocomplete="off" required name = "email" value="<?php echo old_data('email',$old); ?>">
            </div>
            <div class="input-box">
                <input type="password" class="input-field" placeholder="Password" autocomplete="off" required name = 'password'>
            </div>
            <div class="forgot">
                <section>
                    <input type="checkbox" id="check">
                    <label for="check">Remember me</label>
                </section>
                <section>
                    <a href="?module=auth&action=forgot">Forgot password</a>
                </section>
            </div>
            <div class="input-submit">
                <button type="submit" class="submit-btn" id="submit"></button>
                <label for="submit">Sign In</label>
            </div>
            <div class="sign-up-link">
                <p>Don't have account? <a href="?module=auth&action=register">Sign Up</a></p>
            </div>
        </form>
</div>

<?php
layouts('footer');
?>