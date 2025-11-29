<?php
include("participants.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Participants</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<header>
    <h1>Manage Participants</h1>
</header>

<main>
    <section class="participant-manage">
        <?php if (!empty($participants)): ?>
            <ul>
                <?php foreach ($participants as $participant): ?>
                    <li>
                        <h3><?= htmlspecialchars($participant['name']); ?></h3>
                        <p><strong>Email:</strong> <?= htmlspecialchars($participant['email']); ?></p>
                        <p><strong>Phone:</strong> <?= htmlspecialchars($participant['phone_number']); ?></p>

                        <a href="update_participant.php?id=<?= $participant['participant_id']; ?>" class="btn">Update</a>
                        <a href="delete_participant.php?id=<?= $participant['participant_id']; ?>" class="btn" onclick="return confirm('Are you sure you want to delete this participant?');">Delete</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No participants found.</p>
        <?php endif; ?>
    </section>

    <a href="add_participant.php" class="btn">Add New Participant</a>
    <a href="participant_list.php" class="btn">Back to Participant List</a>
    <a href="../dashboard.php" class="btn">Back to Dashboard</a>
</main>
</body>
</html>