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
    <div class="singlepost__container">
        <h2><?= $article['title'] ?></h2>
        <div class="post__author-info">
            <div class="post__author-avatar">
                <img src="<?= ROOT ?>/assets/images/<?= $article['user_avatar'] ?>" alt="Author Avatar">
            </div>
            <div class="author-details">
                <h5>كتابة: <?= $article['first_name'] . ' ' . $article['last_name'] ?></h5>
                <small><?= date('M d, Y', strtotime($article['published_at'])) ?></small>
            </div>
        </div>

        <div class="singlepost__thumbnail">
            <img src="<?= ROOT ?>/assets/images/<?= $article['thumbnail'] ?>" alt="<?= $article['title'] ?>">
        </div>

        <div class="article-content">
            <p><?= nl2br($article['article']) ?></p>
        </div>
    </div>
</section>
<?php include 'inc/footer.php' ?>