<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TempTransaction;
use App\Models\User\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    public function index()
    {

        return view('admin.transactions.index');
    }

    public function addTrans(){
        $users =  User::whereNotNull(['identification_number' , 'policy_number' ])->get();
        return view('admin.transactions.dummy' , compact('users'));
    }


    public function store(Request $request){
        $ibm = $request->user_ibm;
        // dd($data);
        $user = User::where('ibm','=',$ibm)->first();
        $transactions = new Transaction();     
            $transactions->member_id = $user->id;
            $transactions->identification_no = $user->identification_number;
            $transactions->description = $request->description;
            $transactions->policy_no = $user->policy_number;
            $transactions->status = 'Active';
            $transactions->title = 'Mr';
            $transactions->initials = $user->name;
            $transactions->client =  $user->surname;
            $transactions->risk_amt_ex_vat = $request->risk_amt_ex_vat ;
            $transactions->comm_fee_ex_vat = $request->comm_fee_ex_vat;
            $transactions->comm_fee_vat = $request->comm_fee_vat;
            $transactions->balance_brought_forward_ex_vat =$request->balance_brought_forward_ex_vat;
            $transactions->total_owed_ex_vat = $request->total_owed_ex_vat;
            $transactions->total_paid_ex_vat =$request->total_paid_ex_vat;
            $transactions->balance_carried_forward_ex_vat = $request->balance_carried_forward_ex_vat;
            $transactions->save(); 

        return response()->json(['success' => 'Transaction is Added Successfully']);   

    }
}
