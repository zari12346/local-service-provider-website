<?php
session_start();
header('Content-Type: text/plain');
if (isset($_SESSION['user_email']) && !empty($_SESSION['user_email'])) {
    echo 'logged_in';
} else {
    echo 'not_logged_in';
}
?>
