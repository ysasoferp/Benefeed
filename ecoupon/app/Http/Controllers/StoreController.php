<?php

namespace App\Http\Controllers;

use App\Store;
use Illuminate\Http\Request;
 use App\Page;
class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $page = Page::first();
         $stores= Store::paginate(50);
         return view('store_name', compact('stores', 'page'));

        }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


      $store = new Store();
      $store->name= $request->store;
      $store->total_coupon= 0;
      $store->save();

      return back()->with('sumsg' , 'Store Created Successfully' );

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function getLocation(Location $location)
    {
         $locations= Store::all();
         echo json_encode($store);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function deleteStore($id)
    {
           $location = Store::findOrFail($id);
         if($location->forceDelete()){
            return back()->with('msgError','Store Successfully Deleted!');
        }else{
            return back()->with('msgError','Error Deleting Record');
        }
    }
}
