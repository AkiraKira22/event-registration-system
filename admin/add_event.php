<?php
session_start();
if (!isset($_SESSION['admin_id'])) header("Location: login.php");

include "../conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $start = $_POST['start_date'];
    $end = $_POST['end_date'];
    $location = $_POST['location'];

    $stmt = $conn->prepare("INSERT INTO event (name, description, start_date, end_date, location) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $description, $start, $end, $location);
    $stmt->execute();
    $stmt->close();

    header("Location: manage_events.php");
    exit;
}
?>

<h1>Add Event</h1>
<form method="post">
    <input type="text" name="name" placeholder="Event Name" required>
    <textarea name="description" placeholder="Description" required></textarea>
    <input type="date" name="start_date" required>
    <input type="date" name="end_date" required>
    <input type="text" name="location" placeholder="Location" required>
    <button type="submit">Add Event</button>
</form>
<a href="manage_events.php">Back</a>