<?php
include 'config/init.php';
if (isset($_POST['submit'])) {
    $author_id   = $_SESSION['USER']['user_id'];
    $title       = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $article     = filter_var($_POST['article'], FILTER_SANITIZE_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail   = $_FILES['article_thumbnail'];
    if (!$title) {
        $_SESSION['add_article'] = "برجاء اختيار عنوان";
    } elseif (!$category_id) {
        $_SESSION['add_article'] = 'برجاء اختيار فئة المقال';
    } elseif (!$article) {
        $_SESSION['add_article'] = 'برجاء كتابة المقال';
    } elseif (!$thumbnail['name']) {
        $_SESSION['add_article'] = 'برجاء وضع صورة للمقال';
    } else {
        // Work on article thumbnail 
        // rename the thumbnail
        $time = time();
        $thumbnail_name     = $time . $thumbnail['name'];
        $thumbnail_tmp_name = $thumbnail['tmp_name'];
        $thumbnail_path     = 'assets/images/' . $thumbnail_name;
        // making sure the image is not larger than 2mb
        if ($thumbnail['size'] < 2000000) {
            move_uploaded_file($thumbnail_tmp_name, $thumbnail_path);
        } else {
            $_SESSION['add_article'] = "حجم الملف كبير ";
        }
    }
    // redirect back to add_article with form data if there's an error
    if (isset($_SESSION['add_article'])) {
        $_SESSION['add_article_data'] = $_POST;
        header("location:" . ROOT . '/add_article.php');
        die();
    } else {
        // Insert Article into data base
        $sql = "INSERT INTO `articles`(`user_id`,`article`,`category`,`thumbnail`,`title`)
        VALUES('$author_id','$article','$category_id','$thumbnail_name','$title')";
        $result = mysqli_query($conn, $sql);
        if (!mysqli_errno($conn)) {
            $_SESSION['add_article_success'] = "تم اضافة المقال بنجاح";
            header("location:" . ROOT . '/articles.php');
            die();
        }
    }
} else {
    header('location:' . ROOT . "/index.php");
}
