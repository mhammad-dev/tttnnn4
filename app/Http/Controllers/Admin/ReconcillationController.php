<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User\User;
use App\Models\SubscribedUser;
use DB;

class ReconcillationController extends Controller
{
    public function index(){
        return view('admin.reconcile');
    }

    public function getUsers(){
        $user = User::all();
        return $user;
    }   

    public function getListNumber(User $user){
        // if($user->is_root == 1 ){
        //     return 1;
        // }



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
        //dd($level->level);
        $level = $levelObj->level + 1;
        return $level;


    }

    public function getPositionOfEven(User $user){
        // dd($user->is_root);
        if($user->is_root== 1){
            return $user;
        }

        // $parentIbm = $user->refer_ibm; //ibm1
        // $parentUser = SubscribedUser::where('child' , '=' , $parentIbm)->first();
        // if($parentIbm == 'IBM1'){
        //     return $parentUser;
        // }

        // $ancesstorUser =  User::where('ibm' , '=' , $parentUser->refer_ibm)->first();
        // if($ancesstorUser->is_root == 1){
        //     return $ancesstorUser ;
        // }

        $ps = SubscribedUser::where('child' , '=' , $user->refer_ibm)->first();
        return $ps;


        // $ancesstorRef = User::where('refer_ibm' , '=' , $ancesstorUser->ibm)->get();
        // $ancesstorRefCount = $ancesstorRef->count();
        // if(($ancesstorRefCount+1)%2 == 0){

        //     return $this->getPositionOfEven($parentUser);
        // }
        // else{

        //      return $parentUser; 
        // } 

    }

    public function preReconcillation(){
        SubscribedUser::truncate();
         $users = $this->getUsers();
         foreach($users as $user){
            $this->reconcillation($user);
        }
    }

    public function reconcillation(User $user){

       if($user->is_root == 1){
             // $subscribedUser = new SubscribedUser;
             // $subscribedUser->parent = $user->ibm;
             // $subscribedUser->child = $user->ibm;
             // $subscribedUser->level = '1';
             // $subscribedUser->save();
             return;
       }

       $list_num = $this->getListNumber($user);
       if($list_num%2 == 0){

             $userParentIbm="IBM1";
             $userParent = $this->getPositionOfEven($user);
             if(!empty($userParent)){ $userParentIbm = $userParent->parent; }
             $subscribedUser = new SubscribedUser;
             $subscribedUser->parent = $userParentIbm;             
             $subscribedUser->child = $user->ibm;
             if($user->is_root== 1 || $user->refer_ibm == 'IBM1'){
                $subscribedUser->level = '1';
             }
             else{
                $subscribedUser->level = $this->getLevel($user);
             }
             
             $subscribedUser->save();

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
         return;
       
       }
        
    }

    

   
}
