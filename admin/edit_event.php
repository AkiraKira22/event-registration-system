<?php
session_start();
if (!isset($_SESSION['admin_id'])) header("Location: login.php");

include "../conn.php";

$event_id = $_GET['event_id'];

// Fetch event details
$stmt = $conn->prepare("SELECT * FROM event WHERE event_id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();
$event = $result->fetch_assoc();
$stmt->close();

if (!$event) die("Event not found");

// Update event
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $start = $_POST['start_date'];
    $end = $_POST['end_date'];
    $location = $_POST['location'];

    $stmt = $conn->prepare("UPDATE event SET name=?, description=?, start_date=?, end_date=?, location=? WHERE event_id=?");
    $stmt->bind_param("sssssi", $name, $description, $start, $end, $location, $event_id);
    $stmt->execute();
    $stmt->close();

    header("Location: manage_events.php");
    exit;
}
?>

<h1>Edit Event</h1>
<form method="post">
    <input type="text" name="name" value="<?= htmlspecialchars($event['name']); ?>" required>
    <textarea name="description" required><?= htmlspecialchars($event['description']); ?></textarea>
    <input type="date" name="start_date" value="<?= $event['start_date']; ?>" required>
    <input type="date" name="end_date" value="<?= $event['end_date']; ?>" required>
    <input type="text" name="location" value="<?= htmlspecialchars($event['location']); ?>" required>
    <button type="submit">Update Event</button>
</form>
<a href="manage_events.php">Back</a>