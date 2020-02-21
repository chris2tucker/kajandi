<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<h1>Kajandi Limitted</h1>
<?php  
$order=App\ordersdetail::where('ordernumber','=',$ordernumber)->get();
?>
@foreach($order as $ord)
<table>
	
	<thead>
		<tr>
			<th>Product Name</th>
			<th>Order Number</th>
			<th>Total Price</th>
			<th>Quantity</th>
			<th>Ecommerace name</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			@php
			$product=App\products::find($ord->product_id);
			@endphp
			<td>{{$product->name}}</td>
			<td>{{$ord->ordernumber}}</td>
			<td>{{$ord->totalprice}}</td>
			<td>{{$ord->quantity}}</td>
			<td>Kajandi Limitted</td>

		</tr>
	</tbody>
</table>
@endforeach
</body>
</html>