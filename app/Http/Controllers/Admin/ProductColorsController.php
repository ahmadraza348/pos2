<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ColorRequest;
use App\Models\Color;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\StoreColorRequest;
use App\Http\Requests\Admin\UpdateColorRequest;
use App\Services\Admin\ColorService;

class ProductColorsController extends Controller
{
 protected $service;

public function __construct(ColorService $service){
    $this->service = $service;  
}

public function index()
{
    $colors = Color::latest()->get();
    return view('backend.colors.index', compact('colors'));
}

public function create()
{
    return view('backend.colors.create');
}

public function store(ColorRequest $request)
{
    $this->service->createColor($request->validated());
    toastr()->success('Color added successfully');
    return redirect()->route('colors.index');
}

public function edit(Color $color)
{
    return view('backend.colors.edit', compact('color'));
}

public function update(ColorRequest $request, Color $color)
{
    $this->service->updateColor($color, $request->validated());
    toastr()->success('Color updated successfully');
    return redirect()->route('colors.index');
}

public function destroy(Color $color)
{
    $this->service->destroyColor($color);
    toastr()->success('Color deleted successfully');
    return back();
}

}
