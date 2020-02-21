<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class vendorproduct extends Model
{
    protected $table = 'vendorproduct';

    public function products()
    {
    	return $this->belongsTo(products::class);
    }

    public function vendors()
    {
    	return $this->belongsTo(vendors::class);
    }
    
}
