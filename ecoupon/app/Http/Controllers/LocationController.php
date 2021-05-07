<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;
 use App\Page;
class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $page = Page::first();
         $locations= Location::all();
      
      return view('location', compact('locations', 'page'));
        
        
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
        
     
      $location = new Location();
      $location->name= $request->location;
      $location->total_coupon= 0;
      $location->save();
     
      return back()->with('sumsg' , 'Location Created Successfully' );
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function getLocation(Location $location)
    {
         $locations= Location::all();
         echo json_encode($locations);
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
    public function deleteLocation($id)
    {
           $location = Location::findOrFail($id);
         if($location->forceDelete()){
            return back()->with('msgError','User Successfully Deleted!');
        }else{
            return back()->with('msgError','Error Deleting Record');
        }
    }
}
