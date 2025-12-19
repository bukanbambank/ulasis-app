<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\QrCode;
use Illuminate\Support\Facades\Storage;

echo "--- QR Code Diagnostic ---\n";
echo "Scanning Database...\n";

$qrs = QrCode::all();

if ($qrs->isEmpty()) {
    echo "No QR Codes found in database.\n";
    exit;
}

foreach ($qrs as $qr) {
    echo "\nID: {$qr->id}\n";
    echo "Name: {$qr->name}\n";
    echo "Stored Path: {$qr->image_path}\n";

    // Check Storage
    $exists = Storage::disk('public')->exists($qr->image_path);
    echo "File Exists (Storage Disk): " . ($exists ? "YES" : "NO") . "\n";

    if ($exists) {
        $path = Storage::disk('public')->path($qr->image_path);
        echo "Absolute Path: $path\n";
        echo "File Size: " . filesize($path) . " bytes\n";

        // Peek content to check if valid PNG
        $head = file_get_contents($path, false, null, 0, 4);
        echo "Header Hex: " . bin2hex($head) . "\n";
        if (substr($head, 1, 3) === 'PNG') {
            echo "Status: VALID PNG Header.\n";
        } else {
            echo "Status: INVALID/CORRUPT Header.\n";
        }
    } else {
        echo "Status: MISSING FILE.\n";
    }
}
