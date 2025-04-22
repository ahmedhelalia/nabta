<?php
include 'config/init.php';
if (isset($_GET['id'])) {
    $article_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $sql = "SELECT * FROM `articles` WHERE `article_id` = '$article_id' ";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $article = mysqli_fetch_assoc($result);
        $thumbnail_name = $article['thumbnail'];
        $thumbnail_path = 'assets/images/' . $thumbnail_name;
        if ($thumbnail_path) {
            unlink($thumbnail_path);
            $sql = "DELETE FROM `articles` WHERE `article_id` = '$article_id'";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $_SESSION['article_deleted']  = " تم حذف المقال بنجاح";
                header('location:' . ROOT . '/dashboard.php');
                die();
            }
        }
    }
} else {
    header('location:' . ROOT . '/index.php');
    die();
}
