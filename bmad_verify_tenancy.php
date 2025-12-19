<?php
$composer = json_decode(file_get_contents(__DIR__ . '/composer.json'), true);
if (isset($composer['require']['stancl/tenancy'])) {
    echo "FAIL: stancl/tenancy already installed\n";
    exit(1);
}
if (file_exists(__DIR__ . '/config/tenancy.php')) {
    echo "FAIL: configuration file exists\n";
    exit(1);
}
echo "PASS: Tenancy not installed (Red Phase)\n";
exit(0);
