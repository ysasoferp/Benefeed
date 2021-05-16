<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Customer;
use App\Location;
use App\Coupon;
use App\Page;
use App\User;
use Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      //  $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $tcoupon = Coupon::whereMonth('redeem', '=', date('m'))->get();
        $location = Location::all();
       $totalCustomers= Customer::where("Pro_Status",1)->count();
       $recentCustomer= Customer::with('location')->where("Pro_Status",1)->orderby('id', 'DESC')->limit(10)->get();
        return view('index', compact('recentCustomer','totalCustomers', 'location','tcoupon'));
    }
     public function privacy()
    {
        $privacy = Page::first();
               return view('privacy',compact('privacy'));
    }

    public function Adminlogin(Request $request){

        $user = User:: where('email', $request->email)->first();
        if($user != null){

            if(Hash::check($request->password, $user->password)){

                auth()->login($user);
                return redirect()->to('home');
            }
        }
    }
}
