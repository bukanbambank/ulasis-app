<?php

use App\Models\QrCode;
use App\Models\Questionnaire;
use App\Models\Restaurant;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Stancl\Tenancy\Facades\Tenancy;
use Stancl\Tenancy\Middleware\InitializeTenancyBySession;

test('qr code creation page is displayed', function () {
    $tenant = Tenant::create(['id' => 'qr_tenant_1']);
    Tenancy::initialize($tenant);
    $restaurant = Restaurant::create(['tenant_id' => $tenant->id, 'name' => ' QR Resto']);
    $user = User::factory()->create(['tenant_id' => $tenant->id]);

    $response = $this
        ->withoutMiddleware(InitializeTenancyBySession::class)
        ->actingAs($user)
        ->get(route('qr-codes.create'));

    $response->assertOk();
    $response->assertSee('Generate QR Code');
});

test('qr code can be generated', function () {
    Storage::fake('public');

    $tenant = Tenant::create(['id' => 'qr_tenant_2']);
    Tenancy::initialize($tenant);
    $restaurant = Restaurant::create(['tenant_id' => $tenant->id, 'name' => 'QR Resto']);
    $user = User::factory()->create(['tenant_id' => $tenant->id]);

    $questionnaire = Questionnaire::factory()->create([
        'tenant_id' => $tenant->id,
        'title' => 'Test Q'
    ]);

    $response = $this
        ->withoutMiddleware(InitializeTenancyBySession::class)
        ->actingAs($user)
        ->post(route('qr-codes.store'), [
            'name' => 'Table 1',
            'questionnaire_id' => $questionnaire->id,
        ]);

    $response->assertRedirect(route('qr-codes.index'));

    $qrCode = QrCode::first();
    $this->assertNotNull($qrCode);
    $this->assertEquals('Table 1', $qrCode->name);
    $this->assertNotNull($qrCode->unique_code);

    // Check file exists
    Storage::disk('public')->assertExists($qrCode->image_path);
});

test('qr code can be downloaded', function () {
    Storage::fake('public');

    // 1. Setup Tenant and User
    $tenant = Tenant::create(['id' => 'qr_tenant_3']);
    Tenancy::initialize($tenant);
    $restaurant = Restaurant::create(['tenant_id' => $tenant->id, 'name' => 'QR Resto']);
    $user = User::factory()->create(['tenant_id' => $tenant->id]);

    $questionnaire = Questionnaire::factory()->create([
        'tenant_id' => $tenant->id,
        'restaurant_id' => $restaurant->id,
    ]);

    $qrCode = QrCode::create([
        'tenant_id' => $tenant->id,
        'questionnaire_id' => $questionnaire->id,
        'name' => 'Table 1',
        'unique_code' => 'uuid-123',
        'image_path' => 'qr-codes/' . $tenant->id . '/uuid-123.png',
        'is_active' => true
    ]);

    // Create dummy file
    Storage::disk('public')->put($qrCode->image_path, 'dummy content');

    $response = $this
        ->withoutMiddleware(InitializeTenancyBySession::class)
        ->actingAs($user)
        ->get(route('qr-codes.download', $qrCode->id));

    $response->assertOk();
    $response->assertHeader('content-disposition', 'attachment; filename=Table 1.png');
});

test('qr code list is displayed', function () {
    $tenant = Tenant::create(['id' => 'qr_tenant_4']);
    Tenancy::initialize($tenant);
    $restaurant = Restaurant::create(['tenant_id' => $tenant->id, 'name' => 'QR Resto']);
    $user = User::factory()->create(['tenant_id' => $tenant->id]);

    $response = $this
        ->withoutMiddleware(InitializeTenancyBySession::class)
        ->actingAs($user)
        ->get(route('qr-codes.index'));

    $response->assertOk();
    $response->assertSee('My QR Codes');
});
