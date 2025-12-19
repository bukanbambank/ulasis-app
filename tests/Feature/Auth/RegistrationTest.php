<?php

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    \Illuminate\Support\Facades\Notification::fake();

    $response = $this->post('/register', [
        'restaurant_name' => 'Test Restaurant',
        'name' => 'Test Owner',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));

    $user = \App\Models\User::where('email', 'test@example.com')->first();
    \Illuminate\Support\Facades\Notification::assertSentTo($user, \Illuminate\Auth\Notifications\VerifyEmail::class);

    $this->assertDatabaseHas('users', [
        'name' => 'Test Owner',
        'email' => 'test@example.com',
    ]);

    $this->assertDatabaseHas('restaurants', [
        'name' => 'Test Restaurant',
    ]);

    // Verify tenant creation (indirectly via restaurant or user link if possible, or explicit check)
    // Since we don't know the ID, we check if ANY tenant exists or related to user
    $user = \App\Models\User::where('email', 'test@example.com')->first();
    expect($user->tenant_id)->not->toBeNull();

    $this->assertDatabaseHas('tenants', [
        'id' => $user->tenant_id,
    ]);

    $this->assertDatabaseHas('restaurants', [
        'tenant_id' => $user->tenant_id,
        'name' => 'Test Restaurant',
    ]);
});
