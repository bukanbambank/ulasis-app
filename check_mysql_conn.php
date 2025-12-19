<?php
$host = 'localhost';
$db = 'admininf_ulasis-fresh-1';
$user = 'admininf_ulasis';
$pass = '7b@nXTeu~0,5-sG#';
$charset = 'utf8mb4';

// Try 127.0.0.1 if localhost fails
$tryHosts = ['localhost', '127.0.0.1'];

foreach ($tryHosts as $h) {
    echo "Testing Host: $h ... ";
    try {
        $dsn = "mysql:host=$h;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $pdo = new PDO($dsn, $user, $pass, $options);
        echo "SUCCESS!\n";
        exit(0);
    } catch (\PDOException $e) {
        echo "FAIL: " . $e->getMessage() . "\n";
    }
}
exit(1);
