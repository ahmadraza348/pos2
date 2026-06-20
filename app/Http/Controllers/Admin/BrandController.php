<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBrandRequest;
use App\Http\Requests\Admin\UpdateBrandRequest;
use App\Services\Admin\BrandService;

class BrandController extends Controller
{
    protected $brandService;

    /**
     * Inject the BrandService via the constructor.
     */
    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

    public function index()
    {
        $data['brand'] = Brand::orderby('name', 'ASC')->get();
        return view('backend.brand.index', $data);
    }

    public function create()
    {
        $data['categories'] = Category::with('subcategories')->whereNull('parent_id')->orderby('name', 'asc')->get();
        return view('backend.brand.create', $data);
    }

    public function store(StoreBrandRequest $request)
    {
        $this->brandService->createBrand($request->validated());
        toastr()->success('Brand created successfully');
        return redirect()->route('brand.index');
    }

    public function edit(Brand $brand)
    {       
        $data['all_category_data'] = Category::where('status', '1')
            ->whereNull('parent_id')
            ->with('subcategories.subcategories') 
            ->get();
        $data['selected_categories'] = $brand->categories->pluck('id')->toArray();
        return view('backend.brand.edit', $data, compact('brand'));
    }

 public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $this->brandService->updateBrand($brand, $request->validated());
        toastr()->success('Brand updated successfully');
        return redirect()->route('brand.index');
    }

  public function destroy(Brand $brand)
    {
        $brand->delete();
        toastr()->success('Brand Deleted Successfully');
        return redirect()->back();
    }

    public function bulkDelete(Request $request)
    {
        if ($request->filled('brand_ids')) {
            $brandIds = explode(',', $request->brand_ids);
            Brand::whereIn('id', $brandIds)->delete();
            toastr()->success('Brands deleted successfully.');
        } else {
            toastr()->error('No brands selected.');
        }

        return redirect()->back();
    }
}
