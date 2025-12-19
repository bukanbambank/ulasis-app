<?php
$envFile = __DIR__ . '/.env';
$content = file_get_contents($envFile);
$password = '^.!y?*D$}L-.uRLF.';
$content = preg_replace('/^DB_PASSWORD=.*/m', 'DB_PASSWORD="' . $password . '"', $content);
file_put_contents($envFile, $content);
echo "Password updated.\n";
