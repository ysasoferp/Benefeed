<?php

namespace App\Http\Controllers;

use App\Marketing;
use Illuminate\Http\Request;
use App\Page;

class MarketingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $page = Page::first();
        $marketing =Marketing::all();
       return view('marketing', compact('marketing', 'page'));
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
        
        
        $Marketing = new Marketing();
        if(isset($request->bannerName)){
        $Marketing->banner_number = $request->bannerName;
        }
        if(isset($request->bannerFile)){
      $folder= date('Y-m-d');
      $image = $request->bannerFile;
      $extension = ".".$image->getClientOriginalExtension();
      $name=basename($image->getClientOriginalName(), $extension);
      $new_name = $name.rand().$extension;
      $path =$image->move('uploads/images/'.$folder, $new_name );
      $filelocation = 'uploads/images/'.$folder .'/'.$new_name ;
      $Marketing->tumbnail = $filelocation;
 
        }
        
        if($Marketing->save()){
            
            return back()->with('msg', "Banner Upload Successfully");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Marketing  $marketing
     * @return \Illuminate\Http\Response
     */
    public function show(Marketing $marketing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Marketing  $marketing
     * @return \Illuminate\Http\Response
     */
    public function marketImage()
    {
        
        
        $marketImage = Marketing::all();
        $countImage=  count($marketImage);
       
         $imageNumber =  rand(1,$countImage);
         
         foreach($marketImage as $key => $image){
             if($key+1 == $imageNumber){
                 
               $response['marketImageGet'] =$image->tumbnail;
               
             }
             
         
             
         }
         
             echo json_encode($response);
         
    
      
      
      
      
        
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Marketing  $marketing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Marketing $marketing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Marketing  $marketing
     * @return \Illuminate\Http\Response
     */
    public function deleteMarket($id)
    {
       
         $market = Marketing::findOrFail($id);
         if($market->forceDelete()){
            return back()->with('msgError','Market Successfully Deleted!');
        }else{
            return back()->with('msgError','Error Deleting Record');
        }
        
       
    }
}
