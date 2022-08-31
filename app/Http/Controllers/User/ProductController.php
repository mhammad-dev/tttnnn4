<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
class ProductController extends Controller
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
                    ->leftjoin('users','users.id' , '=' , 'products.intermediary')
                    ->leftjoin('user_products','products.id','=', 'user_products.product_id')
                    ->leftjoin('admins' , 'user_products.business_builder' , '=','admins.id')
                    ->where('user_products.user_ibm', '=' ,Auth::user()->ibm)
                    ->select('products.product_name' ,'products.product_description' ,'user_products.policy_no','admins.name as business_builder_name' ,'users.name as group_name')->get();
                    
        return view('user.products-list' , compact('usersProductsDetail'));
    }

    
}
