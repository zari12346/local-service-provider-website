<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$conn = new mysqli("localhost", "root", "", "local_service");

if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed"]);
    exit();
}

$email = $_GET['email'] ?? '';

if (empty($email)) {
    echo json_encode(["error" => "Email required"]);
    exit();
}

$sql = "SELECT 
            booking_id, 
            rating, 
            review_text, 
            reply, 
            created_at
        FROM reviews 
        WHERE user_email = '$email' 
        ORDER BY created_at DESC";

$result = $conn->query($sql);
$reviews = [];

while ($row = $result->fetch_assoc()) {
    $reviews[] = [
        'booking_id' => (int)$row['booking_id'],
        'rating' => (int)$row['rating'],
        'review_text' => $row['review_text'],
        'reply' => $row['reply'],
        'created_at' => $row['created_at']
    ];
}

echo json_encode($reviews);
$conn->close();
?>