<?php

use App\Models\FeedbackResponse;
use Illuminate\Support\Str;
use Stancl\Tenancy\Middleware\InitializeTenancyBySession;
use Illuminate\Support\Facades\DB;

test('feedback page loads with valid uuid', function () {
    // Setup data using DB Facade
    $tenantId = 'feedback_tenant_1';

    // DB::table usage with proper timestamps to match schema expectations
    DB::table('tenants')->insert([
        'id' => $tenantId,
        'data' => '{}',
        'created_at' => now()->toDateTimeString(),
        'updated_at' => now()->toDateTimeString()
    ]);

    DB::table('restaurants')->insert([
        'tenant_id' => $tenantId,
        'name' => 'F Resto',
        'created_at' => now()->toDateTimeString(),
        'updated_at' => now()->toDateTimeString()
    ]);

    $qId = 100;
    DB::table('questionnaires')->insert([
        'id' => $qId,
        'tenant_id' => $tenantId,
        'title' => 'Feedback Q',
        'questions' => json_encode([]),
        'is_active' => true,
        'created_at' => now()->toDateTimeString(),
        'updated_at' => now()->toDateTimeString()
    ]);

    $uuid = (string) Str::uuid();
    DB::table('qr_codes')->insert([
        'tenant_id' => $tenantId,
        'questionnaire_id' => $qId,
        'name' => 'Table 1',
        'unique_code' => $uuid,
        'image_path' => 'path/to/qr.png',
        'is_active' => true,
        'created_at' => now()->toDateTimeString(),
        'updated_at' => now()->toDateTimeString()
    ]);

    $response = $this
        ->withoutMiddleware(InitializeTenancyBySession::class)
        ->get(route('feedback.show', $uuid));

    $response->assertOk();
    $response->assertSee('Feedback Q');
    $response->assertSee('Kirim Masukan');
});

test('feedback page 404 with invalid uuid', function () {
    $response = $this->get(route('feedback.show', 'invalid-uuid'));
    $response->assertNotFound();
});

test('feedback submission stores json correctly', function () {
    $tenantId = 'feedback_tenant_2';

    DB::table('tenants')->insert([
        'id' => $tenantId,
        'data' => '{}',
        'created_at' => now()->toDateTimeString(),
        'updated_at' => now()->toDateTimeString()
    ]);

    $qId = 101;
    DB::table('questionnaires')->insert([
        'id' => $qId,
        'tenant_id' => $tenantId,
        'title' => 'Feedback Q',
        'questions' => json_encode([
            ['id' => 'q1', 'text' => 'Rate?', 'type' => 'rating', 'required' => true]
        ]),
        'is_active' => true,
        'created_at' => now()->toDateTimeString(),
        'updated_at' => now()->toDateTimeString()
    ]);

    $uuid = (string) Str::uuid();
    DB::table('qr_codes')->insert([
        'tenant_id' => $tenantId,
        'questionnaire_id' => $qId,
        'name' => 'Table 1',
        'unique_code' => $uuid,
        'image_path' => 'path/to/qr.png',
        'is_active' => true,
        'created_at' => now()->toDateTimeString(),
        'updated_at' => now()->toDateTimeString()
    ]);

    $response = $this
        ->withoutMiddleware(InitializeTenancyBySession::class)
        ->post(route('feedback.store', $uuid), [
            'ratings' => ['q1' => '5'],
            'feedback_text' => 'Great!',
        ]);

    $response->assertRedirect(route('feedback.thank-you'));

    $feedback = DB::table('feedback_responses')->first();
    expect($feedback)->not->toBeNull();
    expect($feedback->tenant_id)->toBe($tenantId);
    expect($feedback->feedback_text)->toBe('Great!');
});
