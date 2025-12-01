<?php
session_start();
if(!isset($_SESSION['participant_id'])) header("Location: login.php");

include "../conn.php";

$stmt = $conn->prepare("
    SELECT e.* FROM event e
    JOIN registration r ON e.event_id = r.event_id
    WHERE r.participant_id = ?
");
$stmt->bind_param("i", $_SESSION['participant_id']);
$stmt->execute();
$result = $stmt->get_result();
$events = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Registered Events</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>

<div class="container">
    <h1>My Registered Events</h1>

    <?php if(empty($events)): ?>
        <p>You have not registered for any events yet.</p>
    <?php else: ?>
        <ul>
        <?php foreach($events as $event): ?>
            <li>
                <?= htmlspecialchars($event['name']); ?> 
                (<?= $event['start_date']; ?> → <?= $event['end_date']; ?>)
            </li>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <p>
        <a class="link" href="../event/list.php">Upcoming Events</a> |
        <a class="link" href="dashboard.php">Back to Dashboard</a>
    </p>
</div>

</body>
</html>