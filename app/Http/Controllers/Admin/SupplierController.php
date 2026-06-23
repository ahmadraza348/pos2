<?php

namespace App\Http\Controllers\Admin;

use App\Models\Supplier;
use App\Http\Controllers\Controller;
use App\Services\Admin\SupplierService;
use App\Http\Requests\Admin\SupplierRequest;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    protected SupplierService $service;

    public function __construct(SupplierService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('backend.suppliers', [
            'suppliers_data' => Supplier::all(),
            'editable_supplier' => null
        ]);
    }

    public function store(SupplierRequest $request)
    {
        $this->service->create($request->validated());
        toastr()->success('Supplier created successfully');
        return redirect()->route('supplier.index');
    }

    public function edit(Supplier $supplier)
    {
        return view('backend.suppliers', [
            'suppliers_data' => Supplier::all(),
            'editable_supplier' => $supplier
        ]);
    }

    public function update(SupplierRequest $request, Supplier $supplier) 
    {
        $this->service->update($supplier, $request->validated());
        toastr()->success('Supplier updated successfully');
        return redirect()->route('supplier.index');
    }

    public function destroy(Supplier $supplier)
    {
        try {
            $this->service->delete($supplier);
            toastr()->success('Supplier Deleted Successfully');
        } catch (\Throwable $th) {
            toastr()->error('Supplier delete failed');
        }
        return back();
    }

  public function bulkDelete(Request $request)
{
    $supplierIds = array_filter(
        explode(',', $request->supplier_ids)
    );

    $this->service->bulkDelete($supplierIds);

    toastr()->success('Suppliers deleted successfully');

    return back();
}
}