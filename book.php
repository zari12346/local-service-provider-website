<?php
include 'db.php';

if(isset($_POST['user_id']) && isset($_POST['service_id']) && isset($_POST['booking_date'])) {

    $user_id = $_POST['user_id'];
    $service_id = $_POST['service_id'];
    $booking_date = $_POST['booking_date'];

    $sql = "insert into bookings (user_id, service_id, booking_date, status) 
            values ('$user_id', '$service_id', '$booking_date', 'pending')";

    if(mysqli_query($conn, $sql)) {
        echo "booking successful";
    } else {
        echo "error: " . mysqli_error($conn);
    }

} else {
    echo "no data received";
}
?>