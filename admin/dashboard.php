<?php
session_start();
if (!isset($_SESSION['admin_id'])) header("Location: login.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>

<div class="container">

    <h1>Admin Dashboard</h1><a class="btn" href="manage_events.php">Manage Events</a>
    <a class="btn" href="manage_participants.php">Manage Participants</a>
    <a class="link-danger" href="logout.php">Logout</a>

</div>

</body>
</html>