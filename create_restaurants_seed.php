<?php
$host = 'localhost';
$db = 'admininf_ulasis-fresh-1';
$user = 'admininf_ulasis';
$pass = '7b@nXTeu~0,5-sG#';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

// 0. Ensure Users has tenant_id
try {
    $pdo->exec("ALTER TABLE users ADD COLUMN tenant_id varchar(255) COLLATE utf8mb4_unicode_ci AFTER email");
    echo "Added 'tenant_id' to users.\n";
} catch (PDOException $e) {
    if (strpos($e->getMessage(), 'Duplicate column') !== false) {
        echo "Column 'tenant_id' already exists in users.\n";
    } else {
        echo "Notice (Users Alter): " . $e->getMessage() . "\n"; // Might fail if it exists, ignoring.
    }
}

// 1. Create Restaurants Table
try {
    $pdo->exec("
    CREATE TABLE IF NOT EXISTS `restaurants` (
      `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
      `tenant_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
      `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
      `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
      `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
      `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
      `settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL,
      PRIMARY KEY (`id`),
      KEY `restaurants_tenant_id_foreign` (`tenant_id`),
      CONSTRAINT `restaurants_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");
    echo "Created table 'restaurants'.\n";
} catch (PDOException $e) {
    if (strpos($e->getMessage(), 'already exists') !== false) {
        echo "Table 'restaurants' already exists.\n";
    } else {
        echo "FAIL Table: " . $e->getMessage() . "\n";
    }
}

// 2. Seed Data
$tenantId = 'test_tenant_1';
$now = date('Y-m-d H:i:s');

try {
    $stmt = $pdo->prepare("INSERT IGNORE INTO tenants (id, created_at, updated_at) VALUES (?, ?, ?)");
    $stmt->execute([$tenantId, $now, $now]);
    echo "Tenant '$tenantId' ensured.\n";
} catch (PDOException $e) {
    echo "Tenant Seed: " . $e->getMessage() . "\n";
}

try {
    $stmt = $pdo->prepare("UPDATE users SET tenant_id = ? WHERE email = 'strong_agent@ulasis.site'");
    $stmt->execute([$tenantId]);
    echo "User 'strong_agent' linked to '$tenantId'.\n";
} catch (PDOException $e) {
    echo "User Update: " . $e->getMessage() . "\n";
}

try {
    $stmt = $pdo->prepare("INSERT IGNORE INTO restaurants (tenant_id, name, created_at, updated_at) VALUES (?, ?, ?, ?)");
    $stmt->execute([$tenantId, 'Agent Test Restaurant', $now, $now]);
    echo "Restaurant for '$tenantId' ensured.\n";
} catch (PDOException $e) {
    echo "Restaurant Seed: " . $e->getMessage() . "\n";
}
