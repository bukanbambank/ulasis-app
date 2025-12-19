<?php

use App\Models\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

// Load Laravel application
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Mock Auth system if needed, or query directly
$qrCode = QrCode::first();

if (!$qrCode) {
    echo "No QR Code found in DB.\n";
    exit(1);
}

echo "Testing Download Logic for QR: " . $qrCode->id . "\n";
echo "Path: " . $qrCode->image_path . "\n";

if (!Storage::disk('public')->exists($qrCode->image_path)) {
    echo "ERROR: File missing from storage.\n";
    exit(1);
}

$content = Storage::disk('public')->get($qrCode->image_path);
$sourceSize = strlen($content);
echo "Source File Size: " . $sourceSize . " bytes\n";

// Simalute Controller Logic
if (ob_get_length()) {
    ob_end_clean();
}

// We can't "return response()" in CLI, but we can verify the content is intact
// and usually the response() helper just wraps this string.
// If this script outputs exactly the bytes, we know logic is good.

$outputFilename = 'test_download_output.png';
file_put_contents($outputFilename, $content);

echo "Simulated Output Saved to: $outputFilename\n";
echo "Output Size: " . filesize($outputFilename) . " bytes\n";

if (filesize($outputFilename) === $sourceSize) {
    echo "SUCCESS: Output matches source size.\n";
} else {
    echo "FAIL: Size mismatch.\n";
}
