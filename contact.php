<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Custom stylesheet -->
    <link rel="stylesheet" href="assets/css/contact.css">
     <!-- ICONSCOUNT CDN -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <!-- BOOTSTRAP ICONS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>Nabta</title>
</head>

<body>
    <!-- Start Of Nav Bar -->
    <nav>
        <div class="nav_container">
            <a href="index.php" class="nav_logo">Nabta</a>
            <ul class="nav_items">
                <li><a href="about.html">عنا</a></li>
                <li class="nav_categories">
                    <div class="sections">
                        الخدمات
                    </div>
                    <ul>
                        <li><a href="beforeMarriage.php">ما قبل الزواج</a></li>
                        <li><a href="afterMarriage.php">ما بعد الزواج</a></li>
                        <li><a href="childhood.php">مرحلة الطفولة</a></li>
                        <li><a href="teenage.php">مرحلة المراهقة</a></li>
                    </ul>
                </li>
                <li><a href="community.php">المنتدى</a></li>
               
                <li><a href="index.php">الرئيسية</a></li>
                <?php if(isset($_SESSION['USER'])): ?>
                    <li style="margin-right: 40px;" class="nav_profile">
                    <div class="avatar">
                        <img src="<?= ROOT ?>/assets/images/<?= $user_avatar['user_avatar'] ?>" alt="broken">
                    </div>
                    <ul>
                        <li><a href="profile.php">الاعدادات</a></li>
                        <li><a href="logout.php">الخروج</a></li>
                    </ul>
                </li>
                <?php else: ?>
                <li style="margin-right: 90px;"><a href="signup.php">تسجيل</a></li>
                <?php endif; ?>


            </ul>
        </div>
    </nav>
    
    <section style="margin-top: 100px;" id="contact">
        <div class="title-section">
            <h2 class="title">
                <i class="fa-solid fa-headset"></i> Get In <span class="text-primary">Touch</span>
            </h2>
            <div class="contact">
                <div class="social">
                    <a href="https://facebook.com" target="_blank">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="https://linkedin.com" target="_blank">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    <a href="https://instagram.com" target="_blank">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://youtube.com" target="_blank">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="https://twitter.com" target="_blank">
                        <i class="fab fa-twitter"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="image-container">
                    <img src="assets/website_images/IMG-20250203-WA0130.jpg" alt="Get In Touch">
                </div>
                <form action="">
                    <input type="text" name="Name" id="Name" placeholder="Name" required>
                    <input type="email" name="Email" id="Email" placeholder="Email" required>
                    <textarea name="Message" id="Message" cols="30" rows="5" placeholder="Message"></textarea>
                    <button type="submit" class="btn-primary">Send Message</button>
                </form>
            </div>
        </div>
    </section>
    <footer>
        <div class="footer_socials">
            <a href="https://youtube.com/" target="_blank"><i class="uil uil-youtube"></i></a>
            <a href="https://facebook.com/" target="_blank"><i class="uil uil-facebook-f"></i></a>
            <a href="https://instagram.com/" target="_blank"><i class="uil uil-instagram-alt"></i></a>
            <a href="https://twitter.com/" target="_blank"><i class="uil uil-twitter"></i></a>
        </div>
        <div class="footer_container">
            <article>
                <h4>خدمات</h4>
                <ul>
                    <li><a href="beforeMarriage.php">ما قبل الزواج</a></li>
                    <li><a href="afterMarriage.php">ما بعد الزواج</a></li>
                    <li><a href="childhood.php">مرحلة الطفولة</a></li>
                    <li><a href="teenage.php">مرحلة المراهقة</a></li>
                </ul>
            </article>
            <article>
                <h4>الدعم</h4>
                <ul>
                    <li><a href="">Online Support</a></li>
                    <li><a href="">Call Numbers</a></li>
                    <li><a href="">Emails</a></li>
                    <li><a href="">Location</a></li>
                </ul>
            </article>
            <article>
                <h4>الروابط</h4>
                <ul>
                    <li><a href="index.php">الرئيسية</a></li>
                    <li><a href="community.php">المنتدى</a></li>
                    <li><a href="about.php">عنا</a></li>
                    <li><a href="">الخدمات</a></li>
                    <li><a href="contact.php">تواصل معنا</a></li>
                </ul>
            </article>
        </div>
        <div class="footer_copyright">
            <small>Copyright &copy; Nabta 2025 All Rights Reserved</small>
        </div>
      </footer>
</body>
</html>
