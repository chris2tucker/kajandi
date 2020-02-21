@extends('layouts.pagelayout')
@section('content')

	<div class="gap"></div>
        <div class="container" style="width: 90%">
            <div class="" style="    text-align: center;
    margin-bottom: 40px;"><img src="{{url('img/logo-2.png')}}" alt="" style="    height: 100px;"></div>
            <div class="payment-success-title-area">
                <div class="row">
                    <h4 class=" col-sm-6" style="text-align: center;color: #1c6e93;">Kajandi payment slip</h4>
                    <h4 class="col-sm-6">Order ID-{{$ordernumber}}</h4>
                </div>
                
                <!--<p class="lead">Order details has been send to <strong>{{$email}}</strong>
                </p>-->
            </div>
            <div class="gap gap-small"></div>
            <div class="row row-col-gap">
                <div class="col-md-12">
                   <h3 class="widget-title">Order Information</h3>
                    <p>To complete Transaction for Order ({{$ordernumber}}), transfer or pay the payable amount ({!! $orderSummary['payable']['amount_str'] !!}) in to Kajandi bank account.</p>
                    <p> Make sure you write Order number in Transfer information for Transfers or write ‘name’ _ ({{$ordernumber}}) if paying directly to bank. </p>
                    <p style="padding-left: 50px;">This payment slip contains information for the bank payment option selected </p>
                    <div class="box">
                        <table class="table">
                            <thead>
                                <tr style="background: #4fc714;">
                                    <th>DESCRIPTION </th>
                                    <th>INFORMATION</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Order ID</td>
                                    <td>{{$ordernumber}}</td>
                                </tr>
                                <tr>
                                    <td>Account Name</td>
                                    <td>{{$bank->account_name}}</td>
                                </tr>
                                <tr>
                                    <td>Account Number</td>
                                    <td>{{$bank->account_number}}</td>
                                </tr>
                                <tr>
                                    <td>Account type</td>
                                    @if($bank->account_type==0)
                                    <td>Current Account</td>
                                    @else
                                    <td>Saving Account</td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>Sort Code</td>
                                    <td>{{$bank->sort_code}}</td>
                                </tr>
                                @foreach($orderSummary as $item)
                                    <tr>
                                        <td>{!! $item['label'] !!}</td>
                                        <td>{!! $item['amount_str'] !!}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
            <h6>Payable Amount={!! $orderSummary['payable']['amount_str'] !!}</h6>
            <h6>Payment Status={{$paymentstatys->payment}}</h6>
            <div class="gap gap-small"></div>
            <h6>INSTRUCTIONS</h6>
            <h4>FOR TRANSFER:</h4>
            <p>Transfer the total amount to the account provided and write the Payment ID in your payment information</p>
            <h4>FOR DIRECT BANK PAYMENTS:</h4>
            <p>Write your name with payment ID in this format (name – 14404422442) in payment slip and pay total amount to provided account number</p>
            <h4>FOR CHEQUES:</h4>
            <p>Pay the Total amount to Kajandi Limited and submit to any of our offices. You can also call us for pick up. Depending on location of your office, logistics charges may occur</p>
            
             <p>Kindly follow instructions in using any of the payment methods. 

Thank you
</p>
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