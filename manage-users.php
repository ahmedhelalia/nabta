<?php
include 'inc/header.php';
if (!$isAdmin) {
    header('location:' . ROOT . '/index.php');
}
$users_query = "SELECT * FROM `users`";
$users_query_result = mysqli_query($conn, $users_query);

?>
<section class="dashboard" style="margin-left: 18rem;">
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
                    <a href="dashboard.php">
                        <i class="uil uil-postcard"></i>
                        <h5>ادارة المقالات </h5>
                    </a>
                </li>

                <li>
                    <a href="#" class="active">
                        <i class="uil uil-user-plus"> </i>
                        <h5> ادارة المستخدمين</h5>
                    </a>
                </li>

            </ul>

        </aside>
        <main style="direction: rtl;">
            <h2 class="dashboard-main-title">ادارة المستخدمين</h2>
            <?php
            if (isset($_SESSION['user_deleted'])):
            ?>
                <div class="alert_message success">
                    <p><?php
                        echo $_SESSION['user_deleted'];
                        unset($_SESSION['user_deleted'])
                        ?>
                    </p>
                </div>
            <?php endif; ?>
            <?php
            if (isset($_SESSION['delete_user_error'])):
            ?>
                <div class="alert_message error">
                    <p><?php
                        echo $_SESSION['delete_user_error'];
                        unset($_SESSION['delete_user_error']);
                        ?>
                    </p>
                </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['block_success'])): ?>
                <div class="alert_message success">
                    <p><?php
                        echo $_SESSION['block_success'];
                        unset($_SESSION['block_success']);
                        ?></p>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['block_error'])): ?>
                <div class="alert_message error">
                    <p><?php
                        echo $_SESSION['block_error'];
                        unset($_SESSION['block_error']);
                        ?></p>
                </div>
            <?php endif; ?>

            <table>
                <thead>
                    <tr>
                        <th>الحساب الالكتروني</th>
                        <th>اسم المستخدم</th>
                        <th>دور المستخدم</th>
                        <th>تعديل </th>
                        <th>حظر</th>
                        <th>حذف</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = mysqli_fetch_assoc($users_query_result)): ?>
                        <tr> 
                            <td data-label="الحساب الالكتروني"><?= $user['email'] ?></td>
                            <td data-label="اسم المستخدم"><?= $user['first_name'] . ' ' . $user['last_name'] ?></td>
                            <td data-label="دور المستخدم"><?= $user['user_role']  ?></td>
                            <td data-label="تعديل"><a href="#" class="dashboard-btn sm">تعديل </a></td>
                            <td data-label="حظر">
                                <a
                                    class="dashboard-btn sm  warning ?>" 
                                    onclick="confirmBlock(<?= $user['id'] ?>)">
                                    <?= $user['blocked'] === "1" ? 'إلغاء الحظر' : 'حظر' ?>
                                </a>
                            </td>
                            <td data-label="حذف"><a class="dashboard-btn sm danger" onclick="confirmDelete(<?= $user['id'] ?>)">حذف</a></td>
                        </tr>
                    <?php endwhile; ?>


                </tbody>
            </table>

        </main>
    </div>
</section>
<script>
    function confirmDelete(userId) {
        if (confirm("هل أنت متأكد أنك تريد حذف هذا المستخدم؟")) {
            window.location.href = "delete-user.php?id=" + userId;
        } else {
            event.preventDefault();
        }
    }
    function confirmBlock(userId) {
        if (confirm("هل أنت متأكد أنك تريد تغيير حالة الحظر لهذا المستخدم؟")) {
            window.location.href = "block-user.php?id=" + userId;
        } else {
            event.preventDefault();
        }
    }
</script>
<?php include 'inc/footer.php' ?>