<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$conn = new mysqli("localhost", "root", "", "local_service");

if ($conn->connect_error) {
    echo json_encode(["success" => false, "error" => "Connection failed"]);
    exit();
}

$id = $_GET['id'] ?? 0;

if ($id == 0) {
    echo json_encode(["success" => false, "error" => "Invalid booking ID"]);
    exit();
}

$sql = "SELECT id, service_name, provider_name, provider_email, status, booking_date, booking_time FROM bookings WHERE id = $id";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $data = $result->fetch_assoc();
    echo json_encode([
        "success" => true,
        "id" => $data['id'],
        "service_name" => $data['service_name'],
        "provider_name" => $data['provider_name'],
        "provider_email" => $data['provider_email'],
        "status" => $data['status'],
        "booking_date" => $data['booking_date'],
        "booking_time" => $data['booking_time']
    ]);
} else {
    echo json_encode(["success" => false, "error" => "Booking not found for ID: $id"]);
}

$conn->close();
?>