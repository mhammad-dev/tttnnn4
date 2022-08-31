<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User\User;
use App\Models\EmailTemplate;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;



class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'refer_ibm'  => ['required', 'string', 'max:255' , 'exists:App\Models\User\User,ibm'],
            'name' => ['required', 'string', 'max:255'],
            'surname'=>['required' , 'string' , 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'whatsapp_number' => ['required', 'numeric','digits:10' ,'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            // 'g-recaptcha-response' => 'required|captcha',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */

    protected function create(array $data)
    {

        $ibm = User::count();
        $ibm= "IBM". ++$ibm;

        $user= User::create([
            'ibm'        => $ibm, 
            'refer_ibm'  => $data['refer_ibm'],
            'name'       => $data['name'],
            'surname'    =>$data['surname'],
            'email'      => $data['email'],
            'whatsapp_number' => $data['whatsapp_number'],
            'password'   => Hash::make($data['password']),

        ]);


        Mail::to($data['email'])->send(new WelcomeMail($user));


        return $user;

    }

    public function showRegistrationForm($ibm)
    {

        return view('user.auth.register', compact('ibm'));
    }
}
