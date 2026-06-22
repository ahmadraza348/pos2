<?php

namespace App\Services\Admin;


use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class SupplierService
{
   public function create(array $data): Supplier {  
    return Supplier::create($data);
}

public function update(Supplier $supplier, array $data): Supplier {
    $supplier->update($data);
    return $supplier;
}

public function delete(Supplier $supplier): void {   
    $supplier->delete();
}
 public function bulkDelete(array $supplierIds): void
{
    Supplier::whereIn('id', $supplierIds)->delete();
}
}