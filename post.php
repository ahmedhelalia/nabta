<?php
include 'inc/header.php';
if (isset($_SESSION['USER']['user_id'])) {
    $current_user_id = $_SESSION['USER']['user_id'];
}
$post_id = $_GET['id'];
$post_query = "SELECT * FROM `users` INNER JOIN `posts`  WHERE `users`.`id` = `posts`.`user_id` && `posts`.`id` = '$post_id' LIMIT 1 ";
$result = mysqli_query($conn, $post_query);
if ($result) {
    $post_data = mysqli_fetch_assoc($result);
} else {
    echo "Something went wrong";
}
?>
<div class="class_11">
    <h1 style="text-align: right;direction:rtl;font-size: 2rem;">المنشور</h1>
    <!-- post card template -->
    <div class="class_42 " style="animation: appear 2.3s ease;">

        <div class="class_49">
            <h4 class="class_41">
                <?php
                // here i used an interface to handle date and time coming from the database
                $timestamp = strtotime($post_data['created_at']);
                $formatter = new IntlDateFormatter(
                    'ar_EG', // Arabic locale
                    IntlDateFormatter::FULL, // Full date format
                    IntlDateFormatter::SHORT  // Short time format
                );
                // Format the date
                $formatted_date = $formatter->format($timestamp);
                echo $formatted_date;
                ?>
            </h4>
            <div class="class_15">
                <?= $post_data['post_content'] ?>
            </div>
            <?php
            // if there is no logged in user then show nothing
            if (empty($current_user_id)):
            ?>
                <div>
                    <p></p>
                </div>
                <!-- check if user owns the post then show action buttons !-->
            <?php elseif ($current_user_id === $post_data['user_id']): ?>
                <div class="actionButtons">
                    <div class="edit_btn">
                        <a href="post_edit.php?id=<?= $post_data['id'] ?>">تعديل</a>
                    </div>
                    <div class="delete_btn">
                        <a href="post_delete.php?id=<?= $post_data['id'] ?>">حذف</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <a href="#" class="class_45">
            <img src="assets/images/<?= $post_data['user_avatar'] ?>" class="class_47">
            <h2 class="class_48" style="font-size: 16px;">
                <?= $post_data['first_name'] . " " . $post_data['last_name'] ?>
            </h2>
        </a>
    </div>
    <?php if (!isset($_SESSION['USER'])): ?>
        <div class="class_13">
            <i class="bi bi-info-circle-fill class_14">
            </i>
            <div class="class_15" style="cursor: pointer; text-align:center;">
                <a href="login.php"> برجاء تسجيل الدخول حتى تتمكن من التلعيق والنشر
                </a>
            </div>
        </div>
    <?php endif; ?>

    <!-- end post card template -->

    <h1 class="class_41">
        التعليقات
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
    <?php elseif (isset($_SESSION['comment_success'])): ?>
        <div class="alert_message success">
            <p><?php
                $success_message = $_SESSION['comment_success'];
                if (!empty($success_message)) {

                    echo $success_message . "<br>";
                }
                unset($_SESSION['comment_success']);
                ?>
            </p>
        </div>
    <?php endif; ?>
    <form method="post" action="handling_comments.php" class="class_42">
        <div class="class_43">
            <textarea placeholder="كتابة تعليق" name="comment" class="class_44"></textarea>
        </div>
        <input type="hidden" name="user_id" value="<?= $current_user_id ?>">
        <input type="hidden" name="post_id" value="<?= $post_data['id'] ?>">
        <input type="submit" value="تعليق" class="publishPost">
    </form>
    <!-- comment card template  -->
    <?php
    $comment_query = "SELECT * FROM `comments`  INNER JOIN `users`
    WHERE `comments`.`post_id` = '$post_id' && `comments`.`user_id` = `users`.`id`
     ";
    $load_comments = mysqli_query($conn, $comment_query);
    ?>
    <?php
    if (mysqli_num_rows($load_comments) > 0):
    ?>
        <?php while ($comment = mysqli_fetch_assoc($load_comments)): ?>
            <div class="class_42" style="animation: appear 2s ease;">

                <div class="class_49">
                    <h4 class="class_41">
                        <?php
                        // here i used an interface to handle date and time coming from the database
                        $timestamp = strtotime($comment['created_at']);
                        $formatter = new IntlDateFormatter(
                            'ar_EG', // Arabic locale
                            IntlDateFormatter::FULL, // Full date format
                            IntlDateFormatter::SHORT  // Short time format
                        );
                        // Format the date
                        $formatted_date = $formatter->format($timestamp);
                        echo $formatted_date;
                        ?>
                    </h4>
                    <div class="class_15">
                        <?= $comment['comment'] ?>
                    </div>
                    <?php
                    // if there is no logged in user then show nothing
                    if (empty($current_user_id)):
                    ?>
                        <div>
                            <p></p>
                        </div>
                        <!-- check if user owns the post then show action buttons !-->
                    <?php elseif ($current_user_id === $comment['user_id']): ?>
                        <div class="actionButtons">
                            <div class="edit_btn">
                                <a href="edit_comment.php?id=<?= $comment['comment_id'] ?>">تعديل</a>
                            </div>
                            <div class="delete_btn">
                                <a href="delete_comment.php?id=<?= $comment['comment_id'] ?>">حذف</a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <a href="#" class="class_45">
                    <img src="assets/images/<?= $comment['user_avatar'] ?>" class="class_47">
                    <h2 class="class_48" style="font-size: 16px;">
                        <?= $comment['first_name'] . " " . $comment['last_name'] ?>
                    </h2>
                </a>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div>
            <p> No Comments Found </p>
        </div>
    <?php endif; ?>
    <div class="postControl" style="display: flex; justify-content:space-between;">
        <button class="class_54">
            الصفحه السابقه
        </button>
        <div class="page_number" style="color:white">Page 1</div>
        <button class="class_39">
            الصفحه القادمة

        </button>

    </div>
    <!-- end comment card template -->