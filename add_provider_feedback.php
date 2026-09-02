<?php
header('Content-Type: text/plain');

$conn = new mysqli("localhost", "root", "", "local_service");

if ($conn->connect_error) {
    die("Connection failed");
}

$provider_email = $_POST['provider_email'];
$customer_name = $_POST['customer_name'];
$service_name = $_POST['service_name'];
$rating = $_POST['rating'];
$message = $_POST['message'];
$feedback_date = date('Y-m-d');

$sql = "INSERT INTO provider_feedbacks (provider_email, customer_name, service_name, rating, message, feedback_date, is_manual) 
        VALUES ('$provider_email', '$customer_name', '$service_name', '$rating', '$message', '$feedback_date', 1)";

if ($conn->query($sql) === TRUE) {
    // Update provider rating
    $avg = $conn->query("SELECT AVG(rating) as avg, COUNT(*) as cnt FROM provider_feedbacks WHERE provider_email='$provider_email'")->fetch_assoc();
    $conn->query("UPDATE providers SET rating='{$avg['avg']}', total_reviews='{$avg['cnt']}' WHERE email='$provider_email'");
    echo "success";
} else {
    echo "error: " . $conn->error;
}

$conn->close();
?>