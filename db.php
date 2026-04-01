<?php
$host = 'db';
$user = 'user_app';
$pass = 'password_app';
$db   = 'demo-php';

mysqli_report(MYSQLI_REPORT_OFF);
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    // We don't want to die here, we'll display the error in the dashboard info section gracefully
    $db_status = "Disconnected: " . $conn->connect_error;
    $db_connected = false;
} else {
    $db_status = "Connected to MariaDB";
    $db_connected = true;
}
?>
