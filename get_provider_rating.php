<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$conn = new mysqli("localhost", "root", "", "local_service");

if ($conn->connect_error) {
    echo json_encode(["success" => false, "error" => "Connection failed"]);
    exit();
}

$provider_email = $_GET['provider_email'] ?? '';

if (empty($provider_email)) {
    echo json_encode(["success" => false, "error" => "Provider email required"]);
    exit();
}

// Get provider rating
$ratingQuery = "SELECT average_rating, total_reviews FROM provider_ratings WHERE provider_email = '$provider_email'";
$ratingResult = $conn->query($ratingQuery);

$average_rating = 0;
$total_reviews = 0;

if ($ratingResult && $ratingResult->num_rows > 0) {
    $row = $ratingResult->fetch_assoc();
    $average_rating = $row['average_rating'] ?? 0;
    $total_reviews = $row['total_reviews'] ?? 0;
}

// Get all reviews
$reviewsQuery = "SELECT r.*, b.customer_name 
                 FROM reviews r 
                 LEFT JOIN bookings b ON r.booking_id = b.id 
                 WHERE r.provider_email = '$provider_email' 
                 ORDER BY r.created_at DESC";
$reviewsResult = $conn->query($reviewsQuery);
$reviews = [];

if ($reviewsResult) {
    while ($row = $reviewsResult->fetch_assoc()) {
        $reviews[] = [
            'id' => $row['id'],
            'customer_name' => $row['customer_name'] ?? $row['user_email'],
            'rating' => $row['rating'],
            'review_text' => $row['review_text'],
            'service_name' => $row['service_name'],
            'created_at' => $row['created_at']
        ];
    }
}

echo json_encode([
    "success" => true,
    "average_rating" => floatval($average_rating),
    "total_reviews" => intval($total_reviews),
    "reviews" => $reviews
]);

$conn->close();
?>