<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Store extends Model
{
    protected $guarded = [];

    public function customers()
    {
        return $this->hasMany('App\Customer');
    }

    public static function getTop5StoreCouponScanned()
    {
        $couponCounts = DB::select(DB::raw("SELECT s.id AS lid, s.name,COUNT(*) AS coupon_total_count
            FROM stores s
            LEFT JOIN customers c ON s.id = c.store_id
            LEFT JOIN coupons cp ON c.id = cp.customer_id
            WHERE cp.status='scanned'
            GROUP BY lid ORDER BY coupon_total_count DESC LIMIT 5"));

        return $couponCounts;
    }
}
