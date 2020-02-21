<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use Laracasts\Flash\Flash;
use View;
use Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Html\HtmlFacade;
use App\Http\Controllers\Controller;
use DB;
use AUTH;
use Session;
use \Carbon\Carbon;
use Image;
use Response;
use App\vendors;
use App\productmodel;
use App\category;
use App\subcategory;
use App\vendorproduct;
use App\ordersdetail;
use App\Customer;
use App\orders;

class AccountController extends Controller {

	
	public function accounts()
	{


		return View::make('admin.accounts.index');
	}


  public function CommissionCatagory()
  {

  	$catagory = category::all();
  	return View::make('vendors.accounts.setCommission.Commissioncategory',compact('catagory'));
  }

  public function set_commission_catagory(Request $request,$id)
  {

  	$catagory = category::find($id);
  	$catagory->catagory_comission = $request->commission;
  	$catagory->save();

  	Session::flash('status','Successfully Set Commission');
	return Redirect::to('admin/comission_catagory');
  }

  public function CommissionSubCatagory()
  {
  	$Subcatagory = subcategory::all();
  	return View::make('admin.accounts.setCommission.CommissionSubcat',compact('Subcatagory'));
  }

  public function set_commission_subcatagory(Request $request,$id)
  {

  	$subcatagory = subcategory::find($id);
  	$subcatagory->sub_commission  = $request->commission;
  	$subcatagory->save();

  	Session::flash('status','Successfully Set Commission');
	return Redirect::to('admin/comission_Subcatagory');
  }


  public function productCommission()
  {

  	$product = vendorproduct::all();
  	return View::make('admin.accounts.setCommission.CommissionProduct',compact('product'));

  }

  public function set_commission_product(Request $request,$id)
  {

  	$product = vendorproduct::find($id);
  	$product->commision  = $request->commission;
  	$product->save();

  	Session::flash('status','Successfully Set Commission');
	return Redirect::to('admin/productCommission');
  }


  public function product_price()
  {
            $product = DB::table('vendorproduct')
                            ->select('vendorproduct.*','vendors.*')
                           ->leftjoin('vendors','vendors.user_id','=','vendorproduct.user_id')
                           ->get();
            $vendor = DB::table('vendors')->pluck('vendorname','user_id');

  	return View::make('admin.accounts.manage_financial.ProductPrice',compact('product','vendor'));
  }
  public function get_vendor_product_price(Request $request)
  {
         $vendor_id = $request->vendor_id;
            $product = DB::table('vendorproduct')
                            ->select('vendorproduct.user_id','vendorproduct.name as Product Name','vendors.vendorname as Vendor Name','vendorproduct.price as Price')
                           ->leftjoin('vendors','vendors.user_id','=','vendorproduct.user_id')
                           ->where('vendorproduct.user_id',$vendor_id)
                           ->get();
           

    return Response::json($product);
  }

  public function total_order_price_vendor()
  {
          
      $vendor = DB::table('vendors')->pluck('vendorname','user_id');
      

    return View::make('admin.accounts.manage_financial.totalOrderPrice',compact('vendor'));
  }


  public function get_vendor_total_order_price(Request $request)
  {
         $vendor_id = $request->vendor_id;

         
            $order = DB::table('ordersdetail')
                ->select('ordersdetail.ordernumber','vendorproduct.name as ProductName','ordersdetail.quantity as Quantity','ordersdetail.totalprice as TotalPrice','ordersdetail.total_price_without_comission as TotalPrice_witout_commission','ordersdetail.commission as Commission')
                ->leftjoin('vendorproduct','vendorproduct.id','=','ordersdetail.product_id')
                ->where('vendorproduct.user_id',$vendor_id)
                ->orderBy('ordersdetail.id', 'desc')
                ->get();
                //dd($order);
              
$TotalPrice_out_commission = DB::table('ordersdetail')
                ->select(DB::raw("SUM(ordersdetail.total_price_without_comission) as totalprice_without_comission"))
                ->leftjoin('vendorproduct','vendorproduct.id','=','ordersdetail.product_id')
                ->where('vendorproduct.user_id',$vendor_id)
                ->orderBy('ordersdetail.id', 'desc')
                ->first();
$TotalPrice_with_commission = DB::table('ordersdetail')
                ->select(DB::raw("SUM(ordersdetail.totalprice) as totalprice_with_comission"))
                ->leftjoin('vendorproduct','vendorproduct.id','=','ordersdetail.product_id')
                ->where('vendorproduct.user_id',$vendor_id)
                ->orderBy('ordersdetail.id', 'desc')
                ->first();
$Total_commission = DB::table('ordersdetail')
                ->select(DB::raw("SUM(ordersdetail.commission ) as total_comission"))
                ->leftjoin('vendorproduct','vendorproduct.id','=','ordersdetail.product_id')
                ->where('vendorproduct.user_id',$vendor_id)
                ->orderBy('ordersdetail.id', 'desc')
                ->first();
                
     $data['TotalPrice_without_commission'] = $TotalPrice_out_commission ;
     $data['TotalPrice_with_commission'] = $TotalPrice_with_commission ;
     $data['Total_commission'] = $Total_commission ;       
     $data['order'] = $order;
      

    return Response::json($data);

  }




  public function outstanding_customer_payment()
  {

    $customer = Customer::pluck('name','user_id');
    return View::make('admin.accounts.customer_outstanding_payment.outstanding',compact('customer'));        
  }

public function outstandnig_detail_order(Request $request)
{
   $current_date = \Carbon\Carbon::now()->format('Y/m/d');
   $customerid = $request->customer_id;
   $outstanding = DB::table('outstandingpayment')
                    ->select('outstandingpayment.ordernumber','outstandingpayment.ref_id as Reference_ID','vendorproduct.name as product_name','outstandingpayment.quantity as Quantity','outstandingpayment.price','outstandingpayment.totalprice',DB::raw("(CASE WHEN outstandingpayment.payoptions='2' THEN '15 days' WHEN outstandingpayment.payoptions='3' THEN '30 days' ELSE 'instant' END) as payment"),'outstandingpayment.dateordered as Date_ordered','outstandingpayment.duedate as Due_date','outstandingpayment.payment')
                    ->join('users','users.id','=','outstandingpayment.user_id')
                    ->join('vendorproduct','vendorproduct.id','=','outstandingpayment.product_id')
                    ->whereDate('outstandingpayment.duedate','>=', $current_date)
                    ->where('outstandingpayment.user_id',$customerid)
                    ->get();
    $Total_price = DB::table('outstandingpayment')
                ->select(DB::raw("SUM(outstandingpayment.totalprice) as total_price"))
                ->whereDate('outstandingpayment.duedate','>=',$current_date)
                ->where('outstandingpayment.user_id',$customerid)
                ->first();
    $data['total_price'] = $Total_price;
    $data['outstanding'] = $outstanding;
                    
    return Response::json($data);

}

public function due_customer_payment()
  {

    $customer = Customer::pluck('name','user_id');
    return View::make('admin.accounts.customer_outstanding_payment.due_payment',compact('customer'));        
  }

public function due_detail_order(Request $request)
{
   $current_date = \Carbon\Carbon::now()->format('Y/m/d');
   $customerid = $request->customer_id;
   $due = DB::table('outstandingpayment')
                    ->select('outstandingpayment.ordernumber','outstandingpayment.ref_id as Reference_ID','vendorproduct.name as product_name','outstandingpayment.quantity as Quantity','outstandingpayment.price','outstandingpayment.totalprice',DB::raw("(CASE WHEN outstandingpayment.payoptions='2' THEN '15 days' WHEN outstandingpayment.payoptions='3' THEN '30 days' ELSE 'instant' END) as payment"),'outstandingpayment.dateordered as Date_ordered','outstandingpayment.duedate as Due_date','outstandingpayment.payment')
                    ->join('users','users.id','=','outstandingpayment.user_id')
                    ->join('vendorproduct','vendorproduct.id','=','outstandingpayment.product_id')
                    ->whereDate('outstandingpayment.duedate','<=', $current_date)
                    ->where('outstandingpayment.user_id',$customerid)
                    ->get();
    $Total_price = DB::table('outstandingpayment')
                ->select(DB::raw("SUM(outstandingpayment.totalprice) as total_price"))
                ->whereDate('outstandingpayment.duedate','<=',$current_date)
                ->where('outstandingpayment.user_id',$customerid)
                ->first();
    $data['total_price'] = $Total_price;
    $data['due'] = $due;
                    
    return Response::json($data);

}


public function total_purchase()
  {

    $customer = Customer::pluck('name','user_id');
    return View::make('admin.accounts.customer_outstanding_payment.total_purchase',compact('customer'));        
  }


public function total_purchase_detail(Request $request)
{
   

   $customerid = $request->customer_id;
   $orders = orders::where('user_id',$customerid)->get();

    //$order_detail=array();
   if(count($orders)) 
   {
      foreach($orders as $key)
      {
          $ordersdetail = DB::table('ordersdetail')
                              ->select('ordersdetail.ordernumber','vendorproduct.name as ProductName','ordersdetail.quantity as Quantity','ordersdetail.totalprice as TotalPrice')
                              ->leftjoin('vendorproduct','vendorproduct.id','=','ordersdetail.product_id')
                              ->where('ordersdetail.payoptions','1')
                              ->where('ordersdetail.order_id',$key->id)
                              ->get();

$total_price = DB::table('ordersdetail')
                              ->select(DB::raw("SUM(ordersdetail.totalprice) as total_price"))
                              ->leftjoin('vendorproduct','vendorproduct.id','=','ordersdetail.product_id')
                              ->where('ordersdetail.payoptions','1')
                              ->where('ordersdetail.order_id',$key->id)
                              ->first();

          $data['order_detail'] =   $ordersdetail;
          $data['total_price'] =   $total_price;
    
      }

   }else{

     $data['order_detail'] =array('Data'=>'Not Found Data');
     $data['total_price'] =   '0.0';
   }

   return Response::json($data); 

  }

}