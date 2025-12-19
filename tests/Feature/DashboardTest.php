<?php

use App\Models\User;
use App\Services\DashboardService;
use Mockery\MockInterface;
use Illuminate\Support\Facades\DB;
use Stancl\Tenancy\Middleware\InitializeTenancyBySession;

test('dashboard loads with correct stats via mock', function () {
    // 1. Create User
    DB::table('users')->insert([
        'name' => 'Dash Admin',
        'email' => 'dash@test.com',
        'password' => 'password',
        'created_at' => now(),
        'updated_at' => now()
    ]);
    $user = User::where('email', 'dash@test.com')->first();

    // 2. Mock Service
    $this->mock(DashboardService::class, function (MockInterface $mock) {
        $mock->shouldReceive('getStats')->once()->andReturn([
            'total_feedback' => 10,
            'avg_rating' => 4.5
        ]);
        $mock->shouldReceive('getSentimentData')->once()->andReturn([
            'labels' => ['Positive', 'Neutral', 'Negative'],
            'data' => [8, 1, 1]
        ]);
        $mock->shouldReceive('getTrendData')->once()->andReturn([
            'labels' => ['Jan 1', 'Jan 2'],
            'data' => [4.0, 5.0]
        ]);
    });

    // 3. Request
    $response = $this->actingAs($user)
        ->withoutMiddleware(InitializeTenancyBySession::class)
        ->withoutExceptionHandling()
        ->get(route('dashboard'));

    $response->assertOk();
    $response->assertViewHas('stats', function ($stats) {
        return $stats['total_feedback'] === 10 && $stats['avg_rating'] === 4.5;
    });
});
