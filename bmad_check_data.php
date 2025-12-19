<?php
// bmad_check_data.php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Check Tenant
$tenantId = 'admin-system-2024'; // Found in previous debug output
echo "Checking Data for Tenant: $tenantId\n";

$qrCount = \App\Models\QrCode::where('tenant_id', $tenantId)->count();
echo "QR Codes: $qrCount\n";

$feedbackCount = \App\Models\FeedbackResponse::where('tenant_id', $tenantId)->count();
echo "Feedback Responses: $feedbackCount\n";

if ($feedbackCount > 0) {
    $first = \App\Models\FeedbackResponse::where('tenant_id', $tenantId)->first();
    echo "First Feedback Date: " . $first->created_at . "\n";
}
