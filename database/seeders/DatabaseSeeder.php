<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Tenant for Business User
        $tenantId = 'resto_test_01';
        $tenant = \App\Models\Tenant::create(['id' => $tenantId]);
        \Stancl\Tenancy\Facades\Tenancy::initialize($tenant);

        // 2. Create Restaurant Profile (Linked to Tenant)
        \App\Models\Restaurant::create([
            'tenant_id' => $tenantId,
            'name' => 'Kopi Santai (Test)',
        ]);

        // 3. Create Business User (Owner)
        User::factory()->create([
            'name' => 'Sari (Owner)',
            'email' => 'owner@example.com',
            'password' => bcrypt('password'),
            'tenant_id' => $tenantId,
            'is_admin' => false,
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // 4. Create Admin User (System Admin)
        // Admin usually doesn't need a specific tenant, effectively 'global' or 'null' tenant depending on logic.
        // For simplicity/safety, we create a separate admin tenant or keep it null if allowed.
        // Assuming Admin requires no tenant context for global ops, or has their own.
        // Let's keep it simple: separate tenant for admin context if needed, or null.
        // Looking at User model, tenant_id is fillable.

        // Reset Tenancy for Admin (or use a different tenant)
        // \Stancl\Tenancy\Facades\Tenancy::end(); 

        User::factory()->create([
            'name' => 'Andi (System Admin)',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'tenant_id' => null, // Admin might be tenant-less or super-tenant
            'is_admin' => true,
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
    }
}
