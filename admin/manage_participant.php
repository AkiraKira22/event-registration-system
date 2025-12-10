<?php
session_start();
include "../conn.php";

if(!isset($_SESSION['admin_id'])) {
    header("Location: ../admin/login.php");
    exit;
}

$search = "";
// Check if search term exists
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
}

// Search by Name
if ($search !== "") {
    // SQL DML to get matching searched participant name
    $sql = "SELECT p.*, COUNT(r.event_id) as event_count
            FROM participant p
            LEFT JOIN registration r ON p.participant_id = r.participant_id
            WHERE p.name = ?
            GROUP BY p.participant_id
            ORDER BY p.name ASC";
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $result = $stmt->get_result();
}
else {
    // SQL DML with aggregation to get participants with their registered events
    $sql = "SELECT p.*, COUNT(r.event_id) as event_count
            FROM participant p
            LEFT JOIN registration r ON p.participant_id = r.participant_id
            GROUP BY p.participant_id
            ORDER BY p.name ASC";

    $result = $conn->query($sql);
}

$participants = [];
while ($row = $result->fetch_assoc()) {
    $participants[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Manage Participants</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<nav class="navbar">
    <div class="navbar-menu">
        <div class="dropdown">
                <button class="dropbtn">Navigate</button>
                <div class="dropdown-content">
                    <a href="manage_event.php">Manage Events</a>
                    <a href="dashboard.php">Home</a>
                </div>
            </div>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</nav>
<div class="container">
    <h1>Manage Participants</h1>
    <div>
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search participant name" value="<?= htmlspecialchars($search) ?>">
            <button type="submit">Search</button>            
        </form>
        <div style="margin:20px">
            <a href="manage_participant.php">Reset</a>
        </div>
    </div>
    <div style="text-align:right;">
        <a href="add_participant.php">Add Participant</a>
    </div>
    <table>
        <thead>
            <tr>
                <th style="width: 25%;">Name</th>
                <th style="width: 30%;">Email</th>
                <th style="width: 20%;">Phone</th>
                <th style="width: 15%;">Events Registered</th>
                <th style="width: 10%;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($participants)): ?>
                <tr><td colspan="5" style="text-align:center;">No participants found.</td></tr>
            <?php else: ?>
                <?php foreach($participants as $participant): ?>
                    <tr>
                        <td><?= htmlspecialchars($participant['name']) ?></td>
                        <td><?= htmlspecialchars($participant['email']) ?></td>
                        <td><?= htmlspecialchars($participant['phone_number']) ?></td>
                        <td style="text-align: center;">
                            <?= $participant['event_count'] ?>
                        </td>
                        <td class="action-links">
                            <a class="link" href="edit_participant.php?participant_id=<?= $participant['participant_id'] ?>">Edit</a>
                            <a class="link-danger" href="delete_participant.php?participant_id=<?= $participant['participant_id'] ?>" onclick="return confirm('Delete this participant?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>