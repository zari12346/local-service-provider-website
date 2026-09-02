<?php
$conn = new mysqli("localhost", "root", "", "local-service");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// POST data receive karo
$user_email = $_POST['user_email'];
$service_name = $_POST['service_name'];
$provider_name = $_POST['provider_name'];
$booking_date = $_POST['booking_date'];
$booking_time = $_POST['booking_time'];
$area = $_POST['area'];
$customer_name = $_POST['customer_name'];
$phone = $_POST['phone'];
$address = $_POST['address'];

// Insert query
$sql = "INSERT INTO bookings 
(user_email, service_name, provider_name, booking_date, booking_time, area, customer_name, phone, address) 
VALUES 
('$user_email', '$service_name', '$provider_name', '$booking_date', '$booking_time', '$area', '$customer_name', '$phone', '$address')";

if ($conn->query($sql) === TRUE) {
    echo "success";
} else {
    echo "error: " . $conn->error;
}

$conn->close();
?>