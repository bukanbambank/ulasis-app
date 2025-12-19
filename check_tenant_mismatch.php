<?php
$host = 'localhost';
$db = 'admininf_ulasis-fresh-1';
$user = 'admininf_ulasis';
$pass = '7b@nXTeu~0,5-sG#';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

echo "--- User ---\n";
$stmt = $pdo->query("SELECT id, email, tenant_id FROM users WHERE email = 'strong_agent@ulasis.site'");
print_r($stmt->fetch(PDO::FETCH_ASSOC));

echo "\n--- QR Code ---\n";
$uuid = '10dc8233-ab44-423c-acf7-4cb403798d09';
$stmt = $pdo->query("SELECT id, tenant_id, unique_code FROM qr_codes WHERE unique_code = '$uuid'");
print_r($stmt->fetch(PDO::FETCH_ASSOC));

echo "\n--- Feedback ---\n";
$stmt = $pdo->query("SELECT id, tenant_id, ratings, feedback_text FROM feedback_responses");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
