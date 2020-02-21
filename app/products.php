<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class products extends Model
{
	protected $guarded = [];

 	public function subcategory()
 	{
 		return $this->hasOne(subcategory::class);
 	}

 	public function vendorproduct()
 	{
 		return $this->hasMany(vendorproduct::class);
 	}

}
