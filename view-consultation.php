<?php
require_once 'inc/header.php';
$expert = $user_expert ? 'expert' : '';
if (!$expert) {
    header('location:' . ROOT . '/index.php');
}

if (isset($_GET['id'])) {
    $consultation_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $expert_id = $_SESSION['USER']['user_id'];

    // Fetch consultation details
    $query = "SELECT c.*, u.first_name, u.last_name, u.email 
              FROM consultations c
              LEFT JOIN users u ON c.user_id = u.id
              WHERE c.id = ? AND c.expert_id = ?";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ii", $consultation_id, $expert_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($consultation = mysqli_fetch_assoc($result)) {
        // Add consultation update handling here if needed
    } else {
        $_SESSION['error_message'] = "الاستشارة غير موجودة";
        header('location: expert-consultations.php');
        exit;
    }
} else {
    header('location: expert-consultations.php');
    exit;
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
                        <h5>ادارة المقالات</h5>
                    </a>
                </li>
                <li>
                    <a href="expert-consultations.php" class="active">
                        <i class="fas fa-comments"></i>
                        <h5>إدارة الاستشارات</h5>
                    </a>
                </li>
                <li>
                    <a href="expert-profile.php">
                        <i class="fas fa-user-md"></i>
                        <h5>الملف الشخصي</h5>
                    </a>
                </li>
            </ul>
        </aside>

        <main style="direction: rtl;">
            <div class="consultation-details">
                <h2 class="dashboard-main-title">تفاصيل الاستشارة</h2>

                <div class="consultation-card">
                    <div class="user-info">
                        <h3>معلومات المستشير</h3>
                        <p><strong>الاسم:</strong> <?= htmlspecialchars($consultation['first_name'] . ' ' . $consultation['last_name']) ?></p>
                        <p><strong>البريد الإلكتروني:</strong> <?= htmlspecialchars($consultation['email']) ?></p>
                    </div>

                    <div class="consultation-info">
                        <h3>تفاصيل الاستشارة</h3>
                        <p><strong>نوع الاستشارة:</strong> <?= htmlspecialchars($consultation['consultation_type']) ?></p>
                        <p><strong>تاريخ الطلب:</strong> <?= date('Y/m/d', strtotime($consultation['created_at'])) ?></p>
                        <p><strong>الحالة:</strong>
                            <span class="status-badge <?= $consultation['status'] ?>">
                                <?= htmlspecialchars($consultation['status']) ?>
                            </span>
                        </p>
                    </div>

                    <div class="consultation-message">
                        <h3>رسالة المستشير</h3>
                        <p class="message-content"><?= nl2br(htmlspecialchars($consultation['message'])) ?></p>
                    </div>

                    <div class="consultation-actions">
                        <form action="update_consultation.php" method="POST">
                            <input type="hidden" name="consultation_id" value="<?= $consultation['id'] ?>">
                            <div class="form-group">
                                <label for="status">تحديث الحالة:</label>
                                <select name="status" id="status" style="background-color: #032f30;" required>
                                    <option value="pending" <?= $consultation['status'] == 'pending' ? 'selected' : '' ?>>قيد الانتظار</option>
                                    <option value="approved" <?= $consultation['status'] == 'approved' ? 'selected' : '' ?>>موافق عليها</option>
                                    <option value="completed" <?= $consultation['status'] == 'completed' ? 'selected' : '' ?>>مكتملة</option>
                                    <option value="cancelled" <?= $consultation['status'] == 'cancelled' ? 'selected' : '' ?>>ملغية</option>
                                </select>
                            </div>
                            <button type="submit" class="dashboard-btn">تحديث الحالة</button>
                        </form>
                    </div>
                </div>

                <div class="back-link">
                    <a href="expert-consultations.php" class="dashboard-btn sm">
                        <i class="fas fa-arrow-right"></i>
                        العودة إلى قائمة الاستشارات
                    </a>
                </div>
            </div>
        </main>
    </div>
</section>

<?php include 'inc/footer.php' ?>