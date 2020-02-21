<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\termscondition;
use App\orders;
use App\products;
use Auth;
use App\category;
use App\vendorproduct;
use App\subcategory;
class companyguidelinesController extends Controller
{
    public function companyguidelines()
    {
    	$guidelines = termscondition::find(8);

    	return view('vendors.guidelines',compact('guidelines'));

    }

    public function commissions()
    {
    	/*$orders = Orders::where('user_id',Auth::User()->id)->get();
    	$products = Products::all(); */
        $products=vendorproduct::where('user_id',Auth::user()->id)->where('commision','!=',NULL)->get();
        $category=category::where('catagory_comission','!=',NULL)->get();
        $subcategory=subcategory::where('sub_commission','!=',NULL)->get();
    	 return view('vendors.commissions',compact('category','subcategory','products'));
    }
}
