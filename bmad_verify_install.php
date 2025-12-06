<?php
if (!file_exists(__DIR__ . '/artisan')) {
    echo "FAIL: artisan not found\n";
    exit(1);
}
if (!file_exists(__DIR__ . '/composer.json')) {
    echo "FAIL: composer.json not found\n";
    exit(1);
}
$composer = json_decode(file_get_contents(__DIR__ . '/composer.json'), true);
if (!isset($composer['require']['laravel/framework'])) {
    echo "FAIL: laravel/framework not required\n";
    exit(1);
}
echo "PASS: Laravel installed\n";
exit(0);
