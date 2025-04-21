<?php
require 'inc/header.php';
if (isset($_SESSION['USER']['user_id'])) {
	$current_user_id = $_SESSION['USER']['user_id'];
}
$load_posts_query  = "SELECT * FROM `users` INNER JOIN `posts` WHERE `users`.`id` = `posts`.`user_id` ORDER BY created_at desc;";
$load_posts = mysqli_query($conn, $load_posts_query);	
?>

<div class="class_11">

	<h1 class="class_41">
		المنشورات
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
	<?php if (isset($_SESSION['post_success'])): ?>
		<div class="alert_message success">
			<p><?php
				$success_message = $_SESSION['post_success'];
				if (!empty($success_message)) {

					echo $success_message . "<br>";
				}
				unset($_SESSION['post_success']);
				?>
			</p>
		</div>
	<?php endif; ?>
	<form method="post" action="post_handling.php" class="class_42">
		<div class="class_43">
			<textarea placeholder="ما الذي تفكر فيه" name="post" class="class_44"></textarea>
		</div>
		<input type="hidden" name="current_user" value="<?= $current_user_id ?>">
		<input type="submit" value="نشر" class="publishPost">
	</form>
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
	<!-- post card template -->
	<?php
	if (mysqli_num_rows($load_posts) > 0):
	?>
		<?php while ($post = mysqli_fetch_assoc($load_posts)): ?>
			
			<div class="class_42 " style="animation: appear 2.3s ease;">
				<div class="class_49">
					<h4 class="class_41">
						<?php
						// here i used an interface to handle date and time coming from the database
						$timestamp = strtotime($post['created_at']);
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
						<?= $post['post_content'] ?>
					</div>
					<div class="class_51">
					    <?php
						// trying to load comment count foreach post but i got bored
						// $comments_count_query = "SELECT COUNT(comment_id) AS comment_count FROM `comments` INNER JOIN `posts` WHERE comments.post_id = posts.id";
						// $count_result = mysqli_query($conn,$comments_count_query);
						// $comments_count = mysqli_fetch_assoc($count_result)	; 
						?>
						<a class="class_53" href="post.php?id=<?= $post['id'] ?>">
							التعليقات
						</a>
						<i class="bi bi-chat-left-dots class_52">
						</i>
					</div>
					<?php
					// if there is no logged in user then show nothing
					if (empty($current_user_id)):
					?>
						<div>
							<p></p>
						</div>
						<!-- check if user owns the post then show action buttons !-->
					<?php elseif ($current_user_id === $post['user_id']): ?>
						<div class="actionButtons">
							<div class="edit_btn">
								<a href="post_edit.php?id=<?= $post['id'] ?>">تعديل</a>
							</div>
							<div class="delete_btn">
								<p></p>
								<a href="post_delete.php?id=<?= $post['id'] ?>">حذف</a>
							</div>
						</div>
					<?php endif; ?>
				</div>
				<a href="#" class="class_45">
					<img src="assets/images/<?= $post['user_avatar'] ?>" class="class_47">
					<h2 class="class_48" style="font-size: 16px;">
						<?= $post['first_name'] . " " . $post['last_name'] ?>
					</h2>
				</a>
			</div>
		<?php endwhile; ?>
	<?php else: ?>
		<div>
			<p> No Posts Found</p>
		</div>
	<?php endif; ?>
	<!-- end post card template -->
	<div class="postControl" style="display: flex; justify-content:space-between;">
		<button class="class_54">
			الصفحه السابقه
		</button>
		<div class="page_number" style="color:white">Page 1</div>
		<button class="class_39">
			الصفحه القادمة
		</button>

	</div>

</div>
<br><br>

</section>

</body>


</html>