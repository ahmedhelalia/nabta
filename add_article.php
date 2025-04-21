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
<section class="form_section">
    <div class="form_section_container">
        <h2 style="direction: rtl; margin-top:50px">اضافة مقال</h2>
        <?php if(isset($_SESSION['add_article'])): ?>
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