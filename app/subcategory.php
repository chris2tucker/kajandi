<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class subcategory extends Model
{
    protected $fillable = [
        'category_id',
        'name'
    ];

    public function category()
	{
		return $this->belongsTo(category::class);
	}

	public function products()
	{
		return $this->belongsTo(products::class);
	}
}
