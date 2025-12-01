<?php
session_start();
if (!isset($_SESSION['admin_id'])) header("Location: login.php");

include("../conn.php");

// Fetch all events
$result = $conn->query("SELECT * FROM event ORDER BY start_date ASC");
$events = [];
while ($row = $result->fetch_assoc()) $events[] = $row;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Events</title>
    <link rel="stylesheet" href="../styles.css">
    <style>
        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #0066cc;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .action-links a {
            margin-right: 10px;
        }
    </style>
</head>
<body>

<div class="container">

    <h1>Manage Events</h1>

    <p>
        <a class="btn" href="add_event.php">Add New Event</a>
        <a class="btn" href="dashboard.php">Back to Dashboard</a>
    </p>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Start → End</th>
                <th>Location</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($events) === 0): ?>
                <tr>
                    <td colspan="5" style="text-align:center;">No events found.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($events as $event): ?>
                    <tr>
                        <td><?= htmlspecialchars($event['name']); ?></td>
                        <td><?= htmlspecialchars($event['description']); ?></td>
                        <td><?= $event['start_date']; ?> → <?= $event['end_date']; ?></td>
                        <td><?= htmlspecialchars($event['location']); ?></td>
                        <td class="action-links">
                            <a class="link" href="edit_event.php?event_id=<?= $event['event_id']; ?>">Edit</a>
                            <a class="link-danger" href="delete_event.php?event_id=<?= $event['event_id']; ?>" onclick="return confirm('Delete this event?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

</div>

</body>
</html>