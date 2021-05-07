<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    
    protected $guarded =[];
    
    
        public function location()
    {
    return  $this->belongsTo('App\Location');
    }
        public function store()
    {
    return  $this->belongsTo('App\Store');
    }
}
