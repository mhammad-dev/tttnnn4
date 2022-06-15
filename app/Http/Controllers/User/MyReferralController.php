<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\User;
use Auth;

class MyReferralController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $auth_ibm=Auth::user()->ibm;
        $data=User::where('refer_ibm' , '=' , $auth_ibm)->get();
        //dd($data);
        return view('user.myreferral', compact('data'));
    }

    
}
