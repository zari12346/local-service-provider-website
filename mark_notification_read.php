<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "local_service");

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed"]));
}

$id = $_POST['id'] ?? 0;

$conn->query("UPDATE notifications SET is_read = 1 WHERE id = $id");

echo json_encode(["success" => true]);
$conn->close();
?>