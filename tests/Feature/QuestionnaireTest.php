<?php

use App\Models\Questionnaire;
use App\Models\Restaurant;
use App\Models\Tenant;
use App\Models\User;
use Stancl\Tenancy\Facades\Tenancy;
use Stancl\Tenancy\Middleware\InitializeTenancyBySession;

test('questionnaire creation page is displayed with templates', function () {
    $tenant = Tenant::create(['id' => 'test_tenant_1']);
    Tenancy::initialize($tenant);
    $restaurant = Restaurant::create(['tenant_id' => $tenant->id, 'name' => 'Test Restaurant']);
    $user = User::factory()->create(['tenant_id' => $tenant->id]);

    $response = $this
        ->actingAs($user)
        ->get('/questionnaires/create');

    $response->assertOk();
    $response->assertSee('Select a Template');
    $response->assertSee('Casual Dining');
});

test('questionnaire can be created from template', function () {
    $tenant = Tenant::create(['id' => 'test_tenant_2']);
    Tenancy::initialize($tenant);
    $restaurant = Restaurant::create(['tenant_id' => $tenant->id, 'name' => 'Test Restaurant']);
    $user = User::factory()->create(['tenant_id' => $tenant->id]);

    $response = $this
        ->withoutMiddleware(InitializeTenancyBySession::class)
        ->actingAs($user)
        ->post('/questionnaires', [
            'template' => 'casual_dining',
        ]);

    $response->assertRedirect();

    $questionnaire = Questionnaire::first();
    $this->assertNotNull($questionnaire);
    $this->assertEquals('Casual Dining', $questionnaire->title);
    $this->assertEquals('casual_dining', $questionnaire->template_type);
    $this->assertIsArray($questionnaire->questions);
    $this->assertEquals('q1', $questionnaire->questions[0]['id']);
});

test('questionnaire editor is displayed', function () {
    $tenant = Tenant::create(['id' => 'test_tenant_3']);
    Tenancy::initialize($tenant);
    $restaurant = Restaurant::create(['tenant_id' => $tenant->id, 'name' => 'Test Restaurant']);
    $user = User::factory()->create(['tenant_id' => $tenant->id]);

    $questionnaire = Questionnaire::factory()->create([
        'tenant_id' => $tenant->id,
    ]);

    $response = $this
        ->actingAs($user)
        ->get(route('questionnaires.edit', $questionnaire->id));

    $response->assertOk();
    $response->assertSee('Edit Questionnaire');
});

test('questionnaire questions can be updated', function () {
    $tenant = Tenant::create(['id' => 'test_tenant_4']);
    Tenancy::initialize($tenant);
    $restaurant = Restaurant::create(['tenant_id' => $tenant->id, 'name' => 'Test Restaurant']);
    $user = User::factory()->create(['tenant_id' => $tenant->id]);

    $questionnaire = Questionnaire::factory()->create([
        'tenant_id' => $tenant->id,
    ]);

    $newQuestions = [
        [
            'id' => 'q_new_1',
            'text' => 'Updated Question?',
            'type' => 'text',
            'options' => [],
            'required' => false
        ]
    ];

    $response = $this
        ->withoutMiddleware(InitializeTenancyBySession::class)
        ->actingAs($user)
        ->patch(route('questionnaires.update', $questionnaire->id), [
            'title' => 'Updated Title',
            'questions' => $newQuestions,
        ]);

    $response->assertRedirect();

    $questionnaire->refresh();
    $this->assertEquals('Updated Title', $questionnaire->title);
    $this->assertEquals('Updated Question?', $questionnaire->questions[0]['text']);
});

test('user cannot edit other tenants questionnaire', function () {
    $tenant1 = Tenant::create(['id' => 'tenant1']);
    Tenancy::initialize($tenant1);
    Restaurant::create(['tenant_id' => $tenant1->id, 'name' => 'R1']);
    $user1 = User::factory()->create(['tenant_id' => $tenant1->id]);

    // Switch or create context for tenant 2 not needed for isolation check if scope works
    $tenant2 = Tenant::create(['id' => 'tenant2']);
    // We don't initialize tenant2, so creating Q2 might be tricky if scope active.
    // Use withoutGlobalScopes or manually create
    $questionnaire2 = Questionnaire::withoutGlobalScopes()->create([
        'tenant_id' => $tenant2->id,
        'title' => 'Q2',
        'template_type' => 'custom',
        'is_active' => true
    ]);

    $response = $this
        ->actingAs($user1)
        ->get(route('questionnaires.edit', $questionnaire2->id));

    $response->assertStatus(404); // Should be 404 because global scope hides it, OR 403 if found. Model binding with scope -> 404.
});

test('preview page is accessible', function () {
    $tenant = Tenant::create(['id' => 'test_tenant_5']);
    Tenancy::initialize($tenant);
    $restaurant = Restaurant::create(['tenant_id' => $tenant->id, 'name' => 'Test Restaurant']);
    $user = User::factory()->create(['tenant_id' => $tenant->id]);

    $questionnaire = Questionnaire::factory()->create([
        'tenant_id' => $tenant->id,
    ]);

    $response = $this
        ->actingAs($user)
        ->get(route('questionnaires.preview', $questionnaire->id));

    $response->assertOk();
    $response->assertSee('Preview Mode');
    $response->assertSee($questionnaire->title);
});
