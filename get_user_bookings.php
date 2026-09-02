<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "local_service");

if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit();
}

$email = $_GET['email'] ?? '';

if(empty($email)) {
    echo json_encode(["error" => "Email required"]);
    exit();
}

$sql = "SELECT id, service_name, provider_name, booking_date, booking_time, status, area 
        FROM bookings 
        WHERE user_email = '$email' 
        ORDER BY id DESC";

$result = $conn->query($sql);

if(!$result) {
    echo json_encode(["error" => "Query failed: " . $conn->error]);
    exit();
}

$bookings = [];
while($row = $result->fetch_assoc()) {
    $bookings[] = $row;
}

echo json_encode($bookings);
$conn->close();
?>