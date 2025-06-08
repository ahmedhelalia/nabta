<?php
include 'inc/header.php';

if (isset($_GET['id'])) {
    $expert_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Fetch expert details
    $query = "SELECT u.*, ep.* 
              FROM users u
              INNER JOIN expert_profiles ep ON u.id = ep.expert_id
              WHERE u.id = ? AND u.user_role = 'expert'";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $expert_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($expert = mysqli_fetch_assoc($result)) {
?>
        <div class="expert-profile-container">
            <div class="expert-profile-header">
                <img src="assets/images/<?= $expert['user_avatar'] ?>"
                    alt="<?= htmlspecialchars($expert['first_name'] . ' ' . $expert['last_name']) ?>">
                <h1>د. <?= htmlspecialchars($expert['first_name'] . ' ' . $expert['last_name']) ?></h1>
                <h2><?= htmlspecialchars($expert['specialization']) ?></h2>
            </div>

            <div class="expert-profile-content">
                <div class="expert-bio">
                    <h3>نبذة تعريفية</h3>
                    <p><?= nl2br(htmlspecialchars($expert['bio'])) ?></p>
                </div>

                <div class="expert-contact-info">
                    <h3>ساعات العمل</h3>
                    <p><?= htmlspecialchars($expert['contact_hours']) ?></p>

                    <?php if (!empty($expert['whatsapp'])): ?>
                        <a href="https://wa.me/<?= $expert['whatsapp'] ?>" class="whatsapp-btn">
                            <i class="fab fa-whatsapp"></i>
                            تواصل عبر واتساب
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php if (isset($_SESSION['USER']) && $_SESSION['USER']['user_id'] !== $expert_id): ?>
                <div class="consultation-booking">
                    <h3>حجز استشارة</h3>

                    <form class="booking-form" action="process_consultation.php" method="POST">
                        <input type="hidden" name="expert_id" value="<?= $expert_id ?>">
                        <div class="form-group">
                            <select name="consultation_type" required>
                                <option value="">نوع الاستشارة</option>
                                <option value="pre-marriage">استشارات ما قبل الزواج</option>
                                <option value="marriage">استشارات زوجية</option>
                                <option value="parenting">استشارات تربوية</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="tel" name="phone" placeholder="رقم الهاتف" dir="ltr"
                                pattern="[0-9]+" required>
                        </div>
                        <div class="form-group">
                            <textarea name="message" placeholder="تفاصيل الاستشارة" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="submit-btn">تأكيد الحجز</button>
                    </form>
                </div>
            <?php elseif (!isset($_SESSION['USER'])): ?>
                <div class="login-prompt">
                    <p>الرجاء <a href="login.php">تسجيل الدخول</a> لحجز استشارة</p>
                </div>
            <?php endif; ?>
        </div>
        </div>
<?php
    } else {
        echo "<div class='alert_message error'>الخبير غير موجود</div>";
    }
} else {
    header('location: ' . ROOT . '/consultations.php');
}

include 'inc/footer.php';
?>