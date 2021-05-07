<?php
namespace  App\Imports;
use App\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
class ExportQR  implements FromCollection,WithHeadings,WithMapping
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
        
        if($this->type !== null){
            return Customer::where('location_id', $this->type)->with("store", "location")->orderby("id", "desc")->get();
        }else{
            return Customer::with("store", "location")->orderby("id", "desc")->get();
        }
                    
        
        
    }
    
     
    public function headings(): array
    {
        return [
            
            'uID',
            'Email',
            'First Name',
            'Last Name',
            'Date of Birth',
            'Address',
            'Location',
            'Store',
            'Phone',
            'Wallet',
            'Created_at',
            'Updated_at',
              
            ];
    }
    
     public function map($customer): array
    {
        return [
            
              $customer->uID,
              $customer->email,
              $customer->fname,
              $customer->lname,
              $customer->dob,
              $customer->address,
              $customer['location']['name'],
              $customer['store']['name'],
              $customer->phone,
              $customer->wallet,
              $customer->Created_at,
              $customer->Updated_at,
        ];
    }
    
    
    
   
}