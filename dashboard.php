<?php
include 'inc/header.php';
$expert = $user_expert ? 'expert' : '';
if (!$isAdmin && !$expert) {
    header('location:' . ROOT . '/index.php');
}
$sql = "SELECT * FROM `articles` INNER JOIN `categories` on articles.category = categories.category_id";
$articles = mysqli_query($conn, $sql);

?>

<section class="dashboard">
    <div class="mainDash-container dashboard__container">
        <button id="show__sidebar-btn" class="sidebar__toggle"><i class="uil uil-angle-right-b"></i></button>
        <button id="hide__sidebar-btn" class="sidebar__toggle"><i class="uil uil-angle-left-b"></i></button>
        <aside>
            <ul>
                <li>
                    <a href="add_article.php">
                        <i class="uil uil-pen"></i>
                        <h5>اضافة مقال</h5>
                    </a>
                </li>
                <li>
                    <a href="#" class="active">
                        <i class="uil uil-postcard"></i>
                        <h5>ادارة المقالات </h5>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="uil uil-list-ul"> </i>

                        <h5>اضافة برنامج او دورة</h5>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <i class="uil uil-list-ul"> </i>
                        <h5> ادارة البرامج</h5>
                    </a>
                </li>
                <?php if($isAdmin): ?>
                <li>
                    <a href="manage-users.php">
                        <i class="uil uil-user-plus"> </i>
                        <h5> ادارة المستخدمين</h5>
                    </a>
                </li>
                <?php endif; ?>

            </ul>

        </aside>
        <main style="direction: rtl;">
            <h2>ادارة المقالات</h2>
            <?php
            if (isset($_SESSION['article_deleted'])):
            ?>
                <div class="alert_message success">
                    <p><?php
                        echo $_SESSION['article_deleted'];
                        unset($_SESSION['article_deleted'])
                        ?>
                    </p>
                </div>
            <?php endif; ?>
            <table>
                <thead>
                    <tr>
                        <th>العنوان</th>
                        <th>الفئة</th>
                        <th>تعديل </th>
                        <th>حذف</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($article = mysqli_fetch_assoc($articles)): ?>
                        <tr>
                            <td><?= $article['title'] ?></td>
                            <td><?= $article['category_name'] ?></td>
                            <td><a href="#" class="dashboard-btn sm">تعديل </a></td>
                            <td><a href="delete-article.php?id=<?= $article['article_id'] ?>" class="dashboard-btn danger">حذف</a></td>
                        </tr>
                    <?php endwhile; ?>


                </tbody>
            </table>

        </main>
    </div>
</section>
<?php include 'inc/footer.php' ?>