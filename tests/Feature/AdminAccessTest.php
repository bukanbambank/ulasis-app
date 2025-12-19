<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Create manual tenant if needed, or just rely on default if tenancy not enforced on admin routes specifically
        // But our User model has tenant_id.
    }

    public function test_non_admin_cannot_access_admin_dashboard()
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->get(route('admin.dashboard'));

        $response->assertStatus(403);
    }

    public function test_admin_can_access_admin_dashboard()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
    }

    public function test_suspended_user_is_logged_out()
    {
        $user = User::factory()->create(['status' => 'suspended']);

        // Attempt to access a protected route (even a regular one)
        $response = $this->actingAs($user)->get(route('dashboard'));

        // Middleware should log them out and redirect to login
        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }
}
