<?php
include 'config/init.php';
$comment_id = $_GET['id'];
$comment_query = "SELECT * FROM `comments` WHERE `comment_id` = '$comment_id'";
$result = mysqli_query($conn, $comment_query);
$comment_data = mysqli_fetch_assoc($result);
$comment = $comment_data['comment'];


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
        <h1 class="class_41">تعديل التعليق
        </h1>
        <?php if (isset($_SESSION['comment_error'])): ?>
            <div class="alert_message error">
                <p><?php
                    $errors = $_SESSION['comment_error'];
                    if (!empty($errors)) {
                        echo $errors . "<br>";
                    }
                    unset($_SESSION['comment_error']);
                    unset($errors);
                    ?>
                </p>
            </div>
        <?php endif; ?>
        <form method="post" action="comment_edit_handling.php" class="class_42">
            <div class="class_43">
                <textarea name="comment" class="class_44"><?= $comment ?></textarea>
            </div>
            <input type="hidden" name="comment_id" value="<?= $comment_id ?>">
            <input type="hidden" name="post_id" value="<?= $comment_data['post_id'] ?>">
            <input type="submit" value="حفظ" class="publishPost">
        </form>
    </div>
</body>

</html>