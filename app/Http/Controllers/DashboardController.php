<?php

namespace App\Http\Controllers;

use App\Codes\Models\StockRequest;
use Illuminate\Http\Request;

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

        return view('dashboard');

//        $role = auth()->user();
//
//        if ($role){
//            return view('dashboard');
//        }
//
//        $user = auth()->user()->id;
//
//        $stocks = StockRequest::select('total_stock')->where("user_id", $user)->sum('total_stock');
//
//        return view('pages.stok.index', compact('stocks'));
    }

    public function stock(Request $request){
        return view('pages.stock');
    }
}
