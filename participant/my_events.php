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

<h1>My Registered Events</h1>
<ul>
<?php foreach($events as $event): ?>
    <li><?= htmlspecialchars($event['name']); ?> (<?= $event['start_date']; ?> → <?= $event['end_date']; ?>)</li>
<?php endforeach; ?>
</ul>
<a href="../event/list.php">Upcoming Events</a>
<a href="dashboard.php">Back to Dashboard</a>