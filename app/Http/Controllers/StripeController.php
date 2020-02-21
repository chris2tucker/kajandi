<?php 
namespace App\Http\Controllers;
use App\Http\Requests;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Validator;
use URL;
use Session;
use Redirect;
use Input;
use App\User;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Stripe\Error\Card;
use Cart;

use App\Http\Controllers\Controller;
//use Paystack;
use Yabacon\Paystack;
use App\Payment;
use Auth;
use App\wallet;
use App\wallethistory;
use App\orderpayment;
use App\carts;
use App\ordersdetail;
use App\orders;
use App\outstandingpayment;
use carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\invoicemail;
use App\Notification;
use App\bankdetail;
use App\vendorproduct;
class StripeController extends HomeController
{
    
    public function __construct()
    {
       
        $this->user = new User;
    }
    
    /**
     * Show the application paywith stripe.
     *
     * @return \Illuminate\Http\Response
     */
    public function payWithStripe()
    {
        $cart = HomeController::cart();
       
    
        return view('cart.paywithstripe',compact('cart'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postPaymentWithStripe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'card_no' => 'required',
            'ccExpiryMonth' => 'required',
            'ccExpiryYear' => 'required',
            'cvvNumber' => 'required',
            'amount' => 'required',
        ]);
        
        $input = $request->all();
        if ($validator->passes()) {           
            $input = array_except($input,array('_token'));            
            $stripe = Stripe::make('sk_test_G5MhxcpWa2xdmf13ocVS1GYg008SmINAdv');
            try {
                $token = $stripe->tokens()->create([
                    'card' => [
                        'number'    => $request->get('card_no'),
                        'exp_month' => $request->get('ccExpiryMonth'),
                        'exp_year'  => $request->get('ccExpiryYear'),
                        'cvc'       => $request->get('cvvNumber'),
                    ],
                ]);
                if (!isset($token['id'])) {
                    \Session::put('error','The Stripe Token was not generated correctly');
                    return redirect()->route('stripform');
                }
                $charge = $stripe->charges()->create([
                    'card' => $token['id'],
                    'currency' => 'USD',
                    'amount'   => $request->get('amount'),
                    'description' => 'Add in wallet',
                ]);
                if($charge['status'] == 'succeeded') {
                    /**
                    * Write Here Your Database insert logic.
                    */
                    \Session::put('success','Money add successfully in wallet');
                    return redirect()->route('stripform');
                } else {
                    \Session::put('error','Money not add in wallet!!');
                    return redirect()->route('stripform');
                }
            } catch (Exception $e) {
                \Session::put('error',$e->getMessage());
                return redirect()->route('stripform');
            } catch(\Cartalyst\Stripe\Exception\CardErrorException $e) {
                \Session::put('error',$e->getMessage());
                return redirect()->route('stripform');
            } catch(\Cartalyst\Stripe\Exception\MissingParameterException $e) {
                \Session::put('error',$e->getMessage());
                return redirect()->route('stripform');
            }
        }
        \Session::put('error','All fields are required!!');
        return redirect()->route('stripform');
    }
     /**
     * Redirect the User to Paystack Payment Page
     * @return Url
     */
    public function redirectToGateway(Request $request,$option='checkout')
    {
        if($option=='wallet'){
            Session::put('typeofpayment','wallet');
    
         $paystack = new Paystack(config('paystack.secretKey'));
         
    try
    {
      $tranx = $paystack->transaction->initialize([
        'amount'=>$request->amount*100,       // in kobo
        'email'=>Auth::user()->email,         // unique to customers
        'reference'=>time().Auth::user()->id, // unique to transactions
      ]);
    } catch(\Yabacon\Paystack\Exception\ApiException $e){
      print_r($e->getResponseObject());
      die($e->getMessage());
    }
}
else if($option=='dueandoutstanding'){
     Session::put('typeofpayment','dueandoutstanding');
      $paystack = new Paystack(config('paystack.secretKey'));
         
    try
    {
      $tranx = $paystack->transaction->initialize([
        'amount'=>$request->amount*100,       // in kobo
        'email'=>Auth::user()->email,         // unique to customers
        'reference'=>$request->ordernumber,
         // unique to transactions
      ]);
    } catch(\Yabacon\Paystack\Exception\ApiException $e){
      print_r($e->getResponseObject());
      die($e->getMessage());
    }

}
else if($option=='outstandingamount'){
    Session::put('typeofpayment','outstandingamount');
      $paystack = new Paystack(config('paystack.secretKey'));
         
    try
    {
      $tranx = $paystack->transaction->initialize([
        'amount'=>$request->amount*100,       // in kobo
        'email'=>Auth::user()->email,         // unique to customers
        'reference'=>time().Auth::user()->id, // unique to transactions
      ]);
    } catch(\Yabacon\Paystack\Exception\ApiException $e){
      print_r($e->getResponseObject());
      die($e->getMessage());
    }
}
else if($option=='dueamount'){
    Session::put('typeofpayment','dueamount');
      $paystack = new Paystack(config('paystack.secretKey'));
         
    try
    {
      $tranx = $paystack->transaction->initialize([
        'amount'=>$request->amount*100,       // in kobo
        'email'=>Auth::user()->email,         // unique to customers
        'reference'=>time().Auth::user()->id, // unique to transactions
      ]);
    } catch(\Yabacon\Paystack\Exception\ApiException $e){
      print_r($e->getResponseObject());
      die($e->getMessage());
    }
}
else if($option=='totalamount'){
     Session::put('typeofpayment','totalamount');
      $paystack = new Paystack(config('paystack.secretKey'));
         
    try
    {
      $tranx = $paystack->transaction->initialize([
        'amount'=>$request->amount*100,       // in kobo
        'email'=>Auth::user()->email,         // unique to customers
        'reference'=>time().Auth::user()->id, // unique to transactions
      ]);
    } catch(\Yabacon\Paystack\Exception\ApiException $e){
      print_r($e->getResponseObject());
      die($e->getMessage());
    }
}
else if($option=='checkout'){
      $code = $request->get('ordernumber');
            $getordersdetails = '';
            $cart = carts::where('user_id', Auth::user()->id)->delete();
            $shipping=orders::where('user_id', Auth::user()->id)->where('ordernumber', $code)->first();
           /* $orders = orders::where('user_id', Auth::user()->id)->where('ordernumber', $code)->update(array('payment' => 'yes')); */

            $orderpayment = new orderpayment;
            $orderpayment->user_id = Auth::user()->id;
            $orderpayment->ordernumber = $code;
            $orderpayment->save();



            $orderpayment_id = $orderpayment->id;

            $ordernumber = time().''.$code.$orderpayment_id;
            $updatepayment = orderpayment::where('id', $orderpayment_id)->update(array('payordernumber' => $ordernumber, 'payment_type' => 'card'));
            //get total amount here
            $totals=ordersdetail::where('ordernumber',$code)->where('payondelivery','=',NULL)->where('payoptions','=',1)->sum('totalprice');
                $totals=$totals+$shipping->shipping_fee;
           
            Session::put('typeofpayment','checkout');
      $paystack = new Paystack(config('paystack.secretKey'));
         
    try
    {
      $tranx = $paystack->transaction->initialize([
        'amount'=>$totals*100,       // in kobo
        'email'=>Auth::user()->email,         // unique to customers
        'reference'=>$request->ordernumber,
        'metadata'=>$request->ordernumber, // unique to transactions
        
      ]);
    } catch(\Yabacon\Paystack\Exception\ApiException $e){
      print_r($e->getResponseObject());
      die($e->getMessage());
    }
}

    // store transaction reference so we can query in case user never comes back
    // perhaps due to network issue
  // Paystack::save_last_transaction_reference($tranx->data->reference);

    // redirect to page so User can pay
    return Redirect::to($tranx->data->authorization_url);
    //header('Location: ' . $tranx->data->authorization_url);
       // return Paystack::getAuthorizationUrl()->redirectNow();
    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback()
    {
       $reference = isset($_GET['reference']) ? $_GET['reference'] : '';
    if(!$reference){
      die('No reference supplied');
    }
    // initiate the Library's Paystack Object
    $paystack = new Paystack(config('paystack.secretKey'));
    try
    {
      // verify using the library
      $tranx = $paystack->transaction->verify([
        'reference'=>$reference, // unique to transactions
      ]);
    } catch(\Yabacon\Paystack\Exception\ApiException $e){
      print_r($e->getResponseObject());
      die($e->getMessage());
    }
    if ('success' === $tranx->data->status) {

      // transaction was successful...
      // please check other things like whether you already gave value for this ref
      // if the email matches the customer who owns the product etc
      // Give value
        $sessionvalue=Session::get('typeofpayment');
        if($sessionvalue=='wallet'){
            $getwallet = wallet::where('user_id', Auth::user()->id)->first();
            if ($getwallet) {
                $amount = ($tranx->data->amount/100) + ($getwallet->balance);
                $wallet = wallet::where('user_id', Auth::user()->id)->update(array('balance' => $amount));

                $wallethistory = new wallethistory;
            $wallethistory->transactionid = $reference;
            $wallethistory->user_id = Auth::user()->id;
            $wallethistory->payment = ($tranx->data->amount/100);
            $wallethistory->balance = $amount;
            $wallethistory->transactiontype = 1;
            $wallethistory->date = date('Y/m/d');
            $wallethistory->save();

            }else{
                $amount = $tranx->data->amount;

                $wallet = new wallet;
            $wallet->user_id = Auth::user()->id;
            $wallet->balance = $amount;
            $wallet->date = date('Y/m/d');
            $wallet->save();

            $wallethistory = new wallethistory;
            $wallethistory->transactionid = time();
            $wallethistory->user_id = Auth::user()->id;
            $wallethistory->payment = ($tranx->data->amount/100);
            $wallethistory->balance = $amount;
            $wallethistory->transactiontype = 1;
            $wallethistory->date = date('Y/m/d');
            $wallethistory->save();

            }
            Session::forget('typeofpayment');
            return redirect('/customers/wallet');
            
        }
        else if($sessionvalue=='dueandoutstanding'){

            $id = $reference;
            $outstandingpayment = outstandingpayment::where('ordernumber', $id)->update(array('payment' => 'yes'));
            $outstandingpayment1 = outstandingpayment::where('ordernumber', $id)->first();
              $ordersdetail=ordersdetail::where('ordernumber','=',$outstandingamount1->ordernumber)->where('product_id','=',$outstandingpayment1->product_id)->first();
            $orderpayment = new orderpayment;
            $orderpayment->user_id = Auth::user()->id;
            $orderpayment->ordernumber = $outstandingpayment1->ordernumber;
            $orderpayment->ordersdetail_id=$ordersdetail->id;
            $orderpayment->save();
            $orderpayment_id = $orderpayment->id;

            $ordernumber = time().''.$outstandingpayment1->ordernumber.$orderpayment_id;
            $updatepayment = orderpayment::where('id', $orderpayment_id)->update(array('payordernumber' => $ordernumber, 'payment_type' => 'card'));
            Session::forget('typeofpayment');
            return redirect('/customers/dueandoutstanding');
        }
        else if($sessionvalue=='outstandingamount'){
           
            $outstandingpayment = outstandingpayment::where('user_id', Auth::user()->id)->where('duedate','>=',Carbon::today()->toDateString())->update(array('payment' => 'yes'));
            
            $outstandingpayment1 = outstandingpayment::where('user_id', Auth::user()->id)->where('duedate','>=',Carbon::today()->toDateString())->get();
            foreach($outstandingpayment1 as $outstand){
                $ordersdetail=ordersdetail::where('ordernumber','=',$outstand->ordernumber)->where('product_id','=',$outstand->product_id)->first();
                 $orderpayment = new orderpayment;
            $orderpayment->user_id = Auth::user()->id;
            $orderpayment->ordernumber = $outstand->ordernumber;
            $orderpayment->ordersdetail_id=$ordersdetail->id;
            $orderpayment->save();
            $orderpayment_id = $orderpayment->id;
                   $notification = new Notification();
            $notification->user_id = 40;
            $notification->notification = Auth::User()->name." provide his outstanding payment";
            $notification->save();
            $ordernumber = time().''.$outstand->ordernumber.$orderpayment_id;
            $updatepayment = orderpayment::where('id', $orderpayment_id)->update(array('payordernumber' => $ordernumber, 'payment_type' => 'card'));
            }
           
            Session::forget('typeofpayment');
            return redirect('/customers/dueandoutstanding');
        }
        elseif($sessionvalue=='dueamount'){
             $outstandingpayment = outstandingpayment::where('user_id', Auth::user()->id)->where('duedate','>',Carbon::today()->toDateString())->update(array('payment' => 'yes'));
            $outstandingpayment1 = outstandingpayment::where('user_id', Auth::user()->id)->where('duedate','>',Carbon::today()->toDateString())->get();
            foreach($outstandingpayment1 as $outstand){
              $ordersdetail=ordersdetail::where('ordernumber','=',$outstand->ordernumber)->where('product_id','=',$outstand->product_id)->first();
                 $orderpayment = new orderpayment;
            $orderpayment->user_id = Auth::user()->id;
            $orderpayment->ordernumber = $outstand->ordernumber;
            $orderpayment->ordersdetail_id=$ordersdetail->id;
            $orderpayment->save();
            $orderpayment_id = $orderpayment->id;
                   $notification = new Notification();
            $notification->user_id = 40;
            $notification->notification = Auth::User()->name." provide his due payment";
            $notification->save();
            $ordernumber = time().''.$outstand->ordernumber.$orderpayment_id;
            $updatepayment = orderpayment::where('id', $orderpayment_id)->update(array('payordernumber' => $ordernumber, 'payment_type' => 'card'));
            }
           
            Session::forget('typeofpayment');
            return redirect('/customers/dueandoutstanding');
        }
        else if($sessionvalue=='totalamount'){
            $outstandingpayment = outstandingpayment::where('user_id', Auth::user()->id)->update(array('payment' => 'yes'));
            $outstandingpayment1 = outstandingpayment::where('user_id', Auth::user()->id)->get();
            foreach($outstandingpayment1 as $outstand){
                 $orderpayment = new orderpayment;
            $orderpayment->user_id = Auth::user()->id;
            $orderpayment->ordernumber = $outstand->ordernumber;
            $orderpayment->save();
            $orderpayment_id = $orderpayment->id;
                   $notification = new Notification();
            $notification->user_id = 40;
            $notification->notification = Auth::User()->name." provide his total due and outstanding payment";
            $notification->save();
            $ordernumber = time().''.$outstand->ordernumber.$orderpayment_id;
            $updatepayment = orderpayment::where('id', $orderpayment_id)->update(array('payordernumber' => $ordernumber, 'payment_type' => 'card'));
            }
           
            Session::forget('typeofpayment');
            return redirect('/customers/dueandoutstanding');
        }
       else if($sessionvalue=='checkout') {
        if($payment=Payment::where('transaction_id',$reference)->first()){
                   $payment_id=$payment->transaction_id;
               }else{
                   $payment=new Payment;
                  
                   $payment->transaction_id=$reference;
                   $payment->currency_code=$tranx->data->currency;
                   $payment->payment_status=$tranx->data->status;
                   $payment->save();
                   $payment_id=$payment->transaction_id;
               }
               //outstanding payments
                $getordersdetails = ordersdetail::where('ordernumber', $tranx->data->metadata)->where('payoptions', '!=', 1)->first();
            if ($getordersdetails) {
                $getordersdetail = ordersdetail::where('ordernumber', $tranx->data->metadata)->where('payoptions', '!=', 1)->get();

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
               $orders = orders::where('user_id', Auth::user()->id)->where('ordernumber', $tranx->data->metadata)->update(array('payment' => 'yes'));
             $orders=orders::where('ordernumber','=',$tranx->data->metadata)->first();
             $ordersdetail=ordersdetail::where('ordernumber','=',$orders->ordernumber)->get();
             foreach ($ordersdetail as $ordr) {
              if($ordr->payondelivery=='pay on delivery'){
                $orders->payment='pending';
                $orders->save();
              }
               $products=vendorproduct::where('product_id','=',$ordr->product_id)->first();
               $products->stock_count=$products->stock_count-$ordr->quantity;
               $products->sold_qunantity=$products->sold_qunantity+$ordr->quantity;
               $products->save();
             }
             $vendors=User::find($orders->vendor_id);
                    $notification = new Notification();
            $notification->user_id = 40;
            $notification->notification = Auth::User()->name." provide his payment";
            $notification->save();
             
               Mail::to(Auth::user()->email)->send(new invoicemail($tranx->data->metadata));
               Mail::to($vendors->email)->send(new invoicemail($tranx->data->metadata));
                 return redirect('recept/'.$tranx->data->metadata)->with('message','Payment has been done and your payment id is : '.$payment_id);
             }
       return redirect('customers/dashboard');
           
    }
    else{
               return 'Payment has failed';
           }
    }    
    public function paywallet(Request $request){
      $getwallet = wallet::where('user_id', Auth::user()->id)->first();
        $wallethistory = new wallethistory;
            $wallethistory->transactionid = time().Auth::user()->id;
            $wallethistory->user_id = Auth::user()->id;
            $wallethistory->payment = $request->amount;
            $wallethistory->balance=$getwallet->balance;
            $wallethistory->transactiontype = 3;
            $wallethistory->date = date('Y/m/d');
            $wallethistory->save();
            $bank=bankdetail::find(1);
            $cart=HomeController::cart();
            return view('cart.wallet_bank_paymet',compact('bank','wallethistory','cart'));
            
    }
    public function pending(){
      $getpending=wallethistory::where('transactiontype','=',3)->get();

      return view('admin.wallet.index',compact('getpending'));
    }
    public function approved(){
     $getpending=wallethistory::where('approved_date','!=',NULL)->get();

      return view('admin.wallet.approved',compact('getpending'));
    }
    public function approve_wallet($id,$user_id){
      $getwallet = wallet::where('user_id', $user_id)->first();
      $history=wallethistory::find($id);
      $history->balance=$history->payment+$getwallet->balance;
      $getwallet->balance=$history->payment+$getwallet->balance;
      $history->transactiontype = 1;
      $history->approved_date=Carbon::now()->toDateString();
      $history->save();
      $getwallet->save();
      return back();

    }
    public function paybank(Request $request){

      $code = $request->get('ordernumber');
            $getordersdetails = '';
            $cart = carts::where('user_id', Auth::user()->id)->delete();
            $shipping=orders::where('user_id', Auth::user()->id)->where('ordernumber', $code)->first();
            $orders = orders::where('user_id', Auth::user()->id)->where('ordernumber', $code)->update(array('payment' => 'pending'));

            $orderpayment = new orderpayment;
            $orderpayment->user_id = Auth::user()->id;
            $orderpayment->ordernumber = $code;
            $orderpayment->save();



            $orderpayment_id = $orderpayment->id;

            $ordernumber = time().''.$code.$orderpayment_id;
            $updatepayment = orderpayment::where('id', $orderpayment_id)->update(array('payordernumber' => $ordernumber, 'payment_type' => 'bank'));
            //get total amount here
            $totals=ordersdetail::where('ordernumber',$code)->where('payondelivery','=',NULL)->where('payoptions','=',1)->sum('totalprice');
                $totals=$totals+$shipping->shipping_fee;
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
             $bankdetail=bankdetail::find(1);
       /*  return redirect('customers/dashboard')->with('message','Pay the Exact amount you entered into your online deposit into Kajandi bank Account '.$bankdetail->account_number.' Make sure you include your payment ID('.$request->ordernumber.') in your Payment information. You can contact us for More information'); */
        $ordersdetail=ordersdetail::where('ordernumber',$code)->where('payondelivery','=',NULL)->where('payoptions','=',1)->get();
        foreach ($ordersdetail as $single_order) {
            $vendorproduct=vendorproduct::where('product_id','=',$single_order->product_id)->first();
                $vendorproduct->stock_count=$vendorproduct->stock_count-$single_order->quantity;
                $vendorproduct->sold_qunantity=$vendorproduct->sold_qunantity+$single_order->quantity;
                $vendorproduct->save();
        }
       return redirect('bank/order/'.$request->ordernumber);
    }
    public function bankOrderSummary($ordernumber, OrderService $orderService){
      $name=Auth::user()->name;
      $email=Auth::user()->email;
      $bank=bankdetail::find(1);
      $cart=HomeController::cart();
      $order=orders::where('ordernumber','=',$ordernumber)->sum('shipping_fee');
      $paymentstatys=orders::where('ordernumber','=',$ordernumber)->first();
      $amount=ordersdetail::where('ordernumber','=',$ordernumber)->where('payoptions', '!=', 2)->sum('totalprice');
      $amount=$amount+$order;
      $orderSummary = $orderService->orderSummary(orders::where('ordernumber','=',$ordernumber)->first());
      return view('cart.bank_payment_summary',compact('name','email','bank','cart','ordernumber','amount','paymentstatys', 'orderSummary'));
    }
    public function ordersrecept($ordernumber){
      $cart=HomeController::cart();
      $orders=Orders::where('ordernumber','=',$ordernumber)->first();
      $ordersdetail=ordersdetail::where('ordernumber','=',$ordernumber)->get();
      $total=ordersdetail::where('ordernumber','=',$ordernumber)->sum('totalprice');
  return view('cart.recept',compact('cart','orders','ordersdetail','total'));

    }
    public function outstandingBankPayment($id,$paymenttype='outstandingpayment'){
      $unique=uniqid();
      $nopayment = false;
        $ordernumber=$unique;
        $bank=bankdetail::find(1);
        $cart=HomeController::cart();
      if($id=='all'){
        if($paymenttype=='outstandingpayment'){
 $outstanding=outstandingpayment::where('user_id','=',Auth::user()->id)->where('duedate','>',Carbon::today())->where('payment','=','pending')->get();
 $outstandingamount=outstandingpayment::where('user_id','=',Auth::user()->id)->where('duedate','>',Carbon::today())->where('payment','=','pending')->sum('totalprice');
 if($outstandingamount == 0) {
     $lastOutstandingPayments = outstandingpayment::where('user_id','=',Auth::user()->id)->where('duedate','>',Carbon::today())->where('payment','=','bank pending')->get();
     if ($lastOutstandingPayments->count()) {
         $ordernumber = $lastOutstandingPayments->first()->paymentID;
         $amount =  $lastOutstandingPayments->sum('totalprice');
         return view('cart.outstanding_summary',compact('ordernumber','amount','bank','cart', 'nopayment'));
     } else {
         $nopayment = true;
         return view('cart.outstanding_summary',compact('nopayment', 'bank','cart'));
     }
 }

 foreach ($outstanding as $key => $outstand) {
   $outstand->payment='bank pending';
        $outstand->paymentID=$unique;
        $outstand->save();
 }
  foreach($outstanding as $outstand){
              $ordersdetail=ordersdetail::where('ordernumber','=',$outstand->ordernumber)->where('product_id','=',$outstand->product_id)->first();
                 $orderpayment = new orderpayment;
            $orderpayment->user_id = Auth::user()->id;
            $orderpayment->ordernumber = $outstand->ordernumber;
            $orderpayment->ordersdetail_id=$ordersdetail->id;
            $orderpayment->save();
            $orderpayment_id = $orderpayment->id;
                   
            $ordernumber = time().''.$outstand->ordernumber.$orderpayment_id;
            $updatepayment = orderpayment::where('id', $orderpayment_id)->update(array('payordernumber' => $ordernumber, 'payment_type' => 'Bank'));
            }
                 $amount=$outstandingamount;  
        }
        else{
            $lastOutstandingPayments = outstandingpayment::where('user_id','=',Auth::user()->id)->where('duedate','<',Carbon::today())->where('payment','=','bank pending')->get();
            if ($lastOutstandingPayments->count()) {
                $ordernumber = $lastOutstandingPayments->first()->paymentID;
                $amount =  $lastOutstandingPayments->sum('totalprice');
                return view('cart.outstanding_summary',compact('ordernumber','amount','bank','cart', 'nopayment'));
            } else {
                $nopayment = true;
                return view('cart.outstanding_summary',compact('nopayment', 'bank','cart'));
            }
           $due=outstandingpayment::where('user_id','=',Auth::user()->id)->where('duedate','<',Carbon::today())->get();
           $dueamount=$due->sum('totalprice');
           foreach ($due as $key => $outstand) {
             $outstand->payment='bank pending';
        $outstand->paymentID=$unique;
        $outstand->save();
           }
  foreach($due as $outstand){
              $ordersdetail=ordersdetail::where('ordernumber','=',$outstand->ordernumber)->where('product_id','=',$outstand->product_id)->first();
                 $orderpayment = new orderpayment;
            $orderpayment->user_id = Auth::user()->id;
            $orderpayment->ordernumber = $outstand->ordernumber;
            $orderpayment->ordersdetail_id=$ordersdetail->id;
            $orderpayment->save();
            $orderpayment_id = $orderpayment->id;
                   
            $ordernumber = time().''.$outstand->ordernumber.$orderpayment_id;
            $updatepayment = orderpayment::where('id', $orderpayment_id)->update(array('payordernumber' => $ordernumber, 'payment_type' => 'Bank'));
            }
              $amount=$dueamount; 
        }
      }
      else{
        $outstandingpayment=outstandingpayment::find($id);
        $outstandingpayment->payment='bank pending';
        $outstandingpayment->paymentID=$unique;
        $outstandingpayment->save();
       $amount=$outstandingpayment->totalprice;
       $ordersdetail=ordersdetail::where('ordernumber','=',$outstandingpayment->ordernumber)->where('product_id','=',$outstandingpayment->product_id)->first();
                 $orderpayment = new orderpayment;
            $orderpayment->user_id = Auth::user()->id;
            $orderpayment->ordernumber = $outstandingpayment->ordernumber;
            $orderpayment->ordersdetail_id=$ordersdetail->id;
            $orderpayment->save();
            $orderpayment_id = $orderpayment->id;
                   
            $ordernumber = time().''.$outstandingpayment->ordernumber.$orderpayment_id;
            $updatepayment = orderpayment::where('id', $orderpayment_id)->update(array('payordernumber' => $ordernumber, 'payment_type' => 'Bank'));

      }
        $ordernumber=$unique;
        return view('cart.outstanding_summary',compact('ordernumber','amount','bank','cart', 'nopayment'));
    }
    public function dueandoutstandingpayment(){
      $outstandingpayment=outstandingpayment::where('payment','=','bank pending')->get();
      return view('admin.outstandingpayment',compact('outstandingpayment'));
    }
    public function markasapproved($id){
      $outstandingpayment=outstandingpayment::find($id);
      $outstandingpayment->payment='yes';
      $outstandingpayment->save();

                 $orderpayment = new orderpayment;
            $orderpayment->user_id = $outstandingpayment->user_id;
            $orderpayment->ordernumber = $outstandingpayment->ordernumber;
            $orderpayment->save();
            $orderpayment_id = $orderpayment->id;
                
            $ordernumber = time().''.$orderpayment->ordernumber.$orderpayment_id;
            $updatepayment = orderpayment::where('id', $orderpayment_id)->update(array('payordernumber' => $ordernumber, 'payment_type' => 'bank'));
            return back();
            
    }
}