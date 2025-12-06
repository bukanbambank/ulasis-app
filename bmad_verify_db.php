<?php
$envContent = file_get_contents(__DIR__ . '/.env');
preg_match('/DB_HOST=(.*)/', $envContent, $hostM);
preg_match('/DB_USERNAME=(.*)/', $envContent, $userM);
preg_match('/DB_PASSWORD=(.*)/', $envContent, $passM);
// Simple parsing, robust enough for standard Laravel .env

$host = trim($hostM[1] ?? '127.0.0.1');
$user = trim($userM[1] ?? 'root');
$pass = trim($passM[1] ?? '');
$db = 'ulasis_fresh_1';

echo "Checking connection to $host with user $user...\n";
$conn = @new mysqli($host, $user, $pass);
if ($conn->connect_error) {
    echo "FAIL: Connection failed: " . $conn->connect_error . "\n";
    exit(1);
}
if (!$conn->select_db($db)) {
    echo "FAIL: Database $db does not exist\n";
    exit(1);
}
echo "PASS: Database exists\n";
exit(0);
