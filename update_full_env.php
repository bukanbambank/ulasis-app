<?php
$envFile = __DIR__ . '/.env';
$content = file_get_contents($envFile);

$updates = [
    'DB_CONNECTION' => 'mysql',
    'DB_HOST' => 'localhost',
    'DB_PORT' => '3306',
    'DB_DATABASE' => 'admininf_ulasis-fresh-1',
    'DB_USERNAME' => 'admininf_ulasis',
    'DB_PASSWORD' => '7b@nXTeu~0,5-sG#'
];

foreach ($updates as $key => $value) {
    $safeValue = '"' . str_replace('"', '\"', $value) . '"';
    $pattern = "/^$key=.*/m";
    if (preg_match($pattern, $content)) {
        $content = preg_replace($pattern, "$key=$safeValue", $content);
    } else {
        $content .= "\n$key=$safeValue";
    }
}

file_put_contents($envFile, $content);
echo "Environment updated successfully.\n";
