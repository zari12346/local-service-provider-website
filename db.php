<?php
$conn = mysqli_connect("localhost", "root", "", "local_service");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>