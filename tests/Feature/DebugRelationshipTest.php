<?php

use App\Models\Restaurant;
use App\Models\Tenant;
use App\Models\User;
use Stancl\Tenancy\Facades\Tenancy;

test('user has restaurant relationship', function () {
    $tenant = Tenant::create(['id' => 'debug_tenant']);
    Tenancy::initialize($tenant);

    $restaurant = Restaurant::create(['tenant_id' => $tenant->id, 'name' => 'Debug Resto']);
    $user = User::factory()->create(['tenant_id' => $tenant->id]);

    expect($user->restaurant)->not->toBeNull();
    expect($user->restaurant->id)->toBe($restaurant->id);
    expect($user->restaurant->name)->toBe('Debug Resto');
});
