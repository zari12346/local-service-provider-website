<?php
$conn = new mysqli("localhost", "root", "", "local_service");

// Get the latest booking ID
$result = $conn->query("SELECT id, customer_email FROM provider_bookings ORDER BY id DESC LIMIT 1");
$row = $result->fetch_assoc();
$booking_id = $row['id'];
$customer_email = $row['customer_email'];

echo "Booking ID: $booking_id<br>";
echo "Customer Email: $customer_email<br><br>";

// Manually call the update with confirmed status
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://localhost/local-service/update_booking_status.php");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "id=$booking_id&status=confirmed");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

echo "Response from update_booking_status.php: $response<br><br>";

// Check if notification inserted
$notifCheck = $conn->query("SELECT * FROM notifications WHERE booking_id=$booking_id");
if($notifCheck->num_rows > 0) {
    echo "✅ Notification inserted successfully!";
} else {
    echo "❌ No notification found for booking ID: $booking_id";
}

$conn->close();
?>