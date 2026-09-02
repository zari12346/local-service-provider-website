<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli("localhost", "root", "", "local_service");

if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit();
}

// Get data from POST
$id = $_POST['id'] ?? 0;
$status = $_POST['status'] ?? '';

if($id == 0 || empty($status)) {
    echo json_encode(["error" => "Missing id or status"]);
    exit();
}

$sql = "UPDATE providers SET status='$status' WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["error" => $conn->error]);
}

$conn->close();
?>