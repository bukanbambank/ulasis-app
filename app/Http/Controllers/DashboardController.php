<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DashboardService;
use App\Models\Tenant;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index(Request $request)
    {
        $range = $request->get('range', 30); // Default 30 days
        $tenantId = tenancy()->tenant ? tenancy()->tenant->id : auth()->user()->tenant_id;

        $stats = $this->dashboardService->getStats($tenantId, $range);
        $sentiment = $this->dashboardService->getSentimentData($tenantId, $range);
        $trend = $this->dashboardService->getTrendData($tenantId, $range);

        return view('dashboard', compact('stats', 'sentiment', 'trend', 'range'));
    }
}
