<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "local_service");

if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed"]);
    exit();
}

$pending = $conn->query("SELECT COUNT(*) as count FROM providers WHERE status='pending'")->fetch_assoc()['count'];
$approved = $conn->query("SELECT COUNT(*) as count FROM providers WHERE status='approved'")->fetch_assoc()['count'];
$total = $conn->query("SELECT COUNT(*) as count FROM providers")->fetch_assoc()['count'];

echo json_encode([
    "pending" => $pending,
    "approved" => $approved,
    "total" => $total
]);

$conn->close();
?>