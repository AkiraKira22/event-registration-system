<?php
session_start();
include "../conn.php";

if(!isset($_SESSION['admin_id'])) {
    header("Location: ../admin/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-menu">
            <div class="dropdown">
                <button class="dropbtn">Navigate</button>
                <div class="dropdown-content">
                    <a href="manage_event.php">Manage Events</a>
                    <a href="manage_participant.php">Manage Participants</a>
                </div>
            </div>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </nav>
<div class="container">
    <h1>Welcome!!!</h1>
    <p>Use the navigation above to manage events and participants.</p>
</div>
</body>
</html>