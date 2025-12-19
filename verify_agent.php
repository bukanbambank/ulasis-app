<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $email = 'strong_agent@ulasis.site';
    $updated = \App\Models\User::where('email', $email)->update(['email_verified_at' => now(), 'tenant_id' => null, 'status' => 'active']);
    echo "Updated: " . $updated . "\n";
    if ($updated == 0) {
        // Fallback create
        $u = new \App\Models\User();
        $u->name = 'Strong Agent';
        $u->email = $email;
        $u->password = \Illuminate\Support\Facades\Hash::make('Password123!');
        $u->email_verified_at = now();
        $u->save();
        echo "Created: " . $u->id . "\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
