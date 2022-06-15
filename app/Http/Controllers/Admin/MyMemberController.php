<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\User;
use App\Models\Product;
use Auth;
use DB;

class MyMemberController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //$data= User::all();
        $data = DB::table('users')
                    ->leftjoin('products','users.product_id','=', 'products.product_id')
                    ->select('*')->get();
        //dd($data);
        $users= User::all();

        $products=Product::all();
        return view('admin.mymembers' , compact('data' , 'products','users'));
    }

    
}
