@extends('layouts.pagelayout')
@section('content')

	<div class="gap"></div>
        <div class="container" style="width: 90%">
            <div class="" style="    text-align: center;
    margin-bottom: 40px;"><img src="{{url('img/logo-2.png')}}" alt="" style="    height: 100px;"></div>
            <div class="payment-success-title-area">
                <div class="row">
                    <h4 class=" col-sm-6" >
                        <div style="background-color: #1c6e93;text-align: center;color: white;">
                            BILL TO
                        </div>
                        <ul style="list-style: none">
                            <li>{{App\Customer::where('user_id','=',$orders->user_id)->first()->name}}</li>
                            <li>{{App\Customer::where('user_id','=',$orders->user_id)->first()->address}}</li>
                            <li>
                            {{App\Customer::where('user_id','=',$orders->user_id)->first()->country}}</li>
                            <li>
                            {{App\Customer::where('user_id','=',$orders->user_id)->first()->contactperson}}</li>
                                 </li>
                            {{App\User::find($orders->user_id)->email}}</li>
                        </ul>
                    </h4>
                    <h4 class="col-sm-3">
                        <div style="background-color: #1c6e93;text-align: center;color: white;">
                        Customer ID
                        </div>
                        <ul style="list-style: none;">
                            <li>{{$orders->user_id}}</li>
                        </ul>

                    </h4>
                     <h4 class="col-sm-3">
                        <div style="background-color: #1c6e93;text-align: center;color: white;">
                        Terms
                        </div>
                         <ul style="list-style: none;">
                            <li>Due upon Receipt </li>
                        </ul>
                    </h4>
                </div>
                
            
            </div>
            <div class="gap gap-small"></div>
            <div class="row row-col-gap">
                <div class="col-md-12">
                   <h3 class="widget-title">Order Information</h3>
                   
                    <div class="box">
                        <table class="table">
                            <thead>
                                <tr style="background: #4fc714;">
                                    <th>DESCRIPTION </th>
                                    <th>QTV</th>
                                    <th>Unit Price</th>
                                    <th>Amount</th>
                                    <th>Payment Type</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ordersdetail as $order)
                                <tr><td>{{App\products::find($order->product_id)->name}}</td>
                                    <td>{{$order->quantity}}</td>
                                    <td>{{App\Http\Controllers\HomeController::converter($order->price)}}</td>
                                    <td>{{App\Http\Controllers\HomeController::converter($order->totalprice)}}</td>
                                    <td> @if($order->payoptions==1)
                Instant Payment
            
             @elseif($order->payoptions==2)
                15 Days Payment
            
            @else
                30 Days Payment
                @endif
            </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
            <h6>Shipping fee={{App\Http\Controllers\HomeController::converter($orders->shipping_fee)}}</h6>
            <h6>Total Amount={{App\Http\Controllers\HomeController::converter($total)}}</h6>
            @if($orders->payment==NULL || $orders->payment=='pending')
            <h6>payment status=Pending</h6>
            @else
            <h6>payment status=Paid</h6>
            @endif
             
            <div class="gap gap-small"></div>
            <h6>Thank your for shopping!</h6>
<h3><a href="{{url('page/contact')}}" title="">Contact us for more information</a></h3>

        </div>
        <button onclick="myFunction()" class="btn btn-primary" style="float: right;margin-right: 100px;
">Print this page</button>

<script>
function myFunction() {
  window.print();
}
</script>
        <div class="gap"></div>
       
@endsection