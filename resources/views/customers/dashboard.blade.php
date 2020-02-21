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
<div class="container" style="margin-bottom: -30px !important;width: 100%;margin: 0 !important;">
	<br>
	<ol class="breadcrumb page-breadcrumb">
                    <li><a href="{{url('/')}}">Home</a>
                    </li>
                    <li><a href="{{url('customers/dashboard')}}">Dashboard</a>
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
          <div class="">
            <?php 
            if (empty($sumtotal)) {
              echo '<h4><b>No Transaction for the month</b></h4>';
            }else{
              echo '<h4><b>Total:'.App\Http\Controllers\HomeController::converter($sumtotal).'</b></h4>';
              echo '<h4><b>Quantity: '.number_format($sumquantity).'</b></h4>';
            }
             ?>
          </div>
        </div>
      </div>
      <br>
      <br>

      <div class="row">
        <div class="col-md-12">
          <div id="chartContainer" style="width: 100% !important"></div>
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
$(function () {
        var chart = new CanvasJS.Chart("chartContainer", {
            theme: "theme2",
            animationEnabled: true,
            title: {
                text: "Purchase Chart"
            },
            data: [
            {
                type: "column",                
                dataPoints: <?php echo json_encode($chartarray, JSON_NUMERIC_CHECK); ?>
            }
            ]
        });
        chart.render();
    });

  $(function() {
    // body...''

    var chart = new CanvasJS.Chart("chartContainer2",
  {
    theme: "theme2",
    title:{
      text: "Sales Chart of the month"
    },
    data: [
    {
      type: "pie",
      showInLegend: true,
      toolTipContent: "{y} - #percent %",
      yValueFormatString: "#0.#,,. Million",
      legendText: "{indexLabel}",
      dataPoints: <?php echo json_encode($chartarray, JSON_NUMERIC_CHECK); ?>
    }
    ]
  });
  chart.render();
  })

</script>
@endsection










