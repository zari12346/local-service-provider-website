<?php
$conn = new mysqli("localhost", "root", "", "local_service");

$email = "qasim@gmail.com";
$password = "qasim123";
$hashed = md5($password);

echo "Email: $email<br>";
echo "Password: $password<br>";
echo "MD5 of password: $hashed<br><br>";

$result = $conn->query("SELECT id, name, email, password, status FROM providers WHERE email='$email'");

if($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "✅ Provider found in database!<br>";
    echo "Name: " . $row['name'] . "<br>";
    echo "Stored password hash: " . $row['password'] . "<br>";
    echo "Expected hash (MD5 of qasim123): " . $hashed . "<br>";
    
    if($row['password'] === $hashed) {
        echo "✅ Password MATCH!<br>";
        echo "Status: " . $row['status'] . "<br>";
        if($row['status'] === 'approved') {
            echo "✅ Status is APPROVED! Login should work.<br>";
        } else {
            echo "❌ Status is NOT approved. Please approve this provider.<br>";
        }
    } else {
        echo "❌ Password does NOT match!<br>";
        echo "Stored: " . $row['password'] . "<br>";
        echo "Expected: " . $hashed . "<br>";
    }
} else {
    echo "❌ No provider found with email: $email";
}

$conn->close();
?>