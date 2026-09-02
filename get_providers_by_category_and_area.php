<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli("localhost", "root", "", "local_service");

if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit();
}

$category = $_GET['category'] ?? '';
$area = $_GET['area'] ?? '';

// Removed 'rating' column because it doesn't exist in your table
$sql = "SELECT id, name, service, phone, experience, area, status FROM providers 
        WHERE service = '$category' AND status = 'approved' AND area = '$area'";

$result = $conn->query($sql);

if(!$result) {
    echo json_encode(["error" => "Query failed: " . $conn->error]);
    exit();
}

$providers = [];
while($row = $result->fetch_assoc()) {
    // Add default rating if needed
    $row['rating'] = '4.5';
    $providers[] = $row;
}

echo json_encode($providers);
$conn->close();
?>