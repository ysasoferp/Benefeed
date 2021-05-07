<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $pages = Page::first();
        $page = Page::first();
        return view('pages', compact('pages', 'page'));
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
        

         $deleteSettings = Page::truncate();
         
         
         
       $pages = new Page();
       $page  = Page::first();
       if(isset($request->about)){
       $pages->about        = $request->about;
       }
         if(isset($request->privacy)){
       $pages->privacy      = $request->privacy;
         }
         
          if(isset($request->footer)){
       $pages->footer      = $request->footer;
         }
         
          if(isset($request->faq)){
       $pages->faq      = $request->faq;
         }
         
         if(isset($request->email)){
       $pages->email      = $request->email;
         }
         if(isset($request->phone)){
         $pages->phone      = $request->phone;
         }
       $pages->save();
       
      return back()->with('msg', 'Page Updated SeccessFully');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function getAdminData()
    {
        $pages = Page::first();
                   $response['response']        = 200          ;                           
                   $response['about']           = $pages->about          ;               
                   $response['privacy']         = $pages->privacy      ; 
                   $response['faq']             = $pages->faq      ; 
                   $response['email']           = $pages->email         ;              
                   $response['phone']           = $pages->phone     ;
 
    echo json_encode($response);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
       
       $getAdminData = Page::first();
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        //
    }
}
