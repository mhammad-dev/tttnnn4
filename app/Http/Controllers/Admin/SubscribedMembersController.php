<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\User;
use App\Models\Admin\Admin;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\Commission;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Auth;
use DB;

class SubscribedMembersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:all-subscribed-members');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function all()
    {
        
        $usersProductsDetail = DB::table('products')
                    ->join('user_products','products.id','=', 'user_products.product_id')
                     ->leftjoin('admins' , 'user_products.business_builder' , '=','admins.id')
                    ->select('*')->get();
        $products=Product::all();
        $users= User::all();
        $transactions = DB::table('users')
                        ->rightjoin('transactions' , 'users.id' , '=' , 'transactions.member_id')
                        ->rightjoin('user_products' , 'users.ibm' , '=' , 'user_products.user_ibm')
                        ->leftjoin('products' , 'user_products.product_id' , '=' , 'products.id')
                        ->get();
        $commissions = Commission::all();
        $admins = Admin::permission('is-business-builder')->where('id' , '!=' ,Auth::user()->id)->get();
            // return view('admin.mymembers' , compact('data' , 'products','users' , 'transactions' ,'commissions'));


        return view('admin.subscribed_members' , compact('usersProductsDetail' , 'products' , 'users', 'transactions' ,'commissions', 'admins'));
    }

    public function assigned()
    {
        
        $usersProductsDetail = DB::table('products')
                    ->join('user_products','products.id','=', 'user_products.product_id')
                     ->leftjoin('admins' , 'user_products.business_builder' , '=','admins.id')
                    ->select('*')->get();
        $products=Product::all();
        $users= User::where('users.business_builder_id','!=' ,null)->get();
        $transactions = DB::table('users')
                        ->rightjoin('transactions' , 'users.id' , '=' , 'transactions.member_id')
                        ->rightjoin('user_products' , 'users.ibm' , '=' , 'user_products.user_ibm')
                        ->leftjoin('products' , 'user_products.product_id' , '=' , 'products.id')
                        ->where('users.business_builder_id','!=' ,null)
                        ->get();
        $commissions = Commission::all();
        $admins = Admin::permission('is-business-builder')->where('id' , '!=' ,Auth::user()->id)->get();

        return view('admin.subscribed_members' , compact('usersProductsDetail' , 'products' , 'users', 'transactions' ,'commissions', 'admins'));
    }

    public function unassigned()
    {
        
        $usersProductsDetail = DB::table('products')
                    ->join('user_products','products.id','=', 'user_products.product_id')
                     ->leftjoin('admins' , 'user_products.business_builder' , '=','admins.id')
                    ->select('*')->get();
        $products=Product::all();
        $users= User::where('users.business_builder_id','=' ,null)->get();
        $transactions = DB::table('users')
                        ->rightjoin('transactions' , 'users.id' , '=' , 'transactions.member_id')
                        ->rightjoin('user_products' , 'users.ibm' , '=' , 'user_products.user_ibm')
                        ->leftjoin('products' , 'user_products.product_id' , '=' , 'products.id')
                        ->where('users.business_builder_id','=' ,null)
                        ->get();
        $commissions = Commission::all();
        $admins = Admin::permission('is-business-builder')->where('id' , '!=' ,Auth::user()->id)->get();

        return view('admin.subscribed_members' , compact('usersProductsDetail' , 'products' , 'users', 'transactions' ,'commissions', 'admins'));
    }

    public function groups()
    {
        
        $usersProductsDetail = DB::table('products')
                    ->join('user_products','products.id','=', 'user_products.product_id')
                     ->leftjoin('admins' , 'user_products.business_builder' , '=','admins.id')
                    ->select('*')->get();
        $products=Product::all();
        $users= User::where('users.scheme_type','=' ,2)->get();
        $transactions = DB::table('users')
                        ->rightjoin('transactions' , 'users.id' , '=' , 'transactions.member_id')
                        ->rightjoin('user_products' , 'users.ibm' , '=' , 'user_products.user_ibm')
                        ->leftjoin('products' , 'user_products.product_id' , '=' , 'products.id')
                        ->where('users.scheme_type','=' ,2)
                        ->get();
        $commissions = Commission::all();
        $admins = Admin::permission('is-business-builder')->where('id' , '!=' ,Auth::user()->id)->get();

        return view('admin.subscribed_members' , compact('usersProductsDetail' , 'products' , 'users', 'transactions' ,'commissions', 'admins'));
    }

    
}
