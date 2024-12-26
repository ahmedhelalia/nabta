<?php 
include 'config/init.php';
// Get signup form data if submit button is clicked
if(isset($_POST['submit'])){
    $first_name      = filter_var($_POST['first_name'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $last_name       = filter_var($_POST['last_name'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email           = filter_var($_POST['email'],FILTER_VALIDATE_EMAIL);
    $password        = filter_var($_POST['password'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmPassword = filter_var($_POST['confirm_password'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $user_role       = $_POST['user_role'];
    $avatar          = $_FILES['avatar'];
    $errors          = [];
    // Validate input values
    if(empty($first_name)){
        $errors['first_name'] = "من فضلك ادخل الاسم الاول ";
    }elseif(empty($last_name)){
        $errors['last_name']  = "من فضلك ادخل الاسم الاخير";
    }elseif(!$email){
        $errors['email']      = "من فضلك ادخل حساب الكتروني صالح";
    }elseif(strlen($password)<8){
        $errors['password'] = "كلمه السر يجب ان تكون 8 او اكثر";
    }elseif($confirmPassword !== $password){
        $errors['confirmPassword'] = "كلمة السر غير متطابقة";
    }elseif(empty($user_role) || $user_role == 0){
        $errors['user_role'] = "please enter a user role";
    }elseif(!$avatar['name']){
        $errors['avatar'] = "من فضلك قم بادخال صورة شخصية";
    }
    else{
        $hashedPassword = password_hash($password,PASSWORD_DEFAULT);
        // Check if the email already in the data base
        $user_check_query = "SELECT * FROM `users` WHERE email = '$email' ";
        $user_query       = mysqli_query($conn,$user_check_query);
        if(mysqli_num_rows($user_query)>0){
            $errors['email'] = "الحساب موجود بالفعل";
        }else{
            // work on user avatar
            // Rename avatar
            $time = time();
            $avatar_name = $time.$avatar['name'];
            $avatar_tmp_name = $avatar['tmp_name'];
            $avatar_destination_path = 'assets/images/'.$avatar_name;
            // make sure the file is an image
            $allowedFiles = ['png','jpg','jpeg'];
            $extension = explode('.',$avatar_name);
            show($extension);
            $extension = end($extension);
            show($extension);
            // Check if in Allowed files
            if (in_array($extension,$allowedFiles)){
                // make Sure image is not too large
                if ($avatar['size']<1000000){
                    // Upload Avatar
                    move_uploaded_file($avatar_tmp_name,$avatar_destination_path);
                }else{
                   $errors['avatar'] = "حجم الملف يجب ان يكون اقل من 1 ميجا بايت";
                }
            }else{
                   $errors['avatar'] = "File Should be png or jpg or jpeg";
            }
        }
    }
    // Redirect back to signup if there is an error
    if(!empty($errors)){
        // return back the form data
        $_SESSION['signup_data'] = $_POST;
        $_SESSION['signup_data_errors'] = $errors;
        header('location:'.ROOT.'/signup.php');
        die();
    }else{
        // Insert into data base
        $query = "INSERT INTO `users`(`first_name`,`last_name`,`email`,`user_role`,`password`,`user_avatar`)
        VALUES('$first_name','$last_name','$email','$user_role','$hashedPassword','$avatar_name')
        ";
        $result = mysqli_query($conn,$query);
        if($result){
            $_SESSION['signup_success'] = "تم التسجيل بنجاح";
            header('location:'.ROOT.'/login.php');
            die();
        }
    }
}else{
    // if button wasn't clicked redirect back to signup page
    header('location:'.ROOT.'/signup.php');
    die();
}