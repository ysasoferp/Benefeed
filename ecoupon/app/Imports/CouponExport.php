<?php
namespace  App\Imports;
use App\Coupon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
class CouponExport  implements FromCollection,WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */  
    // use Exportable;
    protected $type ;
    
     
        
    function __construct($type) {
        $this->type = $type;
        
 }
    
        public function collection()
    {
      
       if($this->type != null && $this->type !=="all")
        {
         return Coupon::where('status', $this->type)->with('customer')->orderby("id", "desc")->get();
        
        }else{
         return Coupon::with('customer')->orderby("id", "desc")->get();
        
        }
        
    }
    
    
    

    public function headings(): array
    {
        return [
            'Coupon Serial',
            'Amount',
            'Name',
            'Store Name',
            'Status',
            'Scan Date',
            'Area',
            
            ];
    }
    
    
    public function map($coupon): array
    {
        return [
            
              $coupon->coupon_code,
              $coupon->amount,
              $coupon->customer['fname']." ".$coupon->customer['lname'],
              $coupon->customer['store']['name'],
              $coupon->status,
              $coupon->redeem,
              $coupon->customer['location']['name'],
        ];
    }
    
    
    

   
}