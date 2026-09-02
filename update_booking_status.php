<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$conn = new mysqli("localhost", "root", "", "local_service");

if ($conn->connect_error) {
    echo json_encode(["success" => false, "error" => "Connection failed"]);
    exit();
}

$id = $_POST['id'] ?? 0;
$status = $_POST['status'] ?? '';

if ($id == 0 || empty($status)) {
    echo json_encode(["success" => false, "error" => "Missing id or status"]);
    exit();
}

// ✅ STEP 1: GET CORRECT PROVIDER DETAILS
$getProviderSql = "SELECT 
                    pb.id, 
                    pb.provider_email, 
                    pb.customer_email, 
                    pb.customer_name,
                    pb.service_name,
                    pb.booking_date,
                    pb.booking_time,
                    pb.user_booking_id
                  FROM provider_bookings pb
                  WHERE pb.id = $id";
                  
$providerResult = $conn->query($getProviderSql);

if (!$providerResult || $providerResult->num_rows == 0) {
    echo json_encode(["success" => false, "error" => "Provider booking not found for ID: $id"]);
    exit();
}

$booking = $providerResult->fetch_assoc();
$provider_email = $booking['provider_email'];
$customer_email = $booking['customer_email'];
$customer_name = $booking['customer_name'];  // This is customer name - DON'T use for provider!
$service_name = $booking['service_name'];
$booking_date = $booking['booking_date'];
$booking_time = $booking['booking_time'];
$user_booking_id = $booking['user_booking_id'];

// ✅ STEP 2: GET PROVIDER'S REAL NAME FROM providers TABLE
$getProviderNameSql = "SELECT name FROM providers WHERE email = '$provider_email'";
$providerNameResult = $conn->query($getProviderNameSql);
$provider_real_name = $provider_email; // fallback

if ($providerNameResult && $providerNameResult->num_rows > 0) {
    $providerData = $providerNameResult->fetch_assoc();
    $provider_real_name = $providerData['name'];
} else {
    // If no name found, extract from email or use default
    $provider_real_name = explode('@', $provider_email)[0];
}

// ✅ STEP 3: UPDATE provider_bookings table
$sql1 = "UPDATE provider_bookings SET status = '$status' WHERE id = $id";
$conn->query($sql1);

// ✅ STEP 4: UPDATE bookings table with CORRECT provider name (NOT customer name)
if ($user_booking_id && $user_booking_id > 0) {
    $sql2 = "UPDATE bookings 
             SET status = '$status', 
                 provider_email = '$provider_email',
                 provider_name = '$provider_real_name'
             WHERE id = $user_booking_id";
    $conn->query($sql2);
} else {
    // Fallback: update by matching details
    $sql3 = "UPDATE bookings 
             SET status = '$status', 
                 provider_email = '$provider_email',
                 provider_name = '$provider_real_name'
             WHERE user_email = '$customer_email' 
             AND service_name = '$service_name'
             AND booking_date = '$booking_date'
             ORDER BY id DESC LIMIT 1";
    $conn->query($sql3);
}

// ✅ STEP 5: Also update any other pending bookings for same customer/service
$sql4 = "UPDATE bookings 
         SET provider_email = '$provider_email',
             provider_name = '$provider_real_name'
         WHERE user_email = '$customer_email' 
         AND service_name = '$service_name'
         AND (provider_email IS NULL OR provider_email = '')
         AND status = 'pending'";
$conn->query($sql4);

echo json_encode([
    "success" => true,
    "message" => "Booking $status successfully",
    "provider_email" => $provider_email,
    "provider_name" => $provider_real_name,
    "customer_email" => $customer_email
]);

$conn->close();
?>