<?php
include "../conn.php";

$participant_id = $_GET['id'];
$sql = "SELECT * FROM participant WHERE participant_id = $participant_id";
$result = $conn->query($sql);
$participant = $result->fetch_assoc();

if (!$participant) {
    die("Participant not found");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update Participant</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header><h1>Update Participant</h1></header>

<main>
    <form method="post" action="update_participant_save.php">
        <input type="hidden" name="participant_id" value="<?= $participant['participant_id']; ?>">

        <label>Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($participant['name']); ?>" required>

        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($participant['email']); ?>" required>

        <label>Phone Number:</label>
        <input type="text" name="phone_number" value="<?= htmlspecialchars($participant['phone_number']); ?>" required>

        <button type="submit" class="btn">Update Participant</button>
    </form>

    <a href="participant_list.php" class="btn">Back</a>
</main>
</body>
</html>