<?php
session_start();
include "../conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT participant_id, password FROM participant WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($participant_id, $hash);
    $stmt->fetch();
    $stmt->close();

    if ($hash && password_verify($password, $hash)) {
        $_SESSION['participant_id'] = $participant_id;
        header("Location: dashboard.php");
        exit;
    }
    else {
        $error = "Invalid credentials";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Participant</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <h1>Login Participant Account</h1>
    <form method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <?php if(!empty($error)) echo "<p>$error</p>"; ?>
    <p>Don't have an account? <a href="register.php">Register here</a></p>
    <p><a href="../dashboard.php">Back to main dashboard</a></p>
</body>