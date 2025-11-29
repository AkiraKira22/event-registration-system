<?php
include "../conn.php";

$sql = "SELECT * FROM participant ORDER BY participant_id DESC";
$result = $conn->query($sql);


$participants = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $participants[] = $row;
    }
}
?>