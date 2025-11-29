<?php
include("conn.php");

// Create event table
$sql_event = "CREATE TABLE IF NOT EXISTS `event` (
    `event_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `description` TEXT,
    `start_date` DATE NOT NULL,
    `end_date` DATE NOT NULL,
    `location` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if (!$conn->query($sql_event)) {
    die("Error creating event table: " . $conn->error);
}

// Create participant table
$sql_participant = "CREATE TABLE IF NOT EXISTS `participant` (
    `participant_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `phone_number` VARCHAR(20),
    PRIMARY KEY (`participant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if (!$conn->query($sql_participant)) {
    die("Error creating participant table: " . $conn->error);
}

// Create registration table
$sql_registration = "CREATE TABLE IF NOT EXISTS `registration` (
    `registration_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `event_id` INT UNSIGNED NOT NULL,
    `participant_id` INT UNSIGNED NOT NULL,
    `registration_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`registration_id`),
    FOREIGN KEY (`event_id`) REFERENCES `event`(`event_id`) ON DELETE CASCADE,
    FOREIGN KEY (`participant_id`) REFERENCES `participant`(`participant_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if (!$conn->query($sql_registration)) {
    die("Error creating registration table: " . $conn->error);
}

header("Location: dashboard.php");
exit;
?>
