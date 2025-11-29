<?php
include "../conn.php";

$event_id = $_GET['id'];

$sql = "SELECT * FROM event WHERE event_id = $event_id";
$result = $conn->query($sql);
$event = $result->fetch_assoc();

if (!$event) { die("Event not found"); }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update Event</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
<header><h1>Update Event</h1></header>

<main>
    <form method="post" action="update_event_save.php">
        <input type="hidden" name="event_id" value="<?= $event['event_id']; ?>">

        <label>Event Name:</label>
        <input type="text" name="name" value="<?= $event['name']; ?>" required>

        <label>Start Date:</label>
        <input type="date" name="start_date" value="<?= $event['start_date']; ?>" required>

        <label>End Date:</label>
        <input type="date" name="end_date" value="<?= $event['end_date']; ?>" required>

        <label>Location:</label>
        <input type="text" name="location" value="<?= $event['location']; ?>" required>

        <button type="submit" class="btn">Update</button>
    </form>

    <a href="event_list.php" class="btn">Back</a>
</main>
</body>
</html>