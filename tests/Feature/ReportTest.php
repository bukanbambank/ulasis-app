<?php

use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use App\Exports\FeedbackExport;
use Illuminate\Support\Facades\DB;
use Stancl\Tenancy\Middleware\InitializeTenancyBySession;

test('admin can export feedback', function () {
    Excel::fake();

    // Setup Tenant & User
    $tenantId = 'report_tenant';
    DB::table('tenants')->insert(['id' => $tenantId, 'data' => '{}', 'created_at' => now(), 'updated_at' => now()]);
    DB::table('users')->insert(['name' => 'Report Admin', 'email' => 'rep@test.com', 'password' => 'password', 'created_at' => now(), 'updated_at' => now()]);
    $user = User::where('email', 'rep@test.com')->first();

    // Init Tenancy (Required for Controller `tenancy()->tenant->id`)
    $tenant = \App\Models\Tenant::find($tenantId);
    tenancy()->initialize($tenant);

    // Auth & Request
    $response = $this->actingAs($user)
        ->withoutMiddleware(InitializeTenancyBySession::class)
        ->post(route('reports.export'), [
            'range' => '30',
            'format' => 'xlsx',
        ]);

    $response->assertOk(); // Excel download returns binary

    Excel::assertDownloaded('feedback_' . now()->format('Ymd_His') . '.xlsx', function (FeedbackExport $export) {
        return true;
    });
});
