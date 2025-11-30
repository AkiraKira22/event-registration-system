<?php
session_start();
if (!isset($_SESSION['participant_id'])) header("Location: login.php");

?>

<h1>Participant Dashboard</h1>
<ul>
    <li><a href="../event/list.php">Upcoming Events</a></li>
    <li><a href="my_events.php">Registered Events</a></li>
    <li><a href="logout.php">Logout</a></li>
</ul>