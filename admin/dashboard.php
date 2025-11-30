<?php
session_start();
if (!isset($_SESSION['admin_id'])) header("Location: login.php");

?>

<h1>Admin Dashboard</h1>
<ul>
    <li><a href="manage_events.php">Manage Events</a></li>
    <li><a href="manage_participants.php">Manage Participants</a></li>
    <li><a href="logout.php">Logout</a></li>
</ul>