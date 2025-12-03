<?php
session_start();
include "../conn.php";

if(!isset($_SESSION['admin_id'])) {
    header("Location: ../admin/login.php");
    exit;
}

// Handle event form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $start = $_POST['start_date'];
    $end = $_POST['end_date'];
    $location = $_POST['location'];

    // Insert new event
    $stmt = $conn->prepare("
        INSERT INTO event (name, description, start_date, end_date, location)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("sssss", $name, $description, $start, $end, $location);
    $stmt->execute();
    $stmt->close();

    header("Location: manage_event.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add Event</title>
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
    <h1>Add Event</h1>
<form method="post">
        <label>Event Name</label>
        <input type="text" name="name" required>

        <label>Description</label>
        <textarea name="description" required></textarea>

        <label>Start Date</label>
        <input type="date" name="start_date" required>

        <label>End Date</label>
        <input type="date" name="end_date" required>

        <label>Location</label>
        <input type="text" name="location" required>

        <button type="submit">Add Event</button>
    </form>
    <br>
    <a class="btn" href="manage_event.php">Cancel</a>
</div>
</body>
</html>