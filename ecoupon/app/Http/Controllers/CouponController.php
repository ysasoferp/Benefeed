<?php

namespace App\Http\Controllers;

use App\Coupon;
use App\Customer;
use App\Page;
use App\Store;
use App\Location;
use App\Transection;
use Illuminate\Http\Request;
use App\Imports\CouponImport;
use App\Imports\CouponExport;
use Excel;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function importCoupon()
    {
           $coupon = Coupon::paginate(15);
       $page = Page::first();
        return view('importcoupon', compact('coupon', 'page'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showCoupon(Request $request)
    {
        $page = Page::first();
        $storeName = Store::all();
        $areas =
            Location::all();

        $status = $request->status;
        $storeId = $request->store;
        $locationId = $request->area;
        $scannedFrom = $request->scannedFrom;
        $scannedTo = $request->scannedTo;
        $coupon = Coupon::with(['customer.location','customer.store'])
            ->when(isset($status) && $request->status !== "all", function($q) use ($status) {
                $q->where( 'status', $status);
            })->when(($storeId || $locationId), function($q) use ($storeId, $locationId){
                $q->whereHas('customer',function($qr) use ($storeId, $locationId) {
                    if($storeId) {
                        $qr->whereHas( 'store', function($qr2) use($storeId) {
                            $qr2->where('id',$storeId);
                        });
                    }
                    if($locationId) {
                        $qr->whereHas( 'location', function($qr2) use($locationId) {
                            $qr2->where('id',$locationId);
                        });

                    }
                });
            })->when($scannedFrom, function ($q) use($scannedFrom) {
                $q->where('redeem','>=', $scannedFrom);
            })->when($scannedTo, function ($q) use($scannedTo) {
                $q->where('redeem','<=', $scannedTo);
            })->paginate(15);

        return view('couponlist', compact('coupon', 'storeName', 'areas', 'page'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function importCouponStore(Request $request)
    {

        $request->validate([
            'upload_file'=> 'required|mimes:xls,xlsx'
            ]
            );

         Excel::import(new CouponImport, $request->upload_file);

         return redirect('coupon/import')->with('msg','Import Successful');

    }




     function ExportCoupon(Request $request)
    {

        return Excel::download(new CouponExport($request), 'coupon.xls');

    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function couponVerify(Request $request)
    {

        $couponCode = $request->coupon;
        $id = $request->id;
        $customer = Customer::findOrFail($id);
        $wallet =  $customer->wallet;

        $coupon = Coupon::where('coupon_code',$couponCode )->first();
        if(!$coupon == null){

          if($coupon->status == 'valid'){

          $couponPrice =  $coupon->amount;
          $customer->wallet=  $wallet+ $couponPrice;
          if( $customer->location->total_coupon != null){

              $customer->location->total_coupon = $customer->location->total_coupon + 1;
               $customer->location->save();
          }else{
              $customer->location->total_coupon =1;
              $customer->location->save();
          }

         if($customer->save()){

             $coupon->customer_id = $id;
             $coupon->status = "scanned";
              $coupon->redeem = date("Y-m-d");

            if($coupon->save()){

                $transaction = new Transection();
                $transaction->txn_no            =   "COUP-".time();
                $transaction->customer_id       =   $id;
                $transaction->amount            =   $couponPrice;
                $transaction->txn_date          =   date("Y-m-d");
                $transaction->txn_type          =   3;
                $transaction->txn_status        =   0;
                if($transaction->save()){

                     $response['response']=200;
                     $response['amount']=$couponPrice;
                     $response['TxnNumber']=$transaction->txn_no;
                     $response['total_amount']= $customer->wallet;
                     echo json_encode($response);
                     echo  $customer->location->total_coupon ;
                }
            }

         }


  }else{
  $response['response']=201;
  $response['amount']=null;
  $response['TxnNumber']=null;
   $response['total_amount']= null;
  echo json_encode($response);
  }
    }else{
  $response['response']=301;
  $response['amount']=null;
  $response['TxnNumber']=null;
  $response['total_amount']= null;
    echo json_encode($response);

    }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        //
    }

  public function deleteCoupon($id)
    {
           $user = Coupon::findOrFail($id);
         if($user->forceDelete()){
            return back()->with('msgError','Coupon Successfully Deleted!');
        }else{
            return back()->with('msgError','Error Deleting Record');
        }


    }







}
