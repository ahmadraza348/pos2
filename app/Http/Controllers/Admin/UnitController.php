<?php

namespace App\Http\Controllers\Admin;

use App\Models\Unit;
use App\Http\Controllers\Controller;
use App\Services\Admin\UnitService;
use App\Http\Requests\Admin\{UnitRequest};

class UnitController extends Controller
{
    protected UnitService $service;

    public function __construct(UnitService $service)
    {
        $this->service = $service;
    }

public function index()
{
    $data['units_data'] = Unit::all();
    $data['editable_unit'] = null;

    return view('backend.inventory.units', $data);
}

    public function store(UnitRequest $request)
    {
        $this->service->create($request->validated());
        toastr()->success('Unit created successfully');
        return redirect()->route('unit.index');
    }

public function edit(Unit $unit)
{
    $data['units_data'] = Unit::all();
    $data['editable_unit'] = $unit;

    return view('backend.inventory.units', $data);
}

    public function update(UnitRequest $request, Unit $unit) 
    {
        $this->service->update($unit, $request->validated());
        toastr()->success('Unit updated successfully');
        return redirect()->route('unit.index');
    }

    public function destroy(Unit $unit)
    {
        $this->service->delete($unit);
        toastr()->success('Unit Deleted Successfully');
        return back();
    }

 
}