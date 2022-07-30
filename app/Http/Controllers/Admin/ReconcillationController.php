<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User\User;
use App\Models\SubscribedUser;
use App\Models\Commission;
use App\Models\Transaction;
use DB;

class ReconcillationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    
    public function index(){
        return view('admin.reconcile');
    }

    public function getCommissionInPercent($ibm){
        $sponsor = User::where('ibm' , '=' , $ibm )->first();
             if($sponsor->member_intention == 1){
                return $commision_in_percent = 5;
             }
             return $commision_in_percent = 2.5;
    }

    public function getTransactions($month , $year){
        $transactions =  Transaction::select('identification_no', 
                        DB::raw(
                           'sum(risk_amt_ex_vat) as risk_amt_ex_vat , sum(comm_fee_vat) as comm_fee_vat ,sum(comm_fee_ex_vat) as comm_fee_ex_vat , sum(balance_brought_forward_ex_vat) as balance_brought_forward_ex_vat , sum(total_owed_ex_vat) as total_owed_ex_vat, sum(total_paid_ex_vat) as total_paid_ex_vat ,sum(balance_carried_forward_ex_vat) as balance_carried_forward_ex_vat' )
                        )
                        ->whereMonth('created_at' , '=' , $month)
                        ->whereYear('created_at' ,'=' , $year)
                        ->groupBy('identification_no')->get();
        //dd($transactions);

        return $transactions;
    }   

    public function getListNumber(User $user){
       
        $ref_ibm = $user->refer_ibm;
        $members = User::where('refer_ibm' , '=' , $ref_ibm)->get();
        foreach ($members as $key => $member) {
            if($member->ibm == $user->ibm){
                return $key+1;
            }
        }
    }

    public function getLevel(User $user){
        $level = 0;
        $levelObj = SubscribedUser::select('level')->where('child' , '=' , $user->refer_ibm)->first();
        $level = $levelObj->level + 1;
        return $level;
    }



    public function getPositionOfEven(User $user){
        if($user->is_root== 1){
            return $user;
        }

        $position = SubscribedUser::where('child' , '=' , $user->refer_ibm)->first();
        return $position;

    }

    public function reconcillation(Request $request){
        $flag = true;
        $date = $request->txtDate;
        $date = date('m-Y', strtotime($date));
        $new = explode('-', $date);
        $month = $new[0];
        $year = $new[1];

        //THESE LINES WILL BE DELETED IN FUTURE ONLY FOR TESTING PURPOSE
        
        SubscribedUser::truncate();
        Commission::truncate();

        //ABOVE LINES WILL BE DELETED IN FUTURE ONLY FOR TESTING PURPOSE

        $transactions = $this->getTransactions($month , $year);
        if($transactions->isEmpty()){
            return response()->json(['msg' => 'Transaction not found']);
        }
        foreach($transactions as $transaction){
           
            $user = User::where('identification_number' , '=' ,$transaction->identification_no)->first();
            if(!empty($user)){
                $this->postReconcillation($user , $transaction->risk_amt_ex_vat);
            }
        }
        return response()->json(['msg' => 'Reconcilled Successfully']);
    }

    public function postReconcillation(User $user , $risk_amt_ex_vat){
       $level=1;
       // $risk_prem_paid = Transaction::select('risk_amt_ex_vat')->where('member_id' , '=' , $user->id)->first();
       // $risk_prem_paid= $risk_prem_paid->risk_amt_ex_vat;
       if($user->is_root == 1){
             return;
       }

       $list_num = $this->getListNumber($user);
       if($list_num%2 == 0){

             $userParentIbm="IBM1";
             $userParent = $this->getPositionOfEven($user);
             if(!empty($userParent))
             { 
                $userParentIbm = $userParent->parent;
             }
             $subscribedUser = new SubscribedUser;
             $subscribedUser->parent = $userParentIbm;             
             $subscribedUser->child = $user->ibm;
             if($user->is_root== 1 || $user->refer_ibm == 'IBM1'){
                $subscribedUser->level = '1';
             }
             else{
                $level = $this->getLevel($user);
                $subscribedUser->level = $level;
             }
             
             $subscribedUser->save();

             // COMMISSION CALCULATION START

             $commision_in_percent = $this->getCommissionInPercent($userParentIbm);
             $commission = new Commission();
             $commission->sponsor = $userParentIbm;
             $commission->referral= $user->ibm;
             $commission->level = $level;
             $commission->risk_premium_paid = $risk_amt_ex_vat;
             $commission->commission_paid = ($risk_amt_ex_vat/100)*$commision_in_percent;
             $commission->commission_paid_percent = $commision_in_percent;
             $commission->save(); 

             // COMMISSION CALCULATION END

            

             DB::table('users')
                ->where('ibm', $user->ibm)
                ->update(['passed_up_to' => $userParentIbm]);
             return;   
       }
       else{
        $subscribedUser = new SubscribedUser;
        $subscribedUser->parent = $user->refer_ibm;
        $subscribedUser->child = $user->ibm;
        $subscribedUser->level = '1';
        $subscribedUser->save();

        // COMMISSION CALCULATION START
                
            $commision_in_percent = $this->getCommissionInPercent($user->refer_ibm);
            $commission = new Commission();
            $commission->sponsor = $user->refer_ibm;
            $commission->referral= $user->ibm;
            $commission->level = $level;
            $commission->risk_premium_paid = $risk_amt_ex_vat;
            $commission->commission_paid = ($risk_amt_ex_vat/100)*$commision_in_percent;
            $commission->commission_paid_percent = $commision_in_percent;
            $commission->save(); 

        // COMMISSION CALCULATION END
        return;
       
       }
        
    }

    

   
}
