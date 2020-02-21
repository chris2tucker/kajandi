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
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" rel="stylesheet">
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


<div class="container" style="margin-bottom: -30px !important;width: 100%;margin-left: 20px;">
	<br>
	<ol class="breadcrumb page-breadcrumb">
                    <li><a href="{{url('/')}}">Home</a>
                    </li>
                    <li><a href="{{url('favorite/credit/vendors')}}">Credit and favorite Vendors</a>
                    </li>
                    <li class="active">{{Auth::user()->name}}</li>
                </ol>
                <br>
	<div class="row">
		
		<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 dashpanel">
			<div class="gap gap-small"></div>
			@include('customers.customer_dasboard')
			<div class="gap gap-big"></div>
      <div class="gap gap-big"></div>
      <div class="gap gap-big"></div>
      <div class="gap gap-big"></div>
		</div>
		<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 box" >
        <h2>Vendors</h2>
      <div class="row">
        <div class="col-lg-12">
          
        </div>
      </div>
      <br>
      <br>

      <div class="row">
      <div class="col-md-12">
            
          <table id="myTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>S/N</th>
            <th>Name</th>
			<th >Location</th>
            <th>Vendor type</th>
            
            <th>vendor category</th>
            <th>Credit limit</th>
          </tr>
      </thead>
      <tbody>
        @php $i=1;
         @endphp
        @foreach($array as $vendor)
        @php 
        $vend=App\vendors::where('user_id','=',$vendor)->first();

        $customervenodor=App\customersvendor::where('vendor_id','=',$vend->user_id)->where('customer_id','=',Auth::user()->id)->first();
        $favorite=App\favoritevendor::where('vendor_id','=',$vend->user_id)->where('customer_id','=',Auth::user()->id)->first();
        @endphp
       <tr><td>{{$i}}</td>
          <td> <a href="{{url('/vendors/'.$vend->user_id)}}" title="">{{$vend->vendorname}}  </a></td>
          <td>{{$vend->location}}</td>
          <td>{{$vend->vendor_type}}</td>
          
          <td>@if($customervenodor) @if($customervenodor->status=='yes') {{'Credit vendor'}} @else {{'Credit request'}} @endif  @endif @if($favorite) @if($favorite->favorite==1) {{'favorite'}} @endif @endif</td>
          <td>@if($customervenodor) @if($customervenodor->limitted) {{App\Http\Controllers\HomeController::converter($customervenodor->limitted)}} @else {{'limit is not set'}}@endif @else limit is not set @endif</td>
        </tr>  
        @php
        $i++;
        @endphp
        @endforeach
      </tbody>
      <tfoot>
         <tr>
            <th>S/N</th>
            <th>Name</th>
          <th >Location</th>
            <th>Vendor type</th>
            <th>vendor category</th>
            <th>Credit limit</th>
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
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.print.min.js"></script>
<script>
  $(document).ready(function(){
    $("#myTable").DataTable({
      filter:true,
    })
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










