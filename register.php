<?php
$conn = new mysqli("localhost", "root", "", "local_service");

if ($conn->connect_error) {
    die("Connection failed");
}

$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$password = $_POST['password'];
$dob = $_POST['dob'];
$service = $_POST['service'];

// check email exists
$check = $conn->query("SELECT * FROM users WHERE email='$email'");
if ($check->num_rows > 0) {
    echo "Email already exists";
    exit();
}

// insert user
$sql = "INSERT INTO users (first_name, last_name, email, password, dob, service)
VALUES ('$firstName', '$lastName', '$email', '$password', '$dob', '$service')";

if ($conn->query($sql) === TRUE) {
    echo "success";
} else {
    echo "error";
}

$conn->close();
?>