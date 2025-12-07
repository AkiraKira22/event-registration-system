<?php
session_start();
include "../conn.php";

if(!isset($_SESSION['admin_id'])) {
    header("Location: ../admin/login.php");
    exit;
}

$event_id = $_POST['event_id'];
$participant_id = $_POST['participant_id'];

// SQL DML with SELECT to check existing registration
$stmt_check = $conn->prepare("SELECT * FROM registration WHERE event_id = ? AND participant_id = ?");
$stmt_check->bind_param("ii", $event_id, $participant_id);
$stmt_check->execute();
if($stmt_check->get_result()->num_rows > 0){
    header("Location: add_participant.php?event_id=$event_id&error=Participant already registered");
    exit;
}

// SQL DML with INSERT to add participant to event
$stmt = $conn->prepare("INSERT INTO registration (event_id, participant_id) VALUES (?, ?)");
$stmt->bind_param("ii", $event_id, $participant_id);
if($stmt->execute()){
    $_SESSION['success'] = "Participant successfully added!";
}
else {
    $_SESSION['error'] = "Could not register participant.";
}

header("Location: add_participant.php?event_id=$event_id");
exit;
?>