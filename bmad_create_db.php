<?php
$host = '127.0.0.1';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($conn->query("CREATE DATABASE IF NOT EXISTS ulasis_fresh_1") === TRUE) {
    echo "Database created successfully\n";
} else {
    echo "Error creating database: " . $conn->error . "\n";
    exit(1);
}
$conn->close();
?>