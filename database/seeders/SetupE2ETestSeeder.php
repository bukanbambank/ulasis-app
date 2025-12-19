<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Tenant;
use App\Models\Restaurant;
use Stancl\Tenancy\Facades\Tenancy;
use Illuminate\Support\Facades\Hash; // Import Hash facade

class SetupE2ETestSeeder extends Seeder
{
    public function run()
    {
        $tenantId = 'resto_test_01';
        $t = Tenant::firstOrCreate(['id' => $tenantId]);

        try {
            Tenancy::initialize($t);
        } catch (\Exception $e) {
            // Tenancy might already be initialized
        }

        Restaurant::firstOrCreate(['tenant_id' => $tenantId], [
            'name' => 'Kopi Santai',
        ]);

        $u = User::where('email', 'owner@example.com')->first();

        if (!$u) {
            User::create([
                'name' => 'Sari (Owner)',
                'email' => 'owner@example.com',
                'password' => Hash::make('password'),
                'tenant_id' => $tenantId,
                'is_admin' => false,
                'status' => 'active',
                'email_verified_at' => now(),
            ]);
            $this->command->info('User created: owner@example.com / password');
        } else {
            $u->password = Hash::make('password');
            $u->save();
            $this->command->info('User updated: owner@example.com / password (reset)');
        }
    }
}
