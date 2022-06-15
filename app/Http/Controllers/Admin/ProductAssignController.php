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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function index()
    // {
    //     $data= User::all();
    //     $products=Product::all();
    //     return view('admin.mymembers' , compact('data' , 'products'));
    // }

    public function store(Request $request){

         $requestData = $request->All();
         $validator = $this->validateProduct($requestData);

        if($validator->fails())
        {
        
            return response()->json(['error' => 'Kindly Select the product.']);
        }

        $policy_num= Product::where('product_id' ,'!=' ,'NULL')->count();
        $policy_num= "CNN00000".$policy_num;

        $ibm = $request->hiddenibm;
        $product = $request->product;
        DB::table('users')
            ->where('ibm' , '=' , $ibm)
            ->update([
                'product_id' => $product,
                'identification_number'=> $request->identification_no,
                'provider_policy_number' => $provider_policy_num,
                'premium_amount' => $request->premium_amount,
            ]);
        return response()->json(['success' => 'Product is Assigned Successfully']);
    }

    public function validateProduct(array $data)
    {
        $validator = Validator::make($data, [
            'product' => 'required | not_in:0',
            'identification_no' => 'required'
        
        ]);

        return $validator;
    }

    
}
