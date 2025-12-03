<?php
session_start();
include "../conn.php";

if(!isset($_SESSION['admin_id'])) {
    header("Location: ../admin/login.php");
    exit;
}

// Fetch events with attendee counts
$sql = "SELECT e.*, COUNT(r.registration_id) as attendee_count  FROM event e LEFT JOIN registration r ON e.event_id = r.event_id GROUP BY e.event_id ORDER BY e.start_date ASC";
$result = $conn->query($sql);
$events = [];
while ($row = $result->fetch_assoc()) $events[] = $row;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Manage Events</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<nav class="navbar">
    <div class="navbar-menu">
        <div class="dropdown">
                <button class="dropbtn">Navigate</button>
                <div class="dropdown-content">
                    <a href="manage_event.php">Manage Events</a>
                    <a href="manage_participant.php">Manage Participants</a>
                    <a href="dashboard.php">Home</a>
                </div>
            </div>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</nav>
<div class="container">
    <h1>Manage Registration</h1>
    <table style="margin-top: 80px;">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Start → End</th>
                <th>Location</th>
                <th>Attendees</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php if (count($events) === 0): ?>
            <tr>
                <td colspan="6" style="text-align:center;">No events found.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($events as $event): ?>
                <tr>
                    <td><?= htmlspecialchars($event['name']); ?></td>
                    <td><?= htmlspecialchars($event['description']); ?></td>
                    <td><?= $event['start_date']; ?> → <?= $event['end_date']; ?></td>
                    <td><?= htmlspecialchars($event['location']); ?></td>
                    <td style="text-align:center; font-weight:bold;"><?= $event['attendee_count']; ?></td>
                    <td class="action-links">
                        <a class="link" href="../event/detail.php?event_id=<?= $event['event_id']; ?>">Register</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
    </table>
</div>
</body>
</html>