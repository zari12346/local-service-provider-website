<?php
session_start();
$isLoggedIn = isset($_SESSION['user_email']);
$userEmail  = $isLoggedIn ? $_SESSION['user_email']     : '';
$userName   = $isLoggedIn ? $_SESSION['user_name']  : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Local Service Provider</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
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
            line-height: 1.6;
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
        
        .service-link {
            display: inline-block;
            color: #3366FF;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.3s ease;
            align-self: flex-start;
        }
        
        .service-link:hover {
            color: #1A2E55;
        }
        
        /* About Section */
        .about-section {
            max-width: 1200px;
            margin: 0 auto 80px;
            padding: 0 20px;
            display: flex;
            align-items: center;
            gap: 50px;
        }
        
        .about-img {
            flex: 1;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(26, 46, 85, 0.2);
        }
        
        .about-img img {
            width: 100%;
            height: auto;
            display: block;
        }
        
        .about-content {
            flex: 1;
        }
        
        .about-content h2 {
            font-size: 2.2rem;
            margin-bottom: 20px;
            color: #1A2E55;
        }
        
        .about-content p {
            line-height: 1.7;
            margin-bottom: 20px;
            color: #555;
        }
        
        /* Contact Section (on dashboard) */
        .contact-section {
            max-width: 1200px;
            margin: 0 auto 80px;
            padding: 0 20px;
        }
        
        .contact-container {
            display: flex;
            gap: 50px;
            background-color: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(26, 46, 85, 0.1);
        }
        
        .contact-info {
            flex: 1;
            background: linear-gradient(135deg, #3366FF 0%, #1A2E55 100%);
            color: white;
            padding: 40px;
        }
        
        .contact-info h3 {
            font-size: 1.8rem;
            margin-bottom: 20px;
        }
        
        .contact-details {
            margin-bottom: 30px;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .contact-item i {
            margin-right: 15px;
            font-size: 20px;
            color: #84A9FF;
        }
        
        .contact-form {
            flex: 1;
            padding: 40px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #D6E4FF;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #3366FF;
            outline: none;
            box-shadow: 0 0 0 3px rgba(51, 102, 255, 0.2);
        }
        
        textarea.form-control {
            min-height: 150px;
            resize: vertical;
        }
        
        /* Blog Section */
        .blog-section {
            max-width: 1400px;
            margin: 0 auto 80px;
            padding: 0 20px;
        }
        
        .blog-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
        }
        
        @media (max-width: 1199px) {
            .blog-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        
        @media (max-width: 991px) {
            .blog-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 575px) {
            .blog-grid {
                grid-template-columns: 1fr;
            }
        }
        
        .blog-card {
            background-color: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(26, 46, 85, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        
        .blog-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(26, 46, 85, 0.2);
        }
        
        .blog-img {
            height: 200px;
            overflow: hidden;
        }
        
        .blog-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .blog-card:hover .blog-img img {
            transform: scale(1.1);
        }
        
        .blog-content {
            padding: 20px 15px 25px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        
        .blog-meta {
            display: flex;
            gap: 15px;
            margin-bottom: 10px;
            font-size: 0.85rem;
            color: #3366FF;
        }
        
        .blog-content h3 {
            font-size: 1.2rem;
            margin-bottom: 10px;
            color: #1A2E55;
            line-height: 1.4;
        }
        
        .blog-content p {
            color: #555;
            margin-bottom: 20px;
            line-height: 1.5;
            font-size: 0.9rem;
            flex: 1;
        }
        
        .blog-link {
            display: inline-block;
            color: #3366FF;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.3s ease;
            align-self: flex-start;
        }
        
        .blog-link:hover {
            color: #1A2E55;
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
        
        /* Login Page Styles */
        .login-body {
            background: linear-gradient(135deg, #D6E4FF 0%, #84A9FF 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            background-image: url('https://images.unsplash.com/photo-1558591710-4b4a1ae0f04d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            background-blend-mode: overlay;
        }
        
        .container {
            display: flex;
            width: 100%;
            max-width: 1000px;
            background-color: #F5F9FF;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(26, 46, 85, 0.2);
            animation: fadeIn 1s ease-out;
        }
        
        .image-section {
            flex: 1;
            background: 
                linear-gradient(rgba(26, 46, 85, 0.7), rgba(51, 102, 255, 0.7)),
                url('https://images.unsplash.com/photo-1556761175-5973dc0f32e7?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60') center/cover;
            color: white;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
        }
        
        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(26, 46, 85, 0.6);
            z-index: 1;
        }
        
        .image-content {
            position: relative;
            z-index: 2;
        }
        
        .image-section h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            animation: slideInFromLeft 1s ease-out;
            color: #F5F9FF;
        }
        
        .image-section p {
            font-size: 1.1rem;
            margin-bottom: 30px;
            line-height: 1.6;
            color: #D6E4FF;
        }
        
        .features {
            text-align: left;
            margin-top: 20px;
        }
        
        .features p {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            color: #D6E4FF;
        }
        
        .features i {
            margin-right: 10px;
            color: #84A9FF;
        }
        
        .form-section {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .form-container {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }
        
        .form-title {
            font-size: 2rem;
            color: #1A2E55;
            margin-bottom: 10px;
            text-align: center;
        }
        
        .form-subtitle {
            color: #3366FF;
            text-align: center;
            margin-bottom: 30px;
        }
        
        .password-container {
            position: relative;
        }
        
        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #3366FF;
            z-index: 10;
            background: #F5F9FF;
            padding: 5px;
            border-radius: 4px;
        }
        
        .toggle-password:hover {
            background: #D6E4FF;
        }
        
        .btn {
            display: block;
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background-color: #3366FF;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #1A2E55;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(26, 46, 85, 0.2);
        }
        
        .divider {
            text-align: center;
            margin: 20px 0;
            position: relative;
            color: #3366FF;
        }
        
        .divider::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background-color: #D6E4FF;
        }
        
        .divider span {
            background-color: #F5F9FF;
            padding: 0 15px;
            position: relative;
            z-index: 1;
        }
        
        .social-login {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        
        .social-btn {
            flex: 1;
            padding: 12px;
            border: 2px solid #D6E4FF;
            border-radius: 8px;
            background-color: #F5F9FF;
            color: #1A2E55;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .social-btn:hover {
            border-color: #3366FF;
            transform: translateY(-3px);
        }
        
        .toggle-form {
            text-align: center;
            margin-top: 25px;
            color: #1A2E55;
        }
        
        .toggle-form a {
            color: #3366FF;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        
        .toggle-form a:hover {
            color: #1A2E55;
            text-decoration: underline;
        }
        
        .form-page {
            display: none;
            animation: fadeIn 0.5s ease-out;
        }
        
        .active {
            display: block;
        }
        
        .password-hint {
            font-size: 0.8rem;
            color: #3366FF;
            margin-top: 5px;
        }
        
        .forgot-password {
            text-align: right;
            margin-top: 5px;
        }
        
        .forgot-password a {
            color: #3366FF;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }
        
        .forgot-password a:hover {
            color: #1A2E55;
            text-decoration: underline;
        }
        
        .email-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #D6E4FF;
            border-radius: 8px;
            max-height: 150px;
            overflow-y: auto;
            z-index: 100;
            box-shadow: 0 5px 15px rgba(26, 46, 85, 0.1);
            display: none;
        }
        
        .email-suggestion {
            padding: 10px 15px;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        .email-suggestion:hover {
            background-color: #D6E4FF;
        }
        
        .login-container {
            border: 3px solid #D6E4FF;
            border-radius: 15px;
            padding: 30px;
            animation: slideInFromRight 1s ease-out;
            background-color: #F5F9FF;
        }
        
        .back-to-home {
            text-align: center;
            margin-top: 20px;
        }
        
        .back-to-home a {
            color: #3366FF;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: color 0.3s ease;
        }
        
        .back-to-home a:hover {
            color: #1A2E55;
            text-decoration: underline;
        }
        
        .error-message {
            color: #ff4757;
            font-size: 0.8rem;
            margin-top: 5px;
            display: none;
        }
        
        .success-message {
            color: #2ed573;
            font-size: 0.8rem;
            margin-top: 5px;
            display: none;
        }
        
        /* Professional Registration Page Styles */
        .professional-body {
            background: linear-gradient(135deg, #D6E4FF 0%, #84A9FF 100%);
            min-height: 100vh;
            color: #1A2E55;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
        }
        
        .professional-body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('https://images.unsplash.com/photo-1556761175-b4da9f91a9e2?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            opacity: 0.4;
            z-index: -1;
        }
        
        .professional-container {
            background-color: rgba(245, 249, 255, 0.95);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(26, 46, 85, 0.2);
            animation: fadeIn 1s ease-out;
            position: relative;
            max-width: 1100px;
            width: 100%;
            margin: 0 auto;
        }
        
        .professional-header {
            background: linear-gradient(135deg, #3366FF 0%, #1A2E55 100%);
            color: white;
            padding: 30px;
            text-align: center;
            position: relative;
        }
        
        .professional-header h1 {
            font-size: 2.2rem;
            margin-bottom: 10px;
        }
        
        .professional-header p {
            font-size: 1rem;
            color: #D6E4FF;
            max-width: 700px;
            margin: 0 auto;
        }
        
        .city-restriction {
            background: linear-gradient(135deg, #3366FF 0%, #1A2E55 100%);
            padding: 15px;
            border-radius: 8px;
            margin: 15px;
            text-align: center;
            border-left: 5px solid #FFD700;
            color: white;
        }
        
        .city-restriction h3 {
            color: white;
            margin-bottom: 8px;
            font-size: 1.1rem;
        }
        
        .city-restriction p {
            color: #D6E4FF;
            font-weight: 500;
            margin: 0;
            font-size: 0.9rem;
        }
        
        .professional-content {
            padding: 20px;
        }
        
        .professional-image {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(26, 46, 85, 0.1);
            height: 100%;
        }
        
        .professional-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            min-height: 400px;
        }
        
        .professional-form .form-group {
            margin-bottom: 15px;
        }
        
        .professional-form .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 2px solid #D6E4FF;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background-color: rgba(245, 249, 255, 0.8);
        }
        
        .professional-form .form-control:focus {
            border-color: #3366FF;
            outline: none;
            box-shadow: 0 0 0 3px rgba(51, 102, 255, 0.2);
        }
        
        .professional-form .form-label {
            display: block;
            margin-bottom: 6px;
            color: #1A2E55;
            font-weight: 500;
            font-size: 0.9rem;
        }
        
        .professional-form .password-hint {
            font-size: 0.75rem;
            color: #3366FF;
            margin-top: 3px;
        }
        
        .professional-form .error-message {
            color: #ff4757;
            font-size: 0.75rem;
            margin-top: 3px;
            display: none;
        }
        
        .professional-form .success-message {
            color: #2ed573;
            font-size: 0.9rem;
            margin-top: 10px;
            text-align: center;
            font-weight: 500;
            display: none;
            padding: 10px;
            background: rgba(46, 213, 115, 0.1);
            border-radius: 5px;
            border-left: 3px solid #2ed573;
        }
        
        .professional-form .password-container {
            position: relative;
        }
        
        .professional-form .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #3366FF;
            z-index: 10;
            background: #F5F9FF;
            padding: 4px;
            border-radius: 4px;
        }
        
        .professional-form .toggle-password:hover {
            background: #D6E4FF;
        }
        
        .professional-form .btn-primary {
            background-color: #3366FF;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }
        
        .professional-form .btn-primary:hover {
            background-color: #1A2E55;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(26, 46, 85, 0.2);
        }
        
        .professional-form .btn-primary:active {
            transform: translateY(0);
        }
        
        .professional-form .btn-primary:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        
        .cross-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #FFD700;
            color: #1A2E55;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(255, 215, 0, 0.3);
            z-index: 1000;
        }
        
        .cross-btn:hover {
            background-color: #FFC400;
            transform: translateY(-3px) rotate(90deg);
            box-shadow: 0 8px 20px rgba(255, 215, 0, 0.4);
            color: #1A2E55;
            text-decoration: none;
        }
        
        .cross-btn:active {
            transform: translateY(-1px) rotate(90deg);
        }
        
        /* Service & Blog Detail Pages */
        .service-detail, .blog-detail, .contact-detail {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        .service-detail-header, .blog-detail-header, .contact-detail-header {
            background: linear-gradient(135deg, #3366FF 0%, #1A2E55 100%);
            color: white;
            padding: 60px 40px;
            border-radius: 15px;
            margin-bottom: 40px;
            text-align: center;
        }
        
        .service-detail-header h1, .blog-detail-header h1, .contact-detail-header h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }
        
        .service-detail-header p, .blog-detail-header p, .contact-detail-header p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto;
            opacity: 0.9;
        }
        
        .service-detail-content, .blog-detail-content, .contact-detail-content {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 5px 20px rgba(26, 46, 85, 0.1);
        }
        
        .service-detail-content h2, .blog-detail-content h2, .contact-detail-content h2 {
            color: #1A2E55;
            margin: 30px 0 20px;
            font-size: 1.8rem;
        }
        
        .service-detail-content h2:first-of-type, .blog-detail-content h2:first-of-type, .contact-detail-content h2:first-of-type {
            margin-top: 0;
        }
        
        .service-detail-content p, .blog-detail-content p, .contact-detail-content p {
            line-height: 1.8;
            color: #555;
            margin-bottom: 20px;
        }
        
        .service-detail-content ul, .blog-detail-content ul {
            margin-bottom: 30px;
            padding-left: 20px;
        }
        
        .service-detail-content li, .blog-detail-content li {
            margin-bottom: 10px;
            color: #555;
        }
        
        .service-detail-content li i, .blog-detail-content li i {
            color: #3366FF;
            margin-right: 10px;
        }
        
        .service-features, .blog-features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin: 40px 0;
        }
        
        .feature-card {
            background: #F5F9FF;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            transition: transform 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
        }
        
        .feature-card i {
            font-size: 3rem;
            color: #3366FF;
            margin-bottom: 15px;
        }
        
        .feature-card h3 {
            font-size: 1.3rem;
            color: #1A2E55;
            margin-bottom: 10px;
        }
        
        .feature-card p {
            color: #666;
            margin: 0;
        }
        
        .back-to-dashboard {
            display: inline-block;
            margin-top: 30px;
            color: #3366FF;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .back-to-dashboard:hover {
            color: #1A2E55;
        }
        
        .back-to-dashboard i {
            margin-right: 8px;
        }
        
        /* Contact page specific */
        .contact-info-box {
            background: #F5F9FF;
            padding: 25px;
            border-radius: 10px;
            margin: 20px 0;
        }
        
        .contact-info-box .contact-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
        }
        
        .contact-info-box .contact-item i {
            font-size: 1.5rem;
            color: #3366FF;
            margin-right: 15px;
            min-width: 30px;
        }
        
        .contact-info-box .contact-item div {
            color: #1A2E55;
            line-height: 1.6;
        }
        
        .map-placeholder {
            margin-top: 20px;
            border-radius: 10px;
            overflow: hidden;
        }
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideInFromLeft {
            from { transform: translateX(-30px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        @keyframes slideInFromRight {
            from { transform: translateX(30px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        @keyframes aboutHeaderSlide {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes aboutH1 {
            from { opacity: 0; transform: scale(0.8); }
            to { opacity: 1; transform: scale(1); }
        }
        
        @keyframes aboutContentFade {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes featureFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }
        
        /* Service card shimmer animation */
        .service-card {
            position: relative;
        }
        
        /* Page transition animation */
        .page-container.active-page {
            animation: pageReveal 0.5s ease-out;
        }
        
        @keyframes pageReveal {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* ========== PERSISTENT BELL ICON (fixed bottom-right) ========== */
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
            background: linear-gradient(135deg, #1A2E55, #3366FF);
        }
        
        .notification-bell i {
            font-size: 28px;
            color: #FFD700;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
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
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
            border: 2px solid white;
        }
        
        /* Notification Panel */
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
            border: 1px solid rgba(51,102,255,0.15);
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
        
        .panel-header span {
            font-size: 1rem;
            letter-spacing: 0.3px;
        }
        
        .close-panel {
            background: none;
            border: none;
            color: white;
            font-size: 22px;
            cursor: pointer;
            opacity: 0.8;
            transition: 0.2s;
        }
        
        .close-panel:hover {
            opacity: 1;
            transform: scale(1.1);
        }
        
        .notification-list {
            max-height: 420px;
            overflow-y: auto;
            background: #fefefe;
        }
        
        .notif-item {
            padding: 14px 18px;
            border-bottom: 1px solid #eef2ff;
            display: flex;
            gap: 14px;
            transition: background 0.2s;
            cursor: pointer;
            align-items: flex-start;
        }
        
        .notif-item.unread {
            background: #F0F7FF;
            border-left: 4px solid #3366FF;
        }
        
        .notif-item:hover {
            background: #f5f9ff;
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
            font-size: 18px;
            flex-shrink: 0;
        }
        
        .notif-content {
            flex: 1;
        }
        
        .notif-title {
            font-weight: 700;
            font-size: 0.95rem;
            color: #1A2E55;
            margin-bottom: 4px;
        }
        
        .notif-message {
            font-size: 0.85rem;
            color: #4a627a;
            line-height: 1.4;
            margin-bottom: 6px;
        }
        
        .notif-time {
            font-size: 0.7rem;
            color: #84A9FF;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .mark-read-btn {
            background: transparent;
            border: none;
            font-size: 0.7rem;
            color: #3366FF;
            cursor: pointer;
            font-weight: 500;
            padding: 2px 6px;
            border-radius: 20px;
            transition: 0.2s;
        }
        
        .mark-read-btn:hover {
            background: #D6E4FF;
            text-decoration: underline;
        }
        
        .empty-notif {
            text-align: center;
            padding: 40px 20px;
            color: #84A9FF;
            font-size: 0.9rem;
        }
        
        @media (max-width: 576px) {
            .notification-panel {
                width: 300px;
                right: 16px;
                bottom: 90px;
            }
            .notification-bell {
                width: 52px;
                height: 52px;
                bottom: 20px;
                right: 20px;
            }
            .notification-bell i {
                font-size: 24px;
            }
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            
            .image-section {
                padding: 30px 20px;
            }
            
            .form-section {
                padding: 30px 20px;
            }
            
            .about-section {
                flex-direction: column;
            }
            
            .contact-container {
                flex-direction: column;
            }
            
            .hero h2 {
                font-size: 2.5rem;
            }
            
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
            
            .professional-header h1 {
                font-size: 1.8rem;
            }
            
            .professional-header {
                padding: 20px 15px;
            }
            
            .professional-content {
                padding: 15px;
            }
            
            .professional-image img {
                min-height: 250px;
            }
            
            .professional-body {
                padding: 10px;
                align-items: flex-start;
            }
            
            .cross-btn {
                width: 40px;
                height: 40px;
                font-size: 20px;
                top: 15px;
                right: 15px;
            }
            
            .service-detail-header h1,
            .blog-detail-header h1,
            .contact-detail-header h1 {
                font-size: 2.2rem;
            }
            
            .service-detail-content,
            .blog-detail-content,
            .contact-detail-content {
                padding: 25px;
            }
            
            .contact-info-box {
                padding: 20px;
            }
            
            .dropdown-menu {
                min-width: 160px;
            }
            
            .dropdown-menu a {
                white-space: normal;
            }
        }
        
        @media (max-width: 480px) {
            .service-detail-header h1,
            .blog-detail-header h1,
            .contact-detail-header h1 {
                font-size: 1.8rem;
            }
            
            .service-detail-header,
            .blog-detail-header,
            .contact-detail-header {
                padding: 40px 20px;
            }
            
            .service-features,
            .blog-features {
                grid-template-columns: 1fr;
            }
        }
        
        @media (min-width: 992px) {
            .professional-container {
                max-width: 1000px;
            }
        }
    </style>
</head>
<body>
    <!-- ========== PERSISTENT BELL ICON (fixed bottom-right) ========== -->
    <div class="notification-bell" id="globalBellIcon" style="<?php echo $isLoggedIn ? '' : 'display:none;'; ?>">
        <i class="fas fa-bell"></i>
        <span class="bell-badge" id="bellBadge">0</span>
    </div>
    
    <!-- Notification Panel -->
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
        <!-- Header -->
        <header>
            <div class="header-container">
                <div class="logo">
                    <i class="fas fa-hands-helping"></i>
                    <h1>Local<span>service</span></h1>
                </div>
                
                <nav>
                    <ul>
                        <li><a href="#home">Home</a></li>
                        <li><a href="#" onclick="showAboutPage(); return false;">About Us</a></li>
                        <!-- Services Dropdown (Hover) - Updated with external links -->
                        <li class="dropdown">
                            <a href="#services" class="nav-link">Services <i class="fas fa-chevron-down"></i></a>
                            <ul class="dropdown-menu">
                                <li><a href="plumber.html">Plumbing</a></li>
                                <li><a href="electration.html">Electrical</a></li>
                                <li><a href="mechanic.html">Mechanic</a></li>
                                <li><a href="carpenter.html">Carpenter</a></li>
                            </ul>
                        </li>
                        <li><a href="#" onclick="showContactPage(); return false;">Contact</a></li>
                        <li><a href="#blog">Blog</a></li>
                    </ul>
                </nav>
                
                <div style="display:flex; align-items:center; gap:10px;">
                    <?php if($isLoggedIn): ?>
                    <a href="my_bookings.php" class="cta-button" style="background:#28a745; text-decoration:none; font-size:0.85rem; padding:8px 14px;">
                        <i class="fas fa-calendar-check"></i> My Bookings
                    </a>
                    <?php endif; ?>
                    <?php if(!$isLoggedIn): ?>
                    <button id="join-as-pro" class="yellow-button">
                        <i class="fas fa-user-tie"></i> Join as Pro
                    </button>
                    <?php endif; ?>
                    <?php if($isLoggedIn): ?>
                    <span id="user-greeting" style="font-weight:600; color:#1A2E55;">
                        <i class="fas fa-user-circle"></i> <?php echo htmlspecialchars($userName); ?>
                    </span>
                    <button id="logout-button" class="cta-button" style="background:#e74c3c;">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                    <?php else: ?>
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
            <a href="#services" class="cta-button">Explore Services</a>
        </section>

        <!-- Slideshow Section -->
        <section class="slideshow-section">
            <h2 class="section-title">Our Services in Action</h2>
            <div class="slideshow-container">
                <div class="slides">
                    <!-- Slide 1 - Plumbing -->
                    <div class="slide">
                        <img src="https://i.pinimg.com/1200x/ca/21/e0/ca21e0f146b2d2f8e1045684963d7a91.jpg" alt="Plumbing Service">
                        <div class="slide-content">
                            <h3>Professional Plumbing Services</h3>
                            <p>Expert plumbers ready to fix leaks, install fixtures, and handle all your plumbing needs.</p>
                        </div>
                    </div>
                    <!-- Slide 2 - Electrical (brown electrician) -->
                    <div class="slide">
                        <img src="https://www.qanmos.com/wp-content/uploads/2024/09/electrica1.jpg" alt="Electrical Service">
                        <div class="slide-content">
                            <h3>Certified Electrical Work</h3>
                            <p>Safe and reliable electrical installations, repairs, and maintenance by licensed professionals.</p>
                        </div>
                    </div>
                    <!-- Slide 3 - Mechanic -->
                    <div class="slide">
                        <img src="https://www.ozzis.com/wp-content/uploads/2017/05/Ozzis-Automotive-1_Qualities-of-a-Reputable-Japanese-Auto-Repair-Technician_IMAGE.jpeg" alt="Mechanic Service">
                        <div class="slide-content">
                            <h3>Expert Auto Mechanics</h3>
                            <p>Professional automotive repair and maintenance services to keep your vehicle running smoothly.</p>
                        </div>
                    </div>
                    <!-- Slide 4 - Carpenter -->
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

        <!-- Services Section - Updated with external links -->
        <section class="services-section" id="services">
            <h2 class="section-title">Our Services</h2>
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-img">
                        <img src="https://aquaprorooter.com/wp-content/uploads/plumber-using-wrench-on-sink.webp" alt="Plumbing">
                    </div>
                    <div class="service-content">
                        <h3>Plumbing</h3>
                        <p>From leaky faucets to complete pipe installations, our certified plumbers provide reliable solutions for all your plumbing needs.</p>
                        <a href="plumber.html" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-img">
                        <img src="https://png.pngtree.com/png-clipart/20250415/original/pngtree-electrician-connecting-wires-in-electrical-panel-isolated-on-transparent-background-png-image_20719215.png" alt="Electrical">
                    </div>
                    <div class="service-content">
                        <h3>Electration</h3>
                        <p>Safe and efficient electrical installations, repairs, and maintenance services by licensed electricians.</p>
                        <a href="electration.html" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-img">
                        <img src="https://i.pinimg.com/736x/6b/c6/d8/6bc6d874eda0f123a5dfff33cd0c15b2.jpg" alt="Mechanic">
                    </div>
                    <div class="service-content">
                        <h3>Mechanic</h3>
                        <p>Professional automotive repair and maintenance services to keep your vehicle running smoothly and safely.</p>
                        <a href="mechanic.html" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-img">
                        <img src="https://www.shutterstock.com/image-photo/carpenter-worker-work-carpentry-workshop-260nw-1924568537.jpg" alt="Carpenter">
                    </div>
                    <div class="service-content">
                        <h3>Carpenter</h3>
                        <p>Custom woodworking, furniture repair, and carpentry solutions for your home or business needs.</p>
                        <a href="carpenter.html" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Blog Section -->
        <section class="blog-section" id="blog">
            <h2 class="section-title">Latest From Our Blog</h2>
            <div class="blog-grid">
                <div class="blog-card">
                    <div class="blog-img">
                        <img src="https://i.pinimg.com/736x/f6/76/1d/f6761db73758139be3247097595433b5.jpg" alt="Home Maintenance">
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <span><i class="far fa-calendar"></i> June 15, 2023</span>
                            <span><i class="far fa-user"></i> Admin</span>
                        </div>
                        <h3>Essential Home Maintenance Tips for Summer</h3>
                        <p>Keep your home in top condition this summer with these essential maintenance tips from our experts.</p>
                        <a href="#" class="blog-link" onclick="showBlogPage('home-maintenance'); return false;">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="blog-card">
                    <div class="blog-img">
                        <img src="https://i.pinimg.com/1200x/84/a4/d3/84a4d3118b56774f6ec89d146934eb7a.jpg" alt="Electrical Safety">
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <span><i class="far fa-calendar"></i> May 28, 2023</span>
                            <span><i class="far fa-user"></i> Admin</span>
                        </div>
                        <h3>Electrical Safety Tips Every Homeowner Should Know</h3>
                        <p>Learn how to keep your home safe from electrical hazards with these important safety guidelines.</p>
                        <a href="#" class="blog-link" onclick="showBlogPage('electrical-safety'); return false;">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="blog-card">
                    <div class="blog-img">
                        <img src="https://www.intech.edu.au/app_media/2024/01/intech.png" alt="Car Maintenance">
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <span><i class="far fa-calendar"></i> May 10, 2023</span>
                            <span><i class="far fa-user"></i> Admin</span>
                        </div>
                        <h3>5 Essential Car Maintenance Tips for Summer</h3>
                        <p>Keep your vehicle running smoothly during the hot summer months with these essential maintenance tips.</p>
                        <a href="#" class="blog-link" onclick="showBlogPage('car-maintenance'); return false;">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="blog-card">
                    <div class="blog-img">
                        <img src="https://i.pinimg.com/736x/df/7f/1b/df7f1bf1af37bf3e16ab9e12231d4def.jpg" alt="Carpentry Tips">
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <span><i class="far fa-calendar"></i> April 22, 2023</span>
                            <span><i class="far fa-user"></i> Admin</span>
                        </div>
                        <h3>Expert Carpentry Tips for Homeowners</h3>
                        <p>From furniture repair to custom builds, learn essential carpentry skills to enhance your living space.</p>
                        <a href="#" class="blog-link" onclick="showBlogPage('carpentry-tips'); return false;">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer - Updated with external links -->
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
                        <li><a href="#home">Home</a></li>
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#services">Services</a></li>
                        <li><a href="#" onclick="showContactPage(); return false;">Contact</a></li>
                        
                        <li><a href="#blog">Blog</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h3>Our Services</h3>
                    <ul class="footer-links">
                        <li><a href="plumber.html">Plumbing</a></li>
                        <li><a href="electration.html">Electrical</a></li>
                        <li><a href="mechanic.html">Mechanic</a></li>
                        <li><a href="carpenter.html">Carpentry</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h3>Contact Info</h3>
                    <ul class="footer-links">
                        <li><i class="fas fa-map-marker-alt"></i> 123 Service Street, Cityville</li>
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

    <!-- Login Page -->
    <div id="login-page" class="page-container">
        <div class="login-body">
            <div class="container">
                <div class="image-section">
                    <div class="image-overlay"></div>
                    <div class="image-content">
                        <h1>Local Service Provider</h1>
                        <p>Finding Help Should Be Easy — We Make It Happen.</p>
                        <div class="features">
                            <p><i class="fas fa-check-circle"></i> Find trusted local professionals</p>
                            <p><i class="fas fa-check-circle"></i> Compare quotes and reviews</p>
                            <p><i class="fas fa-check-circle"></i> Book services instantly</p>
                        </div>
                    </div>
                </div>
                
                <div class="form-section">
                    <div class="login-container">
                        <!-- Login Form -->
                        <div id="login-form" class="form-page active">
                            <h2 class="form-title">Welcome to LSP</h2>
                            <p class="form-subtitle">Login to your account</p>
                            
                            <form id="loginForm">
                                <div class="form-group">
                                    <label for="login-email">Email Address</label>
                                    <input type="email" id="login-email" class="form-control" placeholder="Enter your email" required>
                                    <div id="email-suggestions" class="email-suggestions"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="login-password">Password</label>
                                    <div class="password-container">
                                        <input type="password" id="login-password" class="form-control" placeholder="Enter your password" required>
                                        <span class="toggle-password" id="toggleLoginPassword">
                                            <i class="far fa-eye"></i>
                                        </span>
                                    </div>
                                    <div id="login-error" class="error-message"></div>
                                    <div class="forgot-password">
                                        <a href="#" id="forgot-password-link">Forgot Password?</a>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Login</button>
                                </div>
                            </form>
                            
                            <div class="divider"><span>or continue with</span></div>
                            
                            <div class="social-login">
                                <button class="social-btn">
                                    <i class="fab fa-google"></i> Google
                                </button>
                                <button class="social-btn">
                                    <i class="fab fa-facebook-f"></i> Facebook
                                </button>
                            </div>
                            
                            <div class="toggle-form">
                                Don't have an account? <a href="#" id="show-signup">Sign Up</a>
                            </div>
                            
                            <div class="back-to-home">
                                <a href="#" id="back-to-home"><i class="fas fa-arrow-left"></i> Back to Home</a>
                            </div>
                        </div>
                        
                        <!-- Signup Form (No password requirements) -->
                        <div id="signup-form" class="form-page">
                            <h2 class="form-title">Create Account</h2>
                            <p class="form-subtitle">Join our community of service providers</p>
                            
                            <form id="signupForm">
                                <div class="form-group">
                                    <label for="first-name">First Name</label>
                                    <input type="text" id="first-name" class="form-control" placeholder="Enter your first name" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="last-name">Last Name</label>
                                    <input type="text" id="last-name" class="form-control" placeholder="Enter your last name" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="dob">Date of Birth</label>
                                    <input type="date" id="dob" class="form-control" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="signup-email">Email Address</label>
                                    <input type="email" id="signup-email" class="form-control" placeholder="Enter your email" required>
                                    <div id="email-error" class="error-message"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="services">Select Service</label>
                                    <select id="services" class="form-control" required>
                                        <option value="" disabled selected>Select your service</option>
                                        <option value="plumbing">Plumbing</option>
                                        <option value="electrical">Electrical</option>
                                        <option value="mechanic">Mechanic</option>
                                        <option value="carpenter">Carpenter</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="signup-password">Password</label>
                                    <div class="password-container">
                                        <input type="password" id="signup-password" class="form-control" placeholder="Create a password" required>
                                        <span class="toggle-password" id="toggleSignupPassword">
                                            <i class="far fa-eye"></i>
                                        </span>
                                    </div>
                                    <div id="password-error" class="error-message"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="confirm-password">Confirm Password</label>
                                    <div class="password-container">
                                        <input type="password" id="confirm-password" class="form-control" placeholder="Confirm your password" required>
                                        <span class="toggle-password" id="toggleConfirmPassword">
                                            <i class="far fa-eye"></i>
                                        </span>
                                    </div>
                                    <div id="confirm-error" class="error-message"></div>
                                </div>
                                
                                <div class="form-group">
                                    <button type="submit" id="signup-btn" class="btn btn-primary">Create Account</button>
                                </div>
                            </form>
                            
                            <div class="toggle-form">
                                Already have an account? <a href="#" id="show-login">Sign In</a>
                            </div>
                            
                            <div class="back-to-home">
                                <a href="#" id="back-to-home-signup"><i class="fas fa-arrow-left"></i> Back to Home</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Professional Registration Page (No password requirements) -->
    <div id="professional-page" class="page-container">
        <div class="professional-body">
            <div class="professional-container">
                <a href="#" id="cross-btn" class="cross-btn">×</a>
                
                <div class="professional-header">
                    <h1>Join as Professional</h1>
                    <p>Become a trusted service provider in Sialkot and grow your business with LocalConnect</p>
                </div>
                
                <div class="city-restriction">
                    <h3><i class="fas fa-map-marker-alt"></i> Serving Sialkot Only</h3>
                    <p>This service is exclusively for professionals serving in Sialkot and surrounding areas</p>
                </div>
                
                <div class="professional-content">
                    <div class="row">
                        <div class="col-12 col-lg-6 mb-4 mb-lg-0">
                            <div class="professional-image">
                         <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Professional Service Provider">
                            </div>
                        </div>
                        
                        <div class="col-12 col-lg-6">
                            <form id="professionalForm" class="professional-form">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pro-first-name" class="form-label">First Name *</label>
                                            <input type="text" id="pro-first-name" class="form-control" placeholder="Enter first name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pro-last-name" class="form-label">Last Name *</label>
                                            <input type="text" id="pro-last-name" class="form-control" placeholder="Enter last name" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="pro-cnic" class="form-label">CNIC Number *</label>
                                    <input type="text" id="pro-cnic" class="form-control" placeholder="XXXXX-XXXXXXX-X" required pattern="[0-9]{5}-[0-9]{7}-[0-9]{1}">
                                    <div class="password-hint">Format: 12345-1234567-1</div>
                                    <div id="cnic-error" class="error-message"></div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pro-phone" class="form-label">Phone Number *</label>
                                            <input type="tel" id="pro-phone" class="form-control" placeholder="03XX-XXXXXXX" required pattern="03[0-9]{2}-[0-9]{7}">
                                            <div class="password-hint">Format: 03XX-XXXXXXX</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pro-email" class="form-label">Email Address *</label>
                                            <input type="email" id="pro-email" class="form-control" placeholder="Enter your email" required>
                                            <div id="pro-email-error" class="error-message"></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pro-city" class="form-label">City *</label>
                                            <select id="pro-city" class="form-control" required>
                                                <option value="" disabled selected>Select your city</option>
                                                <option value="sialkot">Sialkot</option>
                                               
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pro-area" class="form-label">Area in Sialkot *</label>
                                            <select id="pro-area" class="form-control" required>
                                                <option value="" disabled selected>Select your area</option>
                                                <option value="kingra">Kingra</option>
                                                <option value="pindi bhaogo">Pindi bhaogo</option>
                                                <option value="Charwa">Charwa</option>
                                                <option value="Mirza pur">Mirza pur</option>
                                               
                                                <option value="other">Other Area</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pro-service" class="form-label">Service Category *</label>
                                            <select id="pro-service" class="form-control" required>
                                                <option value="" disabled selected>Select your service</option>
                                                <option value="plumbing">Plumbing</option>
                                                <option value="electrical">Electrical</option>
                                                <option value="mechanic">Mechanic</option>
                                                <option value="carpenter">Carpenter</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pro-experience" class="form-label">Years of Experience *</label>
                                            <select id="pro-experience" class="form-control" required>
                                                <option value="" disabled selected>Select experience</option>
                                                <option value="0-1">0-1 Years</option>
                                                <option value="1-3">1-3 Years</option>
                                                <option value="3-5">3-5 Years</option>
                                                <option value="5+">5+ Years</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="pro-password" class="form-label">Create Password *</label>
                                    <div class="password-container">
                                        <input type="password" id="pro-password" class="form-control" placeholder="Create a password" required>
                                        <span class="toggle-password" id="toggleProPassword">
                                            <i class="far fa-eye"></i>
                                        </span>
                                    </div>
                                    <div id="pro-password-error" class="error-message"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="pro-confirm-password" class="form-label">Confirm Password *</label>
                                    <div class="password-container">
                                        <input type="password" id="pro-confirm-password" class="form-control" placeholder="Confirm your password" required>
                                        <span class="toggle-password" id="toggleProConfirmPassword">
                                            <i class="far fa-eye"></i>
                                        </span>
                                    </div>
                                    <div id="pro-confirm-error" class="error-message"></div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="pro-terms" required>
                                        <label class="form-check-label" for="pro-terms" style="font-size: 0.85rem;">
                                            I agree to the <a href="#" style="color: #3366FF;">Terms & Conditions</a> and confirm that I am a legitimate service provider based in Sialkot
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="form-group mt-3">
                                    <button type="submit" id="pro-submit-btn" class="btn-primary">Submit Application</button>
                                    <div id="pro-success" class="success-message"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Service Detail Pages -->
    <!-- Plumbing Detail Page -->
    <div id="plumbing-page" class="page-container">
        <div class="service-detail">
            <div class="service-detail-header">
                <h1>Professional Plumbing Services</h1>
                <p>Expert plumbing solutions for your home or business – from leak repairs to complete installations.</p>
            </div>
            <div class="service-detail-content">
                <h2>Why Choose Our Plumbing Services?</h2>
                <p>Our team of certified plumbers brings years of experience and a commitment to quality. Whether it's a dripping faucet, a clogged drain, or a full bathroom renovation, we handle every job with precision and care.</p>
                
                <h2>Our Plumbing Services Include:</h2>
                <ul>
                    <li><i class="fas fa-wrench"></i> Leak detection and repair</li>
                    <li><i class="fas fa-tint"></i> Drain cleaning and unclogging</li>
                    <li><i class="fas fa-shower"></i> Fixture installation (sinks, faucets, toilets)</li>
                    <li><i class="fas fa-water"></i> Water heater repair and installation</li>
                    <li><i class="fas fa-pipe-valve"></i> Pipe replacement and repiping</li>
                    <li><i class="fas fa-toilet"></i> Toilet repair and installation</li>
                    <li><i class="fas fa-sink"></i> Kitchen and bathroom plumbing</li>
                    <li><i class="fas fa-home"></i> New construction plumbing</li>
                </ul>
                
                <div class="service-features">
                    <div class="feature-card">
                        <i class="fas fa-clock"></i>
                        <h3>24/7 Emergency Service</h3>
                        <p>Available round the clock for urgent plumbing issues.</p>
                    </div>
                    <div class="feature-card">
                        <i class="fas fa-certificate"></i>
                        <h3>Licensed & Insured</h3>
                        <p>All plumbers are fully licensed and insured for your peace of mind.</p>
                    </div>
                    <div class="feature-card">
                        <i class="fas fa-tools"></i>
                        <h3>Quality Workmanship</h3>
                        <p>We use the best materials and guarantee our work.</p>
                    </div>
                </div>
                
                <h2>Common Plumbing Problems We Solve</h2>
                <p>From minor annoyances to major emergencies, we've seen it all. Our plumbers are equipped to handle any challenge, ensuring your plumbing system functions perfectly.</p>
                
                <a href="#" onclick="showDashboard(); return false;" class="back-to-dashboard"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
            </div>
        </div>
    </div>

    <!-- Electrical Detail Page -->
    <div id="electrical-page" class="page-container">
        <div class="service-detail">
            <div class="service-detail-header">
                <h1>Certified Electrical Services</h1>
                <p>Safe, reliable, and professional electrical work for your home and business.</p>
            </div>
            <div class="service-detail-content">
                <h2>Why Choose Our Electrical Services?</h2>
                <p>Electricity is not something to compromise on. Our licensed electricians follow strict safety standards to ensure your property is safe and up to code. From simple repairs to complex installations, we deliver excellence.</p>
                
                <h2>Our Electrical Services Include:</h2>
                <ul>
                    <li><i class="fas fa-bolt"></i> Electrical wiring and rewiring</li>
                    <li><i class="fas fa-lightbulb"></i> Lighting installation and repair</li>
                    <li><i class="fas fa-plug"></i> Outlet and switch installation</li>
                    <li><i class="fas fa-charging-station"></i> Panel upgrades and maintenance</li>
                    <li><i class="fas fa-fan"></i> Ceiling fan installation</li>
                    <li><i class="fas fa-fire-extinguisher"></i> Surge protection and safety inspections</li>
                    <li><i class="fas fa-solar-panel"></i> Solar panel installation</li>
                    <li><i class="fas fa-home"></i> Whole-house electrical audits</li>
                </ul>
                
                <div class="service-features">
                    <div class="feature-card">
                        <i class="fas fa-shield-alt"></i>
                        <h3>Safety First</h3>
                        <p>We prioritize safety in every job, using modern techniques and equipment.</p>
                    </div>
                    <div class="feature-card">
                        <i class="fas fa-clipboard-check"></i>
                        <h3>Code Compliant</h3>
                        <p>All work meets local electrical codes and regulations.</p>
                    </div>
                    <div class="feature-card">
                        <i class="fas fa-tools"></i>
                        <h3>Experienced Team</h3>
                        <p>Our electricians have decades of combined experience.</p>
                    </div>
                </div>
                
                <h2>Signs You Need an Electrician</h2>
                <p>If you notice flickering lights, tripping breakers, or outdated wiring, it's time to call a professional. We're here to help.</p>
                
                <a href="#" onclick="showDashboard(); return false;" class="back-to-dashboard"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
            </div>
        </div>
    </div>

    <!-- Mechanic Detail Page -->
    <div id="mechanic-page" class="page-container">
        <div class="service-detail">
            <div class="service-detail-header">
                <h1>Expert Auto Mechanic Services</h1>
                <p>Keep your vehicle running smoothly with our professional automotive repair and maintenance.</p>
            </div>
            <div class="service-detail-content">
                <h2>Why Choose Our Mechanic Services?</h2>
                <p>Our certified mechanics are passionate about cars and committed to providing top-notch service. We use advanced diagnostic tools and quality parts to ensure your vehicle performs at its best.</p>
                
                <h2>Our Mechanic Services Include:</h2>
                <ul>
                    <li><i class="fas fa-oil-can"></i> Oil changes and fluid checks</li>
                    <li><i class="fas fa-car-battery"></i> Battery testing and replacement</li>
                    <li><i class="fas fa-brake-warning"></i> Brake repair and replacement</li>
                    <li><i class="fas fa-engine"></i> Engine diagnostics and repair</li>
                    <li><i class="fas fa-tire"></i> Tire rotation and balancing</li>
                    <li><i class="fas fa-snowplow"></i> Transmission services</li>
                    <li><i class="fas fa-air-conditioner"></i> AC repair and recharge</li>
                    <li><i class="fas fa-tools"></i> General maintenance and inspections</li>
                </ul>
                
                <div class="service-features">
                    <div class="feature-card">
                        <i class="fas fa-stethoscope"></i>
                        <h3>Accurate Diagnostics</h3>
                        <p>We use the latest diagnostic equipment to pinpoint issues quickly.</p>
                    </div>
                    <div class="feature-card">
                        <i class="fas fa-gem"></i>
                        <h3>Quality Parts</h3>
                        <p>We use high-quality parts to ensure long-lasting repairs.</p>
                    </div>
                    <div class="feature-card">
                        <i class="fas fa-clock"></i>
                        <h3>Timely Service</h3>
                        <p>We respect your time and aim to complete work efficiently.</p>
                    </div>
                </div>
                
                <h2>Preventative Maintenance Tips</h2>
                <p>Regular maintenance can extend the life of your vehicle. Let us help you keep it in peak condition.</p>
                
                <a href="#" onclick="showDashboard(); return false;" class="back-to-dashboard"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
            </div>
        </div>
    </div>

    <!-- Carpenter Detail Page -->
    <div id="carpenter-page" class="page-container">
        <div class="service-detail">
            <div class="service-detail-header">
                <h1>Skilled Carpentry Services</h1>
                <p>Custom woodworking, repairs, and installations by experienced carpenters.</p>
            </div>
            <div class="service-detail-content">
                <h2>Why Choose Our Carpentry Services?</h2>
                <p>From custom furniture to home renovations, our carpenters bring craftsmanship and attention to detail to every project. We work with you to bring your vision to life.</p>
                
                <h2>Our Carpentry Services Include:</h2>
                <ul>
                    <li><i class="fas fa-chair"></i> Custom furniture building</li>
                    <li><i class="fas fa-door-open"></i> Door and window installation</li>
                    <li><i class="fas fa-couch"></i> Cabinet making and installation</li>
                    <li><i class="fas fa-home"></i> Deck and porch construction</li>
                    <li><i class="fas fa-tools"></i> Furniture repair and restoration</li>
                    <li><i class="fas fa-stairs"></i> Staircase and railing installation</li>
                    <li><i class="fas fa-wood"></i> Trim and molding installation</li>
                    <li><i class="fas fa-wrench"></i> General home repairs</li>
                </ul>
                
                <div class="service-features">
                    <div class="feature-card">
                        <i class="fas fa-ruler"></i>
                        <h3>Precision Craftsmanship</h3>
                        <p>We take pride in precise measurements and flawless finishes.</p>
                    </div>
                    <div class="feature-card">
                        <i class="fas fa-tree"></i>
                        <h3>Quality Materials</h3>
                        <p>We source the best wood and materials for durability and beauty.</p>
                    </div>
                    <div class="feature-card">
                        <i class="fas fa-paint-brush"></i>
                        <h3>Custom Designs</h3>
                        <p>We create pieces that match your style and needs perfectly.</p>
                    </div>
                </div>
                
                <h2>Ready to Transform Your Space?</h2>
                <p>Whether you need a single piece of furniture or a complete home renovation, our carpenters are ready to help.</p>
                
                <a href="#" onclick="showDashboard(); return false;" class="back-to-dashboard"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
            </div>
        </div>
    </div>

    <!-- Blog Detail Pages -->
    <!-- Home Maintenance Blog Page -->
    <div id="home-maintenance-page" class="page-container">
        <div class="blog-detail">
            <div class="blog-detail-header">
                <h1>Essential Home Maintenance Tips for Summer</h1>
                <p>Keep your home in top condition during the hot months with these expert tips.</p>
            </div>
            <div class="blog-detail-content">
                <img src="https://i.pinimg.com/736x/f6/76/1d/f6761db73758139be3247097595433b5.jpg" alt="Home Maintenance" style="width: 100%; max-height: 400px; object-fit: cover; border-radius: 10px; margin-bottom: 30px;">
                
                <h2>1. Check Your Air Conditioning System</h2>
                <p>Summer heat puts a strain on your AC. Clean or replace filters monthly, check for refrigerant leaks, and ensure the outdoor unit is free of debris. A well-maintained AC runs efficiently and saves on energy bills.</p>
                
                <h2>2. Inspect Windows and Doors for Leaks</h2>
                <p>Seal gaps around windows and doors to keep cool air in and hot air out. Weatherstripping and caulking are inexpensive fixes that improve comfort and reduce energy costs.</p>
                
                <h2>3. Clean Gutters and Downspouts</h2>
                <p>Summer storms can bring heavy rain. Clogged gutters can lead to water damage. Clear out leaves and debris to ensure proper drainage away from your foundation.</p>
                
                <h2>4. Service Your Lawn Equipment</h2>
                <p>Sharpen mower blades, change oil, and check air filters. Well-maintained equipment makes yard work easier and extends the life of your tools.</p>
                
                <h2>5. Test Smoke and Carbon Monoxide Detectors</h2>
                <p>Replace batteries and test alarms to ensure they're working. Summer is a great time to do this twice-a-year task.</p>
                
                <div class="blog-features">
                    <div class="feature-card">
                        <i class="fas fa-snowflake"></i>
                        <h3>AC Efficiency</h3>
                        <p>Proper maintenance can reduce energy use by up to 15%.</p>
                    </div>
                    <div class="feature-card">
                        <i class="fas fa-tint"></i>
                        <h3>Prevent Water Damage</h3>
                        <p>Clean gutters protect your roof and foundation.</p>
                    </div>
                    <div class="feature-card">
                        <i class="fas fa-shield-alt"></i>
                        <h3>Safety First</h3>
                        <p>Working smoke detectors save lives.</p>
                    </div>
                </div>
                
                <a href="#" onclick="showDashboard(); return false;" class="back-to-dashboard"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
            </div>
        </div>
    </div>

    <!-- Electrical Safety Blog Page -->
    <div id="electrical-safety-page" class="page-container">
        <div class="blog-detail">
            <div class="blog-detail-header">
                <h1>Electrical Safety Tips Every Homeowner Should Know</h1>
                <p>Protect your home and family with these essential electrical safety guidelines.</p>
            </div>
            <div class="blog-detail-content">
                <img src="https://i.pinimg.com/1200x/84/a4/d3/84a4d3118b56774f6ec89d146934eb7a.jpg" alt="Electrical Safety" style="width: 100%; max-height: 400px; object-fit: cover; border-radius: 10px; margin-bottom: 30px;">
                
                <h2>1. Don't Overload Outlets</h2>
                <p>Plugging too many devices into one outlet can cause overheating and fires. Use power strips with built-in surge protectors and spread out your electronics.</p>
                
                <h2>2. Check Cords Regularly</h2>
                <p>Inspect all power cords for fraying, cracking, or damage. Replace damaged cords immediately and never run cords under rugs or furniture.</p>
                
                <h2>3. Keep Water Away from Electricity</h2>
                <p>Water and electricity are a deadly combination. Keep all electrical appliances away from sinks, bathtubs, and wet areas. Use GFCI outlets in bathrooms and kitchens.</p>
                
                <h2>4. Use the Right Wattage</h2>
                <p>Always use light bulbs with the correct wattage for your fixtures. Using a higher wattage bulb can cause overheating and fire.</p>
                
                <h2>5. Know When to Call a Professional</h2>
                <p>If you experience frequent tripping breakers, flickering lights, or sparking outlets, it's time to call a licensed electrician. DIY electrical work can be dangerous.</p>
                
                <div class="blog-features">
                    <div class="feature-card">
                        <i class="fas fa-plug"></i>
                        <h3>GFCI Outlets</h3>
                        <p>These shut off power instantly if water contact is detected.</p>
                    </div>
                    <div class="feature-card">
                        <i class="fas fa-bolt"></i>
                        <h3>Surge Protectors</h3>
                        <p>Protect your electronics from power surges.</p>
                    </div>
                    <div class="feature-card">
                        <i class="fas fa-tools"></i>
                        <h3>Professional Help</h3>
                        <p>Don't risk it – call an expert for complex issues.</p>
                    </div>
                </div>
                
                <a href="#" onclick="showDashboard(); return false;" class="back-to-dashboard"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
            </div>
        </div>
    </div>

    <!-- Car Maintenance Blog Page -->
    <div id="car-maintenance-page" class="page-container">
        <div class="blog-detail">
            <div class="blog-detail-header">
                <h1>5 Essential Car Maintenance Tips for Summer</h1>
                <p>Keep your vehicle running smoothly and safely during the hot months.</p>
            </div>
            <div class="blog-detail-content">
                <img src="https://www.intech.edu.au/app_media/2024/01/intech.png" alt="Car Maintenance" style="width: 100%; max-height: 400px; object-fit: cover; border-radius: 10px; margin-bottom: 30px;">
                
                <h2>1. Check Your Coolant Levels</h2>
                <p>Engine coolant prevents overheating. Make sure the coolant is at the proper level and mixture (50/50 water and antifreeze). Inspect hoses for cracks or leaks.</p>
                
                <h2>2. Test Your Battery</h2>
                <p>Heat can cause battery fluid to evaporate, leading to corrosion and failure. Have your battery tested and clean any corrosion from terminals.</p>
                
                <h2>3. Inspect Tires</h2>
                <p>Hot pavement increases the risk of blowouts. Check tire pressure monthly (including the spare) and inspect tread depth. Rotate tires as recommended.</p>
                
                <h2>4. Check Air Conditioning</h2>
                <p>Nobody wants a broken AC in summer. If it's not blowing cold, have it serviced. Also, replace the cabin air filter for better airflow.</p>
                
                <h2>5. Change Oil and Fluids</h2>
                <p>High temperatures can break down oil faster. Check all fluids (oil, transmission, brake, power steering, windshield washer) and top off or change as needed.</p>
                
                <div class="blog-features">
                    <div class="feature-card">
                        <i class="fas fa-temperature-high"></i>
                        <h3>Prevent Overheating</h3>
                        <p>Proper coolant levels are crucial in summer.</p>
                    </div>
                    <div class="feature-card">
                        <i class="fas fa-car-battery"></i>
                        <h3>Battery Care</h3>
                        <p>Heat can shorten battery life – test it regularly.</p>
                    </div>
                    <div class="feature-card">
                        <i class="fas fa-tire"></i>
                        <h3>Tire Safety</h3>
                        <p>Correct pressure prevents blowouts and improves fuel economy.</p>
                    </div>
                </div>
                
                <a href="#" onclick="showDashboard(); return false;" class="back-to-dashboard"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
            </div>
        </div>
    </div>

    <!-- Carpentry Tips Blog Page -->
    <div id="carpentry-tips-page" class="page-container">
        <div class="blog-detail">
            <div class="blog-detail-header">
                <h1>Expert Carpentry Tips for Homeowners</h1>
                <p>Enhance your living space with these practical carpentry skills and ideas.</p>
            </div>
            <div class="blog-detail-content">
                <img src="https://images.unsplash.com/photo-1581244277943-fe4a9c7770b0?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Carpentry Tips" style="width: 100%; max-height: 400px; object-fit: cover; border-radius: 10px; margin-bottom: 30px;">
                
                <h2>1. Choose the Right Wood for Your Project</h2>
                <p>Softwoods like pine are great for furniture, while hardwoods like oak are better for flooring and high-use items. Consider the look, durability, and cost.</p>
                
                <h2>2. Measure Twice, Cut Once</h2>
                <p>Accurate measurements save materials and frustration. Always double-check your measurements before making a cut. Use a sharp pencil for precise marks.</p>
                
                <h2>3. Keep Your Tools Sharp</h2>
                <p>Dull blades and bits make work harder and can be dangerous. Sharpen chisels, plane blades, and saw blades regularly. A well-maintained tool is a safe tool.</p>
                
                <h2>4. Use the Right Fasteners</h2>
                <p>Nails, screws, and glue each have their place. Screws provide strong joints, nails are good for framing, and wood glue adds extra strength. Pre-drill to prevent splitting.</p>
                
                <h2>5. Sand for a Smooth Finish</h2>
                <p>Start with coarse grit sandpaper and progress to finer grits for a silky-smooth surface. Always sand with the grain to avoid scratches. Finish with a sealant or paint.</p>
                
                <div class="blog-features">
                    <div class="feature-card">
                        <i class="fas fa-ruler"></i>
                        <h3>Precision</h3>
                        <p>Accurate measurements are the foundation of good carpentry.</p>
                    </div>
                    <div class="feature-card">
                        <i class="fas fa-tools"></i>
                        <h3>Sharp Tools</h3>
                        <p>Well-maintained tools make cleaner cuts and are safer.</p>
                    </div>
                    <div class="feature-card">
                        <i class="fas fa-paint-brush"></i>
                        <h3>Finishing</h3>
                        <p>Proper sanding and sealing protect your work and enhance beauty.</p>
                    </div>
                </div>
                
                <a href="#" onclick="showDashboard(); return false;" class="back-to-dashboard"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
            </div>
        </div>
    </div>

    <!-- NEW: Contact Page -->
    <div id="contact-page" class="page-container">
        <div class="contact-detail">
            <div class="contact-detail-header">
                <h1>Contact Us</h1>
                <p>We'd love to hear from you. Reach out with any questions or feedback.</p>
            </div>
            <div class="contact-detail-content">
                <div class="row">
                    <div class="col-lg-6">
                        <h2>Get in Touch</h2>
                        <p>Fill out the form below and we'll get back to you as soon as possible.</p>
                        <form id="contactForm">
                            <div class="form-group">
                                <label for="contact-name">Name *</label>
                                <input type="text" class="form-control" id="contact-name" required>
                            </div>
                            <div class="form-group">
                                <label for="contact-email">Email *</label>
                                <input type="email" class="form-control" id="contact-email" required>
                            </div>
                            <div class="form-group">
                                <label for="contact-subject">Subject *</label>
                                <input type="text" class="form-control" id="contact-subject" required>
                            </div>
                            <div class="form-group">
                                <label for="contact-message">Message *</label>
                                <textarea class="form-control" id="contact-message" rows="5" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Send Message</button>
                        </form>
                    </div>
                    <div class="col-lg-6">
                        <h2>Contact Information</h2>
                        <div class="contact-info-box">
                            <div class="contact-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <div>123 Service Street, Cityville, ST 12345</div>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-phone-alt"></i>
                                <div>(555) 123-4567</div>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-envelope"></i>
                                <div>info@localconnect.com</div>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-clock"></i>
                                <div>Mon - Fri: 9:00 AM - 6:00 PM<br>Sat: 10:00 AM - 4:00 PM<br>Sun: Closed</div>
                            </div>
                        </div>

                    </div>
                </div>
                <a href="#" onclick="showDashboard(); return false;" class="back-to-dashboard"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
            </div>
        </div>
    </div>

    <!-- NEW: About Us Page -->
    <div id="about-page" class="page-container">
        <header>
            <div class="header-container">
                <div class="logo">
                    <i class="fas fa-hands-helping"></i>
                    <h1>Local<span>service</span></h1>
                </div>
                <nav>
                    <ul>
                        <li><a href="#" onclick="showDashboard(); return false;">Home</a></li>
                        <li><a href="#" onclick="showAboutPage(); return false;" style="color:#3366FF;">About Us</a></li>
                        <li><a href="#" onclick="showContactPage(); return false;">Contact</a></li>
                    </ul>
                </nav>
                <a href="#" onclick="showDashboard(); return false;" class="cta-button"><i class="fas fa-arrow-left"></i> Back to Home</a>
            </div>
        </header>
        <div class="contact-detail" style="padding-top:50px;">
            <div class="contact-detail-header" style="background:linear-gradient(135deg,#3366FF 0%,#1A2E55 100%); animation: aboutHeaderSlide 0.8s ease-out;">
                <h1 style="animation: aboutH1 1s ease-out;">About Us</h1>
                <p>We are passionate about connecting people with trusted local service providers.</p>
            </div>
            <div class="contact-detail-content" style="animation: aboutContentFade 0.9s ease-out 0.2s both;">
                <div class="row align-items-center mb-5">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <img src="https://images.unsplash.com/photo-1521737711867-e3b97375f902?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Our Team" style="width:100%; border-radius:15px; box-shadow:0 10px 30px rgba(26,46,85,0.2);">
                    </div>
                    <div class="col-lg-6">
                        <h2 style="color:#1A2E55; margin-bottom:20px;">Who We Are</h2>
                        <p style="color:#555; line-height:1.8;">LocalService is a platform dedicated to bridging the gap between homeowners and skilled professionals. We believe everyone deserves access to reliable, affordable, and quality home services.</p>
                        <p style="color:#555; line-height:1.8;">Founded with a mission to make home maintenance stress-free, our platform connects you with verified plumbers, electricians, mechanics, and carpenters in your local area.</p>
                        <div class="service-features" style="margin-top:30px;">
                            <div class="feature-card" style="animation: featureFloat 3s ease-in-out infinite;">
                                <i class="fas fa-star" style="color:#FFD700;"></i>
                                <h3>Trusted Pros</h3>
                                <p>All professionals are vetted and verified.</p>
                            </div>
                            <div class="feature-card" style="animation: featureFloat 3s ease-in-out 0.5s infinite;">
                                <i class="fas fa-shield-alt"></i>
                                <h3>Secure & Safe</h3>
                                <p>Your safety and satisfaction is our priority.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <h2 style="color:#1A2E55; text-align:center; margin-bottom:30px;">Our Mission & Values</h2>
                <div class="service-features">
                    <div class="feature-card" style="animation: featureFloat 3s ease-in-out infinite;">
                        <i class="fas fa-handshake"></i>
                        <h3>Trust</h3>
                        <p>We build lasting relationships between clients and professionals based on honesty and reliability.</p>
                    </div>
                    <div class="feature-card" style="animation: featureFloat 3s ease-in-out 0.4s infinite;">
                        <i class="fas fa-award"></i>
                        <h3>Quality</h3>
                        <p>We maintain high standards in every service we facilitate, ensuring top-notch work every time.</p>
                    </div>
                    <div class="feature-card" style="animation: featureFloat 3s ease-in-out 0.8s infinite;">
                        <i class="fas fa-users"></i>
                        <h3>Community</h3>
                        <p>We empower local professionals and strengthen local economies by keeping work in the community.</p>
                    </div>
                </div>
                
                <div style="background:linear-gradient(135deg,#3366FF,#1A2E55); border-radius:15px; padding:40px; text-align:center; margin-top:40px; color:white;">
                    <h2 style="color:white; margin-bottom:15px;">Ready to Get Started?</h2>
                    <p style="color:#D6E4FF; margin-bottom:25px;">Join thousands of satisfied customers who trust LocalService for all their home service needs.</p>
                    <a href="#" onclick="showDashboard(); return false;" class="cta-button" style="background:white; color:#3366FF; font-weight:700;">Explore Our Services</a>
                </div>
                
                <a href="#" onclick="showDashboard(); return false;" class="back-to-dashboard" style="margin-top:30px; display:inline-block;"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // ============================================================
        // PHP-INJECTED SESSION STATE
        // ============================================================
        const IS_LOGGED_IN  = <?php echo $isLoggedIn ? 'true' : 'false'; ?>;
        const CURRENT_USER  = <?php echo json_encode($userEmail); ?>;
        const CURRENT_NAME  = <?php echo json_encode($userName); ?>;

        // ============================================================
        // PAGE NAVIGATION FUNCTIONS
        // ============================================================
        function showDashboard() {
            document.querySelectorAll('.page-container').forEach(p => p.classList.remove('active-page'));
            document.getElementById('dashboard-page').classList.add('active-page');
            window.scrollTo(0, 0);
        }

        function showServicePage(service) {
            document.querySelectorAll('.page-container').forEach(p => p.classList.remove('active-page'));
            document.getElementById(service + '-page').classList.add('active-page');
            window.scrollTo(0, 0);
        }

        function showBlogPage(blogId) {
            document.querySelectorAll('.page-container').forEach(p => p.classList.remove('active-page'));
            document.getElementById(blogId + '-page').classList.add('active-page');
            window.scrollTo(0, 0);
        }

        function showContactPage() {
            document.querySelectorAll('.page-container').forEach(p => p.classList.remove('active-page'));
            document.getElementById('contact-page').classList.add('active-page');
            window.scrollTo(0, 0);
        }

        function showAboutPage() {
            document.querySelectorAll('.page-container').forEach(p => p.classList.remove('active-page'));
            document.getElementById('about-page').classList.add('active-page');
            window.scrollTo(0, 0);
        }

        // ============================================================
        // HEADER BUTTON EVENTS
        // ============================================================
        document.getElementById('login-button')?.addEventListener('click', function() {
            document.querySelectorAll('.page-container').forEach(p => p.classList.remove('active-page'));
            document.getElementById('login-page').classList.add('active-page');
            window.scrollTo(0, 0);
        });

        document.getElementById('logout-button')?.addEventListener('click', function() {
            fetch('logout_user.php')
                .then(() => { window.location.href = 'dashboard_new_connected.php'; });
        });

        document.getElementById('join-as-pro')?.addEventListener('click', function() {
            // Approved providers go to login, new ones go to register tab
            window.location.href = 'provider_login.html';
        });

        document.getElementById('back-to-home')?.addEventListener('click', function(e) {
            e.preventDefault(); showDashboard();
        });

        document.getElementById('back-to-home-signup')?.addEventListener('click', function(e) {
            e.preventDefault(); showDashboard();
        });

        document.getElementById('cross-btn')?.addEventListener('click', function(e) {
            e.preventDefault(); showDashboard();
        });

        // ============================================================
        // NOTIFICATION SYSTEM  (Database-backed)
        // ============================================================
        let notifications = [];
        const NOTIF_KEY = 'localConnectNotifications_v2';

        function loadNotifications() {
            if (IS_LOGGED_IN && CURRENT_USER) {
                fetch('get_notifications.php?email=' + encodeURIComponent(CURRENT_USER))
                    .then(r => r.json())
                    .then(data => {
                        notifications = data.map(n => ({
                            id: parseInt(n.id),
                            title: n.title || 'Notification',
                            message: n.message,
                            icon: n.icon || 'fas fa-bell',
                            read: n.is_read == 1
                        }));
                        updateBellBadge();
                        renderNotificationPanel();
                    })
                    .catch(() => {
                        // Fallback: load from localStorage
                        const stored = localStorage.getItem(NOTIF_KEY);
                        notifications = stored ? JSON.parse(stored) : [];
                        updateBellBadge();
                    });
            } else {
                const stored = localStorage.getItem(NOTIF_KEY);
                notifications = stored ? JSON.parse(stored) : [];
                updateBellBadge();
            }
        }

        function saveNotifications() {
            localStorage.setItem(NOTIF_KEY, JSON.stringify(notifications));
        }

        function addNotification(title, message, icon = 'fas fa-bell') {
            const notif = { id: Date.now(), title, message, icon, read: false };
            notifications.unshift(notif);
            if (notifications.length > 20) notifications.pop();
            saveNotifications();
            updateBellBadge();
        }

        function updateBellBadge() {
            const count = notifications.filter(n => !n.read).length;
            const badge = document.getElementById('bellBadge');
            if (badge) {
                badge.textContent = count;
                badge.style.display = count > 0 ? 'flex' : 'none';
            }
        }

        function markAsRead(id) {
            const n = notifications.find(x => x.id === id);
            if (n) { n.read = true; saveNotifications(); updateBellBadge(); renderNotificationPanel(); }
            if (IS_LOGGED_IN) {
                fetch('mark_notification_read.php?id=' + id).catch(() => {});
            }
        }

        function markAllAsRead() {
            notifications.forEach(n => n.read = true);
            saveNotifications(); updateBellBadge(); renderNotificationPanel();
            if (IS_LOGGED_IN) {
                fetch('mark_all_notifications_read.php?email=' + encodeURIComponent(CURRENT_USER)).catch(() => {});
            }
        }

        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/[&<>]/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;'}[m]));
        }

        function renderNotificationPanel() {
            const list = document.getElementById('notificationList');
            if (!list) return;
            if (notifications.length === 0) {
                list.innerHTML = '<div class="empty-notif">✨ No notifications yet</div>';
                return;
            }
            list.innerHTML = notifications.map(n => `
                <div class="notif-item ${n.read ? '' : 'unread'}" data-id="${n.id}">
                    <div class="notif-icon"><i class="${escapeHtml(n.icon)}"></i></div>
                    <div class="notif-content">
                        <strong>${escapeHtml(n.title)}</strong>
                        <p>${escapeHtml(n.message)}</p>
                    </div>
                    ${!n.read ? `<button class="mark-read-btn" data-id="${n.id}" title="Mark read">✓</button>` : ''}
                </div>`).join('');

            document.querySelectorAll('.mark-read-btn').forEach(btn => {
                btn.addEventListener('click', (e) => { e.stopPropagation(); markAsRead(parseInt(btn.getAttribute('data-id'))); });
            });
            document.querySelectorAll('.notif-item').forEach(item => {
                const id = parseInt(item.getAttribute('data-id'));
                const n  = notifications.find(x => x.id === id);
                if (n && !n.read) item.addEventListener('click', () => markAsRead(id));
            });
            const markAllBtn = document.getElementById('markAllReadBtn');
            if (markAllBtn) markAllBtn.addEventListener('click', (e) => { e.stopPropagation(); markAllAsRead(); });
        }

        const bellIcon    = document.getElementById('globalBellIcon');
        const panel       = document.getElementById('notificationPanel');
        const closePanelBtn = document.getElementById('closePanelBtn');

        bellIcon?.addEventListener('click', (e) => {
            e.stopPropagation();
            panel.classList.toggle('show');
            if (panel.classList.contains('show')) renderNotificationPanel();
        });
        closePanelBtn?.addEventListener('click', () => panel.classList.remove('show'));
        document.addEventListener('click', function(e) {
            if (!bellIcon?.contains(e.target) && !panel?.contains(e.target)) panel?.classList.remove('show');
        });

        // ============================================================
        // TOGGLE FORMS
        // ============================================================
        document.getElementById('show-signup')?.addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('login-form').classList.remove('active');
            document.getElementById('signup-form').classList.add('active');
        });

        document.getElementById('show-login')?.addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('signup-form').classList.remove('active');
            document.getElementById('login-form').classList.add('active');
        });

        // ============================================================
        // PASSWORD TOGGLE
        // ============================================================
        function setupPasswordToggle(toggleId, passwordId) {
            const toggle = document.getElementById(toggleId);
            const password = document.getElementById(passwordId);
            if (!toggle || !password) return;
            toggle.addEventListener('click', function() {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                const icon = toggle.querySelector('i');
                if (icon) {
                    icon.classList.toggle('fa-eye', type === 'password');
                    icon.classList.toggle('fa-eye-slash', type === 'text');
                }
            });
        }

        setupPasswordToggle('toggleLoginPassword',      'login-password');
        setupPasswordToggle('toggleSignupPassword',     'signup-password');
        setupPasswordToggle('toggleConfirmPassword',    'confirm-password');
        setupPasswordToggle('toggleProPassword',        'pro-password');
        setupPasswordToggle('toggleProConfirmPassword', 'pro-confirm-password');

        // ============================================================
        // SIGNUP FORM (User) — DATABASE
        // ============================================================
        document.getElementById('signupForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const firstName = document.getElementById('first-name').value.trim();
            const lastName  = document.getElementById('last-name').value.trim();
            const email     = document.getElementById('signup-email').value.trim();
            const password  = document.getElementById('signup-password').value;
            const confirm   = document.getElementById('confirm-password').value;
            const dob       = document.getElementById('dob').value;
            const service   = document.getElementById('services').value;

            if (password !== confirm) { alert('Passwords do not match!'); return; }
            if (password.trim() === '') { alert('Please enter a password'); return; }

            const fd = new FormData();
            fd.append('firstName', firstName);
            fd.append('lastName',  lastName);
            fd.append('email',     email);
            fd.append('password',  password);
            fd.append('dob',       dob);
            fd.append('service',   service);

            fetch('register.php', { method: 'POST', body: fd })
                .then(r => r.text())
                .then(res => {
                    if (res.trim() === 'success') {
                        alert('✅ Account created successfully! Please login.');
                        this.reset();
                        document.getElementById('signup-form').classList.remove('active');
                        document.getElementById('login-form').classList.add('active');
                    } else if (res.includes('already exists')) {
                        alert('⚠️ Email already registered. Please login.');
                    } else {
                        alert('Registration error: ' + res);
                    }
                })
                .catch(() => alert('Network error. Please try again.'));
        });

        // ============================================================
        // LOGIN FORM — DATABASE + PHP SESSION
        // ============================================================
        document.getElementById('loginForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const email    = document.getElementById('login-email').value.trim();
            const password = document.getElementById('login-password').value;
            const loginError = document.getElementById('login-error');

            const fd = new FormData();
            fd.append('email',    email);
            fd.append('password', password);

            fetch('login_session.php', { method: 'POST', body: fd })
                .then(r => r.text())
                .then(res => {
                    const parts = res.trim().split('|');
                    if (parts[0] === 'success') {
                        if (loginError) loginError.style.display = 'none';
                        const redirectTo = sessionStorage.getItem('redirectAfterLogin');
            sessionStorage.removeItem('redirectAfterLogin');
            // replace() instead of href — removes login page from history
            // so browser back button goes to dashboard, not login page
            window.location.replace(redirectTo || 'dashboard_new_connected.php');
                    } else {
                        if (loginError) {
                            loginError.textContent = res.includes('not found') ? 'Email not found. Please sign up first.' : 'Invalid password. Please try again.';
                            loginError.style.display = 'block';
                        }
                    }
                })
                .catch(() => { if(loginError){ loginError.textContent='Network error.'; loginError.style.display='block'; }});
        });

        document.getElementById('forgot-password-link')?.addEventListener('click', function(e) {
            e.preventDefault();
            alert('Please contact admin to reset your password.');
        });

        // ============================================================
        // PROFESSIONAL REGISTRATION FORM — DATABASE
        // ============================================================
        function validateCNIC(cnic)  { return /^[0-9]{5}-[0-9]{7}-[0-9]{1}$/.test(cnic); }
        function validatePhone(phone) { return /^03[0-9]{2}-[0-9]{7}$/.test(phone); }

        function validateProForm() {
            const pass    = document.getElementById('pro-password')?.value || '';
            const confirm = document.getElementById('pro-confirm-password')?.value || '';
            const confErr = document.getElementById('pro-confirm-error');
            if (pass && confirm && pass !== confirm) {
                if (confErr) { confErr.textContent = 'Passwords do not match'; confErr.style.display = 'block'; }
            } else if (confErr) { confErr.style.display = 'none'; }
        }

        document.getElementById('pro-password')?.addEventListener('input', validateProForm);
        document.getElementById('pro-confirm-password')?.addEventListener('input', validateProForm);

        document.getElementById('professionalForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const firstName  = document.getElementById('pro-first-name').value.trim();
            const lastName   = document.getElementById('pro-last-name').value.trim();
            const cnic       = document.getElementById('pro-cnic').value.trim();
            const phone      = document.getElementById('pro-phone').value.trim();
            const email      = document.getElementById('pro-email').value.trim();
            const city       = document.getElementById('pro-city').value;
            const area       = document.getElementById('pro-area').value;
            const service    = document.getElementById('pro-service').value;
            const experience = document.getElementById('pro-experience').value;
            const password   = document.getElementById('pro-password').value;
            const confirm    = document.getElementById('pro-confirm-password').value;

            const cnicError  = document.getElementById('cnic-error');
            const emailError = document.getElementById('pro-email-error');

            if (!validateCNIC(cnic)) {
                if (cnicError) { cnicError.textContent = 'Invalid CNIC format (e.g. 12345-1234567-1)'; cnicError.style.display = 'block'; }
                return;
            }
            if (cnicError) cnicError.style.display = 'none';

            if (!validatePhone(phone)) {
                alert('Invalid phone format (e.g. 03XX-XXXXXXX)');
                return;
            }
            if (password !== confirm) { alert('Passwords do not match!'); return; }

            const fd = new FormData();
            fd.append('firstName',  firstName);
            fd.append('lastName',   lastName);
            fd.append('email',      email);
            fd.append('password',   password);
            fd.append('phone',      phone);
            fd.append('city',       city);
            fd.append('area',       area);
            fd.append('service',    service);
            fd.append('experience', experience);

            const successMsg = document.getElementById('pro-success');
            const submitBtn  = document.getElementById('pro-submit-btn');
            if (submitBtn) submitBtn.disabled = true;

            fetch('register_provider.php', { method: 'POST', body: fd })
                .then(r => r.text())
                .then(res => {
                    if (submitBtn) submitBtn.disabled = false;
                    const trimmed = res.trim();
                    if (trimmed.includes('success')) {
                        if (successMsg) { successMsg.textContent = '✅ Application submitted! Pending admin approval.'; successMsg.style.display = 'block'; }
                        this.reset();
                        setTimeout(() => { window.location.href = 'provider_login.html'; }, 3000);
                    } else if (trimmed === 'email_exists') {
                        if (emailError) { emailError.textContent = 'Email already registered'; emailError.style.display = 'block'; }
                    } else {
                        alert('Registration error. Please try again.\n' + trimmed);
                    }
                })
                .catch(() => { if(submitBtn) submitBtn.disabled=false; alert('Network error. Please try again.'); });
        });

        // ============================================================
        // SLIDESHOW
        // ============================================================
        let currentSlide = 0;
        const slides     = document.querySelectorAll('.slide');
        const dots       = document.querySelectorAll('.nav-dot');
        const totalSlides = slides.length;

        function showSlide(n) {
            if (n >= totalSlides) currentSlide = 0;
            else if (n < 0) currentSlide = totalSlides - 1;
            else currentSlide = n;
            const sc = document.querySelector('.slides');
            if (sc) sc.style.transform = `translateX(-${currentSlide * 100}%)`;
            dots.forEach((dot, i) => dot.classList.toggle('active', i === currentSlide));
        }

        const nextBtn = document.querySelector('.next');
        const prevBtn = document.querySelector('.prev');
        if (nextBtn) nextBtn.addEventListener('click', () => showSlide(currentSlide + 1));
        if (prevBtn) prevBtn.addEventListener('click', () => showSlide(currentSlide - 1));
        dots.forEach((dot, i) => dot.addEventListener('click', () => showSlide(i)));
        setInterval(() => showSlide(currentSlide + 1), 5000);

        // ============================================================
        // SMOOTH SCROLLING
        // ============================================================
        document.querySelectorAll('nav a[href^="#"], .cta-button[href^="#"]').forEach(link => {
            link.addEventListener('click', function(e) {
                const targetId = this.getAttribute('href');
                if (targetId && targetId !== '#') {
                    e.preventDefault();
                    const el = document.querySelector(targetId);
                    if (el) window.scrollTo({ top: el.offsetTop - 80, behavior: 'smooth' });
                }
            });
        });

        // ============================================================
        // INITIALIZE
        // ============================================================
        // ── Require login before accessing service pages ──
        function requireLogin(page) {
            const isLoggedIn = <?php echo $isLoggedIn ? 'true' : 'false'; ?>;
            if (isLoggedIn) {
                window.location.href = page;
            } else {
                // Show login page with a message
                document.querySelectorAll('.page-container').forEach(p => p.classList.remove('active-page'));
                document.getElementById('login-page').classList.add('active-page');
                window.scrollTo(0, 0);
                // Show hint message
                const hint = document.getElementById('login-required-hint');
                if (hint) hint.style.display = 'block';
                // Store intended page for after login
                sessionStorage.setItem('redirectAfterLogin', page);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // If redirected here because login required
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('require_login') === '1') {
                document.querySelectorAll('.page-container').forEach(p => p.classList.remove('active-page'));
                document.getElementById('login-page').classList.add('active-page');
                const hint = document.getElementById('login-required-hint');
                if (hint) hint.style.display = 'block';
                window.scrollTo(0, 0);
            }
            validateProForm();
            loadNotifications();

            // Welcome notification for new visitors
            if (!IS_LOGGED_IN) {
                const stored = localStorage.getItem(NOTIF_KEY);
                if (!stored) {
                    setTimeout(() => addNotification("👋 Welcome to LocalService", "We're here to help you find trusted local professionals!", "fas fa-smile-wink"), 1000);
                }
            }
        });
    </script>
</body>
</html>