<?php

use Illuminate\Support\Facades\App;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Verifying Development Tools...\n";

// Check Debugbar
$debugbarInstalled = class_exists(\Barryvdh\Debugbar\ServiceProvider::class);
$debugbarEnabled = config('debugbar.enabled');

echo "Debugbar Installed: " . ($debugbarInstalled ? "YES" : "NO") . "\n";

// Check IDE Helper
$ideHelperInstalled = class_exists(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
echo "IDE Helper Installed: " . ($ideHelperInstalled ? "YES" : "NO") . "\n";

// Check Environment
echo "Environment: " . App::environment() . "\n";
echo "Debug Mode: " . (config('app.debug') ? "YES" : "NO") . "\n";

if ($debugbarInstalled && $ideHelperInstalled) {
    echo "SUCCESS: Dev tools verified.\n";
    exit(0);
} else {
    echo "FAILURE: Missing tools.\n";
    exit(1);
}
