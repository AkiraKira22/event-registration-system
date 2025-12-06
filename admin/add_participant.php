<?php
session_start();
include "../conn.php";

if(!isset($_SESSION['admin_id'])) {
    header("Location: ../admin/login.php");
    exit;
}

// Handle participant form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // SQL DML for inserting participant
    $stmt = $conn->prepare("INSERT INTO participant (name, email, phone_number) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $phone);
    $stmt->execute();
    $stmt->close();

    header("Location: manage_participant.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add Participant</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<nav class="navbar">
    <div class="navbar-menu">
        <a href="manage_participant.php">Back to Participant List</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</nav>
<div class="container">
    <h1>Add Participant</h1>
    <form method="post">
        <label>Full Name</label>
        <input type="text" name="name" required>

        <label>Email Address</label>
        <input type="email" name="email" required>

        <label>Phone Number</label>
        <input type="text" name="phone">

        <button type="submit" style="font-size: medium;">Add Participant</button>
    </form>
    <br>
    <a class="btn" href="manage_participant.php">Back</a>
</div>
</body>
</html>