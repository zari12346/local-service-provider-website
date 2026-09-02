<?php
header('Content-Type: text/plain');

$conn = new mysqli("localhost", "root", "", "local_service");

if ($conn->connect_error) {
    die("Connection failed");
}

$email = $_POST['email'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$city = $_POST['city'];
$address = $_POST['address'];

$sql = "UPDATE providers SET name='$name', phone='$phone', city='$city', address='$address' WHERE email='$email'";

if ($conn->query($sql) === TRUE) {
    echo "success";
} else {
    echo "error: " . $conn->error;
}

$conn->close();
?>