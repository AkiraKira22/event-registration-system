<!DOCTYPE html>
<html lang="en">
<head>
    <title>Event: <?= htmlspecialchars($event['name']); ?></title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<header>
    <h1><?= htmlspecialchars($event['name']); ?></h1>
</header>
<main>
    <p><strong>Date:</strong> <?= $event['start_date']; ?> → <?= $event['end_date']; ?></p>
    <p><strong>Location:</strong> <?= htmlspecialchars($event['location']); ?></p>
    <p><strong>Description:</strong> <?= htmlspecialchars($event['description']); ?></p>

    <h2>Register Participant</h2>
    <form method="post" action="register_participant.php">
        <input type="hidden" name="event_id" value="<?= $event_id; ?>">
        <select name="participant_id" required>
            <option value="">-- Select Participant --</option>
            <?php foreach($participants as $p): ?>
                <option value="<?= $p['participant_id']; ?>"><?= htmlspecialchars($p['name']); ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn">Register</button>
    </form>

    <h2>Registered Participants</h2>
    <?php if (!empty($registered)): ?>
        <ul>
            <?php foreach($registered as $p): ?>
                <li><?= htmlspecialchars($p['name']); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No participants registered yet.</p>
    <?php endif; ?>

    <a href="../event_list.php" class="btn">Back to Events</a>
</main>
</body>
</html>