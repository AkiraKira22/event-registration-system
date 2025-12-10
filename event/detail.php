<?php
session_start();
include "../conn.php";

if(!isset($_SESSION['admin_id'])) {
    header("Location: ../admin/login.php");
    exit;
}

$event_id = $_GET['event_id'];

// SQL DML with SELECT to get event details
$stmt = $conn->prepare("SELECT * FROM event WHERE event_id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$event = $stmt->get_result()->fetch_assoc();
$stmt->close();
if (!$event) {
    die("Event not found");
}

// SQL DML with JOIN to get registered participants
$sql = "SELECT r.registration_id, r.registration_date, p.participant_id, p.name, p.email
        FROM registration r
        JOIN participant p ON r.participant_id = p.participant_id 
        WHERE r.event_id = ?
        ORDER BY r.registration_date ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();
$registered_users = [];
while($row = $result->fetch_assoc()) {
    $registered_users[] = $row;
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($event['name']) ?></title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<nav class="navbar">
    <div class="navbar-menu">
        <a href="../admin/manage_event.php">Back to Event List</a>
        <a href="../admin/logout.php" class="logout-btn">Logout</a>
    </div>
</nav>
<div class="container">
    <h1><?= htmlspecialchars($event['name']) ?></h1>   
    <div style="text-align: left; margin-bottom: 20px;">
        <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($event['description'])) ?></p>
        <p><strong>Date:</strong> <?= $event['start_date'] ?> → <?= $event['end_date'] ?></p>
        <p><strong>Location:</strong> <?= htmlspecialchars($event['location']) ?></p>
    </div>
    <hr>
    <div>
        <h3>Current Attendee List</h3>
    </div>
    <div style="text-align:right;">
        <a href="register_participant.php?event_id=<?= $event_id; ?>">Register Participant</a>
    </div>
    <table>
        <thead>
            <tr>
                <th style="width:35%">Name</th>
                <th style="width:35%">Email</th>
                <th style="width:20%">Registration Time</th>
                <th style="width:10%">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($registered_users)): ?>
                <tr><td colspan="4" style="text-align:center;">No attendees yet.</td></tr>
            <?php else: ?>
                <?php foreach($registered_users as $reg_user): ?>
                    <tr>
                        <td><?= htmlspecialchars($reg_user['name']) ?></td>
                        <td><?= htmlspecialchars($reg_user['email']) ?></td>
                        <td><?= $reg_user['registration_date'] ?></td>
                        <td class="action-links">
                            <a class="link-danger" 
                               href="delete_registration.php?event_id=<?= $event_id; ?>&participant_id=<?= $reg_user['participant_id'] ?>" 
                               onclick="return confirm('Deregister <?= htmlspecialchars($reg_user['name']) ?> from this event?')"
                            >Deregister</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>