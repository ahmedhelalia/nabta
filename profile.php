<?php
require 'config/init.php';
// check if user logged in from session
if(isset($_SESSION['USER'])){
    $id = $_SESSION['USER']['user_id'];
    // get current user data from data base
    $query = "SELECT * FROM `users` WHERE `id` = '$id'";
    $result = mysqli_query($conn,$query);
    $info = mysqli_fetch_assoc($result);
    $avatar = $info['user_avatar'];
    $user_name = $info['first_name']." ".$info['last_name'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/style.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">

    <title>Profile</title>
</head>

<body>
    <div class="container">
    <div class="profile_container">
        <div class="profile_avatar">
            <img src="assets/images/<?= $avatar ?>" alt="">
        </div>
        <h1 style="margin-left:33%;"><?= $user_name ?></h1>
        <div class="profile_socials">
            <a href="#"><i class="uil uil-facebook-f"></i></a>
            <a href="#"><i class="uil uil-instagram-alt"></i></a>
            <a href="#"><i class="uil uil-twitter"></i></a>
        </div>

        <div class="profile_buttons">
            <a href="profileSettings.php">
                <button class="btn">
                    التعديل
                </button>
            </a>
            <a href="logout.php">
            <button class="btn">
                 تسجيل الخروج 
            </button>
            </a>
            <a href="index.php">
            <button class="btn">
                الصفحة الرئيسية
            </button>
            </a>
        </div>


    </div>




    </div>
    </div>
    <br><br>

</body>

</html>