<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

$cols = DB::select('SHOW COLUMNS FROM feedback_responses');
foreach ($cols as $c) {
    echo $c->Field . " | " . $c->Type . " | Null:" . $c->Null . " | Default:" . $c->Default . "\n";
}
