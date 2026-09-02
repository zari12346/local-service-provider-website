<?php
session_start();
unset($_SESSION['provider_email']);
unset($_SESSION['provider_name']);
session_destroy();
header('Content-Type: text/plain');
echo "logged out";
?>
