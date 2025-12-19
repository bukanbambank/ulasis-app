<?php

namespace Tests\Feature\Tenancy;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IsolationTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_are_scoped_to_current_tenant()
    {
        // 1. Create Tenants
        $tenantA = Tenant::create(['id' => 'tenant-a']);
        $tenantB = Tenant::create(['id' => 'tenant-b']);

        // 2. Create Users
        $userA = User::create([
            'name' => 'User A',
            'email' => 'a@example.com',
            'password' => 'password',
            'tenant_id' => $tenantA->id,
        ]);

        $userB = User::create([
            'name' => 'User B',
            'email' => 'b@example.com',
            'password' => 'password',
            'tenant_id' => $tenantB->id,
        ]);

        // 3. Initialize Tenant A
        tenancy()->initialize($tenantA);

        // 4. Verification: Should only see User A
        $this->assertTrue(User::where('email', 'a@example.com')->exists(), 'Tenant A should see User A');
        $this->assertFalse(User::where('email', 'b@example.com')->exists(), 'Tenant A should NOT see User B');
        $this->assertEquals(1, User::count(), 'Tenant A should see exactly 1 user');

        // 5. Initialize Tenant B
        tenancy()->end(); // Clean up first
        tenancy()->initialize($tenantB);

        // 6. Verification: Should only see User B
        $this->assertTrue(User::where('email', 'b@example.com')->exists(), 'Tenant B should see User B');
        $this->assertFalse(User::where('email', 'a@example.com')->exists(), 'Tenant B should NOT see User A');
        $this->assertEquals(1, User::count(), 'Tenant B should see exactly 1 user');
    }
}
