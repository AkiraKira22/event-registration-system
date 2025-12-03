<?php
session_start();
include "../conn.php";

if(!isset($_SESSION['admin_id'])) {
    header("Location: ../admin/login.php");
    exit;
}

// Fetch participants
$result = $conn->query("SELECT * FROM participant ORDER BY name ASC");
$participants = [];

while ($row = $result->fetch_assoc()) {
    $participant_id = $row['participant_id'];

    // Fetch events this participant is registered to
    $stmt = $conn->prepare("
        SELECT e.name 
        FROM event e
        JOIN registration r ON e.event_id = r.event_id
        WHERE r.participant_id = ?
        ORDER BY e.start_date ASC
    ");
    $stmt->bind_param("i", $participant_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $events = [];
    while ($event_row = $res->fetch_assoc()) {
        $events[] = $event_row['name'];
    }
    $stmt->close();

    $row['registered_events'] = $events;
    $participants[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Manage Participants</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<nav class="navbar">
    <div class="navbar-menu">
        <div class="dropdown">
                <button class="dropbtn">Navigate</button>
                <div class="dropdown-content">
                    <a href="manage_event.php">Manage Events</a>
                    <a href="manage_registration.php">Register Participant</a>
                    <a href="dashboard.php">Home</a>
                </div>
            </div>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</nav>
<div class="container">
    <h1>Manage Participants</h1>
    <div style="margin-bottom: 20px; text-align: right;">
        <a href="add_participant.php">Add Participant</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Registered Events</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($participants)): ?>
                <tr><td colspan="5" style="text-align:center;">No participants found.</td></tr>
            <?php else: ?>
                <?php foreach($participants as $p): ?>
                    <tr>
                        <td><?= htmlspecialchars($p['name']); ?></td>
                        <td><?= htmlspecialchars($p['email']); ?></td>
                        <td><?= htmlspecialchars($p['phone_number']); ?></td>
                        <td>
                            <?php 
                                if (!empty($p['registered_events'])) {
                                    echo implode(", ", array_map('htmlspecialchars', $p['registered_events']));
                                }
                                else {
                                    echo "<span style='color:lightgray;'>None</span>";
                                }
                            ?>
                        </td>
                        <td class="action-links">
                            <a class="link" href="edit_participant.php?participant_id=<?= $p['participant_id']; ?>">Edit</a>
                            <a class="link-danger" href="delete_participant.php?participant_id=<?= $p['participant_id']; ?>" onclick="return confirm('Delete this participant?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>