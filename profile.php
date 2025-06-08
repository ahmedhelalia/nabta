<?php include 'inc/header.php' ?>
<?php
//require 'config/init.php';
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

<div class="container" style="margin-top: 200px;">
    <div class="profile_container">
        <!-- Avatar -->
        <div class="profile_avatar">
            <img src="assets/images/<?= $avatar ?>" alt="<?= $user_name ?>">
        </div>
        
        <!-- User Name -->
        <h1><?= $user_name ?></h1>
        
        <!-- Social Links -->
        <div class="profile_socials">
            <a href="#" aria-label="Facebook"><i class="uil uil-facebook-f"></i></a>
            <a href="#" aria-label="Instagram"><i class="uil uil-instagram-alt"></i></a>
            <a href="#" aria-label="Twitter"><i class="uil uil-twitter"></i></a>
        </div>
        
        <!-- Action Buttons -->
        <div class="profile_buttons">
            <a href="profileSettings.php" class="btn">التعديل</a>
            <a href="logout.php" class="btn">تسجيل الخروج</a>
            <a href="index.php" class="btn">الصفحة الرئيسية</a>
        </div>
    </div>
</div>
<script src="assets/js/main.js"></script>
</body>

</html>