<?php
include "../conn.php";
include "events.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Event Registration System</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
<header>
    <h1>Event Registration System</h1>
</header>

<main>
    <section class="event-list">
        <h2>Upcoming Events</h2>
        <?php if (!empty($events)): ?>
            <ul>
                <?php foreach ($events as $event): ?>
                    <li>
                        <h3><?= htmlspecialchars($event['name']); ?></h3>
                        <p><strong>Date:</strong> <?= $event['start_date']; ?> → <?= $event['end_date']; ?></p>
                        <p><strong>Location:</strong> <?= htmlspecialchars($event['location']); ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No upcoming events.</p>
        <?php endif; ?>
    </section>
    <a href="manage_event.php" class="btn">Manage Events</a>
</main>

</body>
</html>