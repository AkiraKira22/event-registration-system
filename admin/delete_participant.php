<?php
session_start();
if (!isset($_SESSION['admin_id'])) header("Location: login.php");

include("../conn.php");

if (isset($_GET['participant_id'])) {
    $participant_id = intval($_GET['participant_id']);

    // Delete participant
    $conn->query("DELETE FROM participant WHERE participant_id=$participant_id");
}

header("Location: manage_participants.php");
exit;
?>