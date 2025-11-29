<?php
include "../conn.php";

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone_number'];

$stmt = $conn->prepare("INSERT INTO participant (name, email, phone_number) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $phone);
$stmt->execute();
$stmt->close();

header("Location: participant_list.php");

exit;
?>