<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "local_service");

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

$id = $_GET['id'] ?? 0;

$sql = "SELECT id, name, service, phone, experience, rating FROM providers WHERE id = $id";

$result = $conn->query($sql);
$provider = $result->fetch_assoc();

echo json_encode($provider);
$conn->close();
?>