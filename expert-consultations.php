<?php
require_once 'inc/header.php';
$expert = $user_expert ? 'expert' : '';
if (!$expert) {
    header('location:' . ROOT . '/index.php');
}
// Fetch consultations for the logged-in expert
$expert_id = $_SESSION['USER']['user_id'];
$query = "SELECT c.*, u.first_name as firstname, u.last_name as lastname,
          cp.price, cp.duration
          FROM consultations c
          LEFT JOIN users u ON c.user_id = u.id
          LEFT JOIN consultation_prices cp ON c.price_id = cp.id
          WHERE c.expert_id = ? 
          ORDER BY c.created_at DESC";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $expert_id);
mysqli_stmt_execute($stmt);
$consultations = mysqli_stmt_get_result($stmt);

?>
<section class="dashboard" style="margin-right: -4rem;">
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
                        <a href="expert-consultations.php" class="active"><i class="fas fa-comments"></i>
                            <h5>إدارة الاستشارات</h5>
                        </a>
                    </li>
                    <li>
                        <a href="expert-prices.php"><i class="fas fa-comments"></i>
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
            <h2 class="dashboard-main-title">لوحة تحكم الخبير</h2>
            <!-- Expert stats and activities will go here -->
            <div class="stats-container">
                <div class="stat-card">
                    <h3>الاستشارات الجديدة</h3>
                    <p class="stat-number"><?= mysqli_num_rows($consultations) ?></p>
                </div>
                <div class="stat-card">
                    <h3>إجمالي الايرادات</h3>
                    <?php
                    $total_revenue = 0;
                    $all_consultations = [];
                    while ($row = mysqli_fetch_assoc($consultations)) {
                        $all_consultations[] = $row;
                        // Calculate total revenue from paid consultations  
                        if ($row['payment_status'] === 'payment_paid') {
                            $total_revenue += $row['price'];
                        }
                    }
                    ?>
                    <p class="stat-number"><?= $total_revenue ?> ج.م</p>
                </div>
            </div>
            <div class="consultations-table">
                <table>
                    <thead>
                        <tr>
                            <th>اسم المستشير</th>
                            <th>نوع الاستشارة</th>
                            <th>السعر</th>
                            <th>المدة</th>
                            <th>تاريخ الطلب</th>
                            <th>رقم الهاتف</th>
                            <th>حالة الدفع</th>
                            <th>حالة الاستشارة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($all_consultations)): ?>
                            <?php foreach ($all_consultations as $consultation): ?>
                                <tr>
                                    <td data-label="اسم المستشير">
                                        <?= htmlspecialchars($consultation['firstname'] . ' ' . $consultation['lastname']) ?>
                                    </td>
                                    <td data-label="نوع الاستشارة">
                                        <?= htmlspecialchars($consultation['consultation_type']) ?>
                                    </td>
                                    <td data-label="السعر">
                                        <?= htmlspecialchars($consultation['price']) ?> ج.م
                                    </td>
                                    <td data-label="المدة">
                                        <?= htmlspecialchars($consultation['duration']) ?> دقيقة
                                    </td>
                                    <td data-label="تاريخ الطلب">
                                        <?= date('Y/m/d', strtotime($consultation['created_at'])) ?>
                                    </td>
                                    <td data-label="رقم الهاتف">
                                        <?= htmlspecialchars($consultation['phone']) ?>
                                    </td>
                                    <td data-label="حالة الدفع">
                                        <span class="status-badge <?= $consultation['payment_status'] ?>">
                                            <?= htmlspecialchars($consultation['payment_status']) ?>
                                        </span>
                                    </td>
                                    <td data-label="الحالة">
                                        <span class="status <?= $consultation['status'] ?>">
                                            <?= htmlspecialchars($consultation['status']) ?>
                                        </span>
                                    </td>
                                    <td data-label="الإجراءات">
                                        <a href="view-consultation.php?id=<?= $consultation['id'] ?>"
                                            class="dashboard-btn sm">عرض التفاصيل</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="10" style="text-align: center;">لا توجد استشارات حالياً</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </main>
    </div>
</section>

<?php include 'inc/footer.php' ?>