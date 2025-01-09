<?php
include 'config/init.php';
$comment_id = $_GET['id'];
/**
 * this query for getting the post id to pass it in the url
 * so when it gets back to the post page it doesn't give an error
 */
$db_comment_query = "SELECT * FROM `comments` WHERE `comment_id` = $comment_id";
$comment_result = mysqli_query($conn, $db_comment_query);
$comment_data = mysqli_fetch_assoc($comment_result);
$post_id = $comment_data['post_id'];


$comment_delete_query = "DELETE FROM `comments` WHERE `comment_id` = '$comment_id'";
$result = mysqli_query($conn, $comment_delete_query);
if ($result) {

    $_SESSION['comment_success'] = "تم حذف تعلقيك بنجاح";
    header('location:' . ROOT . '/post.php?id=' . $post_id);
}
