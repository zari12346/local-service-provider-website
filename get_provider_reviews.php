<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$conn = new mysqli("localhost", "root", "", "local_service");

$provider_email = $_GET['provider_email'] ?? '';

if (!$provider_email) {
    echo json_encode(["success" => false, "error" => "Provider email required"]);
    exit();
}

// Get reviews
$reviewsQuery = "SELECT r.*, b.customer_name 
                 FROM reviews r 
                 LEFT JOIN bookings b ON r.booking_id = b.id 
                 WHERE r.provider_email = '$provider_email' 
                 ORDER BY r.created_at DESC";

$result = $conn->query($reviewsQuery);
$reviews = [];
while($row = $result->fetch_assoc()) {
    $reviews[] = $row;
}

// Get rating summary
$ratingQuery = "SELECT average_rating, total_reviews FROM provider_ratings WHERE provider_email = '$provider_email'";
$ratingResult = $conn->query($ratingQuery);
$ratings = $ratingResult->fetch_assoc();

echo json_encode([
    "success" => true,
    "reviews" => $reviews,
    "average_rating" => $ratings['average_rating'] ?? 0,
    "total_reviews" => $ratings['total_reviews'] ?? 0
]);

$conn->close();
?>