<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
class GroupProductController extends Controller
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
        $usersProductsDetail = DB::table('products')
                    ->where('intermediary', '=' ,Auth::user()->id)
                    ->select('*')->get();

        return view('user.group-products-list' , compact('usersProductsDetail'));
    }

    
}
