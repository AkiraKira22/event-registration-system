<?php
include "../conn.php";

$id = $_POST['event_id'];
$name = $_POST['name'];
$start = $_POST['start_date'];
$end = $_POST['end_date'];
$location = $_POST['location'];

$sql = "UPDATE event SET name='$name', start_date='$start', end_date='$end', location='$location' WHERE event_id = $id";

$conn->query($sql);

header("Location: manage_event.php");
exit;
?>