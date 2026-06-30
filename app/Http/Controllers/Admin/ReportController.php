<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\Reports\SalesReportService;
use App\Services\Admin\Reports\PurchaseReportService;
use App\Services\Admin\Reports\InventoryReportService;
use App\Services\Admin\Reports\ProfitLossReportService;
use App\Services\Admin\Reports\DayEndReportService;
use App\Services\Admin\Reports\CustomerReportService;
use App\Services\Admin\Reports\SupplierReportService;
use App\Services\Admin\Reports\ReturnReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('backend.reports.index');
    }

    public function sales(Request $request, SalesReportService $service)
    {
        [$from, $to] = $this->resolveDates($request);

        return view('backend.reports.sales', [
            'from'           => $from,
            'to'             => $to,
            'summary'        => $service->getSummary($from, $to),
            'trend'          => $service->getDailyTrend($from, $to),
            'byPaymentMethod'=> $service->getByPaymentMethod($from, $to),
            'byCashier'      => $service->getByCashier($from, $to),
            'topCustomers'   => $service->getTopCustomers($from, $to),
            'topProducts'    => $service->getTopSellingProducts($from, $to),
            'sales'          => $service->getDetailedSales($request->only(['from','to','customer_id','payment_method']) + ['from' => $from, 'to' => $to]),
        ]);
    }

    public function purchases(Request $request, PurchaseReportService $service)
    {
        [$from, $to] = $this->resolveDates($request);

        return view('backend.reports.purchases', [
            'from'             => $from,
            'to'               => $to,
            'summary'          => $service->getSummary($from, $to),
            'trend'            => $service->getDailyTrend($from, $to),
            'bySupplier'       => $service->getBySupplier($from, $to),
            'mostPurchased'    => $service->getMostPurchasedProducts($from, $to),
            'purchases'        => $service->getDetailedPurchases($request->only(['from','to','supplier_id','status']) + ['from' => $from, 'to' => $to]),
        ]);
    }

    public function inventory(InventoryReportService $service)
    {
        return view('backend.reports.inventory', [
            'valuation'  => $service->getStockValuation(),
            'lowStock'   => $service->getLowStock(),
            'outOfStock' => $service->getOutOfStock(),
            'deadStock'  => $service->getDeadStock(),
        ]);
    }

    public function stockMovement(Request $request, InventoryReportService $service)
    {
        [$from, $to] = $this->resolveDates($request);

        return view('backend.reports.stock-movement', [
            'from'     => $from,
            'to'       => $to,
            'movement' => $service->getStockMovement($from, $to),
        ]);
    }

    public function profitLoss(Request $request, ProfitLossReportService $service)
    {
        [$from, $to] = $this->resolveDates($request);
        $year = (int) $request->query('year', now()->year);

        return view('backend.reports.profit-loss', [
            'from'           => $from,
            'to'             => $to,
            'data'           => $service->getProfitLoss($from, $to),
            'trend'          => $service->getMonthlyTrend($year),
            'byCategory'     => $service->getProfitByCategory($from, $to),
            'selectedYear'   => $year,
        ]);
    }

    public function dayEnd(Request $request, DayEndReportService $service)
    {
        $date = $request->query('date', now()->toDateString());
        $cashierId = $request->query('cashier_id');

        return view('backend.reports.day-end', [
            'date'    => $date,
            'report'  => $service->getReport($date, $cashierId),
            'byCashier' => $service->getCashierBreakdown($date),
        ]);
    }

    public function customers(CustomerReportService $service)
    {
        return view('backend.reports.customers', [
            'withDue'      => $service->getCustomersWithDue(),
            'topCustomers' => $service->getTopCustomersByLifetimeValue(),
        ]);
    }

    public function suppliers(SupplierReportService $service)
    {
        return view('backend.reports.suppliers', [
            'withDue' => $service->getSuppliersWithDue(),
        ]);
    }

    public function returns(Request $request, ReturnReportService $service)
    {
        [$from, $to] = $this->resolveDates($request);

        return view('backend.reports.returns', [
            'from'    => $from,
            'to'      => $to,
            'summary' => $service->getSummary($from, $to),
            'byReason'=> $service->getByReason($from, $to),
            'returns' => $service->getDetailed($request->only(['from','to']) + ['from' => $from, 'to' => $to]),
        ]);
    }

    protected function resolveDates(Request $request): array
    {
        $from = $request->query('from', now()->startOfMonth()->toDateString());
        $to = $request->query('to', now()->endOfMonth()->toDateString());
        return [$from, $to];
    }
}