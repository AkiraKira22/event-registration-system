<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Participant</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
    <h1>Add New Participant</h1>
</header>

<main>
    <form method="post" action="add_participant_save.php">
        <label>Name:</label>
        <input type="text" name="name" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Phone Number:</label>
        <input type="text" name="phone_number" required>

        <button type="submit" class="btn">Add Participant</button>
    </form>

    <a href="participant_list.php" class="btn">Back</a>
</main>
</body>
</html>