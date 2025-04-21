<?php
require_once 'config/init.php';
/// get back form data if there was a registration error
$first_name = $_SESSION['signup_data']['first_name'] ?? null;
$last_name = $_SESSION['signup_data']['last_name']?? null;
$username = $_SESSION['signup_data']['username']?? null;
$email = $_SESSION['signup_data']['email']?? null;
$password = $_SESSION['signup_data']['password'] ?? null;
$confirmPassword = $_SESSION['signup_data']['confirm_password']?? null;
// Unset Session signup-data
unset($_SESSION['signup_data']);
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
        <h2 class="form_h2"> سجل الان</h2>
       
        <?php if (isset($_SESSION['signup_data_errors'])): ?>
        <div class="alert_message error">
            <p><?php
            $errors = $_SESSION['signup_data_errors'];
            if(!empty($errors)){
                foreach($errors as $error){
                    echo $error . "<br>";
                }
            }
            unset($_SESSION['signup_data_errors']);
            unset($errors);
            ?>
            </p>
        </div>
        <?php endif;?>
        <form action="<?= ROOT ?>/signupValidate.php" enctype="multipart/form-data" method="post">
            <input type="text" name="first_name"  placeholder="الاسم الاول" value="<?= $first_name ?>">
            <input type="text" name="last_name"  placeholder="الاسم الاخير" value="<?= $last_name ?>">
            <input type="email" name="email"  placeholder="الحساب الالكتروني" value="<?= $email ?>" >
            <input type="password" name="password"  placeholder="كلمة السر" value="<?= $password ?>" >
            <input type="password" name="confirm_password"  placeholder=" تأكيد كلمة السر" value="<?= $confirmPassword ?>">
            <select name="user_role">
                <option value="0">choose role</option>
                <option value="normal_user">normal user</option>
                <option value="expert">expert</option>
            </select>
            <div class="form_control">
                <label for="avatar" class="form_pp">صورة الملف الشخصى</label>
                <input type="file" name="avatar" id="avatar" style="direction: rtl;">
            </div>
            <button type="submit" name="submit" class="btn"> تسجيل</button>
            <div class="end_form">
            <small> لديك حساب بالفعل؟ <a href="login.php" style="color:white"> تسجيل الدخول</a> <a href="index.php" style="color:white">الرئيسية</a></small>
            </div>
        </form>
    </div>
</section>
<script src="js/main.js"></script>
</body>
</html>