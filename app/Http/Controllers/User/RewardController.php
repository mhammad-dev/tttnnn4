<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\User;
use Auth;
use App\Models\SubscribedUser;
use App\Models\Commission;
use DB;
use Carbon\Carbon;

class RewardController extends Controller
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
        $toDate = Carbon::today();
        $toDate = $toDate->toDateString();
        $fromDate =Carbon::today()->subDays(30);
        $fromDate = $fromDate->toDateString();

        $ibm = Auth::user()->ibm;
        $level = SubscribedUser::where('parent' , '=' ,$ibm)->max('level');
        $total_comm = Commission::select('level', DB::raw('sum(commission_paid) as commission'))->where('sponsor' , '=' , $ibm)->whereBetween('commissions.created_at' , [$fromDate." 00:00:00" , $toDate." 23:59:59"])->groupBy('level')->get();
        
        $data = DB::table('users')
                ->rightjoin('user_products' , 'users.ibm' , '=' , 'user_products.user_ibm')
                ->rightjoin('products' , 'user_products.product_id' , '=' ,'products.id')
                ->rightjoin('subscribed_users' , 'users.ibm' , '=' , 'subscribed_users.child')
                ->rightjoin('commissions' , 'users.ibm' , '=' ,'commissions.referral')
                ->where('subscribed_users.parent','=' ,$ibm)
                ->whereBetween('commissions.created_at' , [$fromDate." 00:00:00" , $toDate." 23:59:59"])->get();
        return view('user.rewards' , compact('data' , 'level' , 'total_comm'));
    }


    
}
