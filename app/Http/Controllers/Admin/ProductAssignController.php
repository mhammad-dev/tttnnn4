<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User\User;
use App\Models\Product;
use Auth;
use DB;

class ProductAssignController extends Controller
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

    public function store(Request $request){

        $requestData = $request->All();
        $validator = $this->validateProduct($requestData);
        if($validator->fails())
        {
            return response()->json(['error' => 'Required fields cannot be empty or policy number already exists']);
        }

        
        $ibm = $request->hiddenibm;
        if($request->member_intention == 2){
            DB::table('users')
            ->where('ibm' , '=' , $ibm)
            ->update([
                'member_intention' => $request->member_intention,
            ]);
        }

        else{

        $exists = DB::table('user_products')
                    ->where('product_id' , '=' , $request->product_name)
                    ->where('user_ibm' , '=' , $ibm)
                    ->exists();
        if($exists){
            return response()->json(['error' => 'Product is Assigned Already']);
        }
        
        $response= DB::table('user_products')->insert([
                'user_ibm'   => $ibm,
                'product_id' => $request->product_name,
                'policy_no'  => $request->provider_policy_number,
                'premium_amount'    => $request->premium_amount,
                'business_builder' => Auth::user()->id,
        ]);
    

        if($response){
            DB::table('users')
            ->where('ibm' , '=' , $ibm)
            ->update([
                'member_intention' => $request->member_intention,
                'identification_number'=> $request->identification_number,
            ]);
        }
    }

    return response()->json(['success' => 'Product is Assigned Successfully']);
    }

    public function validateProduct(array $data)
    {
        if($data['member_intention']==2){
            $validator = Validator::make($data, [
            'member_intention' => 'required | not_in:0'
            ]);
        }
        else{
            $validator = Validator::make($data, [
            'product_name' => 'required | not_in:0',
            'provider_policy_number' => 'required | unique:user_products,policy_no',
            'identification_number' => 'required',
            'member_intention' => 'required | not_in:0'
        
            ]);
        }
        

        return $validator;
    }
    
}
