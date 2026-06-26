<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ExpenseCategoryRequest;
use App\Services\Admin\ExpenseCategoryService;

class ExpenseCategoryController extends Controller
{
    protected ExpenseCategoryService $service;

    public function __construct(ExpenseCategoryService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('backend.expense-categories.index', ['categories' => $this->service->getAll()]);
    }

    public function store(ExpenseCategoryRequest $request)
    {
        $this->service->store($request->validated());
        toastr()->success('Expense category created.');
        return redirect()->route('expense-categories.index');
    }

    public function update(ExpenseCategoryRequest $request, string $id)
    {
        $this->service->update($request->validated(), $id);
        toastr()->success('Expense category updated.');
        return redirect()->route('expense-categories.index');
    }

    public function destroy(string $id)
    {
        try {
            $this->service->delete($id);
            toastr()->success('Expense category deleted.');
        } catch (\RuntimeException $e) {
            toastr()->error($e->getMessage());
        }
        return redirect()->back();
    }
}