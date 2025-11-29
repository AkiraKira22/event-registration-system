<?php
include "../conn.php";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $participant_id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM participant WHERE participant_id = ?");
    $stmt->bind_param("i", $participant_id);
    $stmt->execute();
    $stmt->close();

    header("Location: participant_list.php");
    exit;
}
else {
    echo "Invalid participant ID.";
    exit;
}
?>