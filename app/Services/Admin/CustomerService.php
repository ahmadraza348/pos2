<?php

namespace App\Services\Admin;


use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CustomerService
{
   public function create(array $data): Customer {  

     if (isset($data['image'])) {
                $data['image'] = $data['image']->store('images/customers', 'public');
            }
    return Customer::create($data);
}

    public function update(Customer $customer, array $data): Customer
    {
        return DB::transaction(function () use ($customer, $data) {
            if (isset($data['image'])) {
                if ($customer->image) {
                    Storage::disk('public')->delete($customer->image);
                }
                $data['image'] = $data['image']->store('images/customers', 'public');
            }

            $customer->update($data);
            return $customer;
        });
    }

 public function delete(Customer $customer): void
    {
        DB::transaction(function () use ($customer) {
            if ($customer->image) {
                Storage::disk('public')->delete($customer->image);
            }            
            $customer->delete();
        });
    }

    public function bulkDelete(array $customerIds): void
    {
        DB::transaction(function () use ($customerIds) {
            $customers = Customer::whereIn('id', $customerIds)->get();
            
            foreach ($customers as $customer) {
                if ($customer->image) {
                    Storage::disk('public')->delete($customer->image);
                }
            }
            Customer::whereIn('id', $customerIds)->delete();
        });
    }
}