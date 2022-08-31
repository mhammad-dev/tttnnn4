<?php

namespace App\Http\Controllers\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Commission;
use App\Models\User\User;
use App\Models\Product;
use Carbon\Carbon;
use Auth;
use PDF;
use App;
use DB;
use DateTime;

class GroupProfitEarnedController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        
        return view('user.group-profit-earned.index');
    }

    public function searchProfit(Request $request){
        if($request->ajax()){
            //dd(!empty($request->fromdate));
            if(!empty($request->fromdate) && empty($request->todate)){
                $toDate = Carbon::today();
                $toDate = $toDate->toDateString();
                $fromDate = $request->fromdate;

               
            }
            elseif(empty($request->fromdate) && !empty($request->todate)){
                $toDate = $request->todate;
                $fromDate =Carbon::today()->subDays(30);
                $fromDate = $fromDate->toDateString();
            }
            elseif(!empty($request->fromdate) && !empty($request->todate)){
                $toDate = $request->todate;
                $fromDate =$request->fromdate;
            }
            else{
                $toDate = Carbon::today();
                $toDate = $toDate->toDateString();
                $fromDate =Carbon::today()->subDays(30);
                $fromDate = $fromDate->toDateString();
            }

            $output = '';
            $total_premium=0;
            $total_profit_earned = 0;
            $total_products =0;
            $ibm = Auth::user()->ibm;
            $id = Auth::user()->id;
            $data = $data = DB::table('products')
                    ->leftjoin('commissions' , 'products.id' , '=' , 'commissions.product_id')
                    ->where('products.intermediary' , '=' , $id)
                    ->where('commissions.product_group_scheme_profit', '!=' , null)
                    ->whereBetween('commissions.created_at' , [$fromDate." 00:00:00" , $toDate." 23:59:59"])->get();
            // dd($data);
            $totalRows =  $data->count();
            // dd($totalRows);
            if($totalRows>0){
                foreach($data as $key => $row){
                    $output .= '<tr>
                                   <td>'.++$key.'</td>
                                   <td>'.$row->referral.'</td>
                                   <td>'.$row->level.'</td>
                                   <td>'.$row->risk_premium_paid.'</td>
                                   <td>'.$row->product_group_scheme_profit.'</td>
                                   <td>'.$row->product_name.'</td>
                                   <td>'.date('d F Y', strtotime($row->created_at)).'</td>
                                </tr>';
                }
            }
            else{
                $output = '<tr class="odd"><td valign="top" colspan="6" class="dataTables_empty">No data available</td></tr>';
            }

            $total_products = Product::where('intermediary' , '=' , $id)->whereBetween('created_at' , [$fromDate." 00:00:00" , $toDate." 23:59:59"])->count();
            $total_premium= DB::table('products')
                    ->leftjoin('commissions' , 'products.id' , '=' , 'commissions.product_id')
                    ->where('products.intermediary' , '=' , $id)
                    ->where('commissions.product_group_scheme_profit', '!=' , null)->whereBetween('commissions.created_at' , [$fromDate." 00:00:00" , $toDate." 23:59:59"])->sum('risk_premium_paid');
            $total_profit_earned = DB::table('products')
                    ->leftjoin('commissions' , 'products.id' , '=' , 'commissions.product_id')
                    ->where('products.intermediary' , '=' , $id)
                    ->where('commissions.product_group_scheme_profit', '!=' , null)
                    ->whereBetween('commissions.created_at' , [$fromDate." 00:00:00" , $toDate." 23:59:59"])->sum('product_group_scheme_profit');
            $total_profit_earned =number_format((float)$total_profit_earned, 2, '.', '');
            $total_premium =number_format((float)$total_premium, 2, '.', '');

            $data = array(
             'group_profit_earned_data'  => $output,
             'total_products'  => $total_products,
             'total_premium'     => $total_premium,
             'total_profit_earned'       => $total_profit_earned  
            );
            return json_encode($data);

        }
        
    }

    
}
