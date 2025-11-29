<?php
include "../conn.php";
include "events.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Events</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
<header>
    <h1>Manage Events</h1>
</header>

<main>
    <section class="event-manage">
        <?php if (!empty($events)): ?>
            <ul>
                <?php foreach ($events as $event): ?>
                    <li>
                        <h3><?= htmlspecialchars($event['name']); ?></h3>
                        <p><strong>Date:</strong> <?= $event['start_date']; ?> → <?= $event['end_date']; ?></p>
                        <p><strong>Location:</strong> <?= htmlspecialchars($event['location']); ?></p>

                        <a href="update_event.php?id=<?= $event['event_id']; ?>" class="btn">Update Event</a>
                        <a href="delete_event.php?id=<?= $event['event_id']; ?>" class="btn" onclick="return confirm('Are you sure you want to delete this event?');">Delete Event</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No existing events.</p>
        <?php endif; ?>
    </section>

    <a href="add_event.php" class="btn">Add New Event</a>
    <a href="event_list.php" class="btn">Back to Event List</a>
    <a href="../dashboard.php" class="btn">Back to Dashboard</a>
</main>

</body>
</html>