<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$conn = new mysqli("localhost", "root", "", "local_service");

if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed"]);
    exit();
}

$email = $_GET['email'] ?? '';

if (empty($email)) {
    echo json_encode(["error" => "Email required"]);
    exit();
}

// Get provider basic info
$providerQuery = "SELECT name, email, phone, service, city, address FROM providers WHERE email = '$email'";
$providerResult = $conn->query($providerQuery);
$provider = $providerResult->fetch_assoc();

if (!$provider) {
    echo json_encode(["error" => "Provider not found"]);
    exit();
}

// Get bookings
$bookingsQuery = "SELECT * FROM provider_bookings WHERE provider_email = '$email' ORDER BY id DESC";
$bookingsResult = $conn->query($bookingsQuery);
$bookings = [];
while ($row = $bookingsResult->fetch_assoc()) {
    $bookings[] = $row;
}

// ✅ FIXED: Added reply column
$feedbacksQuery = "SELECT 
                    r.id, 
                    r.user_email as customer_name, 
                    r.service_name, 
                    r.rating, 
                    r.review_text as message, 
                    r.created_at as feedback_date,
                    r.reply,
                    '0' as is_manual
                  FROM reviews r 
                  WHERE r.provider_email = '$email' 
                  ORDER BY r.created_at DESC";
                  
$feedbacksResult = $conn->query($feedbacksQuery);
$feedbacks = [];
while ($row = $feedbacksResult->fetch_assoc()) {
    $feedbacks[] = [
        'id' => $row['id'],
        'customer_name' => $row['customer_name'],
        'service_name' => $row['service_name'],
        'rating' => (int)$row['rating'],
        'message' => $row['message'],
        'feedback_date' => $row['feedback_date'],
        'reply' => $row['reply'],  // ✅ Reply included
        'is_manual' => false
    ];
}

// Get services
$servicesQuery = "SELECT service_name, description, price, available FROM provider_services WHERE provider_email = '$email'";
$servicesResult = $conn->query($servicesQuery);
$services = [];
while ($row = $servicesResult->fetch_assoc()) {
    $services[] = $row;
}

echo json_encode([
    "name" => $provider['name'],
    "email" => $provider['email'],
    "phone" => $provider['phone'],
    "service" => $provider['service'],
    "city" => $provider['city'],
    "address" => $provider['address'],
    "bookings" => $bookings,
    "feedbacks" => $feedbacks,
    "services" => $services
]);

$conn->close();
?>