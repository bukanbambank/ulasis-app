<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Auth;

// 1. Simulate Login to get Session
// Since we are CLI, we can't easily get a session cookie for Curl without full browser emulation or using Laravel constraints.
// But we can invoke the controller DIRECTLY and capture output!

$qr = \App\Models\QrCode::find(1);
if (!$qr) {
    die("QR 1 not found");
}

// Mock Auth
Auth::loginUsingId(2); // strong_agent

echo "User: " . Auth::user()->email . "\n";
echo "Tenant: " . Auth::user()->tenant_id . "\n";
echo "QR Tenant: " . $qr->tenant_id . "\n";

// Capture Output
ob_start();
try {
    $controller = new \App\Http\Controllers\QrCodeController();
    $response = $controller->download($qr);

    // If it returns a BinaryFileResponse or Response, we can inspect it.
    if ($response instanceof \Symfony\Component\HttpFoundation\BinaryFileResponse) {
        echo "Type: BinaryFileResponse\n";
        echo "File: " . $response->getFile()->getPathname() . "\n";
    } elseif ($response instanceof \Illuminate\Http\Response) {
        echo "Type: Response\n";
        echo "Content Length: " . strlen($response->getContent()) . "\n";
        echo "Content Snippet (Hex): " . bin2hex(substr($response->getContent(), 0, 50)) . "\n";

        echo "Headers:\n";
        foreach ($response->headers->all() as $k => $v) {
            echo "$k: " . implode(', ', $v) . "\n";
        }
    } else {
        echo "Type: " . get_class($response) . "\n";
        echo "Content: " . $response->getContent(); // For StreamedResponse
    }

} catch (\Exception $e) {
    echo "Exception: " . $e->getMessage();
}
$output = ob_get_clean();
echo $output;
