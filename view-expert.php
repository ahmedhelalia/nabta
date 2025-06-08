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
    $expert = mysqli_fetch_assoc($result);

    // 2. Second query: Get expert consultation prices
    if ($expert) {
        $price_query = "SELECT * FROM consultation_prices 
                        WHERE expert_id = ? AND is_active = 1";

        $price_stmt = mysqli_prepare($conn, $price_query);
        mysqli_stmt_bind_param($price_stmt, "i", $expert_id);
        mysqli_stmt_execute($price_stmt);
        $prices_result = mysqli_stmt_get_result($price_stmt);

        // Create prices array
        $expert_prices = [];
        while ($price = mysqli_fetch_assoc($prices_result)) {
            $expert_prices[$price['consultation_type']] = [
                'price' => $price['price'],
                'duration' => $price['duration']
            ];
        }

        $expert['price_pre_marriage'] = $expert_prices['pre-marriage']['price'] ?? null;
        $expert['duration_pre_marriage'] = $expert_prices['pre-marriage']['duration'] ?? null;
        $expert['price_marriage'] = $expert_prices['marriage']['price'] ?? null;
        $expert['duration_marriage'] = $expert_prices['marriage']['duration'] ?? null;
        $expert['price_parenting'] = $expert_prices['parenting']['price'] ?? null;
        $expert['duration_parenting'] = $expert_prices['parenting']['duration'] ?? null;
    }

    if ($expert) {
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
            <div class="expert-pricing">
                <h3>أسعار الاستشارات</h3>
                <div class="price-cards">
                    <?php if ($expert['price_pre_marriage']): ?>
                        <div class="price-card">
                            <h4>استشارات ما قبل الزواج</h4>
                            <p class="price"><?= htmlspecialchars($expert['price_pre_marriage']) ?> ج.م</p>
                            <p class="duration"><?= htmlspecialchars($expert['duration_pre_marriage']) ?> دقيقة</p>
                        </div>
                    <?php endif; ?>

                    <?php if ($expert['price_marriage']): ?>
                        <div class="price-card">
                            <h4>استشارات زوجية</h4>
                            <p class="price"><?= htmlspecialchars($expert['price_marriage']) ?> ج.م</p>
                            <p class="duration"><?= htmlspecialchars($expert['duration_marriage']) ?> دقيقة</p>
                        </div>
                    <?php endif; ?>

                    <?php if ($expert['price_parenting']): ?>
                        <div class="price-card">
                            <h4>استشارات تربوية</h4>
                            <p class="price"><?= htmlspecialchars($expert['price_parenting']) ?> ج.م</p>
                            <p class="duration"><?= htmlspecialchars($expert['duration_parenting']) ?> دقيقة</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php if (isset($_SESSION['USER']) && $_SESSION['USER']['user_id'] !== $expert_id): ?>
                <div class="consultation-booking">
                    <h3>حجز استشارة</h3>

                    <form class="booking-form" action="process_consultation.php" method="POST">
                        <input type="hidden" name="expert_id" value="<?= $expert_id ?>">
                        <div class="form-group">
                            <select name="consultation_type" id="consultation-type" required onchange="updatePrice()">
                                <option value="">نوع الاستشارة</option>
                                <?php if ($expert['price_pre_marriage']): ?>
                                    <option value="pre-marriage" data-price="<?= htmlspecialchars($expert['price_pre_marriage']) ?>"
                                        data-duration="<?= htmlspecialchars($expert['duration_pre_marriage']) ?>">
                                        استشارات ما قبل الزواج
                                    </option>
                                <?php endif; ?>
                                <?php if ($expert['price_marriage']): ?>
                                    <option value="marriage" data-price="<?= htmlspecialchars($expert['price_marriage']) ?>"
                                        data-duration="<?= htmlspecialchars($expert['duration_marriage']) ?>">
                                        استشارات زوجية
                                    </option>
                                <?php endif; ?>
                                <?php if ($expert['price_parenting']): ?>
                                    <option value="parenting" data-price="<?= htmlspecialchars($expert['price_parenting']) ?>"
                                        data-duration="<?= htmlspecialchars($expert['duration_parenting']) ?>">
                                        استشارات تربوية
                                    </option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="form-group price-display" style="display: none;">
                            <p>السعر: <span id="selected-price">0</span> ج.م</p>
                            <p>المدة: <span id="selected-duration">0</span> دقيقة</p>
                            <input type="hidden" name="consultation_price" id="consultation-price">
                            <input type="hidden" name="consultation_duration" id="consultation-duration">
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
        <script>
            function updatePrice() {
                const select = document.getElementById('consultation-type');
                const priceDisplay = document.querySelector('.price-display');
                const selectedOption = select.options[select.selectedIndex];

                if (selectedOption.value) {
                    const price = selectedOption.getAttribute('data-price');
                    const duration = selectedOption.getAttribute('data-duration');

                    document.getElementById('selected-price').textContent = price;
                    document.getElementById('selected-duration').textContent = duration;
                    document.getElementById('consultation-price').value = price;
                    document.getElementById('consultation-duration').value = duration;

                    priceDisplay.style.display = 'block';
                } else {
                    priceDisplay.style.display = 'none';
                }
            }
        </script>
<?php
    } else {
        echo "<div class='alert_message error'>الخبير غير موجود</div>";
    }
} else {
    header('location: ' . ROOT . '/consultations.php');
}
?>
<?php include 'inc/footer.php'; ?>