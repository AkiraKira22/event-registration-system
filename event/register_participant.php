<?php
include("../conn.php");

$event_id = $_POST['event_id'];
$participant_id = $_POST['participant_id'];

// Prevent duplicate registration
$stmt_check = $conn->prepare("SELECT * FROM registration WHERE participant_id=? AND event_id=?");
$stmt_check->bind_param("ii", $participant_id, $event_id);
$stmt_check->execute();
$result = $stmt_check->get_result();
if ($result->num_rows > 0) {
    die("Participant is already registered for this event.");
}
$stmt_check->close();

// Insert registration
$stmt = $conn->prepare("INSERT INTO registration (participant_id, event_id) VALUES (?, ?)");
$stmt->bind_param("ii", $participant_id, $event_id);
$stmt->execute();
$stmt->close();

header("Location: event_detail.php?id=$event_id&success=1");
exit;
?>