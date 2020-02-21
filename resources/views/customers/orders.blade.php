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
#myTable_filter{
  float: right;
}


</style>

 <div class="mfp-with-anim mfp-hide mfp-dialog clearfix" id="workplace-dialog">
            <h3 class="widget-title">Add Workplace</h3>
            <hr />
                <p class="alert alert-danger loginformerror" style="display: none;">Email or Password incorrect</p>
                <div class="form-group">
                    <label>Name</label>
                    <input class="form-control name" type="text" />
                    <p class="alert alert-danger emailerror" style="display: none;">
                        Email field is empty
                    </p>
                </div>
                <input class="btn btn-primary addworkplace" type="submit" value="Add Workplace" />
            
            <div class="gap gap-small"></div>
        </div>

<div class="container" style="margin-bottom: -30px !important;width: 100%;margin: 0;">
	<br>
	<ol class="breadcrumb page-breadcrumb">
                    <li><a href="{{url('/')}}">Home</a>
                    </li>
                    <li><a href="{{url('customers/orders')}}">Orders</a>
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
			<div class="pull-left">
				<h2>Orders</h2>	
			</div>
			<br><br><br>
			<div class="table-responsive">
			<table id="myTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
					<tr>
						<th>S/N</th>
						<th>Order Number</th>
						<th>Quantity</th>
						<th>Total Price</th>
						<th>Payment Status</th>
						<th>Work Place</th>
						<th>Delivery Status</th>
            <th>Order status</th>
            <th>Order date</th>
						<th>Action</th>
					</tr>
					</thead>
					<tbody>
					 @php($i=1)
                        @foreach($orders as $key=>$order)
                        
                         @php
                         $quantity = App\ordersdetail::where('order_id', $order->id)->sum('quantity');
                $price = App\ordersdetail::where('order_id', $order->id)->sum('totalprice');
                         @endphp
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $order->ordernumber }}</td>
                            <td>{{ $quantity }}</td>
                            <td><?php echo App\Http\Controllers\HomeController::converter($price);?></td>
                            <td>{{ $order->payment }}</td>
                         
                            <td> <form action="{{url('workplace/selected/'.$order->id)}}" method="POST" accept-charset="utf-8">
                              {{csrf_field()}}
                             
                          
                                <select class='form-control orderworkplace' id="{{ $order['orderNumber'] }}" name="workPlacee" required>
                                    <option value=""selected disabled>Select workplace</option>
                                    @if($itemsWorkplaces[$order->ordernumber] > 1)
                                        <option value="{{$itemsWorkplaces[$order->ordernumber]}}"selected disabled>Separate option is selected</option>
                                    @endif
                                    @foreach($getworkplace as $row)
                                    <option value="{{ $row->id }}" {{$itemsWorkplaces[$order->ordernumber] === 1 && $order['workplace_id'] == $row->id ?'selected':'' }}>{{ $row->name }}</option>
                                    @endforeach

                                </select>
                                <button type="submit" class="btn-sm pull-right update" >Update</button>
                                  </form>
                            </td>
                            <td>
                                  
                           
                            @if($order->deliverystatus != 'delivered')
                            <h5  style='padding: 5px; text-align: center'><a @if($order->deliverystatus=='pending') href="{{ URL::to('order/approve',$order->id) }}" @endif class="btn btn-danger">Pending</a></h5>
                            @else
                             <h5  style='padding: 5px; text-align: center'><a @if($order->deliverystatus=='delivered') href="{{ URL::to('order/delivered',$order->id) }} @endif" class="btn btn-success">Delivered</a></h5>
                             @endif
                           
                           
                                
                            </td>
                            <td>{{$order->orderstatus}}</td>
                            <td>{{$order->dateordered}}</td>
                            <td>
                                <a href='{{ URL::to('/customers/ordersdetail',$order->id) }}' class='btn btn-primary'>View</a>
                                <a href='{{ URL::to('/customers/reorder',$order->id) }}' class='btn btn-primary'>Reorder</a>
                                <a href="{{URL::to('/recept/'.$order->ordernumber)}}" class="btn btn-primary" title="">Receipt </a>
                                @if($order->payment=='pending')
                                <a href="{{URL::to('/bank/order/'.$order->ordernumber)}}" class="btn btn-primary" title="">GENERATE SLIP </a>
                                @endif
                            </td>
                        </tr>
                        
                          @endforeach
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
    $('#myTable').DataTable({
       dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});
		// body...
		$('.addworkplace').click(function() {
		val = $('.name').val();
		if (val.length > 0) {
			url = ajaxurl+'addworkplace';
				$.get(
						url,
			      {val: val},
			      function(data) {
			        location.reload();
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
	$('.deliverystatus').change(function () {
            orderid = $(this).attr('id');
            value = $(this).val();
            url = ajaxurl+'deliverystatus';
                $.get(
                        url,
                  {value: value,
                    orderid: orderid},
                  function(data) {
                  });
        })
  
	
</script>
@endsection
















