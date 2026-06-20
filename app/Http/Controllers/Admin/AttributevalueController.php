<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AttributeValueRequest;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Services\Admin\AttributeValueService;

class AttributevalueController extends Controller
{
    protected $service;

    public function __construct(AttributeValueService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $data['value'] = AttributeValue::orderby('name', 'ASC')->get();

        return view('backend.attributevalue.index', $data);
    }

    public function create()
    {
        $data['attributes'] = Attribute::where('status', 1)->orderby('name', 'asc')->get();

        return view('backend.attributevalue.create', $data);
    }

    public function store(AttributeValueRequest $request)
    {
        $this->service->create($request->validated());
        toastr()->success('Attribute Value created successfully');

        return redirect()->route('attributevalue.index');
    }

    public function edit(AttributeValue $attributevalue)
    {
        $attributes = Attribute::orderby('name', 'asc')->get();

        return view('backend.attributevalue.edit', compact('attributevalue', 'attributes'));
    }

    public function update(AttributeValueRequest $request, AttributeValue $attributevalue)
    {
        $this->service->update($attributevalue, $request->validated());
        toastr()->success('Attribute Value updated successfully');
        return redirect()->route('attributevalue.index');
    }

    public function destroy(AttributeValue $attributevalue)
    {
        $this->service->destroy($attributevalue);
        toastr()->success('Attribute Value  Deleted Successfully');

        return redirect()->back();
    }
}
