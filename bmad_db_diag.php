<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

echo "Checking Tables:\n";
$tables = ['tenants', 'users', 'restaurants', 'questionnaires', 'qr_codes', 'feedback_responses'];
foreach ($tables as $table) {
    echo "$table: " . (Schema::hasTable($table) ? "EXISTS" : "MISSING") . "\n";
}

echo "\nChecking Migrations Table:\n";
$migrations = DB::table('migrations')->get();
foreach ($migrations as $m) {
    echo "{$m->migration} (Batch {$m->batch})\n";
}
