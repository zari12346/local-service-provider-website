<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$conn = new mysqli("localhost", "root", "", "local_service");

if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed"]);
    exit();
}

$query = "SELECT provider_email, average_rating, total_reviews FROM provider_ratings ORDER BY average_rating DESC";
$result = $conn->query($query);

$ratings = [];
while($row = $result->fetch_assoc()) {
    $ratings[] = $row;
}

echo json_encode($ratings);
$conn->close();
?>