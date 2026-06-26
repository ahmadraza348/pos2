<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ExpenseRequest;
use App\Services\Admin\ExpenseService;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    protected ExpenseService $service;

    public function __construct(ExpenseService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        return view('backend.expenses.index', [
            'expenses' => $this->service->getAll($request->only(['category_id', 'payment_method', 'from', 'to', 'search'])),
            'filters'  => $request->only(['category_id', 'payment_method', 'from', 'to', 'search']),
            'categories' => app(\App\Services\Admin\ExpenseCategoryService::class)->getActive(),
        ]);
    }

    public function create()
    {
        return view('backend.expenses.create', $this->service->getCreateData());
    }

    public function store(ExpenseRequest $request)
    {
        $this->service->store($request);
        toastr()->success('Expense recorded successfully!');
        return redirect()->route('expenses.index');
    }

    public function edit(string $id)
    {
        return view('backend.expenses.edit', $this->service->getEditData($id));
    }

    public function update(ExpenseRequest $request, string $id)
    {
        $this->service->update($request, $id);
        toastr()->success('Expense updated successfully!');
        return redirect()->route('expenses.index');
    }

    public function destroy(string $id)
    {
        $this->service->delete($id);
        toastr()->success('Expense deleted.');
        return redirect()->back();
    }

    public function restore_trashed()
    {
        return view('backend.expenses.restore', ['expenses' => $this->service->getTrashed()]);
    }

    public function restore(string $id)
    {
        $this->service->restore($id);
        toastr()->success('Expense restored.');
        return redirect()->route('expenses.index');
    }

    public function forceDelete(string $id)
    {
        $this->service->forceDelete($id);
        toastr()->success('Expense permanently deleted.');
        return redirect()->back();
    }
}