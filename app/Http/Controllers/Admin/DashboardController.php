<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected DashboardService $service;

    public function __construct(DashboardService $service)
    {
        $this->service = $service;
    }

    public function dashboard(Request $request)
    {
        $year = (int) $request->query('year', now()->year);
        $dashboardData = $this->service->getDashboardData($year);

        return view('backend.dashboard', compact('dashboardData'));
    }

    // AJAX endpoint so switching the year dropdown updates the chart
    // without a full page reload.
    public function chartData(Request $request)
    {
        $year = (int) $request->query('year', now()->year);
        $data = $this->service->getDashboardData($year);

        return response()->json([
            'success' => true,
            'chart'   => $data['chart'],
        ]);
    }

    public function sticky_notices(){
        return view('backend.sticky_notices');
    }
}