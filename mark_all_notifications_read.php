<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "local_service");

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed"]));
}

$email = $_POST['email'] ?? '';

$conn->query("UPDATE notifications SET is_read = 1 WHERE user_email = '$email'");

echo json_encode(["success" => true]);
$conn->close();
?>