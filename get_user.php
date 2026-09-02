<?php
$conn = new mysqli("localhost", "root", "", "local_service");

if ($conn->connect_error) {
    die("Connection failed");
}

$email = $_GET['email'];

$sql = "SELECT first_name, last_name, email, service FROM users WHERE email='$email'";
$result = $conn->query($sql);

if ($row = $result->fetch_assoc()) {
    echo json_encode($row);
} else {
    echo "not found";
}
?>