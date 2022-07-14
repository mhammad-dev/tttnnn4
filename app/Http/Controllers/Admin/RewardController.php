<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\User;
use Auth;
use App\Models\SubscribedUser;
use DB;

class RewardController extends Controller
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
    public function index(Request $request)
    {
        //dd($request->ibm);
       // dd(Auth::user('admin'));
        $ibm = $request->ibm;
        $level = SubscribedUser::where('parent' , '=' ,$ibm)->max('level');
       // $data = SubscribedUser::where('parent' , '=' , $ibm)->get();
        $data = DB::table('users')
                ->leftjoin('products' , 'users.product_id' , '=' ,'products.product_id')
                ->rightjoin('subscribed_users' , 'users.ibm' , '=' , 'subscribed_users.child')
                ->where('subscribed_users.parent','=' ,$ibm)->get();
        
        
       // $user = $user[0];
        //dd($data);
        return view('admin.member_rewards' , compact('data' , 'level'));
    }


    
}
