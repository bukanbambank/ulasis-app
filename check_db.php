<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "DB Connection: " . config('database.default') . "\n";
try {
    echo "User Count: " . \App\Models\User::count() . "\n";
    $users = \App\Models\User::all();
    foreach ($users as $u) {
        echo " - " . $u->email . " (ID: " . $u->id . ")\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
