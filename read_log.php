<?php
$logFiles = glob(__DIR__ . '/storage/logs/laravel.log');
foreach ($logFiles as $logFile) {
    echo "Log: $logFile\n";
    if (file_exists($logFile)) {
        echo file_get_contents($logFile);
    }
}
