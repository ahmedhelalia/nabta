<?php
require 'inc/header.php';
?>
<section class="contact-section">
    <div class="container">
        <div class="contact-header">
            <h2 class="contact-title">
                <i class="fa-solid fa-headset"></i> تواصل <span>معنا</span>
            </h2>
            <p class="contact-subtitle">نحن هنا لمساعدتك ونسعد بتواصلك معنا</p>
            <div class="contact-social">
                <a href="https://facebook.com" target="_blank" aria-label="Facebook">
                    <i class="fab fa-facebook"></i>
                </a>
                <a href="https://linkedin.com" target="_blank" aria-label="LinkedIn">
                    <i class="fab fa-linkedin"></i>
                </a>
                <a href="https://instagram.com" target="_blank" aria-label="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://youtube.com" target="_blank" aria-label="YouTube">
                    <i class="fab fa-youtube"></i>
                </a>
                <a href="https://twitter.com" target="_blank" aria-label="Twitter">
                    <i class="fab fa-twitter"></i>
                </a>
            </div>
        </div>

        <div class="contact-wrapper">
            <div class="contact-image">
                <img src="<?= ROOT ?>/assets/website_images/IMG-20250203-WA0130.jpg" alt="Contact Us">
            </div>
            <div class="contact-form-wrapper">
                <form class="contact-form" action="" method="POST">
                    <div class="form-group">
                        <input type="text" name="name" id="name" placeholder="الاسم" required>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" id="email" placeholder="البريد الإلكتروني" required>
                    </div>
                    <div class="form-group">
                        <textarea name="message" id="message" placeholder="رسالتك" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="submit-btn">إرسال الرسالة</button>
                </form>
            </div>
        </div>
    </div>
</section>
<?php require 'inc/footer.php'; ?>