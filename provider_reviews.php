<?php
session_start();
if (!isset($_SESSION['provider_email'])) {
    header('Location: provider_login.html');
    exit();
}
$providerEmail = $_SESSION['provider_email'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Reviews & Ratings</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
        
        /* Rating Summary Card */
        .rating-summary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            margin-bottom: 30px;
        }
        
        .big-rating {
            font-size: 60px;
            font-weight: bold;
        }
        
        .stars-big {
            font-size: 30px;
            margin: 10px 0;
        }
        
        .total-reviews {
            font-size: 18px;
            opacity: 0.9;
        }
        
        /* Reviews List */
        .reviews-list {
            background: white;
            border-radius: 20px;
            padding: 20px;
        }
        
        .review-card {
            border-bottom: 1px solid #eee;
            padding: 20px;
            transition: all 0.3s;
        }
        
        .review-card:hover {
            background: #f8f9fa;
        }
        
        .review-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            flex-wrap: wrap;
        }
        
        .customer-name {
            font-weight: bold;
            color: #333;
        }
        
        .review-stars {
            color: #ffc107;
            font-size: 18px;
        }
        
        .service-name {
            color: #667eea;
            margin: 5px 0;
        }
        
        .review-text {
            color: #666;
            margin-top: 10px;
            line-height: 1.5;
        }
        
        .review-date {
            color: #999;
            font-size: 12px;
            margin-top: 10px;
        }
        
        .no-reviews {
            text-align: center;
            padding: 50px;
            color: #999;
        }
        
        .back-btn {
            background: #667eea;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <button class="back-btn" onclick="window.location.href='provider_dashboard.html'">← Back to Dashboard</button>
        
        <div class="rating-summary" id="ratingSummary">
            <div class="big-rating">--</div>
            <div class="stars-big" id="starsBig">☆☆☆☆☆</div>
            <div class="total-reviews" id="totalReviews">Loading...</div>
        </div>
        
        <div class="reviews-list" id="reviewsList">
            <div class="no-reviews">Loading reviews...</div>
        </div>
    </div>
    
    <script>
        const providerEmail = <?php echo json_encode($providerEmail); ?>;
        
        async function loadReviews() {
            try {
                const response = await fetch(`get_provider_reviews.php?provider_email=${providerEmail}`);
                const data = await response.json();
                
                if (data.success) {
                    // Update summary
                    document.getElementById('ratingSummary').innerHTML = `
                        <div class="big-rating">${data.average_rating || 'No ratings'}</div>
                        <div class="stars-big">${getStarsHtml(data.average_rating)}</div>
                        <div class="total-reviews">Based on ${data.total_reviews} reviews</div>
                    `;
                    
                    // Display reviews
                    const reviewsContainer = document.getElementById('reviewsList');
                    if (data.reviews && data.reviews.length > 0) {
                        reviewsContainer.innerHTML = data.reviews.map(review => `
                            <div class="review-card">
                                <div class="review-header">
                                    <span class="customer-name">${escapeHtml(review.customer_name || review.user_email)}</span>
                                    <span class="review-stars">${'★'.repeat(review.rating)}${'☆'.repeat(5-review.rating)}</span>
                                </div>
                                <div class="service-name">Service: ${review.service_name}</div>
                                <div class="review-text">${escapeHtml(review.review_text || 'No comment provided')}</div>
                                <div class="review-date">${review.created_at}</div>
                            </div>
                        `).join('');
                    } else {
                        reviewsContainer.innerHTML = '<div class="no-reviews">No reviews yet. Complete more bookings to get reviews!</div>';
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('reviewsList').innerHTML = '<div class="no-reviews">Error loading reviews</div>';
            }
        }
        
        function getStarsHtml(rating) {
            const full = Math.floor(rating);
            const empty = 5 - full;
            return '★'.repeat(full) + '☆'.repeat(empty);
        }
        
        function escapeHtml(text) {
            if (!text) return '';
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
        
        loadReviews();
    </script>
</body>
</html>