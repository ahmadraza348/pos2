<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PurchaseRequest;
use App\Services\Admin\PurchaseService;

class PurchaseController extends Controller
{
    protected PurchaseService $service;

    public function __construct(PurchaseService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('backend.purchase.index', [
            'purchases' => $this->service->getAll()
        ]);
    }

    public function create()
    {
        return view('backend.purchase.create', $this->service->getCreateData());
    }

    public function store(PurchaseRequest $request)
    {
        $this->service->store($request->validated());
        toastr()->success('Purchase recorded successfully!');
        return redirect()->route('purchase.index');
    }

    public function edit(string $id)
    {
        return view('backend.purchase.edit', $this->service->getEditData($id));
    }

    public function update(PurchaseRequest $request, string $id)
    {
        $this->service->update($request->validated(), $id);
        toastr()->success('Purchase updated successfully!');
        return redirect()->route('purchase.index');
    }

    public function destroy(string $id)
    {
        $this->service->delete($id);
        toastr()->success('Purchase deleted successfully!');
        return redirect()->back();
    }

    public function restore_trashed()
    {
        return view('backend.purchase.restore', [
            'purchases' => $this->service->getTrashed()
        ]);
    }

    public function restore(string $id)
    {
        $this->service->restore($id);
        toastr()->success('Purchase restored successfully!');
        return redirect()->route('purchase.index');
    }

    public function forceDelete(string $id)
    {
        $this->service->forceDelete($id);
        toastr()->success('Purchase permanently deleted!');
        return redirect()->back();
    }
}