@extends('layouts.pagelayout')
@section('content')

<div class="mfp-with-anim mfp-hide mfp-dialog clearfix" id="review-dialog">
    <h3 class="widget-title">Wallet Payment</h3>
    <hr />
        <?php

        if (!empty($getwallet->balance)) {
            
            if($sub<$getwallet->balance){
            $allow=true;
        }else{
            $allow=false;
        }

            $walletamt = App\Http\Controllers\HomeController::converter($getwallet->balance); 
        }else{
            $walletamt = '';
            $allow=false;
        }

        ?>
        <p>Wallet Balance: {{$walletamt}}</p>
        <p>Total Amount: {{$totalamt}}</p>
        @if($allow==true)
        <div class="form-group">
            <input class="form-control password" type="password" placeholder="Wallet Password" />
            
        </div>
        <input class="btn btn-primary paywithwallet" type="submit" value="Send" />
        <br>
        <p class="alert alert-danger alert-dismissable fade in failuretext" style="display: none; padding: 3px; margin-top: 10px">
            Incorrect wallet password
        </p>
        @else
        <h2>Your balance is low.Please recharge!</h2>
        @endif
    
    <div class="gap gap-small"></div>
</div>

	<div class="container">
            <header class="page-header">
                <h3 class="page-title" style="font-size: 40px">Payment for #{{$ordernumber}} Order</h3>
                <h4 style="color: red;">Kindly pay any delivery fee attached to your order</h4>
                <input type="hidden" name="code" id="code" value="{{$ordernumber}}">
            </header>
            <div class="row row-col-gap" data-gutter="60">
                
                <div class="col-md-6">
                    <br>
                    <h3 class="widget-title">Order Info</h3>
                    <div class="box">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>QTY</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php echo $view ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-md-6">
                    <div>
                        <br>
                        <h3 class="widget-title">Payment Gateway</h3>
                        @if($shipping==0)
                        <button class="btn btn-primary paymentcashless" style="margin-bottom: 10px;">Checkout</button>
                        @endif
                        @if($sub==0)
                       <!-- <button class="btn btn-primary paymentcashless" style="margin-bottom: 10px;">Checkout</button>-->
                        @endif
                        @if($payoption)
                        <form action="{{url('/pay/')}}" method="Post" accept-charset="utf-8" style="margin-bottom: 10px;">
                           {{csrf_field()}}
                            <input type="hidden" name="ordernumber" id="code" value="{{$ordernumber}}">
                            <button class="btn btn-primary" >Pay with Card</button>
                        </form>
                        
                        <?php
                        if (!empty($getwallet)) {
                           ?>
                           <button class="btn btn-primary icon_color popup-text" href='#review-dialog' style="margin-bottom: 10px;">Pay with your Wallet</button>
                           <?php
                        }
                        ?>
                        <form action="{{url('/pay/bank/checkout')}}" method="Post" accept-charset="utf-8" style="margin-bottom: 10px;">
                           {{csrf_field()}}
                            <input type="hidden" name="ordernumber" id="code" value="{{$ordernumber}}">
                             <button class="btn btn-primary">Pay to the Bank</button>
                        </form>
                       
                        @else
                       <!-- <button class="btn btn-primary paymentcashless" style="margin-bottom: 10px;">Checkout</button>-->
                          <form action="{{url('/pay/')}}" method="Post" accept-charset="utf-8">
                           {{csrf_field()}}
                            <input type="hidden" name="ordernumber" id="code" value="{{$ordernumber}}">
                            <button class="btn btn-primary" style="margin-bottom: 10px;">Pay with Card</button>
                        </form>
                        <?php
                        if (!empty($getwallet)) {
                           ?>
                           <button class="btn btn-primary icon_color popup-text" href='#review-dialog' style="margin-bottom: 10px;">Pay with your Wallet</button>
                           <?php
                        }
                        ?>
                         <form action="{{url('/pay/bank/checkout')}}" method="Post" accept-charset="utf-8" style="margin-bottom: 10px;">
                           {{csrf_field()}}
                            <input type="hidden" name="ordernumber" id="code" value="{{$ordernumber}}">
                             <button class="btn btn-primary">Pay to the Bank</button>
                        </form>
                        @endif
                        
                    </div>
                </div>
            </div>
        </div>

@endsection