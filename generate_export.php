<?php

use App\Exports\FeedbackExport;
use Maatwebsite\Excel\Facades\Excel;

// Load Laravel application
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Use a known existing Tenant ID for testing
// admin-system-2024 is what we saw in debug output earlier
$tenantId = 'admin-system-2024';
$range = 30;
$fileName = 'manual_export_verified.xlsx';

echo "Generating Export for $tenantId...\n";

try {
    // Save to 'public' disk -> storage/app/public/
    Excel::store(new FeedbackExport($tenantId, $range), $fileName, 'public');
    echo "SUCCESS: Created $fileName\n";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
