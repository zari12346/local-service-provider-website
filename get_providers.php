<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "local_service");

if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit();
}

$sql = "SELECT * FROM providers ORDER BY requested_date DESC";
$result = $conn->query($sql);

$providers = [];
while($row = $result->fetch_assoc()) {
    $providers[] = $row;
}

echo json_encode($providers);
$conn->close();
?>