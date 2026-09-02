<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$conn = new mysqli("localhost", "root", "", "local_service");

if ($conn->connect_error) {
    echo json_encode(["can_review" => false, "error" => "Connection failed"]);
    exit();
}

$booking_id = $_GET['booking_id'] ?? 0;
$user_email = $_GET['user_email'] ?? '';

if (!$booking_id || !$user_email) {
    echo json_encode(["can_review" => false, "error" => "Missing data"]);
    exit();
}

// Check if this SPECIFIC booking is already reviewed
$checkQuery = "SELECT id FROM reviews WHERE booking_id = $booking_id";
$checkResult = $conn->query($checkQuery);
$already_reviewed = $checkResult->num_rows > 0;

// Get booking status
$statusQuery = "SELECT status FROM bookings WHERE id = $booking_id AND user_email = '$user_email'";
$statusResult = $conn->query($statusQuery);
$booking = $statusResult->fetch_assoc();

$can_review = ($booking['status'] == 'completed' && !$already_reviewed);

echo json_encode([
    "can_review" => $can_review,
    "status" => $booking['status'] ?? null,
    "already_reviewed" => $already_reviewed ? 1 : 0,
    "booking_id" => $booking_id
]);

$conn->close();
?>