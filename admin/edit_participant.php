<?php
session_start();
include "../conn.php";

if(!isset($_SESSION['admin_id'])) {
    header("Location: ../admin/login.php");
    exit;
}

// Get participant ID
if (isset($_GET['participant_id'])) {
    $participant_id = $_GET['participant_id'];
}
else {
    $participant_id = null;
}
if (!$participant_id) {
    die("Participant not found");
}

// SQL DML with SELECT to get participant details
$stmt = $conn->prepare("SELECT * FROM participant WHERE participant_id=?");
$stmt->bind_param("i", $participant_id);
$stmt->execute();

$result = $stmt->get_result();
$participant = $result->fetch_assoc();

$stmt->close();
if (!$participant) die("Participant not found");

// Update participant
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // SQL DML with UPDATE to modify participant
    $stmt = $conn->prepare("UPDATE participant SET name=?, email=?, phone_number=? WHERE participant_id=?");
    $stmt->bind_param("sssi", $name, $email, $phone, $participant_id);
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
    <title>Edit Participant</title>
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
    <h1>Edit Participant</h1>
    <form method="post">
        <label>Full Name</label>
        <input type="text" name="name" value="<?= htmlspecialchars($participant['name']); ?>" required>

        <label>Email Address</label>
        <input type="email" name="email" value="<?= htmlspecialchars($participant['email']); ?>" required>

        <label>Phone Number</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($participant['phone_number']); ?>">

        <button type="submit" style="font-size: medium;">Update Participant</button>
    </form>
    <br>
    <a class="btn" href="manage_participant.php">Back</a>
</div>
</body>
</html>