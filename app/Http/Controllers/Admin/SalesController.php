<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\SalesService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SalesController extends Controller
{
    protected SalesService $service;

    public function __construct(SalesService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        return view('backend.sales.index', [
            'sales'   => $this->service->getAll($request->only(['status', 'payment_status', 'from', 'to', 'search'])),
            'filters' => $request->only(['status', 'payment_status', 'from', 'to', 'search']),
        ]);
    }

    public function show(int $id)
    {
        return view('backend.sales.show', ['sale' => $this->service->find($id)]);
    }

    public function void(int $id)
    {
        try {
            $this->service->void($id);
            toastr()->success('Sale voided and stock restored.');
        } catch (ValidationException $e) {
            toastr()->error($e->getMessage());
        }
        return redirect()->back();
    }
}