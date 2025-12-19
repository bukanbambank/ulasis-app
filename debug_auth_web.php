<?php
// Place this in public/debug_auth.php to be accessible via browser
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';

$app->make(\Illuminate\Contracts\Http\Kernel::class)
    ->handle(\Illuminate\Http\Request::capture());

use Illuminate\Support\Facades\Auth;

echo "<h1>Auth Debug</h1>";
if (Auth::check()) {
    echo "User: " . Auth::user()->email . "<br>";
    echo "Tenant ID: " . Auth::user()->tenant_id . "<br>";

    $fqs = \App\Models\FeedbackResponse::withoutGlobalScopes()->where('tenant_id', Auth::user()->tenant_id)->get();
    echo "Feedbacks (Raw Query): " . $fqs->count() . "<br>";
} else {
    echo "Not Logged In.";
}
