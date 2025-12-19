<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "DB Connection: " . config('database.default') . "\n";
echo "DB Path: " . database_path('database.sqlite') . "\n";

try {
    echo "Creating User...\n";
    $u = new \App\Models\User();
    $u->name = 'Prod Tester';
    $u->email = 'prod_test@ulasis.site'; // Try insert directly
    $u->password = \Illuminate\Support\Facades\Hash::make('password');
    $u->tenant_id = null;
    $u->save();
    echo "User Created. ID: " . $u->id . "\n";
} catch (\Exception $e) {
    echo "Create Error: " . $e->getMessage() . "\n";
}

echo "Final Count: " . \App\Models\User::count() . "\n";
