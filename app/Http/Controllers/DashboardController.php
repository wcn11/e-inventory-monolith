<?php

namespace App\Http\Controllers;

use App\StockRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function index(): \Illuminate\Contracts\Support\Renderable
    {
        $role = auth()->user()->hasPermissionTo('admin');
        if ($role){
            return view('dashboard');
        }

        $user = auth()->user()->id;

        $stocks = StockRequest::select('total_stock')->where("user_id", $user)->sum('total_stock');
        return view('pages.stok.index', compact('stocks'));
    }

    public function stock(Request $request){
        return view('pages.stock');
    }
}
