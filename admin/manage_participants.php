<?php
session_start();
if (!isset($_SESSION['admin_id'])) header("Location: login.php");

include("../conn.php");

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
    <title>Manage Participants</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>

<div class="container">

    <h1>Manage Participants</h1>

    <p>
        <a class="btn" href="add_participant.php">Add Participant</a>
        <a class="btn" href="dashboard.php">Back to Dashboard</a>
    </p>

    <ul>
    <?php foreach($participants as $p): ?>
        <li>
            <h3><?= htmlspecialchars($p['name']); ?></h3>
            <p>Email: <?= htmlspecialchars($p['email']); ?> | Phone: <?= htmlspecialchars($p['phone_number']); ?></p>
            <p><strong>Registered Events:</strong>
                <?php 
                    if (!empty($p['registered_events'])) {
                        echo implode(", ", array_map('htmlspecialchars', $p['registered_events']));
                    } else {
                        echo "None";
                    }
                ?>
            </p>
            <a class="link" href="edit_participant.php?participant_id=<?= $p['participant_id']; ?>">Edit</a>
            <a class="link-danger" href="delete_participant.php?participant_id=<?= $p['participant_id']; ?>" onclick="return confirm('Delete this participant?')">Delete</a>
        </li>
    <?php endforeach; ?>
    </ul>

</div>

</body>
</html>