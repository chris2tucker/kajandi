<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ordersdetail extends Model
{
    protected $guarded = [];

    protected $table = 'ordersdetail';
      public function order()
    {
        return $this->belongsTo(orders::class,'order_id');
    }
     public function products()
    {
    	return $this->belongsTo('App\products','product_id');
    }
}
