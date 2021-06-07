<?php

namespace App\Http\Controllers;
use App\Store;
use App\Transection;
use Carbon\Carbon;
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

//        $tcoupon = Coupon::whereMonth('redeem', '=', date('m'))->get();
        $location = Location::all();
       $totalCustomers= Customer::where("Pro_Status",1)->count();
       $totalNewCustomers= Customer::where("status",0)->count();
       $recentCustomer= Customer::with('location')->where("Pro_Status",1)->orderby('id', 'DESC')->limit(10)->get();


        $couponsCountByLocation = Location::getCouponScannedByDateRange('thisMonth');
        $tcoupon = collect($couponsCountByLocation)->sum('coupon_total_count');
        $tcouponAmount = collect($couponsCountByLocation)->sum('total_amount');
        $tValueNotScanned = Coupon::where('status','<>','scanned')->count();

        $top5ScannedStore = Store::getTop5StoreCouponScanned();

        //withdrawals
        $withdrawals = Transection::selectRaw('txn_type,count(*) as totalWithdrawals')->where('txn_no','like','%WREQ%')->groupBy('txn_type')->get()->keyBy('txn_type');

        $withdrawalList = [['Inprogress',$withdrawals->has(1) ? $withdrawals->get(1)['totalWithdrawals'] : 0],
            ['Into Payment Partner',$withdrawals->has(5) ? $withdrawals->get(5)['totalWithdrawals'] : 0],
            ['Gcash Payment',$withdrawals->has(7) ? $withdrawals->get(7)['totalWithdrawals'] : 0],
            ['Withdrawn',$withdrawals->has(4) ? $withdrawals->get(4)['totalWithdrawals'] : 0]];

        $data =  compact('recentCustomer', 'totalCustomers', 'location', 'tcoupon', 'totalNewCustomers',
            'couponsCountByLocation', 'tcouponAmount', 'tValueNotScanned','top5ScannedStore','withdrawalList');
        return view('index',$data);
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

    public function getDataForGraphTotalCouponScanned(Request  $request)
    {
        $couponsCountByLocation = Location::getCouponScannedByDateRange($request->time_span);
        $tcoupon = collect($couponsCountByLocation)->sum('coupon_total_count');
        $tcouponAmount = collect($couponsCountByLocation)->sum('total_amount');


        $range = date('F');
        $type =$request->time_span;
        if($type =='previousMonth') {
            $range = Carbon::now()->subMonths(1)->format('F');
        }elseif ($type == "last6Months") {
            $range = 'Last 6 Months';
        }elseif ($type == "thisYear") {
            $range = "This Year";
        }

        $graphData[] = ['Product Name', 'Quantity'];
        foreach($couponsCountByLocation as $loc) {
            $graphData[] = [$loc->name, $loc->coupon_total_count];
        }


        return response()->json([
            'success' => 1,
            'tcoupon' => $tcoupon,
            'tcouponAmount' => $tcouponAmount,
            'couponsCountByLocation' => $couponsCountByLocation,
            'range' => $range,
            'graphData' => $graphData
        ]);
    }
}
