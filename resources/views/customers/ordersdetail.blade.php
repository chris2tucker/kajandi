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
<link href="{{URL::asset('css/star-rating.min.css') }}" media="all" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('/themes/krajee-svg/theme.css') }}" media="all" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('/themes/krajee-fa/theme.css') }}" media="all" rel="stylesheet" type="text/css" />


<div class="mfp-with-anim mfp-hide mfp-dialog clearfix" id="review-dialog">
            <h3 class="widget-title">Add Review</h3>
            <hr />
                <p class="alert alert-danger loginformerror" style="display: none;">Email or Password incorrect</p>
                <input id="input-id" value="0" type="text" class="rating" data-min=1 data-max=5 data-step=0.1 data-size="xs" required 
               title="">
                <div class="form-group">
                    <textarea cols="4" rows="4" class="form-control reviewtext"></textarea>
                </div>
                <input type="hidden" name="hiddenid" class="hiddenid">
                <input class="btn btn-primary addreview" type="submit" value="Send" />
                <p class="successtext" style="display: none; padding: 3px"></p>
            
            <div class="gap gap-small"></div>
        </div>

<link rel="stylesheet" type="text/css" href="/css/datatables.min.css"/>

<div class="container" style="margin-bottom: -30px !important;width: 100%;margin: 0;">
	<br>
	<ol class="breadcrumb page-breadcrumb">
                    <li><a href="/">Home</a>
                    </li>
                    <li><a href="#">Orders Detail</a>
                    </li>
                    <li class="active">{{Auth::user()->name}}</li>
                </ol>
                <br>
	<div class="row" style="width: 100%;margin: 0;">
		
		<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 dashpanel hidden-xs">
			<div class="gap gap-small"></div>
			@include('customers.customer_dasboard')
			<div class="gap gap-big"></div>
		</div>
		<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 box" >
			<div class="col-lg-6">
				<h2>Orders #{{$ordersss->ordernumber}}</h2>
			</div>
			<div class="col-lg-6">
				<div class="pull-right">
				<p><b>Total: <?php echo App\Http\Controllers\HomeController::converter($totalprice); ?></b></p>
				<p><b>Quantity: <?php echo $totalquantity; ?></b></p>
			</div>
			</div>
			<div class="col-lg-12">
				<div class="table-responsive">
			<table id="myTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
					<tr>
						<th>S/N</th>
						<th >Product</th>
            <th>Ref id</th>
						<th>Vendor</th>
						<th>Workplace</th>
						<th>Delivery Status</th>
            <th>Order status</th>
            <th>Payment</th>
            <th>Status</th>
            <th>Cancel Reason</th>
					</tr>
					</thead>
					<tfoot>
					<tr>
						<th>S/N</th>
						<th>Product</th>
            <th>Ref id</th>
						<th>Vendor</th>
						<th>Workplace</th>
						<th>Delivery Status</th>
            <th>Order status</th>
            <th>Payment</th>
             <th>Status</th>
            <th>Cancel Reason</th>
					</tr>
					</tfoot>
					<tbody class="data">
					<?php echo $view ?>
				</tbody>
			</table>
		</div>
			</div>
			
			
		</div>
	</div>
</div>
@endsection
@section('script')
<script src="{{URL::asset('/js/star-rating.min.js') }}" type="text/javascript"></script>
<script src="{URL::asset('/themes/krajee-svg/theme.js') }}"></script>
<script src="{{URL::asset('/themes/krajee-fa/theme.js') }}"></script>
<script src="{{URL::asset('/js/locales/de.js') }}"></script>


<script type="text/javascript">

  $("#input-id").rating();

	$(document).ready(function(){
    $('#myTable').DataTable();
});

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

</script>
<script type="text/javascript">
    $(document).ready(function(){
    $('#myTable').DataTable();
});
    $('.deliverystatus').change(function () {
        orderid = $(this).attr('id');
        value = $(this).val();
        url = ajaxurl+'orderdeliverystatus';
            $.get(
                    url,
              {value: value,
                orderid: orderid},
              function(data) {
              });
        })
    $('.review').click(function() {
    	id = $(this).attr('id');
    	$('.hiddenid').val(id);
    	$('.successtext').hide();
    })

    $('.addreview').click(function() {
    	reviewtext = $('.reviewtext').val();
    	id = $('.hiddenid').val();
      rating = $('#input-id').val();
    	url = ajaxurl+'addreview';
            $.get(
                    url,
              {id: id,
                reviewtext: reviewtext,
                rating: rating},
              function(data) {
              	$('.reviewtext').val('');
                $('#input-id').rating('clear').val();
              	$('.rev'+id).html("<button class='btn btn-sm btn-default' >Reviewed</button>");
              	$('.successtext').show().html(data);
              });
    })
</script>

@endsection
















