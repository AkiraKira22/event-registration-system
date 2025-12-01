<?php
session_start();
include "../conn.php";

$result = $conn->query("SELECT * FROM event ORDER BY start_date ASC");
$events = [];
while($row = $result->fetch_assoc()) $events[] = $row;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upcoming Events</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<div class="container">

    <h1>Upcoming Events</h1>
    
    <ul>
    <?php foreach($events as $event): ?>
        <li>
            <a class="link" href="detail.php?event_id=<?= $event['event_id']; ?>">
                <?= htmlspecialchars($event['name']); ?>
            </a>
        </li>
    <?php endforeach; ?>
    </ul>

    <p>
    <?php if(isset($_SESSION['participant_id'])): ?>
        <a class="link" href="../participant/my_events.php">My Registered Events</a>
    <?php else: ?>
        <a class="link" href="../participant/login.php">Participant Login</a>
    <?php endif; ?>
    </p>

    <p>
        <a class="link" href="../participant/dashboard.php">Back to Dashboard</a>
    </p>

</div>
</body>
</html>