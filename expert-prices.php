<?php
require_once 'inc/header.php';
$expert = $user_expert ? 'expert' : '';
if (!$expert) {
    header('location:' . ROOT . '/index.php');
}

// Fetch current prices for the expert
$expert_id = $_SESSION['USER']['user_id'];
$query = "SELECT * FROM consultation_prices WHERE expert_id = ? AND is_active = 1";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $expert_id);
mysqli_stmt_execute($stmt);
$prices = mysqli_stmt_get_result($stmt);

// Convert to associative array for easier access
$current_prices = [];
while ($row = mysqli_fetch_assoc($prices)) {
    $current_prices[$row['consultation_type']] = $row;
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
                        <a href="expert-prices.php" class="active"><i class="fa-solid fa-money-check-dollar"></i>
                            <h5>إدارة اسعار الاستشارات</h5>
                        </a>
                    </li>
                    <li>
                        <a href="expert-profile.php"><i class="fas fa-user-md"></i>
                            <h5>الملف الشخصي</h5>
                        </a>
                    </li>
                <?php endif; ?>

            </ul>

        </aside>
        <main style="direction: rtl;">
            <h2 class="dashboard-main-title">إدارة أسعار الاستشارات</h2>

            <?php if (isset($_SESSION['price_message'])): ?>
                <div class="alert_message <?= $_SESSION['price_status'] ?>">
                    <p><?= $_SESSION['price_message'] ?></p>
                </div>
                <?php unset($_SESSION['price_message'], $_SESSION['price_status']); ?>
            <?php endif; ?>

            <form action="process_pricing.php" method="POST" class="pricing-form">
                <!-- Pre-marriage consultation pricing -->
                <div class="form-group">
                    <h3>استشارات ما قبل الزواج</h3>
                    <div class="price-inputs">
                        <label style="color:white" for="price">السعر</label>
                        <input type="number" name="prices[pre-marriage]"
                            value="<?= $current_prices['pre-marriage']['price'] ?? '' ?>"
                            id="price" required>
                        <label style="color: white;" for="duration">المدة (بالدقائق)</label>
                        <input type="number" name="duration[pre-marriage]"
                            value="<?= $current_prices['pre-marriage']['duration'] ?? '' ?>"
                            id="duration" required>
                    </div>
                </div>

                <!-- Marriage consultation pricing -->
                <div class="form-group">
                    <h3>استشارات زوجية</h3>
                    <div class="price-inputs">
                        <label style="color:white" for="price">السعر</label>
                        <input type="number" name="prices[marriage]"
                            value="<?= $current_prices['marriage']['price'] ?? '' ?>"
                            id="price" required>
                        <label style="color: white;" for="duration">المدة (بالدقائق)</label>
                        <input type="number" name="duration[marriage]"
                            value="<?= $current_prices['marriage']['duration'] ?? '' ?>"
                            id="duration" required>
                    </div>
                </div>

                <!-- Parenting consultation pricing -->
                <div class="form-group">
                    <h3>استشارات تربوية</h3>
                    <div class="price-inputs">
                        <label style="color:white" for="price">السعر</label>
                        <input type="number" name="prices[parenting]"
                            value="<?= $current_prices['parenting']['price'] ?? '' ?>"
                            required id="price">
                        <label style="color: white;" for="duration">المدة (بالدقائق)</label>
                        <input type="number" name="duration[parenting]"
                            value="<?= $current_prices['parenting']['duration'] ?? '' ?>"
                            required id="duration">
                    </div>
                </div>

                <button type="submit" class="dashboard-btn">حفظ الأسعار</button>
            </form>
        </main>
    </div>
</section>

<?php include 'inc/footer.php' ?>