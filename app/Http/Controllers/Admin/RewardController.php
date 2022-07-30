<?php

namespace App\Http\Controllers\Admin;

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
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $toDate = Carbon::today();
        $toDate = $toDate->toDateString();
        $fromDate =Carbon::today()->subDays(30);
        $fromDate = $fromDate->toDateString();
        $ibm = $request->ibm;
        $level = SubscribedUser::where('parent' , '=' ,$ibm)->max('level');
        $total_comm = Commission::select('level', DB::raw('sum(commission_paid) as commission'))->where('sponsor' , '=' , $ibm)->whereBetween('commissions.created_at' , [$fromDate." 00:00:00" , $toDate." 23:59:59"])->groupBy('level')->get();
        $data = DB::table('users')
                ->leftjoin('products' , 'users.product_id' , '=' ,'products.product_id')
                ->rightjoin('subscribed_users' , 'users.ibm' , '=' , 'subscribed_users.child')
                ->rightjoin('commissions' , 'users.ibm' , '=' ,'commissions.referral')
                ->where('subscribed_users.parent','=' ,$ibm)
                ->whereBetween('commissions.created_at' , [$fromDate." 00:00:00" , $toDate." 23:59:59"])->get();
        
        return view('admin.member_rewards' , compact('data' , 'level' , 'total_comm'));
    }


    
}
