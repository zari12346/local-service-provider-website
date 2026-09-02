<?php
session_start();
// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_email']);
$userEmail = $isLoggedIn ? $_SESSION['user_email'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>LocalConnect | User Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* ========== ALL YOUR EXISTING STYLES HERE (keeping same) ========== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #D6E4FF 0%, #84A9FF 100%);
            min-height: 100vh;
            color: #1A2E55;
        }
        
        /* Page Container */
        .page-container {
            display: none;
            animation: fadeIn 0.5s ease-out;
        }
        
        .active-page {
            display: block;
        }
        
        /* Header Styles */
        header {
            background-color: rgba(245, 249, 255, 0.95);
            box-shadow: 0 2px 15px rgba(26, 46, 85, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 5%;
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .logo i {
            font-size: 28px;
            color: #3366FF;
        }
        
        .logo h1 {
            font-size: 24px;
            font-weight: 700;
            color: #1A2E55;
        }
        
        .logo span {
            color: #3366FF;
        }
        
        nav ul {
            display: flex;
            list-style: none;
            gap: 30px;
        }
        
        nav a {
            text-decoration: none;
            color: #1A2E55;
            font-weight: 500;
            transition: color 0.3s ease;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        
        nav a:hover {
            color: #3366FF;
            background-color: rgba(51, 102, 255, 0.1);
        }
        
        /* Dropdown Styles */
        .dropdown {
            position: relative;
            display: inline-block;
        }
        
        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: white;
            min-width: 200px;
            box-shadow: 0 8px 16px rgba(26, 46, 85, 0.15);
            border-radius: 8px;
            padding: 8px 0;
            z-index: 1000;
            border: 1px solid #D6E4FF;
        }
        
        .dropdown:hover .dropdown-menu {
            display: block;
        }
        
        .dropdown-menu li {
            list-style: none;
        }
        
        .dropdown-menu a {
            display: block;
            padding: 10px 20px;
            color: #1A2E55;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.2s;
            white-space: nowrap;
        }
        
        .dropdown-menu a:hover {
            background-color: #D6E4FF;
            color: #3366FF;
        }
        
        .nav-link i {
            font-size: 0.8rem;
            margin-left: 5px;
            transition: transform 0.2s;
        }
        
        .dropdown:hover .nav-link i {
            transform: rotate(180deg);
        }
        
        .cta-button {
            background-color: #3366FF;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .cta-button:hover {
            background-color: #1A2E55;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(26, 46, 85, 0.2);
        }
        
        /* Yellow Join as Pro Button */
        .yellow-button {
            background-color: #FFD700;
            color: #1A2E55;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 4px 12px rgba(255, 215, 0, 0.3);
        }
        
        .yellow-button:hover {
            background-color: #FFC400;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 215, 0, 0.4);
            color: #1A2E55;
        }
        
        /* Hero Section */
        .hero {
            padding: 140px 5%;
            text-align: center;
            background: 
                linear-gradient(rgba(26, 46, 85, 0.75), rgba(51, 102, 255, 0.65)),
                url('https://images.unsplash.com/photo-1556761175-5973dc0f32e7?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') center/cover;
            background-attachment: fixed;
            color: white;
            margin-bottom: 60px;
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(ellipse at center, rgba(51,102,255,0.15) 0%, transparent 70%);
            animation: heroPulse 4s ease-in-out infinite;
        }
        
        @keyframes heroPulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 1; }
        }
        
        .hero h2 {
            font-size: 3.8rem;
            margin-bottom: 20px;
            animation: heroSlideDown 1s ease-out;
            text-shadow: 2px 4px 20px rgba(0,0,0,0.3);
        }
        
        @keyframes heroSlideDown {
            from { opacity: 0; transform: translateY(-40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .hero p {
            font-size: 1.3rem;
            max-width: 700px;
            margin: 0 auto 30px;
            animation: heroSlideUp 1s ease-out 0.3s both;
        }
        
        @keyframes heroSlideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .hero .cta-button {
            animation: heroFadeIn 1s ease-out 0.6s both;
            font-size: 1.1rem;
            padding: 15px 35px;
            border-radius: 50px;
            box-shadow: 0 8px 25px rgba(51,102,255,0.4);
        }
        
        @keyframes heroFadeIn {
            from { opacity: 0; transform: scale(0.8); }
            to { opacity: 1; transform: scale(1); }
        }
        
        .hero .cta-button:hover {
            transform: translateY(-4px) scale(1.05);
            box-shadow: 0 15px 35px rgba(51,102,255,0.5);
        }
        
        /* Slideshow Section */
        .slideshow-section {
            max-width: 1200px;
            margin: 0 auto 80px;
            padding: 0 20px;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 40px;
            font-size: 2.2rem;
            color: #1A2E55;
            position: relative;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background-color: #3366FF;
            border-radius: 2px;
        }
        
        .slideshow-container {
            position: relative;
            max-width: 1000px;
            margin: 0 auto;
            overflow: hidden;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(26, 46, 85, 0.2);
        }
        
        .slides {
            display: flex;
            transition: transform 0.5s ease;
        }
        
        .slide {
            min-width: 100%;
            position: relative;
        }
        
        .slide img {
            width: 100%;
            height: 500px;
            object-fit: cover;
            display: block;
        }
        
        .slide-content {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(26, 46, 85, 0.8));
            color: white;
            padding: 30px;
        }
        
        .slide-content h3 {
            font-size: 1.8rem;
            margin-bottom: 10px;
        }
        
        .slide-content p {
            font-size: 1rem;
            max-width: 600px;
        }
        
        .slideshow-nav {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            gap: 10px;
        }
        
        .nav-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: #D6E4FF;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        
        .nav-dot.active {
            background-color: #3366FF;
        }
        
        .prev, .next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(255, 255, 255, 0.7);
            color: #1A2E55;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            font-size: 18px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            z-index: 10;
        }
        
        .prev {
            left: 20px;
        }
        
        .next {
            right: 20px;
        }
        
        .prev:hover, .next:hover {
            background-color: white;
            box-shadow: 0 5px 15px rgba(26, 46, 85, 0.2);
        }
        
        /* Services Section */
        .services-section {
            max-width: 1400px;
            margin: 0 auto 80px;
            padding: 0 20px;
        }
        
        .services-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
        }
        
        @media (max-width: 1199px) {
            .services-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        
        @media (max-width: 991px) {
            .services-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 575px) {
            .services-grid {
                grid-template-columns: 1fr;
            }
        }
        
        .service-card {
            background-color: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(26, 46, 85, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
            cursor: pointer;
        }
        
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(26, 46, 85, 0.2);
        }
        
        .service-img {
            height: 180px;
            overflow: hidden;
        }
        
        .service-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .service-card:hover .service-img img {
            transform: scale(1.1);
        }
        
        .service-content {
            padding: 20px 15px 25px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        
        .service-content h3 {
            font-size: 1.3rem;
            margin-bottom: 10px;
            color: #1A2E55;
        }
        
        .service-content p {
            color: #555;
            margin-bottom: 20px;
            line-height: 1.5;
            font-size: 0.95rem;
            flex: 1;
        }
        
        /* Footer */
        footer {
            background-color: #1A2E55;
            color: white;
            padding: 60px 5% 30px;
        }
        
        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
        }
        
        .footer-col h3 {
            font-size: 1.4rem;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }
        
        .footer-col h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background-color: #3366FF;
        }
        
        .footer-col p {
            line-height: 1.6;
            margin-bottom: 20px;
            color: #D6E4FF;
        }
        
        .footer-links {
            list-style: none;
        }
        
        .footer-links li {
            margin-bottom: 12px;
        }
        
        .footer-links a {
            color: #D6E4FF;
            text-decoration: none;
            transition: color 0.3s ease;
            cursor: pointer;
        }
        
        .footer-links a:hover {
            color: #84A9FF;
        }
        
        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        
        .social-links a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: white;
            transition: all 0.3s ease;
        }
        
        .social-links a:hover {
            background-color: #3366FF;
            transform: translateY(-5px);
        }
        
        .copyright {
            text-align: center;
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: #84A9FF;
        }
        
        /* User Info Bar */
        .user-info-bar {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .user-email {
            font-size: 0.9rem;
            color: #1A2E55;
            background: #D6E4FF;
            padding: 5px 12px;
            border-radius: 20px;
        }
        
        /* Notification Bell */
        .notification-bell {
            position: fixed;
            bottom: 28px;
            right: 28px;
            z-index: 9999;
            background: linear-gradient(135deg, #3366FF, #1A2E55);
            width: 58px;
            height: 58px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25), 0 0 0 4px rgba(255, 255, 255, 0.3);
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            text-decoration: none;
        }
        
        .notification-bell:hover {
            transform: scale(1.08) translateY(-4px);
        }
        
        .notification-bell i {
            font-size: 28px;
            color: #FFD700;
        }
        
        .bell-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            background-color: #ff4757;
            color: white;
            font-size: 12px;
            font-weight: bold;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid white;
        }
        
        .notification-panel {
            position: fixed;
            bottom: 100px;
            right: 28px;
            width: 360px;
            max-height: 500px;
            background: white;
            border-radius: 24px;
            box-shadow: 0 25px 40px rgba(26, 46, 85, 0.3);
            z-index: 9998;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transform: translateY(20px);
            opacity: 0;
            visibility: hidden;
            transition: all 0.25s ease;
            pointer-events: none;
        }
        
        .notification-panel.show {
            transform: translateY(0);
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }
        
        .panel-header {
            background: linear-gradient(95deg, #1A2E55, #3366FF);
            color: white;
            padding: 14px 18px;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .close-panel {
            background: none;
            border: none;
            color: white;
            font-size: 22px;
            cursor: pointer;
        }
        
        .notification-list {
            max-height: 420px;
            overflow-y: auto;
        }
        
        .notif-item {
            padding: 14px 18px;
            border-bottom: 1px solid #eef2ff;
            display: flex;
            gap: 14px;
            cursor: pointer;
        }
        
        .notif-item.unread {
            background: #F0F7FF;
            border-left: 4px solid #3366FF;
        }
        
        .notif-icon {
            width: 40px;
            height: 40px;
            background: #E9EFFA;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #3366FF;
        }
        
        .notif-content {
            flex: 1;
        }
        
        .notif-title {
            font-weight: 700;
            font-size: 0.95rem;
            color: #1A2E55;
        }
        
        .notif-message {
            font-size: 0.85rem;
            color: #4a627a;
        }
        
        .notif-time {
            font-size: 0.7rem;
            color: #84A9FF;
        }
        
        .empty-notif {
            text-align: center;
            padding: 40px 20px;
            color: #84A9FF;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                gap: 15px;
            }
            nav ul {
                flex-wrap: wrap;
                justify-content: center;
                gap: 15px;
            }
            .hero h2 {
                font-size: 2rem;
            }
            .hero p {
                font-size: 1rem;
            }
            .services-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 480px) {
            .services-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Notification Bell -->
    <div class="notification-bell" id="globalBellIcon">
        <i class="fas fa-bell"></i>
        <span class="bell-badge" id="bellBadge">0</span>
    </div>
    
    <div class="notification-panel" id="notificationPanel">
        <div class="panel-header">
            <span><i class="fas fa-bell"></i> Notifications</span>
            <button class="close-panel" id="closePanelBtn">&times;</button>
        </div>
        <div class="notification-list" id="notificationList">
            <div class="empty-notif">✨ No notifications yet</div>
        </div>
    </div>

    <!-- Dashboard Page -->
    <div id="dashboard-page" class="page-container active-page">
        <header>
            <div class="header-container">
                <div class="logo">
                    <i class="fas fa-hands-helping"></i>
                    <h1>Local<span>service</span></h1>
                </div>
                
                <nav>
                    <ul>
                        <li><a onclick="scrollToSection('home')">Home</a></li>
                        <li><a onclick="showAboutPage()">About Us</a></li>
                        <li class="dropdown">
                            <a class="nav-link">Services <i class="fas fa-chevron-down"></i></a>
                            <ul class="dropdown-menu">
                                <li><a onclick="bookService('Plumbing')">Plumbing</a></li>
                                <li><a onclick="bookService('Electrical')">Electrical</a></li>
                                <li><a onclick="bookService('Mechanic')">Mechanic</a></li>
                                <li><a onclick="bookService('Carpenter')">Carpenter</a></li>
                            </ul>
                        </li>
                        <li><a onclick="showContactPage()">Contact</a></li>
                        <li><a onclick="scrollToSection('blog')">Blog</a></li>
                        <?php if($isLoggedIn): ?>
                        <li><a href="my_bookings.html">My Bookings</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
                
                <div style="display:flex; align-items:center; gap:10px;">
                    <?php if($isLoggedIn): ?>
                        <div class="user-info-bar">
                            <span class="user-email"><i class="fas fa-user"></i> <?php echo htmlspecialchars($userEmail); ?></span>
                            <button id="logout-btn" class="cta-button" style="background:#dc3545;">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </div>
                    <?php else: ?>
                        <button id="join-as-pro" class="yellow-button">
                            <i class="fas fa-user-tie"></i> Join as Pro
                        </button>
                        <button id="login-button" class="cta-button">
                            Login
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="hero" id="home">
            <h2>Connecting You With Trusted Local Service Providers</h2>
            <p>Find reliable professionals for all your home service needs. From plumbing to electrical work, we've got you covered.</p>
            <button onclick="scrollToSection('services')" class="cta-button">Explore Services</button>
        </section>

        <!-- Slideshow Section -->
        <section class="slideshow-section">
            <h2 class="section-title">Our Services in Action</h2>
            <div class="slideshow-container">
                <div class="slides">
                    <div class="slide">
                        <img src="https://i.pinimg.com/1200x/ca/21/e0/ca21e0f146b2d2f8e1045684963d7a91.jpg" alt="Plumbing Service">
                        <div class="slide-content">
                            <h3>Professional Plumbing Services</h3>
                            <p>Expert plumbers ready to fix leaks, install fixtures, and handle all your plumbing needs.</p>
                        </div>
                    </div>
                    <div class="slide">
                        <img src="https://www.qanmos.com/wp-content/uploads/2024/09/electrica1.jpg" alt="Electrical Service">
                        <div class="slide-content">
                            <h3>Certified Electrical Work</h3>
                            <p>Safe and reliable electrical installations, repairs, and maintenance by licensed professionals.</p>
                        </div>
                    </div>
                    <div class="slide">
                        <img src="https://www.ozzis.com/wp-content/uploads/2017/05/Ozzis-Automotive-1_Qualities-of-a-Reputable-Japanese-Auto-Repair-Technician_IMAGE.jpeg" alt="Mechanic Service">
                        <div class="slide-content">
                            <h3>Expert Auto Mechanics</h3>
                            <p>Professional automotive repair and maintenance services to keep your vehicle running smoothly.</p>
                        </div>
                    </div>
                    <div class="slide">
                        <img src="https://i.pinimg.com/1200x/f9/72/ec/f972ec4c7c312f1254b842d91057b1bc.jpg" alt="Carpentry Service">
                        <div class="slide-content">
                            <h3>Skilled Carpentry Services</h3>
                            <p>Custom woodworking, furniture repair, and carpentry solutions for your home or business.</p>
                        </div>
                    </div>
                </div>
                <button class="prev">&#10094;</button>
                <button class="next">&#10095;</button>
            </div>
            <div class="slideshow-nav">
                <div class="nav-dot active"></div>
                <div class="nav-dot"></div>
                <div class="nav-dot"></div>
                <div class="nav-dot"></div>
            </div>
        </section>

        <!-- Services Section -->
        <section class="services-section" id="services">
            <h2 class="section-title">Our Services</h2>
            <div class="services-grid">
                <div class="service-card" onclick="bookService('Plumbing')">
                    <div class="service-img">
                        <img src="https://aquaprorooter.com/wp-content/uploads/plumber-using-wrench-on-sink.webp" alt="Plumbing">
                    </div>
                    <div class="service-content">
                        <h3>Plumbing</h3>
                        <p>From leaky faucets to complete pipe installations, our certified plumbers provide reliable solutions.</p>
                    </div>
                </div>
                <div class="service-card" onclick="bookService('Electrical')">
                    <div class="service-img">
                        <img src="https://png.pngtree.com/png-clipart/20250415/original/pngtree-electrician-connecting-wires-in-electrical-panel-isolated-on-transparent-background-png-image_20719215.png" alt="Electrical">
                    </div>
                    <div class="service-content">
                        <h3>Electrical</h3>
                        <p>Safe and efficient electrical installations, repairs, and maintenance services by licensed electricians.</p>
                    </div>
                </div>
                <div class="service-card" onclick="bookService('Mechanic')">
                    <div class="service-img">
                        <img src="https://i.pinimg.com/736x/6b/c6/d8/6bc6d874eda0f123a5dfff33cd0c15b2.jpg" alt="Mechanic">
                    </div>
                    <div class="service-content">
                        <h3>Mechanic</h3>
                        <p>Professional automotive repair and maintenance services to keep your vehicle running smoothly.</p>
                    </div>
                </div>
                <div class="service-card" onclick="bookService('Carpenter')">
                    <div class="service-img">
                        <img src="https://www.shutterstock.com/image-photo/carpenter-worker-work-carpentry-workshop-260nw-1924568537.jpg" alt="Carpenter">
                    </div>
                    <div class="service-content">
                        <h3>Carpenter</h3>
                        <p>Custom woodworking, furniture repair, and carpentry solutions for your home or business needs.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Blog Section -->
        <section class="blog-section" id="blog" style="max-width:1400px; margin:0 auto 80px; padding:0 20px;">
            <h2 class="section-title">Latest From Our Blog</h2>
            <div class="services-grid" style="grid-template-columns: repeat(4,1fr);">
                <div class="service-card" onclick="showBlogPage('home-maintenance')">
                    <div class="service-img">
                        <img src="https://i.pinimg.com/736x/f6/76/1d/f6761db73758139be3247097595433b5.jpg" alt="Home Maintenance">
                    </div>
                    <div class="service-content">
                        <h3>Essential Home Maintenance Tips for Summer</h3>
                        <p>Keep your home in top condition this summer with these essential maintenance tips from our experts.</p>
                    </div>
                </div>
                <div class="service-card" onclick="showBlogPage('electrical-safety')">
                    <div class="service-img">
                        <img src="https://i.pinimg.com/1200x/84/a4/d3/84a4d3118b56774f6ec89d146934eb7a.jpg" alt="Electrical Safety">
                    </div>
                    <div class="service-content">
                        <h3>Electrical Safety Tips Every Homeowner Should Know</h3>
                        <p>Learn how to keep your home safe from electrical hazards with these important safety guidelines.</p>
                    </div>
                </div>
                <div class="service-card" onclick="showBlogPage('car-maintenance')">
                    <div class="service-img">
                        <img src="https://www.intech.edu.au/app_media/2024/01/intech.png" alt="Car Maintenance">
                    </div>
                    <div class="service-content">
                        <h3>5 Essential Car Maintenance Tips for Summer</h3>
                        <p>Keep your vehicle running smoothly during the hot summer months with these essential maintenance tips.</p>
                    </div>
                </div>
                <div class="service-card" onclick="showBlogPage('carpentry-tips')">
                    <div class="service-img">
                        <img src="https://i.pinimg.com/736x/df/7f/1b/df7f1bf1af37bf3e16ab9e12231d4def.jpg" alt="Carpentry Tips">
                    </div>
                    <div class="service-content">
                        <h3>Expert Carpentry Tips for Homeowners</h3>
                        <p>From furniture repair to custom builds, learn essential carpentry skills to enhance your living space.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Us Section -->
        <section id="about-section" style="max-width:1200px; margin:0 auto 80px; padding:0 20px; display:none;">
            <div class="contact-detail-header" style="background:linear-gradient(135deg,#3366FF 0%,#1A2E55 100%); border-radius:15px; padding:60px 40px; text-align:center; color:white;">
                <h1 style="font-size:3rem;">About Us</h1>
                <p>We are passionate about connecting people with trusted local service providers.</p>
            </div>
            <div class="contact-detail-content" style="background:white; border-radius:15px; padding:40px; margin-top:30px;">
                <div style="display:flex; gap:40px; flex-wrap:wrap;">
                    <div style="flex:1;">
                        <img src="https://images.unsplash.com/photo-1521737711867-e3b97375f902?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" style="width:100%; border-radius:15px;">
                    </div>
                    <div style="flex:1;">
                        <h2 style="color:#1A2E55;">Who We Are</h2>
                        <p style="color:#555; line-height:1.8;">LocalService is a platform dedicated to bridging the gap between homeowners and skilled professionals. We believe everyone deserves access to reliable, affordable, and quality home services.</p>
                        <p style="color:#555; line-height:1.8;">Founded with a mission to make home maintenance stress-free, our platform connects you with verified plumbers, electricians, mechanics, and carpenters in your local area.</p>
                    </div>
                </div>
                <div style="text-align:center; margin-top:40px;">
                    <button onclick="showDashboard()" class="cta-button">Back to Home</button>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact-section" style="max-width:1200px; margin:0 auto 80px; padding:0 20px; display:none;">
            <div class="contact-detail-header" style="background:linear-gradient(135deg,#3366FF 0%,#1A2E55 100%); border-radius:15px; padding:60px 40px; text-align:center; color:white;">
                <h1 style="font-size:3rem;">Contact Us</h1>
                <p>We'd love to hear from you. Reach out with any questions or feedback.</p>
            </div>
            <div class="contact-detail-content" style="background:white; border-radius:15px; padding:40px; margin-top:30px;">
                <div style="display:flex; gap:40px; flex-wrap:wrap;">
                    <div style="flex:1;">
                        <h2>Get in Touch</h2>
                        <p>Fill out the form below and we'll get back to you as soon as possible.</p>
                        <form id="contactForm">
                            <div class="form-group" style="margin-bottom:15px;">
                                <label>Name *</label>
                                <input type="text" id="contact-name" class="form-control" style="width:100%; padding:12px; border:2px solid #D6E4FF; border-radius:8px;">
                            </div>
                            <div class="form-group" style="margin-bottom:15px;">
                                <label>Email *</label>
                                <input type="email" id="contact-email" class="form-control" style="width:100%; padding:12px; border:2px solid #D6E4FF; border-radius:8px;">
                            </div>
                            <div class="form-group" style="margin-bottom:15px;">
                                <label>Subject *</label>
                                <input type="text" id="contact-subject" class="form-control" style="width:100%; padding:12px; border:2px solid #D6E4FF; border-radius:8px;">
                            </div>
                            <div class="form-group" style="margin-bottom:15px;">
                                <label>Message *</label>
                                <textarea id="contact-message" rows="5" class="form-control" style="width:100%; padding:12px; border:2px solid #D6E4FF; border-radius:8px;"></textarea>
                            </div>
                            <button type="submit" class="cta-button">Send Message</button>
                        </form>
                    </div>
                    <div style="flex:1;">
                        <h2>Contact Information</h2>
                        <div style="background:#F5F9FF; padding:25px; border-radius:10px;">
                            <p style="margin-bottom:15px;"><i class="fas fa-map-marker-alt"></i> 123 Service Street, Sialkot</p>
                            <p style="margin-bottom:15px;"><i class="fas fa-phone-alt"></i> (555) 123-4567</p>
                            <p style="margin-bottom:15px;"><i class="fas fa-envelope"></i> info@localconnect.com</p>
                            <p><i class="fas fa-clock"></i> Mon - Fri: 9:00 AM - 6:00 PM</p>
                        </div>
                    </div>
                </div>
                <div style="text-align:center; margin-top:40px;">
                    <button onclick="showDashboard()" class="cta-button">Back to Home</button>
                </div>
            </div>
        </section>

        <!-- Blog Detail Pages -->
        <div id="blog-home-maintenance" style="display:none;">
            <div style="max-width:1200px; margin:40px auto; padding:20px;">
                <div style="background:linear-gradient(135deg,#3366FF,#1A2E55); border-radius:15px; padding:60px; text-align:center; color:white;">
                    <h1>Essential Home Maintenance Tips for Summer</h1>
                </div>
                <div style="background:white; border-radius:15px; padding:40px; margin-top:30px;">
                    <img src="https://i.pinimg.com/736x/f6/76/1d/f6761db73758139be3247097595433b5.jpg" style="width:100%; border-radius:15px; margin-bottom:30px;">
                    <h2>1. Check Your Air Conditioning System</h2>
                    <p>Summer heat puts a strain on your AC. Clean or replace filters monthly, check for refrigerant leaks, and ensure the outdoor unit is free of debris.</p>
                    <h2>2. Inspect Windows and Doors</h2>
                    <p>Seal gaps around windows and doors to keep cool air in and hot air out.</p>
                    <button onclick="showDashboard()" class="cta-button" style="margin-top:30px;">Back to Home</button>
                </div>
            </div>
        </div>
        <!-- Add other blog pages similarly - simplified for brevity -->

        <footer>
            <div class="footer-container">
                <div class="footer-col">
                    <h3>LocalConnect</h3>
                    <p>Connecting you with trusted local service providers for all your home maintenance and repair needs.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="footer-col">
                    <h3>Quick Links</h3>
                    <ul class="footer-links">
                        <li><a onclick="scrollToSection('home')">Home</a></li>
                        <li><a onclick="showAboutPage()">About Us</a></li>
                        <li><a onclick="scrollToSection('services')">Services</a></li>
                        <li><a onclick="showContactPage()">Contact</a></li>
                        <li><a onclick="scrollToSection('blog')">Blog</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h3>Our Services</h3>
                    <ul class="footer-links">
                        <li><a onclick="bookService('Plumbing')">Plumbing</a></li>
                        <li><a onclick="bookService('Electrical')">Electrical</a></li>
                        <li><a onclick="bookService('Mechanic')">Mechanic</a></li>
                        <li><a onclick="bookService('Carpenter')">Carpentry</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h3>Contact Info</h3>
                    <ul class="footer-links">
                        <li><i class="fas fa-map-marker-alt"></i> Sialkot, Pakistan</li>
                        <li><i class="fas fa-phone-alt"></i> (555) 123-4567</li>
                        <li><i class="fas fa-envelope"></i> info@localconnect.com</li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2023 LocalConnect. All Rights Reserved.</p>
            </div>
        </footer>
    </div>

    <script>
        // ==================== PAGE NAVIGATION ====================
        function showDashboard() {
            document.getElementById('about-section').style.display = 'none';
            document.getElementById('contact-section').style.display = 'none';
            document.getElementById('dashboard-page').style.display = 'block';
            document.getElementById('blog-home-maintenance').style.display = 'none';
            window.scrollTo(0, 0);
        }
        
        function showAboutPage() {
            document.getElementById('dashboard-page').style.display = 'none';
            document.getElementById('contact-section').style.display = 'none';
            document.getElementById('about-section').style.display = 'block';
            document.getElementById('blog-home-maintenance').style.display = 'none';
            window.scrollTo(0, 0);
        }
        
        function showContactPage() {
            document.getElementById('dashboard-page').style.display = 'none';
            document.getElementById('about-section').style.display = 'none';
            document.getElementById('contact-section').style.display = 'block';
            document.getElementById('blog-home-maintenance').style.display = 'none';
            window.scrollTo(0, 0);
        }
        
        function showBlogPage(blogId) {
            document.getElementById('dashboard-page').style.display = 'none';
            document.getElementById('about-section').style.display = 'none';
            document.getElementById('contact-section').style.display = 'none';
            document.getElementById('blog-home-maintenance').style.display = 'block';
            window.scrollTo(0, 0);
        }
        
        function scrollToSection(sectionId) {
            showDashboard();
            const element = document.getElementById(sectionId);
            if (element) {
                element.scrollIntoView({ behavior: 'smooth' });
            }
        }
        
        // ==================== BOOK SERVICE FUNCTION ====================
        function bookService(serviceName) {
            <?php if(!$isLoggedIn): ?>
                Swal.fire({
                    title: 'Login Required',
                    text: 'Please login to book a service',
                    icon: 'info',
                    confirmButtonText: 'Login',
                    showCancelButton: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'login.html';
                    }
                });
            <?php else: ?>
                window.location.href = `book_service.html?service=${encodeURIComponent(serviceName)}&email=${encodeURIComponent('<?php echo $userEmail; ?>')}`;
            <?php endif; ?>
        }
        
        // ==================== LOGIN/LOGOUT BUTTONS ====================
        document.getElementById('login-button')?.addEventListener('click', function() {
            window.location.href = 'login.html';
        });
        
        document.getElementById('join-as-pro')?.addEventListener('click', function() {
            window.location.href = 'provider_login.html';
        });
        
        document.getElementById('logout-btn')?.addEventListener('click', function() {
            window.location.href = 'logout.php';
        });
        
        // ==================== SLIDESHOW ====================
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.nav-dot');
        const totalSlides = slides.length;
        
        function showSlide(n) {
            if (n >= totalSlides) currentSlide = 0;
            else if (n < 0) currentSlide = totalSlides - 1;
            else currentSlide = n;
            const slidesContainer = document.querySelector('.slides');
            if (slidesContainer) {
                slidesContainer.style.transform = `translateX(-${currentSlide * 100}%)`;
            }
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === currentSlide);
            });
        }
        
        document.querySelector('.next')?.addEventListener('click', () => showSlide(currentSlide + 1));
        document.querySelector('.prev')?.addEventListener('click', () => showSlide(currentSlide - 1));
        dots.forEach((dot, index) => dot.addEventListener('click', () => showSlide(index)));
        setInterval(() => showSlide(currentSlide + 1), 5000);
        
        // ==================== NOTIFICATION SYSTEM ====================
        let notifications = [];
        const NOTIF_KEY = 'localConnectNotifications';
        
        function loadNotifications() {
            const stored = localStorage.getItem(NOTIF_KEY);
            if (stored) {
                notifications = JSON.parse(stored);
            } else {
                notifications = [
                    { id: 1, title: "🔔 Welcome to LocalService", message: "We're here to connect you with trusted local professionals!", time: "Just now", read: false, icon: "fas fa-smile-wink" }
                ];
                saveNotifications();
            }
            updateBellBadge();
            renderNotificationPanel();
        }
        
        function saveNotifications() {
            localStorage.setItem(NOTIF_KEY, JSON.stringify(notifications));
        }
        
        function updateBellBadge() {
            const unreadCount = notifications.filter(n => !n.read).length;
            const badge = document.getElementById('bellBadge');
            if (badge) {
                badge.textContent = unreadCount;
                badge.style.display = unreadCount > 0 ? 'flex' : 'none';
            }
        }
        
        function renderNotificationPanel() {
            const container = document.getElementById('notificationList');
            if (!container) return;
            if (notifications.length === 0) {
                container.innerHTML = '<div class="empty-notif">📭 No notifications yet</div>';
                return;
            }
            let html = '';
            notifications.forEach(notif => {
                const unreadClass = notif.read ? '' : 'unread';
                html += `
                    <div class="notif-item ${unreadClass}" data-id="${notif.id}">
                        <div class="notif-icon"><i class="${notif.icon}"></i></div>
                        <div class="notif-content">
                            <div class="notif-title">${notif.title}</div>
                            <div class="notif-message">${notif.message}</div>
                            <div class="notif-time"><i class="far fa-clock"></i> ${notif.time}</div>
                        </div>
                    </div>
                `;
            });
            container.innerHTML = html;
        }
        
        const bellIcon = document.getElementById('globalBellIcon');
        const panel = document.getElementById('notificationPanel');
        const closePanelBtn = document.getElementById('closePanelBtn');
        
        bellIcon?.addEventListener('click', (e) => {
            e.stopPropagation();
            panel.classList.toggle('show');
            renderNotificationPanel();
        });
        
        closePanelBtn?.addEventListener('click', () => {
            panel.classList.remove('show');
        });
        
        document.addEventListener('click', function(event) {
            if (bellIcon && !bellIcon.contains(event.target) && panel && !panel.contains(event.target)) {
                panel.classList.remove('show');
            }
        });
        
        // Contact form
        document.getElementById('contactForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire('Success!', 'Your message has been sent. We will get back to you soon.', 'success');
            this.reset();
        });
        
        // Initialize
        loadNotifications();
        
        // Handle redirect after login (if coming from login page)
        <?php if(isset($_GET['login']) && $_GET['login'] == 'success'): ?>
            Swal.fire('Success!', 'Login successful! Welcome back.', 'success');
        <?php endif; ?>
    </script>
</body>
</html>