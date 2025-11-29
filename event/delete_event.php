<?php
include "../conn.php";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $event_id = $_GET['id'];

    // Delete the event
    $sql = "DELETE FROM event WHERE event_id = $event_id";
    $conn->query($sql);

    // Redirect back to the event manager
    header("Location: manage_event.php");
    exit;
}
else {
    echo "Invalid event ID.";
    exit;
}
?>