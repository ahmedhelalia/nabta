<?php
require 'inc/header.php';
// Get expert profile data
$expert_id = $_SESSION['USER']['user_id'];
$query = "SELECT * FROM expert_profiles WHERE expert_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $expert_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$expert_data = mysqli_fetch_assoc($result);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $specialization = filter_var($_POST['specialization'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $bio = filter_var($_POST['bio'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $contact_hours = filter_var($_POST['contact_hours'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $whatsapp = filter_var($_POST['whatsapp'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if (!$expert_data) {
        // Insert new profile
        $query = "INSERT INTO expert_profiles (expert_id, specialization, bio, contact_hours,whatsapp) 
                  VALUES (?, ?, ?, ?,?)";
    } else {
        // Update existing profile
        $query = "UPDATE expert_profiles 
                  SET specialization = ?, bio = ?, contact_hours = ? ,whatsapp = ?
                  WHERE expert_id = ?";
    }

    $stmt = mysqli_prepare($conn, $query);
    if (!$expert_data) {
        mysqli_stmt_bind_param($stmt, "issss", $expert_id, $specialization, $bio, $contact_hours,$whatsapp);
    } else {
        mysqli_stmt_bind_param($stmt, "ssssi", $specialization, $bio, $contact_hours, $whatsapp,$expert_id);
    }

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success_message'] = "تم تحديث الملف الشخصي بنجاح";
        header('location: ' . ROOT . '/expert-profile.php');
        exit;
    }
}
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
                <?php if ($user_expert === 'expert'): ?>

                    <li>
                        <a href="expert-consultations.php"><i class="fas fa-comments"></i>
                            <h5>إدارة الاستشارات</h5>
                        </a>
                    </li>
                    <li>
                        <a href="expert-profile.php" class="active"><i class="fas fa-user-md"></i>
                            <h5>الملف الشخصي</h5>
                        </a>
                    </li>
                <?php endif; ?>

            </ul>

        </aside>
        <main style="direction: rtl;">
            <h2 class="dashboard-main-title">الملف الشخصي</h2>
            <form class="dashboard_form_container" method="POST">
                <div class="form_control">
                    <label for="specialization">التخصص</label>
                    <input type="text" name="specialization" id="specialization"
                        value="<?= $expert_data['specialization'] ?? '' ?>">
                </div>
                <div class="form_control">
                    <label for="bio">نبذة تعريفية</label>
                    <textarea name="bio" id="bio"><?= $expert_data['bio'] ?? '' ?></textarea>
                </div>
                <div class="form_control">
                    <label for="contact_hours">ساعات العمل</label>
                    <input type="text" name="contact_hours" id="contact_hours"
                        value="<?= $expert_data['contact_hours'] ?? '' ?>">
                </div>
                <div class="form_control">
                    <label for="whatsapp">رقم الواتساب (مع رمز الدولة، مثال: 201234567890)</label>
                    <input type="text" name="whatsapp" id="whatsapp" dir="ltr"
                        placeholder="+20XXXXXXXXXX"
                        value="<?= $expert_data['whatsapp'] ?? '' ?>">
                </div>
                <button type="submit" class="dashboard-btn">حفظ التغييرات</button>
            </form>
        </main>
    </div>
</section>

<?php include 'inc/footer.php' ?>