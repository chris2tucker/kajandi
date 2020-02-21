<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    protected $guarded = [];

    protected $table = 'orders';
     public function orderdetails()
    {
    	return $this->HasMany('App\ordersdetail','order_id');
    }
    public function user()
    {
    	return $this->belongsTo('App\User','user_id');
    }
    
}
