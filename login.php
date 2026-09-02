<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

$email = $_POST['email'];
$password = $_POST['password'];

$query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
$result = mysqli_query($conn, $query);

if(!$result){
    die("Query Failed: " . mysqli_error($conn));
}

if(mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    echo "success|" . $row['first_name']; // 👈 name
} else {
    echo "Invalid login";
}
?>