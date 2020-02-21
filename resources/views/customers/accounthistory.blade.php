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

<div class="mfp-with-anim mfp-hide mfp-dialog clearfix" id="review-dialog">
            <h3 class="widget-title">Fund Account</h3>
            <hr />
               <button type="button" class="btn btn-primary" id="card">Card</button> <button type="button" class="btn btn-primary" id="bank">Bank</button>
               <button type="button" class="btn btn-primary">PayPal</button>
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

<div class="container" style="margin-bottom: -30px !important;width: 100%;">
	<br>
	<ol class="breadcrumb page-breadcrumb">
                    <li><a href="/">Home</a>
                    </li>
                    <li><a href="#">Dashboard</a>
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
          <a href='#review-dialog' class="icon_color popup-text">
                
                  <h4>Fund Wallet</h4>
                  <br>
               
                </a>
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
            <th >Transaction Type</th>
            <th>Transaction Id</th>
            <th>Amount</th>
            <th>Balance</th>
            <th>Transaction Date</th>
          </tr>
      </thead>
      <tfoot>
          <tr>
            <th>S/N</th>
            <th >Transaction Type</th>
            <th>Transaction Id</th>
            <th>Amount</th>
            <th>Balance</th>
            <th>Transaction Date</th>
          </tr>
      </tfoot>
      <tbody class="data">

          <?php echo $view ?>
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
})

$(document).ready(function(){
    $('#myTable').DataTable();
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










