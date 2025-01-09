<?php
include "config/init.php";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $errors = [];
    $new_comment = htmlspecialchars($_POST['comment']);
    $comment_id = $_POST['comment_id'];
    $post_id = $_POST['post_id'];
    $current_timestamp =  date('Y-m-d H:i:s', time());
    if (empty($new_comment)) {
        $errors['comment'] = "لا يمكن ترك الحقل فارغ";
    }

    // check if empty errors then update
    if (empty($errors)) {
        $comment_update_query = "UPDATE `comments` SET `comment` = '$new_comment',
        `created_at` = '$current_timestamp' WHERE `comment_id` = '$comment_id'";
        $result = mysqli_query($conn, $comment_update_query);
        if ($result) {
            $_SESSION['comment_success'] = "تم تعديل تعليقك بنجاح";
            header('location:' . ROOT . '/post.php?id='.$post_id);
        }
    } else {
        $_SESSION['comment_error'] = $errors['comment'];
        header('location:' . ROOT . '/edit_comment.php?id='.$comment_id);
    }
} else {
    header('location:' . ROOT . '/community.php');
}