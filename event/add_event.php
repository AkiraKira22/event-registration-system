<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Event</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
<header>
    <h1>Add New Event</h1>
</header>

<main>
    <form method="post" action="add_event_save.php">
        <label>Event Name:</label>
        <input type="text" name="event_name" required>

        <label>Description:</label>
        <textarea name="description" required></textarea>

        <label>Start Date:</label>
        <input type="date" name="start_date" required>

        <label>End Date:</label>
        <input type="date" name="end_date" required>

        <label>Location:</label>
        <input type="text" name="location" required>

        <button type="submit" class="btn">Add Event</button>
    </form>

    <a href="event_list.php" class="btn">Back</a>
</main>
</body>
</html>