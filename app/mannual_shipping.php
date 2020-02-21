<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mannual_shipping extends Model
{
     public $timestamps=false;

    public function product()
    {
        return $this->belongsTo(vendorproduct::class, 'vendorproduct_id');
     }
}
