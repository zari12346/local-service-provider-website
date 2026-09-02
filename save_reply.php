<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$conn = new mysqli("localhost", "root", "", "local_service");

if ($conn->connect_error) {
    echo json_encode(["success" => false, "error" => "Connection failed"]);
    exit();
}

$review_id = $_POST['review_id'] ?? 0;
$reply = $_POST['reply'] ?? '';

if ($review_id == 0 || empty($reply)) {
    echo json_encode(["success" => false, "error" => "Missing review_id or reply"]);
    exit();
}

$sql = "UPDATE reviews SET reply = '$reply', replied_at = NOW() WHERE id = $review_id";

if ($conn->query($sql)) {
    echo json_encode(["success" => true, "message" => "Reply sent successfully!"]);
} else {
    echo json_encode(["success" => false, "error" => $conn->error]);
}

$conn->close();
?>