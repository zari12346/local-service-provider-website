<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: text/plain');

$conn = new mysqli("localhost", "root", "", "local_service");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// POST data
$service = $_POST['service'] ?? '';
$provider = $_POST['provider'] ?? '';
$date = $_POST['date'] ?? '';
$time = $_POST['time'] ?? '';
$name = $_POST['name'] ?? '';
$phone = $_POST['phone'] ?? '';
$email = $_POST['email'] ?? '';  // ✅ Customer email
$address = $_POST['address'] ?? '';
$area = $_POST['area'] ?? '';

// Check required fields
if(empty($service) || empty($provider) || empty($date) || empty($time) || empty($name) || empty($phone) || empty($email)) {
    echo "error: missing required fields";
    exit();
}

$formatted_date = date("Y-m-d", strtotime($date));

// ========== 1. INSERT INTO bookings TABLE ==========
$sql1 = "INSERT INTO bookings (service_name, provider_name, booking_date, booking_time, customer_name, phone, user_email, address, area, status) 
         VALUES ('$service', '$provider', '$formatted_date', '$time', '$name', '$phone', '$email', '$address', '$area', 'pending')";

if(!$conn->query($sql1)) {
    echo "error in bookings: " . $conn->error;
    exit();
}

// ========== 2. INSERT INTO provider_bookings TABLE ==========
$providerQuery = $conn->query("SELECT email FROM providers WHERE name = '$provider'");
if($providerQuery && $providerQuery->num_rows > 0) {
    $providerRow = $providerQuery->fetch_assoc();
    $provider_email = $providerRow['email'];
    
    // ✅ customer_email properly save ho raha hai
    $sql2 = "INSERT INTO provider_bookings (provider_email, customer_name, customer_phone, customer_address, service_name, booking_date, booking_time, status, customer_email) 
             VALUES ('$provider_email', '$name', '$phone', '$address', '$service', '$formatted_date', '$time', 'pending', '$email')";
    
    if($conn->query($sql2)) {
        echo "success";
    } else {
        echo "error in provider_bookings: " . $conn->error;
    }
} else {
    echo "error: Provider not found: $provider";
}

$conn->close();
?>