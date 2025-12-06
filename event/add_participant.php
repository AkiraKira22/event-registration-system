<?php
session_start();
include "../conn.php";

if(!isset($_SESSION['admin_id'])) {
    header("Location: ../admin/login.php");
    exit;
}

if(!isset($_GET['event_id'])) {
    die("Event ID missing.");
}

$event_id = $_GET['event_id'];

// Fetch Event Name
$stmt = $conn->prepare("SELECT name FROM event WHERE event_id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$event = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$event) {
    die("Event not found");
}

// Fetch participants
$participants_fetch = $conn->query("SELECT * FROM participant ORDER BY name ASC");
$all_participants = [];
while($row = $participants_fetch->fetch_assoc()) {
    $all_participants[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register Attendee</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<nav class="navbar">
    <div class="navbar-menu">
        <a href="detail.php?event_id=<?= $event_id; ?>">Back to Event Details</a>
        <a href="../admin/logout.php" class="logout-btn">Logout</a>
    </div>
</nav>
<div class="container" style="max-width: 600px;">
    <h1>Register Participant</h1>
    <p>Adding attendee to: <strong><?= htmlspecialchars($event['name']); ?></strong></p>
    <hr>
    <form method="post" action="register_participant.php">
        <input type="hidden" name="event_id" value="<?= $event_id; ?>">
        <label>Select Participant:</label>
        <select name="participant_id" required>
            <option value="">Choose a Person</option>
            <?php foreach($all_participants as $p): ?>
                <option value="<?= $p['participant_id']; ?>">
                    <?= htmlspecialchars($p['name']); ?> (<?= htmlspecialchars($p['email']); ?>)
                </option>
            <?php endforeach; ?>
        </select>
        <?php if(isset($_SESSION['success'])): ?>
            <p class="success" style="text-align: center;"><?= htmlspecialchars($_SESSION['success']); ?></p>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        <?php if(isset($_SESSION['error'])): ?>
            <p class="error"><?= htmlspecialchars($_SESSION['error']); ?></p>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <button type="submit" style="font-size: medium;">Add to Event</button>
    </form>
    <br>
    <a class="btn" href="detail.php?event_id=<?= $event_id; ?>">Back</a>
</div>
</body>
</html>