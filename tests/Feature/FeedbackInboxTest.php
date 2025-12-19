<?php

use App\Models\FeedbackResponse;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Stancl\Tenancy\Middleware\InitializeTenancyBySession;

test('admin can view feedback inbox', function () {
    $tenantId = 'admin_tenant';

    // Setup using DB to avoid model/tenancy crashes
    DB::table('tenants')->insert([
        'id' => $tenantId,
        'data' => '{}',
        'created_at' => now(),
        'updated_at' => now()
    ]);

    DB::table('users')->insert([
        'name' => 'Admin',
        'email' => 'admin@test.com',
        'password' => 'password',
        'created_at' => now(),
        'updated_at' => now()
    ]);

    $user = User::where('email', 'admin@test.com')->first();

    // Initialize Tenancy Manually for Scope to work
    $tenant = \App\Models\Tenant::find($tenantId);
    tenancy()->initialize($tenant);

    $qId = 1;
    DB::table('questionnaires')->insert([
        'id' => $qId,
        'tenant_id' => $tenantId,
        'title' => 'Q',
        'questions' => '{}',
        'is_active' => 1,
        'created_at' => now(),
        'updated_at' => now()
    ]);

    $uuid = (string) Str::uuid();
    DB::table('qr_codes')->insert([
        'id' => 1,
        'tenant_id' => $tenantId,
        'questionnaire_id' => $qId,
        'unique_code' => $uuid,
        'name' => 'Test QR',
        'is_active' => 1,
        'created_at' => now(),
        'updated_at' => now()
    ]);

    DB::table('feedback_responses')->insert([
        'tenant_id' => $tenantId,
        'qr_code_id' => 1,
        'ratings' => json_encode(['q1' => 5]),
        'feedback_text' => 'Visible Feedback',
        'status' => 'unread',
        'created_at' => now(),
        'updated_at' => now()
    ]);

    $response = $this->actingAs($user)
        ->get(route('feedback-inbox.index'));

    $response->assertOk();
    $response->assertSee('Visible Feedback');
    $response->assertSee('Test QR');
});

test('admin cannot see other tenants feedback', function () {
    $tenantId1 = 'tenant_1';
    $tenantId2 = 'tenant_2';

    DB::table('tenants')->insert([['id' => $tenantId1, 'data' => '{}', 'created_at' => now(), 'updated_at' => now()], ['id' => $tenantId2, 'data' => '{}', 'created_at' => now(), 'updated_at' => now()]]);

    DB::table('users')->insert([
        'name' => 'Admin',
        'email' => 'admin2@test.com',
        'password' => 'password',
        'created_at' => now(),
        'updated_at' => now()
    ]);
    $user = User::where('email', 'admin2@test.com')->first();

    // Feedback for Tenant 2
    DB::table('qr_codes')->insert([
        'id' => 2,
        'tenant_id' => $tenantId2,
        'questionnaire_id' => 1,
        'unique_code' => (string) Str::uuid(),
        'name' => 'Other QR',
        'is_active' => 1,
        'created_at' => now(),
        'updated_at' => now()
    ]);
    // Need Q for T2
    DB::table('questionnaires')->insert([
        'id' => 2,
        'tenant_id' => $tenantId2,
        'title' => 'Q2',
        'questions' => '{}',
        'is_active' => 1,
        'created_at' => now(),
        'updated_at' => now()
    ]);

    DB::table('feedback_responses')->insert([
        'tenant_id' => $tenantId2,
        'qr_code_id' => 2,
        'ratings' => json_encode(['q1' => 1]),
        'feedback_text' => 'Hidden Feedback',
        'status' => 'unread',
        'created_at' => now(),
        'updated_at' => now()
    ]);

    // Switch to Tenant 1
    $tenant = \App\Models\Tenant::find($tenantId1);
    tenancy()->initialize($tenant);

    tenancy()->initialize($tenant);

    $response = $this->actingAs($user)
        ->withoutExceptionHandling()
        ->get(route('feedback-inbox.index'));

    $response->assertOk();
    $response->assertDontSee('Hidden Feedback');
});
