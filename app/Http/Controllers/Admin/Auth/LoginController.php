<?php

namespace App\Http\Controllers\Admin\Auth;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Providers\RouteServiceProvider;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $guard = 'admin';

    protected $redirectTo = 'admin/home';

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }


    protected function guard(){
        return Auth::guard('admin');
    }
}