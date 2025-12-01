<?php
session_start();
if (!isset($_SESSION['participant_id'])) header("Location: login.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Participant Dashboard</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>

<div class="container">
    <h1>Participant Dashboard</h1>

    <ul>
        <li><a class="link" href="../event/list.php">Upcoming Events</a></li>
        <li><a class="link" href="my_events.php">Registered Events</a></li>
        <li><a class="link-danger" href="logout.php">Logout</a></li>
    </ul>
</div>

</body>
</html>