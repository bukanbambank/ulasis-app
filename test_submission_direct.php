<?php
// Load Laravel
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Http\Request;
use App\Http\Controllers\FeedbackController;
use Illuminate\Support\Facades\DB;

// 1. Get the QR Code UUID we created
// UUID from E2E: 10dc8233-ab44-423c-acf7-4cb403798d09
$uuid = '10dc8233-ab44-423c-acf7-4cb403798d09';

echo "Testing Submission for UUID: $uuid\n";

// 2. Fetch QR to ensure it exists
$qr = DB::table('qr_codes')->where('unique_code', $uuid)->first();
if (!$qr) {
    die("QR Code not found!\n");
}
echo "QR Found. Questionnaire ID: {$qr->questionnaire_id}\n";

// 3. Prepare Request
$data = [
    'ratings' => [
        'q1_mock_id' => 5, // Mock IDs, assuming controller just stores the array
        'q2_mock_id' => 5,
    ],
    'feedback_text' => 'Direct Backend Injection Test via Script.',
];

$request = Request::create("/feedback/$uuid", 'POST', $data);

// 4. Instantiate Controller
$controller = new FeedbackController();

try {
    // 5. Call Store
    $response = $controller->store($request, $uuid);

    echo "Status Code: " . $response->getStatusCode() . "\n";
    if ($response->isRedirect()) {
        echo "Redirect Target: " . $response->getTargetUrl() . "\n";
        echo "SUCCESS: Feedback Submitted.\n";
    } else {
        echo "Response Content: " . $response->getContent() . "\n";
    }

} catch (\Illuminate\Validation\ValidationException $e) {
    echo "Validation Error: " . print_r($e->errors(), true) . "\n";
} catch (Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
