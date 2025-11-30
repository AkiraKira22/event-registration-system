<?php
session_start();
if (!isset($_SESSION['admin_id'])) header("Location: login.php");

include("../conn.php");

// Fetch all events
$result = $conn->query("SELECT * FROM event ORDER BY start_date ASC");
$events = [];
while ($row = $result->fetch_assoc()) $events[] = $row;
?>

<h1>Manage Events</h1>
<a href="add_event.php">Add New Event</a>
<a href="dashboard.php">Back to Dashboard</a>

<ul>
<?php foreach ($events as $event): ?>
    <li>
        <h3><?= htmlspecialchars($event['name']); ?></h3>
        <p><?= htmlspecialchars($event['description']); ?></p>
        <p>Date: <?= $event['start_date']; ?> → <?= $event['end_date']; ?></p>
        <p>Location: <?= htmlspecialchars($event['location']); ?></p>
        <a href="edit_event.php?event_id=<?= $event['event_id']; ?>">Edit</a>
        <a href="delete_event.php?event_id=<?= $event['event_id']; ?>" onclick="return confirm('Delete this event?')">Delete</a>
    </li>
<?php endforeach; ?>
</ul>