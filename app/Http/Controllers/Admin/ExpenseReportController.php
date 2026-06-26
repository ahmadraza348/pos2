<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\ExpenseReportService;
use Illuminate\Http\Request;

class ExpenseReportController extends Controller
{
    protected ExpenseReportService $service;

    public function __construct(ExpenseReportService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $from = $request->query('from');
        $to = $request->query('to');
        $year = (int) $request->query('year', now()->year);

        return view('backend.expenses.report', [
            'summary'        => $this->service->getSummary($from, $to),
            'trend'          => $this->service->getMonthlyTrend($year),
            'topCategories'  => $this->service->getTopCategories($from, $to),
            'selectedYear'   => $year,
        ]);
    }

    public function trendData(Request $request)
    {
        $year = (int) $request->query('year', now()->year);
        return response()->json(['success' => true, 'trend' => $this->service->getMonthlyTrend($year)]);
    }
}