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

<script src="{{URL::asset('/js/canvasjs.min.js') }}"></script>

<div class="mfp-with-anim mfp-hide mfp-dialog clearfix" id="review-dialog">
            <h3 class="widget-title">Fund Account</h3>
            <hr />
               <button type="button" class="btn btn-primary" id="card">Card Payment</button> <button type="button" class="btn btn-primary" id="bank">Bank Payment</button>
               <!--<button type="button" class="btn btn-primary">PayPal</button>-->
                <form action="{{url('/pay/wallet')}}" method="POST" accept-charset="utf-8" style="display: none;"  class="cardform">
                  {{csrf_field()}}
                  <div class="form-group">
                    <label>Amount</label>
                    <input class="form-control fund" name="amount" type="number" required placeholder="Amount in Naira" />
                    <p class="alert alert-danger emailerror" style="display: none;">
                        Amount field is empty
                    </p>
                </div>
                <input class="btn btn-primary " type="submit" value="Send" />
                <p class="successtext" style="display: none; padding: 3px"></p>
                  
                </form>
                <form action="{{url('/pay/bank/wallet')}}" method="POST" accept-charset="utf-8" style="display: none;"  class="bankform">
                  {{csrf_field()}}
                  <div class="form-group">
                    <label>Amount</label>
                    <input class="form-control fund" name="amount" type="number" required placeholder="Amount in Naira" />
                    <p class="alert alert-danger emailerror" style="display: none;">
                        Amount field is empty
                    </p>
                </div>
                <input class="btn btn-primary " type="submit" value="Send" />
                <p class="successtext" style="display: none; padding: 3px"></p>
                  
                </form>
            
            <div class="gap gap-small"></div>
        </div>

<div class="container" style="margin-bottom: -30px !important;width: 100%;margin: 0;">
	<br>
	<ol class="breadcrumb page-breadcrumb">
                    <li><a href="{{url('/')}}">Home</a>
                    </li>
                    <li><a href="{{url('customers/wallet')}}">Dashboard</a>
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
        <div class="col-lg-12">
          
        </div>
      </div>
      <br>
      <br>
      @if(Session::has('message'))
      {{Session::get('message')}}
      @endif
      <div class="col-md-10">
        <h4 style="margin-bottom: 20px;">You can fund your wallet here. Money paid into your wallet can be used for direct purchases</h4>
        <div class="row">
        <div class="col-lg-6">
              <div class="col-lg-12" style="margin-bottom: 10px">
                  <div class="col-lg-5 text-center" style="background-color: #E6E6E6; padding: 5px; color: #fff">
                    
                    <i class="fa fa-money fa-4x" aria-hidden="true"></i>
                  </div>
                  <div class="col-lg-7" style="border-right: 6px solid #428BCA">
                    <h4>Wallet</h4>
                    {{ App\Http\Controllers\HomeController::converter($wallet) }}
                    <br>
                  </div>
              </div>

              <div class="col-lg-12" >
                <a href='#review-dialog' class="icon_color popup-text">
                <div class="col-lg-5 text-center" style="background-color: #5BC0DE; padding: 5px; color: #fff">
                  
                  <i class="fa fa-line-chart fa-4x" aria-hidden="true"></i>
                </div>
                <div class="col-lg-7" style="border-right: 6px solid #5BC0DE">
                  <h4>Fund Wallet</h4>
                  <br>
                </div>
                </a>
              </div>
          </div>
          <div class="col-lg-6">
              <div class="col-lg-12" style="margin-bottom: 10px">
                <a href="{{url('/customers/accounthistory')}}" class="icon_color">
                  <div class="col-lg-5 text-center" style="background-color: #428BCA; padding: 5px; color: #fff">
                    <i class="fa fa-history fa-4x" aria-hidden="true"></i>
                    
                  </div>
                  <div class="col-lg-7" style="border-right: 6px solid #E6E6E6">
                    <h4>Wallet History</h4>
                    <br>
                  </div>
                </a>
              </div>
  
              <div class="col-lg-12">
                <a href="{{url('/customers/walletsetting')}}" class="icon_color">
                <div class="col-lg-5 text-center" style="background-color: #F0AD4E; padding: 5px; color: #fff">
                  <i class="fa fa-cog fa-4x" aria-hidden="true"></i>
                </div>
                <div class="col-lg-7" style="border-right: 6px solid #F0AD4E">
                  <h4>Wallet Settings</h4>
                  <br>
                </div>
                </a>
              </div>
          </div>  
         <!-- <form method="POST" action="{{ route('pay') }}" accept-charset="UTF-8" class="form-horizontal" role="form">
        <div class="row" style="margin-bottom:40px;">
          <div class="col-md-8 col-md-offset-2">
            <p>
                <div>
                    Lagos Eyo Print Tee Shirt
                    ₦ 2,950
                </div>
            </p>
            <input type="hidden" name="email" value="careeroffaisal1@gmail.com"> {{-- required --}}
            <input type="hidden" name="orderID" value="345">
            <input type="hidden" name="amount" value="800"> {{-- required in kobo --}}
            <input type="hidden" name="quantity" value="3">
            <input type="hidden" name="metadata" value="{{ json_encode($array = ['key_name' => 'value',]) }}" > {{-- For other necessary things you want to add to your payload. it is optional though --}}
            <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}"> {{-- required --}}
            <input type="hidden" name="key" value="{{ config('paystack.secretKey') }}"> {{-- required --}}
            {{ csrf_field() }} {{-- works only when using laravel 5.1, 5.2 --}}

             <input type="hidden" name="_token" value="{{ csrf_token() }}"> {{-- employ this in place of csrf_field only in laravel 5.0 --}}


            <p>
              <button class="btn btn-success btn-lg btn-block" type="submit" value="Pay Now!">
              <i class="fa fa-plus-circle fa-lg"></i> Pay Now!
              </button>
            </p>
          </div>
        </div>
</form>-->
      </div>
      </div>
      
      <div class="gap gap-big"></div>
      <div class="gap gap-big"></div>
      <div class="gap gap-big"></div>
      <div class="gap gap-big"></div>
     <h4> Money paid into your wallet is stored and not used till you make purchases with your wallet. A password is always required before purchase</h4>
		</div>
	</div>

</div>

@endsection
@section('script')
<script type="text/javascript">
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
});
$(document).ready(function(){
  $("#card").click(function(){
  $('.cardform').show();
  $(".bankform").hide();
});
  $("#bank").click(function(){
    $('.cardform').hide();
  $(".bankform").show();
  })
})

</script>
@endsection










