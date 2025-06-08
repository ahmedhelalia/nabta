<?php
require 'config/init.php';
// check if user logged in from session
if (isset($_SESSION['USER'])) {
    $id = $_SESSION['USER']['user_id'];
    // get current user avatar_name from data base
    $query = "SELECT * FROM `users` WHERE `id` = '$id'";
    $result = mysqli_query($conn, $query);
    $user_data = mysqli_fetch_assoc($result);
    $user_avatar = $user_data['user_avatar'];
    $user_expert = $user_data['user_role'];
    $isAdmin = $user_data['isAdmin'];
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
    <!-- FONT-AWESOME ICONS !-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Nabta</title>
</head>

<body>
    <!-- Start Of Nav Bar -->
    <nav>
        <div class="nav_container">
            <a href="index.php" class="nav_logo">
                <img src="<?= ROOT ?>/assets/images/nabta-logo.png" alt="Nabta Logo">
            </a>
            <button class="mobile-nav-toggle" aria-controls="nav_items" aria-expanded="false">
                <i class="uil uil-bars"></i>
                <span class="visually-hidden">القائمة</span>
            </button>
            <ul class="nav_items">
                
                <li><a href="index.php">الرئيسية</a></li>
                <li><a href="community.php">المنتدى</a></li>
                <li><a href="articles.php">مقالات متنوعة</a></li>
                <li><a href="courses.php">البرامج والدورات</a></li>
                <li><a href="contact.php">تواصل معنا</a></li>

            </ul>
            <?php if (isset($_SESSION['USER'])): ?>
                <li  class="nav_profile">
                    <div class="avatar">
                        <img src="<?= ROOT ?>/assets/images/<?= $user_avatar ?>" alt="broken">
                    </div>
                    <ul>
                        <li><a href="profile.php">الاعدادات</a></li>
                        <?php if ($isAdmin || $user_expert === 'expert'): ?>
                            <li><a href="dashboard.php" style="white-space: nowrap;">لوحة التحكم </a></li>
                        <?php endif; ?>
                        <li><a href="logout.php">الخروج</a></li>
                    </ul>
                </li>
            <?php else: ?>
                <li class="nav-responsive-li" style="margin-right: 90px;"><a href="signup.php">تسجيل</a></li>
            <?php endif; ?>
        </div>
    </nav>