<?php

namespace App\Http\Controllers;

use App\Settings;
use App\Customer;
use Illuminate\Http\Request;
use App\Appinfo;
use App\Page;
class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = Page::first();
       $Settings =Settings::orderby('id', 'desc')->first();
       return view('settings', compact('Settings','page'));
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
   
       $Settings = Settings::first();
   
   if($Settings !=null){
       
        if(isset($request->range))
     {
         $Settings->limit             = $request->range; 
     }
      
      if(isset($request->notification)){
           $Settings->notification      = $request->notification;
           $Settings->time              = time();
      }
       
        $Settings->save();
       
      return view('settings', compact('Settings'));
   }else{
       $Settings = new Settings();
              if(isset($request->range))
     {
         $Settings->limit             = $request->range; 
     }
      
      if(isset($request->notification)){
           $Settings->notification      = $request->notification;
           $Settings->time              = time();
      } 
       $Settings->save();
       
       $page = Page::first();
       
      return view('settings', compact('Settings', 'page'));
       
   }
       
       
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function getNotification(Request $request)
    {
        
         $user = Customer::findOrFail($request->id);
         
         $Settings =Settings::orderby('id', 'desc')->first();
    
        if($Settings->notification != null){
            if($user->noti < $Settings->time){
                
                     $response['response']=200;
                     $response['time']=1;
                     $response['notification']=$Settings->notification;
                     echo json_encode($response);
            }else{
                 $response['response']=200;
                     $response['time']=0;
                     $response['notification']=$Settings->notification;
                     echo json_encode($response);
            }
            
        }
      
    }

  public function setNotification(Request $request)
    {
        
         $user = Customer::findOrFail($request->id);
         $user->noti = time();
         $user->save();
        
      
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function edit(Settings $settings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function appInfo(Request $request)
    {
        $page =Page::first();
         $appinfo =Appinfo::orderby('id', 'desc')->first();
    
     return view('appinfo', compact('appinfo', 'page'))   ;
        
    }



  public function appinfostore(Request $request)
    {
        
       $appinfo = Appinfo::first();
   
   if($appinfo !=null){
       
        if(isset($request->app_v))
     {
         $appinfo->app_v             = $request->app_v; 
     }
      
      if(isset($request->applink)){
           $appinfo->updated_link      = $request->applink;
          
      }
       if(isset($request->heading)){
           $appinfo->heading      = $request->heading;
          
      }
       if(isset($request->description)){
           $appinfo->description      = $request->description;
          
      }
       if(isset($request->success)){
           $appinfo->success      = $request->success;
          
      }
       if(isset($request->fail)){
           $appinfo->fail      = $request->fail;
          
      }
        $appinfo->save();
        
       
      return back();
   }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function destroy(Settings $settings)
    {
        //
    }
    
    
    
    public function getAppinfo(Request $request)
    {
        
         $appinfo =Appinfo::orderby('id', 'desc')->first();
    
        if($appinfo->app_v != null){
           
                     $response['response']=200;
                     $response['app_v']=$appinfo->app_v;
                     $response['link']=$appinfo->updated_link;
                     $response['heading']=$appinfo->heading;
                     $response['description']=$appinfo->description;
                     $response['success']=$appinfo->success;
                     $response['fail']=$appinfo->fail;
                     echo json_encode($response);
            }else{
                 $response['response']=201;
                  $response['app_v']=null ;
                  $response['link']=$appinfo->update_link;
                   $response['heading']=null;
                     $response['description']=null;
                     $response['success']=null;
                     $response['fail']=null;
                echo json_encode($response);
            }
      
    }
   
    
    
    
    
}
