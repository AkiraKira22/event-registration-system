<?php
session_start();
include "../conn.php";

$error = "";
$success = "";

// Handle register form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    }
    else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT admin_id FROM admin WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $error = "Email already registered. Use another email.";
        }
        else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            // Create admin account
            $stmt_insert = $conn->prepare("INSERT INTO admin (email, password) VALUES (?, ?)");
            $stmt_insert->bind_param("ss", $email, $hash);
            if ($stmt_insert->execute()) {
                $success = "Admin account created successfully! <a href='login.php'>Login here</a>.";
            }
            else {
                $error = "Error creating admin account: " . $conn->error;
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
    <title>Register Admin</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<div class="container" style="width: 500px;">
    <h1>Register</h1>
    <?php if ($error) echo "<p class='error'>$error</p>"; ?>
    <?php if ($success) echo "<p class='success'>$success</p>"; ?>
    <?php if (!$success): ?>
    <form method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <button type="submit">Create Admin</button>
    </form>
    <p>Already have an account? <a class="link" href="login.php">Login here</a></p>
    <p><a class="btn" href="../dashboard.php">Cancel</a></p>
    <?php endif; ?>
</div>
</body>
</html>