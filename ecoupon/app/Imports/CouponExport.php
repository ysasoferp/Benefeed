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
    protected $status ;
    protected $locationId;
    protected $storeId;
    protected $scannedFrom;
    protected $scannedTo;



    function __construct($request) {
        $this->status = $request->status;
        $this->storeId = $request->store;
        $this->locationId = $request->area;
        $this->scannedFrom = $request->scannedFrom;
        $this->scannedTo = $request->scannedTo;

 }

        public function collection()
    {

        $coupon = Coupon::with(['customer.location','customer.store'])
            ->when(isset($this->status) && $this->status !== "all", function($q) {
                $q->where( 'status', $this->status);
            })->when(($this->storeId || $this->locationId), function($q){
                $q->whereHas('customer',function($qr){
                    if($this->storeId) {
                        $qr->whereHas('store',function($qr2){ $qr2->where('id', $this->storeId); });
                    }
                    if($this->locationId) {
                        $qr->whereHas('location',function($qr2) {
                           $qr2->where('id', $this->locationId);
                        });
                    }
                });
            })->when($this->scannedFrom, function ($q) {
                $q->where('redeem','>=', $this->scannedFrom);
            })->when($this->scannedTo, function ($q) {
                $q->where('redeem','<=', $this->scannedTo);
            })->orderby("id", "desc")->limit(500)->get();

        return $coupon;
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
