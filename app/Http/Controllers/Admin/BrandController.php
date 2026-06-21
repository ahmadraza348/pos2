<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Http\Controllers\Controller;
use App\Services\Admin\BrandService;
use App\Http\Requests\Admin\{StoreBrandRequest,  UpdateBrandRequest};

class BrandController extends Controller
{
    protected BrandService $service;

    public function __construct(BrandService $service)
    {
        $this->service = $service;
    }

public function index()
{
    $data['brands_data'] = Brand::all();
    $data['editable_brand'] = null;

    return view('backend.inventory.brands', $data);
}

    public function store(StoreBrandRequest $request)
    {
        $this->service->create($request->validated());
        toastr()->success('Brand created successfully');
        return redirect()->route('brand.index');
    }

public function edit(Brand $brand)
{
    $data['brands_data'] = Brand::all();
    $data['editable_brand'] = $brand;

    return view('backend.inventory.brands', $data);
}

    public function update(UpdateBrandRequest $request, Brand $brand) 
    {
        $this->service->update($brand, $request->validated());
        toastr()->success('Brand updated successfully');
        return redirect()->route('brand.index');
    }

    public function destroy(Brand $brand)
    {
        $this->service->delete($brand);
        toastr()->success('Brand Deleted Successfully');
        return back();
    }

 
}