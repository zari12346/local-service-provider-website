<?php
session_start();
if (!isset($_SESSION['provider_email'])) {
    header('Location: provider_login.html');
    exit();
}
$providerEmail = $_SESSION['provider_email'];
$providerName  = $_SESSION['provider_name'] ?? 'Provider';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>LocalConnect | Service Provider Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif; }
        body { background: #F1F5F9; min-height: 100vh; }
        .dashboard-container { display: flex; min-height: 100vh; }
        .sidebar { width: 280px; background: #0F172A; color: #E2E8F0; position: fixed; height: 100vh; overflow-y: auto; z-index: 10; transition: all 0.3s ease; box-shadow: 4px 0 20px rgba(0,0,0,0.08); }
        .sidebar-header { padding: 28px 24px; border-bottom: 1px solid rgba(255,255,255,0.08); }
        .sidebar-header h2 { font-size: 26px; font-weight: 700; background: linear-gradient(135deg, #FFFFFF 0%, #94A3B8 100%); -webkit-background-clip: text; background-clip: text; color: transparent; }
        .sidebar-header h2 span { background: linear-gradient(135deg, #FBBF24 0%, #F59E0B 100%); -webkit-background-clip: text; background-clip: text; color: transparent; }
        .provider-info { padding: 24px; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.08); margin-bottom: 8px; }
        .provider-avatar { width: 88px; height: 88px; background: linear-gradient(135deg, #3B82F6, #2563EB); border-radius: 50%; margin: 0 auto 16px; display: flex; align-items: center; justify-content: center; font-size: 38px; color: white; box-shadow: 0 8px 20px rgba(59,130,246,0.3); border: 3px solid rgba(255,255,255,0.2); }
        .provider-name { font-size: 18px; font-weight: 700; margin-bottom: 6px; color: white; }
        .provider-service { font-size: 13px; color: #FBBF24; font-weight: 500; margin-bottom: 12px; letter-spacing: 0.3px; }
        .status-badge { display: inline-flex; align-items: center; gap: 6px; padding: 5px 14px; background: rgba(34,197,94,0.15); border-radius: 40px; font-size: 12px; font-weight: 500; color: #4ADE80; border: 1px solid rgba(74,222,128,0.3); }
        .status-badge:before { content: "●"; font-size: 10px; }
        .nav-menu { list-style: none; padding: 16px 16px; }
        .nav-item { margin-bottom: 6px; }
        .nav-link { display: flex; align-items: center; padding: 12px 18px; color: #CBD5E1; text-decoration: none; gap: 14px; border-radius: 14px; transition: all 0.2s; cursor: pointer; font-weight: 500; font-size: 15px; }
        .nav-link:hover { background: rgba(59,130,246,0.15); color: white; }
        .nav-link.active { background: #3B82F6; color: white; box-shadow: 0 4px 10px rgba(59,130,246,0.3); }
        .nav-link i { width: 24px; font-size: 1.2rem; }
        .main-content { flex: 1; margin-left: 280px; padding: 28px 32px; }
        .top-bar { background: white; border-radius: 24px; padding: 16px 28px; margin-bottom: 32px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.05); border: 1px solid #E2E8F0; }
        .page-title { font-size: 26px; font-weight: 700; color: #0F172A; letter-spacing: -0.3px; }
        .logout-btn { background: #FEF2F2; color: #DC2626; border: 1px solid #FECACA; padding: 10px 24px; border-radius: 40px; cursor: pointer; font-weight: 600; font-size: 14px; transition: 0.2s; display: flex; align-items: center; gap: 8px; }
        .logout-btn:hover { background: #DC2626; color: white; border-color: #DC2626; }
        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-bottom: 36px; }
        .stat-card { background: white; border-radius: 24px; padding: 24px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 6px -2px rgba(0,0,0,0.05); border: 1px solid #E2E8F0; transition: all 0.2s; }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 20px 25px -12px rgba(0,0,0,0.1); }
        .stat-info h3 { font-size: 34px; font-weight: 800; color: #0F172A; line-height: 1.2; }
        .stat-info p { color: #64748B; font-size: 14px; font-weight: 500; margin-top: 6px; }
        .stat-icon { width: 56px; height: 56px; background: #EFF6FF; border-radius: 18px; display: flex; align-items: center; justify-content: center; font-size: 28px; color: #3B82F6; }
        .section-card { background: white; border-radius: 24px; padding: 28px; margin-bottom: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); border: 1px solid #E2E8F0; transition: all 0.2s; }
        .card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 12px; }
        .card-header h3 { color: #0F172A; font-size: 20px; font-weight: 700; display: flex; align-items: center; gap: 12px; }
        .card-header h3 i { color: #3B82F6; font-size: 22px; }
        .btn-primary { background: #3B82F6; color: white; border: none; padding: 10px 20px; border-radius: 40px; cursor: pointer; font-weight: 600; font-size: 14px; transition: all 0.2s; display: inline-flex; align-items: center; gap: 8px; }
        .btn-primary:hover { background: #2563EB; transform: scale(0.98); }
        .location-card { background: linear-gradient(135deg, #F8FAFE 0%, #F1F5F9 100%); border-radius: 20px; padding: 20px; margin-bottom: 0; border: 1px solid #E2E8F0; }
        .location-header { display: flex; align-items: center; gap: 12px; margin-bottom: 14px; }
        .location-header i { font-size: 28px; color: #3B82F6; }
        .location-address { font-size: 16px; font-weight: 600; color: #1E293B; margin-bottom: 12px; line-height: 1.4; }
        .location-detail { color: #475569; font-size: 14px; display: flex; align-items: center; gap: 16px; flex-wrap: wrap; }
        .location-badge { background: #EFF6FF; padding: 6px 14px; border-radius: 40px; font-size: 13px; color: #2563EB; font-weight: 500; }
        .open-map-btn { background: white; border: 1px solid #CBD5E1; color: #1E293B; padding: 6px 16px; border-radius: 40px; cursor: pointer; transition: 0.2s; font-weight: 500; }
        .open-map-btn:hover { background: #3B82F6; border-color: #3B82F6; color: white; }
        .service-item { display: flex; justify-content: space-between; align-items: center; padding: 18px; background: #F8FAFC; border-radius: 20px; margin-bottom: 12px; transition: all 0.2s; border: 1px solid #E2E8F0; }
        .service-info h4 { font-size: 17px; font-weight: 700; margin-bottom: 6px; color: #0F172A; }
        .service-info p { color: #475569; font-size: 14px; }
        .service-actions button { padding: 8px 16px; margin-left: 10px; border: none; border-radius: 30px; font-weight: 500; cursor: pointer; transition: 0.2s; }
        .edit-btn { background: #FEF3C7; color: #B45309; }
        .toggle-btn { background: #DCFCE7; color: #15803D; }
        .toggle-btn.off { background: #FEE2E2; color: #B91C1C; }
        .booking-card { background: #F9FAFB; border-radius: 20px; padding: 20px; margin-bottom: 16px; border: 1px solid #E5E7EB; transition: all 0.2s; }
        .booking-card:hover { border-color: #CBD5E1; box-shadow: 0 4px 12px rgba(0,0,0,0.03); }
        .booking-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
        .booking-date { color: #3B82F6; font-weight: 600; font-size: 13px; background: #EFF6FF; padding: 4px 12px; border-radius: 50px; display: inline-block; }
        .booking-customer { font-weight: 800; color: #0F172A; margin-bottom: 8px; font-size: 16px; display: flex; align-items: center; gap: 8px; }
        .booking-details { color: #475569; font-size: 14px; margin-bottom: 6px; display: flex; align-items: center; gap: 8px; }
        .status { padding: 4px 12px; border-radius: 40px; font-size: 12px; font-weight: 600; }
        .status-pending { background: #FEF3C7; color: #B45309; }
        .status-confirmed { background: #DCFCE7; color: #15803D; }
        .status-completed { background: #DBEAFE; color: #1E40AF; }
        .booking-actions { margin-top: 14px; display: flex; gap: 12px; }
        .booking-actions button { padding: 8px 18px; border: none; border-radius: 40px; font-weight: 600; cursor: pointer; transition: 0.2s; }
        .accept-btn { background: #3B82F6; color: white; }
        .reject-btn { background: #FEE2E2; color: #DC2626; }
        .call-btn { background: #EFF6FF; color: #2563EB; }
        .feedback-stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 25px; }
        .feedback-stat-card { background: white; border-radius: 20px; padding: 20px; text-align: center; border: 1px solid #E2E8F0; transition: all 0.2s; }
        .feedback-stat-card:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
        .feedback-stat-icon { font-size: 32px; margin-bottom: 10px; }
        .feedback-stat-number { font-size: 28px; font-weight: 800; color: #0F172A; }
        .feedback-stat-label { font-size: 12px; color: #64748B; margin-top: 5px; }
        .provider-rating-box { background: linear-gradient(135deg, #FEF3C7, #FDE68A); padding: 12px 24px; border-radius: 50px; display: inline-flex; align-items: center; gap: 12px; }
        .provider-stars { color: #FBBF24; font-size: 18px; letter-spacing: 2px; }
        .feedback-card-item { background: #F8FAFC; border-radius: 20px; padding: 20px; margin-bottom: 16px; border-left: 4px solid #3B82F6; transition: all 0.2s; }
        .feedback-card-item:hover { background: white; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .feedback-header-row { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; margin-bottom: 12px; }
        .feedback-customer { font-weight: 700; color: #0F172A; display: flex; align-items: center; gap: 8px; }
        .feedback-stars { color: #FBBF24; font-size: 14px; }
        .feedback-service-badge { background: #EFF6FF; padding: 4px 12px; border-radius: 30px; font-size: 11px; color: #2563EB; display: inline-block; margin: 8px 0; }
        .feedback-message { color: #475569; line-height: 1.5; margin: 10px 0; }
        .feedback-date { font-size: 11px; color: #94A3B8; margin-top: 8px; }
        .manual-badge { background: #8B5CF6; color: white; font-size: 10px; padding: 2px 8px; border-radius: 20px; margin-left: 8px; }
        .reply-box { background: #EFF6FF; border-radius: 16px; padding: 12px; margin-top: 12px; font-size: 13px; }
        .reply-box i { color: #3B82F6; margin-right: 6px; }
        .reply-btn-sm { background: none; border: 1px solid #3B82F6; color: #3B82F6; padding: 4px 14px; border-radius: 30px; font-size: 11px; cursor: pointer; transition: 0.2s; margin-top: 10px; }
        .reply-btn-sm:hover { background: #3B82F6; color: white; }
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); backdrop-filter: blur(4px); justify-content: center; align-items: center; z-index: 1000; }
        .modal.active { display: flex; }
        .modal-content { background: white; border-radius: 32px; width: 90%; max-width: 500px; padding: 28px; animation: fadeInUp 0.2s ease; }
        @keyframes fadeInUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; font-weight: 700; }
        .close-modal { background: none; border: none; font-size: 28px; cursor: pointer; color: #94A3B8; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #334155; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 12px 16px; border: 1px solid #CBD5E1; border-radius: 16px; font-size: 14px; transition: 0.2s; }
        .form-group input:focus, .form-group textarea:focus, .form-group select:focus { outline: none; border-color: #3B82F6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
        .tab-content { display: none; }
        .tab-content.active { display: block; animation: fadeIn 0.25s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(6px);} to { opacity: 1; transform: translateY(0);} }
        .empty-state { text-align: center; padding: 48px 20px; color: #64748B; background: #F8FAFC; border-radius: 24px; font-size: 15px; }
        @media (max-width: 768px) { .sidebar { width: 80px; } .sidebar-header h2, .provider-info p, .nav-link span, .provider-name, .provider-service, .status-badge { display: none; } .provider-info { padding: 16px 0; } .provider-avatar { width: 48px; height: 48px; font-size: 24px; } .main-content { margin-left: 80px; padding: 20px 16px; } .stats-grid { grid-template-columns: 1fr; gap: 16px; } .feedback-stats-grid { grid-template-columns: repeat(2, 1fr); } .top-bar { flex-direction: column; gap: 12px; align-items: flex-start; } }
    </style>
</head>
<body>

<div class="dashboard-container">
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>Local<span>Service Provider</span></h2>
        </div>
        <div class="provider-info">
            <div class="provider-avatar">
                <i class="fas fa-user-tie"></i>
            </div>
            <div class="provider-name" id="providerName">Loading...</div>
            <div class="provider-service" id="providerService">Loading...</div>
            <span class="status-badge">Active</span>
        </div>
        <ul class="nav-menu">
            <li class="nav-item"><div class="nav-link active" data-tab="dashboard"><i class="fas fa-th-large"></i> <span>Dashboard</span></div></li>
            <li class="nav-item"><div class="nav-link" data-tab="services"><i class="fas fa-wrench"></i> <span>My Services</span></div></li>
            <li class="nav-item"><div class="nav-link" data-tab="bookings"><i class="fas fa-calendar-alt"></i> <span>Bookings</span></div></li>
            <li class="nav-item"><div class="nav-link" data-tab="feedback-tab"><i class="fas fa-star"></i> <span>Feedback</span></div></li>
            <li class="nav-item"><div class="nav-link" data-tab="profile"><i class="fas fa-user-circle"></i> <span>Profile</span></div></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="top-bar">
            <h1 class="page-title" id="pageTitle">Dashboard</h1>
            <button class="logout-btn" id="logoutBtn"><i class="fas fa-arrow-right-from-bracket"></i> Logout</button>
        </div>

        <div id="tab-dashboard" class="tab-content active">
            <div class="stats-grid">
                <div class="stat-card"><div class="stat-info"><h3 id="totalBookings">0</h3><p>Total Bookings</p></div><div class="stat-icon"><i class="fas fa-calendar-check"></i></div></div>
                <div class="stat-card"><div class="stat-info"><h3 id="pendingRequests">0</h3><p>Pending Requests</p></div><div class="stat-icon"><i class="fas fa-hourglass-half"></i></div></div>
                <div class="stat-card"><div class="stat-info"><h3 id="completedJobs">0</h3><p>Completed Jobs</p></div><div class="stat-icon"><i class="fas fa-circle-check"></i></div></div>
            </div>
            <div class="section-card"><div class="card-header"><h3><i class="fas fa-map-pin"></i> Service Location</h3></div><div id="providerLocationWidget"></div></div>
            <div class="section-card">
                <div class="card-header"><h3><i class="fas fa-bell"></i> Recent Booking Requests</h3><button class="btn-primary" onclick="switchTab('bookings')">View All →</button></div>
                <div id="recentRequests"></div>
            </div>
            <div class="section-card"><div class="card-header"><h3><i class="fas fa-lightbulb"></i> Pro Tips</h3></div>
                <ul style="margin-left: 20px; color: #334155; display: flex; flex-direction: column; gap: 10px;">
                    <li><i class="fas fa-check-circle" style="color:#10B981;"></i> Respond to booking requests quickly to boost acceptance rate</li>
                    <li><i class="fas fa-chart-line" style="color:#3B82F6;"></i> Keep service prices competitive & update regularly</li>
                    <li><i class="fas fa-star" style="color:#FBBF24;"></i> Quality service leads to better ratings and more clients</li>
                    <li><i class="fas fa-location-dot" style="color:#EF4444;"></i> Keep your address accurate for better customer trust</li>
                </ul>
            </div>
        </div>

        <div id="tab-services" class="tab-content">
            <div class="section-card"><div class="card-header"><h3><i class="fas fa-tools"></i> My Service Offerings</h3><button class="btn-primary" id="addServiceBtn"><i class="fas fa-plus-circle"></i> Add Service</button></div><div id="servicesList"></div></div>
        </div>

        <div id="tab-bookings" class="tab-content">
            <div class="section-card"><div class="card-header"><h3><i class="fas fa-clock"></i> Pending Requests</h3></div><div id="pendingBookingsList"></div></div>
            <div class="section-card"><div class="card-header"><h3><i class="fas fa-calendar-week"></i> Upcoming & Completed</h3></div><div id="confirmedBookingsList"></div></div>
        </div>

        <div id="tab-feedback-tab" class="tab-content">
            <div class="section-card">
                <div class="card-header"><h3><i class="fas fa-star"></i> Customer Feedback & Reviews</h3><div class="provider-rating-box" id="providerRatingBox"><i class="fas fa-medal"></i><span>Your Rating:</span><span class="provider-stars" id="providerStarsDisplay">☆☆☆☆☆</span><span id="providerRatingCount">(0 reviews)</span></div></div>
                <div style="text-align: right; margin-bottom: 20px;"><button class="btn-primary" id="manualFeedbackBtn" style="background: #8B5CF6;"><i class="fas fa-pen-alt"></i> Add Manual Feedback</button></div>
                <div class="feedback-stats-grid">
                    <div class="feedback-stat-card"><div class="feedback-stat-icon"><i class="fas fa-smile" style="color:#2ed573;"></i></div><div class="feedback-stat-number" id="positiveCount">0</div><div class="feedback-stat-label">Positive (4-5★)</div></div>
                    <div class="feedback-stat-card"><div class="feedback-stat-icon"><i class="fas fa-meh" style="color:#FFD700;"></i></div><div class="feedback-stat-number" id="neutralCount">0</div><div class="feedback-stat-label">Neutral (3★)</div></div>
                    <div class="feedback-stat-card"><div class="feedback-stat-icon"><i class="fas fa-frown" style="color:#ff4757;"></i></div><div class="feedback-stat-number" id="negativeCount">0</div><div class="feedback-stat-label">Needs Improvement</div></div>
                    <div class="feedback-stat-card"><div class="feedback-stat-icon"><i class="fas fa-reply-all" style="color:#3B82F6;"></i></div><div class="feedback-stat-number" id="responseCount">0</div><div class="feedback-stat-label">Replies Sent</div></div>
                </div>
                <div id="providerFeedbacksList" style="max-height: 500px; overflow-y: auto;"></div>
            </div>
        </div>

        <div id="tab-profile" class="tab-content">
            <div class="section-card"><div class="card-header"><h3><i class="fas fa-id-card"></i> Personal Information</h3></div>
                <form id="profileForm">
                    <div class="form-group"><label>Full Name</label><input type="text" id="profileFullName" placeholder="Your name"></div>
                    <div class="form-group"><label>Phone Number</label><input type="text" id="profilePhone" placeholder="Contact number"></div>
                    <div class="form-group"><label>Email Address</label><input type="email" id="profileEmail" readonly style="background:#F1F5F9;"></div>
                    <div class="form-group"><label>Service Category</label><input type="text" id="profileService" readonly style="background:#F1F5F9;"></div>
                    <div class="form-group"><label>City</label><input type="text" id="profileCity" placeholder="e.g., Sialkot"></div>
                    <div class="form-group"><label>Complete Address</label><textarea id="profileAddress" rows="2" placeholder="House# / Street / Sector"></textarea></div>
                    <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Save Changes</button>
                </form>
            </div>
            <div class="section-card"><div class="card-header"><h3><i class="fas fa-star"></i> Recent Feedback</h3></div><div id="profileFeedbackPreview"></div></div>
            <div class="section-card"><div class="card-header"><h3><i class="fas fa-location-dot"></i> Live Service Location Preview</h3></div><div id="profileLocationPreview"></div></div>
        </div>
    </div>
</div>

<div id="serviceModal" class="modal"><div class="modal-content"><div class="modal-header"><h3><i class="fas fa-plus-circle"></i> New Service</h3><button class="close-modal" onclick="closeModal()">×</button></div>
    <form id="serviceForm"><div class="form-group"><label>Service Name</label><input type="text" id="serviceName" required placeholder="e.g., AC Repair"></div>
    <div class="form-group"><label>Description</label><textarea id="serviceDesc" rows="2" required placeholder="Brief description"></textarea></div>
    <div class="form-group"><label>Price (Rs)</label><input type="number" id="servicePrice" required placeholder="e.g., 500"></div>
    <button type="submit" class="btn-primary" style="width:100%">Add Service</button></form>
</div></div>

<div id="replyModal" class="modal"><div class="modal-content"><div class="modal-header"><h3><i class="fas fa-reply"></i> Reply to Customer</h3><button class="close-modal" onclick="closeReplyModal()">×</button></div>
    <form id="replyForm"><div class="form-group"><label>Your Reply</label><textarea id="replyText" rows="4" required placeholder="Write your response here..."></textarea></div>
    <input type="hidden" id="replyFeedbackId" value=""><button type="submit" class="btn-primary" style="width:100%"><i class="fas fa-paper-plane"></i> Send Reply</button></form>
</div></div>

<div id="manualFeedbackModal" class="modal"><div class="modal-content"><div class="modal-header"><h3><i class="fas fa-star"></i> Add Customer Feedback</h3><button class="close-modal" onclick="closeManualFeedbackModal()">×</button></div>
    <form id="manualFeedbackForm"><div class="form-group"><label>Customer Name *</label><input type="text" id="manualCustomerName" required placeholder="e.g., Ali Raza"></div>
    <div class="form-group"><label>Service Name *</label><input type="text" id="manualServiceName" required placeholder="e.g., AC Repair"></div>
    <div class="form-group"><label>Rating *</label><select id="manualRating" required><option value="5">⭐⭐⭐⭐⭐ - Excellent</option><option value="4">⭐⭐⭐⭐ - Good</option><option value="3">⭐⭐⭐ - Average</option><option value="2">⭐⭐ - Poor</option><option value="1">⭐ - Very Poor</option></select></div>
    <div class="form-group"><label>Feedback Message *</label><textarea id="manualMessage" rows="3" required placeholder="Write customer's feedback here..."></textarea></div>
    <button type="submit" class="btn-primary" style="width:100%"><i class="fas fa-save"></i> Save Feedback</button></form>
</div></div>

<script>
    const providerEmail = <?php echo json_encode($providerEmail); ?>;

    let currentProvider = {};
    let allBookings = [];
    let allFeedbacks = [];

    function loadProviderData() {
        fetch("get_provider_data.php?email=" + providerEmail)
        .then(res => res.json())
        .then(data => {
            if(data.error) { console.log("Error:", data.error); return; }
            currentProvider = data;
            allBookings = data.bookings || [];
            allFeedbacks = data.feedbacks || [];
            
            document.getElementById("providerName").innerText = data.name || "Provider";
            document.getElementById("providerService").innerText = data.service || "Service";
            document.getElementById("profileEmail").value = data.email || "";
            document.getElementById("profileService").value = data.service || "";
            document.getElementById("profileFullName").value = data.name || "";
            document.getElementById("profilePhone").value = data.phone || "";
            document.getElementById("profileCity").value = data.city || "";
            document.getElementById("profileAddress").value = data.address || "";
            
            updateStats();
            loadServices();
            loadBookingsTabs();
            updateLocationWidgets();
            loadFeedbacks();
        })
        .catch(err => console.log("Fetch Error:", err));
    }

    function updateStats() {
        const total = allBookings.length;
        const pending = allBookings.filter(b => b.status === 'pending').length;
        const completed = allBookings.filter(b => b.status === 'completed').length;
        document.getElementById('totalBookings').innerText = total;
        document.getElementById('pendingRequests').innerText = pending;
        document.getElementById('completedJobs').innerText = completed;
        
        const recent = allBookings.filter(b => b.status === 'pending').slice(0, 3);
        document.getElementById('recentRequests').innerHTML = recent.map(b => `
            <div class="booking-card"><div class="booking-header"><span class="booking-date">📅 ${b.booking_date} | ${b.booking_time}</span><span class="status status-pending">Pending</span></div>
            <div class="booking-customer">👤 ${b.customer_name}</div><div class="booking-details">📍 ${b.customer_address}</div><div class="booking-details">📞 ${b.customer_phone}</div>
            <div class="booking-actions"><button class="accept-btn" onclick='acceptBooking(${b.id})'>✔ Accept</button><button class="reject-btn" onclick='rejectBooking(${b.id})'>✘ Decline</button><button class="call-btn" onclick="callCustomer('${b.customer_phone}')">📞 Call</button></div></div>
        `).join('') || '<div class="empty-state">No pending requests.</div>';
    }

    function loadServices() {
        const services = currentProvider.services || [];
        document.getElementById('servicesList').innerHTML = services.map((s, i) => `
            <div class="service-item"><div class="service-info"><h4>${s.service_name}</h4><p>${s.description || ''} | <strong>₹${s.price}</strong></p></div>
            <div class="service-actions"><button class="edit-btn" onclick="editService(${i})">Edit Price</button><button class="toggle-btn" onclick="toggleService(${i})">${s.available ? '✓ Available' : '✗ Unavailable'}</button></div></div>
        `).join('') || '<div class="empty-state">No services yet. Click "Add Service".</div>';
    }

    function loadBookingsTabs() {
        const pending = allBookings.filter(b => b.status === 'pending');
        const confirmed = allBookings.filter(b => b.status === 'confirmed');
        const completed = allBookings.filter(b => b.status === 'completed');
        
        document.getElementById('pendingBookingsList').innerHTML = pending.map(b => `
            <div class="booking-card"><div class="booking-header"><span class="booking-date">📅 ${b.booking_date} | ${b.booking_time}</span><span class="status status-pending">Pending</span></div>
            <div class="booking-customer">👤 ${b.customer_name}</div><div class="booking-details">📍 ${b.customer_address}</div><div class="booking-details">📞 ${b.customer_phone}</div>
            <div class="booking-actions"><button class="accept-btn" onclick='acceptBooking(${b.id})'>✔ Accept</button><button class="reject-btn" onclick='rejectBooking(${b.id})'>✘ Decline</button><button class="call-btn" onclick="callCustomer('${b.customer_phone}')">📞 Call</button></div></div>
        `).join('') || '<div class="empty-state">No pending bookings.</div>';
        
        document.getElementById('confirmedBookingsList').innerHTML = [...confirmed, ...completed].map(b => `
            <div class="booking-card"><div class="booking-header"><span class="booking-date">📅 ${b.booking_date} | ${b.booking_time}</span><span class="status ${b.status === 'completed' ? 'status-completed' : 'status-confirmed'}">${b.status === 'completed' ? '✓ Completed' : '✓ Confirmed'}</span></div>
            <div class="booking-customer">👤 ${b.customer_name}</div><div class="booking-details">📍 ${b.customer_address}</div>
            ${b.status === 'confirmed' ? `<div class="booking-actions"><button class="accept-btn" onclick='completeBooking(${b.id})'>Mark Completed</button></div>` : ''}
        </div>
        `).join('') || '<div class="empty-state">No confirmed/completed bookings.</div>';
    }

    // ✅ COMPLETE loadFeedbacks FUNCTION with ALL Stats
    function loadFeedbacks() {
        const feedbacks = allFeedbacks || [];
        
        // 🔥 CALCULATE STATS FROM FEEDBACKS
        const positive = feedbacks.filter(f => f.rating >= 4).length;
        const neutral = feedbacks.filter(f => f.rating === 3).length;
        const negative = feedbacks.filter(f => f.rating <= 2).length;
        const replied = feedbacks.filter(f => f.reply && f.reply.length > 0).length;
        
        // Update stats display
        document.getElementById('positiveCount').innerText = positive;
        document.getElementById('neutralCount').innerText = neutral;
        document.getElementById('negativeCount').innerText = negative;
        document.getElementById('responseCount').innerText = replied;
        
        // 🔥 FETCH REAL RATING FROM DATABASE
        fetch(`get_provider_rating.php?provider_email=${encodeURIComponent(providerEmail)}`)
            .then(res => res.json())
            .then(ratingData => {
                if (ratingData.success) {
                    const avg = ratingData.average_rating;
                    const total = ratingData.total_reviews;
                    
                    const fullStars = Math.floor(avg);
                    const emptyStars = 5 - fullStars;
                    const stars = '★'.repeat(fullStars) + '☆'.repeat(emptyStars);
                    
                    document.getElementById('providerStarsDisplay').innerHTML = stars;
                    document.getElementById('providerRatingCount').innerHTML = `(${total} review${total !== 1 ? 's' : ''})`;
                    
                    const ratingBox = document.getElementById('providerRatingBox');
                    if (ratingBox && total > 0) {
                        ratingBox.style.background = "linear-gradient(135deg, #FEF3C7, #FDE68A)";
                    }
                }
            })
            .catch(err => console.log("Rating fetch error:", err));
        
        // Update rating stars from feedbacks array
        const total = feedbacks.length;
        if(total > 0) {
            const avg = feedbacks.reduce((a,b) => a + b.rating, 0) / total;
            const stars = '★'.repeat(Math.floor(avg)) + '☆'.repeat(5 - Math.floor(avg));
            document.getElementById('providerStarsDisplay').innerHTML = stars;
            document.getElementById('providerRatingCount').innerHTML = `(${total} review${total !== 1 ? 's' : ''})`;
        }
        
        // Display feedback list
        if (feedbacks.length > 0) {
            document.getElementById('providerFeedbacksList').innerHTML = feedbacks.map(f => `
                <div class="feedback-card-item">
                    <div class="feedback-header-row">
                        <div class="feedback-customer"><i class="fas fa-user-circle"></i> ${escapeHtml(f.customer_name)}${f.is_manual ? '<span class="manual-badge">Manual</span>' : ''}</div>
                        <div class="feedback-stars">${'★'.repeat(f.rating)}${'☆'.repeat(5-f.rating)}</div>
                    </div>
                    <div class="feedback-service-badge"><i class="fas fa-tag"></i> ${escapeHtml(f.service_name)}</div>
                    <div class="feedback-message">"${escapeHtml(f.message)}"</div>
                    <div class="feedback-date"><i class="far fa-calendar-alt"></i> ${f.feedback_date}</div>
                    ${f.reply ? `<div class="reply-box"><i class="fas fa-reply"></i> <strong>Your Reply:</strong><p>${escapeHtml(f.reply)}</p></div>` : `<button class="reply-btn-sm" onclick="openReplyModal(${f.id}, '${escapeHtml(f.customer_name)}')">Reply to Review</button>`}
                </div>
            `).join('');
        } else {
            document.getElementById('providerFeedbacksList').innerHTML = '<div class="empty-state"><i class="fas fa-star" style="font-size: 48px; color: #CBD5E1;"></i><p>No feedback received yet.<br>Click "Add Manual Feedback" to add customer reviews!</p></div>';
        }
    }
    
    // Helper function to escape HTML
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function updateLocationWidgets() {
        const locHtml = `<div class="location-card"><div class="location-header"><i class="fas fa-map-marker-alt"></i><strong>Your Service Address</strong></div><div class="location-address">${currentProvider.address || ''}${currentProvider.city ? ', ' + currentProvider.city : ''}</div><div class="location-detail"><span class="location-badge"><i class="fas fa-city"></i> ${currentProvider.city || 'City not set'}</span></div></div>`;
        document.getElementById('providerLocationWidget').innerHTML = locHtml;
        document.getElementById('profileLocationPreview').innerHTML = locHtml;
    }

    // ✅ ACCEPT BOOKING FUNCTION
    window.acceptBooking = function(id) {
        console.log("Accepting booking ID:", id);
        
        fetch("update_booking_status.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams({ id: id, status: "confirmed" })
        })
        .then(res => res.json())
        .then(data => {
            console.log("Accept Response:", data);
            if(data.success) {
                loadProviderData();
                Swal.fire('Accepted!', 'Booking confirmed.', 'success');
            } else {
                Swal.fire('Error', data.error || 'Something went wrong', 'error');
            }
        })
        .catch(err => {
            console.error("Error:", err);
            Swal.fire('Error', 'Network error!', 'error');
        });
    };
    
    window.rejectBooking = function(id) {
        Swal.fire({
            title: 'Reject Request?',
            input: 'text',
            inputPlaceholder: 'Reason (optional)',
            showCancelButton: true,
            confirmButtonText: 'Reject',
            confirmButtonColor: '#d33'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch("update_booking_status.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: new URLSearchParams({ id: id, status: "rejected", reason: result.value || "" })
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        loadProviderData();
                        Swal.fire('Rejected', 'Booking rejected.', 'error');
                    }
                });
            }
        });
    };
    
    window.completeBooking = function(id) {
        fetch("update_booking_status.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams({ id: id, status: "completed" })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                loadProviderData();
                Swal.fire('Completed!', 'Job marked as completed.', 'success');
            }
        });
    };
    
    window.callCustomer = (phone) => { alert(`📞 Calling ${phone}...`); };
    
    function addService(service) {
        fetch("add_provider_service.php", { method: "POST", headers: { "Content-Type": "application/x-www-form-urlencoded" }, body: new URLSearchParams({ email: providerEmail, service_name: service.name, description: service.description, price: service.price }) })
        .then(res => res.text()).then(data => { if(data === "success") { loadProviderData(); alert("✅ Service added!"); } else { alert("Error: " + data); } });
    }
    
    window.editService = (idx) => { let newPrice = prompt("Enter new price:", currentProvider.services[idx].price); if(newPrice) { /* update via API */ } };
    window.toggleService = (idx) => { /* update via API */ };
    
    function updateProfile(updates) {
        fetch("update_provider_profile.php", { method: "POST", headers: { "Content-Type": "application/x-www-form-urlencoded" }, body: new URLSearchParams({ email: providerEmail, name: updates.name, phone: updates.phone, city: updates.city, address: updates.address }) })
        .then(res => res.text()).then(data => { if(data === "success") { loadProviderData(); alert("✅ Profile updated!"); } });
    }
    
    function addManualFeedback(customerName, serviceName, rating, message) {
        fetch("add_provider_feedback.php", { method: "POST", headers: { "Content-Type": "application/x-www-form-urlencoded" }, body: new URLSearchParams({ provider_email: providerEmail, customer_name: customerName, service_name: serviceName, rating: rating, message: message }) })
        .then(res => res.text()).then(data => { if(data === "success") { loadProviderData(); alert("✅ Feedback added!"); } });
    }
    
    function logout() { fetch("provider_logout.php").then(() => window.location.href = "provider_login.html"); }
    function openModal() { document.getElementById('serviceModal').classList.add('active'); }
    window.closeModal = () => { document.getElementById('serviceModal').classList.remove('active'); };
    window.closeReplyModal = () => { document.getElementById('replyModal').classList.remove('active'); };
    window.closeManualFeedbackModal = () => { document.getElementById('manualFeedbackModal').classList.remove('active'); };
    window.openReplyModal = (id, name) => { 
        document.getElementById('replyFeedbackId').value = id; 
        document.getElementById('replyText').value = '';
        document.getElementById('replyModal').classList.add('active');
    };
    
    // ✅ UPDATED submitReply FUNCTION - Now works with API
    function submitReply() { 
        const reply = document.getElementById('replyText').value; 
        const id = document.getElementById('replyFeedbackId').value; 
        
        if (!reply.trim()) {
            Swal.fire('Error', 'Please write a reply before sending.', 'error');
            return;
        }
        
        // Show loading state
        const submitBtn = document.querySelector('#replyForm button');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Sending...';
        submitBtn.disabled = true;
        
        fetch("save_reply.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams({ review_id: id, reply: reply })
        })
        .then(res => res.json())
        .then(data => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
            
            if (data.success) {
                closeReplyModal();
                loadProviderData(); // Refresh to show the reply
                Swal.fire('Success!', data.message, 'success');
            } else {
                Swal.fire('Error', data.error || 'Something went wrong', 'error');
            }
        })
        .catch(err => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
            console.error("Error:", err);
            Swal.fire('Error', 'Network error! Please try again.', 'error');
        });
    }
    
    window.switchTab = (tabName) => {
        document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
        document.getElementById(`tab-${tabName}`).classList.add('active');
        document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
        document.querySelector(`[data-tab="${tabName}"]`).classList.add('active');
        const titles = { dashboard: 'Dashboard', services: 'My Services', bookings: 'Bookings', 'feedback-tab': 'Feedback', profile: 'Profile' };
        document.getElementById('pageTitle').innerText = titles[tabName];
    };
    
    document.getElementById('addServiceBtn').addEventListener('click', openModal);
    document.getElementById('manualFeedbackBtn').addEventListener('click', () => { document.getElementById('manualFeedbackModal').classList.add('active'); });
    document.getElementById('serviceForm').addEventListener('submit', function(e) { e.preventDefault(); addService({ name: document.getElementById('serviceName').value, description: document.getElementById('serviceDesc').value, price: document.getElementById('servicePrice').value }); closeModal(); this.reset(); });
    document.getElementById('profileForm').addEventListener('submit', function(e) { e.preventDefault(); updateProfile({ name: document.getElementById('profileFullName').value, phone: document.getElementById('profilePhone').value, city: document.getElementById('profileCity').value, address: document.getElementById('profileAddress').value }); });
    document.getElementById('logoutBtn').addEventListener('click', logout);
    document.querySelectorAll('.nav-link').forEach(link => link.addEventListener('click', function() { switchTab(this.getAttribute('data-tab')); }));
    document.getElementById('replyForm').addEventListener('submit', function(e) { e.preventDefault(); submitReply(); });
    document.getElementById('manualFeedbackForm').addEventListener('submit', function(e) { e.preventDefault(); addManualFeedback(document.getElementById('manualCustomerName').value, document.getElementById('manualServiceName').value, document.getElementById('manualRating').value, document.getElementById('manualMessage').value); closeManualFeedbackModal(); this.reset(); });
    
    loadProviderData();
</script>
</body>
</html>