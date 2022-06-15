<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ChangePasswordController extends Controller{


public function __construct()
{
    $this->middleware('auth:admin');
}

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
public function index()
{
   return view('admin.changepassword');
}

 /**
 * Change users password
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\RedirectResponse
 */
public function changePassword(Request $request)
{
    
        $requestData = $request->All();
       
        $validator = $this->validatePasswords($requestData);

        if($validator->fails())
        {
        
            return back()->with('errors','New and Confirm Passwords Should be same');
        }
        else
        {
            $currentPassword = Auth::guard('admin')->user()->password;
            if(Hash::check($requestData['password'], $currentPassword))
            {
                $userId = Auth::guard('admin')->user()->id;
                $user = \App\Models\Admin\Admin::find($userId);
                $user->password = Hash::make($requestData['new_password']);;
                $user->save();
                return back()->with('success', 'Your password has been updated successfully.');
            }
            else
            {
                return back()->with('errors','Current Password is not correct');
            }
        }
   
}

/**
 * Validate password entry
 *
 * @param array $data
 * @return \Illuminate\Contracts\Validation\Validator
 */
public function validatePasswords(array $data)
{
    $validator = Validator::make($data, [
        'password' => 'required',
        'new_password' => 'required', 'same:new_password', 'min:8',
        'confirm_password' => 'required|same:new_password',
    ]);

    return $validator;
}


}