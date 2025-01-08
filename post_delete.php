<?php
include 'config/init.php';
$post_id = $_GET['id'];
$post_delete_query = "DELETE FROM `posts` WHERE `id` = '$post_id'";
$result = mysqli_query($conn, $post_delete_query);

if ($result) {
    $_SESSION['post_success'] = "تم حذف منشورك بنجاح";
    header('location:' . ROOT . '/community.php');
}
