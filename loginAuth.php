<?php
include 'config/init.php';
if (isset($_POST['submit'])) {
    $email    = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $errors = array();
    if (!$email || empty($email)) {
        $errors['email'] = "من فضلك ادخل حساب الكتروني صالح";
    } elseif (empty($password)) {
        $errors['password'] = "كلمة المرور لا يمكن ان تكون فارغة";
    } elseif (strlen($password) < 8) {
        $errors['password'] = "كلمة المرور يجب ان تكون 8 حروف او اكثر";
    } else {
        // Fetch User from database
        $fetch_user_query = "SELECT * FROM `users` WHERE `email` = '$email'";
        $fetch_user_result = mysqli_query($conn, $fetch_user_query);
        if (mysqli_num_rows($fetch_user_result) == 1) {
            // Convert user record into associative array
            $user_record = mysqli_fetch_assoc($fetch_user_result);
            $db_password = $user_record['PASSWORD'];
            // Compare form password with hashed password from data base
            if (password_verify($password, $db_password)) {
                // Set session for access control
                $_SESSION['USER']['user_id'] = $user_record['id'];
                // Set Session if user is admin or expert
                if ($user_record['user_role'] == 'admin') {
                    $_SESSION['USER']['user_is_admin'] = true;
                } elseif ($user_record['user_role'] == 'expert') {
                    $_SESSION['USER']['user_is_expert'] = true;
                }
            } else {
                $errors['login'] = "من فضلك التأكد من كلمة السر او الحساب الالكتروني";
            }
        } else {
            $errors['login'] = "الحساب الذي ادخلته غير متوفر";
        }
    }
    if (empty($errors)) {
        // Log the user in
        header('location:' . ROOT . '/index.php');
        die();
    } else {
        $_SESSION['user_login_errors'] = $errors;
        header('location:'.ROOT.'/login.php');
    }
    

} else {
    header('location:' . ROOT . '/login.php');
    die();
}
