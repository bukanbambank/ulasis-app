<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_list_users()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        User::factory()->count(3)->create();

        $response = $this->actingAs($admin)->get(route('admin.users.index'));

        $response->assertStatus(200);
        $response->assertViewHas('users');
    }

    public function test_admin_can_suspend_user()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $user = User::factory()->create(['status' => 'active']);

        $response = $this->actingAs($admin)->post(route('admin.users.suspend', $user));

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'status' => 'suspended',
        ]);

        $this->assertDatabaseHas('audit_logs', [
            'admin_id' => $admin->id,
            'action' => 'suspend_user',
            'target_id' => $user->id,
        ]);
    }

    public function test_admin_cannot_suspend_themselves()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->post(route('admin.users.suspend', $admin));

        $response->assertRedirect(); // Back with error
        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
            'status' => 'active', // Unchanged
        ]);
    }
}
