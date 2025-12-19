<?php
$host = 'localhost';
$db = 'admininf_ulasis-fresh-1';
$user = 'admininf_ulasis';
$pass = '7b@nXTeu~0,5-sG#';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "Connected.\n";

    // Hash for 'Password123!'
    $hash = password_hash('Password123!', PASSWORD_BCRYPT);
    $email = 'strong_agent@ulasis.site';
    $name = 'Strong Agent';
    $now = date('Y-m-d H:i:s');

    // Check if exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $exists = $stmt->fetch();

    if ($exists) {
        echo "User exists (ID: " . $exists['id'] . "). Updating password...\n";
        $upd = $pdo->prepare("UPDATE users SET password = ?, email_verified_at = ? WHERE email = ?");
        $upd->execute([$hash, $now, $email]);
        echo "Updated.\n";
    } else {
        echo "Creating user...\n";
        $ins = $pdo->prepare("INSERT INTO users (name, email, password, email_verified_at, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)");
        $ins->execute([$name, $email, $hash, $now, $now, $now]);
        echo "Created. ID: " . $pdo->lastInsertId() . "\n";
    }

} catch (\PDOException $e) {
    echo "FAIL: " . $e->getMessage() . "\n";
}
