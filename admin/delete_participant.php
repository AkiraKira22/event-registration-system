<?php
session_start();
include "../conn.php";

if(!isset($_SESSION['admin_id'])) {
    header("Location: ../admin/login.php");
    exit;
}

// Delete participant
if (isset($_GET['participant_id'])) {
    $participant_id = intval($_GET['participant_id']);
    $conn->query("DELETE FROM participant WHERE participant_id=$participant_id");
}

header("Location: manage_participant.php");
exit;
?>