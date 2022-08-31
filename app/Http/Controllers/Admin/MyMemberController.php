<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\User;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\Commission;
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
        $this->middleware('permission:my-members', ['only' => ['index']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $bbId = Auth::user()->id;
        $usersProductsDetail = DB::table('products')
                    ->leftjoin('user_products','products.id','=', 'user_products.product_id')
                    ->leftjoin('users' , 'user_products.business_builder' , '=' , 'users.id')
                    ->where('user_products.business_builder', '=' ,$bbId)
                    ->select('*')->get();
        
        $products=Product::all();
        $users = User::all();
        $mymembers= DB::table('users')
                ->where('business_builder_id' ,'=' ,$bbId)
                ->get();

        $transactions = DB::table('users')
                        ->rightjoin('transactions' , 'users.id' , '=' , 'transactions.member_id')
                        ->rightjoin('user_products' , 'users.ibm' , '=' , 'user_products.user_ibm')
                        ->leftjoin('products' , 'user_products.product_id' , '=' , 'products.id')
                        ->where('user_products.business_builder' ,'=' ,$bbId)
                        ->get();
        $commissions = Commission::all();
        // return view('admin.mymembers' , compact('data' , 'products','users' , 'transactions' ,'commissions'));


        return view('admin.mymembers' , compact('usersProductsDetail' ,'mymembers','users', 'transactions' ,'commissions' , 'products'));
    }

    
}
