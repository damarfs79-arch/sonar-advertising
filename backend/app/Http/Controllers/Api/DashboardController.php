<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    protected DashboardService $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function stats(): JsonResponse
    {
        return response()->json($this->dashboardService->getStats());
    }

    public function recentActivity(Request $request): JsonResponse
    {
        return response()->json($this->dashboardService->getRecentActivity());
    }
}
