<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use Auth;
use App\vendorproduct;
use App\User;

class VendorproductController extends Controller
{
    public function index()
    {
    	$vendorproducts = Vendorproduct::latest()->get();
    	$cart = HomeController::cart();

    	return view('vendorproducts',compact('vendorproducts','cart'));
    }

    public function accounting($id)
    {
    	 $user = User::find($id);
    	 	$cart = HomeController::cart();
    	 return view('customers.user_accounting',compact('user','cart'));
    }
}
