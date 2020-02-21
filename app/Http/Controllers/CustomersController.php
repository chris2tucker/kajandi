<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facade;
use App\category;
use App\subcategory;
use App\vendors;
use App\User;
use App\productmodel;
use App\products;
use App\vendorproduct;
use App\condition;
use App\productmanufacturer;
use App\productaddon;
use App\source;
use App\strengthofmaterial;
use App\customersvendor;
use App\productimages;
use App\Role;
use App\carts;
use App\ordersdetail;
use App\orders;
use App\workplace;
use App\review;
use App\orderpayment;
use App\wallet;
use App\wallethistory;
use App\walletusers;
use App\outstandingpayment;
use App\customersverification;
use Cart;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Customer_QA;
use Response;
use App\commission;
use App\accounts;
use App\PaymentDeliveryInformation;
use App\Customer;
use Session;
use App\currency;
use App\shipping;
use App\rfq;
use App\rfqvendor;
use App\favoritevendor;
use carbon\Carbon;
use App\term;
use App\wishlist;
use App\Notification;
use App\shippingInformations;
use Illuminate\Support\Facades\Mail;
use App\Mail\rfqMail;
use App\mannual_shipping;
use App\city;
use App\state;
class CustomersController extends Controller
{


	public function addvendorproduct()
    {
        $productid = $_GET['productid'];  
        $productqty = $_GET['productqty'];     
        $paymentid = $_GET['paymentid'];
        //$price = $_GET['price']; 
        $getproducts = vendorproduct::where('id', $productid)->first();
        $slog = $getproducts->slog;
        $products = products::where('id', $getproducts->product_id)->first();
        $paymentids = '';


        if (Auth::check()) {
            
            $getcart = carts::where('product_id', $productid)->where('user_id', Auth::user()->id)->where('payoptions', $paymentid)->first();
            
            if ($paymentid == 1) {
                $newtotal = $getproducts->price;
                $paymentid = 1;
            }else{

                //to get verification access
                $getcustomersvendoreaccess = customersverification::where('user_id', Auth::user()->id)->where('verification', 'yes')->first();
                if ($getcustomersvendoreaccess) {

                    //to get if the vendor is the customer's vendor
                    $customersvendor = customersvendor::where('customer_id', Auth::user()->id)->where('status', 'yes')->first();
                    if ($customersvendor) {

                        //to get if the user has an outstanding payment
                       $outstandingpayment = DB::table('outstandingpayment')->where('user_id', Auth::user()->id)->where('payment', 'pending')->where('duedate','<',Carbon::today()->toDateString())->sum('totalprice');
                                            $limit = DB::table('outstandingpayment')->where('user_id', Auth::user()->id)->where('payment', 'pending')->where('duedate','>',Carbon::today()->toDateString())->sum('totalprice');
                        if ($outstandingpayment>0 || $limit>=$customersvendor->limitted) {
                        
                            $newtotal = $getproducts->price;
                            $paymentid = 1;
                        }else{

                            if ($paymentid == 2) {
                                $newtotal = $getproducts->pricewithin15days;
                                $paymentid = 2;
                            }elseif ($paymentid = 3){
                                $newtotal = $getproducts->pricewithin30days;
                                $paymentid = 3;
                            }

                        }

                    }else{
                        $newtotal = $getproducts->price;
                        $paymentid = 1;
                    }

                }else{
                         if ($paymentid == 2) {
                                $newtotal = $getproducts->pricewithin15days;
                                $paymentid = 2;
                            }elseif ($paymentid = 3){
                                $newtotal = $getproducts->pricewithin30days;
                                $paymentid = 3;
                            }
                }

            }
            

        if ($getcart) {
            $getcartqty = $getcart->quantity;
            $newqty = $getcartqty + $productqty;
            $totalprice = $newqty * $newtotal;


            $updatecart = carts::where('product_id', $productid)->where('user_id', Auth::user()->id)->where('payoptions', $paymentid)->update(array('quantity' =>  $newqty, 'totalprice' => $totalprice));
        }else{

            $totalamt = $newtotal * $productqty;

            $cart = new carts;
            $cart->user_id = Auth::user()->id;
            $cart->product_id = $productid;
            $cart->price = $newtotal;
            $cart->quantity = $productqty;
            $cart->totalprice = $totalamt;
            $cart->payoptions = $paymentid;
            $cart->save();
        }

        }else{
            $newtotal = $getproducts->price;
            $cart = Cart::add($productid, $products->name, $productqty, $newtotal, ['size' => $slog]);
        }

    }

    public function viewcart()
    {
        if(Auth::check()){
            $user=Auth::user();
            $cus=customer::where('user_id','=',$user->id)->first();
            if($cus){
                if($cus->city && $cus->state){

                }
                else{
                    return redirect('customers/profile')->with('message','Please update your profile first');
                }
            }
        }
        $view = '';
        $totalamt = 0;
        $subtotal = 0;
        $totalshipping=0;
        $notNew = false;
        $tax = '';
        $myurl =  asset('/');
        if (Auth::check()) {
            $cartbag = 'not empty';
            $shipping=0;
            $totalshipping=0;
            $getcart = carts::where('user_id', Auth::user()->id)->first();
            if ($getcart) {
                $getcart = carts::where('user_id', Auth::user()->id)->get();

                foreach($getcart as $row) {

                    $getproducts = vendorproduct::where('id', $row->product_id)->first();
                    $condition=condition::find($getproducts->condition_id);
                    if ($condition->name != 'New' && !$notNew) {
                        $notNew = true;
                    }
                    $PaymentDeliveryInformation=PaymentDeliveryInformation::where('product_id','=',$getproducts->product_id)->first();
        $products = products::where('id', $getproducts->product_id)->first();
        $shipping_type=shipping::where('vendorproduct_id','=',$getproducts->id)->first();
        
        if($row->payoptions==1){
          
        if($PaymentDeliveryInformation->payment_mehod){
            if($PaymentDeliveryInformation->payment_mehod=='COD'){
                if($row->payondelivery !=NULL){
                    $checked='checked';
                }
                else{
                    $checked='';
                }
                $paymentondelivery='<form action="'.$myurl.'/payondeliver/'.$row->id.'" method="POST" accept-charset="utf-8">
                    '.csrf_field().'
                    <input name="isondelivery" type="checkbox"'.$checked.' value="pay on delivery">Pay on delivery
                    <button type="submit" class="btn btn-xs btn-default">update</button>

                </form>';
            }
            else{
                $paymentondelivery='Payment on delivery not available';
            }
        }
        else{
            $paymentondelivery='Payment on delivery not available';
        }
    }else{
        $paymentondelivery='Payment on delivery not available';
    }
        if($getproducts->deliveryratestate==NULL){
            $stateDeliveryrate=0;
        }
        else{
            $stateDeliveryrate=(float)$getproducts->deliveryratestate;
        }
        if($getproducts->deliveryrateoutsidegeo==NULL){
            $deliveryrateoutstategeo=0;
        }
        else{
            $deliveryrateoutstategeo=(float)$getproducts->deliveryrateoutsidegeo;
        }
        if($getproducts->deliveryrateoutstatewithgeo==NULL){
            $deliveryrateoutstatewithgeo=0;
        }
        else{
            $deliveryrateoutstatewithgeo=(float)$getproducts->deliveryrateoutstatewithgeo;
        }
//shipping calculation goes

        if($shipping_type){
        if($shipping_type->shipping_type=='free'){
            $shipping=$shipping+0;
        }
        else if($shipping_type->shipping_type=='Vendor_shipping'){
            $customer=Customer::where('user_id','=',Auth::user()->id)->first();

             $vendor=vendors::where('user_id','=',$getproducts->user_id)->first();
             $city=city::where('name','=',$customer->billing_city)->first();
             if($city){
                $state=state::where('name','=',$city->state_name)->first();
                $vendorstate=state::where('name','=',$vendor->state)->first();
             }

             $state_zone=shippingInformations::where('city',$customer->billing_city)->first();
             if($vendor->location==$customer->billing_city){
                $shipping=$shipping+$stateDeliveryrate;
             }
             else if($state->zone == $vendorstate->zone){
                 $shipping=$shipping+$deliveryrateoutstatewithgeo;
             }
             else {

                 $shipping=$shipping+$deliveryrateoutstategeo;
             }
            
        }
        else if($shipping_type->shipping_type=='company_shipping'){
           $customer=Customer::where('user_id','=',Auth::user()->id)->first();
            $city=city::where('name','=',$customer->billing_city)->first();
             if($city){
                $state=state::where('name','=',$city->state_name)->first();
             }
            $shippinginfos=shippingInformations::where('zone',$state->zone)->first();
            if($shippinginfos){

                if($shippinginfos->zone !=NULL){
                    
                    $shipping=$shipping+($shippinginfos->ammount_per_kg*$products->weight+$shippinginfos->volume*$products->length)+$deliveryrateoutstatewithgeo;
                   
                }
                else{
                    $shipping=$shipping+($shippinginfos->ammount_per_kg*$products->weight+$shippinginfos->volume*$products->length)+$deliveryrateoutstategeo;
                }
                
            }
        }
        else if($shipping_type->shipping_type=='mannual_shipping'){
             $customer=Customer::where('user_id','=',Auth::user()->id)->first();
           $manual_shipping=mannual_shipping::where('city','=',$customer->billing_city)->where('vendorproduct_id','=',$getproducts->product_id)->first();
           if($manual_shipping){
           $shipping=$shipping+$manual_shipping->shipping;
       }
       else{
        $shipping=$shipping+0;
       }
        }
    }
   
    $shipping=$shipping*$row->quantity;
    $totalshipping=$totalshipping+$shipping;
    $shipping=0;
        if(!empty($getproducts->image)){
            $image = $getproducts->image;
        }
        else{
            $image = $products->image;
        }

            $price = ($row->price);
            $total = ($row->totalprice);
            if($row->payoptions==1){
            if($row->payondelivery==NULL){
            $totalamt += $row->totalprice;
            $subtotal += $row->totalprice;
        }
        else{
             $totalamt += 0;
            $subtotal += 0;
        }
    }
    else{
         $totalamt += 0;
            $subtotal += 0;
    }
            $tax = '0.00';
            //payment type instant or 15 days or 30 day

            if($row->payoptions==1){
                $type='Instant Payment';
            }
             else if($row->payoptions==2){
                $type='15 Days Payment';
            }
            else{
                $type='30 Days Payment';
            }

            if(Session::has('currency')){
                                    $getPrice=currency::find(1);
                                    if(Session::get('currency')=='Dollar'){
                                    $price="$ ".number_format($price*$getPrice->Dollar);
                                    $total="$ ".number_format($total*$getPrice->Dollar);
                                   
                                    }
                                    else if(Session::get('currency')=='Yen'){
                                    $price="¥ ".number_format($price*$getPrice->Yen);
                                    $total="¥ ".number_format($total*$getPrice->Yen);
                                    
                                }
                                else if(Session::get('currency')=='Euro'){
                                $price="€ ".number_format($price*$getPrice->Euro);
                                $total="€ ".number_format($total*$getPrice->Euro);
                                
                            }
                            else{
                            $price="₦ ".number_format($price);
                            $total="₦ ".number_format($total);
                           
                        }
                                    }
                                    else{
                                     $price="₦ ".number_format($price);
                                     $total="₦ ".number_format($total);
                                     
                                }
                                if($getproducts->stock_count>$PaymentDeliveryInformation->minimum_order_quantity){
                                                    $max=$getproducts->stock_count;
                                                }
                                                else{
                                                    $max=$PaymentDeliveryInformation->minimum_order_quantity;
                                                } 
            $view .= "<tr>      
                        <td class='table-shopping-cart-img'>
                            <a href='$myurl/product/$getproducts->slog'>
                                <img src='$myurl/$image' alt='Image Alternative text' title='Image Title' />
                            </a>
                        </td>
                        <td class='table-shopping-cart-title'><a href='$myurl/product/$getproducts->slog'>$products->name</a>
                            <small class='text-sm ".($condition->name !== 'New' ? 'text-danger' : '' )."'>($condition->name)</small>

                        </td>
                        <td>".HomeController::converter($row->price)."</td>
                        <td>
                            <input class='form-control table-shopping-qty shoppingqty prod$row->id' id=$row->id  type='number' style='width: 60px !important' value='$row->quantity' max='$max' min='$PaymentDeliveryInformation->minimum_order_quantity' onkeydown='return false'/>
                            <button type='button' style='display: none' id=$row->id class='btn btn-xs btn-default updateproduct upd$row->id'>update</button>
                        </td>
                        <td>".HomeController::converter($row->totalprice)."</td>
                        <td>$type</td>
                        <td>$paymentondelivery</td>
                        <td>";

             $view .=  \Form::open(['url' => '/deleteproduct']);
              $view .=   "<input type='hidden' name='productid' value=$row->product_id><button class='btncart'><span class='fa fa-close table-shopping-remove'><input type='hidden' name='payment' class='payment' value=$row->payoptions></span></button>";
              $view .=  \Form::close();
               $view .=   "</td>
                    </tr>";

                }
            $totalamt = $totalamt+$totalshipping;
            $subtotal =$subtotal;
            }
            else{
                $cartbag = '';

        $view = "<div class='text-center'><i class='fa fa-cart-arrow-down empty-cart-icon'></i>
                <p class='lead'>You haven't Fill Your Shopping Cart Yet</p><a class='btn btn-primary btn-lg' href='$myurl'>Start Shopping <i class='fa fa-long-arrow-right'></i></a>
            </div>";
            }
        }else{

        $getcart = Cart::count();
        $shipping=0;
           if ($getcart >= 1) {
                $cartbag = 'not empty';
                
        foreach(Cart::content() as $row) {

        $getproducts = vendorproduct::where('id', $row->id)->first();
            $condition=condition::find($getproducts->condition_id);
            if ($condition->name != 'New' && !$notNew) {
                $notNew = true;
            }
            $PaymentDeliveryInformation=PaymentDeliveryInformation::where('product_id','=',$getproducts->product_id)->first();
        $products = products::where('id', $getproducts->product_id)->first();
        $shipping_type=shipping::where('vendorproduct_id','=',$getproducts->id)->first();
        
        //shipping calculation goes
        if($shipping_type){
        if($shipping_type->shipping_type=='free'){
            $shipping=$shipping+0;
        }
        else if($shipping_type->shipping_type=='Vendor_shipping'){

            $PublicIP=$_SERVER['REMOTE_ADDR'];
             $json  = file_get_contents("http://ipinfo.io/$PublicIP/geo");
             $json  =  json_decode($json ,true);
             if(isset($json['country'])){
             $country =  $json['country'];
             $region= $json['region'];
             $city = $json['city'];
             $state_zone=shippingInformations::where('city',$city)->first();
             $vendor=vendors::where('user_id','=',$getproducts->user_id)->first();
             if($vendor->location==$city){
                $shipping=$shipping+$stateDeliveryrate;
             }
             else if($state_zone->zone=='geopolite-zone'){
                 $shipping=$shipping+$deliveryrateoutstatewithgeo;
             }
             else {

                 $shipping=$shipping+$$deliveryrateoutstategeo;
             }
            }
        }
        else if($shipping_type->shipping_type=='company_shipping'){
            $PublicIP=$_SERVER['REMOTE_ADDR'];
             $json  = file_get_contents("http://ipinfo.io/$PublicIP/geo");
             $json  =  json_decode($json ,true);
             if(isset($json['country'])){
             $country =  $json['country'];
             $region= $json['region'];
             $city = $json['city'];
            $shippinginfos=shippingInformations::where('city',$city)->first();
            if($shippinginfos){

                if($shippinginfos->zone=='geopolite-zone'){
                    
                    $shipping=$shipping+($shippinginfos->ammount_per_kg*$products->weight+$shippinginfos->volume*$products->length)+$deliveryrateoutstatewithgeo;
                   
                }
                else{
                    $shipping=$shipping+($shippinginfos->ammount_per_kg*$products->weight+$shippinginfos->volume*$products->length)+$deliveryrateoutstategeo;
                }
                
            }
        }
        }
        else if($shipping_type->shipping_type=='mannual_shipping'){
            $PublicIP=$_SERVER['REMOTE_ADDR'];
             $json  = file_get_contents("http://ipinfo.io/$PublicIP/geo");
             $json  =  json_decode($json ,true);
             if(isset($json['country'])){
             $country =  $json['country'];
             $region= $json['region'];
             $city = $json['city'];
           $manual_shipping=mannual_shipping::where('city','=',$city)->where('vendorproduct_id','=',$getproducts->product_id)->first();
           if($manual_shipping){
           $shipping=$shipping+$manual_shipping->shipping;
       }
   }
}
else{
    $shipping=$shipping+0;
}
}
$shipping=$shipping*$row->quantity;
$totalshipping=$totalshipping+$shipping;
        if(!empty($getproducts->image)){
            $image = $getproducts->image;
        }
        else{
            $image = $products->image;
        }

            $price = number_format($row->price);
            $total = number_format($row->total);

            $subtotal = Cart::subtotal();
            $tax = Cart::tax();

            $totalamt = Cart::total();
            $names = $row->options->size;
            if(Session::has('currency')){
                                    $getPrice=currency::find(1);
                                    if(Session::get('currency')=='Dollar'){
                                    $price="$ ".$price*$getPrice->Dollar;
                                    $total="$ ".$total*$getPrice->Dollar;
                                    }
                                    else if(Session::get('currency')=='Yen'){
                                    $price="¥ ".$price*$getPrice->Yen;
                                    $total="¥ ".$total*$getPrice->Yen;
                                }
                                else if(Session::get('currency')=='Euro'){
                                $price="€ ".$price*$getPrice->Euro;
                                $total="€ ".$total*$getPrice->Euro;
                            }
                            else{
                            $price="₦ ".$price;
                            $total="₦ ".$total;
                        }
                                    }
                                    else{
                                     $price="₦ ".$price;
                                     $total="₦ ".$total;
                                }
            $view .= "<tr>      
                        <td class='table-shopping-cart-img'>
                            <a href='$myurl/product/$names'>
                                <img src='$myurl/$image' alt='Image Alternative text' title='Image Title' />
                            </a>
                        </td>
                        <td class='table-shopping-cart-title'><a href='$myurl/product/$names'>$row->name</a>
                        <small class='text-sm ".($condition->name !== 'New' ? 'text-danger' : '' )."'>($condition->name)</small>
                        </td>
                        <td> $price</td>
                        <td>
                            <input class='form-control table-shopping-qty shoppingqty prod$row->rowId' id=$row->rowId  type='number' style='width: 60px !important' value='$row->qty' max='$getproducts->stock_count' min='$PaymentDeliveryInformation->minimum_order_quantity' onkeydown='return false' />
                            <button type='button' style='display: none' id=$row->rowId class='btn btn-xs btn-default updateproduct upd$row->rowId'>update</button>
                        </td>
                        <td>$total</td>
                        <td></td>
                        <td></td>
                        <td>";
            $view .=  \Form::open(['url' => '/deleteproduct']);
              $view .=   "<input type='hidden' name='productid' value=$row->rowId><button class='btncart'><span class='fa fa-close table-shopping-remove'></span></button>";
              $view .=  \Form::close();
               $view .=   "</td>
                    </tr>";
        }
    }else{
        $cartbag = '';
        $totalshipping=0;
        $view = "<div class='text-center'><i class='fa fa-cart-arrow-down empty-cart-icon'></i>
                <p class='lead'>You haven't Fill Your Shopping Cart Yet</p><a class='btn btn-primary btn-lg' href='$myurl'>Start Shopping <i class='fa fa-long-arrow-right'></i></a>
            </div>";

    }
    }
    $cart = HomeController::cart();
        return view('cart/viewcart', compact('view', 'cartbag', 'totalamt', 'subtotal', 'tax', 'cart','totalshipping', 'notNew'));
    
    }

    public function updateproduct()
    {
        $productid = $_GET['productid'];
        $quantity = $_GET['quantity'];

        if (Auth::check()) {
        
            $getcart = carts::where('id', $productid)->first();
            $price = $getcart->price * $quantity;
            $cart = carts::where('id', $productid)->where('user_id', Auth::user()->id)->update(array('totalprice' => $price, 'quantity' => $quantity));

        }else{
            $getcart = Cart::get($productid);
            Cart::update($productid, $quantity);

        }

        return "<p class='bg-success' style='padding: 3px'>Updated Successfully</p>";

    }

    public function checkout()
    {
        
        $view = '';
        $totalamt = 0;
        $subtotal = 0;
        $tax = '';
        $shipping=0;
        $totalshipping=0;
        if (Auth::check()) {
            $cartbag = 'not empty';
            $getcart = carts::where('user_id', Auth::user()->id)->first();
            if(!$getcart){
                return redirect('/');
            }
            if ($getcart) {
                $getcart = carts::where('user_id', Auth::user()->id)->get();

                foreach($getcart as $row) {

                    $getproducts = vendorproduct::where('id', $row->product_id)->first();
        $products = products::where('id', $getproducts->product_id)->first();
        $shipping_type=shipping::where('vendorproduct_id','=',$getproducts->id)->first();
         if($getproducts->deliveryratestate==NULL){
            $stateDeliveryrate=0;
        }
        else{
            $stateDeliveryrate=(float)$getproducts->deliveryratestate;
        }
        if($getproducts->deliveryrateoutsidegeo==NULL){
            $deliveryrateoutstategeo=0;
        }
        else{
            $deliveryrateoutstategeo=(float)$getproducts->deliveryrateoutsidegeo;
        }
        if($getproducts->deliveryrateoutstatewithgeo==NULL){
            $deliveryrateoutstatewithgeo=0;
        }
        else{
            $deliveryrateoutstatewithgeo=(float)$getproducts->deliveryrateoutstatewithgeo;
        }
//shipping calculation goes

        if($shipping_type){
        if($shipping_type->shipping_type=='free'){
            $shipping=$shipping+0;
        }
        else if($shipping_type->shipping_type=='Vendor_shipping'){
            $customer=Customer::where('user_id','=',Auth::user()->id)->first();
             $vendor=vendors::where('user_id','=',$getproducts->user_id)->first();
             $city=city::where('name','=',$customer->billing_city)->first();
             if($city){
                $state=state::where('name','=',$city->state_name)->first();
                $vendor_state=state::where('name','=',$vendor->state)->first();
             }

             $state_zone=shippingInformations::where('city',$customer->billing_city)->first();
             if($vendor->location==$customer->billing_city){
                $shipping=$shipping+$stateDeliveryrate;
             }
             else if($state->zone ==$vendor_state->zone){
               
                 $shipping=$shipping+$deliveryrateoutstatewithgeo;
             }
             else {

                 $shipping=$shipping+$deliveryrateoutstategeo;
             }
            
        }
        else if($shipping_type->shipping_type=='company_shipping'){
           $customer=Customer::where('user_id','=',Auth::user()->id)->first();
            $city=city::where('name','=',$customer->billing_city)->first();
             if($city){
                $state=state::where('name','=',$city->state_name)->first();
             }
            $shippinginfos=shippingInformations::where('zone',$state->zone)->first();
            if($shippinginfos){

                if($shippinginfos->zone !=NULL){
                    
                    $shipping=$shipping+($shippinginfos->ammount_per_kg*$products->weight+$shippinginfos->volume*$products->length)+$deliveryrateoutstatewithgeo;
                   
                }
                else{
                    $shipping=$shipping+($shippinginfos->ammount_per_kg*$products->weight+$shippinginfos->volume*$products->length)+$deliveryrateoutstategeo;
                }
                
            }
        }
        else if($shipping_type->shipping_type=='mannual_shipping'){
             $customer=Customer::where('user_id','=',Auth::user()->id)->first();
           $manual_shipping=mannual_shipping::where('city','=',$customer->billing_city)->where('vendorproduct_id','=',$getproducts->product_id)->first();
           if($manual_shipping){
           $shipping=$shipping+$manual_shipping->shipping;
       }
       else{
        $shipping=$shipping+0;
       }
        }
    }
    else{
        $shipping=$shipping+0;
    }
   
    $shipping=$shipping*$row->quantity;
    $totalshipping=$totalshipping+$shipping;
    $shipping=0;
$ship=$totalshipping;
            $price = ($row->price);
            $total = ($row->totalprice);
            if ($row->payoptions == 1) {
                # code...
                if($row->payondelivery==NULL){
                $subtotal += $row->totalprice;
            }
            else{
                $subtotal+=0;
            }
            }
            if($row->payoptions==1){
            if($row->payondelivery==NULL){
                $totalamt += $row->totalprice;
            }
            else{
                $totalamt += 0;
            }
        }
        else{
            $totalamt +=0;
        }
            
            if(Session::has('currency')){
                                    $getPrice=currency::find(1);
                                    if(Session::get('currency')=='Dollar'){
                                    $total="$ ".$total*$getPrice->Dollar;
                                    }
                                    else if(Session::get('currency')=='Yen'){
                                    $total="¥ ".$total*$getPrice->Yen;
                                }
                                else if(Session::get('currency')=='Euro'){
                                $total="€ ".$total*$getPrice->Euro;
                            }
                            else{
                            $total="₦ ".$total;
                        }
                                    }
                                    else{
                                     $total="₦ ".$total;
                                }
            $tax = '0.00';
            $view .= "<tr>
                        <td>$products->name</td>
                        <td>$row->quantity</td>
                        <td>$total</td>
                    </tr>";

                }
            $totalamt = ($totalamt+$totalshipping);
            $subtotal = ($subtotal);
            
            $view .= "<tr>
                        <td>Subtotal</td>
                        <td></td>
                        <td>".HomeController::converter($subtotal)."</td>
                    </tr>
                    <tr>
                        <td>Shipping</td>
                        <td></td>
                        <td>".HomeController::converter($totalshipping)."</td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td></td>
                        <td> ".HomeController::converter($totalamt)."</td>
                    </tr>";
            }
            else{
                $cartbag = '';

        $view = "<div class='text-center'><i class='fa fa-cart-arrow-down empty-cart-icon'></i>
                <p class='lead'>You haven't Fill Your Shopping Cart Yet</p><a class='btn btn-primary btn-lg' href='#'>Start Shopping <i class='fa fa-long-arrow-right'></i></a>
            </div>";
            }
        }else{

        $getcart = Cart::count();

            if ($getcart >= 1) {
                $cartbag = 'not empty';

        foreach(Cart::content() as $row) {


        $getproducts = vendorproduct::where('id', $row->id)->first();
        $products = products::where('id', $getproducts->product_id)->first();
$shipping_type=shipping::where('vendorproduct_id','=',$getproducts->id)->first();
        
//shipping calculation goes
        if($shipping_type->shipping_type=='free'){
            $shipping=$shipping+0;
        }
        else if($shipping_type->shipping_type=='Vendor_shipping'){
            $PublicIP=$_SERVER['REMOTE_ADDR'];
             $json  = file_get_contents("http://ipinfo.io/$PublicIP/geo");
             $json  =  json_decode($json ,true);
             if(isset($json['country'])){
             $country =  $json['country'];
             $region= $json['region'];
             $city = $json['city'];
             $vendor=vendors::where('user_id','=',$getproducts->user_id)->first();
             $city=city::where('name','=',$city)->first();
             if($city){
                $state=state::where('name','=',$city->state_name)->first();
             }
             if($vendor->location==$city){
                $shipping=$shipping+$getproducts->deliveryratestate;
             }
             else if(isset($state)){
                if($state->zone !=NULL){
                 $shipping=$shipping+$getproducts->deliveryrateoutstategeo;
                }
                else{
                 $shipping=$shipping+$getproducts->deliveryrateoutsidegeo;

                }
             }
             else {
                 $shipping=$shipping+$getproducts->deliveryrateoutsidegeo;
             }
            }
        }
        else if($shipping_type->admin){
            $PublicIP=$_SERVER['REMOTE_ADDR'];
             $json  = file_get_contents("http://ipinfo.io/$PublicIP/geo");
             $json  =  json_decode($json ,true);
             if(isset($json['country'])){
             $country =  $json['country'];
             $region= $json['region'];
             $city = $json['city'];
            $shippinginfos=shippingInformations::all();
            foreach ($shippinginfos as $value) {
                if($value->city==$city){
                    $shipping=$shipping+($value->ammount_per_kg*$products->weight+$value->volume*$products->length);
                    break 2;
                }
            }
        }
        }
        

            $price = number_format($row->price);
            $total = number_format($row->total);
            $subtotal = Cart::subtotal();
            $tax = Cart::tax();
            $totalamt = Cart::total()+$shipping;
            $view .= "<tr>
                        <td>$row->name</td>
                        <td>$row->qty</td>
                        <td>$ $total</td>
                    </tr>";
        }
            $view .= "<tr>
                        <td>Subtotal</td>
                        <td></td>
                        <td>$ $totalamt</td>
                    </tr>
                    <tr>
                        <td>Shipping</td>
                        <td></td>
                        <td>$shipping</td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td></td>
                        <td>$ $totalamt</td>
                    </tr>";
    }else{
        $cartbag = '';

        $view = "<div class='text-center'><i class='fa fa-cart-arrow-down empty-cart-icon'></i>
                <p class='lead'>You haven't Fill Your Shopping Cart Yet</p><a class='btn btn-primary btn-lg' href='#'>Start Shopping <i class='fa fa-long-arrow-right'></i></a>
            </div>";

    }
    }
        
        $cart = HomeController::cart();
        return view('cart/checkout', compact('cartbag', 'view', 'cart','ship'));
    }

    public function checkoutorder(Request $request)
    {
        # code...

        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'state' => 'required',
            'city' => 'required',
            'address' => 'required'
            ]);
        $shipping=0;
        $totalshipping=0;
            $getcart = carts::where('user_id', Auth::user()->id)->first();
            if ($getcart) {
                $getcart = carts::where('user_id', Auth::user()->id)->get();

                foreach($getcart as $row) {

                    $getproducts = vendorproduct::where('id', $row->product_id)->first();
        $products = products::where('id', $getproducts->product_id)->first();
        $shipping_type=shipping::where('vendorproduct_id','=',$getproducts->id)->first();
         if($getproducts->deliveryratestate==NULL){
            $stateDeliveryrate=0;
        }
        else{
            $stateDeliveryrate=(float)$getproducts->deliveryratestate;
        }
        if($getproducts->deliveryrateoutsidegeo==NULL){
            $deliveryrateoutstategeo=0;
        }
        else{
            $deliveryrateoutstategeo=(float)$getproducts->deliveryrateoutsidegeo;
        }
        if($getproducts->deliveryrateoutstatewithgeo==NULL){
            $deliveryrateoutstatewithgeo=0;
        }
        else{
            $deliveryrateoutstatewithgeo=(float)$getproducts->deliveryrateoutstatewithgeo;
        }
//shipping calculation goes

        if($shipping_type){
        if($shipping_type->shipping_type=='free'){
            $shipping=$shipping+0;
        }
        else if($shipping_type->shipping_type=='Vendor_shipping'){
        
             $vendor=vendors::where('user_id','=',$getproducts->user_id)->first();
             $city=city::where('name','=',$request->city)->first();
             if($city){
                $state=state::where('name','=',$city->state_name)->first();
                $vendor_state=state::where('name','=',$vendor->state)->first();
             }

             $state_zone=shippingInformations::where('city',$request->city)->first();
             if($vendor->location==$request->city){
                $shipping=$shipping+$stateDeliveryrate;
             }
             else if($state->zone == $vendor_state->zone){
                 $shipping=$shipping+$deliveryrateoutstatewithgeo;
             }
             else {

                 $shipping=$shipping+$deliveryrateoutstategeo;
             }
            
        }
        else if($shipping_type->shipping_type=='company_shipping'){
         //  $customer=Customer::where('user_id','=',Auth::user()->id)->first();
            $city=city::where('name','=',$request->city)->first();
             if($city){
                $state=state::where('name','=',$city->state_name)->first();
             }
            $shippinginfos=shippingInformations::where('zone',$state->zone)->first();
            if($shippinginfos){

                if($shippinginfos->zone !=NULL){
                    
                    $shipping=$shipping+($shippinginfos->ammount_per_kg*$products->weight+$shippinginfos->volume*$products->length)+$deliveryrateoutstatewithgeo;
                   
                }
                else{
                    $shipping=$shipping+($shippinginfos->ammount_per_kg*$products->weight+$shippinginfos->volume*$products->length)+$deliveryrateoutstategeo;
                }
                
            }
        }
        else if($shipping_type->shipping_type=='mannual_shipping'){
           //  $customer=Customer::where('user_id','=',Auth::user()->id)->first();
           $manual_shipping=mannual_shipping::where('city','=',$request->city)->where('vendorproduct_id','=',$getproducts->product_id)->first();
           if($manual_shipping){
           $shipping=$shipping+$manual_shipping->shipping;
       }
       else{
        $shipping=$shipping+0;
       }
        }
    }
    else{
        $shipping=$shipping+0;
    }
   
    $shipping=$shipping*$row->quantity;
    $totalshipping=$totalshipping+$shipping;
    $shipping=0;
}
}
        $orders = new orders;
        $orders->user_id = Auth::user()->id;
        $orders->paymenttype = 'offline';
        $orders->phone = request('phone');
        $orders->shipaddress = request('address');
        $orders->ordercity = request('city');
        $orders->orderstate = request('state');
        $orders->orderstatus = 'active';
        $orders->dateordered = date('Y/m/d');
        $orders->deliverystatus = 'pending';
        $orders->shipping_fee=$totalshipping;
        $orders->save();
        $notification = new Notification();
        $notification->user_id = 40;
        $notification->notification = Auth::User()->name." added a new order";
        $notification->save();
        $order_id = $orders->id;
        $ordernumber = time().''.$order_id;

        $updateorder = orders::where('id', $order_id)->update(array('ordernumber' => $ordernumber));

        $getcart = carts::where('user_id', Auth::user()->id)->first();
            if ($getcart) {
                $getcart = carts::where('user_id', Auth::user()->id)->get();

                foreach($getcart as $row) {


        $vendorproduct = vendorproduct::find($row->product_id);
        $vendors = vendors::where('user_id', $vendorproduct->user_id)->first();
        $catagory = category::where('id',$vendorproduct->category)->first();
        $subcategory = subcategory::where('id',$vendorproduct->subcategory)->first();
         $order_vendor = Orders::find($orders->id);
                $order_vendor->vendor_id = $vendors->user_id;
                $order_vendor->save();

        if(!empty($vendorproduct->commision))
        {
            $commission = $vendorproduct->commision;
        }elseif(!empty($subcategory->sub_commission)){

            $commission = $subcategory->sub_commission;
        }else{

            $commission = $catagory->catagory_comission;
        }
        $commission_cal = $row->totalprice*$commission/100;

        $commission_amount = $row->totalprice-$commission_cal;

        $ordersdetail = new ordersdetail;
        $ordersdetail->order_id = $order_id;
        $ordersdetail->ordernumber = $ordernumber;
        $ordersdetail->product_id = $row->product_id;
        $ordersdetail->price = $row->price;
        $ordersdetail->quantity = $row->quantity;
        $ordersdetail->totalprice = $row->totalprice;
        $ordersdetail->dateordered = date('Y/m/d');
        $ordersdetail->deliverystatus = 'pending';
        $ordersdetail->payoptions = $row->payoptions;
        $ordersdetail->commission = $commission_cal;
        $ordersdetail->payondelivery=$row->payondelivery;
        $ordersdetail->total_price_without_comission = $commission_amount;
        $ordersdetail->vendor_id=$vendorproduct->user_id;
        $ordersdetail->deliverystatus='pending';
        if($row->payondelivery=='pay on delivery'){
            $ordersdetail->ispaid=1;
        }
        $ordersdetail->save();
        $ref_id = $ordernumber.''.$ordersdetail->id;
        $getordersdetail = ordersdetail::where('id', $ordersdetail->id)->update(array('ref_id' => $ref_id));

        $accounts = accounts::where('vendor_id',$vendors->user_id)->first();
        
        if($accounts)
        {
           $accounts = accounts::find($accounts->id);
            $accounts->total_commission = $accounts->total_commission+$commission_cal;
            $accounts->account_name =$vendors->vendorname;
            $accounts->total_sale   = $accounts->total_sale+$commission_amount;
            $accounts->save();  

            $ac = accounts::find(1);
            $ac->total_commission = $ac->total_commission+$commission_cal;
            $ac->save();

        }else{

            $accounts = new accounts;
            $accounts->total_commission = $commission_cal;
            $accounts->vendor_id = $vendors->user_id;
            $accounts->account_name =$vendors->vendorname;
            $accounts->total_sale   = $accounts->total_sale+$commission_amount;
            $accounts->save();

            $ac = accounts::find(1);
            $ac->total_commission = $ac->total_commission+$commission_cal;
            $ac->save();
        }
        
       
                 }
            }

        return redirect()->route('payorder', ['id' => $ordernumber]);
    }

    public function payorder($ordernumber)
    {
        $view = '';
        $totalamt = 0;
        $subtotal = 0;
        $tax = '';
        $shipping=0;
        $ordernumber = $ordernumber;
        $getorder = ordersdetail::where('ordernumber', $ordernumber)->get();

        $payoptions = ordersdetail::where('ordernumber', $ordernumber)->where('payoptions', 1)->first();

        if ($payoptions) {
            $payoption = true;
        }else{
            $payoption = false;
        }
        $shipping=orders::where('ordernumber','=',$ordernumber)->sum('shipping_fee');
        foreach ($getorder as $row) {
            # code...
            $getproducts = vendorproduct::where('id', $row->product_id)->first();
        $products = products::where('id', $getproducts->product_id)->first();
        $shipping_type=shipping::where('vendorproduct_id','=',$getproducts->id)->first();
       /*if($getproducts->deliveryratestate==NULL){
            $stateDeliveryrate=0;
        }
        else{
            $stateDeliveryrate=(float)$getproducts->deliveryratestate;
        }
        if($getproducts->deliveryrateoutsidegeo==NULL){
            $deliveryrateoutstategeo=0;
        }
        else{
            $deliveryrateoutstategeo=(float)$getproducts->deliveryrateoutsidegeo;
        }
        if($getproducts->deliveryrateoutstatewithgeo==NULL){
            $deliveryrateoutstatewithgeo=0;
        }
        else{
            $deliveryrateoutstatewithgeo=(float)$getproducts->deliveryrateoutstatewithgeo;
        }
//shipping calculation goes

        if($shipping_type){
        if($shipping_type->shipping_type=='free'){
            $shipping=$shipping+0;
        }
        else if($shipping_type->shipping_type=='Vendor_shipping'){
            $customer=Customer::where('user_id','=',Auth::user()->id)->first();
             $vendor=vendors::where('user_id','=',$getproducts->user_id)->first();
             $city=city::where('name','=',$customer->billing_city)->first();
             if($city){
                $state=state::where('name','=',$city->state_name)->first();
             }

             $state_zone=shippingInformations::where('city',$customer->billing_city)->first();
             if($vendor->location==$customer->billing_city){
                $shipping=$shipping+$stateDeliveryrate;
             }
             else if($state->zone != NULL){
                 $shipping=$shipping+$deliveryrateoutstatewithgeo;
             }
             else {

                 $shipping=$shipping+$deliveryrateoutstategeo;
             }
            
        }
        else if($shipping_type->shipping_type=='company_shipping'){
           $customer=Customer::where('user_id','=',Auth::user()->id)->first();
            $city=city::where('name','=',$customer->billing_city)->first();
             if($city){
                $state=state::where('name','=',$city->state_name)->first();
             }
            $shippinginfos=shippingInformations::where('zone',$state->zone)->first();
            if($shippinginfos){

                if($shippinginfos->zone !=NULL){
                    
                    $shipping=$shipping+($shippinginfos->ammount_per_kg*$products->weight+$shippinginfos->volume*$products->length)+$deliveryrateoutstatewithgeo;
                   
                }
                else{
                    $shipping=$shipping+($shippinginfos->ammount_per_kg*$products->weight+$shippinginfos->volume*$products->length)+$deliveryrateoutstategeo;
                }
                
            }
        }
        else if($shipping_type->shipping_type=='mannual_shipping'){
             $customer=Customer::where('user_id','=',Auth::user()->id)->first();
           $manual_shipping=mannual_shipping::where('city','=',$customer->billing_city)->where('vendorproduct_id','=',$getproducts->product_id)->first();
           if($manual_shipping){
           $shipping=$shipping+$manual_shipping->shipping;
       }
       else{
        $shipping=$shipping+0;
       }
        }
    }
    else{
        $shipping=$shipping+0;
    }
    $shipping=$shipping*$row->quantity;
*/

            $price = ($row->price);
            $total = ($row->totalprice);
            

            if ($row->payoptions == 1) {
                # code...
                if($row->payondelivery==NULL){
                $subtotal += $row->totalprice;
            }
            else{
                $subtotal +=0;
            }
            }
            else{
                $subtotal+=0;
            }
            if($row->payoptions==1){
            if($row->payondelivery==NULL){
            $totalamt += $row->totalprice;
        }
        else{
            $totalamt +=0;
        }}
        else{
            $totalamt+=0;
        }

            $tax = '0.00';
            $view .= "<tr>
                        <td>$products->name</td>
                        <td>$row->quantity</td>
                        <td>".HomeController::converter($total)."</td>
                    </tr>";

                }
            $totalamt = $totalamt+$shipping;
            $subtotal = $subtotal;
            $sub=$totalamt;
                       
            $view .= "<tr>
                        <td>Subtotal</td>
                        <td></td>
                        <td> ".HomeController::converter($subtotal)."</td>
                    </tr>
                    <tr>
                        <td>Shipping</td>
                        <td></td>
                        <td>".HomeController::converter($shipping)."</td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td></td>
                        <td>".HomeController::converter($totalamt)."</td>
                    </tr>";

        $cart = HomeController::cart();
        $getwallet = wallet::where('user_id', Auth::user()->id)->first();
        return view('cart/orderpayment', compact('view', 'ordernumber', 'cart', 'getwallet', 'subtotal', 'payoption','sub','totalamt','shipping'));
    }

    public function checkoutorderoffline()
    {
        # code...
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required',
            'password' => 'required|confirmed|min:6',
            'state' => 'required',
            'city' => 'required',
            'address' => 'required'
            ]);

        $email = request('email');
        $password = request('password');
        $name = request('name');

        $role_customer = Role::where('name', 'Customer')->first();

        $user = new User;
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->user_type = 'Customer';
        $user->save();
        $user->roles()->attach($role_customer);

        if (Auth::attempt(['email' => $email, 'password' => $password])) {

            $getcart = Cart::count();

            if ($getcart >= 1) {
                # code...

                $orders = new orders;
        $orders->user_id = Auth::user()->id;
        $orders->paymenttype = 'offline';
        $orders->phone = request('phone_number');
        $orders->shipaddress = request('address');
        $orders->ordercity = request('city');
        $orders->orderstate = request('state');
        $orders->orderstatus = 'active';
        $orders->dateordered = date('Y/m/d');
        $orders->deliverystatus = 'pending';
        $orders->save();
        $order_id = $orders->id;
        $ordernumber = time().''.$order_id;

        $updateorder = orders::where('id', $order_id)->update(array('ordernumber' => $ordernumber));

                foreach(Cart::content() as $row) {


        $getproducts = vendorproduct::where('id', $row->id)->first();
        $products = products::where('id', $getproducts->product_id)->first();
        
            $cart = new carts;
            $cart->user_id = Auth::user()->id;
            $cart->product_id = $row->id;
            $cart->price = $row->price;
            $cart->quantity = $row->qty;
            $cart->totalprice = $row->total;
            $cart->payoptions = 1;
            $cart->save();
            
            $ordersdetail = new ordersdetail;
        $ordersdetail->order_id = $order_id;
        $ordersdetail->ordernumber = $ordernumber;
        $ordersdetail->product_id = $row->id;
        $ordersdetail->price = $row->price;
        $ordersdetail->quantity = $row->qty;
        $ordersdetail->totalprice = $row->total;
        $ordersdetail->dateordered = date('Y/m/d');
        $ordersdetail->deliverystatus = 'pending';
        $ordersdetail->payoptions = 1;
        $ordersdetail->save();
        $ref_id = $ordernumber.''.$ordersdetail->id;
        $getordersdetail = ordersdetail::where('id', $ordersdetail->id)->update(array('ref_id' => $ref_id));
            
        }
        Cart::destroy();

            }


            return redirect()->route('payorder', ['id' => $ordernumber]);      

        }

    }

    public function signincheckout()
    {
        $this->validate(request(), [

            'email' => 'required|email',
            'password' => 'required'

            ]);

        $email = request('email');
        $password = request('password');


        if (Auth::attempt(['email' => $email, 'password' => $password])) {

            $getcart = Cart::count();

            if ($getcart >= 1) {
                # code...

                foreach(Cart::content() as $row) {


        $getproducts = vendorproduct::where('id', $row->id)->first();
        $products = products::where('id', $getproducts->product_id)->first();
        $getcart = carts::where('product_id', $row->id)->where('user_id', Auth::user()->id)->first();

        if ($getcart) {
            $getcartqty = $getcart->quantity;
            $newqty = $getcartqty + $row->qty;
            $totalprice = $newqty * $row->price;
            $updatecart = carts::where('product_id', $row->id)->where('user_id', Auth::user()->id)->where('payoptions', 1)->update(array('quantity' =>  $newqty, 'totalprice' => $totalprice));
        }else{
            $cart = new carts;
            $cart->user_id = Auth::user()->id;
            $cart->product_id = $row->id;
            $cart->price = $row->price;
            $cart->quantity = $row->qty;
            $cart->totalprice = $row->total;
            $cart->payoptions = 1;
            $cart->save();
        }

        
            
        }
        Cart::destroy();

            }

            return back();
            }
        }

        public function deleteproduct()
        {
            $productid = request('productid');
            if (Auth::check()) {
                # code...
            $paymentid = request('payment');
                $deleteproduct = carts::where('product_id', $productid)->where('user_id', Auth::user()->id)->where('payoptions', $paymentid)->delete();
                session()->flash('status', 'Product deleted successful!');  
            return back()->with('status', 'Product deleted successful!');  
            }else{
                Cart::remove($productid);
                session()->flash('status', 'Product deleted successful!');  
            return back()->with('status', 'Product deleted successful!');
            }

        }

        public function dashboard()
        {
            $cart = HomeController::cart();

            $date = date('Y/m/d');

            $from = date('Y/m/01', strtotime($date));
            $to = date('Y/m/t', strtotime($date));

            $sumquantity = 0;
            $sumtotal = 0;
           $orders = orders::where('user_id', Auth::user()->id)->where('payment', 'yes')->whereBetween('dateordered', [$from, $to])->orderBy('dateordered', 'desc')->get();

           $getorders = orders::where('user_id', Auth::user()->id)->where('payment', 'yes')->whereBetween('dateordered', [$from, $to])->get();
           $chartarray = array();

           foreach ($orders as $keys) {
                $sumorder = ordersdetail::where('order_id', $keys->id)->sum('totalprice');
                $sumqty = ordersdetail::where('order_id', $keys->id)->sum('quantity');

                $sumtotal =$sumtotal+$sumorder;
                $sumquantity =$sumquantity+$sumqty; 
            }
          
           foreach ($getorders as $key) {

                $getordersdetail = ordersdetail::where('order_id', $key->id)->get();

                foreach ($getordersdetail as $value) {
                    $vendorproduct = vendorproduct::where('id', $value->product_id)->first();
                    $category = category::where('id', $vendorproduct->category)->first();
                    $categoryname = $category->name;

                    if ($this->in_array_r($categoryname, $chartarray)) {
                        $searchkey = $this->searchForId($categoryname, $chartarray);
                        $chartarray[$searchkey]['y'] = $chartarray[$searchkey]['y'] + $value->totalprice;
                        
                    }else{
                        $chartarray[] = array('y' => $value->totalprice, 'label' => $categoryname); 
                    }

                    

                   
                }
               
           }

        return view('customers.dashboard', compact('cart', 'chartarray', 'sumquantity', 'sumtotal'));
        }
   
        public function orders()
        {
        $orders = Orders::where('user_id',Auth::User()->id)->where('payment', 'yes')->orwhere('payment','pending ')->get();
        $getorders = orders::where('user_id', Auth::user()->id)->where('payment', 'yes')->orwhere('payment','pending ')->first();
        $orders = orders::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->where('payment', 'yes')->orwhere('payment','pending ')->get();
        $view = '';
        $num = 0;
        $orderData = array();
        $itemsWorkplaces = [];
        $getworkplace = workplace::where('user_id', Auth::user()->id)->get();
        if ($getorders) {
            foreach ($orders as $key) {
                $num += 1;
                $quantity = ordersdetail::where('order_id', $key->id)->sum('quantity');
                $price = ordersdetail::where('order_id', $key->id)->sum('totalprice');
                $deliverystatus = ordersdetail::where('order_id', $key->id)->where('deliverystatus', 'pending')->first();
                $itemsWorkplace = $key->orderdetails()->pluck('workplace_id')->unique();
                $workplace = '';
                if ($itemsWorkplace->count() === 1 && !empty($key->workplace_id)) {
                    $workplace = $key->workplace_id;
                }
                $itemsWorkplaces[$key->ordernumber] = $itemsWorkplace->count();


                $view .= "<tr>";
                $myurl = asset('/');

                $price = number_format($price);
                $orderData[] = array(
                    'id' => $key->id,
                    'orderNumber' => $key->ordernumber,
                    'quantity' => $quantity,
                    'price' => $price,
                    'paymentStatus' => 'paid',
                    'workplaceId' => $workplace,
                    'deliveryStatus' => $deliverystatus
                );
                $view .= "<td>$num</td>
                    <td>$key->ordernumber</td>
                    <td>$quantity</td>
                    <td>$$price</td>
                    <td>Paid</td>
                    <td>";
                if ($itemsWorkplace->count() > 1) {
                $view .= 'Separate option is selected for each item';
                }
                $view .= "<select class='form-control workplace-id-$key->id' id=$key->ordernumber>
                    <option value=''>Select workplace</option>
                    ";
                    foreach ($getworkplace as $keys) {
                        $select = '';
                        if (!empty($workplace)) {
                            if ($keys->id === $workplace) {
                                $select = "selected=selected";
                            }
                        }
                        $view .= "<option $select value=$keys->id>$keys->name</option>";
                    }
                $view .= "</select></td>
                    
                    <td>
                    <a href='$myurl/customers/ordersdetail/$key->id' class='btn btn-xs btn-primary'>View</a>
                        <button class='btn btn-success btn-xs orderworkplace' id=$key->id  type='button'>Update</button>
                        </td>
                    </tr>";
            }
        }
        $cart = HomeController::cart();
        return view('customers.orders', compact('cart', 'view', 'orderData', 'getworkplace','orders', 'itemsWorkplaces'));
        }

        public function ordersdetail($id)
        {
            $ordersss=orders::find($id);

            $myurl =  asset('/');
            $num = 0;
            $view = '';

            $totalquantity = ordersdetail::where('order_id', $id)->sum('quantity');
            $totalprice = ordersdetail::where('order_id', $id)->sum('totalprice');
            $totalprice = ($totalprice);
            

            $ordersdetail = ordersdetail::where('order_id', $id)->get();
                foreach ($ordersdetail as $key) {
                    $ordersss=orders::find($key->order_id);
                    $payoptions = '';
                    $num += 1;

                    if ($key->payoptions != '1') {
                        if ($key->payoptions == '2') {
                            $payoptions = '<br>15 days Payment';
                        }elseif ($key->payoptions == '3') {
                            $payoptions = '<br>30 days Payment';
                        }
                    }

                $view .= "<tr style='font-size: 14px'>";

                $getproducts = vendorproduct::where('id', $key->product_id)->first();
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
                $unitprice = number_format($key->price);
                $price = number_format($key->totalprice);
                $description = str_limit($getproducts->remark, 120);

            $getreview = review::where('user_id', Auth::user()->id)->where('product_id', $key->product_id)->where('order_id', $key->id)->first();
            if ($getreview) {
                $btn = "<button class='btn btn-sm btn-default' >Reviewed</button>";
            }else{
                $btn = "<button class='btn btn-sm btn-default review popup-text' href='#review-dialog' data-effect='mfp-move-from-top' id=$key->id>Review</button>";
            }

          $view .= "<td>$num</td>
                    <td class='table-shopping-cart-img'>

                        
                        <div class='col-md-2'>
                        <img src='$myurl/$image' alt='Image Alternative text' title='Image Title' style='width: 40px' />
                        </div>
                        <div class='col-md-10'>
                            
                                <p>
                                    <a href='$myurl/product/$getproducts->slog' style='color: #000'>
                                        <strong>$products->name</strong>
                                    </a>
                                <br>
                                $description</p>
                                <p>".HomeController::converter($key->price)." X $key->quantity = ".HomeController::converter($key->totalprice)." $payoptions</p> 
                                <p style='color: #8D8A97 !important'>Product Properties: Color $key->color<br>
                                <div class=rev$key->id>
                                $btn
                                </div>
                                </p>

                        </div>
                        
                    </td>
                    <td>$key->ref_id</td>
                    <td>$vendorname->vendorname</td>
                    <td><select class='form-control ordersdetailsworkspcae' id=$key->id>
                    <option value=''>Select workplace</option>
                    ";
                    $getworkplace = workplace::where('user_id', Auth::user()->id)->get();
                    foreach ($getworkplace as $keys) {
                        $select = '';
                    if (!empty($workplace)) {
                        
                        if ($keys->id == $workplace) {
                            $select = "selected=selected";
                        }
                    }
            $view .= "<option $select value=$keys->id>$keys->name</option>";
                    }
            $view .= "</select></td>
                    <td>";
                    if ($key->deliverystatus != 'delivered') {
                    
                $view .= "<select class='deliverystatus form-control' id='$key->id'>
                            <option value='pending'>pending</option>
                            <option value='delivered'>delivered</option>
                         </select>";

                            }else{
                                if($key->deliverydate==NULL){
                                     $view .= "<h5 class='bg-success' style='padding: 5px; text-align: center'>Pending</h5>";
                                }
                                else{


                    $view .= "<h5 class='bg-success' style='padding: 5px; text-align: center'>Delivered on ".$key->deliverydate."</h5>";
                }
                            }
                    $view .= "</td>
                                <td>$ordersss->orderstatus</td>
                                <td>$ordersss->payment</td>
                                ";
                               /* if($key->ispaid==1){
                                    if($key->payment_get==NULL){
                                        $view .="<td>Pending</td>";
                                    }
                                    else{
                                        $view .="<td>Paid</td>";
                                    }
                                }else{
                                    $view .="<td>Pending</td>";
                                }*/
                                if($key->orderstatus=='cancel'){
                                    $view .="<td>$key->orderstatus</td>";
                                }else{
                                    $view .="<td></td>";
                                }
                                if($key->order_cancel_reason!=NULL){
                                    $view .="<td>$key->order_cancel_reason</td></tr>";
                                }else{
                                    $view .="<td></td></tr>";
                                }

                }
                
            $cart = HomeController::cart();
        return view('customers.ordersdetail', compact('cart', 'view', 'totalquantity', 'totalprice','ordersss'));
        }

        public function changeoderworkplace()
        {
            $value = $_GET['val'];
            $ordernumber = $_GET['ordernumber'];

            $updateorder = orders::where('user_id', Auth::user()->id)->where('ordernumber', $ordernumber)->update(array('workplace_id' => $value));
        }

        public function changeoderdetailsworkplace()
        {
            $value = $_GET['val'];
            $order_id = $_GET['order_id'];

            $updateorder = ordersdetail::where('id', $order_id)->update(array('workplace_id' => $value));
        }

        public function in_array_r($needle, $haystack, $strict = false) {
            foreach ($haystack as $item) {
                if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && $this->in_array_r($needle, $item, $strict))) {
                    return true;
                }
            }

            return false;
        }

        public function searchForId($id, $array) {
           foreach ($array as $key => $val) {
               if ($val['label'] === $id) {
                   return $key;
               }
           }
           return null;
        }

        public function report()
        {
            $num = 0;
            $view = '';
            $categories = category::all();
            $date = date('Y/m/d');
            $searchkey = '';
            $keyarray = array();
            $myurl = asset('/');
            
            $from = date('Y/m/01', strtotime($date));
            $to = date('Y/m/t', strtotime($date));
           $orders = orders::where('user_id', Auth::user()->id)->where('payment', 'yes')->whereBetween('dateordered', [$from, $to])->orderBy('dateordered', 'desc')->get();
           $getorders = orders::where('user_id', Auth::user()->id)->where('payment', 'yes')->whereBetween('dateordered', [$from, $to])->get();
            $station =orders::where('user_id', Auth::user()->id)->where('payment', 'yes')->get();
           $chartarray = array();
            $stationchart=array();
           foreach ($station as $key) {
                   $orderpayment=orderpayment::where('ordernumber','=',$key->ordernumber)->first();
                $getordersdetail = ordersdetail::where('order_id', $key->id)->get(); 
               $name=workplace::find($key->workplace_id);

                foreach ($getordersdetail as $value) {
                   // $vendorproduct = vendorproduct::where('id', $value->product_id)->first();
                    if($name){
                        $placeName=$name->name;
                   
                }
                else{
                     $placeName='Unknown';
                }
                   // $category = category::where('id', $vendorproduct->category)->first();
                    $categoryname = $placeName;

                    if ($this->in_array_r($categoryname, $stationchart)) {
                        $searchkey = $this->searchForId($categoryname, $stationchart);
                        $stationchart[$searchkey]['y'] = $stationchart[$searchkey]['y'] + $value->totalprice;
                        
                    }else{
                        $stationchart[] = array('y' => $value->totalprice, 'label' => $categoryname); 
                    }

                    

                   
                }
               
           }
           foreach ($getorders as $key) {

                $getordersdetail = ordersdetail::where('order_id', $key->id)->get();

                foreach ($getordersdetail as $value) {
                    $vendorproduct = vendorproduct::where('id', $value->product_id)->first();
                    $category = category::where('id', $vendorproduct->category)->first();
                    $categoryname = $category->name;

                    if ($this->in_array_r($categoryname, $chartarray)) {
                        $searchkey = $this->searchForId($categoryname, $chartarray);
                        $chartarray[$searchkey]['y'] = $chartarray[$searchkey]['y'] + $value->totalprice;
                        
                    }else{
                        $chartarray[] = array('y' => $value->totalprice, 'label' => $categoryname); 
                    }

                    

                   
                }
               
           }

           foreach ($orders as $keys) {
               $getordersdetail = ordersdetail::where('ordernumber', $keys->ordernumber)->get();

               foreach ($getordersdetail as $key) {

                $payoptions = '';
                if ($key->payoptions != '1') {
                        if ($key->payoptions == '2') {
                            $payoptions = '<br>15 days Payment';
                        }elseif ($key->payoptions == '3') {
                            $payoptions = '<br>30 days Payment';
                        }
                    }

                $num ++;
                $view .= "
                            <tr style='font-size: 14px'>";              
                   $getproducts = vendorproduct::where('id', $key->product_id)->first();
                   $vendorname = vendors::where('user_id', $getproducts->user_id)->first();
                $products = products::where('id', $getproducts->product_id)->first();
                   if(!empty($getproducts->image)){
                    $image = $getproducts->image;
                    }
                    else{
                        $image = $products->image;
                    }

                    if (!empty($key->workplace_id)) {
                        $workplace = workplace::where('user_id', Auth::user()->id)->where('id', $key->workplace_id)->first();
                        
                        $workplacename = $workplace->name;
                    }else{
                        $workplacename = '';
                    }

                    $price = number_format($key->totalprice);
                $description = str_limit($getproducts->remark, 120);
                $unitprice = number_format($key->price);

                if ($key->deliverystatus != 'delivered') {
                    $delivery = "<button class='btn btn-xs btn-danger'>Pending</button>";
                }else{
                    if($key->deliverydate==NULL){
                        $delivery = "<h5 class='bg-success' style='padding: 5px; text-align: center'>Pending</h5>";
                    }
                    else{
                    $delivery = "<h5 class='bg-success' style='padding: 5px; text-align: center'>Delivered on ".$key->deliverydate."</h5>";
                }
                }

                   $view .= "<td>$num</td>

                            <td class='table-shopping-cart-img'>

                                <a href='$myurl/product/$getproducts->slog' style='color: #000'>
                                <div class='col-md-2'>
                                <img src='$myurl/$image' alt='Image Alternative text' title='Image Title' style='width: 40px'/>
                                </div>
                                <div class='col-md-10'>
                                    <p><strong>$products->name</strong><br>
                                     $description</p>
                                    <p>".HomeController::converter($key->price)." * $key->quantity = ".HomeController::converter($key->price*$key->quantity)." $payoptions</p> 
                                    <p style='color: #8D8A97 !important'>Product Properties: Color $key->color</p>
                                </div>
                                </a>
                            </td>
                    <td>$key->ref_id</td>
                    <td>$key->ordernumber</td>
                            <td>$vendorname->vendorname</td>
                            <td>$workplacename</td>
                            <td>$key->dateordered</td>
                            <td>$delivery</td>";
                $view .= "</tr>";
               }
           }
           $cart = HomeController::cart();
           return view('customers.reports', compact('view', 'cart', 'categories', 'chartarray','stationchart'));
        }

        public function getreportdate()
        {
            $to = $_GET['to'];
            $from = $_GET['from'];
            $num = 1;
             $myurl = asset('/');
            $view = '';
            $category = $_GET['categories'];
            $subcategory=$_GET['subcategory'];
            $deliveries=$_GET['delivery'];
            if($deliveries=='all'){
            $getdateordered = DB::table('orders')->where('user_id', Auth::user()->id)->where('payment', 'yes')
                    ->whereBetween('dateordered', [$from, $to])->first();

            $dateordered = DB::table('orders')->where('user_id', Auth::user()->id)->where('payment', 'yes')
                    ->whereBetween('dateordered', [$from, $to])->get();
                }
                else{
                      $getdateordered = DB::table('orders')->where('user_id', Auth::user()->id)->where('payment', 'yes')->where('deliverystatus','=',$deliveries)
                    ->whereBetween('dateordered', [$from, $to])->first();

            $dateordered = DB::table('orders')->where('user_id', Auth::user()->id)->where('payment', 'yes')->where('deliverystatus','=',$deliveries)
                    ->whereBetween('dateordered', [$from, $to])->get();
                }
            if ($getdateordered) {

                if ($category == 'all') {

                    foreach ($dateordered as $keys) {

                    $dateordered = DB::table('ordersdetail')->where('ordernumber', $keys->ordernumber)
                    ->whereBetween('dateordered', [$from, $to])->get();
                   foreach ($dateordered as $key) {
                    $payoptions = '';
                if ($key->payoptions != '1') {
                        if ($key->payoptions == '2') {
                            $payoptions = '<br>15 days Payment';
                        }elseif ($key->payoptions == '3') {
                            $payoptions = '<br>30 days Payment';
                        }
                    }

                    $num ++;
                $view .= "
                            <tr>";              
                   $getproducts = vendorproduct::where('id', $key->product_id)->first();
                   $vendorname = vendors::where('user_id', $getproducts->user_id)->first();
                $products = products::where('id', $getproducts->product_id)->first();
                   if(!empty($getproducts->image)){
                    $image = $getproducts->image;
                    }
                    else{
                        $image = $products->image;
                    }

                    if (!empty($key->workplace_id)) {
                        $workplace = workplace::where('user_id', Auth::user()->id)->where('id', $key->workplace_id)->first();
                        
                        $workplacename = $workplace->name;
                    }else{
                        $workplacename = '';
                    }

                    $price = number_format($key->totalprice);
                $description = str_limit($getproducts->remark, 120);
                $unitprice = number_format($key->price);

                if ($key->deliverystatus != 'delivered') {
                    $delivery = "<button class='btn btn-xs btn-danger'>Pending</button>";
                }else{
                    $delivery = "<h5 class='bg-success' style='padding: 5px; text-align: center'>Delivered on ".$key->deliverydate."</h5>";
                }

                    $view .= "<td>$num</td>

                            <td class='table-shopping-cart-img'>

                                <a href='$myurl/product/$getproducts->slog' style='color: #000'>
                                <div class='col-md-2'>
                                <img src=$myurl/$image alt='Image Alternative text' title='Image Title' style='width: 40px' />
                                </div>
                                <div class='col-md-10'>
                                    <p><strong>$products->name</strong><br>
                                    $description</p>
                                    <p>₦$unitprice X $key->quantity = ₦$price $payoptions</p> 
                                    <p style='color: #8D8A97 !important'>Product Properties: Color $key->color</p>
                                </div>
                                </a>
                            </td>
                    <td>$key->ref_id</td>
                    <td>$key->ordernumber</td>
                            <td>$vendorname->vendorname</td>
                            <td>$workplacename</td>
                            <td>$key->dateordered</td>
                            <td>$delivery</td>";
                $view .= "</tr>";

                   

                }

                }
                }else{

                    foreach ($dateordered as $keys) {

                    $dateordered = DB::table('ordersdetail')->where('ordernumber', $keys->ordernumber)
                    ->whereBetween('dateordered', [$from, $to])->get();
                   foreach ($dateordered as $key) {

                    $payoptions = '';
                if ($key->payoptions != '1') {
                        if ($key->payoptions == '2') {
                            $payoptions = '<br>15 days Payment';
                        }elseif ($key->payoptions == '3') {
                            $payoptions = '<br>30 days Payment';
                        }
                    }
                    if($subcategory=='all'){
                    $getvendorproduct = vendorproduct::where('id', $key->product_id)->where('category', $category)->first();
                }
                else{
                     $getvendorproduct = vendorproduct::where('id', $key->product_id)->where('category', $category)->where('subcategory',$subcategory)->first();
                }

                    if ($getvendorproduct) {

                        $num += 1;
                $view .= "
                            <tr>";              
                   $getproducts = vendorproduct::where('id', $key->product_id)->first();
                   $vendorname = vendors::where('user_id', $getproducts->user_id)->first();
                $products = products::where('id', $getproducts->product_id)->first();
                   if(!empty($getproducts->image)){
                    $image = $getproducts->image;
                    }
                    else{
                        $image = $products->image;
                    }

                    if (!empty($key->workplace_id)) {
                        $workplace = workplace::where('user_id', Auth::user()->id)->where('id', $key->workplace_id)->first();
                        
                        $workplacename = $workplace->name;
                    }else{
                        $workplacename = '';
                    }

                    $price = number_format($key->totalprice);
                $description = str_limit($getproducts->remark, 120);
                $unitprice = number_format($key->price);

                if ($key->deliverystatus != 'delivered') {
                    $delivery = "<button class='btn btn-xs btn-danger'>Pending</button>";
                }else{
                    $delivery = "<h5 class='bg-success' style='padding: 5px; text-align: center'>Delivered on ".$key->deliverydate."</h5>";
                }

                   $view .= "<td>$num</td>

                            <td class='table-shopping-cart-img'>

                                <a href='$myurl/product/$getproducts->slog' style='color: #000'>
                                <div class='col-md-2'>
                                <img src=$myurl/$image alt='Image Alternative text' title='Image Title' style='width: 40px' />
                                </div>
                                <div class='col-md-12'>
                                    <p><strong>$products->name</strong><br>
                                    $description</p>
                                    <p>₦$unitprice X $key->quantity = ₦$price $payoptions</p> 
                                </div>
                                </a>
                            </td>
                    <td>$key->ref_id</td>
                    <td>$key->ordernumber</td>
                            <td>$vendorname->vendorname</td>
                            <td>$workplacename</td>
                            <td>$key->dateordered</td>
                            <td>$delivery</td>";
                $view .= "</tr>";

                    }else{
                        $view .= "";
                    }

                    

                }
            }

                }

                
            }else{
                $view = "<h3>No report available</h3>";
            }

            return $view;
        }

        public function getreportsum()
        {
            $to = $_GET['to'];
            $from = $_GET['from'];
            $searchkey = '';
            $chartarray = array();

            $getorders = orders::where('user_id', Auth::user()->id)->where('payment', 'yes')->whereBetween('dateordered', [$from, $to])->get();

            foreach ($getorders as $key) {

                $getordersdetail = ordersdetail::where('order_id', $key->id)->get();

                foreach ($getordersdetail as $value) {
                    $vendorproduct = vendorproduct::where('id', $value->product_id)->first();
                    $category = category::where('id', $vendorproduct->category)->first();
                    $categoryname = $category->name;

                    if ($this->in_array_r($categoryname, $chartarray)) {
                        $searchkey = $this->searchForId($categoryname, $chartarray);
                        $chartarray[$searchkey]['y'] = $chartarray[$searchkey]['y'] + $value->totalprice;
                        
                    }else{
                        $chartarray[] = array('label' => $categoryname, 'y' => $value->totalprice); 
                    }

                    

                   
                }
               
           }

           return json_encode($chartarray, JSON_UNESCAPED_UNICODE);

        }

        public function getaccountsum()
        {
            $to = $_GET['to'];
            $from = $_GET['from'];
            $searchkey = '';
            $chartarray = array();

            $getorders = orders::where('user_id', Auth::user()->id)->where('payment', 'yes')->whereBetween('dateordered', [$from, $to])->get();

            foreach ($getorders as $key) {

                $getordersdetail = ordersdetail::where('order_id', $key->id)->get();

                foreach ($getordersdetail as $value) {
                    $vendorproduct = vendorproduct::where('id', $value->product_id)->first();
                    $category = category::where('id', $vendorproduct->category)->first();
                    $categoryname = $category->name;

                    if ($this->in_array_r($categoryname, $chartarray)) {
                        $searchkey = $this->searchForId($categoryname, $chartarray);
                        $chartarray[$searchkey]['y'] = $chartarray[$searchkey]['y'] + $value->totalprice;
                        
                    }else{
                        $chartarray[] = array('label' => $categoryname, 'y' => $value->totalprice); 
                    }

                    

                   
                }
               
           }

           return json_encode($chartarray, JSON_UNESCAPED_UNICODE);
        }

        public function accounting()
        {
            $num = 0;
            $view = '';
            $sumtotal = 0;
            $sumquantity = 0;
            $categories = category::all();
            $myurl =  asset('/');

            $date = date('Y/m/d');
            
            $from = date('Y/m/01', strtotime($date));
            $to = date('Y/m/t', strtotime($date));

           $orders = orders::where('user_id', Auth::user()->id)->where('payment', 'yes')->whereBetween('dateordered', [$from, $to])->orderBy('dateordered', 'desc')->get();
           $getorders = orders::where('user_id', Auth::user()->id)->where('payment', 'yes')->whereBetween('dateordered', [$from, $to])->get();
           $station =orders::where('user_id', Auth::user()->id)->where('payment', 'yes')->get();
           $workplaces = workplace::all(['name', 'id']);
           $chartarray = array();
           $stationchart=array();
           foreach ($station as $key) {
                   $orderpayment=orderpayment::where('ordernumber','=',$key->ordernumber)->first();
                $getordersdetail = ordersdetail::where('order_id', $key->id)->get();

                foreach ($getordersdetail as $value) {
                    $name=$workplaces->where('id', $value->workplace_id)->first();
                    // $vendorproduct = vendorproduct::where('id', $value->product_id)->first();
                    if($name){
                        $placeName=$name->name;

                }
                else{
                     $placeName='Unknown';
                }
                   // $category = category::where('id', $vendorproduct->category)->first();
                    $categoryname = $placeName;

                    if ($this->in_array_r($categoryname, $stationchart)) {
                        $searchkey = $this->searchForId($categoryname, $stationchart);
                        $stationchart[$searchkey]['y'] = $stationchart[$searchkey]['y'] + $value->totalprice;

                    }else{
                        $stationchart[] = array('y' => $value->totalprice, 'label' => $categoryname);
                    }
                }

           }
           
           foreach ($getorders as $key) {
                    $orderpayment=orderpayment::where('ordernumber','=',$key->ordernumber)->first();
                $getordersdetail = ordersdetail::where('order_id', $key->id)->get();

                foreach ($getordersdetail as $value) {
                    $vendorproduct = vendorproduct::where('id', $value->product_id)->first();
                    $category = category::where('id', $vendorproduct->category)->first();
                    $categoryname = $category->name;

                    if ($this->in_array_r($categoryname, $chartarray)) {
                        $searchkey = $this->searchForId($categoryname, $chartarray);
                        $chartarray[$searchkey]['y'] = $chartarray[$searchkey]['y'] + $value->totalprice;
                        
                    }else{
                        $chartarray[] = array('y' => $value->totalprice, 'label' => $categoryname); 
                    }

                    

                   
                }
               
           }

           foreach ($orders as $keys) {
            $orderpayment=orderpayment::where('ordernumber','=',$keys->ordernumber)->first();
                $sumorder = ordersdetail::where('order_id', $keys->id)->sum('totalprice');
                $sumqty = ordersdetail::where('order_id', $keys->id)->sum('quantity');
                $sumtotal =$sumtotal+ $sumorder;
                $sumquantity =$sumquantity+ $sumqty; 
               $getordersdetail = ordersdetail::where('ordernumber', $keys->ordernumber)->get();

               foreach ($getordersdetail as $key) {
           
                $payoptions = '';
                if ($key->payoptions != '1') {
                        if ($key->payoptions == '2') {
                            $payoptions = '<br>15 days Payment';
                        }elseif ($key->payoptions == '3') {
                            $payoptions = '<br>30 days Payment';
                        }
                    }

                $num ++;
                $view .= "
                            <tr style='font-size: 14px'>";              
                   $getproducts = vendorproduct::where('id', $key->product_id)->first();
                   $vendorname = vendors::where('user_id', $getproducts->user_id)->first();
                $products = products::where('id', $getproducts->product_id)->first();
                   if(!empty($getproducts->image)){
                    $image = $getproducts->image;
                    }
                    else{
                        $image = $products->image;
                    }
                  $getorder=orders::find($key->order_id);
                 
                    if (!empty($getorder->workplace_id)) {
                        $workplace = workplace::where('user_id', Auth::user()->id)->where('id', $getorder->workplace_id)->first();
                        
                        $workplacename = $workplace->name;
                    }else{
                        $workplacename = '';
                    }

                    $price = number_format($key->totalprice);
                $description = str_limit($getproducts->remark, 120);
                $unitprice = number_format($key->price);

                if ($key->deliverystatus != 'delivered') {
                    $delivery = "<button class='btn btn-xs btn-danger'>Pending</button>";
                }else{
                    if($key->deliverydate==NULL){
                        $delivery = "<h5 class='bg-success' style='padding: 5px; text-align: center'>Pending</h5>";
                    }
                    else{
                        $delivery = "<h5 class='bg-success' style='padding: 5px; text-align: center'>Delivered on ".$key->deliverydate."</h5>";
                    }
                    
                }

                    $view .= "<td>$num</td>

                            <td class='table-shopping-cart-img'>

                                <a href='$myurl/product/$getproducts->slog' style='color: #000'>
                                <div class='col-md-2'>
                                <img src='$myurl/$image' alt='Image Alternative text' title='Image Title' style='width: 40px' />
                                </div>
                                <div class='col-md-10'>
                                    <p style='font-size: 14px'><strong>$products->name</strong><br>
                                    $description</p>
                                    <p>".HomeController::converter($key->price)." X $key->quantity = ".HomeController::converter($key->totalprice)."$payoptions</p> 
                                    <p style='color: #8D8A97 !important'>Product Properties: Color $key->color</p>
                                </div>
                                </a>
                            </td>
                            <td><a href='$myurl/customers/ordersdetail/$keys->id'>$key->ordernumber</a></td>
                    <td>$key->ref_id</td>
                            <td>$vendorname->vendorname</td>
                            <td>$workplacename</td>
                            <td>$key->dateordered</td>";
                            if($key->payoptions !=1){
                                $orderpayment=orderpayment::where('ordernumber','=',$key->ordernumber)->where('ordersdetail_id','=',$key->id)->first();
                                if($orderpayment){
                                    $view .="<td>$orderpayment->payment_type</td>";
                                }
                                else{
                                    $view .="<td>paylatter</td>";
                                }
                            }else{
                           $view .=" <td>$orderpayment->payment_type</td>";
                        }
                            $view .="<td>$delivery</td>";
                $view .= "</tr>";
               }
           }
           $cart = HomeController::cart();
           return view('customers.accounting', compact('view', 'cart', 'sumtotal', 'categories', 'sumquantity', 'chartarray','stationchart'));
        }

        public function addworkplace()
        {
            
            $val = $_GET['val'];

            $getworkplace = workplace::where('user_id', Auth::user()->id)->where('name', $val)->first();
            if ($getworkplace) {
                # code...
            }else{
               $workplace = new workplace;
            $workplace->user_id = Auth::user()->id;
            $workplace->name = $val;
            $workplace->save(); 
            }

            
        }

        public function addsupplier()
        {
            $myurl =  asset('/');


            $getcustomersvendor = '';
            $no = 0;
            $no1 = 0;
            $getvendors = '';
            $view = '';
            $creditvends=[];
           
            $cusvendors = customersvendor::where('customer_id', Auth::user()->id)->where('status', 'yes')->groupBy('vendor_id')->get();
            foreach ($cusvendors as $cus) {
                $creditvends[]=$cus->vendor_id;
            }
            
           $favoritvend=favoritevendor::where('customer_id',Auth::user()->id)->where('favorite','=',1)->get();
           foreach ($favoritvend as $fav) {
            $creditvends[]=$fav->vendor_id;
           }
           $creditvends=array_unique($creditvends);

            $sql = vendorproduct::orderBy('id', 'desc')->where('product_status','1')->where('delete_product','=',0)->where('availability','=','yes');
           if(count($creditvends)>0){
            foreach ($creditvends as $key => $value) {
               if($key==0){
                $sql=$sql->where('user_id','=',$value);
               }
               else{
                $sql=$sql->orwhere('user_id','=',$value);
               }
            }
           }
           else{
            $sql=$sql->where('user_id','=',NULL);
           }
           
               
            
        
        
            $sql=$sql->get();
            $count = vendorproduct::orderBy('id', 'desc')->count();

            $view .= "<ul class='paginate' style='list-style-type:none'>";

            $count = $count / 12;
            $value = ceil($count);
            if ($value > 6) {
                $val = 6;
            }else{
                $val = $value;
            }
                if(!$sql){
                    $view .='You have no Favorite or Credit Vendors in your list';
                }
            foreach ($sql as $key) {
                
            $vendorname = vendors::where('user_id', $key->user_id)->first();
            $products = products::where('id', $key->product_id)->first();
               if(!empty($key->image)){
                $image = $key->image;
                }
                else{
                    $image = $products->image;
                }
                $price = number_format($key->price);
                $ratingss=HomeController::ratings($key->product_id);
            $view .= "<li><div class='col-md-3' style='margin-bottom: 10px'>
                        <div class='product '>
                            <ul class='product-labels'>
                                
                            </ul>
                            <div class='product-img-wrap' style='margin: 0;'>
                                <img class='product-img-primary' src='".$myurl."/$image' style='height: 200px;' alt='Image Alternative text' title='Image Title'>
                                <img class='product-img-alt' src='".$myurl."/$image' alt='Image Alternative text' style='height:200px;' title='Image Title'>
                            </div>
                            <div class='product-caption'>
                                <ul class='product-caption-rating'>
                                  ";
                                     if($ratingss>0){
                                      if($ratingss==1){
                                      $view .=" <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li><i class='fa fa-star'></i>
                                        </li>";
                                    }
                                      elseif($ratingss==2){
                                       $view .="<li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li><i class='fa fa-star'></i>
                                        </li>";
                                    }
                                      elseif($ratingss==3){
                                      $view=" <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li><i class='fa fa-star'></i>
                                        </li>";
                                    }
                                      elseif($ratingss=4){
                                       $view .="<li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li><i class='fa fa-star'></i>
                                        </li>";
                                    }
                                      else{
                                       $view .="<li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>";
                                    }
                                      
                                       }
                                       else{
                                       $view .="<li class=''><i class='fa fa-star'></i>
                                        </li>
                                        <li class=''><i class='fa fa-star'></i>
                                        </li>
                                        <li class=''><i class='fa fa-star'></i>
                                        </li>
                                        <li class=''><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>";
                                    }
                                        
                                    $view.="
                                    
                                </ul>
                                <h5 class='product-caption-title'><a href='".$myurl."/product/$key->slog'>$products->name($vendorname->vendorname)</a></h5>
                                <div class='product-caption-price'><span class='product-caption-price-new'><span style='font-size: 18px'> ".HomeController::converter($key->price)." </span><br> <span class='add$key->id'><button class='btn btn-sm btn-primary addproducttocart' id=$key->id>add to cart</button></span></span>
                                </div>
                            </div>
                        </div>
                    </div></li>";

            }
            $view .= "</ul>
                        <script type='text/javascript'>
                    $('.paginate').paginathing({
                    perPage: 12,
                    limitPagination: $val
                    })
                    </script>";

           $cart = HomeController::cart();
           $customersvendor = customersvendor::where('customer_id', Auth::user()->id)->get();
           $customersvendor2 = customersvendor::where('customer_id', Auth::user()->id)->where('status', 'yes')->get();
           $favourites=favoritevendor::where('customer_id',Auth::user()->id)->where('favorite','=',1)->get();

           foreach ($customersvendor as $key) {
                $no += 1; 
               $getvendor = vendors::where('user_id', $key->vendor_id)->first();
               $getcustomersvendor .= "<tr>
                                            <td>$no</td>
                                            <td>$getvendor->vendorname</td>
                                            <td>$key->status</td>
                                        </tr>";
           }
           $array=[];
           foreach ($customersvendor2 as $keys) {
           $array[]=$keys->vendor_id;
           /*     $no1 += 1; 
               $getvendor1 = vendors::where('user_id', $keys->vendor_id)->first();
               $getvendors .= "<option value=$keys->vendor_id>$getvendor1->vendorname</option>";
         */  }
           foreach ($favourites as $key => $favorite) {
           $array[]=$favorite->vendor_id;
         /*      $getvendor1 = vendors::where('user_id', $favorite->vendor_id)->first();
               $getvendors .= "<option value=$keys->vendor_id>$getvendor1->vendorname</option>";
        */   }
           $result=array_unique($array);
         foreach ($result as $key => $favorite) {
           
               $getvendor1 = vendors::where('user_id', $favorite)->first();
               $getvendors .= "<option value=$getvendor1->user_id>$getvendor1->vendorname</option>";
           }
           
           $vendors = vendors::all();
           $categories = category::all();
           return view('customers.addsupplier', compact('cart', 'vendors', 'getcustomersvendor', 'getvendors', 'categories', 'view'));
        }

        public function getaccounting()
        {
        	$to = $_GET['to'];
            $from = $_GET['from'];
            $num = 1;
            $view = '';
            $category = $_GET['categories'];
            $payment=$_GET['payment'];
            $workplace=$_GET['workplace'];
            $myurl =  asset('/');
            if($workplace=='all'){
            $getdateordered = DB::table('orders')->where('user_id', Auth::user()->id)->where('payment', 'yes')
                    ->whereBetween('dateordered', [$from, $to])->first();

            $dateordered = DB::table('orders')->where('user_id', Auth::user()->id)->where('payment', 'yes')
                    ->whereBetween('dateordered', [$from, $to])->get();
                }
                else{
                    $getdateordered = DB::table('orders')->where('user_id', Auth::user()->id)->where('payment', 'yes')->where('workplace_id','=',$workplace)
                    ->whereBetween('dateordered', [$from, $to])->first();

            $dateordered = DB::table('orders')->where('user_id', Auth::user()->id)->where('payment', 'yes')->where('workplace_id','=',$workplace)
                    ->whereBetween('dateordered', [$from, $to])->get();

                }

            if ($getdateordered) {

                if ($category == 'all') {

                    foreach ($dateordered as $keys) {

                $dateordered = DB::table('ordersdetail')->where('ordernumber', $keys->ordernumber)
                    ->whereBetween('dateordered', [$from, $to])->get();

                foreach ($dateordered as $key) {
                    # code...
                    if($payment=='all'){
                        $allow=true;
                    }
                    else{
                        $orderpayment=orderpayment::where('ordernumber','=',$key->ordernumber)->where('payment_type','=',$payment)->first();
                        if($orderpayment){
                            $allow=true;
                        }
                        else{
                            $allow=false;
                        }
                    }
                    if($allow){
                $payoptions = '';
                if ($key->payoptions != '1') {
                        if ($key->payoptions == '2') {
                            $payoptions = '<br>15 days Payment';
                        }elseif ($key->payoptions == '3') {
                            $payoptions = '<br>30 days Payment';
                        }
                    }

                    $num ++;
                $view .= "
                            <tr style='font-size: 14px'>";              
                   $getproducts = vendorproduct::where('id', $key->product_id)->first();
                   $vendorname = vendors::where('user_id', $getproducts->user_id)->first();
                $products = products::where('id', $getproducts->product_id)->first();
                 $orderpayment=orderpayment::where('ordernumber',$keys->ordernumber)->first();
                   if(!empty($getproducts->image)){
                    $image = $getproducts->image;
                    }
                    else{
                        $image = $products->image;
                    }
                        $order=orders::find($key->order_id);
                    if (!empty($order->workplace_id)) {
                        $workplace = workplace::where('user_id', Auth::user()->id)->where('id', $order->workplace_id)->first();
                        
                        $workplacename = $workplace->name;
                    }else{
                        $workplacename = '';
                    }

                    $price = number_format($key->totalprice);
                $description = str_limit($getproducts->remark, 120);
                $unitprice = number_format($key->price);

                if ($key->deliverystatus != 'delivered') {
                    $delivery = "<button class='btn btn-xs btn-danger'>Pending</button>";
                }else{
                    $delivery = "<h5 class='bg-success' style='padding: 5px; text-align: center'>Delivered on ".$key->deliverydate."</h5>";
                }

                    $view .= "<td>$num</td>

                            <td class='table-shopping-cart-img'>

                                <a href='$myurl/product/$key->product_id' style='color: #000'>
                                <div class='col-md-2'>
                                <img src='$myurl/$image' alt='Image Alternative text' title='Image Title' style='width: 40px' />
                                </div>
                                <div class='col-md-9'>
                                    <p><strong>$products->name</strong><br>
                                    <p>$description</p>
                                    <p>₦$unitprice X $key->quantity = ₦$price $payoptions</p> 
                                </div>
                                </a>
                            </td>
                            <td>$key->ordernumber</td>
                    <td>$key->ref_id</td>
                            <td>$vendorname->vendorname</td>
                            <td>$workplacename</td>
                            <td>$key->dateordered</td>
                            <td>$payment</td>
                            <td>$delivery</td>";
                $view .= "</tr>";
            }
                }
                }

                }else{

                    foreach ($dateordered as $keys) {

                $dateordered = DB::table('ordersdetail')->where('ordernumber', $keys->ordernumber)
                    ->whereBetween('dateordered', [$from, $to])->get();

                foreach ($dateordered as $key) {
                    # code...
                     if($payment=='all'){
                        $allow=true;
                    }
                    else{
                        $orderpayment=orderpayment::where('ordernumber','=',$key->ordernumber)->where('payment_type','=',$payment)->first();
                        if($orderpayment){
                            $allow=true;
                        }
                        else{
                            $allow=false;
                        }
                    }
                    if($allow){
                    $payoptions = '';
                if ($key->payoptions != '1') {
                        if ($key->payoptions == '2') {
                            $payoptions = '<br>15 days Payment';
                        }elseif ($key->payoptions == '3') {
                            $payoptions = '<br>30 days Payment';
                        }
                    }
                    
                    $getvendorproduct = vendorproduct::where('id', $key->product_id)->where('category', $category)->first();
                    if ($getvendorproduct) {
                    
                        $num ++;
                $view .= "
                            <tr style='font-size: 14px'>";              
                   $getproducts = vendorproduct::where('id', $key->product_id)->first();
                   $vendorname = vendors::where('user_id', $getproducts->user_id)->first();
                $products = products::where('id', $getproducts->product_id)->first();
                $orderpayment=orderpayment::where('ordernumber',$keys->ordernumber)->first();
                   if(!empty($getproducts->image)){
                    $image = $getproducts->image;
                    }
                    else{
                        $image = $products->image;
                    }
                    $order=orders::find($key->order_id);
                    if (!empty($order->workplace_id)) {
                        $workplace = workplace::where('user_id', Auth::user()->id)->where('id', $order->workplace_id)->first();
                        
                        $workplacename = $workplace->name;
                    }else{
                        $workplacename = '';
                    }

                    $price = number_format($key->totalprice);
                $description = str_limit($getproducts->remark, 120);
                $unitprice = number_format($key->price);

                if ($key->deliverystatus != 'delivered') {
                    $delivery = "<button class='btn btn-xs btn-danger'>Pending</button>";
                }else{
                    $delivery = "<h5 class='bg-success' style='padding: 5px; text-align: center'>Delivered on ".$key->deliverydate."</h5>";
                }

                    $view .= "<td>$num</td>

                            <td class='table-shopping-cart-img'>

                                <a href='$myurl/product/$key->product_id' style='color: #000'>
                                <div class='col-md-2'>
                                <img src='$myurl/$image' alt='Image Alternative text' title='Image Title' style='width: 40px' />
                                </div>
                                <div class='col-md-10'>
                                    <p><strong>$products->name</strong><br>
                                    $description</p>
                                    <p>₦$unitprice X $key->quantity = ₦$price $payoptions</p> 
                                    <p style='color: #8D8A97 !important'>Product Properties: Color $key->color</p>
                                </div>
                                </a>
                            </td>
                            <td>$key->ordernumber</td>
                    <td>$key->ref_id</td>
                            <td>$vendorname->vendorname</td>
                            <td>$workplacename</td>
                            <td>$key->dateordered</td>
                            <td>$payment</td>
                            <td>$delivery</td>";
                $view .= "</tr>";

                    }else{
                        $view .= '';
                    }


                    
                }
                }
                }

                }

                
            }else{
                $view = "<h3>No report available</h3>";
            }

            return $view;
        }

        public function getaccountingsum()
        {
        	$to = $_GET['to'];
            $from = $_GET['from'];
            $num = '';
            $view = '';
            $total = 0;
            $quantity = 0;
            $category = $_GET['categories'];
            $passarray = array();

            $getdateordered = DB::table('orders')->where('user_id', Auth::user()->id)->where('payment', 'yes')
                    ->whereBetween('dateordered', [$from, $to])->first();

            $dateordered = DB::table('orders')->where('user_id', Auth::user()->id)->where('payment', 'yes')
                    ->whereBetween('dateordered', [$from, $to])->get();

            if (!empty($getdateordered)) {

                if ($category == 'all') {
                    foreach ($dateordered as $key) {
                    # code...
                    $totalamt = DB::table('ordersdetail')->where('ordernumber', $key->ordernumber)
                    ->whereBetween('dateordered', [$from, $to])->sum('totalprice');
                    $totalqty = DB::table('ordersdetail')->where('ordernumber', $key->ordernumber)
                    ->whereBetween('dateordered', [$from, $to])->sum('quantity');
                    $total=$total+$totalamt;
                    $quantity=$quantity+$totalqty;
                    }
                }else{

                    foreach ($dateordered as $key) {
                        $getresult = DB::table('ordersdetail')->where('ordernumber', $key->ordernumber)
                    ->whereBetween('dateordered', [$from, $to])->get();
                    foreach ($getresult as $key) {
                        $getvendorproduct = vendorproduct::where('id', $key->product_id)->where('category', $category)->first();
                        if ($getvendorproduct) {
                            $totalamt = DB::table('ordersdetail')->where('ordernumber', $key->ordernumber)
                    ->whereBetween('dateordered', [$from, $to])->sum('totalprice');
                            $totalqty = DB::table('ordersdetail')->where('ordernumber', $key->ordernumber)
                    ->whereBetween('dateordered', [$from, $to])->sum('quantity');
                    $total=$total+$totalamt;
                    $quantity=$quantity+$totalqty;
                        }else{
                            $total ++;
                            $quantity = $key->sum('quantity');
                        }
                }
                    }

                    
            }
        }else{
                $total =0;
                $quantity =0;
            }

            $total = HomeController::converter($total);
            $quantity = number_format($quantity);

            $passarray = array('total' => $total, 'quantity' =>$quantity);


            return json_encode($passarray);
        }

        public function addcustomersvendor()
        {
            $vendor = $_GET['vendor'];
            $getcustomersvendor = customersvendor::where('customer_id', Auth::user()->id)->where('vendor_id', $vendor)->first();
            if ($getcustomersvendor) {
                # code...
            }else{
                $addcustomersvendor = new customersvendor;
                $addcustomersvendor->customer_id = Auth::user()->id;
                $addcustomersvendor->vendor_id = $vendor;
                $addcustomersvendor->status = 'pending';
                $addcustomersvendor->save();
            }
        }

        public function searchdata()
        {
            $vendors = $_GET['vendors'];
            $categories = $_GET['categories'];
            $subcategories = $_GET['subcategories'];
            $product=$_GET['products'];
            $view = '';
            $count = '';
            $sql = '';

            if ($vendors == 'all' && $categories == 'all' && $subcategories == 'all') {
                if($product !=""){
                $sql = vendorproduct::orderBy('id', 'desc')->where('name','LIKE','%'.$product.'%')->where('product_status','=',1)->where('delete_product','=',0)->get();
                $count = vendorproduct::orderBy('id', 'desc')->where('name','LIKE','%'.$product.'%')->where('product_status','=',1)->where('delete_product','=',0)->count();
            }
            else{
                $sql = vendorproduct::orderBy('id', 'desc')->get();
                $count = vendorproduct::orderBy('id', 'desc')->count();
            }
            }elseif ($vendors != 'all' && $categories != 'all' && $subcategories != 'all') {
                if($product !=""){
                     $sql = vendorproduct::where('user_id', $vendors)->where('category', $categories)->where('subcategory', $subcategories)->where('name','LIKE','%'.$product.'%')->where('product_status','=',1)->where('delete_product','=',0)->get();
                $count = vendorproduct::where('user_id', $vendors)->where('category', $categories)->where('subcategory', $subcategories)->where('name','LIKE','%'.$product.'%')->where('product_status','=',1)->where('delete_product','=',0)->count();
                }
                else{
                     $sql = vendorproduct::where('user_id', $vendors)->where('category', $categories)->where('subcategory', $subcategories)->get();
                $count = vendorproduct::where('user_id', $vendors)->where('category', $categories)->where('subcategory', $subcategories)->count();
                }
               
            }elseif ($vendors != 'all' && $categories == 'all') {
                if($product !=""){
                     $sql = vendorproduct::where('user_id', $vendors)->where('name','LIKE','%'.$product.'%')->where('product_status','=',1)->where('delete_product','=',0)->get();
                $count = vendorproduct::where('user_id', $vendors)->where('name','LIKE','%'.$product.'%')->where('product_status','=',1)->where('delete_product','=',0)->count();
                }
                else{
                     $sql = vendorproduct::where('user_id', $vendors)->where('product_status','=',1)->where('delete_product','=',0)->get();
                $count = vendorproduct::where('user_id', $vendors)->where('product_status','=',1)->where('delete_product','=',0)->count();
                }
               
            }elseif ($vendors == 'all' && $categories != 'all') {
                if($product !=""){
 $sql = vendorproduct::where('category', $categories)->where('name','LIKE','%'.$product.'%')->get();
                $count = vendorproduct::where('category', $categories)->where('name','LIKE','%'.$product.'%')->count();
                }
                else{
                     $sql = vendorproduct::where('category', $categories)->get();
                $count = vendorproduct::where('category', $categories)->count();
                }
               
            }

            if ($count < 1) {
                $view = '';
            }else{
            
            $view .= "<ul class='paginate' style='list-style-type:none'>";
            $count = $count / 12;
            $value = ceil($count);
            if ($value > 6) {
                $val = 6;
            }else{
                $val = $value;
            }
            foreach ($sql as $key) {
                
            $vendorname = vendors::where('user_id', $key->user_id)->first();
            $products = products::where('id', $key->product_id)->first();
               if(!empty($key->image)){
                $image = $key->image;
                }
                else{
                    $image = $products->image;
                }
                $price = number_format($key->price);
                $myurl = asset('/');
                $ratingss = '';
//                $ratingss=HomeController::rating($key->product_id);
            $view .= "<li><div class='col-md-3' style='margin-bottom: 10px'>
                        <div class='product '>
                            <ul class='product-labels'>
                                
                            </ul>
                            <div class='product-img-wrap'>
                                <img class='product-img-primary' src='".$myurl."/$image' style='height: 122px' alt='Image Alternative text' title='Image Title'>
                                <img class='product-img-alt' src='".$myurl."/$image' alt='Image Alternative text' title='Image Title'>
                            </div>
                            <div class='product-caption'>
                                <ul class='product-caption-rating'>
                                     ";
                                     if($ratingss>0){
                                      if($ratingss==1){
                                      $view .=" <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li><i class='fa fa-star'></i>
                                        </li>";
                                    }
                                      elseif($ratingss==2){
                                       $view .="<li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li><i class='fa fa-star'></i>
                                        </li>";
                                    }
                                      elseif($ratingss==3){
                                      $view=" <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li><i class='fa fa-star'></i>
                                        </li>";
                                    }
                                      elseif($ratingss=4){
                                       $view .="<li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li><i class='fa fa-star'></i>
                                        </li>";
                                    }
                                      else{
                                       $view .="<li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>";
                                    }
                                      
                                       }
                                       else{
                                       $view .="<li class=''><i class='fa fa-star'></i>
                                        </li>
                                        <li class=''><i class='fa fa-star'></i>
                                        </li>
                                        <li class=''><i class='fa fa-star'></i>
                                        </li>
                                        <li class=''><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>";
                                    }
                                        
                                    $view.="
                                    
                                </ul>
                                <h5 class='product-caption-title'><a href='".$myurl."/product/$key->id'>$products->name($vendorname->vendorname)</a></h5>
                                <div class='product-caption-price'><span class='product-caption-price-new'><span style='font-size: 18px'> ".HomeController::converter($key->price)." </span> <br> <span class='add$key->id'><button class='btn btn-sm btn-primary addproducttocart' id=$key->id>add to cart</button></span></span>
                                </div>
                            </div>
                        </div>
                    </div></li>";

            }
            $view .= "</ul>
                        <script type='text/javascript'>
                    $('.paginate').paginathing({
                    perPage: 12,
                    limitPagination: $val
                    })
                    </script>";

            }

            return $view;

        }

        public function addvendor()
        {
            $categories = category::all();
            $customersvendor = customersvendor::where('customer_id', Auth::user()->id)->get();
            $view = '';
            $num = 0;
            $contact = '';
            foreach ($customersvendor as $key) {
                $user = User::where('id', $key->vendor_id)->first();
                $vendor = vendors::where('user_id', $key->vendor_id)->first();
                $num += 1;
                if ($key->verification == 'yes') {
                    $contact = "<p class='bg-primary text-center' style='padding: 3px;'>Contacted</p>";
                }elseif ($key->verification == 'pending') {
                    $contact = "<p class='bg-success text-center' style='padding: 3px;'>Pending</p>";
                    # code...
                }
                else{
                $contact = "<button class='btn btn-primary btn-sm requestuser' id=$key->id>Request Invitation</button>";
                }

                $view .= "<tr>
                            <td>$num</td>
                            <td>$user->name</td>
                            <td>$vendor->country</td>
                            <td>Active</td>
                            <td class='text-center'><span class='showrequest$key->id'>$contact</span></td>
                         </tr>";
            }
            $cart = HomeController::cart();
            return view('customers.addvendor', compact('categories', 'view', 'cart'));
        }

        public function searchvendor()
        {
            $categories = $_GET['categories'];
            $num = 0;
            $view = '';
            $contact = '';
            $vendorproduct = vendorproduct::where('category', $categories)->groupBy('user_id')->get();
            foreach ($vendorproduct as $key) {

                $customersvendor = customersvendor::where('customer_id', Auth::user()->id)->where('vendor_id', $key->user_id)->first();

                $vendor = vendors::where('user_id', $key->user_id)->first();
                if (!empty($customersvendor)) {
                        if ($customersvendor->verification == 'yes') {
                        $contact = "<p class='bg-primary text-center' style='padding: 3px;'>Contacted</p>";
                        $active = 'Active';
                    }elseif ($customersvendor->verification == 'pending') {
                        $contact = "<p class='bg-success text-center' style='padding: 3px;'>Pending</p>";
                        $active = 'Active';
                    }
                    else{
                    $contact = "<button class='btn btn-primary btn-sm requestuseidr' id=$key->id>Request Invitation</button>";
                    $active = 'None';
                    }
                }else{

                    $contact = "<button class='btn btn-primary btn-sm requestuserid' id=$key->id>Request Invitation</button>";
                    $active = 'None';
                }
                

                $user = User::where('id', $key->user_id)->first();
                $num += 1;
                $view .= "<tr>
                            <td>$num</td>
                            <td>$user->name</td>
                            <td>$vendor->country</td>
                            <td>$active</td>
                            <td><span class='showrequestid$key->id'>$contact</span></td>
                         </tr>";
            }
            return $view;

        }

        public function addcustvendor()
        {
            $vendor = $_GET['id'];
            $getcustomersvendor = customersvendor::where('customer_id', Auth::user()->id)->where('vendor_id', $vendor)->first();
            if ($getcustomersvendor) {
                # code...
            }else{
                $addcustomersvendor = new customersvendor;
                $addcustomersvendor->customer_id = Auth::user()->id;
                $addcustomersvendor->vendor_id = $vendor;
                $addcustomersvendor->status = 'pending';
                $addcustomersvendor->save();
            }
            return "<p class='bg-primary' style='padding: 7px'>Added Successfully</p>";
        }

        public function getsubcategory()
        {
            $category = $_GET['category'];
            $view = '';
            $getsubcat = subcategory::where('category_id', $category)->get();
            $view = "<option value='all'>All Categories</option>";
            foreach ($getsubcat as $key) {
                $view .= "<option value=$key->id>$key->name</option>";
            }
            return $view;
        }

        public function requestvendor()
        {
            $id = $_GET['id'];
            $getvendor = customersvendor::where('id', $id)->first();

                $updatevendor = customersvendor::where('id', $id)->update(array('verification' => 'pending'));
                $value = "<p class='bg-success text-center' style='padding: 3px;'>Pending</p>";
                return $value;
        }

        public function requestvendorid()
        {
            $id = $_GET['id'];
            $getvendorproduct = vendorproduct::where('id', $id)->first();
            $addcustomersvendor = new customersvendor;
            $addcustomersvendor->customer_id = Auth::user()->id;
            $addcustomersvendor->vendor_id = $getvendorproduct->user_id;
            $addcustomersvendor->status = 'pending';
            $addcustomersvendor->verification = 'pending';
            $addcustomersvendor->save();
            $customersverification = new customersverification();
            $customersverification->user_id = Auth::user()->id;
            $customersverification->verification = 'pending';
            $customersverification->requestdate = \Carbon\Carbon::now();
            $customersverification->save();
            $value = "<p class='bg-success text-center' style='padding: 3px;'>Pending</p>";
            return $value;
        }
        public function requestvendorsid()
        {
            $id = $_GET['id'];
           // $getvendorproduct = vendorproduct::where('id', $id)->first();
            $addcustomersvendor = new customersvendor;
            $addcustomersvendor->customer_id = Auth::user()->id;
            $addcustomersvendor->vendor_id = $id;
            $addcustomersvendor->status = 'pending';
            $addcustomersvendor->verification = 'pending';
            $addcustomersvendor->save();
            $customersverification = new customersverification();
            $customersverification->user_id = Auth::user()->id;
            $customersverification->verification = 'pending';
            $customersverification->requestdate = \Carbon\Carbon::now();
            $customersverification->save();
            $value = "<p class='bg-success text-center' style='padding: 3px;'>Pending</p>";
            return $value;
        }
        public function validatepayment()
        {
            $code = $_GET['code'];
            $getordersdetails = '';
            $cart = carts::where('user_id', Auth::user()->id)->delete();
            $orders = orders::where('user_id', Auth::user()->id)->where('ordernumber', $code)->update(array('payment' => 'yes'));
            $orderpayment = new orderpayment;
            $orderpayment->user_id = Auth::user()->id;
            $orderpayment->ordernumber = $code;
            $orderpayment->save();



            $orderpayment_id = $orderpayment->id;

            $ordernumber = time().''.$code.$orderpayment_id;
            $updatepayment = orderpayment::where('id', $orderpayment_id)->update(array('payordernumber' => $ordernumber, 'payment_type' => 'card'));

            
            $getordersdetails = ordersdetail::where('ordernumber', $code)->where('payoptions', '!=', 1)->first();
            if ($getordersdetails) {
                $getordersdetail = ordersdetail::where('ordernumber', $code)->where('payoptions', '!=', 1)->get();

                foreach ($getordersdetail as $key) {

                    $date = date('Y/m/d');
                    if ($key->payoptions == 2) {
                        $newdate = date('Y/m/d', strtotime($date. ' + 15 days'));
                    }elseif ($key->payoptions == 3) {
                        $newdate = date('Y/m/d', strtotime($date. ' + 30 days'));
                    }

                    $outstandingpayment = new outstandingpayment;
                    $outstandingpayment->user_id = Auth::user()->id;
                    $outstandingpayment->ordernumber = $key->ordernumber;
                    $outstandingpayment->ref_id = $key->ref_id;
                    $outstandingpayment->product_id = $key->product_id;
                    $outstandingpayment->quantity = $key->quantity;
                    $outstandingpayment->price = $key->price;
                    $outstandingpayment->totalprice = $key->totalprice;
                    $outstandingpayment->dateordered = date('Y/m/d');
                    $outstandingpayment->duedate = $newdate;
                    $outstandingpayment->payoptions = $key->payoptions;
                    $outstandingpayment->payment = 'pending';
                    $outstandingpayment->save();
                }
            }
            

        return Response::json($ordernumber);
            
        }

        public function validatepaymentcashless()
        {
            $code = $_GET['code'];
            $getordersdetails = '';
            $cart = carts::where('user_id', Auth::user()->id)->delete();
            $orders = orders::where('user_id', Auth::user()->id)->where('ordernumber', $code)->update(array('payment' => 'yes'));
            $orderpayment = new orderpayment;
            $orderpayment->user_id = Auth::user()->id;
            $orderpayment->ordernumber = $code;
            $orderpayment->save();

            $orderpayment_id = $orderpayment->id;

            $ordernumber = time().''.$code.$orderpayment_id;
            $updatepayment = orderpayment::where('id', $orderpayment_id)->update(array('payordernumber' => $ordernumber, 'payment_type' => 'paylater'));

            
            $getordersdetails = ordersdetail::where('ordernumber', $code)->where('payoptions', '!=', 1)->first();
            if ($getordersdetails) {
                $getordersdetail = ordersdetail::where('ordernumber', $code)->where('payoptions', '!=', 1)->get();

                foreach ($getordersdetail as $key) {
                    //deduce stock
                    $vendorproduct=vendorproduct::where('product_id','=',$key->product_id)->first();
                    $vendorproduct->stock_count=$vendorproduct->stock_count-$key->quantity;
                    $vendorproduct->save();
                    $date = date('Y/m/d');
                    if ($key->payoptions == 2) {
                        $newdate = date('Y/m/d', strtotime($date. ' + 15 days'));
                    }elseif ($key->payoptions == 3) {
                        $newdate = date('Y/m/d', strtotime($date. ' + 30 days'));
                    }

                    $outstandingpayment = new outstandingpayment;
                    $outstandingpayment->user_id = Auth::user()->id;
                    $outstandingpayment->ordernumber = $key->ordernumber;
                    $outstandingpayment->ref_id = $key->ref_id;
                    $outstandingpayment->product_id = $key->product_id;
                    $outstandingpayment->quantity = $key->quantity;
                    $outstandingpayment->price = $key->price;
                    $outstandingpayment->totalprice = $key->totalprice;
                    $outstandingpayment->dateordered = date('Y/m/d');
                    $outstandingpayment->duedate = $newdate;
                    $outstandingpayment->payoptions = $key->payoptions;
                    $outstandingpayment->payment = 'pending';
                    $outstandingpayment->save();
                }
            }
            

    return Response::json($code);
            
        }

        public function ordersummary($id)
        {
            $getpayment = orderpayment::where('ordernumber', trim($id))->first();
            $ordernumber = $getpayment->ordernumber;
            $user = User::where('id', $getpayment->user_id)->first();
            $name = $user->name;
            $email = $user->email;
            $getproduct = ordersdetail::where('ordernumber', $ordernumber)->get();
            $getorders = orders::where('user_id', Auth::user()->id)->where('ordernumber', $ordernumber)->first();
            $product = '';

            foreach ($getproduct as $key) {
                $productname = vendorproduct::where('id', $key->product_id)->first(); 
                $price = number_format($key->totalprice);

               $product .= "<tr>
                                    <td>$productname->name</td>
                                    <td>$key->quantity</td>
                                    <td>".HomeController::converter($key->totalprice)."</td>
                                </tr>"; 
            }

                     $billing = "<tr>
                                    <td>Nigeria</td>
                                    <td>Nigeria</td>
                                </tr>
                                <tr>
                                    <td>$getorders->orderstate</td>
                                    <td>$getorders->orderstate</td>
                                </tr>
                                <tr>
                                    <td>$getorders->shipaddress</td>
                                    <td>$getorders->shipaddress</td>
                                </tr>
                                <tr>
                                    <td>$getorders->phone</td>
                                    <td>$getorders->phone</td>
                                </tr>
                                <tr>
                                    <td>$user->name</td>
                                    <td>$user->name</td>
                                </tr>";


            $cart = '';

            return view('cart.ordersummary', compact('product', 'billing', 'name', 'email', 'cart'));

        }

        public function addreview()
        {
            $id = $_GET['id'];
            $reviewtext = $_GET['reviewtext'];
            $rating = $_GET['rating'];
            $ordersdetail = ordersdetail::where('id', $id)->first();
            $product_id = $ordersdetail->product_id;

            $getreview = review::where('user_id', Auth::user()->id)->where('product_id', $product_id)->where('order_id', $id)->first();
            if ($getreview) {
                
            }else{
                $review = new review;
                $review->user_id = Auth::user()->id;
                $review->order_id = $id;
                $review->product_id = $product_id;
                $review->review = $reviewtext;
                $review->rating = $rating;
                $review->save();
            }

            $text = 'Review sent successfully';
            return $text;

        }

        public function wallet()
        {
            $cart = HomeController::cart();
            
            $wallet = wallet::where('user_id', Auth::user()->id)->first();
            if ($wallet) {
                $wallet = ($wallet->balance);
            }else{
                $wallet = 0;
            }

            return view('customers.wallet', compact('cart', 'wallet'));  
        }

        public function addfund()
        {
            $fund = $_GET['fund'];

            $getwallet = wallet::where('user_id', Auth::user()->id)->first();
            if ($getwallet) {
                $amount = $fund + $getwallet->balance;
                $wallet = wallet::where('user_id', Auth::user()->id)->update(array('balance' => $amount));

                $wallethistory = new wallethistory;
            $wallethistory->transactionid = time();
            $wallethistory->user_id = Auth::user()->id;
            $wallethistory->payment = $fund;
            $wallethistory->balance = $amount;
            $wallethistory->transactiontype = 1;
            $wallethistory->date = date('Y/m/d');
            $wallethistory->save();

            }else{
                $amount = $fund;

                $wallet = new wallet;
            $wallet->user_id = Auth::user()->id;
            $wallet->balance = $amount;
            $wallet->date = date('Y/m/d');
            $wallet->save();

            $wallethistory = new wallethistory;
            $wallethistory->transactionid = time();
            $wallethistory->user_id = Auth::user()->id;
            $wallethistory->payment = $fund;
            $wallethistory->balance = $amount;
            $wallethistory->transactiontype = 1;
            $wallethistory->date = date('Y/m/d');
            $wallethistory->save();

            }
            

            
        }

        public function accounthistory()
        {
            $viewhistory = wallethistory::where('user_id', Auth::user()->id)->first(); 
            $view = "";
            $no = 0;
            if ($viewhistory) {
                $viewhistory = wallethistory::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();
                foreach ($viewhistory as $key) {
                    # code...
                    $no ++;
                
                if ($key->transactiontype == 1) {
                    $transactiontype = "Deposit";
                }elseif($key->transactiontype == 2){
                    $transactiontype = "Purchase";
                }else{
                    $transactiontype="Pending payment";
                }

                $view .= "<tr>
                            <td>$no</td>
                            <td>$transactiontype</td>
                            <td>$key->transactionid</td>
                            <td>".HomeController::converter($key->payment)."</td>
                            <td>".HomeController::converter($key->balance)."</td>
                            <td>$key->date</td>
                        </tr>";
                }
            }

            $cart = HomeController::cart();
            return view('customers.accounthistory', compact('viewhistory', 'view', 'cart'));
        }

        public function paywithwallet()
        {
            $password = $_GET['password'];
            $code = $_GET['code'];
            $walletusers = walletusers::where('user_id', Auth::user()->id)->where('password', $password)->first();
            $getwallet = wallet::where('user_id', Auth::user()->id)->first();


            if ($walletusers) {
                
            $cart = carts::where('user_id', Auth::user()->id)->delete();
            $orders = orders::where('user_id', Auth::user()->id)->where('ordernumber', $code)->update(array('payment' => 'yes'));
            $ord = orders::where('user_id', Auth::user()->id)->where('ordernumber', $code)->first();
            $orderpayment = new orderpayment;
            $orderpayment->user_id = Auth::user()->id;
            $orderpayment->ordernumber = $code;
            $orderpayment->save();
            $orderpayment_id = $orderpayment->id;

            $ordernumber = time().''.$code.$orderpayment_id;
            $updatepayment = orderpayment::where('id', $orderpayment_id)->update(array('payordernumber' => $ordernumber, 'payment_type' => 'wallet'));

            $getorders = ordersdetail::where('ordernumber', $code)->where('payoptions', 1)->sum('totalprice');
            $totalorder = $getwallet->balance - ($getorders+$ord->shipping_fee);
            $updatewallet = wallet::where('user_id', Auth::user()->id)->update(array('balance' => $totalorder));
 
            $wallethistory = new wallethistory;
            $wallethistory->transactionid = time();
            $wallethistory->user_id = Auth::user()->id;
            $wallethistory->payment = $getorders+$ord->shipping_fee;
            $wallethistory->balance = $totalorder;
            $wallethistory->transactiontype = 2;
            $wallethistory->date = date('Y/m/d');
            $wallethistory->save();
            $ordersdetail = ordersdetail::where('ordernumber', $code)->where('payoptions', 1)->get();
            foreach ($ordersdetail as $ods) {
                $vendorproduct=vendorproduct::where('product_id','=',$ods->product_id)->first();
                $vendorproduct->stock_count=$vendorproduct->stock_count-$ods->quantity;
                $vendorproduct->save();
            }
            $getordersdetail = ordersdetail::where('ordernumber', $code)->where('payoptions', '!=', 1)->get();
            foreach ($getordersdetail as $key) {

                    $date = date('Y/m/d');
                    if ($key->payoptions == 2) {
                        $newdate = date('Y/m/d', strtotime($date. ' + 15 days'));
                    }elseif ($key->payoptions == 3) {
                        $newdate = date('Y/m/d', strtotime($date. ' + 30 days'));
                    }

                    $outstandingpayment = new outstandingpayment;
                    $outstandingpayment->user_id = Auth::user()->id;
                    $outstandingpayment->ordernumber = $key->ordernumber;
                    $outstandingpayment->ref_id = $key->ref_id;
                    $outstandingpayment->product_id = $key->product_id;
                    $outstandingpayment->quantity = $key->quantity;
                    $outstandingpayment->price = $key->price;
                    $outstandingpayment->totalprice = $key->totalprice;
                    $outstandingpayment->dateordered = date('Y/m/d');
                    $outstandingpayment->duedate = $newdate;
                    $outstandingpayment->payoptions = $key->payoptions;
                    $outstandingpayment->payment = 'pending';
                    $outstandingpayment->save();
                }
            return json_decode($code);

            }else{
                return 'false';
            }
        }

        public function walletsetting()
        {
            $cart = HomeController::cart();
           
            $walletusers = walletusers::where('user_id', Auth::user()->id)->first();
           if($walletusers){
            $walletpassword = $walletusers->password;
        }
        else{
            $walletpassword=NULL;
        }

            return view('customers.wallethistory', compact('cart', 'walletpassword'));
        }

        public function changewalletpassword()
        {
        $password = $_GET['password'];
        $newpassword = $_GET['newpassword'];
        $confirmpassword = $_GET['confirmpassword'];

            $walletusers = walletusers::where('user_id', Auth::user()->id)->first();
            if ($password == $walletusers->password) {
                $walletusers = walletusers::where('user_id', Auth::user()->id)->update(array('password' => $newpassword));
                return 'true';
            }else{
                return 'false';
            }

        }

        public function dueandoutstanding()
        {
            $cart = HomeController::cart();
            $outstandingpayment = outstandingpayment::where('user_id', Auth::user()->id)->where('payment', '!=', 'yes')->first();
            $num = 0;
            $view = '';
            $validwallet = '';
            $myurl = asset('/');

            $walletusers = walletusers::where('user_id', Auth::user()->id)->first();

                    
            if ($walletusers) {
                $walletbalance=wallet::where('user_id',Auth::user()->id)->first();
                if($walletbalance){
                    $balance=$walletbalance->balance;
                }else{
                    $balance=0;
                }

                    $validwallet = true; 
                
            }else{
                    $validwallet = false;
                     $balance=0;
            }

            if ($outstandingpayment) {
                
                $getoutstandingpayment = outstandingpayment::where('user_id', Auth::user()->id)->where('payment', '!=', 'yes')->orderBy('id','DESC')->get();

                foreach ($getoutstandingpayment as $keys) {
                    $num += 1;

                    $key = ordersdetail::where('ref_id', $keys->ref_id)->first();

                    $outstandingpayment = outstandingpayment::where('ref_id', $keys->ref_id)->first();
                    $duetotal = $outstandingpayment->totalprice;
                    
                    if($outstandingpayment->dateordered>Carbon::today()->toDateString()){
                        $typeis='outstanding Payment';
                    }
                    else{
                        $typeis='Due Payment';
                    }
                $payoptions = '';
                if ($key->payoptions != '1') {
                        if ($key->payoptions == '2') {
                            $payoptions = '<br>15 days Payment';
                        }elseif ($key->payoptions == '3') {
                            $payoptions = '<br>30 days Payment';
                        }
                    }

                $view .= "
                            <tr style='font-size: 14px'>";              
                   $getproducts = vendorproduct::where('id', $key->product_id)->first();
                   $vendorname = vendors::where('user_id', $getproducts->user_id)->first();
                $products = products::where('id', $getproducts->product_id)->first();
                   if(!empty($getproducts->image)){
                    $image = $getproducts->image;
                    }
                    else{
                        $image = $products->image;
                    }

                    if (!empty($key->workplace_id)) {
                        $workplace = workplace::where('user_id', Auth::user()->id)->where('id', $key->workplace_id)->first();
                        
                        $workplacename = $workplace->name;
                    }else{
                        $workplacename = '';
                    }

                    $price = number_format($key->totalprice);
                $description = str_limit($getproducts->remark, 120);
                $unitprice = number_format($key->price);

                if ($key->deliverystatus != 'delivered') {
                    $delivery = "<button class='btn btn-xs btn-danger'>Pending</button>";
                }else{
                    $delivery = "<h5 class='bg-success' style='padding: 5px; text-align: center'>Delivered on ".$key->deliverydate."</h5>";
                }

                    $view .= "<td>$num</td>
                            <td>$key->ref_id</td>
                            <td><a href='".$myurl."/customers/ordersdetail/$key->order_id'>$key->ordernumber</a></td>

                            <td class='table-shopping-cart-img'>

                                <a href='".$myurl."/product/$getproducts->slog' style='color: #000'>
                                <div class='col-md-2'>
                                <img src='".$myurl."/$image' alt='Image Alternative text' title='Image Title' style='width: 40px' />
                                </div>
                                <div class='col-md-10'>
                                    <p style='font-size: 14px'><strong>$products->name</strong><br>
                                    $description</p>
                                    <p>".HomeController::converter($key->price)." X $key->quantity = ".HomeController::converter($key->totalprice)." $payoptions</p> 
                                    <p style='color: #8D8A97 !important'>Product Properties: Color $key->color</p>
                                </div>
                                </a>
                            </td>
                            <td>".HomeController::converter($key->totalprice)."</td>
                            <td>$keys->dateordered</td>
                            <td>$keys->duedate</td>
                            <td>$typeis</td>
                            <td><button class='btn btn-default popup-text paydue' href='#paymentdue-$key->id' data-effect='mfp-move-from-top' id=$keys->id>Pay</button></td>";
                $view .= "</tr>
                <div class='mfp-with-anim mfp-hide mfp-dialog4 clearfix' id='paymentdue-$key->id' style='width: 100%''>
    <h3 class='widget-title'>Payment</h3>
    <p>Select your payment method</p>
    <hr />
    <input type='hidden' name='dueid' class='dueid'>
    <form action='".$myurl."/pay/dueandoutstanding' method='POST'    class='cardform'>
                  '".csrf_field()."'
                  <div class='form-group' style='display:none;'>
                    <label>Amount</label>
                    <input class='form-control fund' name='amount' value='$key->totalprice' type='number' required />
                    <input class='form-control fund' name='ordernumber' value='$key->ordernumber' type='text' required />
                    <p class='alert alert-danger emailerror' style='display: none;''>
                        Amount field is empty
                    </p>
                </div>
                <input class='btn btn-primary ' type='submit' value='Pay with card' />
                
                  
                </form>
                <a class='btn btn-primary' href='$myurl/outstanding/slip/$keys->id' >Payment Slip</a>";
                if($validwallet){
                    if($key->totalprice<$balance){
                        $view .="<button class='paywithwallet btn btn-primary popup-text  changeval' href='#walletpayment' id='1' >Pay with wallet</button></div> 
";
                    }
                    else{
                        $view .="<button class='paywithwallet btn btn-primary popup-text  changeval' href='#walletpayment' id='1' disabled >Pay with wallet</button></div> 
";
                    }
                }
                else{
                    $view .="<button class='paywithwallet btn btn-primary popup-text  changeval' href='#walletpayment' id='1'  disabled >Pay with wallet</button></div> 
";
                }
   
    
   
    
        
                

                }
            }

            

            return view('customers.dueandoutstanding', compact('cart', 'view', 'validwallet','balance'));
        }


        public function paywithwalletoutstand()
        {
            $id = $_GET['id'];

            $outstandingpayment = outstandingpayment::where('id', $id)->first();
            $duetotal = $outstandingpayment->totalprice;
            $duetotal = number_format($duetotal);

            $wallet = wallet::where('user_id', Auth::user()->id)->first();
            $walletbalance = $wallet->balance;
            $walletbalance = number_format($walletbalance);
            $data = "<input type='hidden' name='oustandingid' class='oustandingid' value=$id<p>Wallet Balance: $walletbalance <br> Total Amount: $duetotal</p>";
            
            return $data;
        }

        public function paywallet()
        {
            $password = $_GET['password'];
            $code = $_GET['code'];
            $walletusers = walletusers::where('user_id', Auth::user()->id)->where('password', $password)->first();
            $getwallet = wallet::where('user_id', Auth::user()->id)->first();


            if ($walletusers) {
                if($code=='outstanding'){
                    $outstandings=outstandingpayment::where('user_id','=',Auth::user()->id)->where('duedate','>',Carbon::today())->where('payment','=','pending')->get();
                    $outstanding = $outstandings->sum('totalprice');
                    $totalorder = $getwallet->balance - $outstanding;
                    $updatewallet = wallet::where('user_id', Auth::user()->id)->update(array('balance' => $totalorder));

                    $outstandingpayment2 = outstandingpayment::where('user_id','=',Auth::user()->id)->where('duedate','>',Carbon::today())->where('payment','=','pending')->update(array('payment' => 'yes'));

                    $wallethistory = new wallethistory;
                    $wallethistory->transactionid = time();
                    $wallethistory->user_id = Auth::user()->id;
                    $wallethistory->payment = $outstanding;
                    $wallethistory->balance = $totalorder;
                    $wallethistory->transactiontype = 2;
                    $wallethistory->date = date('Y/m/d');
                    $wallethistory->save();
                        $outstanding=outstandingpayment::where('user_id','=',Auth::user()->id)->where('duedate','>',Carbon::today())->where('payment','=','pending')->get();
                        foreach ($outstandings as $key => $out) {
                            $ordersdetail=ordersdetail::where('ordernumber','=',$out->ordernumber)->where('product_id','=',$out->product_id)->first();
                           $orderpayment = new orderpayment;
            $orderpayment->user_id = Auth::user()->id;
            $orderpayment->ordernumber = $out->ordernumber;
            $orderpayment->ordersdetail_id=$ordersdetail->id;
            $orderpayment->save();
            $orderpayment_id = $orderpayment->id;

            $ordernumber = time().''.$out->ordernumber.$orderpayment_id;
            $updatepayment = orderpayment::where('id', $orderpayment_id)->update(array('payordernumber' => $ordernumber, 'payment_type' => 'wallet')); 
                        } 
                    

                    return 'true';
                        
                }
                else if($code=='due'){
                    $dues=outstandingpayment::where('user_id','=',Auth::user()->id)->where('duedate','<',Carbon::today())->where('payment','=','pending')->get();
                    $due = $dues->sum('totalprice');
                    $totalorder = $getwallet->balance - $due;
                    $updatewallet = wallet::where('user_id', Auth::user()->id)->update(array('balance' => $totalorder));

                    $outstandingpayment2 = outstandingpayment::where('user_id','=',Auth::user()->id)->where('duedate','<',Carbon::today())->where('payment','=','pending')->update(array('payment' => 'yes'));

                    $wallethistory = new wallethistory;
                    $wallethistory->transactionid = time();
                    $wallethistory->user_id = Auth::user()->id;
                    $wallethistory->payment = $due;
                    $wallethistory->balance = $totalorder;
                    $wallethistory->transactiontype = 2;
                    $wallethistory->date = date('Y/m/d');
                    $wallethistory->save();
                    $due=outstandingpayment::where('user_id','=',Auth::user()->id)->where('duedate','<',Carbon::today())->where('payment','=','pending')->get();

                     foreach ($dues as $key => $out) {
                        $ordersdetail=ordersdetail::where('ordernumber','=',$out->ordernumber)->where('product_id','=',$out->product_id)->first();
                           $orderpayment = new orderpayment;
            $orderpayment->user_id = Auth::user()->id;
            $orderpayment->ordernumber = $out->ordernumber;
            $orderpayment->ordersdetail_id=$ordersdetail->id;
            $orderpayment->save();
            $orderpayment_id = $orderpayment->id;

            $ordernumber = time().''.$out->ordernumber.$orderpayment_id;
            $updatepayment = orderpayment::where('id', $orderpayment_id)->update(array('payordernumber' => $ordernumber, 'payment_type' => 'wallet')); 
                        }
                    return 'true';
                }
                else{
                $outstandingpayment = outstandingpayment::where('id', $code)->first();
            $duetotal = $outstandingpayment->totalprice;

                if ($getwallet->balance >= $duetotal) {
                    
                    $totalorder = $getwallet->balance - $duetotal;
                    $updatewallet = wallet::where('user_id', Auth::user()->id)->update(array('balance' => $totalorder));

                    $outstandingpayment2 = outstandingpayment::where('id', $code)->update(array('payment' => 'yes'));

                    $wallethistory = new wallethistory;
                    $wallethistory->transactionid = time();
                    $wallethistory->user_id = Auth::user()->id;
                    $wallethistory->payment = $duetotal;
                    $wallethistory->balance = $totalorder;
                    $wallethistory->transactiontype = 2;
                    $wallethistory->date = date('Y/m/d');
                    $wallethistory->save();
                        $ordersdetail=ordersdetail::where('ordernumber','=',$outstandingpayment->ordernumber)->where('product_id','=',$outstandingpayment->product_id)->first();
                   $orderpayment = new orderpayment;
            $orderpayment->user_id = Auth::user()->id;
            $orderpayment->ordernumber = $outstandingpayment->ordernumber;
            $orderpayment->ordersdetail_id=$ordersdetail->id;
            $orderpayment->save();
            $orderpayment_id = $orderpayment->id;

            $ordernumber = time().''.$outstandingpayment->ordernumber.$orderpayment_id;
            $updatepayment = orderpayment::where('id', $orderpayment_id)->update(array('payordernumber' => $ordernumber, 'payment_type' => 'wallet')); 

                    return 'true';

                }else{
                    return 'insufficient';
                }
                }

            }else{
                return 'false';
            }
        }

        public function paywithcard()
        {
            $id = $_GET['id'];
            $outstandingpayment = outstandingpayment::where('id', $id)->update(array('payment' => 'yes'));
            $outstandingpayment1 = outstandingpayment::where('id', $id)->first();

            $orderpayment = new orderpayment;
            $orderpayment->user_id = Auth::user()->id;
            $orderpayment->ordernumber = $outstandingpayment1->ordernumber;
            $orderpayment->save();
            $orderpayment_id = $orderpayment->id;

            $ordernumber = time().''.$outstandingpayment1->ordernumber.$orderpayment_id;
            $updatepayment = orderpayment::where('id', $orderpayment_id)->update(array('payordernumber' => $ordernumber, 'payment_type' => 'card'));

        }



public function save_q_a(Request $request)
{

    
    $product_id = $request->product_id;
    $question = $request->question;
    $userid = $request->user_id;
    $q_a = new Customer_QA();
    $q_a->product_id = $product_id;
    $q_a->question = $question;
    $q_a->save();

    $q_aa = DB::table('customer_q_a')
                            ->select('customer_q_a.*','customer_q_a.id as id')
                           ->leftjoin('vendorproduct','vendorproduct.id','=','customer_q_a.product_id')
                            ->where('customer_q_a.product_id', $q_a->product_id)
                            ->orderBy('customer_q_a.created_at','DESC')
                            ->limit(1)
                            ->first();
  
    return Response::json($q_aa);
}


public function loadDataAjax(Request $request)
    {
        $output = '';
        $id = $request->id;
        $product_id = $request->product_id;
        $q_as = DB::table('customer_q_a')
            ->select('customer_q_a.*','vendorproduct.*','customer_q_a.id as id')
           ->leftjoin('vendorproduct','vendorproduct.id','=','customer_q_a.product_id')
           ->where('customer_q_a.id','<',$id)
           ->where('customer_q_a.product_id', $product_id)
           ->orderBy('customer_q_a.created_at','DESC')
           ->limit(2)
            ->get();
        
        if(!$q_as->isEmpty())
        {
            foreach($q_as as $k)
            {
                if($k->answer)
                {

                    $answer ='<div class="product-page-qa-answer">
                                        <p class="product-page-qa-text">'.$k->answer.'</p>
                                        <p class="product-page-qa-meta">answered on '.$k->answer_date.'</p>
                                    </div>';

                }else{

                    $answer='';
                }
                                
                $output .= '<article class="product-page-qa"><div class="product-page-qa-question">
                                        <p class="product-page-qa-text">'.$k->question.'</p>
                                        <p class="product-page-qa-meta">asked  on "'.$k->created_at.'"</p>
                                    </div>
                                '.$answer.'
                                    </article>';
            }
            
            $output .= '<div id="remove-row">
                            <button id="btn-more" data-id="'.$k->id.'" class="nounderline btn-block mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent btn btn-primary" > Load More </button>
                        </div>';
            
            echo $output;
        }
    }

public function shipo()
{

    

        \Shippo::setApiKey("shippo_live_2749e7522c60e4cee9dfed213475bb79e430f77e");
    $address = \Shippo_Address::
        create(
            array(
                 'object_purpose' => 'QUOTE',
                 'name' => 'John Smith',
                 'company' => 'Initech',
                 'street1' => '6512 Greene Rd.',
                 'city' => 'Woodridge',
                 'state' => 'IL',
                 'zip' => '60517',
                 'country' => 'US',
                 'phone' => '773 353 2345',
                 'email' => 'jmercouris@iit.com',
                 'metadata' => 'Customer ID 23424'
            ));
            
        var_dump($address);
}
public function profile(){
    $cart = HomeController::cart();

            $date = date('Y/m/d');
            $from = date('Y/m/01', strtotime($date));
            $to = date('Y/m/t', strtotime($date));
            $sumquantity = '';
            $sumtotal = '';
           $orders = orders::where('user_id', Auth::user()->id)->where('payment', 'yes')->whereBetween('dateordered', [$from, $to])->orderBy('dateordered', 'desc')->get();
           $getorders = orders::where('user_id', Auth::user()->id)->where('payment', 'yes')->whereBetween('dateordered', [$from, $to])->get();
           $chartarray = array();

           foreach ($orders as $keys) {
                $sumorder = ordersdetail::where('order_id', $keys->id)->sum('totalprice');
                $sumqty = ordersdetail::where('order_id', $keys->id)->sum('quantity');
                $sumtotal = $sumorder;
                $sumquantity = $sumqty; 
            }

           foreach ($getorders as $key) {

                $getordersdetail = ordersdetail::where('order_id', $key->id)->get();

                foreach ($getordersdetail as $value) {
                    $vendorproduct = vendorproduct::where('id', $value->product_id)->first();
                    $category = category::where('id', $vendorproduct->category)->first();
                    $categoryname = $category->name;

                    if ($this->in_array_r($categoryname, $chartarray)) {
                        $searchkey = $this->searchForId($categoryname, $chartarray);
                        $chartarray[$searchkey]['y'] = $chartarray[$searchkey]['y'] + $value->totalprice;
                        
                    }else{
                        $chartarray[] = array('y' => $value->totalprice, 'label' => $categoryname); 
                    }

                    

                   
                }
               
           }
    return view('customers.profile', compact('cart', 'chartarray', 'sumquantity', 'sumtotal'));
}
public function updateProfile(Request $request){
     $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.Auth::user()->id,
            'password' => 'nullable|min:6',
             'password_confirmation' => 'sometimes|required_with:password|same:password',
            'company_name' => 'required',
            'type_of_business' => 'required',
            'phone_of_MD_Chairman' => 'required',
            'email_of_MD_Chairman' => 'required',
            'phone_of_contact_person' => 'required',
            'email_of_contact_person' => 'required',


            ]);

        $email = request('email');
        $password = request('password');
        $name = request('name');


        $user =User::find(Auth::user()->id);
        $user->name = $name;
        $user->phone=request('phone');
        $user->email = $email;
        if($password){
        $user->password = Hash::make($password);
        }
        if($user->save())
         {
            $customer =Customer::where('user_id','=',$user->id)->first();
            $customer->company_name = request('company_name');
            $customer->name = $name;
            $customer->about = request('about_company');
            $customer->website = request('website_url');
            $customer->cac = request('cac_number');
            $customer->businesstype = request('type_of_business');
            $customer->yearsofexitence = request('year_of_existence');
            $customer->mdtel = request('phone_of_MD_Chairman');
            $customer->mdemail = request('email_of_MD_Chairman');
            $customer->contactpersontel = request('phone_of_contact_person');
            $customer->contactpersonemail  = request('email_of_contact_person');
            $customer->company_rating  = request('company_rating');
            $customer->country=request('country');
            $customer->state=request('state');
            $customer->city=request('city');
            $customer->address=request('address');
            $customer->address_2=request('address_2');
            $customer->zip=request('zip');
             $customer->billing_country=request('billing_country');
            $customer->billing_state=request('billing_state');
            $customer->billing_city=request('billing_city');
            $customer->billing_address=request('billing_address');
            $customer->billing_address_2=request('billing_address_2');
            $customer->billing_zip=request('billing_zip');
            $customer->same_billing=request('same_billing');
            $customer->save();


         }
         return redirect()->back();
}
public function vendorsList(){
    $sortIdentity='id';
     $sorting='ASC';
        if(Session::has('sortvendors')){
        if(Session::get('sortby')=='Newest First'){
            $sortIdentity='id';
            $sorting='ASC';
        }
        else if(Session::get('sortvendors')=='Professional'){
            $sortIdentity='ratings';
        $sorting='ASC';
        }
        else if(Session::get('sortvendors')=='Expert'){
            $sortIdentity='ratings';
        $sorting='DESC';
        }
        else if(Session::get('sortvendors')=='Title : A - Z'){
            $sortIdentity='vendorname';
        $sorting='ASC';
        }
        else{
$sortIdentity='vendorname';
        $sorting='DESC';
        }
    }
    $pagination=20;
    if(Session::has('pagination')){
        if(Session::get('pagination')=='9 / page'){
            $pagination=9;
        }
        else if(Session::get('pagination')=='12 / page'){
            $pagination=12;
        }
        else if(Session::get('pagination')=='18 / page'){
            $pagination=18;
        }
        else{
            $pagination=20;
        }
    }
    $vendors=vendors::orderBy($sortIdentity,$sorting)->paginate($pagination);
    $category=vendorproduct::groupBy('category')->get();
    $subcategory=vendorproduct::groupBy('subcategory')->get();
    $locations=vendors::groupBy('location')->get();

    $categories='';
    $subcategories='';
    $location='';
    foreach ($locations as $key) {
           $location .= "<div class='checkbox'>
                                 <label>
                                    <input class=' form vender_filter' name='location[]' type='checkbox' value='$key->location' style='position:relative;' />$key->location<span class='category-filters-amount'></span>
                                </label>
                            </div>";
           // $getmanu = category::where('id', $key->category)->first();
          //  $location .="<option value='$key->location'>$key->location</option>";
           /* $categories .= "<div class='checkbox'>
                                <label>
                                    <input class=' form vender_filter' name='categories[]' type='checkbox' value=$key->category />$getmanu->name<span class='category-filters-amount'></span>
                                </label>
                            </div>"; */

        }
  foreach ($category as $key) {
            
            $getmanu = category::where('id', $key->category)->first();
            $categories .="<option value='$key->category'>$getmanu->name</option>";
           /* $categories .= "<div class='checkbox'>
                                <label>
                                    <input class=' form vender_filter' name='categories[]' type='checkbox' value=$key->category />$getmanu->name<span class='category-filters-amount'></span>
                                </label>
                            </div>"; */

        }
        foreach ($subcategory as $key) {
            
            $getmanu = subcategory::where('id', $key->subcategory)->first();
            $subcategories .="<option value='$key->subcategory'>$getmanu->name</option>";
         
          /*  $subcategories .= "<div class='checkbox'>
                                <label>
                                    <input class=' form vender_filter' name='subcategories[]' type='checkbox' value=$key->subcategory />$getmanu->name<span class='category-filters-amount'></span>
                                </label>
                            </div>"; */

        }
        
     $cart = HomeController::cart();
    return view('vendors/vendorlist',compact('vendors','cart','categories','subcategories','location'));
}

    public function vendorsearchr(Request $request){
        parse_str($_GET['val'], $formdata);
        $vendor = DB::table('vendors');
        $query = $vendor;
        $value = '';
        $view = '';
        if (!empty($formdata)) {
            $data = array();
            if (!empty($formdata['location'])) {
                # code...
                $data[] = $formdata['location'];

                foreach ($data as $key) {
                    foreach ($key as $value) {
                      /*  $query = $product->orWhere(function($query) use ($value, $category, $max, $min)
                                    {
                                        $query->where('category', $category)
                                        ->whereBetween('price', [$min, $max])
                                        ->where('manufacturer_id', $value);
                                    });
                        */
                                    $man[]=$value;
                    }
                    
                }
                $query->whereIn('location',$man);
            }
            if (!empty($formdata['supplier'])) {
                # code...
                unset($data);
                $data[] = $formdata['supplier'];

                foreach ($data as $key) {
                    foreach ($key as $value) {
                      /*  $query = $product->orWhere(function($query) use ($value, $category, $max, $min)
                                    {
                                        $query->where('category', $category)
                                        ->whereBetween('price', [$min, $max])
                                        ->where('manufacturer_id', $value);
                                    });
                        */
                                    $suplis[]=$value;
                    }
                    
                }
                $query->whereIn('vendor_type',$suplis);
            }
            if (!empty($formdata['categories'])) {
                # code...
                unset($data);
                $data[] = $formdata['categories'];
                
                foreach ($data as $value) {
                   // foreach ($key as $value) {
                        
                        $values=vendorproduct::where('category','=',$value)->first();
                      /*  $query = $product->orWhere(function($query) use ($value, $category, $max, $min)
                                    {
                                        $query->where('category', $category)
                                        ->whereBetween('price', [$min, $max])
                                        ->where('manufacturer_id', $value);
                                    });
                        */
                                    $cats[]=$values->user_id;
                    //}
                    
                }
                $query->whereIn('user_id',$cats);
            }
            if (!empty($formdata['subcategories'])) {
                # code...
                unset($data);
                $data[] = $formdata['subcategories'];

                foreach ($data as $value) {
                  
                   // foreach ($key as $value) {
                        $subcats=vendorproduct::where('subcategory','=',$value)->first();
                      /*  $query = $product->orWhere(function($query) use ($value, $category, $max, $min)
                                    {
                                        $query->where('category', $category)
                                        ->whereBetween('price', [$min, $max])
                                        ->where('manufacturer_id', $value);
                                    });
                        */
                                    $subca[]=$subcats->user_id;
                 //   }
                    
                }
                $query->whereIn('user_id',$subca);
            }
        }
        $querys = $query->get(); 
        $myurl =  asset('/');
        foreach ($querys as  $key) {
            $view.="<div class='col-md-4'>
                               
                            <div class='product '>
                                <ul class='product-labels'>
                                    
                                </ul>
                                <div class='product-img-wrap'>
                                    <img class='product-img-primary' src=".$myurl."/$key->image alt='Image Alternative text' title='Image Title' style='height: 180px' />
                                    <img class='product-img-alt' src=".$myurl."/$key->image alt='Image Alternative text' title='Image Title' style='height: 180px' />
                                </div>
                                <a class='product-link' href='".url('product/'.$key->id)."'></a>
                                <div class='product-caption'>
                                    <ul class='product-caption-rating'>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li><i class='fa fa-star'></i>
                                        </li>
                                    </ul>
                                    <h5 class='product-caption-title'>$key->vendorname</h5>
                                    
                                    <div class='product-caption-price'></div>
                                    <ul class='product-caption-feature-list'>
                                       
                                    </ul>
                                    
                                   
                                 </diV>   
                            </div>
                        </div>";
        }
        return $view;
    }
    public function create_rfq(){
        $cart = HomeController::cart();
        return view('RFQ.create_rfq',compact('cart'));
    }
    public function vendorRFQ(){
        $rfq=rfq::all();
      return view('vendors.RFQ.rfq',compact('rfq'));
    }
    public function adminRFQ(){
        return view('admin.RFQ.rfq');
    }
    public function customerRFQ(){
        $cart=HomeController::cart();
        return view('RFQ.viewrfq',compact('cart'));
    }
    public function selected($id,$vendorid){
        $rfqvenodr=rfqvendor::where('rfq_id','=',$id)->where('vendor_id','=',$vendorid)->first();
        $rfqvenodr->selected=$vendorid;
        $rfqvenodr->save();
        $user=User::find($vendorid);
        Mail::to($user->email)->send(new rfqMail());
        return back()->with('message',''.$user->name.' is selected vendor');
    }
    public function getsubcategory_for_rfq(Request $request){
        $category=$request->get('category');
        $view='';
        $subcategories=subcategory::where('category_id','=',$category)->get();
        if(count($subcategories)>0){
            foreach ($subcategories as $key) {
               $view .='<option value="'.$key->id.'" id="subcat">'.$key->name.'</option>';
            }
        }

        return json_encode($view);
    }
    public function store_rfq(Request $request){
        $this->validate($request,[
            'product_name'=>'required',
            'product_generic_name'=>'required',
            'category'=>'required',
            'subcategory'=>'required']);
        $user_id=Auth::user()->id;
        $rfq=new rfq;
        $rfq->user_id=$user_id;
        $rfq->product_name=$request->product_name;
        $rfq->category=$request->category;
        $rfq->subcategory=$request->subcategory;
        $rfq->generic_name=$request->product_generic_name;
        $rfq->orders=$request->order;
        $rfq->unit=$request->units;
        $rfq->quantity=$request->quantity;
        $rfq->duration=$request->duration;
        $rfq->paymentMethod=$request->paymentmethod;
        $rfq->businuss_email=$request->businuss_email;
        $rfq->product_certificate=$request->product_certificate;
        $rfq->company_certificate=$request->company_certificate;
         if($request->file('file')){

            $image = $request->file('file');
            $filename = time().'-'.$image->getClientOriginalName(). '.' . $image->getClientOriginalExtension();
            $path = base_path('img\products');
            $image->move($path, $filename);
            $images = 'img/products/'.$filename;
            $rfq->file=$images;
            }
            $rfq->save();
            return back()->with('status','Posted successfully!');


    }
    public function placebid(Request $request,$id){
        $bid=new rfqvendor;
        $bid->vendor_id=Auth::user()->id;
        $bid->rfq_id=$id;
        $bid->bid=$request->bid;
        $bid->note=$request->bidnote;
        $bid->save();
        return back()->with('status','Bid placed successfully');
    }
    public function getcategory(Request $request){
       $category = $_GET['vendor'];
            $view = '';
            $vendorproduct=vendorproduct::where('user_id','=',$category)->groupBy('category')->get();
        
           
            $view = "<option value='all'>All Categories</option>";
            foreach ($vendorproduct as $category) {
                 $key = category::where('id', $category->category)->first();
                $view .= "<option value=$key->id>$key->name</option>";
            }
            return $view;

    }
    public function showfavorite(){
        $cart = HomeController::cart();
        $credit=[];
        $favorite=[];
        $creditvenodrs=customersvendor::where('customer_id','=',Auth::user()->id)->groupBy('vendor_id')->get();
        foreach ($creditvenodrs as $key => $value) {
            $credit[]=$value->vendor_id;
        }
        $favoritevendor=favoritevendor::where('customer_id','=',Auth::user()->id)->groupBy('vendor_id')->get();
        foreach ($favoritevendor as $key => $value) {
            $favorite[]=$value->vendor_id;
            }
        $array=array_merge($credit,$favorite);
        $array=array_unique($array);
       
        
        return view('customers.favorite',compact('cart','array'));
    }
    public function setfavorite(Request $request){
        $vendor=$request->get('data');
        $favorit=favoritevendor::where('vendor_id','=',$vendor)->where('customer_id','=',Auth::user()->id)->first();
        if($favorit){
            $favorit->favorite=1;
            $isfav=$favorit->save();
        }
        else{
            $newfav=new favoritevendor;
            $newfav->customer_id=Auth::user()->id;
            $newfav->vendor_id=$vendor;
            $newfav->favorite=1;
           $isfav=$newfav->save();

        }
        if($isfav){
            return json_encode('favorite');
        }
    }
    public function unfavorite(Request $request){
        $vendor=$request->get('data');
        $favorit=favoritevendor::where('vendor_id','=',$vendor)->where('customer_id','=',Auth::user()->id)->first();
        if($favorit){
            $favorit->favorite=0;
            $isfav=$favorit->save();
        }
        
        if($isfav){
            return json_encode('unfavorite');
        }
    }
    public function viewquotes($id){
        $cart = HomeController::cart();
        return view('RFQ.viewquotations',compact('id','cart'));
    }

    public function reorder($id) {
        $orders = orders::where('orders.id', $id)
                ->join('ordersdetail', 'ordersdetail.order_id', '=', 'orders.id')
                ->get();

        foreach ($orders as $key) {
            $productid = $key->product_id;
            $products = vendorproduct::where('product_id', $productid)->first();
            $productqty = $key->quantity;
            $newtotal = $products->price;
            $totalamt = $newtotal * $productqty;
            $paymentid = 1;

             $getcart = carts::where('product_id', $productid)->where('user_id', Auth::user()->id)->where('payoptions', $paymentid)->first();
            if ($getcart) {
                $getcartqty = $getcart->quantity;
                $newqty = $getcartqty + $productqty;
                $totalprice = $newqty * $newtotal;
                carts::where('product_id', $productid)->where('user_id', Auth::user()->id)->where('payoptions', $paymentid)->update(array('quantity' => $newqty, 'totalprice' => $totalprice));
            } else {
                $cart = new carts;
                $cart->user_id = Auth::user()->id;
                $cart->product_id = $productid;
                $cart->price = $newtotal;
                $cart->quantity = $productqty;
                $cart->totalprice = $totalamt;
                $cart->payoptions = $paymentid;
                $cart->save();
            }
        }
        return redirect('/mycart');
    }
    public function workplaceSelected(Request $request,$id){
       
        $order=Orders::find($id);
        $order->workplace_id=$request->get('workPlacee');
        $order->save();
        foreach ($order->orderdetails as $orderdetail)  {
            $orderdetail->workplace_id=$request->get('workPlacee');
            $orderdetail->save();
        }
        return back();
    }
    public function updateDeliveryoption(Request $request ,$id){
        $cart=carts::find($id);
        $cart->payondelivery=$request->isondelivery;
        $cart->save();
        return back();
    }
    public function wishlist(){
        $sortIdentity='id';
        $sorting='ASC';
        if(Session::has('sortby')){
        if(Session::get('sortby')=='Newest First'){
            $sortIdentity='id';
            $sorting='ASC';
        }
        else if(Session::get('sortby')=='Price : Lowest First'){
            $sortIdentity='price';
        $sorting='ASC';
        }
        else if(Session::get('sortby')=='Price : Highest First'){
            $sortIdentity='price';
        $sorting='DESC';
        }
        else if(Session::get('sortby')=='Title : A - Z'){
            $sortIdentity='name';
        $sorting='ASC';
        }
        else{
$sortIdentity='name';
        $sorting='DESC';
        }
    }
    $pagination=20;
    if(Session::has('pagination')){
        if(Session::get('pagination')=='9 / page'){
            $pagination=9;
        }
        else if(Session::get('pagination')=='12 / page'){
            $pagination=12;
        }
        else if(Session::get('pagination')=='18 / page'){
            $pagination=18;
        }
        else{
            $pagination=20;
        }
    }
        $user=Auth::user()->id;
        $getproducts=[];
        $getproducts=DB::select("SELECT * from vendorproduct,wishlist WHERE wishlist.product_id=vendorproduct.product_id AND wishlist.user_id=".$user." ORDER BY vendorproduct.".$sortIdentity." ".$sorting." LIMIT ".$pagination."");
       
       // dd($products);
        //$wish=wishlist::where('user_id','=',$user)->orderBy($sortIdentity,$sorting)->paginate($pagination);
        /*foreach ($wish as $key => $value) {
            $getproducts[]=vendorproduct::where('product_id','=',$value->product_id)->first()->toarray();
        }*/
        $cart = HomeController::cart();
        return view('wishlist.wishlist',compact('getproducts','cart'));
    }
    public function workplace(){
        $workplaces=workplace::where('user_id','=',Auth::user()->id)->get();
        $cart=HomeController::cart();
        return view('customers.workplace',compact('cart','workplaces'));
    }
    public function lowstock(){
        $lowstock=vendorproduct::where('stock_count','<',50)->get();
        return view('admin.lowstock',compact('lowstock'));
    }
}































