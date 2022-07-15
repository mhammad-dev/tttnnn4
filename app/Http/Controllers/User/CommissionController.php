<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Commission;
use Auth;
class CommissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $ibm = Auth::user()->ibm;
        $id = Auth::user()->id;
        $commissions = Commission::where('sponsor' , '=' , $ibm)->get();
        $risk_amt_sum = Commission::where('sponsor' , '=' , $ibm)->sum('risk_premium_paid');
        $total_comm= Commission::where('sponsor' , '=' , $ibm)->sum('commission_paid');
        $risk_amt_sum =number_format((float)$risk_amt_sum, 2, '.', '');
        $total_comm =number_format((float)$total_comm, 2, '.', '');
        return view('user.commissions.index' , compact('commissions' , 'risk_amt_sum' ,'total_comm'));
    }
}
