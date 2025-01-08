<?php
include "config/init.php";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $errors = [];
    $new_post = htmlspecialchars($_POST['post']);
    $post_id = $_POST['post_id'];
    $current_timestamp =  date('Y-m-d H:i:s', time());
    if (empty($new_post)) {
        $errors['post'] = "لا يمكن ترك الحقل فارغ";
    }

    // check if empty errors then update
    if (empty($errors)) {
        $post_update_query = "UPDATE `posts` SET `post_content` = '$new_post',
        `created_at` = '$current_timestamp' WHERE `id` = '$post_id'";
        $result = mysqli_query($conn, $post_update_query);
        if ($result) {
            $_SESSION['post_success'] = "تم تعديل منشورك بنجاح";
            header('location:' . ROOT . '/community.php');
        }
    } else {
        $_SESSION['post_error'] = $errors['post'];
        header('location:' . ROOT . '/post_edit.php');
    }
} else {
    header('location:' . ROOT . '/community.php');
}
