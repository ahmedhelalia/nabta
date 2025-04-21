<?php 
include 'config/init.php';
if(isset($_GET['id'])){
    $article_id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
    $sql = "DELETE FROM `articles` WHERE `article_id` = '$article_id'";
    $result = mysqli_query($conn,$sql);
    if($result){
        $_SESSION['article_deleted']  = "Article Deleted";
        header('location:'.ROOT.'/dashboard.php');
    }
}else{
    header('location:'.ROOT.'/index.php');
}