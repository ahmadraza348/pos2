<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Services\Admin\ProductService;

class ProductController extends Controller
{
    protected ProductService $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('backend.inventory.product.index', [
            'products' => $this->service->getAll()
        ]);
    }

    public function create()
    {
        return view('backend.inventory.product.create', $this->service->getCreateData());
    }

    public function store(ProductRequest $request)
    {
        $this->service->store($request);
        toastr()->success('Product saved successfully!');
        return redirect()->route('product.index');
    }

    public function edit(string $id)
    {
        return view('backend.inventory.product.edit', $this->service->getEditData($id));
    }

    public function update(ProductRequest $request, string $id)
    {
        $this->service->update($request, $id);
        toastr()->success('Product updated successfully!');
        return redirect()->route('product.index');
    }

    public function destroy(string $id)
    {
        $this->service->delete($id);
        toastr()->success('Product deleted successfully!');
        return redirect()->back();
    }

    public function restore_product()
    {
        return view('backend.inventory.product.restore', [
            'products' => $this->service->getTrashed()
        ]);
    }

    public function restore($id)
    {
        $this->service->restore($id);
        toastr()->success('Product restored successfully!');
        return redirect()->route('product.index');
    }

    public function forceDelete($id)
    {
        $this->service->forceDelete($id);
        toastr()->success('Product permanently deleted successfully!');
        return redirect()->back();
    }

    public function bulkDelete(Request $request)
    {
        $this->service->bulkDelete($request->pro_ids);
        toastr()->success('Products deleted successfully.');
        return redirect()->back();
    }

    public function import(Request $request)
    {
        $this->service->import($request);
        toastr()->success('Products imported successfully.');
        return redirect()->back();
    }
}