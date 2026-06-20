<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\Admin\SalesService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Exports\SalesExport;
use Maatwebsite\Excel\Facades\Excel;

use function Flasher\Toastr\Prime\toastr;

class SalesController extends Controller
{
    protected $service;

    public function __construct(SalesService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $sales = $this->service->getsales();

        return view('backend.sales.index', compact('sales'));
    }

    public function details(Order $order)
    {
        return view('backend.sales.details', compact('order'));
    }

    public function updateOrderStatus(Order $order, Request $request)
    {
        if ($order->order_status === 'cancelled') {
            toastr()->error('This order is already cancelled. Status cannot be changed.');
            return redirect()->back();
        }
        if ($request->order_status === 'cancelled') {
            $this->service->cancelOrder($order);
        }
        $this->service->updateOrderStatus($order);
        toastr()->success('Order status updated successfully');

        return redirect()->back();
    }

    public function download_pdf($id)
    {
        $order = Order::findOrFail($id);
        $pdf = Pdf::loadView('backend.sales.pdf', compact('order'));
        return $pdf->download('order-'.$order->order_number.'.pdf');
    }

    public function print($id)
    {
        $order = Order::findOrFail($id);
       $printView = view('backend.sales.print', compact('order'));
       return response($printView);
}
public function export(){
    return Excel::download(new SalesExport, 'all-sales.xlsx');
}
}