<?php
include 'inc/header.php';
if (isset($_GET['search']) && isset($_GET['submit'])) {
    $search = filter_var($_GET['search'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $query = "SELECT * FROM `articles` WHERE `title` LIKE '%$search%' ORDER BY article_id DESC;";
    $articles = mysqli_query($conn, $query);
} else {
    header("location: " . ROOT . '/articles.php');
    die();
}
?>
<?php if (mysqli_num_rows($articles) > 0): ?>
    <section class="posts" style="margin-top: 4rem;">
        <div class="article-container posts__container">
            <?php while ($article = mysqli_fetch_assoc($articles)): ?>
                <article class="post">
                    <div class="post__thumbnail">
                        <img src="<?= ROOT ?>/assets/images/<?= $article['thumbnail'] ?>">
                    </div>
                    <?php
                    // fetch category from categories using category_id 
                    $category_id = $article['category'];
                    $category_query = "SELECT * FROM `categories` WHERE `category_id` = '$category_id'";
                    $category_result = mysqli_query($conn, $category_query);
                    $category = mysqli_fetch_assoc($category_result);
                    ?>
                    <div class="post__info">
                        <a href="" class="category__button"><?= $category['category_name'] ?></a>
                        <h3 class="post__title"><a href="article.php?id=<?= $article['article_id'] ?>"><?= $article['title'] ?> </a></h3>
                        <p class="post__body">
                            <?= mb_substr($article['article'], 0, 200, 'UTF-8') ?>...
                        </p>
                        <?php
                        // fetch author from users table using author_id
                        $author_id = $article['user_id'];
                        $author_query  = "SELECT * FROM `users` WHERE `id` = $author_id;";
                        $author_result = mysqli_query($conn, $author_query);
                        $author = mysqli_fetch_assoc($author_result);
                        ?>
                        <div class="post__author">
                            <div class="post__author-avatar">
                                <img src="<?= ROOT ?>/assets/images/<?= $author['user_avatar'] ?>">
                            </div>
                            <div class="post__author-info">
                                <h5>كتابة: <?= $author['first_name'] . $author['last_name'] ?></h5>
                                <small>Sep 30,2024 1:22 AM</small>
                            </div>
                        </div>
                    </div>

                </article>
            <?php endwhile; ?>
        </div>
    </section>
<?php else: ?>
    <div class="empty__search">      
        <p>لا يوجد نتائج لهذا البحث</p>
    </div>
<?php endif; ?>
<?php include 'inc/footer.php' ?>