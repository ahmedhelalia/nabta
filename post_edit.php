<?php
include 'config/init.php';
$post_id = $_GET['id'];
$post_query = "SELECT * FROM `posts` WHERE `id` = '$post_id'";
$result = mysqli_query($conn, $post_query);
$post_data = mysqli_fetch_assoc($result);
$post = $post_data['post_content'];


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/style.css">
    <title>Post Edit</title>
</head>

<body>
    <div class="class_11">
        <h1 class="class_41">
            تعديل المنشور
        </h1>
        <?php if (isset($_SESSION['post_error'])): ?>
            <div class="alert_message error">
                <p><?php
                    $errors = $_SESSION['post_error'];
                    if (!empty($errors)) {
                        echo $errors . "<br>";
                    }
                    unset($_SESSION['post_error']);
                    unset($errors);
                    ?>
                </p>
            </div>
        <?php endif; ?>
        <form method="post" action="post_edit_handling.php" class="class_42">
            <div class="class_43">
                <textarea name="post" class="class_44"><?= $post ?></textarea>
            </div>
            <input type="hidden" name="post_id" value="<?= $post_id ?>">
            <input type="submit" value="حفظ" class="publishPost">
        </form>
    </div>
</body>

</html>