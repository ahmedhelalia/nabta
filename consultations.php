<?php
include 'inc/header.php';
// Fetch experts from database
$query = "SELECT u.*, ep.* 
          FROM users u
          INNER JOIN expert_profiles ep ON u.id = ep.expert_id
          WHERE u.user_role = 'expert'";
$experts = mysqli_query($conn, $query);
?>

<section class="consultations-section">
    <div class="hero-banner">
        <h1>الاستشارات الأسرية</h1>
        <p>نقدم خدمات استشارية متخصصة لمساعدتك في بناء حياة أسرية سعيدة ومستقرة</p>
    </div>

    <div class="consultation-categories">
        <!-- Pre-marriage Category -->
        <div class="consultations-category-card">
            <div class="consultations-category-icon">
                <i class="fas fa-heart"></i>
            </div>
            <h3>استشارات ما قبل الزواج</h3>
            <ul>
                <li>التعرف على الذات وتحديد الأهداف</li>
                <li>معايير اختيار شريك الحياة</li>
                <li>الاستعداد النفسي للزواج</li>
            </ul>
            <a href="#experts-section" class="book-btn">احجز استشارة</a>
        </div>

        <!-- Marriage Category -->
        <div class="consultations-category-card">
            <div class="consultations-category-icon">
                <i class="fas fa-users"></i>
            </div>
            <h3>استشارات زوجية</h3>
            <ul>
                <li>تحسين التواصل بين الزوجين</li>
                <li>حل المشكلات الأسرية</li>
                <li>التوازن بين الحياة الزوجية والعملية</li>
            </ul>
            <a href="#experts-section" class="book-btn">احجز استشارة</a>
        </div>

        <!-- Parenting Category -->
        <div class="consultations-category-card">
            <div class="consultations-category-icon">
                <i class="fas fa-child"></i>
            </div>
            <h3>استشارات تربوية</h3>
            <ul>
                <li>تربية الأطفال والمراهقين</li>
                <li>التعامل مع المشكلات السلوكية</li>
                <li>تعزيز الصحة النفسية للأسرة</li>
            </ul>
            <a href="#experts-section" class="book-btn">احجز استشارة</a>
        </div>
    </div>

    <div class="quick-contact">
        <h3>تحتاج مساعدة فورية؟</h3>
        <p>اتصل بنا على الخط الساخن: <strong>19123</strong></p>
        <p>أو راسلنا على البريد الإلكتروني:</p>
        <a href="mailto:support@nabta.com">support@nabta.com</a>
    </div>
    <div class="pricing-info">
        <h3>أسعار الاستشارات</h3>
        <ul>
            <li>جلسة فردية (60 دقيقة): 300 جنيه</li>
            <li>جلسة زوجية (90 دقيقة): 450 جنيه</li>
            <li>استشارة عبر الإنترنت: 200 جنيه</li>
        </ul>
    </div>
    <!-- Experts Section -->
    <div class="experts-section" id="experts-section">
        <h2 class="consultations-title" style="text-align: center;">مستشارونا المتخصصون</h2>
        <div class="experts-grid">
            <?php if (mysqli_num_rows($experts) > 0): ?>
                <?php while ($expert = mysqli_fetch_assoc($experts)): ?>
                    <div class="expert-card">
                        <div class="expert-image">
                            <img src="assets/images/<?= $expert['user_avatar'] ?>" alt="<?= htmlspecialchars($expert['first_name'] . ' ' . $expert['last_name']) ?>">
                        </div>
                        <h3 class="expert-name">د. <?= htmlspecialchars($expert['first_name'] . ' ' . $expert['last_name']) ?></h3>
                        <p class="expert-specialization"><?= htmlspecialchars($expert['specialization']) ?></p>
                        <div class="expert-actions">
                            <a href="view-expert.php?id=<?= $expert['expert_id'] ?>" class="view-profile-btn">عرض الملف الشخصي</a>
                            <?php if (!empty($expert['whatsapp'])): ?>
                                <a href="https://wa.me/<?= $expert['whatsapp'] ?>" class="whatsapp-btn">
                                    <i class="fab fa-whatsapp"></i>
                                    تواصل عبر واتساب
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="no-experts">
                    <p>لا يوجد خبراء متاحين حالياً</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>



<?php include 'inc/footer.php' ?>