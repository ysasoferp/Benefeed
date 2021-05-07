<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\User;
use Illuminate\Support\Facades\Hash;

class CostumerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $customers = Customer::paginate(10);
       return view('customers', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function users()
    {
        $users= User::all();
        return view('users', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        if(!Customer::where("email", $request->email)->exists()){
     
          $customer               = new Customer();
        $customer->email        = $request->email;
        $customer->password     =  Hash::make($request->password);
        if($customer->save())
        {
    $response['response']=200;
    $response['email']=$request->email;
    echo json_encode($response);
        }
        else{

        
        }
        }else{
   $response['response']=301;
   $response['email']=$request->email;
  echo json_encode($response);
        }
        }



    public function loginUser(Request $request)
    {
    
    $user = Customer::where('email', $request->email)->Exists();
    if($user){
        
   $check= Hash::check($request->password, $user->password);
   if($check){
       
   $response['response']=200;
   $response['email']=$request->email;
   echo json_encode($response);
   }else{
   $response['response']=201;
   $response['email']=$request->email;
   echo json_encode($response);
   }
    }else{
   $response['response']=301;
   $response['email']=$request->email;
  echo json_encode($response);
        
    }
    
    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteUser($id)
    {
           $user = User::findOrFail($id);
         if($user->forceDelete()){
            return back()->with('msgError','User Successfully Deleted!');
        }else{
            return back()->with('msgError','Error Deleting Record');
        }
        
        
    }
        public function deleteCustom($id)
    {
           $user = Customer::findOrFail($id);
         if($user->forceDelete()){
            return back()->with('msgError','User Successfully Deleted!');
        }else{
            return back()->with('msgError','Error Deleting Record');
        }
        
        
    }
    
            public function editCustom($id)
    {
           $user = Customer::findOrFail($id);
       
         return response()->json($user);
        }
        
             public function activateCustom(Request $request)
    {
           $user = Customer::findOrFail($request->id);
           $user->status = $request->status;
          if( $user->save()){
              
              return back();
              
          }
      
        }
        
    
    
    
    
}
