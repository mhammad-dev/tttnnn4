<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User\User;
use App\Models\SubscribedUser;
use App\Models\Commission;
use App\Models\Transaction;
use App\Models\Product;
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

    public function checkReferralSubscription(User $user){
         $response = SubscribedUser::where('child' , '=' , $user->refer_ibm)->exists();
         return $response;
    }

    public function checkUserExists(User $user){
        $response = SubscribedUser::where('child' ,'=' ,$user->ibm)->exists();
        return $response;
    }

    public function getProductDetails($policyNo){
        $productDetails = DB::table('user_products')
            ->join('products' , 'user_products.product_id' , '=' , 'products.id')
            ->where('user_products.policy_no' , '=' , $policyNo)
            ->first();

        return $productDetails;
    }

    public function getCommissionInPercent($ibm , $productPolicyNo){
        $sponsor = User::where('ibm' , '=' , $ibm )->first();
        $productDetails = $this->getProductDetails($productPolicyNo);
             if($sponsor->member_intention == 1){
                return $commision_in_percent = $productDetails->rewards_commission_for_buyer;
             }
             return $commision_in_percent = $productDetails->rewards_commission_for_advertiser;
    }

    public function getTransactions($month , $year){
        $transactions =  Transaction::select('identification_no', 'policy_no' ,
                        DB::raw(
                           'sum(risk_amt_ex_vat) as risk_amt_ex_vat , sum(comm_fee_vat) as comm_fee_vat ,sum(comm_fee_ex_vat) as comm_fee_ex_vat , sum(balance_brought_forward_ex_vat) as balance_brought_forward_ex_vat , sum(total_owed_ex_vat) as total_owed_ex_vat, sum(total_paid_ex_vat) as total_paid_ex_vat ,sum(balance_carried_forward_ex_vat) as balance_carried_forward_ex_vat' )
                        )
                        ->whereMonth('created_at' , '=' , $month)
                        ->whereYear('created_at' ,'=' , $year)
                        ->groupBy('policy_no')->get();
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
        if(!empty($levelObj)){
             $level = $levelObj->level + 1;
        }

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

        // $count=0;
        $transactions = $this->getTransactions($month , $year);
        if($transactions->isEmpty()){
            return response()->json(['msg' => 'Transaction not found']);
        }
         // $count = "0";
        foreach($transactions as $transaction){  
            // $count =$count."1";
            $user = User::where('identification_number' , '=' ,$transaction->identification_no)->first();
            if(!empty($user)){
                $this->postReconcillation($user , $transaction->risk_amt_ex_vat , $transaction->policy_no);
            }
        }
        return response()->json(['msg' => 'Reconcilled Successfully']);
    }

    public function postReconcillation(User $user , $risk_amt_ex_vat , $productPolicyNo){
       $level=1;
       if($user->is_root == 1){
             return;
       }

       if(!($this->checkReferralSubscription($user))){
            $userRefer=User::where('ibm' , '=' ,$user->refer_ibm )->first();
            $this->postReconcillation($userRefer , null , null);
       }

       $list_num = $this->getListNumber($user);
       if($list_num%2 == 0){

             $userParentIbm="IBM1";
             $userParent = $this->getPositionOfEven($user);
             if(!empty($userParent))
             { 
                $userParentIbm = $userParent->parent;
             }
             if(!($this->checkUserExists($user))){

             $subscribedUser = new SubscribedUser;
             $subscribedUser->parent = $userParentIbm;             
             $subscribedUser->child = $user->ibm;
             if($user->is_root == 1 || $user->refer_ibm == 'IBM1'){
                $subscribedUser->level = '1';
             }
             else{
                $level = $this->getLevel($user);
                $subscribedUser->level = $level;
             }
             
             $subscribedUser->save();

             }
             // COMMISSION CALCULATION START
             $userProduct = DB::table('user_products')
                                ->where('user_ibm' ,'=',$user->ibm)
                                ->where('policy_no' , '=' , $productPolicyNo)
                                ->select('*')
                                ->first();

            if(!empty($userProduct)){
                $commision_in_percent = $this->getCommissionInPercent($userParentIbm , $userProduct->policy_no);
                $product = Product::where('id' , '=' ,$userProduct->product_id)->first();
                $commission = new Commission();
                $commission->sponsor = $userParentIbm;
                $commission->referral= $user->ibm;
                $commission->level = $level;
                $commission->product_policy_no = $productPolicyNo;
                $commission->product_id = $product->id;
                $commission->risk_premium_paid = $risk_amt_ex_vat;
                $commission->commission_paid = ($risk_amt_ex_vat/100)*$commision_in_percent;
                $commission->commission_paid_percent = $commision_in_percent;
                $commission->administrator_fee = $product->administrator_fee;
                $commission->admin_fee =  ($risk_amt_ex_vat/100)*$product->admin_fee;
                $commission->bb_fee = ($risk_amt_ex_vat/100)*$product->bb_fee;
                if($product->intermediary != 0){
                    $commission->product_group_scheme_profit =  $risk_amt_ex_vat - ((($risk_amt_ex_vat/100)*$product->rewards_commission_for_advertiser)+(($risk_amt_ex_vat/100)*$product->admin_fee)+(($risk_amt_ex_vat/100)*$product->bb_fee)+$product->administrator_fee);
                }
               
                $commission->save();
            }
               
            // COMMISSION CALCULATION END

            if(!($this->checkUserExists($user))){

            DB::table('users')
                ->where('ibm', $user->ibm)
                ->update(['passed_up_to' => $userParentIbm]);
            }

            return;   
       }
       else{
        if(!($this->checkUserExists($user))){
        $subscribedUser = new SubscribedUser;
        $subscribedUser->parent = $user->refer_ibm;
        $subscribedUser->child = $user->ibm;
        $subscribedUser->level = '1';
        $subscribedUser->save();
    }

        // COMMISSION CALCULATION START
            $userProduct = DB::table('user_products')
                                ->where('user_ibm' ,'=',$user->ibm)
                                ->where('policy_no' , '=' , $productPolicyNo)
                                ->select('*')
                                ->first();

            if(!empty($userProduct)){
                $commision_in_percent = $this->getCommissionInPercent($user->refer_ibm , $userProduct->policy_no);
                $product = Product::where('id' , '=' ,$userProduct->product_id)->first();
                $commission = new Commission();
                $commission->sponsor = $user->refer_ibm;
                $commission->referral= $user->ibm;
                $commission->level = $level;
                $commission->product_policy_no = $productPolicyNo;
                $commission->product_id = $product->id;
                $commission->risk_premium_paid = $risk_amt_ex_vat;
                $commission->commission_paid = ($risk_amt_ex_vat/100)*$commision_in_percent;
                $commission->commission_paid_percent = $commision_in_percent;
                $commission->administrator_fee = $product->administrator_fee;
                $commission->admin_fee =  ($risk_amt_ex_vat/100)*$product->admin_fee;
                $commission->bb_fee = ($risk_amt_ex_vat/100)*$product->bb_fee;
                if($product->intermediary != 0){
                    $commission->product_group_scheme_profit =  $risk_amt_ex_vat - ((($risk_amt_ex_vat/100)*$product->rewards_commission_for_advertiser)+(($risk_amt_ex_vat/100)*$product->admin_fee)+(($risk_amt_ex_vat/100)*$product->bb_fee)+$product->administrator_fee);
                }
                $commission->save(); 
            }                      
           // COMMISSION CALCULATION END
        
        return;
       
       }
        
    }

    

   
}
