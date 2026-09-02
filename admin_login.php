<?php
session_start();
header('Content-Type: text/plain');

$conn = new mysqli("localhost", "root", "", "local_service");

if ($conn->connect_error) {
    die("Connection failed");
}

$email = $_POST['email'];
$password = md5($_POST['password']);

$result = $conn->query("SELECT * FROM admin_users WHERE email='$email' AND password='$password'");

if($result->num_rows > 0) {
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_email'] = $email;
    echo "success";
} else {
    echo "failed";
}

$conn->close();
?>