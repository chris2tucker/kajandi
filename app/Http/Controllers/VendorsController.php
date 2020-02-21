<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\category;
use App\subcategory;
use App\vendors;
use App\User;
use App\productmodel;
use App\products;
use App\condition;
use App\productmanufacturer;
use App\productaddon;
use App\source;
use App\strengthofmaterial;
use App\productimages;
use App\vendorproduct;
use App\ordersdetail;
use App\orders;
use App\customersvendor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\customersverification;
use App\outstandingpayment;
use App\Bankdetails;
use Carbon\carbon;
use App\shipping;
use App\Customer;
class VendorsController extends Controller
{

	public function index()
    {
    	
      $getoutstandingpayment = outstandingpayment::where('user_id',Auth::User()->id)->count('price');
      $getduepayment = outstandingpayment::where('user_id',Auth::User()->id)->where('duedate','>',Carbon::today())->where('payment','=','no')->count('price');
        $productscount = vendorproduct::where('user_id', Auth::user()->id)->get();
        $products = vendorproduct::where('user_id', Auth::user()->id)->where('delete_product','=',0)->get();
       $pending = $products->where('availability','!=','yes')->count();

       $customersvendor = customersvendor::where('vendor_id', Auth::user()->id)->first();
       $sales=orders::where('vendor_id','=',Auth::user()->id)->where('deliverystatus','=','delivered')->count();
        $orderscompleted=orders::where('deliverystatus','=','delivered')->get();
        $totalearned=0;
        foreach ($orderscompleted as $order) {
           $orderprice=ordersdetail::where('order_id','=',$order->id)->where('deliverystatus','=','delivered')->where('vendor_id','=',Auth::user()->id)->sum('total_price_without_comission');
           if($orderprice)
           $totalearned=$totalearned + $orderprice;
        }
       
        if ($customersvendor) {
            
            $customersvendors = customersvendor::where('vendor_id', $customersvendor->vendor_id)->get();
            //dd($customersvendors);

            foreach ($customersvendors as $key) {
                $getcustomer = User::where('id',$key->customer_id)->get();
                //dd($getcustomer);
               
            }
           

        }
        else{
            $getcustomer = User::where('id',NULL)->get();
        }

        $view = '';
        $i = 0;
        foreach($products as $key){
        $i++;
        $getproduct = products::where('id', $key->product_id)->first();
        $vendor = vendors::where('user_id', $key->user_id)->first();
        $subcategory=subcategory::where('id','=',$key->subcategory)->first();
        $category=category::where('id','=',$key->category)->first();
        $myurl =asset('/');
        if($key->commision !=NULL){
            $pricewithoutcommision=$key->price-$key->commision;
        }
        else{
            $pricewithoutcommision=$key->price;
        }
          if(!empty($key->commision))
        {
            $commission = $key->commision;
        }elseif(!empty($subcategory->sub_commission)){

            $commission = $subcategory->sub_commission;
        }elseif(!empty($category->sub_commission)){

            $commission = $category->catagory_comission;
        }
        else{
            $commission=0;
        }
         if (empty($key->image)) {
            $img="/$getproduct->image";
        }else{
            $img="/$key->image";
        }

        $view   .=  "<tr>
                    <td class='text-center'>$i</td>
                    <td class='w100'><img class='img-responsive mw40 ib mr10 img_product' 
                    width='50' title='user'
                                             src='$myurl/$img'></td>
                    </td>
                    <td>$getproduct->name</td>
                    <td>$vendor->vendorname</td>
                    <td>$getproduct->partnumber</td>
                    <td>".HomeController::converter($key->price)."</td>
                    <td>$commission %</td>
                    <td>$key->stock_count</td>
                    <td class='text-right'>";
                        if($key->availability == 'yes'){
        $view .=     "<button type='button'
                                class='btn btn-success br2 btn-xs fs12 dropdown-toggle'
                                data-toggle='dropdown' aria-expanded='false'> Active
                        
                        </button>";
                    }
                        else{
           $view .=     "<button type='button'
                                class='btn btn-warning br2 btn-xs fs12 dropdown-toggle'
                                data-toggle='dropdown' aria-expanded='false'> Disabled
                        
                        </button>";
                    }
            $view .= "</td>
                    <td>
                        <a href=".$myurl."vendor/edit_product/$key->id class='btn btn-primary btn-xs'>Edit</a>
                        
                    </td>
                </tr>";
        }

$bankdetails = Bankdetails::where('user_id',Auth::User()->id)->first();
       

        return view('vendors.index',compact('productscount','pending','getcustomer','customersvendor','view','getoutstandingpayment','bankdetails','sales','totalearned','getduepayment'));
    }

    public function products()
    {
        $products = vendorproduct::where('user_id', Auth::user()->id)->where('delete_product','=',0)->get();
        $view = '';
        $i = 0;
        foreach($products as $key){
        $i++;
        $getproduct = products::where('id', $key->product_id)->first();
        $vendor = vendors::where('user_id', $key->user_id)->first();
         $subcategory=subcategory::where('id','=',$key->subcategory)->first();
        $category=category::where('id','=',$key->category)->first();
        $shippingType=shipping::where('vendorproduct_id','=',$key->id)->first();
        $myurl =asset('/');
       if(!empty($key->commision))
        {
            $commission = $key->commision;
        }elseif(!empty($subcategory->sub_commission)){

            $commission = $subcategory->sub_commission;
        }elseif(!empty($category->sub_commission)){

            $commission = $category->catagory_comission;
        }
        else{
            $commission=0;
        }
       
         if (empty($key->image)) {
            $img="/$getproduct->image";
        }else{
            $img="/$key->image";
        }

        $view   .=  "<tr";
            if($key->stock_count<50){
                $view .=" style='background-color: #efc7c7;'";
            }

        $view .=">
                    <td class='text-center'>$i</td>
                    <td class='w100'><img class='img-responsive mw40 ib mr10 img_product' title='user'
                                             src='$myurl/$img'></td>
                    </td>
                    <td><a href='$myurl/product/$key->slog'>$getproduct->name</a></td>
                    <td>$vendor->vendorname</td>
                    <td>$getproduct->partnumber</td>
                    <td>".HomeController::converter($key->price)."</td>
                    <td>$commission %</td>
                    <td>$key->stock_count</td>";
                    if($shippingType){
                        if($shippingType->shipping_type){
                        $view .="<td>$shippingType->shipping_type</td>";
                    }else{
                        $view .="<td>free_shipping</td>";
                    }

                    }else{
                        $view .="<td>free_shipping</td>";
                    }
                    $view .="<td class='text-right'>";
                        if($key->availability == 'yes'){
        $view .=     "<a href=".$myurl."vendor/deactivate_product/$key->id
                                class='btn btn-success br2 btn-xs fs12 dropdown-toggle'
                                > Active
                        
                        </button>";
                    }
                        else{
           $view .=     "<a href=".$myurl."vendor/activate_product/$key->id
                                class='btn btn-warning br2 btn-xs fs12 dropdown-toggle'
                                > Disabled
                        
                        </a>";
                    }
            $view .= "</td>
                    <td>
                        <a href=".$myurl."vendor/edit_product/$key->id class='btn btn-primary btn-xs'>Edit</a>
                        <!--<a href=".$myurl."vendor/delete_product/$key->id class='btn btn-danger btn-xs delete'>Delete</a>-->";
                if($key->product_status==1 && $key->promotion ==0){
                    $view .=" <a href=".$myurl."vendor/promote_product/$key->id class='btn btn-warning btn-xs '>Promote</a></td>
                </tr>";
                }
                else{
                   $view .="</td>
                </tr>" ;
                }      
                    ;
        }
        return view('vendors.products', compact('view'));
    }

    public function viewproduct($id)
    {
        $vendorproduct = vendorproduct::where('id', $id)->first();
        $products = products::where('id', $vendorproduct->product_id)->first();
        $product = products::all();
        $vendorproducts = vendorproduct::where('id', $id)->get();
        $productmodel = productmodel::all();
        $productmanufacturer = productmanufacturer::all();
        $condition = condition::all();
        $vendors = vendors::all();
        $productaddon = productaddon::all();
        $source = source::all();
        $strengthofmaterial = strengthofmaterial::all();
        $category = category::where('id', $vendorproduct->category)->first();
        $subcategory = subcategory::where('id', $vendorproduct->subcategory)->first();
        return view('vendors.viewproduct', compact('product', 'products', 'vendorproduct','category', 'productaddon', 'subcategory', 'productmodel', 'vendors', 'productmanufacturer', 'condition', 'source', 'strengthofmaterial', 'vendorproducts'));
    }

 
    public function addvendorproduct(){
        $products = products::all();
        $productmodel = productmodel::all();
        $productmanufacturer = productmanufacturer::all();
        $condition = condition::all();
        $vendors = vendors::all();
        $productaddon = productaddon::all();
        $source = source::all();
        $strengthofmaterial = strengthofmaterial::all();
        return view('vendors/vendorproduct', compact('products', 'productmodel', 'productmanufacturer', 'productaddon', 'vendors', 'source', 'strengthofmaterial', 'condition'));
    }

  

    public function requisition()
    {   $update = orders::where('vendor_read', 0)->update(array('vendor_read' => 1));
        $getorders = orders::where('payment', 'yes')->first();
        $orders = orders::where('payment', 'yes')->orderBy('id', 'desc')->get();
        $num = 0;
        $view = '';
        $selected = '';
        $myurl =asset('/');

            
        if ($getorders) {
            # code...
        

            foreach ($orders as $keys) {

                $getordersdetail = ordersdetail::where('order_id', $keys->id)->first();
                $vendorproduct = vendorproduct::where('id', $getordersdetail->product_id)->where('user_id', Auth::user()->id)->first();
                
                
                    

                    $getordersdetail2 = ordersdetail::where('order_id', $keys->id)->where('vendor_id','=',Auth::user()->id)->get();

                    foreach ($getordersdetail2 as $key) {
                        

                        $vendorproduct2 = vendorproduct::where('id', $key->product_id)->where('user_id', Auth::user()->id)->first();
                        if ($vendorproduct2) {
                            
                            
                            $num += 1;
                            $quantity = number_format($key->quantity);
                            $price = number_format($key->totalprice);
                            $customer = User::where('id', $keys->user_id)->first();

                            $statusofdelivery=orders::find($key->order_id);

                            $view .= "<tr>
                                    <td>$num</td>
                                    <td>$key->ordernumber</td>
                                    <td>$key->ref_id</td>
                                    <td><a href='".$myurl."product/$vendorproduct2->slog'>$vendorproduct2->name</a></td>
                                    <td>$customer->name</td>
                                    <td>$quantity</td>
                                    <td>".HomeController::converter($key->totalprice)."</td>
                                    <td>$key->dateordered</td>";
                                    if($key->payoptions==1){
                                        $view .="<td>Instant payment</td>";
                                    }
                                    else if($key->payoptions==2){
                                        $view .="<td>15 days payment</td>";
                                    }
                                    else if($key->payoptions==3){
                                        $view .="<td>30 days payment</td>";
                                    }
                                    else if($key->payondelivery=='pay on delivery'){
                                        $view .="<td>Pay on delivery</td>";
                                    }else{
                                        $view .="<td>Instant price</td>";
                                    }
                                    if($key->paymentposted==1){
                                        $view .="<td>Payment Posted</td>";
                                    }else{
                                        $view .="<td>Payment Pending</td>";
                                    }
                                    
                                    if($statusofdelivery->orderstatus =='cancel'){
                                           /* if ($statusofdelivery->deliverystatus == 'pending') {
                                                $view .= "<td>Pending</td>";
                                            }
                                            if ($statusofdelivery->deliverystatus == 'delivered') {
                                                $view .= "<td>Delivered</td>";
                                            } */
                                             $view .="<td>order cancelled</td>";
                                        }
                                        else{
                                           if($key->deliverystatus=='pending'){
                                            $view .="<td>Pending</td>";
                                           }
                                           else{
                                            $view .="<td>Delivered</td>";
                                           }
                                        }
 
                                        $view .="
                                    <td><a href='".$myurl."vendors/ordersdetail/$key->id' class='btn btn-primary btn-sm'>View</a>";
                                        if ($key->deliverystatus === 'pending') {
                                            $view .= "<a href='' class='btn btn-sm btn-danger'  data-toggle='modal' data-target='#exampleModal-$statusofdelivery->id'>cancel order</a></td>";
                                        }
                                    $view .="</td></tr><div class='modal fade' id='exampleModal-$statusofdelivery->id' tabindex='-1' role='dialog'  aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                              <div class='modal-dialog' role='document'>
                                                <div class='modal-content'>
                                                  <div class='modal-header'>
                                                    <h5 class='modal-title' id='exampleModalLabel'>Why you want to cancel this order?</h5>
                                                    
                                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                      <span aria-hidden='true'>&times;</span>
                                                    </button>
                                                  </div>
                                                  <div class='modal-body'>
                                                    <form action='".$myurl."/vendor/order/status/$key->id' method='POST'>
                                                       ". csrf_field(). "
                                                         <div class='form-group'>
                                                            <label for='message-text' class='col-form-label'></label>
                                                            <textarea class='form-control' id='message-text' cols='50' placeholder='You must state reasong for cancelling order' name='orderstatus'></textarea>
                                                          </div>
                                                    
                                                  </div>
                                                  <div class='modal-footer'>
                                                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                                    <button type='submit' class='btn btn-primary'>Cancel Order</button>
                                                  </div>
                                                  </form>
                                                </div>
                                              </div>
                                            </div>";

                        }
                    }

                    

               

                

            }

            }
            return view('vendors.requisition', compact('view'));

    }
public function cancelledrequisition()
    {   $update = orders::where('vendor_read', 0)->where('vendor_id','=',Auth::user()->id)->update(array('vendor_read' => 1));
      //  $getorders = orders::where('orderstatus', 'cancel')->where('vendor_id','=',Auth::user()->id)->first();
      //  $orders = orders::where('orderstatus', 'cancel')->where('vendor_id','=',Auth::user()->id)->orderBy('id', 'desc')->get();
        $num = 0;
        $view = '';
        $selected = '';
        $myurl =asset('/');

            
        

          

                $getordersdetail = ordersdetail::where('vendor_id', Auth::user()->id)->where('orderstatus', 'cancel')->first();
               // $vendorproduct = vendorproduct::where('id', $getordersdetail->product_id)->where('user_id', Auth::user()->id)->first();
                  $getordersdetail2 = ordersdetail::where('vendor_id', Auth::user()->id)->where('orderstatus', 'cancel')->get();

                    foreach ($getordersdetail2 as $key) {
                        

                        $vendorproduct2 = vendorproduct::where('id', $key->product_id)->where('user_id', Auth::user()->id)->first();
                        if ($vendorproduct2) {
                            
                            
                            $num += 1;
                            $quantity = number_format($key->quantity);
                            $price = number_format($key->totalprice);
                          
                            $statusofdelivery=orders::find($key->order_id);
                            $customer = User::where('id', $statusofdelivery->user_id)->first();

                            $view .= "<tr>
                                    <td>$num</td>
                                    <td>$key->ordernumber</td>
                                    <td>$key->ref_id</td>
                                    <td><a href='".$myurl."product/$vendorproduct2->slog'>$vendorproduct2->name</a></td>
                                    <td>$customer->name</td>
                                    <td>$quantity</td>
                                    <td>".HomeController::converter($key->totalprice)."</td>
                                    <td>$key->dateordered</td>
                                    <td>$key->order_cancel_reason</td>
                                    <td><a href='".$myurl."vendors/ordersdetail/$key->id' class='btn btn-primary btn-sm'>View</a></td>
                                    </tr><div class='modal fade' id='exampleModal-$statusofdelivery->id' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                              <div class='modal-dialog' role='document'>
                                                <div class='modal-content'>
                                                  <div class='modal-header'>
                                                    <h5 class='modal-title' id='exampleModalLabel'>Why you want to cancel this order?</h5>
                                                    
                                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                      <span aria-hidden='true'>&times;</span>
                                                    </button>
                                                  </div>
                                                  <div class='modal-body'>
                                                    <form action='".$myurl."/vendor/order/status/$statusofdelivery->id' method='POST'>
                                                       ". csrf_field(). "
                                                         <div class='form-group'>
                                                            <label for='message-text' class='col-form-label'></label>
                                                            <textarea class='form-control' id='message-text' cols='50' placeholder='Write this Reason' name='orderstatus'></textarea>
                                                          </div>
                                                    
                                                  </div>
                                                  <div class='modal-footer'>
                                                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                                   <button type='submit' class='btn btn-primary'>Cancel Order</button
                                                  </div>
                                                  </form>
                                                </div>
                                              </div>
                                            </div>";

                        
                    }

                    

               

                

            

            }
            return view('vendors.cancelledreason', compact('view'));

    }
    public function ordersdetail($id)
    {
        $num = 0;
            $view = '';

            $totalquantity = ordersdetail::where('id', $id)->sum('quantity');
            $totalprice = ordersdetail::where('id', $id)->sum('totalprice');
            $totalprice = ($totalprice);

            $key = ordersdetail::where('id', $id)->first();
            $getorders = orders::where('id', $key->order_id)->first();
            $getcustomer = User::where('id',$getorders->user_id)->first();
            $myurl =asset('/');

                    $num += 1;

                $view .= "<tr>";

                $getproducts = vendorproduct::where('id', $key->product_id)->first();
                $shipping=shipping::where('vendorproduct_id','=',$getproducts->id)->first();
                   $vendorname = vendors::where('user_id', $getproducts->user_id)->first();
                $products = products::where('id', $getproducts->product_id)->first();
                if (!empty($key->workplace_id)) {
                        $workplace = $key->workplace_id;
                    }else{
                        $workplace = '';
                    }

                if(!empty($getproducts->image)){
                    $image = $getproducts->image;
                }
                else{
                    $image = $products->image;
                }

                $price = ($key->totalprice);

          $view .= "<td>$num</td>
                    <td>$key->ordernumber</td>
                    <td class='table-shopping-cart-img'>
                        <a href='$myurl/product/$getproducts->slog'>
                            <img src='$myurl/$image' alt='Image Alternative text' style='height: 50px' title='Image Title' />
                            <br>
                            $products->name
                        </a>
                    </td>
                            <td>$vendorname->vendorname</td>
                    <td>$key->color</td>
                    <td>$key->quantity</td>
                    <td>".HomeController::converter($key->totalprice)."</td>
                    <td>$key->dateordered</td>
                    <td>$shipping->shipping_type</td>
                    <td>
                        <select class='deliverystatus form-control' id='$key->id'>
                            <option value='pending' ";
                            if ($key->deliverystatus == 'pending') {
                                $deliverydate = '';
                                $view .= "selected=selected";
                            }
                        $view .=">pending</option>
                            <option value='delivered' ";
                            if ($key->deliverystatus == 'delivered') {
                                $deliverydate = '<h6>Delivered on '.$key->deliverydate.'</h6>';
                                $view .= "selected=selected";
                            }
                        $view .=">delivered</option>
                        </select>
                        
                    </td>
                    </tr>";


        return view('vendors.ordersdetail', compact('view', 'totalquantity', 'totalprice', 'getorders', 'getcustomer'));
    }

    public function credit_customers()
    {
        $customersvendor = customersvendor::where('vendor_id', Auth::user()->id)->first();
        //dd($customersvendor);
        $view = '';
        $no = 0;
        $myurl =asset('/');
        if ($customersvendor) {
            
            $customersvendors = customersvendor::where('vendor_id', $customersvendor->vendor_id)->groupBy('customer_id')->get();
            //dd($customersvendors);
            foreach ($customersvendors as $key) {
                $getcustomer = User::where('id',$key->customer_id)->first();
                //dd($getcustomer);
                $no += 1;

                if ($key->status == 'pending') {
                    $status = "Pending";
                }elseif ($key->status == 'yes') {
                    # code...
                    $status = "Active";
                }
                elseif($key->status=='declined'){
                    $status='Decline';
                }

                $view .= "<tr>
                            <td>$no</td>
                            <td>$getcustomer->name</td>
                            <td>$status</td>
                            <td><a class='btn btn-xs' href='".$myurl."vendors/viewcustomers/$key->id'>View</a></td>
                            <td><form method='get' action='".$myurl."venodors/credit/customer/$key->id'><input type='text' name='update_credit' value='$key->limitted'></input><button class='btn btn-default' type='submit'>Update</button></form></td>
                            <td><a class='btn btn-xs' href='".$myurl."vendors/favourite'><i class='ti-heart gg' style='font-size:15px;";if ($key->favourite_customer == null) {
                                $view .= "color:black";
                            }else{
                                $view .= "color:red";
                               }$view .= "'></i></a></td>";
                            $view .= "<td>";
                                if ($key->reject == 1) {
                                    $view .= "<a href='".$myurl."vendors/accept/$key->id' onclick='kk($key->id)' class='btn btn-danger'>Reject</a>";
                                }else{
                                    $view .= "<a href='".$myurl."vendors/reject/$key->id' onclick='kk($key->id)' class='btn btn-success'>Accept</a>";
                                }

                             $view .= "</td>
                        </tr>";
            }

        }
        return view('vendors.credit_customers', compact('view'));
    }
    public function updatecredit(Request $request,$id){
        $vendorcustomer=customersvendor::find($id);
        $vendorcustomer->limitted=$request->update_credit;
        $vendorcustomer->save();
        return back();
    }

    public function viewcustomers($id)
    {
        $customersvendor = customersvendor::where('id', $id)->first();
        $getcustomer = User::where('id', $customersvendor->customer_id)->first();
        $customer=Customer::where('user_id','=',$getcustomer->id)->first();
        if ($customersvendor->status == 'pending') {
            $btn = "<td class='text-left'><span style='font-size: 16px'>Pending</span> <br>
                    </td>";
            $btn2 = "<button class='btn btn-sm btn-success acceptuser' id=$id>Accept</button> <button class='btn btn-sm btn-danger declineuser' id=$id>Decline</button>";
        }elseif ($customersvendor->status == 'yes') {
            $btn = "<td class='text-left'><span style='font-size: 16px'>Active</span></td>";
            $btn2 = "<button class='btn btn-sm btn-danger declineuser' id=$id>Decline</button>";
        }elseif ($customersvendor->status == 'declined') {
            $btn = "<td class='text-left'><span style='font-size: 16px'>Declined</span></td>";
            $btn2 = "<button class='btn btn-sm btn-success acceptuser' id=$id>Accept</button>";
        }

        return view('vendors.viewcustomers', compact('getcustomer', 'btn', 'btn2','customer'));
    }

    public function confirmcustomer()
    {
        $id = $_GET['id'];
        $value = $_GET['value'];
        $customer = customersvendor::where('id', $id)->first();
        $customersvendor = customersvendor::where('id', $id)->update(array('status' => $value));
        $customerverify = customersverification::where('user_id',$customer->customer_id)->update(array('verification' => $value));
       
        return $id;

    }
     public function bank()
    {
         $bankdetails = Bankdetails::where('user_id',Auth::User()->id)->first();
        return view('vendors.bank',compact('bankdetails'));
    }
    
    public function bank_store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'account_name' => 'required',
            'account_number' => 'required|numeric',
            'account_type' => 'required',
            'bank_name'=>'required',
        ]);
        $bankdetails = Bankdetails::where('user_id',Auth::User()->id)->first();
        if ($bankdetails == null) {
            $bank = new Bankdetails();
            $bank->name = $request->name;
            $bank->account_name = $request->account_name;
            $bank->account_number = $request->account_number;
            $bank->account_type = $request->account_type;
            $bank->bank_name=$request->bank_name;
            $bank->user_id = Auth::User()->id;
            $bank->save();
        }else{
            $bank = Bankdetails::find($bankdetails->id);
            $bank->name = $request->name;
            $bank->account_name = $request->account_name;
            $bank->account_number = $request->account_number;
            $bank->account_type = $request->account_type;
             $bank->user_id = Auth::User()->id;
            $bank->save();
        }

        

        return back()->with('status','Bankdetails Successfully updated');

    }

    public function favourite()
    {
        

        $customervendor = customersvendor::where('vendor_id',Auth::User()->id)->first();
        $customervendor->favourite_customer =    $customervendor->vendor_id;
        $customervendor->save();
        return back()->with('status','Your customer Successfully added your favourite list');
    }

    public function favourite_customer()
    {
       $favourite_customers = Auth::User()->customersvendors;
       return view('vendors.favourite',compact('favourite_customers'));
    }

    public function customer_create()
    {
       $customers = User::where('user_type','Customer')->get();
       return view('vendors.customer_create',compact('customers'));
    }

    public function customer_store(Request $request)
    {
        $customersvendor = new customersvendor();
        $customersvendor->customer_id = $request->customer_id;
        $customersvendor->vendor_id = Auth::User()->id;
        $customersvendor->status = $request->status;
        $customersvendor->verification = 'pending';
        $customersvendor->save();

        return redirect('vendors/credit_customers')->with('status','kkk');
    }
     public function reject($id)
    {
       $reject =  customersvendor::find($id);
       $reject->reject = 1;
       $reject->save();
       return back()->with('status','suessfully reject');
    }

    public function accept($id)
    {
        $reject =  customersvendor::find($id);
       $reject->reject = 0;
       $reject->save();
       return back()->with('status','suessfully Accept');
    }
    public function promote_product($id){
       $product=vendorproduct::find($id);
       $product->promotion=1;
       $product->save();
       return back()->with('status','Successfully Sent to admin for promotion!');
    }
    public function deactive_product($id){
        $product=vendorproduct::find($id);
        $product->availability='no';
       $save= $product->save();
      
        return back();
    }
    public function active_product($id){
        $product=vendorproduct::find($id);
        $product->availability='yes';
        $product->save();
        return back();
    }
}





































