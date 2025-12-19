<?php
$host = 'localhost';
$db = 'admininf_ulasis-fresh-1';
$user = 'admininf_ulasis';
$pass = '7b@nXTeu~0,5-sG#';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

echo "--- Users ---\n";
$stmt = $pdo->query("SELECT id, email, tenant_id FROM users WHERE email = 'strong_agent@ulasis.site'");
$u = $stmt->fetch(PDO::FETCH_ASSOC);
print_r($u);

echo "\n--- Restaurants ---\n";
try {
    $stmt = $pdo->query("SELECT id, tenant_id, name FROM restaurants");
    $rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    print_r($rs);
} catch (Exception $e) {
    echo "Error reading restaurants: " . $e->getMessage();
}

echo "\n--- Tenants ---\n";
try {
    $stmt = $pdo->query("SELECT id FROM tenants");
    $ts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    print_r($ts);
} catch (Exception $e) {
    echo "Error reading tenants: " . $e->getMessage();
}
