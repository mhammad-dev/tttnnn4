<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\User;
use Auth;
use App\Models\SubscribedUser;

class RewardController extends Controller
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
        $ibm = Auth::user()->ibm;
        $level = SubscribedUser::where('parent' , '=' ,$ibm)->max('level');
        $data = SubscribedUser::where('parent' , '=' , $ibm)->get();
        //dd($data);
        return view('user.rewards' , compact('data' , 'level'));
    }

    
}
