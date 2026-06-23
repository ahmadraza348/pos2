<?php

namespace App\Http\Controllers\Admin;

use App\Models\Customer;
use App\Http\Controllers\Controller;
use App\Services\Admin\CustomerService;
use App\Http\Requests\Admin\CustomerRequest;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected CustomerService $service;

    public function __construct(CustomerService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('backend.customers', [
            'customer_data' => Customer::all(),
            'editable_customer' => null
        ]);
    }

    public function store(CustomerRequest $request)
    {
        $this->service->create($request->validated());
        toastr()->success('Customer created successfully');
        return redirect()->route('customer.index');
    }

    public function edit(Customer $customer)
    {
        return view('backend.customers', [
            'customer_data' => Customer::all(),
            'editable_customer' => $customer
        ]);
    }

    public function update(CustomerRequest $request, Customer $customer) 
    {
        $this->service->update($customer, $request->validated());
        toastr()->success('Customer updated successfully');
        return redirect()->route('customer.index');
    }

    public function destroy(Customer $customer)
    {
        try {
            $this->service->delete($customer);
            toastr()->success('Customer Deleted Successfully');
        } catch (\Throwable $th) {
            toastr()->error('Customer delete failed');
        }
        return back();
    }

  public function bulkDelete(Request $request)
{
    $customerIds = array_filter(
        explode(',', $request->customer_ids)
    );

    $this->service->bulkDelete($customerIds);

    toastr()->success('customer deleted successfully');

    return back();
}
}