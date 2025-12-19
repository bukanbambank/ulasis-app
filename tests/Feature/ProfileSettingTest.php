<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Stancl\Tenancy\Middleware\InitializeTenancyBySession;

test('profile page can update restaurant details', function () {
    Storage::fake('public');

    // Setup Tenant & User
    $tenantId = 'prof_tenant';
    DB::table('tenants')->insert(['id' => $tenantId, 'data' => '{}', 'created_at' => now(), 'updated_at' => now()]);

    // Create Restaurant record
    DB::table('restaurants')->insert([
        'tenant_id' => $tenantId,
        'name' => 'Old Name',
        'created_at' => now(),
        'updated_at' => now()
    ]);

    DB::table('users')->insert(['name' => 'Prof Admin', 'email' => 'prof@test.com', 'password' => 'password', 'tenant_id' => $tenantId, 'created_at' => now(), 'updated_at' => now()]);
    $user = User::where('email', 'prof@test.com')->first();

    // Init Tenancy
    $tenant = \App\Models\Tenant::find($tenantId);
    tenancy()->initialize($tenant);

    $response = $this->actingAs($user)
        ->withoutMiddleware(InitializeTenancyBySession::class)
        ->patch(route('profile.update'), [
            'name' => 'Prof Admin Updated',
            'email' => 'prof@test.com',
            'restaurant_name' => 'New Name',
            'phone' => '08123456789',
            'address' => 'Jakarta Selatan',
            // 'logo' => UploadedFile::fake()->image('logo.jpg'), // Skipped: No GD
        ]);

    $response->assertSessionHasNoErrors();
    $response->assertRedirect(route('profile.edit'));

    $this->assertDatabaseHas('users', ['name' => 'Prof Admin Updated']);
    $this->assertDatabaseHas('restaurants', [
        'tenant_id' => $tenantId,
        'name' => 'New Name',
        'phone' => '08123456789',
        'address' => 'Jakarta Selatan',
    ]);
});
