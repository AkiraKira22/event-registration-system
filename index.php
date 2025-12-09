<?php
include "conn.php";

// SQL DDL tables definition
// Create participant table
$sql = "CREATE TABLE IF NOT EXISTS participant (
    participant_id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone_number VARCHAR(10),
    password VARCHAR(255) NOT NULL
    PRIMARY KEY (participant_id)
)";
if (!$conn->query($sql)) die("Error creating participant table: " . $conn->error);

// Create event table
$sql = "CREATE TABLE IF NOT EXISTS event (
    event_id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    location VARCHAR(255) NOT NULL
    PRIMARY KEY (event_id)
)";
if (!$conn->query($sql)) die("Error creating event table: " . $conn->error);

// Create admin table
$sql = "CREATE TABLE IF NOT EXISTS admin (
    admin_id INT NOT NULL AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
    PRIMARY KEY (admin_id)
)";
if (!$conn->query($sql)) die("Error creating admin table: " . $conn->error);

// Create registration table
$sql = "CREATE TABLE IF NOT EXISTS registration (
    registration_id INT NOT NULL AUTO_INCREMENT,
    event_id INT NOT NULL,
    participant_id INT NOT NULL,
    registration_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (registration_id),
    FOREIGN KEY (event_id) REFERENCES event(event_id) ON DELETE CASCADE,
    FOREIGN KEY (participant_id) REFERENCES participant(participant_id) ON DELETE CASCADE
)";
if (!$conn->query($sql)) die("Error creating registration table: " . $conn->error);

header("Location: dashboard.php");
?>