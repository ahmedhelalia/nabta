<?php 
require 'config/init.php';
// check if user logged in from session
if(isset($_SESSION['USER'])){
    $id = $_SESSION['USER']['user_id'];
    // get current user avatar_name from data base
    $query = "SELECT `user_avatar` FROM `users` WHERE `id` = '$id'";
    $result = mysqli_query($conn,$query);
    $user_avatar = mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Custom stylesheet -->
    <link rel="stylesheet" href="assets/css/style.css">
     <!-- ICONSCOUNT CDN -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <!-- BOOTSTRAP ICONS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    
    <title>Nabta</title>
</head>

<body>
    <!-- Start Of Nav Bar -->
    <nav>
        <div class="nav_container">
            <a href="index.php" class="nav_logo">Nabta</a>
            <ul class="nav_items">
                <li><a href="about.html">عنا</a></li>
                <li class="nav_categories">
                    <div class="sections">
                        الخدمات
                    </div>
                    <ul>
                        <li><a href="beforeMarriage.php">ما قبل الزواج</a></li>
                        <li><a href="afterMarriage.php">ما بعد الزواج</a></li>
                        <li><a href="childhood.php">مرحلة الطفولة</a></li>
                        <li><a href="teenage.php">مرحلة المراهقة</a></li>
                    </ul>
                </li>
                <li><a href="community.php">المنتدى</a></li>
               
                <li><a href="index.php">الرئيسية</a></li>
                <?php if(isset($_SESSION['USER'])): ?>
                    <li style="margin-right: 40px;" class="nav_profile">
                    <div class="avatar">
                        <img src="<?= ROOT ?>/assets/images/<?= $user_avatar['user_avatar'] ?>" alt="broken">
                    </div>
                    <ul>
                        <li><a href="profile.php">الاعدادات</a></li>
                        <li><a href="logout.php">الخروج</a></li>
                    </ul>
                </li>
                <?php else: ?>
                <li style="margin-right: 90px;"><a href="signup.php">تسجيل</a></li>
                <?php endif; ?>


            </ul>
        </div>
    </nav>