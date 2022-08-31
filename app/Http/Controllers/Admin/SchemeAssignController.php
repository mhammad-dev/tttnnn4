<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User\User;
use App\Models\Product;
use Auth;
use DB;

class SchemeAssignController extends Controller
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
        $validator = $this->validateScheme($requestData);
        
        if($validator->fails())
        {
            return response()->json(['error' => 'Please Select the type']);
        }

        
        $ibm = $request->hiddenibm;
        DB::table('users')
            ->where('ibm' , '=' , $ibm)
            ->update([
                'scheme_type' => $request->scheme_type,
            ]);
        

    return response()->json(['success' => 'Scheme is Assigned Successfully']);
    }

    public function validateScheme(array $data)
    {
            $validator = Validator::make($data, [
            'scheme_type' => 'required | not_in:0',   
            ]);
        

        return $validator;
    }
    
}
