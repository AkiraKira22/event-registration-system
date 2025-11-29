<?php
include "../conn.php";

$name = $_POST['event_name'];
$description = $_POST['description'];
$start = $_POST['start_date'];
$end = $_POST['end_date'];
$location = $_POST['location'];

// Use prepared statement
$stmt = $conn->prepare("INSERT INTO event (name, description, start_date, end_date, location) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $name, $description, $start, $end, $location);
$stmt->execute();
$stmt->close();

header("Location: event_list.php");
exit;
?>