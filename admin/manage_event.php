<?php
session_start();
include "../conn.php";

if(!isset($_SESSION['admin_id'])) {
    header("Location: ../admin/login.php");
    exit;
}

$search = "";
// Check if search term exists
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
}
// Search by Name 
if ($search !== "") {
    // SQL DML to get matching searched event name
    $sql = "SELECT e.*, COUNT(r.registration_id) as attendee_count
            FROM event e
            LEFT JOIN registration r ON e.event_id = r.event_id
            WHERE e.name = ?
            GROUP BY e.event_id
            ORDER BY e.start_date DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $result = $stmt->get_result();
}
else {
    // SQL DML with aggregation to get events with attendee counts
    $sql = "SELECT e.*, COUNT(r.registration_id) as attendee_count
            FROM event e
            LEFT JOIN registration r ON e.event_id = r.event_id
            GROUP BY e.event_id
            ORDER BY e.start_date DESC";
    $result = $conn->query($sql);
}

$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = $row;
}
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
                    <a href="manage_participant.php">Manage Participants</a>
                    <a href="dashboard.php">Home</a>
                </div>
            </div>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</nav>
<div class="container">
    <h1>Manage Events</h1>
    <div>
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search event name" value="<?= htmlspecialchars($search) ?>">
            <button type="submit">Search</button>            
        </form>
        <div style="margin:20px">
            <a href="manage_event.php">Reset</a>
        </div>
    </div>
    <div style="text-align:right;">
        <a href="add_event.php">Add Event</a>
    </div>
    <table>
        <thead>
            <tr>
                <th style="width: 20%;">Name</th>
                <th style="width: 25%;">Description</th>
                <th style="width: 20%;">Start → End</th>
                <th style="width: 15%;">Location</th>
                <th style="width: 10%">Attendees</th>
                <th style="width: 10%;">Actions</th>
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
                    <td>
                        <a href="../event/detail.php?event_id=<?= $event['event_id']; ?>" class="link" style="font-weight: bold;">
                            <?= htmlspecialchars($event['name']) ?>
                        </a>
                    </td>
                    <td><?= htmlspecialchars($event['description']) ?></td>
                    <td><?= $event['start_date']; ?> → <?= $event['end_date'] ?></td>
                    <td><?= htmlspecialchars($event['location']) ?></td>
                    <td style="text-align:center"><?= $event['attendee_count'] ?></td>
                    <td class="action-links">
                        <a class="link" href="edit_event.php?event_id=<?= $event['event_id'] ?>">Edit</a>
                        <a class="link-danger" href="delete_event.php?event_id=<?= $event['event_id'] ?>" onclick="return confirm('Delete this event?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
    </table>
</div>
</body>
</html>