<?php
namespace App;
use Eloquent;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;

class TodayFeatured extends Eloquent {

    protected $table = 'today_featured';
    protected $fillable = ['vendor_id','vendor_product_id','image'];
	
	
	
	

}