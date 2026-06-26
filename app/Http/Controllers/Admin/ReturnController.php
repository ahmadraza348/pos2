<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReturnRequest;
use App\Services\Admin\ReturnService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ReturnController extends Controller
{
    protected ReturnService $service;

    public function __construct(ReturnService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('backend.returns.index', ['returns' => $this->service->getAll()]);
    }

    public function create()
    {
        return view('backend.returns.create');
    }

    public function searchSale(Request $request)
    {
        $request->validate(['invoice_no' => 'required|string']);

        try {
            $result = $this->service->findSaleForReturn($request->invoice_no);
            return response()->json(['success' => true, 'data' => $result]);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function store(ReturnRequest $request)
    {
        try {
            $saleReturn = $this->service->create($request->validated());
            toastr()->success("Return {$saleReturn->return_no} processed successfully!");
            return redirect()->route('returns.show', $saleReturn->id);
        } catch (ValidationException $e) {
            toastr()->error($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function show(int $id)
    {
        return view('backend.returns.show', ['saleReturn' => $this->service->find($id)]);
    }
}