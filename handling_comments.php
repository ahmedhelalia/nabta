<?php
include 'config/init.php';
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $errors = [];
    $comment = filter_var($_POST['comment'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $post_id = filter_var($_POST['post_id'], FILTER_SANITIZE_NUMBER_INT);
    $user_id = filter_var($_POST['user_id'], FILTER_SANITIZE_NUMBER_INT);
    if (empty($comment)) {
        $errors['comment'] = "برجاء كتابة تعليق لنشره";
    }
    if (empty($errors)) {
        $comment_query = "INSERT INTO `comments`(`comment`,`post_id`,`user_id`) 
        VALUES('$comment','$post_id','$user_id')";
        $result = mysqli_query($conn, $comment_query);
        if ($result) {
            $_SESSION['comment_success'] = "تم كتبابة تعليقك بنجاح";
            show($post_id);
            header("location:" . ROOT . "/post.php?id=" . $post_id);
        } else {
            echo "Something went wrong";
        }
    } else {
        $_SESSION['comment_error'] = $errors['comment'];
        // show($post_id);
        // show($_SESSION);
        header('location:' . ROOT . '/post.php?id=' . $post_id);
    }
}
