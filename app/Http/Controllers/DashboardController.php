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

        $user = auth()->user();

        if ($user->hasAnyRole('Administrator')){

            return view('dashboard');

        }

        return redirect()->route('stok.opname');

    }

    public function stock(Request $request){
        return view('pages.stock');
    }
}
