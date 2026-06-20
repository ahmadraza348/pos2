<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\Pos as PosService;

class PosController extends Controller
{
    protected $posService;
    public function __construct(PosService $posService)
    {
        $this->posService = $posService;
    }

    public function dashboard()
    {
        return view('backend.pos.dashboard');
    }
}
