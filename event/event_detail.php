<?php
include("../conn.php");

// Get the event ID from URL
$event_id = $_GET['id'] ?? 0;

// Fetch event details
$stmt = $conn->prepare("SELECT * FROM event WHERE event_id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$event = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$event) {
    die("Event not found.");
}

// Fetch all participants
$participants = [];
$res = $conn->query("SELECT participant_id, name FROM participant ORDER BY name ASC");
while ($row = $res->fetch_assoc()) {
    $participants[] = $row;
}

// Fetch participants already registered
$registered = [];
$res = $conn->prepare("SELECT p.participant_id, p.name 
                       FROM registration r 
                       JOIN participant p ON r.participant_id = p.participant_id
                       WHERE r.event_id = ?");
$res->bind_param("i", $event_id);
$res->execute();
$result = $res->get_result();
while ($row = $result->fetch_assoc()) {
    $registered[] = $row;
}
$res->close();

// Pass variables to HTML view
include("event_detail_view.php");
?>