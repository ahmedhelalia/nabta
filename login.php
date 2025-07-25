<?php
require_once 'config/init.php';

?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nabta</title>
    <!-- Custom StyleSheet-->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- ICONSCOUNT CDN -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <!-- Google Font (MONTSERRAT)-->

    
</head>
<body>
<section class="form_section">
    <div class="container form_section_container">
        <h2 class="form_h2_login"> تسجيل الدخول</h2>
        <?php if (isset($_SESSION['user_login_errors'])): ?>
        <div class="alert_message error">
            <p><?php
            $errors = $_SESSION['user_login_errors'];
            if(!empty($errors)){
                foreach($errors as $error){
                    echo $error . "<br>";
                }
            }
            unset($_SESSION['user_login_errors']);
            unset($errors);
            ?>
            </p>
        </div>
        <?php endif;?>
        <form action="loginAuth.php" enctype="multipart/form-data" method="post">
      
            <input type="text" name="email"  placeholder="الحساب الالكتروني" >
            <input type="password" name="password"  placeholder="كلمة السر" >
            
            <button type="submit" name="submit" class="btn form-btn"> الدخول </button>
            <div class="end_form">
            <small> ليس لديك حساب؟ <a href="signup.php" style="color:white">انشاء حساب</a> <a href="index.php" style="color:white">الرئيسية</a></small>
            </div>
        </form>
    </div>
</section>
<script src="js/main.js"></script>
</body>
</html>