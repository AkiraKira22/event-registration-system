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

<!DOCTYPE html>
<html>
<head>
    <title>Edit Event</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>

<div class="container">

    <h1>Edit Event</h1>

    <form method="post">
        <input type="text" name="name" value="<?= htmlspecialchars($event['name']); ?>" placeholder="Event Name" required>
        <textarea name="description" placeholder="Description" required><?= htmlspecialchars($event['description']); ?></textarea>
        <input type="date" name="start_date" value="<?= $event['start_date']; ?>" required>
        <input type="date" name="end_date" value="<?= $event['end_date']; ?>" required>
        <input type="text" name="location" value="<?= htmlspecialchars($event['location']); ?>" placeholder="Location" required>
        <button type="submit">Update Event</button>
    </form>

    <a class="btn" href="manage_events.php">Back</a>

</div>

</body>
</html>