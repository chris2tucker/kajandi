@extends('layouts.pagelayout')
@section('content')
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" rel="stylesheet">
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
.canvasjs-chart-canvas{
  width: auto !important;
}
.canvasjs-chart-container{
  width: 100% !important;
}

</style>
<link rel="stylesheet" type="text/css" href="{{URL::asset('/css/datatables.min.css') }}"/>
<script src="{{URL::asset('/js/canvasjs.min.js') }}"></script>
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

<div class="container" style="margin-bottom: -30px !important;width: 100%;margin: 0;">
	<br>
	<ol class="breadcrumb page-breadcrumb">
                    <li><a href="{{url('/')}}">Home</a>
                    </li>
                    <li><a href="{{url('customers/report')}}">Report</a>
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
			<h2>Report</h2>
      <div class="show"></div>

			<div>
          <label for="categories">Categories</label>
          <select name="categories" class="categories" style="width: 100px">
              <option value="all">All Categories</option>
            @foreach($categories as $category)
              <option value="{{$category->id}}">{{$category->name}}</option>
            @endforeach
          </select>
          <script>
            $(document).ready(function(){
              $('.categories').change(function() {
        category = $(this).val();
        url = ajaxurl+'/getsubcategory';
        $.get(
          url,
           {category: category},
          function(data) {
            $('.sub-categories').html(data);
          });
      })
            })
          </script>
          <label for="subcategory">Sub Categories</label>
                <select name="subcategory" class="sub-categories" style="width: 100px">
                    <option value="all">All Subcategory</option>

                </select>
                <label for="delivery">Delivery Status</label>
                <select name="delivery" class="delivery-status" style="width: 100px">
                    <option value="all">All Delivery Status</option>
                    <option value="pending">Delivered</option>
                    <option value="delivered">Pending</option>
                </select>
				<label for="from">From</label>
<input type="text" id="from" name="from">
<label for="to">to</label>
<input type="text" id="to" name="to">
<button class="btn btn-primary daterange">Search</button>
<br><br>
<button class="btn btn-primary popup-text" href="#workplace-dialog" data-effect="mfp-move-from-top"><i class="fa fa-bar-chart" aria-hidden="true"></i>
 View Chart</button>
   <button class="btn btn-primary popup-text" href="#stations-dialog" data-effect="mfp-move-from-top"><i class="fa fa-bar-chart" aria-hidden="true"></i>
 Money spent on stations</button>
 <br><br><br><br>
		
      <div class="data">
			<table id="myTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
					<tr>
            <th>S/N</th>
            <th >Product</th>
            <th>Ref id</th>
            <td>Order Number</td>
            <th>Vendor</th>
            <th>Workplace</th>
            <th>Order Date</th>
            <th>Delivery Status</th>
          </tr>
			</thead>
			<tfoot>
					<tr>
            <th>S/N</th>
            <th >Product</th>
            <th>Ref id</th>
            <th>Order number</th>
            <th>Vendor</th>
            <th>Workplace</th>
            <th>Order Date</th>
            <th>Delivery Status</th>
          </tr>
			</tfoot>
			<tbody>

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
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.print.min.js"></script>

<?php
    $dataPoints = array(
        array("y" => 6, "label" => "Apple"),
        array("y" => 4, "label" => "Mango"),
        array("y" => 5, "label" => "Orange"),
        array("y" => 7, "label" => "Banana"),
        array("y" => 4, "label" => "Pineapple"),
        array("y" => 6, "label" => "Pears"),
        array("y" => 7, "label" => "Grapes"),
        array("y" => 5, "label" => "Lychee"),
        array("y" => 4, "label" => "Jackfruit")
    );
?>

<script type="text/javascript">


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
      toolTipContent: "{y} ",
     
      legendText: "{indexLabel}",
      dataPoints: <?php echo json_encode($chartarray, JSON_NUMERIC_CHECK); ?>
    }
    ]
  });
  chart.render();
  });
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

	$(document).ready(function(){
    $('#myTable').DataTable({
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
  </script>

  <script type="text/javascript">
  		$('.daterange').click(function() {
        categories = $('.categories').val();
        var subcategory_id = $(".sub-categories").val();
        var delivery_status = $(".delivery-status").val();
  			from = $( "#from" ).val();
  			to = $( "#to" ).val();

  			if (from.length > 0 && to.length > 0) {
  				url = ajaxurl+'getreportdate';
				$.get(
						url,
			      {from: from,
			      	to: to,
              categories: categories,subcategory:subcategory_id,delivery:delivery_status},
			      function(data) {
    $('#myTable').DataTable();

            var Datahtml = '<table id="myTable" class="table table-striped table-bordered data" cellspacing="0" width="100%">'+
                            '<thead>'+
                                '<tr>'+
                                  '<th>S/N</th>'+
                                  '<th >Product</th>'+
                                  '<th>Refrence id</th>'+
                                  '<th>Order Number</th>'+
                                  '<th>Vendor</th>'+
                                  '<th>Workplace</th>'+
                                  '<th>Order Date</th>'+
                                  '<th>Delivery Status</th>'+
                                '</tr>'+
                            '</thead>'+
                            '<tfoot>'+
                                '<tr>'+
                                  '<th>S/N</th>'+
                                  '<th >Product</th>'+
                                  '<th>Refrence id</th>'+
                                  '<th>Order number</th>'+
                                  '<th>Vendor</th>'+
                                  '<th>Workplace</th>'+
                                  '<th>Order Date</th>'+
                                  '<th>Delivery Status</th>'+
                                '</tr>'+
                            '</tfoot>'+
                            '<tbody class="data">'+
                              data+
                            '</tbody>'+
                            '</table>'+

			      	$('.data').html('');
              $('.data').empty();
			        $('.data').html(Datahtml);
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
















