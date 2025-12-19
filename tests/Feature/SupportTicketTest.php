<?php

use App\Models\User;
use App\Models\SupportTicket;
use Illuminate\Support\Facades\DB;
use Stancl\Tenancy\Middleware\InitializeTenancyBySession;

test('user can submit support ticket', function () {
    // Setup Tenant & User
    $tenantId = 'supp_tenant';
    DB::table('tenants')->insert(['id' => $tenantId, 'data' => '{}', 'created_at' => now(), 'updated_at' => now()]);
    DB::table('users')->insert(['name' => 'supp Admin', 'email' => 'supp@test.com', 'password' => 'password', 'tenant_id' => $tenantId, 'created_at' => now(), 'updated_at' => now()]);
    $user = User::where('email', 'supp@test.com')->first();

    // Init Tenancy
    $tenant = \App\Models\Tenant::find($tenantId);
    tenancy()->initialize($tenant);

    $response = $this->actingAs($user)
        ->withoutMiddleware(InitializeTenancyBySession::class)
        ->post(route('support.store'), [
            'subject' => 'Help me',
            'message' => 'I found a bug',
        ]);

    $response->assertRedirect(route('support.index'));

    $this->assertDatabaseHas('support_tickets', [
        'tenant_id' => $tenantId,
        'subject' => 'Help me',
        'message' => 'I found a bug',
        'status' => 'open',
    ]);
});

test('user can view support tickets', function () {
    // Setup Tenant & User
    $tenantId = 'view_tenant';
    DB::table('tenants')->insert(['id' => $tenantId, 'data' => '{}', 'created_at' => now(), 'updated_at' => now()]);
    DB::table('users')->insert(['name' => 'view Admin', 'email' => 'view@test.com', 'password' => 'password', 'tenant_id' => $tenantId, 'created_at' => now(), 'updated_at' => now()]);
    $user = User::where('email', 'view@test.com')->first();

    // Init Tenancy
    $tenant = \App\Models\Tenant::find($tenantId);
    tenancy()->initialize($tenant);

    // Create Ticket
    DB::table('support_tickets')->insert([
        'tenant_id' => $tenantId,
        'user_id' => $user->id,
        'subject' => 'Existing Ticket',
        'message' => 'Test',
        'status' => 'open',
        'created_at' => now(),
        'updated_at' => now()
    ]);

    $response = $this->actingAs($user)
        ->withoutMiddleware(InitializeTenancyBySession::class)
        ->get(route('support.index'));

    $response->assertOk();
    $response->assertSee('Existing Ticket');
});
