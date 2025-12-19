<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $u = \App\Models\User::firstOrNew(['email' => 'prod_test@ulasis.site']);
    $u->name = 'Prod Tester';
    $u->password = \Illuminate\Support\Facades\Hash::make('password');
    $u->email_verified_at = now();
    $u->tenant_id = null;
    $u->save();
    echo "RESET_SUCCESS\n";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
