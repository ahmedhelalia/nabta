<?php
include 'inc/header.php';
if (!$isAdmin) {
    header('location:' . ROOT . '/index.php');
}
$users_query = "SELECT * FROM `users` LIMIT 8";
$users_query_result = mysqli_query($conn, $users_query);

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
                    <a href="dashboard.php">
                        <i class="uil uil-postcard"></i>
                        <h5>ادارة المقالات </h5>
                    </a>
                </li>
                <li>
                    <a href="add-user.html">
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
                <li>
                    <a href="#" class="active">
                        <i class="uil uil-user-plus"> </i>
                        <h5> ادارة المستخدمين</h5>
                    </a>
                </li>

            </ul>

        </aside>
        <main style="direction: rtl;">
            <h2>ادارة المستخدمين</h2>
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
            <table>
                <thead>
                    <tr>
                        <th>الحساب الالكتروني</th>
                        <th>اسم المستخدم</th>
                        <th>دور المستخدم</th>
                        <th>تعديل </th>
                        <th>حذف</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = mysqli_fetch_assoc($users_query_result)): ?>
                        <tr>
                            <td><?= $user['email'] ?></td>
                            <td><?= $user['first_name'] . ' ' . $user['last_name'] ?></td>
                            <td><?= $user['user_role']  ?></td>
                            <td><a href="#" class="dashboard-btn sm">تعديل </a></td>
                            <td><a href="delete-user.php?id=<?= $user['id'] ?>" class="dashboard-btn danger">حذف</a></td>
                        </tr>
                    <?php endwhile; ?>


                </tbody>
            </table>

        </main>
    </div>
</section>
<?php include 'inc/footer.php' ?>