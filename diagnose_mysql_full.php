<?php
$host = 'localhost';
$db = 'adminf_ualasis-fresh-1';
$user = 'adminf_ualasis';
$pass = '7b@nXTeu~0,5-sG#';
$charset = 'utf8mb4';

echo "PHP Version: " . phpversion() . "\n";
echo "PDO Drivers: " . implode(', ', PDO::getAvailableDrivers()) . "\n";

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
echo "DSN: $dsn\n";

try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    echo "SUCCESS: Connected to localhost via TCP/Socket.\n";
} catch (\PDOException $e) {
    echo "FAIL (localhost): [" . $e->getCode() . "] " . $e->getMessage() . "\n";
}

// Try 127.0.0.1
try {
    $dsn2 = "mysql:host=127.0.0.1;dbname=$db;charset=$charset";
    $pdo = new PDO($dsn2, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    echo "SUCCESS: Connected to 127.0.0.1 via TCP.\n";
} catch (\PDOException $e) {
    echo "FAIL (127.0.0.1): [" . $e->getCode() . "] " . $e->getMessage() . "\n";
}
