<?php
session_start();
include "../conn.php";

if(!isset($_SESSION['admin_id'])) {
    header("Location: ../admin/login.php");
    exit;
}

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = $_POST["event_id"];
    $participant_id = $_POST["participant_id"];

    if ($event_id == null) {
        $error .= "Event not found.";
    }
    else {
        // SQL DML with SELECT to check whether participant is already registered
        $stmt_select = $conn->prepare("SELECT * FROM registration WHERE event_id = ? AND participant_id = ?");
        $stmt_select->bind_param("ii", $event_id, $participant_id);
        $stmt_select->execute();

        if ($stmt_select->get_result()->num_rows > 0) {
            $error = "Participant already registered for this event.";
        }
        else {
            $stmt_insert = $conn->prepare("INSERT INTO registration (event_id, participant_id) VALUES (?, ?)");
            $stmt_insert->bind_param("ii", $event_id, $participant_id);
            if ($stmt_insert->execute()) {
                $success = "Participant successfully added!";
            }
            else {
                $error = "Could not register participant." . $conn->error;
            }
            $stmt_insert->close();
        }
        $stmt_select->close();
    }
}

if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];
}
elseif (isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];
}
else {
    die("Event ID is missing.");
}

// SQL DML with SELECT to get event details
$stmt = $conn->prepare("SELECT * FROM event WHERE event_id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();
$event = $result->fetch_assoc();
$stmt->close();
if (!$event) {
    die("Event not found");
}

// SQL DML with SELECT to get all participants
$participants_fetch = $conn->query("SELECT * FROM participant ORDER BY name ASC");
$all_participants = [];
while($row = $participants_fetch->fetch_assoc()) {
    $all_participants[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register Attendee</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<nav class="navbar">
    <div class="navbar-menu">
        <a href="detail.php?event_id=<?= $event_id; ?>">Back to Event Details</a>
        <a href="../admin/logout.php" class="logout-btn">Logout</a>
    </div>
</nav>
<div class="container" style="max-width: 600px;">
    <h1>Register Participant</h1>
    <p>Adding attendee to: <strong><?= htmlspecialchars($event['name']) ?></strong></p>
    <hr>
    <form method="post">
        <input type="hidden" name="event_id" value="<?= $event_id; ?>">
        <label>Select Participant:</label>
        <select name="participant_id" required>
            <option value="">Choose a Person</option>
            <?php foreach($all_participants as $participant): ?>
                <option value="<?= $participant['participant_id'] ?>">
                    <?= htmlspecialchars($participant['name']) ?> (<?= htmlspecialchars($participant['email']) ?>)
                </option>
            <?php endforeach; ?>
        </select>

        <?php if($success): ?>
            <p class="success" style="text-align: center;"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>
        <?php if($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <button type="submit" style="font-size: medium;">Add to Event</button>
    </form>
    <br>
    <a class="btn" href="detail.php?event_id=<?= $event_id; ?>">Back</a>
</div>
</body>
</html>