<?php include 'inc/header.php' ?>
<section class="hero-section">
    <div class="hero-content">
        <h1>نبتة - لبناء أسرة متماسكة وسعيدة</h1>
        <p>خدمات استشارية وتعليمية لتعزيز العلاقات الأسرية والزوجية</p>
        <a href="#services" class="cta-button">استكشف خدماتنا</a>
    </div>
</section>
<!-- Services Section with Enhanced Design -->
<section class="services-section" id="services">
    <h2 class="section-title-home">خدماتنا</h2>

    <div class="services-grid">
        <div class="service-card">
            <div class="service-icon"><i class="fas fa-comments"></i></div>
            <h3>استشارات زوجية</h3>
            <p>جلسات استشارية مع خبراء متخصصين لمساعدتكم في تجاوز التحديات الزوجية</p>
            <a href="consultations.php" class="service-button">تفاصيل أكثر</a>
        </div>

        <div class="service-card">
            <div class="service-icon"><i class="fas fa-book-open"></i></div>
            <h3>مقالات ودروس تعليمية</h3>
            <p>محتوى تعليمي عالي الجودة يساعد في فهم ديناميكيات العلاقات الأسرية</p>
            <a href="articles.php" class="service-button">استعرض المقالات</a>
        </div>

        <div class="service-card">
            <div class="service-icon"><i class="fas fa-users"></i></div>
            <h3>منتدى النقاش</h3>
            <p>منصة تفاعلية لطرح الأسئلة ومشاركة التجارب مع مجتمع داعم</p>
            <a href="community.php" class="service-button">انضم للمنتدى</a>
        </div>

        <div class="service-card">
            <div class="service-icon"><i class="fas fa-graduation-cap"></i></div>
            <h3>دورات تدريبية</h3>
            <p>برامج تدريبية متخصصة لتنمية المهارات الأسرية والزوجية</p>
            <a href="courses.php" class="service-button">تصفح الدورات</a>
        </div>
    </div>
</section>

<!-- Family Growth Stages Section -->
<section class="stages-section">
    <h2 class="section-title-home">مراحل نمو وتطور الأسرة</h2>
    <div class="stages-container">
        <div class="stage-card">
            <img src="courses_images/1 (1).jpg" alt="مرحلة ما قبل الزواج">
            <div class="stage-content">
                <h3>مرحلة ما قبل الزواج</h3>
                <p>"هي فترة التعارف والتخطيط للحياة الزوجية"</p>
                <a href="stage1.html" class="read-more-btn">اقرأ المزيد</a>
            </div>
        </div>

        <div class="stage-card">
            <img src="courses_images/1 (2).jpg" alt="مرحلة ما بعد الزواج">
            <div class="stage-content">
                <h3>مرحلة ما بعد الزواج</h3>
                <p>"هي فترة التكيف والنمو المشترك"</p>
                <a href="stage2.html" class="read-more-btn">اقرأ المزيد</a>
            </div>
        </div>

        <div class="stage-card">
            <img src="courses_images/1 (1).jpeg" alt="مرحلة ما بعد الطفولة">
            <div class="stage-content">
                <h3>مرحلة ما بعد الطفولة</h3>
                <p>"تشمل فترة المراهقة والشباب"</p>
                <a href="stage3.html" class="read-more-btn">اقرأ المزيد</a>
            </div>
        </div>
    </div>
</section>
<section class="testimonials-section">
    <h2 class="section-title-home">آراء المستفيدين</h2>

    <div class="testimonials-slider">
        <div class="testimonial-card">
            <div class="quote-icon"><i class="fas fa-quote-right"></i></div>
            <p class="testimonial-text">لقد استفدنا كثيراً من الاستشارات الزوجية، وتغيرت حياتنا للأفضل بعد تطبيق النصائح والإرشادات.</p>
            <div class="testimonial-author">أحمد وسارة</div>
        </div>

        <div class="testimonial-card">
            <div class="quote-icon"><i class="fas fa-quote-right"></i></div>
            <p class="testimonial-text">المقالات التعليمية ساعدتني كثيراً في فهم سلوكيات أطفالي وكيفية التعامل معهم بطريقة صحيحة.</p>
            <div class="testimonial-author">منى عبدالله</div>
        </div>

        <div class="testimonial-card">
            <div class="quote-icon"><i class="fas fa-quote-right"></i></div>
            <p class="testimonial-text">الدورة التدريبية كانت مفيدة جداً وغيرت الكثير من مفاهيمي عن الحياة الزوجية.</p>
            <div class="testimonial-author">خالد محمود</div>
        </div>
    </div>
</section>
<?php if(!isset($_SESSION['USER'])): ?>
<section class="cta-section">
    <div class="cta-content">
        <h2>ابدأ رحلة تطوير أسرتك الآن</h2>
        <p>سجل في موقعنا واحصل على استشارة مجانية مع أحد خبرائنا</p>
        <a href="signup.php" class="cta-button-large">سجل الآن</a>
    </div>
</section>
<?php endif; ?>
<?php if (isset($_SESSION['USER']) && $user_expert === 'expert'): ?>
    <div class="expert-alert">
        <div class="expert-alert-content">
            <i class="fas fa-user-md"></i>
            <h3>مرحباً بك كخبير في منصتنا</h3>
            <p>نرحب بمشاركة خبراتك مع مجتمعنا. للبدء في تقديم خدماتك الاستشارية، يرجى التواصل معنا</p>
            <a href="contact.php" class="expert-alert-button">تواصل معنا</a>
        </div>
    </div>
<?php endif; ?>
<section class="index-stats-section">
    <h2 class="section-title-home">تأثيرنا</h2>

    <div class="index-stats-container">
        <div class="index-stat-card">
            <div class="index-stat-number">1000+</div>
            <div class="index-stat-title">استشارة</div>
        </div>

        <div class="index-stat-card">
            <div class="index-stat-number">50+</div>
            <div class="index-stat-title">دورة تدريبية</div>
        </div>

        <div class="index-stat-card">
            <div class="index-stat-number">200+</div>
            <div class="index-stat-title">مقال تعليمي</div>
        </div>

        <div class="index-stat-card">
            <div class="index-stat-number">5000+</div>
            <div class="index-stat-title">مستخدم مسجل</div>
        </div>
    </div>
</section>
<div class="chat-widget">
    <div class="chat-button">
        <i class="fas fa-comments"></i>
    </div>
    <div class="chat-container">
        <div class="chat-header">
            <h3>نبتة - المساعد الآلي</h3>
        </div>
        <div class="chat-messages">
            <div class="message bot-message">
                مرحباً بك! كيف يمكنني مساعدتك اليوم؟
            </div>
        </div>
        <div class="chat-input">
            <input type="text" placeholder="اكتب رسالتك هنا...">
            <button>إرسال</button>
        </div>
    </div>
</div>
<?php include 'inc/footer.php' ?>