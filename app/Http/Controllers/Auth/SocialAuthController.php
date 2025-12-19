<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Tenant;
use App\Models\Restaurant;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirect(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();

            $user = User::where('email', $socialUser->getEmail())->first();

            if ($user) {
                // Link existing user if not linked
                if (!$user->google_id) {
                    $user->update(['google_id' => $socialUser->getId()]);
                }

                Auth::login($user);
                return redirect()->intended(route('dashboard', absolute: false));
            }

            // Create new user with Tenant/Restaurant
            $user = DB::transaction(function () use ($socialUser) {
                // Create Default Tenant
                $tenantId = Str::slug('my-restaurant') . '-' . Str::random(6);
                $tenant = Tenant::create(['id' => $tenantId]);

                // Create Default Restaurant
                Restaurant::create([
                    'tenant_id' => $tenant->id,
                    'name' => 'My Restaurant (Default)',
                ]);

                return User::create([
                    'name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'password' => Hash::make(Str::random(16)), // Random password
                    'google_id' => $socialUser->getId(),
                    'email_verified_at' => now(), // Trusted provider
                    'tenant_id' => $tenant->id,
                ]);
            });

            event(new Registered($user));
            Auth::login($user);

            return redirect()->intended(route('dashboard', absolute: false));

        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['email' => 'Failed to login with Google. Please try again.']);
        }
    }
}
