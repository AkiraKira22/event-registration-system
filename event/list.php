<?php
session_start();
include "../conn.php";

$result = $conn->query("SELECT * FROM event ORDER BY start_date ASC");
$events = [];
while($row = $result->fetch_assoc()) $events[] = $row;
?>

<h1>Upcoming Events</h1>
<ul>
<?php foreach($events as $event): ?>
    <li>
        <a href="detail.php?event_id=<?= $event['event_id']; ?>"><?= htmlspecialchars($event['name']); ?></a>
    </li>
<?php endforeach; ?>
</ul>

<?php if(isset($_SESSION['participant_id'])): ?>
    <a href="../participant/my_events.php">My Registered Events</a>
<?php else: ?>
    <a href="../participant/login.php">Participant Login</a>
<?php endif; ?>
<a href="../participant/dashboard.php">Back to Dashboard</a>