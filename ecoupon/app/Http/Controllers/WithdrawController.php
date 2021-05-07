<?php

namespace App\Http\Controllers;

use App\Withdraw;
use App\Settings;
use App\Customer;
use App\Transection;
use Illuminate\Http\Request;
use Excel;
use App\Page;
use App\Imports\TransactionExport;

class WithdrawController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = Page::first();
        $fromDate = date('Y-m-d', strtotime($request->from) ) ;
        $todate   = date('Y-m-d', strtotime($request->to) );
       
        if(isset($request->filter)){
        $transaction =Transection::where('txn_no', 'LIKE', '%WREQ%')->where('txn_type', $request->filter )->orderby("id", "desc")->get();
        return view('transaction', compact('transaction', 'page'));
}elseif(isset($request->from) && isset($request->to)){
        $transaction =Transection::where('txn_no', 'LIKE', '%WREQ%')->whereDate('txn_date','>=',$fromDate)->whereDate('txn_date','<=',$todate)->orderby("id", "desc")->get();
        return view('transaction', compact('transaction', 'page'));
}elseif(isset($request->fname) && isset($request->lname)){
        $transaction =[];
        $transaction_get =Transection::where('txn_no', 'LIKE', '%WREQ%')->orderby("id", "desc")->with('customer')->get();
        foreach($transaction_get as $trans){
            if(strtolower($trans->customer['fname']) == strtolower($request->fname) && strtolower($trans->customer['lname']) == strtolower($request->lname)){
            $transaction[] = $trans;
        }
    }
        
        return view('transaction', compact('transaction', 'page'));
}else{
    
        $transaction =Transection::where('txn_no', 'LIKE', '%WREQ%')->orderby("id", "desc")->get();
        return view('transaction', compact('transaction', 'page'));
}
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
     
     
    public function withdrawMoney(Request $request)
   {
        
        $withdrawMoney = $request->amount;
        $id = $request->id; 
        
        $customer = Customer::findOrFail($id);
        $wallet =  $customer->wallet;
        
        $settings =Settings::first();
        $limit =$settings->limit;
        
        
        if( $withdrawMoney >= $limit){
            
          if($withdrawMoney <= $wallet){
        
         $customer->wallet =  $wallet - $withdrawMoney;
         if($customer->save()){
             
                $transaction = new Transection();
                $transaction->txn_no            =   "WREQ-".time();
                $transaction->customer_id       =   $id;
                $transaction->name              =   $customer->fname." ".$customer->lname;
                $transaction->amount            =   $withdrawMoney;
                $transaction->txn_date          =   date("Y-m-d");
                $transaction->txn_type          =   1;
                $transaction->txn_status        =   1;
                if($transaction->save()){
                    
                     $response['response']=200;
                     $response['amount']=$withdrawMoney;
                     $response['TxnNumber']=$transaction->txn_no;
                     $response['total_amount']= $customer->wallet;
                      $response['limit']=null;
                     echo json_encode($response);
                
            }
}
 
  }else{
  $response['response']=201;
  $response['amount']=null;
  $response['TxnNumber']=null;
  $response['total_amount']= $customer->wallet;
   $response['limit']=null;
   echo json_encode($response);
  }
    }else{
  $response['response']=301;
  $response['amount']=null;
  $response['TxnNumber']=null;
  $response['total_amount']= null;
  $response['limit']=$limit;
     echo json_encode($response);
        
    }
    }




    
    public function transferMoneyMobile(Request $request)
    {
        
        $sendMoney = $request->amount;
        $id = $request->id; 
        
        $sender = Customer::findOrFail($id);
        $reciever = Customer::where("phone",$request->mobile)->first();
        $senderWallet =  $sender->wallet;
        
        
     
     if($reciever != null && $id != $reciever->id && $reciever->status == 1){
           if($sendMoney <= $senderWallet){
        
         $sender->wallet =  $senderWallet - $sendMoney;
         if($sender->save()){
             
                $Stransaction = new Transection();
                $Stransaction->txn_no            =   "TRANS-".time();
                $Stransaction->customer_id       =   $sender->id;
                $Stransaction->amount            =   $sendMoney;
                $Stransaction->txn_date          =   date("Y-m-d");
                $Stransaction->txn_type          =   0;
                $Stransaction->txn_status        =   1;
                if($Stransaction->save()){
                    
    
              $recieverWallet =  $reciever->wallet;      
              $reciever->wallet = $recieverWallet + $sendMoney;
              
                if($reciever->save()){
                     
                $Rtransaction = new Transection();
                $Rtransaction->txn_no            =   $Stransaction->txn_no;
                $Rtransaction->customer_id       =   $reciever->id;
                $Rtransaction->amount            =   $sendMoney;
                $Rtransaction->txn_date          =   date("Y-m-d");
                $Rtransaction->txn_type          =   2;
                $Rtransaction->txn_status        =   0;
                if($Rtransaction->save()){
                    
                      
                     $response['response']=200;
                     $response['amount']=$sendMoney;
                     $response['TxnNumber']=$Stransaction->txn_no;
                     $response['total_amount']= $sender->wallet;
                     $response['limit']=null;
                     echo json_encode($response);
                    
                }
                
            }
}
}
 
  }else{
  $response['response']=201;
  $response['amount']=null;
  $response['TxnNumber']=null;
  $response['total_amount']= $sender->wallet;
   $response['limit']=null;
   echo json_encode($response);
  }
         
     }else{
  $response['response']=301;
  $response['amount']=null;
  $response['TxnNumber']=null;
  $response['total_amount']=null;
  $response['limit']=null;
   echo json_encode($response);
         
     }
     
    }























    /**
     * Display the specified resource.
     *
     * @param  \App\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     **/
     
       public function transferMoney(Request $request)
   {
        
        $sendMoney = $request->amount;
        $withdrawMoney = $request->amount;
        $id = $request->id; 
        
        $sender = Customer::findOrFail($id);
        $reciever = Customer::where("email",$request->email)->first();
        $senderWallet =  $sender->wallet;
        
        
     
     if($reciever != null && $id != $reciever->id && $reciever->status == 1){
           if($sendMoney <= $senderWallet){
        
         $sender->wallet =  $senderWallet - $sendMoney;
         if($sender->save()){
             
                $Stransaction = new Transection();
                $Stransaction->txn_no            =   "TRANS-".time();
                $Stransaction->customer_id       =   $sender->id;
                $Stransaction->amount            =   $sendMoney;
                $Stransaction->txn_date          =   date("Y-m-d");
                $Stransaction->txn_type          =   0;
                $Stransaction->txn_status        =   1;
                if($Stransaction->save()){
                    
    
              $recieverWallet =  $reciever->wallet;      
              $reciever->wallet = $recieverWallet + $sendMoney;
              
                if($reciever->save()){
                     
                $Rtransaction = new Transection();
                $Rtransaction->txn_no            =   $Stransaction->txn_no;
                $Rtransaction->customer_id       =   $reciever->id;
                $Rtransaction->amount            =   $sendMoney;
                $Rtransaction->txn_date          =   date("Y-m-d");
                $Rtransaction->txn_type          =   2;
                $Rtransaction->txn_status        =   0;
                if($Rtransaction->save()){
                    
                      
                     $response['response']=200;
                     $response['amount']=$sendMoney;
                     $response['TxnNumber']=$Stransaction->txn_no;
                     $response['total_amount']= $sender->wallet;
                     $response['limit']=null;
                     echo json_encode($response);
                    
                }
                
            }
}
}
 
  }else{
  $response['response']=201;
  $response['amount']=null;
  $response['TxnNumber']=null;
  $response['total_amount']= $sender->wallet;
   $response['limit']=null;
   echo json_encode($response);
  }
         
     }else{
  $response['response']=301;
  $response['amount']=null;
  $response['TxnNumber']=null;
  $response['total_amount']=null;
  $response['limit']=null;
   echo json_encode($response);
         
     }
     
    }

    public function transferHistory($id)
    {
        
        
            $transaction = Transection::where("customer_id", $id)->orderby("id", "desc")->get();
        
        echo json_encode($transaction);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function editWithdraw(Request $request)
    {
        
        $transection = Transection::findOrFail($request->id);
        $transection->txn_type = $request->status;
        $transection->note = $request->note;
        $transection->save();
        return back();
        
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function dealerVerify(Request $request)
    {
        
     
        $uid = $request->uid; 
        $id  = $request->id; 
        $user = Customer::where('uID', $uid)->first();
         if ($user != null && $user->id != $id && $user->status == 1){
        
                   $response['response']=200;
                   $response['email']=$user->email;
                   echo json_encode($response);
        
    }else{
                  $response['response']=301;
                   $response['email']=null;
                   echo json_encode($response);
    }
  
        
        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function destroy(Withdraw $withdraw)
    {
        //
    }
    
     function ExportWithdrawlData(Request $request)
    {
        $type = null;
        $from = null;
        $to   = null;  
        
        if(isset($request->filter)){
            $type = $request->filter;
        }elseif(isset($request->from) && isset($request->to)){
           
             $from = $request->from;
             $to   = $request->to;
        }
        
        return Excel::download(new TransactionExport($type,$from, $to), 'transactions.xls');
       
    }   
        
    
}
