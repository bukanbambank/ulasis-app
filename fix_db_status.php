<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "Adding status column...\n";
    DB::statement("ALTER TABLE feedback_responses ADD COLUMN status VARCHAR(255) DEFAULT 'unread' AFTER customer_info");
    echo "Success.\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
