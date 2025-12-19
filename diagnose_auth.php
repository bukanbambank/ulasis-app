<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$email = 'prod_test@ulasis.site';
$password = 'password';

$user = \App\Models\User::where('email', $email)->first();

echo "User Found: " . ($user ? "YES" : "NO") . "\n";
if ($user) {
    echo "ID: " . $user->id . "\n";
    echo "Email: " . $user->email . "\n";
    echo "Hash: " . substr($user->password, 0, 10) . "...\n";
    $check = \Illuminate\Support\Facades\Hash::check($password, $user->password);
    echo "Hash Check ('$password'): " . ($check ? "PASS" : "FAIL") . "\n";

    // Test re-hashing
    $newHash = \Illuminate\Support\Facades\Hash::make($password);
    echo "New Hash Generation: " . substr($newHash, 0, 10) . "...\n";
}
