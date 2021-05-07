<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
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
   
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

   public function register( Request $request){
       
       
         
        $request->validate([
        'firstname' => ['required', 'string', 'max:255'],
        'lastname' => ['required', 'string', 'max:255'],
        'email'=> ['required', 'string', 'email', 'max:255', 'unique:users'],
        'uname'=>['required', 'string', 'max:255', 'unique:users'],
        'role'=>['required', 'string', 'max:255'],
        'password'=>['required', 'string', 'min:6'],
        'password_confirmation' => 'required|same:password|min:6'
       
              ]);


   if(  User::create([
            'fname' => $request['firstname'],
            'lname' => $request['lastname'],
            'uname' => $request['uname'],
            'role' => $request['role'] ? $request['role'] : "user" ,
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ])){
            
    return back()->with('sumsg' , 'User Created Successfully' );
    

        }
        


}

  
}
