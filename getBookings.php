<?php
include 'db.php';

if(isset($_GET['user_id'])) {

    $user_id = $_GET['user_id'];

    $sql = "SELECT bookings.*, services.service_name 
            FROM bookings 
            JOIN services ON bookings.service_id = services.id
            WHERE bookings.user_id = '$user_id'";

    $result = mysqli_query($conn, $sql);

    $data = [];

    while($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    echo json_encode($data);

} else {
    echo "no user id";
}
?>