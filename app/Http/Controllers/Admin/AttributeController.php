<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\RelationalCategory;
use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AttributeStoreRequest;
use App\Services\Admin\AttributeService;
use App\Http\Requests\Admin\UpdateAttributeRequest;

class AttributeController extends Controller
{
    protected $attributeService;

    public  function __construct(AttributeService $attributeService)
    {
        $this->attributeService = $attributeService;
    }

    public function index()
    {
        $data['attribute'] = Attribute::OrderBy('name', 'ASC')->get();
        return view('backend.attribute.index', $data);
    }

    public function create()
    {
        $data['categories'] = Category::with('subcategories')->whereNull('parent_id')->orderby('name', 'asc')->get();
        return view('backend.attribute.create', $data);
    }

    public function store(AttributeStoreRequest $request)
    {
        $this->attributeService->storeAttribute($request->validated());
        toastr()->success('Attribute created successfully');
        return redirect()->route('attribute.index');
    }

    public function edit(Attribute $attribute)
    {
        $data['attribute'] = $attribute;

        $data['all_category_data'] = Category::where('status', '1')
            ->whereNull('parent_id')
            ->with('subcategories.subcategories')
            ->get();

        $data['selected_categories'] = $data['attribute']->categories->pluck('id')->toArray();
        return view('backend.attribute.edit', $data);
    }

    public function update(UpdateAttributeRequest $request, Attribute $attribute)
    {
        $this->attributeService->updateAttribute($attribute, $request->validated());
        toastr()->success('Attribute updated successfully');
        return redirect()->route('attribute.index');
    }

    public function destroy(Attribute $attribute)
    {
        $this->attributeService->destroyAttribute($attribute);
        toastr()->success('Attribute Deleted Successfully');
        return redirect()->back();
    }
}
