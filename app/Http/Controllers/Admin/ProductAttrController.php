<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProAttrRequest;
use App\Services\Admin\ProAttributeService;
use Illuminate\Http\JsonResponse;

class ProductAttrController extends Controller
{
    public function __construct(
        protected ProAttributeService $service
    ) {}

    public function add_pro_attr(int $product_id)
    {
        $data = $this->service->getAttributesData($product_id);
        return view('backend.pro_attr.add', $data);
    }

    public function fetch_pro_attr(int $product_id): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data'   => $this->service->fetchAttributes($product_id)
        ]);
    }

    public function store_pro_attr(ProAttrRequest $request): JsonResponse
    {
        $this->service->storeAttributeData($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Product attribute created successfully!'
        ]);
    }

    public function update_pro_attr(ProAttrRequest $request, int $id): JsonResponse
    {
        $this->service->updateAttributeData(
            $request->validated(),
            $id
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Product attribute updated successfully!'
        ]);
    }

    public function delete_pro_attr(int $id): JsonResponse
    {
        $this->service->deleteAttribute($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Attribute deleted successfully!'
        ]);
    }
}