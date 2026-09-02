<?php
session_start();
header('Content-Type: text/plain');

include 'db.php';

$email    = trim($_POST['email']    ?? '');
$password = trim($_POST['password'] ?? '');

if (empty($email) || empty($password)) {
    echo "error: missing fields";
    exit();
}

$email_safe    = mysqli_real_escape_string($conn, $email);
$password_safe = mysqli_real_escape_string($conn, $password);

// Try plain-text password first (existing users), then md5 (provider-style)
$query = "SELECT id, first_name, last_name, email FROM users 
          WHERE email = '$email_safe' 
          AND (password = '$password_safe' OR password = '" . md5($password) . "')";

$result = mysqli_query($conn, $query);

if (!$result) {
    echo "error: " . mysqli_error($conn);
    exit();
}

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['user_email'] = $row['email'];
    $_SESSION['user_name']  = $row['first_name'] . ' ' . $row['last_name'];
    $_SESSION['user_id']    = $row['id'];
    echo "success|" . $row['first_name'];
} else {
    // Check if email exists to give proper error
    $check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email_safe'");
    if ($check && mysqli_num_rows($check) > 0) {
        echo "invalid_password";
    } else {
        echo "email_not_found";
    }
}

mysqli_close($conn);
?>
