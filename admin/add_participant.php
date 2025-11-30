<?php
session_start();
if (!isset($_SESSION['admin_id'])) header("Location: login.php");

include("../conn.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $stmt = $conn->prepare("INSERT INTO participant (name, email, phone_number) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $phone);
    $stmt->execute();
    $stmt->close();

    header("Location: manage_participants.php");
    exit;
}
?>

<h1>Add Participant</h1>
<form method="post">
    <input type="text" name="name" placeholder="Full Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="phone" placeholder="Phone Number">
    <button type="submit">Add Participant</button>
</form>
<a href="manage_participants.php">Back</a>