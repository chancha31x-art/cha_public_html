<?php
    require('system/master.php');

    // === ตรวจสอบว่าเป็นหน้าบทความหรือไม่ ===
    $article_seo = null;
    $current_page = isset($_GET['page']) ? $_GET['page'] : '';
    $current_slug = isset($_GET['slug']) ? $_GET['slug'] : '';

    if ($current_page === 'article_detail' && !empty($current_slug)) {
        $slug_safe = $connect->real_escape_string(trim($current_slug));
        $r = $connect->query("SELECT title, meta_title, meta_description, content, img, slug FROM pp_article WHERE slug='$slug_safe' AND status=1 LIMIT 1");
        if ($r && $r->num_rows > 0) {
            $article_seo = $r->fetch_assoc();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <base href="<?= LOCAL_WEB ?>/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php
        if ($article_seo) {
            echo !empty($article_seo['meta_title'])
                ? htmlspecialchars($article_seo['meta_title'])
                : htmlspecialchars($article_seo['title']);
        } else {
            echo $web_rows['web_title'];
        }
    ?></title>
    <meta name="keywords" content="<?= $web_rows['web_keywords'] ?>">
    <meta name="description" content="<?php
        if ($article_seo) {
            echo !empty($article_seo['meta_description'])
                ? htmlspecialchars($article_seo['meta_description'])
                : htmlspecialchars(mb_substr(strip_tags($article_seo['content']), 0, 155, 'UTF-8'));
        } else {
            echo htmlspecialchars($web_rows['web_description']);
        }
    ?>">
    <meta name="author" content="APP4K">
    <meta name="robots" content="index, follow" />
    
    <!-- Canonical URL -->
    <link rel="canonical" href="<?php
        if ($article_seo) {
            echo 'https://' . $_SERVER['HTTP_HOST'] . '/article/' . htmlspecialchars($article_seo['slug']);
        } else {
            echo LOCAL_WEB . (isset($_GET['page']) && $_GET['page'] ? '/?page=' . htmlspecialchars($_GET['page']) : '/');
        }
    ?>" />
    
    <!-- Hreflang for multilingual support -->
    <link rel="alternate" hreflang="th" href="<?= LOCAL_WEB ?><?= isset($_GET['page']) && $_GET['page'] ? '/?page=' . htmlspecialchars($_GET['page']) : '/' ?>" />
    <link rel="alternate" hreflang="x-default" href="<?= LOCAL_WEB ?><?= isset($_GET['page']) && $_GET['page'] ? '/?page=' . htmlspecialchars($_GET['page']) : '/' ?>" />
    
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?php
        if ($article_seo) {
            echo 'https://' . $_SERVER['HTTP_HOST'] . '/article/' . htmlspecialchars($article_seo['slug']);
        } else {
            echo LOCAL_WEB;
        }
    ?>" />
    <meta property="og:title" content="<?php
        if ($article_seo) {
            echo !empty($article_seo['meta_title'])
                ? htmlspecialchars($article_seo['meta_title'])
                : htmlspecialchars($article_seo['title']);
        } else {
            echo 'Netflix ราคาถูก 79บาท/เดือน 4K Ultra HD | Disney+ Youtube Premium MONOMAX HBO GO VIU iQIYI WeTV Prime Video Spotify TrueID Bilibili';
        }
    ?>" />
    <meta property="og:description" content="<?php
        if ($article_seo) {
            echo !empty($article_seo['meta_description'])
                ? htmlspecialchars($article_seo['meta_description'])
                : htmlspecialchars(mb_substr(strip_tags($article_seo['content']), 0, 155, 'UTF-8'));
        } else {
            echo 'สมัครNetflix ราคาถูก 89บาท/เดือน 4k Ultra HD | ' . LOCAL_WEB;
        }
    ?>" />
    <meta property="og:image" content="<?php
        if ($article_seo && !empty($article_seo['img'])) {
            echo htmlspecialchars($article_seo['img']);
        } else {
            echo 'assets/img/ydjpg.jpg';
        }
    ?>" />

    <!-- Favicons -->
    <link href="assets/img/logo_th.ico" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.min.css" rel="stylesheet">
    <link href="assets/css/hover.css" rel="stylesheet">
    <link href="assets/css/tung.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit:wght@200;300">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <link rel="stylesheet" href="assets/css/owl/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/owl/owl.theme.default.min.css">

    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js?compat=recaptcha" async defer></script>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        body {
            font-family: 'Kanit', sans-serif !important;
            min-height: 100%;
            background: linear-gradient(90deg, rgba(175, 116, 255) 0%, rgba(218, 155, 242) 50%, rgba(249, 201, 240) 89%);
            background-blend-mode: overlay;
            background-position: center center !important;
            background-attachment: fixed !important;
            background-repeat: no-repeat !important;
            background-size: cover !important;
        }

        @media (max-width: 767px) {
            .navbar {
                background-color: #3498db;
            }
        }

        .card-hover-bg:hover {
            background-color: rgb(240, 240, 240);
        }

        .list-group-item {
            padding: 20px 20px;
        }

        canvas {
            width: 100%;
            height: 100%;
        }

        .table-responsive {
            overflow-x: visible !important;
        }

        .fb-detail {
            background-color: #fafafa;
        }

        .pointer {
            cursor: pointer;
        }

        button.acc-btn {
            display: grid;
            grid-template-columns: 1fr max-content max-content;
            align-items: center;
            grid-gap: 10px;
        }

        .background {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: -1;
        }

        .owl-carousel .owl-stage{display: flex;}
        .aticle-box {height:360px;}

        body::-webkit-scrollbar {
            width: 5px;
        }

        body::-webkit-scrollbar-track {
            background: #696969;
        }

        body::-webkit-scrollbar-thumb {
            background-color: #9655F9;
            border-radius: 2px;
        }

        .nav.navbar-nav.navbar-right li a {
            color: white;
        }

        @media (max-width: 767px) {
            .navbar-nav .nav-link {
                color: #000000;
            }
        }
        
        /* Premium Product Cards */
        .card {
            border: none;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            overflow: hidden;
        }
        
        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
            z-index: 1;
        }
        
        .card:hover::before {
            left: 100%;
        }
        
        .card:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: 0 20px 50px rgba(102, 126, 234, 0.4);
            border-bottom: 3px solid #667eea;
        }
        
        .card img {
            transition: all 0.4s ease;
            filter: brightness(0.95);
        }
        
        .card:hover img {
            transform: scale(1.15) rotate(5deg);
            filter: brightness(1.1) drop-shadow(0 0 10px rgba(102, 126, 234, 0.6));
        }
        
        .badge {
            animation: slideInRight 0.6s ease-out 0.2s both;
        }
        
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        .btn:hover {
            animation: buttonPulse 0.3s ease-out;
        }
        
        @keyframes buttonPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
    </style>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-3D6D206VNY"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-3D6D206VNY');
</script>

</head>
<body>
<?php include('include/navbar.php'); ?>

<!-- Running Text Announcement -->
<div class="announcement-banner" style="background: linear-gradient(90deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4); background-size: 400% 400%; animation: gradient 3s ease infinite; overflow: hidden; padding: 8px 5px; margin: 0; border-bottom: 2px solid rgba(255,255,255,0.3);">
    <div class="running-text" style="white-space: nowrap; overflow: hidden; animation: scroll 20s linear infinite; color: white; font-weight: bold; text-align: center; font-size: 14px; text-shadow: 1px 1px 2px rgba(0,0,0,0.7);">
        🚨 แจ้งเตือน: หากพบปัญหาการเติมเงิน กรุณาติดต่อเพจ <a href="https://web.facebook.com/xth.shops" target="_blank" style="color: #ffff00; text-decoration: none; font-weight: bold; text-shadow: 1px 1px 2px rgba(0,0,0,0.8); transition: all 0.3s ease;" onmouseover="this.style.color='#ff6b6b'; this.style.textDecoration='underline';" onmouseout="this.style.color='#ffff00'; this.style.textDecoration='none';">TH-SHOPs.COM</a> 🚨
    </div>
</div>

<!-- Premium Hero Section -->
<div class="premium-hero-section" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%); background-size: 400% 400%; animation: gradientShift 8s ease infinite; padding: 80px 20px; margin: 30px 0; border-radius: 20px; overflow: hidden; position: relative;">
    <style>
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .floating-icon {
            position: absolute;
            font-size: 60px;
            opacity: 0.15;
            animation: float 6s ease-in-out infinite;
        }
        
        .floating-icon:nth-child(1) { top: 10%; left: 5%; animation-delay: 0s; }
        .floating-icon:nth-child(2) { top: 50%; right: 10%; animation-delay: 1s; }
        .floating-icon:nth-child(3) { bottom: 20%; left: 20%; animation-delay: 2s; }
        .floating-icon:nth-child(4) { top: 30%; right: 15%; animation-delay: 1.5s; }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        
        .hero-content {
            position: relative;
            z-index: 10;
            text-align: center;
            color: white;
            animation: fadeInUp 1s ease-out;
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .hero-content h1 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 15px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            animation: slideInDown 1s ease-out 0.2s both;
        }
        
        .hero-content p {
            font-size: 1.3rem;
            margin-bottom: 30px;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.2);
            animation: slideInUp 1s ease-out 0.4s both;
        }
        
        @keyframes slideInDown {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .cta-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
            animation: zoomIn 1s ease-out 0.6s both;
        }
        
        @keyframes zoomIn {
            from { opacity: 0; transform: scale(0.8); }
            to { opacity: 1; transform: scale(1); }
        }
        
        .cta-buttons .btn {
            padding: 12px 30px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        
        .btn-primary-hero {
            background: white;
            color: #667eea;
            border: none;
        }
        
        .btn-primary-hero:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
            background: #f0f0f0;
        }
        
        .btn-secondary-hero {
            background: rgba(255,255,255,0.2);
            color: white;
            border: 2px solid white;
        }
        
        .btn-secondary-hero:hover {
            background: white;
            color: #667eea;
            transform: translateY(-3px);
        }
    </style>
    
    <div class="floating-icon">🎬</div>
    <div class="floating-icon">🎵</div>
    <div class="floating-icon">📺</div>
    <div class="floating-icon">⭐</div>
    
    <div class="hero-content">
        <h1><i class='bx bxs-star'></i> ปล่อยสตรีมมิ่งไม่อั้น</h1>
        <p>บัญชี Netflix • Disney+ • Spotify และอื่นๆ ราคาประหยัด 💎</p>
        <div class="cta-buttons">
            <button class="btn btn-primary-hero" onclick="document.querySelector('[data-bs-target=\'#byshop1\']')?.click() || window.location.hash='#shop'">
                <i class='bx bx-shopping-bag'></i> ช้อปปิ้งเลย
            </button>
            <button class="btn btn-secondary-hero" onclick="document.getElementById('chatSupportBtn').click()">
                <i class='bx bx-phone-call'></i> ติดต่อเรา
            </button>
        </div>
    </div>
</div>

<style>
@keyframes scroll {
    0% { transform: translateX(100%); }
    100% { transform: translateX(-100%); }
}

@keyframes gradient {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.announcement-banner {
    position: relative;
    z-index: 1000;
}

.announcement-banner:hover .running-text {
    animation-play-state: paused;
}

@media (max-width: 768px) {
    .announcement-banner { padding: 6px 3px !important; }
    .running-text { font-size: 12px !important; animation: scroll 25s linear infinite !important; line-height: 1.3 !important; }
}

@media (max-width: 480px) {
    .announcement-banner { padding: 5px 2px !important; }
    .running-text { font-size: 11px !important; animation: scroll 30s linear infinite !important; }
}

@media (max-width: 320px) {
    .running-text { font-size: 10px !important; animation: scroll 35s linear infinite !important; }
}
</style>

<div class="container">
    <div id="return"></div>

    <!-- Limited Time Offer Banner -->
    <div class="limited-offer-banner" style="background: linear-gradient(90deg, #ff6b6b -10%, #f093fb 25%, #667eea 75%, #45b7d1 110%); background-size: 200% 200%; animation: gradientShift 5s ease infinite; padding: 30px; border-radius: 15px; margin: 30px 0; position: relative; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; opacity: 0.1;">
            <div style="position: absolute; width: 200px; height: 200px; background: white; border-radius: 50%; top: -50px; left: -50px;"></div>
            <div style="position: absolute; width: 150px; height: 150px; background: white; border-radius: 50%; bottom: -40px; right: -40px;"></div>
        </div>
        
        <div style="position: relative; z-index: 2; text-align: center; color: white;">
            <div style="display: flex; align-items: center; justify-content: center; gap: 15px; flex-wrap: wrap; margin-bottom: 15px;">
                <span style="font-size: 2rem; animation: pulse 1.5s infinite;">🎉</span>
                <h3 style="font-size: 1.8rem; font-weight: 800; margin: 0; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">ดีลสุดพิเศษ!</h3>
                <span style="font-size: 2rem; animation: pulse 1.5s infinite; animation-delay: 0.3s;">🎁</span>
            </div>
            <p style="font-size: 1.1rem; margin: 10px 0; text-shadow: 1px 1px 2px rgba(0,0,0,0.2);">
                สมาชิกใหม่ลด <span style="font-size: 1.5rem; font-weight: 900;">15%</span> ทั้งเก็บเงิน! โปรโมชั่นจำกัด 100 คนแรกเท่านั้น
            </p>
            <div style="margin-top: 15px;">
                <button class="btn btn-light" style="padding: 10px 30px; font-weight: 600; border-radius: 50px; transition: all 0.3s ease;" 
                    onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.3)'" 
                    onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 10px rgba(0,0,0,0.2)'"
                    onclick="window.location.hash='#shop'">
                    <i class='bx bx-zap'></i> รับโปรโมชั่น
                </button>
            </div>
        </div>
        
        <style>
            @keyframes pulse {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.2); }
            }
        </style>
    </div>
    
    <!-- Trust & Security Section -->
    <div class="trust-section" style="margin: 60px 0; padding: 40px 0;">
        <h2 style="text-align: center; font-size: 2rem; font-weight: 800; margin-bottom: 40px; color: white; text-shadow: 2px 2px 4px rgba(0,0,0,0.2);">
            <i class='bx bx-shield-check'></i> ทำไมต้องเลือก TH-SHOPs?
        </h2>
        
        <style>
            .trust-card {
                background: linear-gradient(135deg, rgba(255,255,255,0.95), rgba(255,255,255,0.85));
                padding: 30px;
                border-radius: 15px;
                text-align: center;
                box-shadow: 0 8px 25px rgba(0,0,0,0.1);
                transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
                animation: slideUpFade 0.8s ease-out both;
            }
            
            @keyframes slideUpFade {
                from { opacity: 0; transform: translateY(40px); }
                to { opacity: 1; transform: translateY(0); }
            }
            
            .trust-card:hover {
                transform: translateY(-15px);
                box-shadow: 0 20px 50px rgba(102,126,234,0.3);
                border-bottom: 4px solid #667eea;
            }
            
            .trust-icon {
                font-size: 3rem;
                margin-bottom: 15px;
                animation: bounce 2s infinite;
            }
        </style>

        <div class="row justify-content-center">
            <div class="col-6 col-sm-6 col-md-3 mb-3">
                <div class="trust-card h-100">
                    <div class="trust-icon">🔒</div>
                    <h5 style="font-weight: 700; color: #333; margin-bottom: 10px;">ปลอดภัยและเชื่อถือได้</h5>
                    <p style="color: #666; font-size: 0.9rem;">บัญชีแท้ 100% รับประกันจากร้านอย่างเป็นทางการ</p>
                </div>
            </div>
            <div class="col-6 col-sm-6 col-md-3 mb-3">
                <div class="trust-card h-100">
                    <div class="trust-icon">⚡</div>
                    <h5 style="font-weight: 700; color: #333; margin-bottom: 10px;">ส่งมอบทันที</h5>
                    <p style="color: #666; font-size: 0.9rem;">ได้รับบัญชีทันที รหัส 24 ชั่วโมงแล้ว</p>
                </div>
            </div>
            <div class="col-6 col-sm-6 col-md-3 mb-3">
                <div class="trust-card h-100">
                    <div class="trust-icon">💰</div>
                    <h5 style="font-weight: 700; color: #333; margin-bottom: 10px;">ราคาประหยัด</h5>
                    <p style="color: #666; font-size: 0.9rem;">ราคาถูกที่สุด ข่าวสาร ไม่มีค่าเพิ่มเติม</p>
                </div>
            </div>
            <div class="col-6 col-sm-6 col-md-3 mb-3">
                <div class="trust-card h-100">
                    <div class="trust-icon">🎯</div>
                    <h5 style="font-weight: 700; color: #333; margin-bottom: 10px;">ช่วยเหลือ 24/7</h5>
                    <p style="color: #666; font-size: 0.9rem;">ติดต่อ Line/Telegram ได้ตลอดวัน</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">

        <?php
            if (@$_GET['page'] == "login") {
                if (!isset($_SESSION['username'])) {
                    include 'page/page_login.php';
                } else {
                    include 'page/page_home.php';
                }
            } else if (@$_GET['page'] == "register") {
                if (!isset($_SESSION['username'])) {
                    include 'page/page_register.php';
                } else {
                    include 'page/page_home.php';
                }
            } else if (@$_GET['page'] == "shop") {
                include 'page/page_shop.php';
            } else if (@$_GET['page'] == "topup") {
                if (!isset($_SESSION['username'])) {
                    include 'page/page_login.php';
                } else {
                    include 'page/page_topup.php';
                }
            } else if (@$_GET['page'] == "history") {
                if (!isset($_SESSION['username'])) {
                    include 'page/page_login.php';
                } else {
                    include 'page/page_history.php';
                }
            } else if (@$_GET['page'] == "profile") {
                if (!isset($_SESSION['username'])) {
                    include 'page/page_login.php';
                } else {
                    include 'page/page_profile.php';
                }
            } else if (@$_GET['page'] == "manage") {
                if (!isset($_SESSION['username'])) {
                    include 'page/page_login.php';
                } else {
                    if ($users_status == $admin_status) {
                        include 'page/backend/page_home.php';
                    } else {
                        include 'page/page_home.php';
                    }
                }
            } else if (@$_GET['page'] == "contact") {
                include 'page/page_contact.php';
            } else if (@$_GET['page'] == "article") {
                include 'page/page_article.php';
            } else if (@$_GET['page'] == "article_detail") {
                include 'page/page_article_detail.php';
            } else if (@$_GET['page'] == "manage_article") {
                if (!isset($_SESSION['username'])) {
                    include 'page/page_login.php';
                } else {
                    if ($users_status == $admin_status) {
                        include 'page/backend/page_admin_article.php';
                    } else {
                        include 'page/page_home.php';
                    }
                }
            } else if (!preg_match('/^[a-zA-Z0-9\_]*$/', @$_GET['page'])) {
                include 'page/page_home.php';
            } else {
                include 'page/page_home.php';
            }
        ?>

        <?php if (!isset($_GET['page']) || $_GET['page'] == '' || $_GET['page'] == 'home'): ?>
        <?php include('page/page_home_article_faq.php'); ?>
        <?php endif; ?>

        <div class="col-md-12 col-sm-12 mt-4 text-center text-white">
            <h5 class="text-white">
                <spen class="hvr-icon-up pointer" onclick="CradURL('<?=$web_rows['web_facebook']?>')" target="_blank"><i class="fa-brands fa-facebook hvr-icon"></i> Facebook</spen>
                    &nbsp; &nbsp;
                <spen class="hvr-icon-up pointer" onclick="CradURL('<?=$web_rows['web_line']?>')" target="_blank"><i class="fa-brands fa-telegram hvr-icon"></i> Telegram</spen>
            </h5>
                
            <p>&copy; <?php echo date('Y'); ?> <?=$web_rows['web_name']?> · Dev By |  <a style="text-decoration: none;color:#fff;" href="https://web.facebook.com/xth.shops">禅茶 Chánchá</a></p>
        </div>

    </div>
</div>

<!-- Back to top button -->
<p id="button"></p>

<!-- Chat Support Buttons -->
<div id="chatSupportBtn" onclick="openChatSupport()" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999; cursor: pointer; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 20px rgba(102,126,234,0.5), 0 0 30px rgba(102,126,234,0.3); animation: pulse 2s infinite, float 3s ease-in-out infinite; transition: all 0.3s ease; user-select: none;">
    <i class="fab fa-facebook-messenger" style="color: white; font-size: 28px; pointer-events: none; position: relative; z-index: 10;"></i>
    <div style="position: absolute; width: 100%; height: 100%; border-radius: 50%; border: 2px solid rgba(102,126,234,0.5); animation: ripple-pulse 1.5s infinite;"></div>
</div>

<!-- Telegram Chat -->
<div id="telegramChatBtn" onclick="openTelegramChat()" style="position: fixed; bottom: 90px; right: 20px; z-index: 9999; cursor: pointer; background: linear-gradient(135deg, #0088cc 0%, #005577 100%); width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 20px rgba(0,136,204,0.5), 0 0 30px rgba(0,136,204,0.3); animation: pulse 2s infinite 0.3s, float 3s ease-in-out infinite 0.3s; transition: all 0.3s ease; user-select: none;">
    <i class="fab fa-telegram-plane" style="color: white; font-size: 28px; pointer-events: none; position: relative; z-index: 10;"></i>
    <div style="position: absolute; width: 100%; height: 100%; border-radius: 50%; border: 2px solid rgba(0,136,204,0.5); animation: ripple-pulse 1.5s infinite 0.3s;"></div>
</div>

<!-- Chat Tooltips -->
<div id="chatTooltip" style="position: fixed; bottom: 85px; right: 20px; z-index: 9998; background: rgba(0,0,0,0.9); color: white; padding: 8px 12px; border-radius: 20px; font-size: 14px; white-space: nowrap; opacity: 0; pointer-events: none; transition: all 0.3s ease; transform: translateY(10px); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1);">
    💬 Messenger
</div>

<div id="telegramTooltip" style="position: fixed; bottom: 155px; right: 20px; z-index: 9998; background: rgba(0,0,0,0.9); color: white; padding: 8px 12px; border-radius: 20px; font-size: 14px; white-space: nowrap; opacity: 0; pointer-events: none; transition: all 0.3s ease; transform: translateY(10px); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1);">
    📱 Telegram
</div>

<style>
@keyframes ripple-pulse {
    0% { transform: scale(1); opacity: 1; }
    100% { transform: scale(1.5); opacity: 0; }
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

#chatSupportBtn:hover,
#telegramChatBtn:hover {
    transform: scale(1.15);
    box-shadow: 0 8px 30px rgba(0,0,0,0.4), 0 0 50px rgba(102,126,234,0.6);
}

@media (max-width: 768px) {
    #chatSupportBtn { bottom: 15px; right: 15px; width: 50px; height: 50px; }
    #chatSupportBtn i { font-size: 24px; }
    #chatTooltip { bottom: 70px; right: 15px; font-size: 12px; }
    #telegramChatBtn { bottom: 75px; right: 15px; width: 50px; height: 50px; }
    #telegramChatBtn i { font-size: 24px; }
    #telegramTooltip { bottom: 130px; right: 15px; font-size: 12px; }
}
</style>

  <canvas class="background"></canvas>
    <script src="assets/js/particles.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <?php
    if (@$_GET['page'] != "spin") {
        echo '<script src="assets/js/jquery-3.4.1.min.js"></script>';
    }
    ?>
    <script src="assets/js/a.js?<?= time() ?>"></script>
    <?php if (@$users_status == $admin_status) : ?>
        <script src="assets/js/app.js"></script>
    <?php endif; ?>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script src="assets/css/owl/owl.carousel.min.js"></script>   

    <script>
        var btn = $('#button');

        $(window).scroll(function() {
            if ($(window).scrollTop() > 300) {
                btn.addClass('show');
            } else {
                btn.removeClass('show');
            }
        });

        btn.on('click', function(e) {
            e.preventDefault();
            $('html, body').animate({scrollTop:0}, '300');
        });
    </script>

    <script>
    $('#tbl_users1').dataTable({
        "order": [[0, 'desc']],
        "columnDefs": [{"className": "dt-center", "targets": "_all"}],
        "oLanguage": {
            "sLengthMenu": "แสดง _MENU_ เร็คคอร์ด ต่อหน้า",
            "sZeroRecords": "ไม่เจอข้อมูลที่ค้นหา",
            "sInfo": "แสดง _START_ ถึง _END_ ของ _TOTAL_ เร็คคอร์ด",
            "sInfoEmpty": "แสดง 0 ถึง 0 ของ 0 เร็คคอร์ด",
            "sInfoFiltered": "(จากเร็คคอร์ดทั้งหมด _MAX_ เร็คคอร์ด)",
            "sSearch": "ค้นหา :",
            "oPaginate": {
                "sFirst": "หน้าแรก",
                "sPrevious": "ก่อนหน้า",
                "sNext": "ถัดไป",
                "sLast": "หน้าสุดท้าย"
            }
        }
    });
    </script>

    <script>
        function get_page(url) {
            window.location.href = url;
        }
        AOS.init();
    </script>

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 200,
                'width': '100%',
            });
        });

        var particles = Particles.init({
            selector: '.background',
            color: '#6a6880'
        });

        <?php if ($_GET['page'] == "home" || $_GET['page'] == "pshop" || $_GET['page'] == "shop") : ?>
            UpdateStock();
        <?php endif; ?>

        var owl = $('.owl-carousel');
        owl.owlCarousel({
            items:4,
            loop:true,
            margin:0,
            autoplay:true,
            autoplayTimeout:3000,
            autoplayHoverPause:true,
            responsiveClass:true,
            responsive:{
                0:{ items:1 },
                600:{ items:3 },
                1000:{ items:4 }
            }
        });
        $('.play').on('click',function(){ owl.trigger('play.owl.autoplay',[2000]) });
        $('.stop').on('click',function(){ owl.trigger('stop.owl.autoplay') });

        function CradURL(url){
            location.href = url;
        }

        function pls_login() {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'กรุณาเข้าสู่ระบบก่อนสั่งซื้อ.',
                showConfirmButton: false,
                timer: 2100
            })
        }

        function openChatSupport() {
            try {
                window.open('https://m.me/587191811137461', '_blank', 'noopener,noreferrer');
            } catch(e) {
                window.location.href = 'https://m.me/587191811137461';
            }
        }

        function openTelegramChat() {
            try {
                window.open('https://t.me/chancha31x', '_blank', 'noopener,noreferrer');
            } catch(e) {
                window.location.href = 'https://t.me/chancha31x';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const chatBtn = document.getElementById('chatSupportBtn');
            const telegramBtn = document.getElementById('telegramChatBtn');
            
            if (chatBtn) {
                chatBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    openChatSupport();
                });
                chatBtn.addEventListener('mouseenter', function() {
                    const tooltip = document.getElementById('chatTooltip');
                    if (tooltip) { tooltip.style.opacity = '1'; tooltip.style.transform = 'translateY(0)'; }
                });
                chatBtn.addEventListener('mouseleave', function() {
                    const tooltip = document.getElementById('chatTooltip');
                    if (tooltip) { tooltip.style.opacity = '0'; tooltip.style.transform = 'translateY(10px)'; }
                });
            }

            if (telegramBtn) {
                telegramBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    openTelegramChat();
                });
                telegramBtn.addEventListener('mouseenter', function() {
                    const tooltip = document.getElementById('telegramTooltip');
                    if (tooltip) { tooltip.style.opacity = '1'; tooltip.style.transform = 'translateY(0)'; }
                });
                telegramBtn.addEventListener('mouseleave', function() {
                    const tooltip = document.getElementById('telegramTooltip');
                    if (tooltip) { tooltip.style.opacity = '0'; tooltip.style.transform = 'translateY(10px)'; }
                });
            }
        });

        $(document).ready(function() {
            $('#chatSupportBtn').off('click').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                openChatSupport();
                return false;
            });
            $('#telegramChatBtn').off('click').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                openTelegramChat();
                return false;
            });
        });
    </script>

    <script type="text/javascript" charset="utf-8">
        $(document).ready(function() {
            $('#tbl_topuphistory').dataTable({
                "order": [[0, 'desc']],
                "columnDefs": [{"className": "dt-center", "targets": "_all"}],
                "oLanguage": {
                    "sLengthMenu": "แสดง _MENU_ เร็คคอร์ด ต่อหน้า",
                    "sZeroRecords": "ไม่เจอข้อมูลที่ค้นหา",
                    "sInfo": "แสดง _START_ ถึง _END_ ของ _TOTAL_ เร็คคอร์ด",
                    "sInfoEmpty": "แสดง 0 ถึง 0 ของ 0 เร็คคอร์ด",
                    "sInfoFiltered": "(จากเร็คคอร์ดทั้งหมด _MAX_ เร็คคอร์ด)",
                    "sSearch": "ค้นหา :",
                    "oPaginate": {
                        "sFirst": "หน้าแรก", "sPrevious": "ก่อนหน้า",
                        "sNext": "ถัดไป", "sLast": "หน้าสุดท้าย"
                    }
                }
            });

            $('#tbl_topuphistory2').dataTable({
                "order": [[0, 'desc']],
                "columnDefs": [{"className": "dt-center", "targets": "_all"}],
                "oLanguage": {
                    "sLengthMenu": "แสดง _MENU_ เร็คคอร์ด ต่อหน้า",
                    "sZeroRecords": "ไม่เจอข้อมูลที่ค้นหา",
                    "sInfo": "แสดง _START_ ถึง _END_ ของ _TOTAL_ เร็คคอร์ด",
                    "sInfoEmpty": "แสดง 0 ถึง 0 ของ 0 เร็คคอร์ด",
                    "sInfoFiltered": "(จากเร็คคอร์ดทั้งหมด _MAX_ เร็คคอร์ด)",
                    "sSearch": "ค้นหา :",
                    "oPaginate": {
                        "sFirst": "หน้าแรก", "sPrevious": "ก่อนหน้า",
                        "sNext": "ถัดไป", "sLast": "หน้าสุดท้าย"
                    }
                }
            });

            <?php if (@$users_status == $admin_status) : ?>
                $('#tbl_shopapi').dataTable({
                    "order": [[0, 'desc']],
                    "columnDefs": [{"className": "dt-center", "targets": "_all"}],
                    "oLanguage": {
                        "sLengthMenu": "แสดง _MENU_ เร็คคอร์ด ต่อหน้า",
                        "sZeroRecords": "ไม่เจอข้อมูลที่ค้นหา",
                        "sInfo": "แสดง _START_ ถึง _END_ ของ _TOTAL_ เร็คคอร์ด",
                        "sInfoEmpty": "แสดง 0 ถึง 0 ของ 0 เร็คคอร์ด",
                        "sInfoFiltered": "(จากเร็คคอร์ดทั้งหมด _MAX_ เร็คคอร์ด)",
                        "sSearch": "ค้นหา :",
                        "oPaginate": {
                            "sFirst": "หน้าแรก", "sPrevious": "ก่อนหน้า",
                            "sNext": "ถัดไป", "sLast": "หน้าสุดท้าย"
                        }
                    }
                });

                $('#tbl_stock').dataTable({
                    "order": [[0, 'asc']],
                    "columnDefs": [{"className": "dt-center", "targets": "_all"}],
                    "oLanguage": {
                        "sLengthMenu": "แสดง _MENU_ เร็คคอร์ด ต่อหน้า",
                        "sZeroRecords": "ไม่เจอข้อมูลที่ค้นหา",
                        "sInfo": "แสดง _START_ ถึง _END_ ของ _TOTAL_ เร็คคอร์ด",
                        "sInfoEmpty": "แสดง 0 ถึง 0 ของ 0 เร็คคอร์ด",
                        "sInfoFiltered": "(จากเร็คคอร์ดทั้งหมด _MAX_ เร็คคอร์ด)",
                        "sSearch": "ค้นหา :",
                        "oPaginate": {
                            "sFirst": "หน้าแรก", "sPrevious": "ก่อนหน้า",
                            "sNext": "ถัดไป", "sLast": "หน้าสุดท้าย"
                        }
                    }
                });

                var xValues = [
                    <?php
                    function randomHex() {
                        $chars = 'ABCDEF0123456789';
                        $color = '#';
                        for ($i = 0; $i < 6; $i++) {
                            $color .= $chars[rand(0, strlen($chars) - 1)];
                        }
                        return $color;
                    }
                    $result_chart = $connect->query("SELECT * FROM pum_product ");
                    $shop_fetch_charts = $result_chart->fetch_all(MYSQLI_ASSOC);
                    foreach ($shop_fetch_charts as $shop_fetch_chart) :
                        echo '"' . $shop_fetch_chart['name'] . '",';
                    endforeach; ?>
                ];
                var yValues = [
                    <?php foreach ($shop_fetch_charts as $shop_fetch_chart) :
                        $stock_count_charts = $connect->query('SELECT * FROM `pum_product_stock` WHERE `product_id` = "' . $shop_fetch_chart['id'] . '" ')->num_rows;
                        echo $stock_count_charts . ',';
                    endforeach; ?>
                ];
                var barColors = [
                    <?php foreach ($shop_fetch_charts as $shop_fetch_chart) :
                        echo '"' . randomHex() . '",';
                    endforeach; ?>
                ];

                new Chart("myChart", {
                    type: "doughnut",
                    data: {
                        labels: xValues,
                        datasets: [{ backgroundColor: barColors, data: yValues }]
                    },
                    options: {
                        title: { display: true, text: "กราฟแสดง stock สินต้า หน้าเว็บ" }
                    }
                });
            <?php endif; ?>
        });
    </script>

</body>
</html>