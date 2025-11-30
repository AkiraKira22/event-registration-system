<?php
session_start();
if (!isset($_SESSION['admin_id'])) header("Location: login.php");

include("../conn.php");

if(isset($_GET['event_id'])) {
    $event_id = intval($_GET['event_id']);
    $conn->query("DELETE FROM event WHERE event_id = $event_id");
}

header("Location: manage_events.php");
exit;
?>