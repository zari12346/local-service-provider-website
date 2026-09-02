<?php
session_start();
session_destroy();
header('Content-Type: text/plain');
echo "logged out";
?>
