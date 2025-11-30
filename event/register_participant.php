<?php
session_start();
include "../conn.php";

if(!isset($_SESSION['participant_id'])) {
    header("Location: ../participant/login.php");
    exit;
}

$participant_id = $_SESSION['participant_id'];
$event_id = $_POST['event_id'] ?? null;

if(!$event_id) {
    die("No event selected.");
}

// Check if participant is already registered
$stmt_check = $conn->prepare("SELECT * FROM registration WHERE event_id = ? AND participant_id = ?");
$stmt_check->bind_param("ii", $event_id, $participant_id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if($result_check->num_rows > 0){
    $stmt_check->close();
    header("Location: detail.php?event_id=$event_id&success=already");
    exit;
}
$stmt_check->close();

// Register participant
$stmt = $conn->prepare("INSERT INTO registration (event_id, participant_id) VALUES (?, ?)");
$stmt->bind_param("ii", $event_id, $participant_id);
$stmt->execute();
$stmt->close();

header("Location: detail.php?event_id=$event_id&success=1");
exit;
?>