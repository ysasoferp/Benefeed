<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Location extends Model
{
    protected $guarded = [];

    public function customers()
    {
        return $this->hasMany('App\Customer');
    }

    public static function getCouponScannedByDateRange($type)
    {
        $whereSql = "MONTH(redeem)='".date("m")."'";
        if($type =='previousMonth') {
            $whereSql = "MONTH(redeem)='".Carbon::now()->subMonths(1)->format("m")."'";
        }elseif ($type == "last6Months") {
            $whereSql = "redeem>='".Carbon::now()->subMonths(6)->format("Y-m")."'";
        }elseif ($type == "thisYear") {
            $whereSql = "year(redeem)='".Carbon::now()->format("Y")."'";
        }
        $couponCounts = DB::select(DB::raw("SELECT l.id AS lid, l.name,COUNT(*) AS coupon_total_count,sum(amount) as total_amount
            FROM locations l
            LEFT JOIN customers c ON l.id = c.location_id
            LEFT JOIN coupons cp ON c.id = cp.customer_id
            WHERE cp.status='scanned' and ".$whereSql."
            GROUP BY lid"));

//        $couponCounts = collect($couponCounts)->keyBy('lid');
//        $locations = self::all();
//        foreach ($locations as $k => $location) {
//            if($couponCounts->has($location->id)) {
//                $location->coupon_total_count = $couponCounts[$location->id]->total_count;
//            } else {
//                $location->coupon_total_count = 0;
//            }
//        }

        return $couponCounts;
    }



}
