<?php

/**
 * cPanel Requirement Check Script
 * Run this on the server to verify PHP extensions and Environment.
 */

$requirements = [
    'bcmath',
    'ctype',
    'json',
    'mbstring',
    'openssl',
    'pdo',
    'tokenizer',
    'xml',
    'curl',
    'fileinfo',
];

echo "Checking Requirements for Ulasis v2:\n";
echo "------------------------------------\n";
echo "PHP Version: " . phpversion() . "\n";

$hasErrors = false;

foreach ($requirements as $ext) {
    if (extension_loaded($ext)) {
        echo "✅ $ext: Installed\n";
    } else {
        echo "❌ $ext: MISSING\n";
        $hasErrors = true;
    }
}

echo "------------------------------------\n";

if ($hasErrors) {
    echo "⚠️  Some requirements are missing. Please enable them in cPanel PHP Selector.\n";
    exit(1);
} else {
    echo "✅  All extensions ready. Proceed with deployment.\n";
    exit(0);
}
