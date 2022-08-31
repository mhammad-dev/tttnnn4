<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin\Admin;
use App\Models\Product;
use Auth;
use DB;

class BBAssignController extends Controller
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
        $ibm = $request->hiddenibm;
        $validator = $this->validateBB($requestData);
        
        if($validator->fails())
        {
            return response()->json(['error' => 'Please Select the type']);
        }

        $exists = DB::table('users')
                    ->where('ibm' , '=' , $ibm)
                    ->where('business_builder_id' , '=' , $request->bb_selection)
                    ->exists();
        if($exists){
            return response()->json(['error' => 'This business builder is already assigned']);
        }

        $response = DB::table('users')
            ->where('ibm' , '=' , $ibm)
            ->update(['business_builder_id' => $request->bb_selection]);
            
        
        if($response){
            return response()->json(['success' => 'Business Builder is Assigned Successfully']);
        }

        return response()->json(['error' => 'Something bad is happened']);
    }

    public function validateBB(array $data)
    {
            $validator = Validator::make($data, [
            'bb_selection' => 'required | not_in:0',   
            ]);
        

        return $validator;
    }
    
}
