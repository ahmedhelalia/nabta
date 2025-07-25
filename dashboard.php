<?php
include 'inc/header.php';
$expert = $user_expert ? 'expert' : '';
if (!$isAdmin && !$expert) {
    header('location:' . ROOT . '/index.php');
}
// Get the current user's ID
$current_user_id = $_SESSION['USER']['user_id'];

// Modify SQL query based on user role
if ($isAdmin) {
    // Admin sees all articles
    $sql = "SELECT * FROM `articles` 
            INNER JOIN `categories` ON articles.category = categories.category_id";
} else {
    // Expert sees only their own articles
    $sql = "SELECT * FROM `articles` 
            INNER JOIN `categories` ON articles.category = categories.category_id 
            WHERE articles.user_id = $current_user_id";
}

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
                <?php if ($user_expert === 'expert'): ?>

                    <li>
                        <a href="expert-consultations.php"><i class="fas fa-comments"></i>
                            <h5>إدارة الاستشارات</h5>
                        </a>
                    </li>
                      <li>
                        <a href="expert-prices.php" ><i class="fa-solid fa-money-check-dollar"></i>
                            <h5>إدارة اسعار الاستشارات</h5>
                        </a>
                    </li>
                    <li>
                        <a href="expert-profile.php"><i class="fas fa-user-md"></i>
                            <h5>الملف الشخصي</h5>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ($isAdmin): ?>
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
            <h2 class="dashboard-main-title">ادارة المقالات</h2>
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
                    <?php if (mysqli_num_rows($articles) > 0): ?>
                        <?php while ($article = mysqli_fetch_assoc($articles)): ?>
                            <tr>
                                <td data-label="العنوان"><?= $article['title'] ?></td>
                                <td data-label="الفئة "><?= $article['category_name'] ?></td>
                                <td data-label="تعديل "><a href="#" class="dashboard-btn sm">تعديل </a></td>
                                <td data-label="حذف"><a href="delete-article.php?id=<?= $article['article_id'] ?>" class="dashboard-btn sm danger">حذف</a></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" style="text-align: center;">لا توجد مقالات منشورة حالياً</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

        </main>
    </div>
</section>
<?php include 'inc/footer.php' ?>