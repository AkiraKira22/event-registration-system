<?php
session_start();
include "../conn.php";

if(!isset($_SESSION['admin_id'])) {
    header("Location: ../admin/login.php");
    exit;
}

$error = "";

// Get event ID
if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];
}
else {
    $event_id = null;
}
if (!$event_id) {
    die("Event ID is missing.");
}

// Fetch event details
$stmt = $conn->prepare("SELECT * FROM event WHERE event_id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();

$result = $stmt->get_result();
$event = $result->fetch_assoc();

$stmt->close();
if (!$event) die("Event not found");

// Update event
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $start = $_POST['start_date'];
    $end = $_POST['end_date'];
    $location = $_POST['location'];

    if ($start > $end) {
        $error = "Invalid date input.";
        // Retain entered values
        $event["name"] = $name;
        $event["description"] = $description;
        $event["start_date"] = $start;
        $event["end_date"] = $end;
        $event["location"] = $location;
    }
    else {
        //SQL DML with UPDATE to modify event
        $stmt = $conn->prepare("UPDATE event SET name=?, description=?, start_date=?, end_date=?, location=? WHERE event_id=?");
        $stmt->bind_param("sssssi", $name, $description, $start, $end, $location, $event_id);
        $stmt->execute();
        $stmt->close();

        header("Location: manage_event.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Event</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<nav class="navbar">
    <div class="navbar-menu">
        <a href="manage_event.php">Back to Event List</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</nav>
<div class="container">
    <h1>Edit Event</h1>
    <form method="post">
        <label>Event Name</label>
        <input type="text" name="name" value="<?= htmlspecialchars($event['name']) ?>" required>
        
        <label>Description</label>
        <textarea name="description" required><?= htmlspecialchars($event['description']) ?></textarea>
        
        <label>Start Date</label>
        <input type="date" name="start_date" value="<?= $event['start_date'] ?>" required>
        
        <label>End Date</label>
        <input type="date" name="end_date" value="<?= $event['end_date'] ?>" required>
        
        <label>Location</label>
        <input type="text" name="location" value="<?= htmlspecialchars($event['location']) ?>" required>

        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        
        <button type="submit" style="font-size: medium;">Update Event</button>
    </form>
    <br>
    <a class="btn" href="manage_event.php">Back</a>
</div>
</body>
</html>