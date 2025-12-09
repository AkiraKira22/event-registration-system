<?php
session_start();
include "../conn.php";

if(!isset($_SESSION['admin_id'])) {
    header("Location: ../admin/login.php");
    exit;
}

if (isset($_GET['event_id']) && isset($_GET['participant_id'])) {
    $event_id = intval($_GET['event_id']);
    $participant_id = intval($_GET['participant_id']);
    
    // SQL DML with DELETE to remove participant registration
    $conn->query("DELETE FROM registration WHERE event_id = $event_id AND participant_id = $participant_id");
}

header("Location: detail.php?event_id=" . $_GET['event_id']);
exit;
?>