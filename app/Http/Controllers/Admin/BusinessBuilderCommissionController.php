<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Commission;
use App\Models\Admin\Admin;
use Carbon\Carbon;
use Auth;
use PDF;
use App;
use DB;
use DateTime;

class BusinessBuilderCommissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function index()
    {
        return view('admin.commissions.businessbuilder-commissions');
    }

    public function searchCommission(Request $request){
        if($request->ajax()){
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
            $risk_amt_sum=0;
            $total_comm = 0;
            $id = Auth::user()->id;
            $data = DB::table('commissions')
                    ->leftjoin('user_products' , 'user_products.user_ibm', '=' ,'commissions.referral')
                    ->where('user_products.business_builder' , '=' , '14')
                    ->where('commissions.bb_fee' , '!=' , '0.0')
                    ->whereBetween('created_at' , [$fromDate." 00:00:00" , $toDate." 23:59:59"])->get();   
            $totalRows =  $data->count();
            if($totalRows>0){
                foreach($data as $key => $row){
                    $output .= '<tr>
                                   <td>'.++$key.'</td>
                                   <td>'.$row->referral.'</td>
                                   <td>'.$row->level.'</td>
                                   <td>'.$row->risk_premium_paid.'</td>
                                   <td>'.$row->bb_fee.'</td>
                                   <td>'.date('d F Y', strtotime($row->created_at)).'</td>
                                </tr>';
                }
            }
            else{
                $output = '<tr class="odd"><td valign="top" colspan="6" class="dataTables_empty">No data available</td></tr>';
            }

            $total_comm= DB::table('commissions')
                    ->leftjoin('user_products' , 'user_products.user_ibm', '=' ,'commissions.referral')
                    ->where('user_products.business_builder' , '=' , '14')
                    ->where('commissions.bb_fee' , '!=' , '0.0')
                    ->whereBetween('created_at' , [$fromDate." 00:00:00" , $toDate." 23:59:59"])->sum('commissions.bb_fee');
            $total_comm =number_format((float)$total_comm, 2, '.', '');

            $data = array(
             'commission_data'  => $output,
             'total_comm'       => $total_comm  
            );
            return json_encode($data);

        }
        
    }

/*    public function downloadCommission(Request $request){
        $daysInterval='';
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
                $datetime1 = new DateTime($fromDate);
                $datetime2 = new DateTime($toDate);
                $interval = $datetime1->diff($datetime2);
                $daysInterval = $interval->format('%a');
            }
            else{
                $toDate = Carbon::today();
                $toDate = $toDate->toDateString();
                $fromDate =Carbon::today()->subDays(30);
                $fromDate = $fromDate->toDateString();
            }

            $ibm = Auth::user()->ibm;
            $id = Auth::user()->id;
            $data = DB::table('users')
                    ->rightjoin('commissions' , 'users.ibm' , '=' , 'commissions.referral')
                    ->where('commissions.sponsor' , '=' , $ibm)
                    ->whereBetween('commissions.created_at' , [$fromDate." 00:00:00" , $toDate." 23:59:59"])->get();
          
            $total_comm= Commission::where('sponsor' , '=' , $ibm)->whereBetween('created_at' , [$fromDate." 00:00:00" , $toDate." 23:59:59"])->sum('commission_paid');

            $levels = Commission::where('sponsor' , '=' , $ibm)
                       ->whereBetween('created_at' , [$fromDate." 00:00:00" , $toDate." 23:59:59"])->max('level');

            // dd($levels);
            $user = User::where('id' , '=' ,$id)->first();
           $pdf = PDF::loadView('download' , compact('data' , 'user' , 'levels','total_comm','daysInterval'));
           return $pdf->download('commission_report.pdf');
    }*/

    public function downloadView(){
        // if(!empty($request->fromdate) && empty($request->todate)){
        //         $toDate = Carbon::today();
        //         $toDate = $toDate->toDateString();
        //         $fromDate = $request->fromdate;
               
        //     }
        //     elseif(empty($request->fromdate) && !empty($request->todate)){
        //         $toDate = $request->todate;
        //         $fromDate =Carbon::today()->subDays(30);
        //         $fromDate = $fromDate->toDateString();
        //     }
        //     elseif(!empty($request->fromdate) && !empty($request->todate)){
        //         $toDate = $request->todate;
        //         $fromDate =$request->fromdate;
        //     }
        //     else{
        //         $toDate = Carbon::today();
        //         $toDate = $toDate->toDateString();
        //         $fromDate =Carbon::today()->subDays(30);
        //         $fromDate = $fromDate->toDateString();
        //     }
        // $ibm = Auth::user()->ibm;
        //  $data = Commission::where('sponsor' , '=' , $ibm)
        //             ->whereBetween('created_at' , [$fromDate." 00:00:00" , $toDate." 23:59:59"])->get();
        // $user = User::where('ibm' , '=' ,$ibm)->first();
        return view('download');
    }
}
