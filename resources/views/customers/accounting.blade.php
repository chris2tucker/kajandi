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
<div class="mfp-with-anim mfp-hide mfp-dialog3 clearfix" id="summary" style="background: #f9f9f9">
      <div class="row">
        
        <div class="col-md-12">
        <table id="myTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>Total Amount</th>
            <th >Total spent in this month</th>
            <th>outstanding payment</th>
            <th>Due payment</th>
            
            <th>card payment amount</th>
            <th>bank payment amount</th>
            <th>Wallet payment amount</th>
            <th>Pay total Amount</th>
          </tr>
      </thead>
      <tfoot>
          <tr>
            <th>Total Amount</th>
            <th >Total spent in this month</th>
            <th>outstanding payment</th>
            <th>Due payment</th>
            <th>card payment amount</th>
            <th>bank payment amount</th>
            <th>Wallet payment amount</th>
            <th>Pay total Amount</th>
            
          </tr>
      </tfoot>
      <?php
      $user=Auth::user()->id;
      $totalamount=0;
      $thismonth=0;
      $cardpay=0;
      $orders=App\orders::where('user_id','=',$user)->where('payment','=','yes')->get();
      $outstandingamount=App\outstandingpayment::where('user_id','=',$user)->where('duedate','>=',carbon\carbon::today()->toDateString())->where('payment','pending')->sum('totalprice');
     $dueamount=App\outstandingpayment::where('user_id','=',$user)->where('duedate','<=',carbon\carbon::today()->toDateString())->where('payment','pending')->sum('totalprice');
      $startmonth=carbon\Carbon::now()->startOfMonth()->toDateString();
      $endmonth=carbon\Carbon::now()->endOfMonth()->toDateString();
      
     foreach ($orders as $order) {
       $orderdetail=App\ordersdetail::where('ordernumber','=',$order->ordernumber)->first();
       $monthsamount=App\ordersdetail::where('ordernumber','=',$order->ordernumber)->whereBetween('dateordered',[$startmonth,$endmonth])->first();
       $cardpayment=App\orderpayment::where('ordernumber','=',$order->ordernumber)->where('payment_type','=','card')->first();
       if($cardpayment){
         $orderdetail=App\ordersdetail::where('ordernumber','=',$order->ordernumber)->first();
       $cardpay=$cardpay+$orderdetail->totalprice;
       }
       
       if($monthsamount){
        $thismonth=$$thismonth+$monthsamount->totalprice;
       }
     $totalamount=$totalamount+$orderdetail->totalprice;
     }
    
        ?>
      <tbody class="data">

       <tr>
         <td>{{App\Http\Controllers\HomeController::converter($totalamount)}}</td>
         <td>{{App\Http\Controllers\HomeController::converter($thismonth)}}</td>
         <td>{{App\Http\Controllers\HomeController::converter($outstandingamount)}}
          <form action="{{url('pay/outstandingamount')}}" method="POST" accept-charset="utf-8">
            {{csrf_field()}}
            <input type="hidden" name="amount" value="{{$outstandingamount}}">
            <button type="submit">card pay</button>
          </form>
         </td>
         <td>{{App\Http\Controllers\HomeController::converter($dueamount)}}
          <form action="{{url('pay/dueamount')}}" method="POST" accept-charset="utf-8">
            {{csrf_field()}}
            <input type="hidden" name="amount" value="{{$dueamount}}">
            <button type="submit">card pay</button>
          </form></td>
         <td>{{App\Http\Controllers\HomeController::converter($cardpay)}}</td>
         <td>0</td>
         <td>0</td>
           <td>{{App\Http\Controllers\HomeController::converter($dueamount+$outstandingamount)}}
          <form action="{{url('pay/totalamount')}}" method="POST" accept-charset="utf-8">
            {{csrf_field()}}
            <input type="hidden" name="amount" value="{{($dueamount+$outstandingamount)}}">
            <button type="submit">card pay</button>
          </form></td>
       </tr>
        </tbody>
        </tbody>
    </table>
      </div>  
      </div>
        
      
</div>
<div class="mfp-with-anim mfp-hide mfp-dialog3 clearfix" id="stations-dialog">
      <div class="row">
        
        <div class="col-md-12">
        <div id="pieContainer2" style="width: 100% !important"></div>
      </div>  
      </div>
        
      
</div>

 <div class="mfp-with-anim mfp-hide mfp-dialog3 clearfix" id="workplace-dialog">
      <div class="row">
        <div class="col-md-12">
          <div id="chartContainer" style="width: 100% !important"></div>
        </div>
        <div class="col-md-12">
        <div id="chartContainer2" style="width: 100% !important"></div>
      </div>  
      </div>
        
      
</div>


<div class="container" style="margin-bottom: -30px !important;width: 100%;margin: 0 !important">
	<br>
	<ol class="breadcrumb page-breadcrumb">
                    <li><a href="{{url('/')}}">Home</a>
                    </li>
                    <li><a href="{{url('customers/accounting')}}">Accounting</a>
                    </li>
                    <li class="active">{{Auth::user()->name}}</li>
                </ol>
                <br>
	<div class="row" style="width: 100%;margin:0;">
		
		<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 dashpanel hidden-xs">
			<div class="gap gap-small"></div>
			@include('customers.customer_dasboard')
			<div class="gap gap-big"></div>
		</div>
		<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 box" >
			<h2>Accounting</h2>
			<div>

        <label for="categories">Categories</label>
          <select name="categories" class="categories" style="width: 100px">
              <option value="all">All Categories</option>
            @foreach($categories as $category)
              <option value="{{$category->id}}">{{$category->name}}</option>
            @endforeach
          </select>
          @php
          $workspace=App\workplace::where('user_id','=',Auth::user()->id)->get();
          $payment=App\orderpayment::where('user_id','=',Auth::user()->id)->groupBy('payment_type')->get();
          @endphp
          <label for="workplace">Workplace</label>
          <select name="workplace" class="workplace" style="width: 100px">
              <option value="all">All Workplace</option>
            @foreach($workspace as $space)
              <option value="{{$space->id}}">{{$space->name}}</option>
            @endforeach
          </select>
          <label for="payment">PaymentType</label>
          <select name="payment" class="payment" style="width: 100px">
              <option value="all">All Payment type</option>
            @foreach($payment as $pay)
              <option value="{{$pay->payment_type}}">{{$pay->payment_type}}</option>
            @endforeach
          </select>

				<label for="from">From</label>
<input type="text" id="from" name="from">
<label for="to">to</label>
<input type="text" id="to" name="to">
<button class="btn btn-primary daterange">Search</button>

<br><br>
<div class="row" style="margin: 0;">
  <div class="col-md-12">
    <?php 
            if (empty($sumtotal)) {
              echo '<h4><b>No Transaction for the month</b></h4>';
            }else{
              echo '<p>Total order: <b><span class="totalamt">'.App\Http\Controllers\HomeController::converter($sumtotal).'</span></b></p>';
              echo '<p>Total quantity: <b><span class="totalqty">'.number_format($sumquantity).'</span></b></p>';
            }
        ?>
    <button class="btn btn-primary popup-text" href="#workplace-dialog" data-effect="mfp-move-from-top"><i class="fa fa-bar-chart" aria-hidden="true"></i>
 View Chart</button>
  <button class="btn btn-primary popup-text" href="#stations-dialog" data-effect="mfp-move-from-top"><i class="fa fa-bar-chart" aria-hidden="true"></i>
 Money spent on stations</button>
 <button class="btn btn-primary popup-text" href="#summary" data-effect="mfp-move-from-top"><i class="fa fa-bar-chart" aria-hidden="true"></i>
 Summary</button>
  </div>
</div>

<br>
			<table id="mytab" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
					<tr>
            <th>S/N</th>
            <th >Product</th>
            <th>Order Number</th>
            <th>Ref id</th>
            <th>Vendor</th>
            <th>Workplace</th>
            <th>Order Date</th>
            <th>Payment Type</th>
            <th>Delivery Status</th>
          </tr>
			</thead>
			<tfoot>
					<tr>
            <th>S/N</th>
            <th >Product</th>
            <th>Order Number</th>
            <th>Ref id</th>
            <th>Vendor</th>
            <th>Workplace</th>
            <th>Order Date</th>
            <th>Payment Type</th>
            <th>Delivery Status</th>
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
@endsection
@section('script')
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.print.min.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
    $('#mytab').DataTable({
       dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ] 
    });
});
</script>
<script>
  $( function() {
    var dateFormat = "yy/mm/dd",
      from = $( "#from" )
        .datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 3,
          dateFormat: "yy/mm/dd"
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#to" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 3,
          dateFormat: "yy/mm/dd"
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }
  } );

    $(function () {
        var chart = new CanvasJS.Chart("chartContainer", {
            theme: "theme2",
            animationEnabled: true,
            exportEnabled: true,
            title: {
                text: "Purchase Chart of the month"
            },
            data: [
            {
                type: "column", 
                indexLabelFontColor: "#5A5757",
                indexLabelPlacement: "outside",               
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
    animationEnabled: true,
    exportEnabled: true,
    title:{
      text: "Purchase Chart of the month"
    },
    data: [
    {
      type: "pie",
      showInLegend: true,
      toolTipContent: "{y}",
    
      legendText: "{indexLabel}",
      dataPoints: <?php echo json_encode($chartarray, JSON_NUMERIC_CHECK); ?>
    }
    ]
  });
  chart.render();
  })
  $(function() {
    // body...''

    var chart = new CanvasJS.Chart("pieContainer2",
  {
    theme: "theme2",
    animationEnabled: true,
    exportEnabled: true,
    title:{
      text: "Purchase Chart of the month"
    },
    data: [
    {
      type: "pie",
      showInLegend: true,
      toolTipContent: "{y}",
     
      legendText: "{indexLabel}",
      dataPoints: <?php echo json_encode($stationchart, JSON_NUMERIC_CHECK); ?>
    }
    ]
  });
  chart.render();
  })

  </script>

  <script type="text/javascript">
  		$('.daterange').click(function() {
  			from = $( "#from" ).val();
  			to = $( "#to" ).val();
        categories = $('.categories').val();
        payment=$('.payment').val();
        workplace=$('.workplace').val();
  			if (from.length > 0 && to.length > 0) {
  				url = ajaxurl+'getaccounting';
				$.get(
						url,
			      {from: from,
			      	to: to,
              categories: categories,
              workplace:workplace,
              payment:payment},
			      function(data) {
			        $('.data').html(data);
			      });
  			}
  		})

  		$('.daterange').click(function() {
  			from = $( "#from" ).val();
  			to = $( "#to" ).val();
        categories = $('.categories').val();

  			if (from.length > 0 && to.length > 0) {
  				url = ajaxurl+'getaccountingsum';
				$.get(
						url,
			      {from: from,
			      	to: to,
              categories: categories},
			      function(data) {

              datas = JSON.parse(data);
              console.log(data);
              $('.totalamt').html(datas.total);
			        $('.totalqty').html(datas.quantity);
			      });
  			}
  		})

      $('.daterange').click(function() {
        from = $( "#from" ).val();
        to = $( "#to" ).val();

        if (from.length > 0 && to.length > 0) {
          url = ajaxurl+'getreportsum';
       
              

              var dataPoints = [];
              $.getJSON(ajaxurl+"/getreportsum?from="+from+"&to="+to, function(data) {  
                $.each(data, function(key, value){
                  dataPoints.push({label: value['label'], y: parseInt(value['y'])});
                });
                var chart = new CanvasJS.Chart("chartContainer2",{
                  theme: "theme2",
                  title:{
                    text:"Purchase Chart of the month"
                  },
                  data: [{
                    type: "pie",
                    showInLegend: true,
                    toolTipContent: "{y} - #percent %",
                    yValueFormatString: "#0.#,,. Million",
                    legendText: "{indexLabel}",
                    dataPoints : dataPoints,
                  }]
                });
                chart.render();
              });

              var dataPoint = [];
              $.getJSON(ajaxurl+"/getreportsum?from="+from+"&to="+to, function(data) {  
                $.each(data, function(key, value){
                  dataPoint.push({label: value['label'], y: parseInt(value['y'])});
                });
                var chart = new CanvasJS.Chart("chartContainer",{
                  theme: "theme2",
                  animationEnabled: true,
                  title:{
                    text:"Purchase Chart of the month"
                  },
                  data: [{
                    type: "column",
                    dataPoints : dataPoint,
                  }]
                });
                chart.render();
              });

            
      }
    })

  </script>
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
</script>

@endsection
















