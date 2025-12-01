<?php
session_start();
if (!isset($_SESSION['admin_id'])) header("Location: login.php");

include("../conn.php");

$participant_id = $_GET['participant_id'] ?? null;
if (!$participant_id) die("Participant not found");

// Fetch participant
$stmt = $conn->prepare("SELECT * FROM participant WHERE participant_id=?");
$stmt->bind_param("i", $participant_id);
$stmt->execute();
$result = $stmt->get_result();
$participant = $result->fetch_assoc();
$stmt->close();

if (!$participant) die("Participant not found");

// Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $stmt = $conn->prepare("UPDATE participant SET name=?, email=?, phone_number=? WHERE participant_id=?");
    $stmt->bind_param("sssi", $name, $email, $phone, $participant_id);
    $stmt->execute();
    $stmt->close();

    header("Location: manage_participants.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Participant</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>

<div class="container">

    <h1>Edit Participant</h1>

    <form method="post">
        <input type="text" name="name" value="<?= htmlspecialchars($participant['name']); ?>" placeholder="Full Name" required>
        <input type="email" name="email" value="<?= htmlspecialchars($participant['email']); ?>" placeholder="Email" required>
        <input type="text" name="phone" value="<?= htmlspecialchars($participant['phone_number']); ?>" placeholder="Phone Number">
        <button type="submit">Update Participant</button>
    </form>

    <a class="btn" href="manage_participants.php">Back</a>

</div>

</body>
</html>