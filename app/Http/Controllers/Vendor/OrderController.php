<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\orders;
use Auth;
use App\ordersdetail;
use App\products;

class OrderController extends Controller
{
    public function index()
    {
    	$orders = Orders::where('user_id',Auth::User()->id)->get();
    	$products = Products::all();
    	return view('vendors.order.index',compact('orders','products'));
    }

    public function status(Request $request,$id)
    {
    	$this->validate($request,[
    		'orderstatus' => 'required',
    	]);
  		$order = Ordersdetail::where('id',$id)->first();
  		if ($request->orderstatus) {
  			$order->orderstatus = "cancel";
	  		$order->order_cancel_reason	= $request->orderstatus;
	  		$order->save();

	  		return back()->with('status','Your Order Successfully cancel');
  		}else{
  			return back();
  		}
  		
    }
     public function active($id)
    {
      $orders = Orders::find($id);
      $orders->orderstatus = "cancel";
      $orders->save();
      return back()->with('status','Your order status suessfully cancel');
    }

     public function cancel($id)
    {
      $orders = Orders::find($id);
      $orders->orderstatus = "active";
      $orders->save();
      return back()->with('status','Your order status suessfully active');
    }

    public function paymentstatus()
    {
      $orders = Orders::where('vendor_id',Auth::User()->id)->where('payment',null)->get();

      return view('vendors.order.payment',compact('orders'));
    }
}
