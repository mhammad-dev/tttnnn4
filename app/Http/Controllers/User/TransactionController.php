<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Auth;
class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $id = Auth::user()->id;
        $transactions = Transaction::where('member_id' , '=' , $id)->get();
        $risk_amt_sum = Transaction::where('member_id' , '=' , $id)->sum('risk_amt_ex_vat');
        $comm_with_vat_sum= Transaction::where('member_id' , '=' , $id)->sum('comm_fee_ex_vat');
        $risk_amt_sum =number_format((float)$risk_amt_sum, 2, '.', '');
        $comm_with_vat_sum =number_format((float)$comm_with_vat_sum, 2, '.', '');
        return view('user.transactions', compact('transactions' , 'risk_amt_sum' ,'comm_with_vat_sum'));
    }
}
