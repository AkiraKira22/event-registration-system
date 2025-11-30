<?php
session_start();
include "../conn.php";

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone_number = trim($_POST['phone_number']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate passwords
    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } 
    else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT participant_id FROM participant WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $error = "Email already registered. Choose another.";
        }
        else {
            // Insert new participant
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt_insert = $conn->prepare("INSERT INTO participant (name, email, phone_number, password) VALUES (?, ?, ?, ?)");
            $stmt_insert->bind_param("ssss", $name, $email, $phone_number, $hash);
            if ($stmt_insert->execute()) {
                $success = "Participant account created successfully! <a href='login.php'>Login here</a>.";
            }
            else {
                $error = "Error creating participant account: " . $conn->error;
            }
            $stmt_insert->close();
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register Participant</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <h1>Register Participant Account</h1>

    <?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>
    <?php if ($success) echo "<p style='color:green;'>$success</p>"; ?>

    <?php if (!$success): ?>
    <form method="post">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="phone_number" placeholder="Phone Number">
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <button type="submit">Create Account</button>
    </form>
    <?php endif; ?>

    <p>Already have an account? <a href="login.php">Login here</a></p>
    <p><a href="../dashboard.php">Back to main dashboard</a></p>
</body>
</html>