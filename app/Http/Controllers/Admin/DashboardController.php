<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\DashboardService;

class DashboardController extends Controller
{
    protected $service;
    public function __construct(DashboardService $service)
    {
        $this->service = $service;
    }
   public function dashboard()
{
    $dashboardData = $this->service->getDashboardData();
    return view('backend.dashboard', compact('dashboardData'));
}

}
