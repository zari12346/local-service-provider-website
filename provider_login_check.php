<?php
session_start();
header('Content-Type: text/plain');

$conn = new mysqli("localhost", "root", "", "local_service");
if ($conn->connect_error) { echo "error"; exit(); }

$email    = trim($_POST['email']    ?? '');
$password = trim($_POST['password'] ?? '');

if (empty($email) || empty($password)) { echo "error"; exit(); }

$emailSafe = mysqli_real_escape_string($conn, $email);
$hashedPw  = md5($password);

$result = $conn->query("SELECT * FROM providers WHERE email='$emailSafe' AND password='$hashedPw'");

if ($result && $result->num_rows > 0) {
    $row    = $result->fetch_assoc();
    $status = $row['status'];

    if ($status === 'approved') {
        $_SESSION['provider_email'] = $row['email'];
        $_SESSION['provider_name']  = $row['name'];
        $_SESSION['provider_id']    = $row['id'];
        echo "success";
    } elseif ($status === 'pending') {
        echo "pending";
    } elseif ($status === 'rejected') {
        echo "rejected";
    } else {
        echo "pending";
    }
} else {
    // Check if email exists to give better error
    $checkEmail = $conn->query("SELECT id FROM providers WHERE email='$emailSafe'");
    if ($checkEmail && $checkEmail->num_rows > 0) {
        echo "wrong_password";
    } else {
        echo "not_found";
    }
}

$conn->close();
?>
