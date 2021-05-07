<?php
namespace  App\Imports;
use App\Transection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransactionExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */  
    // use Exportable;
    protected $type ;
     protected $from ;
      protected $to ;
     
        
    function __construct($type,$from, $to ) {
        $this->type = $type;
         $this->from = $from;
          $this->to = $to;
 }
    
    

    public function headings(): array
    {
        return [
            'TXN NUMBER',
            'TXN NOTE',
            'Customer Name',
            'AMOUNT',
           
              
            ];
    }
    public function collection()
    {
        
        if($this->from != null && $this->to !=null){
        $fromDate = date('Y-m-d', strtotime($request->from) ) ;
        $todate   = date('Y-m-d', strtotime($request->to) );
        
        return Transection::select('txn_no', 'note', 'Name', 'amount')->where('txn_no', 'LIKE', '%WREQ%')->whereDate('txn_date','>=',$fromDate)->whereDate('txn_date','<=',$todate)->orderby("id", "desc")->get();
        
        }elseif($this->type != null)
        {
             return Transection::select('txn_no', 'note', 'Name', 'amount' )->where('txn_type',$this->type)->where('txn_no', 'LIKE', '%WREQ%')->orderby("id", "desc")->get();
      
        }else{
           return Transection::select('txn_no', 'note', 'Name', 'amount')->where('txn_no', 'LIKE', '%WREQ%')->orderby("id", "desc")->get();
        
        }
        
       

    
        
    }
   
}