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
 <?php 
 $outstanding=App\outstandingpayment::where('user_id','=',Auth::user()->id)->where('duedate','>',carbon\Carbon::today())->where('payment','!=','yes')->sum('totalprice');
                        $due=App\outstandingpayment::where('user_id','=',Auth::user()->id)->where('duedate','<',carbon\Carbon::today())->where('payment','!=','yes')->sum('totalprice');
                        ?>

<div class='mfp-with-anim mfp-hide mfp-dialog4 clearfix' id='abcd' style='width: 100%'>
    <h3 class='widget-title'>Payment</h3>
    <p>Select your payment method</p>
    <hr />
    <form action="{{url('pay/outstandingamount')}}" method="POST" accept-charset="utf-8" style="display: inline;">
            {{csrf_field()}}
            <input type="hidden" name="amount" value="{{$outstanding}}">
            <button class="btn btn-primary" type="submit">Pay With Card</button>
          </form>
   
   <a class="btn btn-primary" href="{{url('/outstanding/slip/all')}}" >Payment Slip</a>
    <button class='paywithwallet btn btn-primary popup-text  changeval' href='#walletpayment' id='1'  @if($outstanding<$balance) @else disabled @endif>Pay with wallet</button>
   
    
    
        
</div>
<!-- due ampunt-->
<div class='mfp-with-anim mfp-hide mfp-dialog4 clearfix' id='abc' style='width: 100%'>
    <h3 class='widget-title'>Payment</h3>
    <p>Select your payment method</p>
    <hr />
    <input type='hidden' name='dueid' class='dueid'>
    <form action="{{url('pay/dueamount')}}" method="POST" accept-charset="utf-8" style="display: inline;">
            {{csrf_field()}}
            <input type="hidden" name="amount" value="{{$due}}">
            <button class="btn btn-primary" type="submit">Pay with card</button>
          </form>
    
   <a class="btn btn-primary" href="{{url('/outstanding/slip/all/duepay')}}" >Payment Slip</a>
    <button class='paywithwallet btn btn-primary popup-text  changeval' href='#walletpayment' id='1'  @if($due<$balance) @else disabled @endif>Pay with wallet</button>
   
  
        
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


<div class="container" style="margin-bottom: -30px !important;width: 100%;margin: 0;">
	<br>
	<ol class="breadcrumb page-breadcrumb">
                    <li><a href="{{url('/')}}">Home</a>
                    </li>
                    <li><a href="{{url('customers/dueandoutstanding')}}">Due and outstanding</a>
                    </li>
                    <li class="active">{{Auth::user()->name}}</li>
                </ol>
                <br>
	<div class="row" style="margin: 0;">
		
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
        <div class="col-md-6">    
          Outstanding Amount ={{App\Http\Controllers\HomeController::converter($outstanding)}}
          @if($outstanding>0) <button class='btn btn-default popup-text paydue' href='#abcd' data-effect='mfp-move-from-top' id='outstanding'>Outstanding Amount Pay</button> @endif

          
          </form>
        </div>
        <div class="col-md-6">
        @if($due)  <button class='btn btn-default popup-text paydue' href='#abc' data-effect='mfp-move-from-top' id='due'>Due Amount Pay</button>@endif
         Due Amount ={{App\Http\Controllers\HomeController::converter($due)}}
           
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
            <th>Transaction Id</th>
            <th>Order Number</th>
			<th >Product</th>
            <th>Amount</th>
            <th>Transaction Date</th>
            <th>Due Date</th>
            <th>Amount type</th>
            <th>Pay</th>
          </tr>
      </thead>
      <tfoot>
          <tr>
            <th>S/N</th>
            <th >Transaction Type</th>
            <th>Transaction Id</th>
            <th>Amount</th>
            <th>Transaction Date</th>
            <th>Due Date</th>
            <th>Pay</th>
          </tr>
      </tfoot>
      <tbody class="data">
      	<?php echo $view; ?>
       </tbody>
    </table>

      </div>
      </div>
      <h4 style="margin-top: 30px;"> You will not be able to make Credit Purchases (15 days or 30 days) with an active due amount. Kindly Pay your total Due amounts to be able to enjoy full services and Credit facility</h4>
      <div class="gap gap-big"></div>
      <div class="gap gap-big"></div>
      <div class="gap gap-big"></div>
      <div class="gap gap-big"></div>
		</div>
	</div>
</div>

@endsection
@section('script')
<script type="text/javascript">

	$(document).on('click', '.paywithcard', function() {
		id = $('.dueid').val();
		url = ajaxurl+'paywithcard';
		$.get(
	      url,
	      {id: id},
	      function(data) {
	        window.location = ajaxurl+'customers/dueandoutstanding';
	      });
	})

	$(document).on('click', '.paywallet', function() {
		password = $('.password').val();
	  code = $('.dueid2').val();
  
	  url = ajaxurl+'paywallet';
	  if (password.length > 0) {


	    $.get(
	      url,
	      {password: password,
	        code: code},
	      function(data) {
	        if (data == 'false') {
	          $('.failuretext').show();
	          $('.failuretext2').hide();
	        }else if (data == 'insufficient') {
	        	$('.failuretext2').show();
	        	$('.failuretext').hide();
	        }else{
	          window.location = ajaxurl+'customers/dueandoutstanding';
	        }
	      });

	  }
	})

	$(document).on('click', '.paydue', function() {
		id = $(this).attr('id');
		$('.dueid').val(id);
		$('.dueid2').val(id);
	})
	// $(document).on('click', '.paywithwallet', function() {
		
	// })
	$(".navtoggle").click(function() {
  $( ".showtoggle" ).toggle( "slow", function() {
    // Animation complete.
  });
});
  $(".rfq").click(function() {
  $( ".showrfq" ).toggle( "slow", function() {
    // Animation complete.
  });
});

$('.addfund').click(function() {
  fund = $('.fund').val();
  url = ajaxurl+'addfund';
    $.get(
        url,
        {fund: fund},
        function(data) {
          location.reload();
        });
})

$(document).ready(function(){
    $('#myTable').DataTable();
});

</script>
@endsection










