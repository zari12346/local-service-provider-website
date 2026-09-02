<?php
$conn = new mysqli("localhost", "root", "", "local_service");

if ($conn->connect_error) {
    die("Connection failed");
}

$sql = "SELECT * FROM services";
$result = $conn->query($sql);

$services = [];

while($row = $result->fetch_assoc()) {
    $services[] = $row;
}

echo json_encode($services);
?>