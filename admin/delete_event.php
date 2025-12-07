<?php
session_start();
include "../conn.php";

if(!isset($_SESSION['admin_id'])) {
    header("Location: ../admin/login.php");
    exit;
}

if(isset($_GET['event_id'])) {
    $event_id = intval($_GET['event_id']);
    
    // SQL DM with DELETE to remove event
    $conn->query("DELETE FROM event WHERE event_id = $event_id");
}

header("Location: manage_event.php");
exit;
?>