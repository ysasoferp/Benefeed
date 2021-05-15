<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Location;
use App\User;
use App\Page;
use App\Store;
use Excel;
use App\Imports\ExportQR;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = Page::first();
        $location = Location::all();
        $stores = Store::all();

        $filter = $request->filter;
        $status = $request->status;
        $customersQuery = Customer::when($filter,function($q) use ($filter) {
            $q->where( 'location_id','=',$filter);
        })->when($request->status !== null, function($q) use ($status) {
            $q->where( 'status','=',$status);
        });
//        if(isset($request->filter)){
//        $customers = Customer::where("Pro_Status", 1)->where('location_id', $request->filter)->paginate(10);
//        return view('customers', compact('customers', 'location', 'page', 'stores'));
//        }else{
//        $customers = Customer::where("Pro_Status", 1)->paginate(10);
//        return view('customers', compact('customers', 'location', 'page', 'stores'));
//        }

        $customers = $customersQuery->paginate(10);
        return view('customers', compact('customers', 'location', 'page', 'stores','filter','status'));

    }





  function ExportQR(Request $request)
    {
        $filter = null ;
        $status   = null;
       if(isset($request->filter)){
           $filter = $request->filter;
       }

        if(isset($request->status)){
            $status = $request->status;
        }
       return Excel::download(new ExportQR($filter, $status) , 'CustomerQR.xls');

    }









    public function getProfileData($id)
    {
      $customers = Customer::findOrFail($id);


      $response["email"] = $customers->email;
       $response["fname"] = $customers->fname;
        $response["lname"] = $customers->lname;
         $response["location"] = $customers->location->name;
          $response["phone"] = $customers->phone;
           $response["dp"] = $customers->dp ? url($customers->dp) :201;
           $response["identity"] = url($customers->identity);


       echo json_encode($response);


    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function users()
    {
        $page = Page::first();
        $users= User::all();
        return view('users', compact('users', 'page'));
    }




 public function registerUser( Request $request){



        $request->validate([
        'firstname' => ['required'],
        'lastname' => ['required'],
        'email'=> ['required', 'email', 'unique:users'],
        'uname'=>['required'],
        'role'=>['required'],
        'password'=>['required'],
        'password_confirmation' => 'required|same:password'

              ]);


   $user = new User();
        $user->uname = $request->uname;
         $user->lname= $request->lastname;
          $user->fname = $request->firstname;
           $user->role =$request->role;
            $user->email = $request->email;
           $user->password =Hash::make($request->password);
           $user->save();

        {

    return back()->with('sumsg' , 'User Created Successfully' );


        }



}












  public function UpdateUser($id)
    {
        $users= User::findOrFail($id);

        return response()->json([

            'uname'=>$users->uname,
             'fname'=>$users->fname,
              'lname'=>$users->lname,
               'email'=>$users->email,
               'id'=>$users->id
            ]);

    }


  public function postUpdateUser(Request $requeset)
    {

        $users= User::findOrFail($requeset->id);

        $users->uname = $requeset->uname;
        $users->email = $requeset->email;
        $users->lname = $requeset->firstname ;
        $users->fname = $requeset->lastname;
        if(isset($requeset->password)){
        $users->password = Hash::make($requeset->password);
        }

   if($users->save()){

          return back()->with('msg' , 'User Updated Successfully' );

   }




    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {

            // Response Array variable

                   $response['response']        = null   ;  //Check Response fail or Success Blank
                   $response['email']           = null   ;  //Get Email Blank
                   $response['user_id']         = null   ;  //Get User Id Blank

        if(!Customer::where("email", $request->email)->exists()){

        $customer               = new Customer();
        $customer->email        = $request->email;
        $customer->status       = 0;
        $customer->Pro_Status   = 0;
        $customer->uID          = "eCoup-".time();
        $customer->Login_type   = 1;
        $customer->password     =  md5($request->password);
        if($customer->save())
        {

                   $response['response']        = 200                                       ;  //Check Response fail or Success
                   $response['email']           = $customer->email                          ;  //Get Email
                   $response['user_id']         = $customer->id                             ;  //Get User Id
                   $response['amount']          = $customer->wallet                         ;  //Get Wallet Amount

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







   /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function registerLogin(Request $request)
    {

            // Response Array variable

                   $response['response']        = null   ;  //Check Response fail or Success Blank
                   $response['email']           = null   ;  //Get Email Blank
                   $response['user_id']         = null   ;  //Get User Id Blank

        if(!Customer::where("email", $request->email)->exists()){

        $customer                        = new Customer();
        $customer->email                 = $request->email;
        $customer->status                = 0;
        $customer->Pro_Status            = 0;
        $customer->uID                   = "eCoup-".time();
        $customer->Login_type            = 0;
        $customer->wallet                = 0.00;
        if($customer->save())
        {


                   $response['response']        = 200                                       ;  //Check Response fail or Success
                   $response['email']           = $customer->email                          ;  //Get Email
                   $response['user_id']         = $customer->id                             ;  //Get User Id
                   $response['amount']          = $customer->wallet                         ;  //Get Wallet Amount

    echo json_encode($response);
        }
        else{


        }
        }else{

                $customer=  Customer::where("email", $request->email)->first();

                   $response['response']        = 200                                       ;  //Check Response fail or Success
                   $response['email']           = $customer->email                          ;  //Get Email
                   $response['user_id']         = $customer->id                             ;  //Get User Id
                   $response['amount']          = $customer->wallet                         ;  //Get Wallet Amount

  echo json_encode($response);
        }
        }







public function resetPass($expire)
    {

        $customer = Customer::where('resetPass' , $expire)->first();
        if($customer != null){
     return view('auth.passwords.reset', compact('customer'));

    }else{

        return "this link is expired";
    }

}


public function resetPassApp(Request $request)

    {
          if($request->password == $request->password_confirmation ){
        $customer = Customer::findOrFail($request->id);
        if($customer != null){
    $customer->password = md5($request->password);
    $customer->resetPass = null;
    if($customer->save()){

        return "Password Reset Successfully";
    }
    }else{

        return "this link is expired";
    }

}else{
    return back()->with('error', "Confirm Password not Match");
}


}









 public function forgotPassEmail($email)
    {
$subject = "Forgot Password";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        $customer = Customer::where('email' , $email)->first();
        if($customer != null){
            if($customer->Login_type != 0){
        $time= time();

        $expire = Crypt::encryptString($time);
        $msg ="Hello! ".$customer->fname." Click the link for reset your Password".url('resetPass/'.$expire);

       if(mail($email,$subject,$msg,$headers)){
        $customer->resetpass = $expire;
            $customer->save();
         $response['result']=200;
         $response['msg']= 'Password Reset link send Successfully';
       echo json_encode($response);
        }
            }else{

    $response['result']=301;
   $response['msg']='Please Login With Google Account';
   echo json_encode($response);
            }
    }else{
   $response['result']=201;
   $response['msg']=null;
   echo json_encode($response);
        }
    }





  public function changePassword(Request $request)
    {

     $pass = md5($request->password);
     $passNew = md5($request->passwordNew);
            // Response Array variable

    $response['response']        = null   ;  //Check Response fail or Success Blank

        $customer = Customer::findOrFail($request->user_id);
        if($customer != null){

          if($pass == $customer->password ) {
            $customer->password  = $passNew;
            $customer->save();
        $response['response']=200;
       echo json_encode($response);
        }else{
   $response['response']=201;
   echo json_encode($response);
        }

    }
    }


    public function loginUser(Request $request)
    {


            // Response Array variable

                   $response['response']        = null   ;  //Check Response fail or Success Blank
                   $response['email']           = null   ;  //Get Email Blank
                   $response['user_id']         = null   ;  //Get User Id Blank
                   $response['amount']          = null   ;  //Get Wallet Amount Blank
                   $response['fullName']        = null   ;  //Get Full Name Blank
                   $response['fName']           = null   ;  //Get First Name Blank
                   $response['lName']           = null   ;  //Get Last Name Blank
                   $response['location']        = null   ;  //Get Location Blank
                   $response['status']          = null   ;  //Get Status Blank
                   $response['phone']           = null   ;  //Get Phone Blank
                   $response['Login_type']      = null   ;  //Get Login Status Blank
                   $response['Pro_Status']      = null   ;  //Get Profile Status Blank
                   $location                    = null   ;  //Make Location Null
                   $response['dp']              = null   ;  //Get Image Null



    $password = md5($request->password);
    $customer = Customer::where('email', $request->email)->first();


    if(isset($customer->location->name)){
        $location = $customer->location->name;
    }



   if(!$customer == null){
     if($password == $customer->password){

                   $response['response']        = 200                                       ;  //Check Response fail or Success
                   $response['email']           = $customer->email                          ;  //Get Email
                   $response['user_id']         = $customer->id                             ;  //Get User Id
                   $response['amount']          = $customer->wallet                         ;  //Get Wallet Amount
                   $response['fullName']        = $customer->fname." ".$customer->lname     ;  //Get Full Name
                   $response['fName']           = $customer->fname                          ;  //Get First Name
                   $response['lName']           = $customer->lname                          ;  //Get Last Name
                   $response['location']        = $location                                 ;  //Get Location
                   $response['phone']           = $customer->phone                          ;  //Get Status
                   $response['status']          = $customer->status                         ;  //Get Status
                   $response['dp']              = url($customer->dp)                    ; //GET IMAGE
                   $response['Login_type']      = $customer->Login_type                     ;
                   $response['Pro_Status']      = $customer->Pro_Status                     ;

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
    public function getUserData($id)
    {


            // Response Array variable

                   $response['response']        = null   ;  //Check Response fail or Success Blank
                   $response['email']           = null   ;  //Get Email Blank
                   $response['user_id']         = null   ;  //Get User Id Blank
                   $response['amount']          = null   ;  //Get Wallet Amount Blank
                   $response['fullName']        = null   ;  //Get Full Name Blank
                   $response['fName']           = null   ;  //Get First Name Blank
                   $response['lName']           = null   ;  //Get Last Name Blank
                   $response['location']        = null   ;  //Get Location Blank
                   $response['status']          = null   ;  //Get Status Blank
                   $response['phone']           = null   ;  //Get Phone Blank
                   $location                    = null   ;  //Make Location Null
                   $response['dp']              = null   ; //GET IMAGE Null
                   $response['Login_type']      = null   ;  //Get Login Status Blank
                   $response['Pro_Status']      = null   ;  //Get Profile Status Blank


    $customer = Customer::where('id', $id)->first();

    if(isset($customer->location->name)){
        $location = $customer->location->name;
    }



   if(!$customer == null){
                   $response['response']        = 200                                       ;  //Check Response fail or Success
                   $response['email']           = $customer->email                          ;  //Get Email
                   $response['user_id']         = $customer->id                             ;  //Get User Id
                   $response['amount']          = $customer->wallet                         ;  //Get Wallet Amount
                   $response['fullName']        = $customer->fname." ".$customer->lname     ;  //Get Full Name
                   $response['fName']           = $customer->fname                          ;  //Get First Name
                   $response['lName']           = $customer->lname                          ;  //Get Last Name
                   $response['location']        = $location                                 ;  //Get Location
                   $response['phone']           = $customer->phone                          ;  //Get Status
                   $response['status']          = $customer->status                         ;  //Get Status
                   $response['dp']              = url($customer->dp)                    ; //GET IMAGE
                   $response['Login_type']      = $customer->Login_type                     ;
                   $response['Pro_Status']      = $customer->Pro_Status                     ;
   echo json_encode($response);

     }




    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getLocation()
    {

      $location = Location::all();
      foreach($location as $key => $loc){
        $data[]=$loc->name;
      }
        echo json_encode($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     */



    public function uploadProfileData(Request $request)
    {

        $customer = Customer::findOrFail($request->user_id);

        $identitylocation = $customer->identity;


       if($customer->dp ==null){

         if (isset($request->upload)) {

      $image =base64_decode($request->upload);
      $filename = $request->fName.rand().".jpg";
      $path =file_put_contents('uploads/images/Profile/'.$filename, $image );
      $filelocation = 'uploads/images/Profile/'.$filename;
      }else{
          $filelocation= 'uploads/images/profile_image.png';
      }
       }else{

               if (isset($request->upload)) {

      $image =base64_decode($request->upload);
      $filename = $request->fName.rand().".jpg";
      $path =file_put_contents('uploads/images/Profile/'.$filename, $image );
      $filelocation = 'uploads/images/Profile/'.$filename;
      }else{
          $filelocation= $customer->dp;
      }

       }

      if (isset($request->identity)) {

      $identity =base64_decode($request->identity);
      $filenameIdentity = $request->fName.rand().".jpg";
      $path =file_put_contents('uploads/images/Identity/'.$filenameIdentity, $identity );
      $identitylocation = 'uploads/images/Identity/'.$filenameIdentity;
      }



      $location = Location::where("name", $request->Location)->first();

      $customer->identity = $identitylocation;
      $customer->fname = $request->fName;
      $customer->lname = $request->lName;
      $customer->phone = $request->pNumber;
      $customer->Pro_Status = 1;
      $customer->location_id = $location->id;
      $customer->dp = $filelocation;

      $customer->save();

      $response['ProStatus'] = $customer->Pro_Status;
      $response['fname'] = $customer->fname;
      $response['lname'] = $customer->lname;
      $response['phone'] = $request->pNumber;
      $response['location'] = $request->Location;


      echo json_encode($response);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteUser($id)
    {
           $customer = User::findOrFail($id);
         if($customer->forceDelete()){
            return back()->with('msgError','User Successfully Deleted!');
        }else{
            return back()->with('msgError','Error Deleting Record');
        }


    }
        public function deleteCustom($id)
    {
           $customer = Customer::findOrFail($id);
         if($customer->forceDelete()){
            return back()->with('msgError','User Successfully Deleted!');
        }else{
            return back()->with('msgError','Error Deleting Record');
        }


    }

            public function editCustom($id)
    {
           $customer = Customer::findOrFail($id);

         return response()->json($customer);
        }

             public function activateCustom(Request $request)
    {
           $customer = Customer::findOrFail($request->id);
           $customer->status = $request->status;
           $customer->store_id= $request->storeName;
          if( $customer->save()){

              return back();

          }

        }





}
