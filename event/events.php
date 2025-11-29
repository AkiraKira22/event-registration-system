<?php
include "../conn.php";

$sql = "SELECT * FROM event ORDER BY start_date ASC";
$result = $conn->query($sql);

$events = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}
?>