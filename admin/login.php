<?php
session_start();
include "../conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT admin_id, password FROM admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($admin_id, $hash);
    $stmt->fetch();
    $stmt->close();

    if ($hash && password_verify($password, $hash)) {
        $_SESSION['admin_id'] = $admin_id;
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
    <title>Login Admin</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>

<div class="container">

    <h1>Login Admin Account</h1>

    <form method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>

    <p>Don't have an account? <a class="link" href="register.php">Register here</a></p>
    <p><a class="btn" href="../dashboard.php">Back to main dashboard</a></p>

</div>

</body>
</html>