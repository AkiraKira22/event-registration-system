<?php
include "../conn.php";

$id = $_POST['participant_id'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone_number'];

$stmt = $conn->prepare("UPDATE participant SET name=?, email=?, phone_number=? WHERE participant_id=?");
$stmt->bind_param("sssi", $name, $email, $phone, $id);
$stmt->execute();
$stmt->close();

header("Location: participant_list.php");
exit;
?>