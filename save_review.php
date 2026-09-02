<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

$conn = new mysqli("localhost", "root", "", "local_service");

if ($conn->connect_error) {
    echo json_encode(["success" => false, "error" => "Connection failed"]);
    exit();
}

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);

$booking_id = $data['booking_id'] ?? 0;
$rating = $data['rating'] ?? 0;
$review_text = $data['review_text'] ?? '';
$user_email = $data['user_email'] ?? '';

if (!$booking_id || !$rating || !$user_email) {
    echo json_encode(["success" => false, "error" => "Missing required fields"]);
    exit();
}

// Check if already reviewed
$checkQuery = "SELECT id FROM reviews WHERE booking_id = $booking_id";
$checkResult = $conn->query($checkQuery);
if ($checkResult->num_rows > 0) {
    echo json_encode(["success" => false, "error" => "You already reviewed this booking"]);
    exit();
}

// Get booking details
$bookingQuery = "SELECT service_name, provider_name, provider_email FROM bookings WHERE id = $booking_id AND user_email = '$user_email'";
$bookingResult = $conn->query($bookingQuery);

if (!$bookingResult || $bookingResult->num_rows == 0) {
    echo json_encode(["success" => false, "error" => "Booking not found"]);
    exit();
}

$booking = $bookingResult->fetch_assoc();
$provider_email = $booking['provider_email'];
$service_name = $booking['service_name'];

// Save review
$sql = "INSERT INTO reviews (booking_id, user_email, provider_email, service_name, rating, review_text) 
        VALUES ($booking_id, '$user_email', '$provider_email', '$service_name', $rating, '$review_text')";

if ($conn->query($sql)) {
    // Update provider aggregated ratings
    updateProviderRating($conn, $provider_email);
    
    echo json_encode([
        "success" => true,
        "message" => "Thank you for your review! ⭐"
    ]);
} else {
    echo json_encode(["success" => false, "error" => $conn->error]);
}

$conn->close();

function updateProviderRating($conn, $provider_email) {
    $avgQuery = "SELECT AVG(rating) as avg_rating, COUNT(*) as total FROM reviews WHERE provider_email = '$provider_email'";
    $result = $conn->query($avgQuery);
    $data = $result->fetch_assoc();
    
    $avg_rating = round($data['avg_rating'], 1);
    $total = $data['total'];
    
    $updateQuery = "INSERT INTO provider_ratings (provider_email, total_ratings, average_rating, total_reviews) 
                    VALUES ('$provider_email', $total, $avg_rating, $total)
                    ON DUPLICATE KEY UPDATE 
                    total_ratings = $total, 
                    average_rating = $avg_rating,
                    total_reviews = $total";
    $conn->query($updateQuery);
}
?>