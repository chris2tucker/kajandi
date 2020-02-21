@extends('layouts.pagelayout')
@section('content')

<style type="text/css">
	.row {
  display: flex; /* equal height of the children */
  width: 100%;
}
@media (max-width: 768px) {
  .col-xs-12 {
  	float: left;
    width: 100%;
  }
  .row {
  display: table-row; /* equal height of the children */
}
}


</style>

<link rel="stylesheet" type="text/css" href="{{URL::asset('/css/datatables.min.css') }}"/>
<script src="{{URL::asset('/js/canvasjs.min.js') }}"></script>

<div class="mfp-with-anim mfp-hide mfp-dialog4 clearfix" id="paymentdue" style="width: 100%">
    <h3 class="widget-title">Payment</h3>
    <p>Select your payment method</p>
    <hr />
    <input type="hidden" name="dueid" class="dueid">
    <button class='btn btn-primary paywithcard'>Pay with card</button>
    
    <button class='btn btn-primary'>Generate Payment Slip</button>
    <div class="duedata">
    	
    </div>
        
</div>


<div class="mfp-with-anim mfp-hide mfp-dialog clearfix" id="walletpayment">
    <h3 class="widget-title">Wallet Payment</h3>
    <hr />
        <div class="paymentwallet"></div>
        <div class="form-group">
        	<input type="hidden" name="dueid2" class="dueid2">
            <input class="form-control password" type="password" placeholder="Wallet Password" />
            
        </div>
        <input class="btn btn-primary paywallet" type="submit" value="Send" />
        <br>
        <p class="alert alert-danger alert-dismissable fade in failuretext" style="display: none; padding: 3px; margin-top: 10px">
            Incorrect wallet password
        </p>
        <p class="alert alert-danger alert-dismissable fade in failuretext2" style="display: none; padding: 3px; margin-top: 10px">
            Insufficient Fund
        </p>
    
    <div class="gap gap-small"></div>
</div>
<?php
$products=App\rfq::find($id);

  ?>

<div class="container" style="margin-bottom: -30px !important;width: 100%;margin:0">
	<br>
	<ol class="breadcrumb page-breadcrumb">
                    <li><a href="/">Home</a>
                    </li>
                    <li><a href="#">Dashboard</a>
                    </li>
                    <li class="active">{{Auth::user()->name}}</li>
                </ol>
                <br>
	<div class="row" style="width: 100%;margin:0">
		
		<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 dashpanel">
			<div class="gap gap-small"></div>
			@include('customers.customer_dasboard')
			<div class="gap gap-big"></div>
      <div class="gap gap-big"></div>
      <div class="gap gap-big"></div>
      <div class="gap gap-big"></div>
		</div>
		<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 box" >
      <div class="row">
        <div class="col-lg-12">
          
        </div>
      </div>
      <br>
      <br>

      <div class="row">
      <div class="col-md-12">
            
          <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
          <tr>
            
            <th>Product Name</th>
			<th >Vendor Name</th>
            <th>Bid Price</th>
            <th>Vendor Location</th>
            <th>Note</th>
            <th>Select</th>
          </tr>
      </thead>
      <tbody>
       
        @php

          $vendorrfq=App\rfqvendor::where('rfq_id','=',$id)->get();

         @endphp
         @if(count($vendorrfq)>0)
         @foreach($vendorrfq as $rfq)
         @php

         $vendor=App\vendors::where('user_id','=',$rfq->vendor_id)->first();
         @endphp
         <tr>
           <td>{{$products->product_name}}</td>
           <td><a href="{{url('/vendors/'.$vendor->user_id)}}" title="">{{$vendor->vendorname}}</a></td>
           <td>{{App\Http\Controllers\HomeController::converter($rfq->bid)}}</td>
           <td>{{$vendor->location}}</td>
           <td>{{$rfq->note}}</td>
           <td><a href="{{url('rfq/selected/'.$products->id.'/'.$rfq->vendor_id)}}" title="">Select</a></td>
         </tr>
         @endforeach
         @endif
      
      </tbody>
      <tfoot>
          <tr>
            
            <th>Product Name</th>
      <th >Vendor Name</th>
            <th>Bid Price</th>
            <th>Vendor Location</th>
          <th>Note</th>
            <th>Select</th>
          </tr>
      </tfoot>
      <tbody class="data">
      	
       </tbody>
    </table>

      </div>
      </div>
      
      <div class="gap gap-big"></div>
      <div class="gap gap-big"></div>
      <div class="gap gap-big"></div>
      <div class="gap gap-big"></div>
		</div>
	</div>
</div>
<script>
  $(document).ready(function(){
    $('#table').DataTable();
  });
  $(".navtoggle").click(function () {
    $(".showtoggle").toggle("slow", function () {
        // Animation complete.
    });
});
$(".rfq").click(function() {
  $( ".showrfq" ).toggle( "slow", function() {
    // Animation complete.
  });
});
</script>
@endsection











