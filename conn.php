<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "event_registration_system";

$conn = new mysqli($host, $user, $pass);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!$conn->query("CREATE DATABASE IF NOT EXISTS `$dbname`")) {
    die("Error creating database: " . $conn->error);
}

if (!$conn->select_db($dbname)) {
    die("Error selecting database: " . $conn->error);
}
?>