<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Models\Restaurant;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Mockery;
use Tests\TestCase;

class SocialAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_redirects_to_google()
    {
        $response = $this->get(route('social.redirect', 'google'));

        $response->assertRedirect();
        $this->assertStringContainsString('accounts.google.com', $response->getTargetUrl());
    }

    public function test_existing_user_can_login_via_google()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'google_id' => null,
        ]);

        $abstractUser = Mockery::mock(SocialiteUser::class);
        $abstractUser->shouldReceive('getId')->andReturn('google-12345');
        $abstractUser->shouldReceive('getEmail')->andReturn('test@example.com');
        $abstractUser->shouldReceive('getName')->andReturn('Test User');
        $abstractUser->shouldReceive('getAvatar')->andReturn('image.jpg');

        Socialite::shouldReceive('driver->user')->andReturn($abstractUser);

        $response = $this->get(route('social.callback', 'google'));

        $response->assertRedirect(route('dashboard', absolute: false));
        $this->assertAuthenticatedAs($user);
        $this->assertEquals('google-12345', $user->fresh()->google_id);
    }

    public function test_new_user_is_created_with_tenant()
    {
        $abstractUser = Mockery::mock(SocialiteUser::class);
        $abstractUser->shouldReceive('getId')->andReturn('google-new-user');
        $abstractUser->shouldReceive('getEmail')->andReturn('new@example.com');
        $abstractUser->shouldReceive('getName')->andReturn('New User');
        $abstractUser->shouldReceive('getAvatar')->andReturn('image.jpg');

        Socialite::shouldReceive('driver->user')->andReturn($abstractUser);

        $response = $this->get(route('social.callback', 'google'));

        $response->assertRedirect(route('dashboard', absolute: false));
        $this->assertAuthenticated();

        $user = User::where('email', 'new@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('google-new-user', $user->google_id);
        $this->assertNotNull($user->tenant_id);

        // Verify Tenant and Restaurant Creation
        $this->assertDatabaseHas('restaurants', [
            'tenant_id' => $user->tenant_id,
            'name' => 'My Restaurant (Default)',
        ]);
    }
}
