<?php
include 'inc/header.php';
if (isset($_GET['id'])) {
    $article_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $sql = "SELECT * FROM `articles` INNER JOIN `users` INNER JOIN `categories`
            ON articles.user_id = users.id AND articles.category = categories.category_id
            WHERE articles.article_id = '$article_id'";
    $result = mysqli_query($conn, $sql);
    $article = mysqli_fetch_assoc($result);
}
?>
<section class="singlepost">
    <div class="single-container singlepost__container">
        <h2><?= $article['title'] ?></h2>
        <div class="post__author-info" style="margin-top:20px">
            <small>Sep 31,2024 11:31 PM</small>
            <h5> كتابة: <?= $article['first_name'] . $article['last_name'] ?> </h5>
            <div class="post__author-avatar">
            <!-- <img src="assets/images/<?= $article['user_avatar'] ?>"> -->
        </div>
        </div>
        

        <div class="singlepost__thumbnail">
            <img src="assets/images/<?= $article['thumbnail'] ?>">
        </div>
        <p>
            <?= $article['article'] ?>
        </p>
    </div>
</section>
<?php include 'inc/footer.php' ?>