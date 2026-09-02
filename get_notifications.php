<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "local_service");

if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit();
}

$email = $_GET['email'] ?? '';

if(empty($email)) {
    echo json_encode([]);
    exit();
}

$result = $conn->query("SELECT * FROM notifications WHERE user_email='$email' ORDER BY id DESC");

$notifications = [];
while($row = $result->fetch_assoc()) {
    $notifications[] = $row;
}

echo json_encode($notifications);
$conn->close();
?>