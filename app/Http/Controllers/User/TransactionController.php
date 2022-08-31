<?php

namespace App\Http\Controllers\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\UserProduct;
use Auth;
use DB;
use Carbon\Carbon;
class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        //dd(DB::table('user_product')->get());
        $id = Auth::user()->id;
        //$transactions = Transaction::where('member_id' , '=' , $id)->get();

        $transactions = DB::table('users')
                        ->join('user_products' , 'users.ibm' , '=' ,'user_products.user_ibm')
                        ->join('products' , 'user_products.product_id' , '=' ,'products.id')
                        ->join('transactions' , 'users.id' , '=' , 'transactions.member_id')
                        ->where('users.id' , '=' ,$id)
                        ->get();
        //dd($transactions);
        //dd($transactions);
        // $risk_amt_sum = Transaction::where('member_id' , '=' , $id)->sum('risk_amt_ex_vat');
        // $comm_with_vat_sum= Transaction::where('member_id' , '=' , $id)->sum('comm_fee_ex_vat');
        // $risk_amt_sum =number_format((float)$risk_amt_sum, 2, '.', '');
        // $comm_with_vat_sum =number_format((float)$comm_with_vat_sum, 2, '.', '');
        $total_transactions = Transaction::where('member_id' , '=' , $id)->sum('risk_amt_ex_vat');


        return view('user.transactions', compact('transactions' ,'total_transactions'));
    }

    public function searchTransaction(Request $request){
        if($request->ajax()){
            if(!empty($request->fromdate) && empty($request->todate)){
                $toDate = Carbon::today();
                $toDate = $toDate->toDateString();
                $fromDate = $request->fromdate;

                //dd('toDate : '.$toDate.' fromDate : '.$fromDate);
               
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
            $id = Auth::user()->id;

            $data = DB::table('users')
                        ->rightjoin('transactions' , 'users.id' , '=' , 'transactions.member_id')
                        ->rightjoin('user_products' , 'users.ibm' , '=' , 'user_products.user_ibm')
                        ->leftjoin('products' , 'user_products.product_id' , '=' , 'products.id')
                        ->where('users.id' , '=' ,$id)
                        ->whereBetween('transactions.created_at' , [$fromDate." 00:00:00" , $toDate." 23:59:59"])->get();
                
            $total_transactions = Transaction::where('member_id' , '=' , $id)->whereBetween('transactions.created_at' , [$fromDate." 00:00:00" , $toDate." 23:59:59"])->sum('risk_amt_ex_vat');

            $totalRows =  $data->count();
            // dd($total_transactions);
            if($totalRows>0){
                foreach($data as $key => $row){
                    $output .= '<tr>
                                    <td>'.date('d F Y', strtotime($row->created_at)).'</td>
                                    <td>'.substr(str_repeat(0, 7).$row->id, - 7).'</td>
                                    <td>$row->product_name</td>
                                    <td>'.$row->policy_no.'</td>
                                    <td>'.$row->risk_amt_ex_vat.'</td>
                                    <td>'.$row->status.'</td>  
                                </tr> ';
                }
            }
            else{
                $output = '<tr class="odd"><td valign="top" colspan="6" class="dataTables_empty">No data available</td></tr>';
            }

            $data = array(
             'transaction_data'  => $output,
             'total_transactions'=> $total_transactions
            );  
            return json_encode($data);

        }
        
    }
}
