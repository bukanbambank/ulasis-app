<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=ulasis_fresh_1', 'root', '');
    echo "Database Connection Successful";
} catch (PDOException $e) {
    echo "Database Connection Failed: " . $e->getMessage();
}
