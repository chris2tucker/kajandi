<?php

namespace App\Http\Controllers\Admin;

use App\ordersdetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\vendorproduct;
use App\User;
use App\orders;

class ProductdetailsController extends Controller
{
    public function index()
    {
    	$products = Vendorproduct::latest()->get();
    	return view('admin.product_accounting',compact('products'));
    }

    public function details($id)
    {
        $product = vendorproduct::findOrFail($id);
    	 $orders = ordersdetail::where('product_id',$id)->with('order', 'order.user')->get();
    	 return view('admin.product_details',compact('orders', 'product'));
    }

    public function failed($id)
    {
        $order = Orders::find($id);
        $order->failed = 1;
        $order->save();
        return back();
    }

       public function pending($id)
    {
        $order = Orders::find($id);
        $order->failed = null;
        $order->save();
        return back();
    }

    public function payment()
    {
        $orders = Orders::where('payment',NULL)->get();
        
        return view('admin.paymentapprove',compact('orders'));
    }
    public function approved(){
        $orders = Orders::where('payment','yes')->get();
        
        return view('admin.approved',compact('orders'));
    }

    public function approve($id)
    {
       $order = Orders::find($id);
       $order->payment = 'yes';
       $order->save();
       return back();
    }

}
