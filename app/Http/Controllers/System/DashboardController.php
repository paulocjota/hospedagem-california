<?php

namespace App\Http\Controllers\System;

use App\Models\Room;
use App\Models\Product;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('system.dashboard')->with([
            'products' => Product::lowStock()->get(),
            'rooms' => Room::orderBy('number', 'ASC')->get(),
        ]);
    }
}
