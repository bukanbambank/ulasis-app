<?php
if (!file_exists(__DIR__ . '/routes/auth.php')) {
    echo "FAIL: routes/auth.php missing\n";
    exit(1);
}
$composer = json_decode(file_get_contents(__DIR__ . '/composer.json'), true);
if (!isset($composer['require-dev']['laravel/breeze'])) {
    echo "FAIL: laravel/breeze not required\n";
    exit(1);
}
echo "PASS: Breeze installed\n";
exit(0);