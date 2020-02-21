<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class vendors extends Model
{
    protected $guarded = [];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function vendorproduct()
    {
    	return $this->hasMany(vendorproduct::class);
    }
    
}
