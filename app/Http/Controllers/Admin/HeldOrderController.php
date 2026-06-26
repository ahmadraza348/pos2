<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\PosService;

class HeldOrderController extends Controller
{
    protected PosService $posService;

    public function __construct(PosService $posService)
    {
        $this->posService = $posService;
    }

    public function index()
    {
        return view('backend.held-orders.index', ['orders' => $this->posService->getHeldOrders()]);
    }

    public function resume(int $id)
    {
        // Hand off to the POS screen; POS will pull this order into the cart on load.
        return redirect()->route('pos.index', ['resume' => $id]);
    }

    public function destroy(int $id)
    {
        $this->posService->deleteHeldOrder($id);
        toastr()->success('Held order deleted.');
        return redirect()->route('held-orders.index');
    }
}