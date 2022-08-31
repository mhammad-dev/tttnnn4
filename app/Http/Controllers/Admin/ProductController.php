<?php
    
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User\User;
use DB;

class ProductController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','store']]);
         $this->middleware('permission:product-create', ['only' => ['create','store']]);
         $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $data = Product::orderBy('id','DESC')->get();
        return view('admin.products.index',compact('data'))
            ->with('i', (0));
    }

     public function create()
    {
        $groups = User::where('scheme_type' , '=' , '2')->get();
        return view('admin.products.create' , compact('groups'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'product_name' => 'required',
            'product_description' => 'required',
        ]);
        // Premium - (24% + 4 % + 12% + Administrator admin fee)
        $input = $request->all();

        $premium = $input['premium'];
        $rewardsCommission = $input['rewards_commission_for_advertiser'];
        $adminFee = $input['admin_fee'];
        $bbFee =$input['bb_fee'];
        $administratorFee = $input['administrator_fee'];
        $groupSchemeProfit = $premium - ((($premium/100)*$rewardsCommission)+(($premium/100)*$adminFee)+(($premium/100)*$bbFee)+$administratorFee);
        $input['group_scheme_profit'] = $groupSchemeProfit;
        $product = Product::create($input);
        return redirect()->route('products.index')
                        ->with('success','Product created successfully');
    }

    public function show($id)
    {
        $product = Product::find($id);
        return view('admin.products.show',compact('product'));
    }
    
    public function edit($id)
    {
        $groups = User::where('scheme_type' , '=' , '2')->get();
        $product = Product::find($id);
        return view('admin.products.edit', compact('product' , 'groups'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'product_name' => 'required',
            'product_description' => 'required',
        ]);
    
        $input = $request->all();
        $premium = $input['premium'];
        $rewardsCommission = $input['rewards_commission_for_advertiser'];
        $adminFee = $input['admin_fee'];
        $bbFee =$input['bb_fee'];
        $administratorFee = $input['administrator_fee'];
        $groupSchemeProfit = $premium - ((($premium/100)*$rewardsCommission)+(($premium/100)*$adminFee)+(($premium/100)*$bbFee)+$administratorFee);
        $input['group_scheme_profit'] = $groupSchemeProfit;
        $product = Product::find($id);
        $product->update($input);
        return redirect()->route('products.index')
                        ->with('success','Product updated successfully');
    }
    

    public function destroy($id)
    {
        Product::find($id)->delete();
        return redirect()->route('products.index')
                        ->with('success','Product deleted successfully');
    }
}