<?php
$conn = new mysqli("localhost", "root", "", "local_service");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Change these values
$username = "talmeez";
$password = md5("talmeez123");
$email = "talmeez@admin.com";

$sql = "INSERT INTO admin_users (username, password, email) VALUES ('$username', '$password', '$email')";

if ($conn->query($sql) === TRUE) {
    echo "✅ New admin added successfully!<br>";
    echo "Username: $username<br>";
    echo "Password: talmeez123<br>";
    echo "Email: $email<br>";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>