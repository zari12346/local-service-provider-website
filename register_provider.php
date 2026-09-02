<?php
header('Content-Type: text/plain');

$conn = new mysqli("localhost", "root", "", "local_service");

if ($conn->connect_error) {
    echo "error: Connection failed";
    exit();
}

$firstName  = trim($_POST['firstName']  ?? '');
$lastName   = trim($_POST['lastName']   ?? '');
$email      = trim($_POST['email']      ?? '');
$password   = trim($_POST['password']   ?? '');
$phone      = trim($_POST['phone']      ?? '');
$city       = trim($_POST['city']       ?? '');
$area       = trim($_POST['area']       ?? '');
$service    = trim($_POST['service']    ?? '');
$experience = trim($_POST['experience'] ?? '');
$businessName = trim($_POST['businessName'] ?? '');
$cnic       = trim($_POST['cnic']       ?? '');

if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
    echo "error: missing required fields";
    exit();
}

// Check duplicate email
$emailSafe = mysqli_real_escape_string($conn, $email);
$check = $conn->query("SELECT id FROM providers WHERE email='$emailSafe'");
if ($check && $check->num_rows > 0) {
    echo "email_exists";
    exit();
}

$hashedPassword = md5($password);
$fullName = mysqli_real_escape_string($conn, $firstName . ' ' . $lastName);
$emailSafe    = mysqli_real_escape_string($conn, $email);
$phoneSafe    = mysqli_real_escape_string($conn, $phone);
$citySafe     = mysqli_real_escape_string($conn, $city);
$areaSafe     = mysqli_real_escape_string($conn, $area);
$serviceSafe  = mysqli_real_escape_string($conn, $service);
$expSafe      = mysqli_real_escape_string($conn, $experience);
$cnicSafe     = mysqli_real_escape_string($conn, $cnic);

// status = 'pending' — admin must approve before login works
$sql = "INSERT INTO providers (name, email, password, service, phone, city, area, experience, status, requested_date) 
        VALUES ('$fullName', '$emailSafe', '$hashedPassword', '$serviceSafe', '$phoneSafe', '$citySafe', '$areaSafe', '$expSafe', 'pending', CURDATE())";

if ($conn->query($sql) === TRUE) {
    echo "success";
} else {
    echo "error: " . $conn->error;
}

$conn->close();
?>
