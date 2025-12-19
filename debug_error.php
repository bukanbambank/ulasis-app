<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $tables = \Illuminate\Support\Facades\DB::select("SELECT name FROM sqlite_master WHERE type='table';");
    echo "Tables: " . count($tables) . "\n";
    foreach ($tables as $t) {
        echo $t->name . ", ";
    }
    echo "\n";

    echo "Attempting Insert...\n";
    $u = new \App\Models\User();
    $u->name = 'Test';
    $u->email = 'test_' . rand(1, 999) . '@example.com';
    $u->password = 'password';
    $u->tenant_id = null;
    $u->save();
    echo "Success!\n";
} catch (\Exception $e) {
    echo "FULL ERROR: " . $e->getMessage() . "\n";
}
