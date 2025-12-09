<?php
session_start();
include "../conn.php";

if(!isset($_SESSION['admin_id'])) {
    header("Location: ../admin/login.php");
    exit;
}

if (!isset($_GET['event_id']) || !isset($_GET['participant_id'])) {
    die("Missing event or participant ID.");
}

$event_id = $_GET['event_id'];
$participant_id = $_GET['participant_id'];

$stmt = $conn->prepare("DELETE FROM registration WHERE event_id = ? AND participant_id = ?");
$stmt->bind_param("ii", $event_id, $participant_id);
if ($stmt->execute()) {
    $_SESSION["success_message"] = "Registration deleted successfully.";
}
else {
    $_SESSION["error_message"] = "Failed to remove registration:" . $conn->error;
}
$stmt->close();

header("Location: detail.php?event_id=$event_id");
exit;
?>