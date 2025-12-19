<?php
$host = 'localhost';
$db = 'admininf_ulasis-fresh-1';
$user = 'admininf_ulasis';
$pass = '7b@nXTeu~0,5-sG#';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

function createTable($pdo, $name, $sql)
{
  try {
    $pdo->exec($sql);
    echo "Created table '$name'.\n";
  } catch (PDOException $e) {
    if (strpos($e->getMessage(), 'already exists') !== false) {
      echo "Table '$name' already exists.\n";
    } else {
      echo "FAIL '$name': " . $e->getMessage() . "\n";
    }
  }
}

// 1. Tenants
createTable($pdo, 'tenants', "
CREATE TABLE IF NOT EXISTS `tenants` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `data` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

// 1.5 Questionnaires (Added)
createTable($pdo, 'questionnaires', "
CREATE TABLE IF NOT EXISTS `questionnaires` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `template_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  `questions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `questionnaires_tenant_id_foreign` (`tenant_id`),
  CONSTRAINT `questionnaires_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

// 1.8 Restaurants (Added)
createTable($pdo, 'restaurants', "
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

// SEED DATA
echo "\nSeeding Data...\n";
$tenantId = 'test_tenant_1';
$now = date('Y-m-d H:i:s');

// 1. Insert Tenant
try {
  $stmt = $pdo->prepare("INSERT IGNORE INTO tenants (id, created_at, updated_at) VALUES (?, ?, ?)");
  $stmt->execute([$tenantId, $now, $now]);
  echo "Tenant '$tenantId' ensured.\n";
} catch (PDOException $e) {
  echo "Tenant Seed: " . $e->getMessage() . "\n";
}

// 2. Update User
try {
  $stmt = $pdo->prepare("UPDATE users SET tenant_id = ? WHERE email = 'strong_agent@ulasis.site'");
  $stmt->execute([$tenantId]);
  echo "User 'strong_agent' linked to '$tenantId'.\n";
} catch (PDOException $e) {
  echo "User Update: " . $e->getMessage() . "\n";
}

// 3. Insert Restaurant
try {
  $stmt = $pdo->prepare("INSERT IGNORE INTO restaurants (tenant_id, name, created_at, updated_at) VALUES (?, ?, ?, ?)");
  $stmt->execute([$tenantId, 'Agent Test Restaurant', $now, $now]);
  echo "Restaurant for '$tenantId' ensured.\n";
} catch (PDOException $e) {
  echo "Restaurant Seed: " . $e->getMessage() . "\n";
}

// 2. QR Codes
createTable($pdo, 'qr_codes', "
CREATE TABLE IF NOT EXISTS `qr_codes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `questionnaire_id` bigint(20) unsigned DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `qr_codes_tenant_id_foreign` (`tenant_id`),
  CONSTRAINT `qr_codes_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

// 3. Feedback Responses
createTable($pdo, 'feedback_responses', "
CREATE TABLE IF NOT EXISTS `feedback_responses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qr_code_id` bigint(20) unsigned NOT NULL,
  `ratings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `feedback_text` text COLLATE utf8mb4_unicode_ci,
  `customer_info` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `feedback_responses_tenant_id_foreign` (`tenant_id`),
  KEY `feedback_responses_qr_code_id_foreign` (`qr_code_id`),
  CONSTRAINT `feedback_responses_qr_code_id_foreign` FOREIGN KEY (`qr_code_id`) REFERENCES `qr_codes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `feedback_responses_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");
