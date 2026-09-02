<?php
header('Content-Type: text/plain');

$conn = new mysqli("localhost", "root", "", "local_service");

if ($conn->connect_error) {
    die("Connection failed");
}

$email = $_POST['email'];
$service_name = $_POST['service_name'];
$description = $_POST['description'];
$price = $_POST['price'];

$sql = "INSERT INTO provider_services (provider_email, service_name, description, price) 
        VALUES ('$email', '$service_name', '$description', '$price')";

if ($conn->query($sql) === TRUE) {
    echo "success";
} else {
    echo "error: " . $conn->error;
}

$conn->close();
?>