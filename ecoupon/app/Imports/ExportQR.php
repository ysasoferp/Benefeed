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
    protected $status ;



    function __construct($type,$status) {
        $this->type = $type;
        $this->status = $status;

 }

    public function collection()
    {
        $filter = $this->type;
        $status = $this->status;
        $customersQuery = Customer::when($this->type,function($q) use ($filter) {
            $q->where( 'location_id','=',$filter);
        })->when($this->status !== null, function($q) use ($status) {
            $q->where( 'status','=',$status);
        });

        return $customersQuery->with("store", "location")->orderby("id", "desc")->get();
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
