<?php

namespace App\Imports;

use App\Coupon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CouponImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        $coupon_code = Coupon::where('coupon_code', $row['coupon_code'])->first();
        
        if($coupon_code == null){
            return new  Coupon([
                'coupon_code'=> $row['coupon_code'],
                'amount'=>$row['amount']
               
                ]);
        }
    }
}
