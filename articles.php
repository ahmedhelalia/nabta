<?php
include 'inc/header.php';
// Fetch all Categories
$sql = "SELECT * FROM `articles` INNER JOIN `users` INNER JOIN `categories`
 ON articles.user_id = users.id AND articles.category = categories.category_id";
$articles = mysqli_query($conn, $sql);
?>
<!-- Start Search Bar -->
<section class="search__bar">
    <form action="<?= ROOT ?>/search.php" method="get" class="search__bar-container">
        <div class="search-items">
            <input type="search" name="search" placeholder="ابحث عن مقال...">
            <i class="uil uil-search"></i>
            
        <button type="submit" name="submit" class="search-btn">بحث</button>
        </div>
    </form>
</section>
<!-- End Search Bar  -->

<section class="posts">
    <div class="article-container posts__container">
        <?php while ($article = mysqli_fetch_assoc($articles)): ?>
            <article class="post">
                <div class="post__thumbnail">
                    <img src="<?= ROOT ?>/assets/images/<?= $article['thumbnail'] ?>">
                </div>
                <div class="post__info">
                    <a href="" class="category__button"><?= $article['category_name'] ?></a>
                    <h3 class="post__title"><a href="article.php?id=<?= $article['article_id'] ?>"><?= $article['title'] ?> </a></h3>
                    <p class="post__body">
                        <?= mb_substr($article['article'], 0, 200, 'UTF-8') ?>...
                    </p>
                    <div class="post__author">
                        <div class="post__author-avatar">
                            <img src="<?= ROOT ?>/assets/images/<?= $article['user_avatar'] ?>">
                        </div>
                        <div class="post__author-info">
                            <h5>كتابة: <?= $article['first_name'] . $article['last_name'] ?></h5>
                            <small>Sep 30,2024 1:22 AM</small>
                        </div>
                    </div>
                </div>

            </article>
        <?php endwhile; ?>
    </div>
</section>
<?php include 'inc/footer.php' ?>