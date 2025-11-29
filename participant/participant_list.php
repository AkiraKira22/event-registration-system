<?php
include "../conn.php";
include "participants.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Participant List</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
    <h1>Participants</h1>
</header>

<main>
    <section class="participant-list">
        <?php if (!empty($participants)): ?>
            <ul>
                <?php foreach ($participants as $p): ?>
                    <li>
                        <strong><?= htmlspecialchars($p['name']); ?></strong>
                        <p>Email: <?= htmlspecialchars($p['email']); ?></p>
                        <p>Phone: <?= htmlspecialchars($p['phone_number']); ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No participants found.</p>
        <?php endif; ?>
        <a href="manage_participant.php" class="btn">Manage Participants</a>
    </section>
</main>
</body>
</html>