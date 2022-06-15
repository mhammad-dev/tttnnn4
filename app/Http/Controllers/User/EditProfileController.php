<?php

namespace App\Http\Controllers\User;
use Auth;
use DB;
use Redirect,File;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\User;
use App\Models\Product;


class EditProfileController extends Controller
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

        $userId = Auth::User()->id;
        $user = DB::table('users')
                    ->leftjoin('products','users.product_id','=', 'products.product_id')
                    ->where('users.id','=' , $userId) 
                    ->select('*')->first();

        return view('user.editprofile' , compact('user'));
    }

    public function update(Request $request){
         //$path;
        //dd($request->hasFile('profile_img'));
         if($request->hasFile('profile_img')) {
                $file = $request->file('profile_img');
                //dd($file[$key]);


                //you also need to keep file extension as well
                $extension=$file->guessClientExtension();

                $name =md5_file( $file->getRealPath());
                $name= $name .'.'.$extension;

                //using the array instead of object
                $profile_img['filePath'] = $name;
                $path=$file->storeAs('profile_images', $name , 'public');
       
                $userId = Auth::User()->id;
                $user = User::find($userId);
                User::where('id','=', $userId)->update([
                        'name' => $request->name,
                        'surname' => $request->surname,
                        'email' => $request->email,
                        'whatsapp_number' => $request->whatsapp_number,
                        'bank_name' => $request->bankname,
                        'iban_number' => $request->iban,
                        'profile_img_path' => '/storage/'. $path,

                ]);
        }
        else{

                $userId = Auth::User()->id;
                $user = User::find($userId);
                User::where('id','=', $userId)->update([
                        'name' => $request->name,
                        'surname' => $request->surname,
                        'email' => $request->email,
                        'whatsapp_number' => $request->whatsapp_number,
                        'bank_name' => $request->bankname,
                        'iban_number' => $request->iban,

            ]);

        }

        return redirect()->route('editprofile_form')
                        ->with('success','Profile is updated');
         
    }

    
}
