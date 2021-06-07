<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'id', 'coupon_code', 'amount', 'expire', 'status', 'redeem',
    ];

    public function customer()
    {
        return $this->belongsTo('App\Customer')->with('location', 'store')->withDefault();
    }

}
