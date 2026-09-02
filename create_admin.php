<?php
$conn = new mysqli("localhost", "root", "", "local_service");

$password = md5("admin123");
$sql = "INSERT INTO admin_users (username, password, email) 
        VALUES ('admin', '$password', 'admin@localservice.com')
        ON DUPLICATE KEY UPDATE password='$password'";

if ($conn->query($sql) === TRUE) {
    echo "Admin created/updated successfully!";
    echo "<br>Password hash: " . $password;
} else {
    echo "Error: " . $conn->error;
}
?>