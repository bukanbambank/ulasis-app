<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\SupportTicket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSupportTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_tickets()
    {
        $tenant = \App\Models\Tenant::create(['id' => 'test-tenant', 'name' => 'Test Tenant']);
        $admin = User::factory()->create(['is_admin' => true]);

        SupportTicket::create([
            'tenant_id' => $tenant->id,
            'user_id' => User::factory()->create(['tenant_id' => $tenant->id])->id,
            'subject' => 'Test Ticket',
            'message' => 'Help me',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.support.index'));

        $response->assertStatus(200);
        $response->assertSee('Test Ticket');
    }

    public function test_admin_can_reply_to_ticket()
    {
        $tenant = \App\Models\Tenant::create(['id' => 'test-tenant', 'name' => 'Test Tenant']);
        $admin = User::factory()->create(['is_admin' => true]);
        $ticket = SupportTicket::create([
            'tenant_id' => $tenant->id,
            'user_id' => User::factory()->create(['tenant_id' => $tenant->id])->id,
            'subject' => 'Test Ticket',
            'message' => 'Help me',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.support.reply', $ticket), [
            'message' => 'This is a reply',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('support_ticket_replies', [
            'support_ticket_id' => $ticket->id,
            'user_id' => $admin->id,
            'message' => 'This is a reply',
        ]);

        // Ticket status should change to in_progress (logic I added)
        $this->assertDatabaseHas('support_tickets', [
            'id' => $ticket->id,
            'status' => 'in_progress',
        ]);
    }
}
