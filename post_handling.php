<?php
include 'config/init.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];
    if(!isset($_SESSION['USER'])){
        $errors['post'] = "برجاء تسجيل الدخول حتي تتمكن من النشر";
    }
    $post   = htmlspecialchars($_POST['post']);
    $current_user_id = filter_var($_POST['current_user'],FILTER_SANITIZE_NUMBER_INT);
   
    if (empty($post)) {
        $errors['post'] = "برجاء كتابة شيء لنشره";
    }
    // check if empty errors then insert the post into the data base
    if (empty($errors)) {
        $query = "INSERT INTO `posts`(`post_content`,`user_id`) VALUES('$post','$current_user_id')";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $_SESSION['post_success'] = "تم اضافة منشورك بنجاح";
            header('location:' . ROOT . '/community.php');
        }
    } else {
        $_SESSION['post_error'] = $errors['post'];
        header('location:' . ROOT . '/community.php');
    }
} else {
    header('location:' . ROOT . '/community.php');
}
