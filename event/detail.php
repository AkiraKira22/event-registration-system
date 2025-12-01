<?php
session_start();
include "../conn.php";

$event_id = $_GET['event_id'];
$stmt = $conn->prepare("SELECT * FROM event WHERE event_id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();
$event = $result->fetch_assoc();
$stmt->close();

if (!$event) die("Event not found");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($event['name']); ?></title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<div class="container">

    <h1><?= htmlspecialchars($event['name']); ?></h1>
    <p><?= htmlspecialchars($event['description']); ?></p>
    <p><strong>Date:</strong> <?= $event['start_date']; ?> → <?= $event['end_date']; ?></p>
    <p><strong>Location:</strong> <?= htmlspecialchars($event['location']); ?></p>

    <?php if(isset($_SESSION['participant_id'])): ?>
        <form method="post" action="register_participant.php">
            <input type="hidden" name="event_id" value="<?= $event_id; ?>">
            <button type="submit">Register for this event</button>
        </form>
    <?php else: ?>
        <p><a class="link" href="../participant/login.php">Login to register</a></p>
    <?php endif; ?>

    <?php if(isset($_GET['success'])): ?>
        <p class="success">Successfully registered!</p>
    <?php endif; ?>

    <p><a class="link" href="list.php">Back to Event List</a></p>

</div>
</body>
</html>