<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\TempTransaction;
use App\Models\Transaction;
use App\Models\User\User;


class TempTransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    
    public function index()
    {
        $transactions = TempTransaction::paginate();

        return view('admin.transactions.confirmation', compact('transactions'));
    }

    public function getMemberId($id_no){
        $memberId = User::where('identification_number' , '=' , $id_no)->first();
        //dd($memberId);
        if(!empty($memberId)){
            return $memberId->id;
        }
        return;
    }
        

    public function confirm()
    {
        $tempTransactions = TempTransaction::all();
        //dd(count($tempTransactions));
       
        foreach($tempTransactions as  $tempTransaction){
             $transactions = new Transaction();     
            $transactions->member_id = $this->getMemberId($tempTransaction->identification_no);
            $transactions->identification_no = $tempTransaction->identification_no;
            $transactions->description = $tempTransaction->description;
            $transactions->policy_no = $tempTransaction->policy_no;
            $transactions->status = $tempTransaction->status;
            $transactions->title = $tempTransaction->title;
            $transactions->initials = $tempTransaction->initials;
            $transactions->client = $tempTransaction->client;
            $transactions->risk_amt_ex_vat = $tempTransaction->risk_amt_ex_vat;
            $transactions->comm_fee_ex_vat = $tempTransaction->comm_fee_ex_vat;
            $transactions->comm_fee_vat = $tempTransaction->comm_fee_vat;
            $transactions->balance_brought_forward_ex_vat = $tempTransaction->balance_brought_forward_ex_vat;
            $transactions->total_owed_ex_vat = $tempTransaction->total_owed_ex_vat;
            $transactions->total_paid_ex_vat = $tempTransaction->total_paid_ex_vat;
            $transactions->balance_carried_forward_ex_vat = $tempTransaction->balance_carried_forward_ex_vat;
            $transactions->save(); 
        }

            

        TempTransaction::truncate();

        return redirect()->route('transactions.index')->with('success', 'Import finished.');

    }

    public function rollback(){
        TempTransaction::truncate();
         return redirect()->route('transactions.index')->with('success', 'Data is rolled back.');
    }
}
