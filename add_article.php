<?php include
    'inc/header.php';
$categories_query = "SELECT * FROM `categories`";
$categories = mysqli_query($conn, $categories_query);
// get back form data if form was invalid
$title = $_SESSION["add_article_data"]['title'] ?? null;
$article = $_SESSION['add_article_data']['article'] ?? null;

// delete form data session 
unset($_SESSION['add_article_data']);
?>
<section class="dashboard">
    <div class="mainDash-container dashboard__container">
        <button id="show__sidebar-btn" class="sidebar__toggle"><i class="uil uil-angle-right-b"></i></button>
        <button id="hide__sidebar-btn" class="sidebar__toggle"><i class="uil uil-angle-left-b"></i></button>
        <aside>
            <ul>
                <li>
                    <a href="add_article.php" class="active">
                        <i class="uil uil-pen"></i>
                        <h5>اضافة مقال</h5>
                    </a>
                </li>
                <li>
                    <a href="dashboard.php">
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
        <div class="dashboard_form_container" style="direction: rtl;">
            <h2 style="direction: rtl; margin-top:50px">اضافة مقال</h2>
            <?php if (isset($_SESSION['add_article'])): ?>
                <div class="alert_message error">
                    <p>
                        <?= $_SESSION['add_article'];
                        unset($_SESSION['add_article'])
                        ?>
                    </p>
                </div>
            <?php endif; ?>
            <form action="add_article_logic.php" enctype="multipart/form-data" method="post">

                <input type="text" name="title" value="<?= $title ?>" placeholder="عنوان المقال">
                <select name="category">
                    <option value="">الفئة</option>
                    <?php while ($category = mysqli_fetch_assoc($categories)): ?>
                        <option value="<?= $category['category_id'] ?>"><?= $category['category_name'] ?></option>
                    <?php endwhile; ?>
                </select>

                <textarea name="article" id="" rows="10" placeholder="المقال"><?= $article ?></textarea>
                <div class="form_control" style="direction:rtl">
                    <label for="thumbnail">صورة المقال</label>
                    <input type="file" name="article_thumbnail" id="thumbnail">
                </div>

                <button type="submit" name="submit" class="btn">اضافة</button>

            </form>
        </div>
</section>
<?php include 'inc/footer.php' ?>