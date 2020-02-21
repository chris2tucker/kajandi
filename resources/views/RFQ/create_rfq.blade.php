@extends('layouts.pagelayout')
@section('content')
<?php 
$categories=App\category::all();

 ?>
<div class="container" style="margin-bottom: -30px !important;width: 100%;margin-right: 20px">
	<br>
	<ol class="breadcrumb page-breadcrumb">
                    <li><a href="{{url('/')}}">Home</a>
                    </li>
                    <li><a href="{{url('/create/rfq')}}">RFQ</a>
                    </li>
                    <li class="active">{{Auth::user()->name}}</li>
                </ol>
                <br>
	<div class="row" style="width: 100%;margin:0">
		
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
          <h4 style="margin-bottom: 40px;">Describe your products and services here for all available certified vendors and sellers to post quotations</h4>
          <div class="row" data-gutter="60">
          	<div class="col-md-12">
          		 @if ($errors->any())
                    @foreach ($errors->all() as $error)
                      <div class="alert alert-danger">
                        <li>{{ $error }}</li>
                      </div>
                    @endforeach
                  @endif
          	</div>
                           <div class="col-md-6">

                        <form method="POST" action="{{ url('/create/rfq') }}" aria-label="{{ __('Register') }}" enctype="multipart/form-data">
                             {{ csrf_field() }}
                      
                            <div class="form-group">
                                <label>Product name</label>
                                <input type="text" class="form-control" name="product_name" value="{{old('product_name')}}"   autofocus required>

                            </div>
                           <div class="form-group">
                                <label>Product category</label>
                                <select name="category" class="form-control" required>
                                  <option value="" disabled selected>Select a Category</option>
                                 @foreach($categories as $category)
                                  <option value="{{$category->id}}">{{$category->name}}</option>
                                  @endforeach
                                </select>
                                
                            </div>
                               <div class="form-group">
                                <label>Product sub-category</label>
                                <select name="subcategory" class="form-control" id="subcats">
                                  <option value="" disabled selected >Select a sub-category</option>
                                 
                                  
                                  
                                </select>
                                
                            </div>
                            <div class="form-group">
                                <label>Duration </label>
                                <input type="text" class="form-control" name="duration" value="{{old('duration')}}"   autofocus>

                            </div>
                            <div class="form-group">
                                <label>Businuss Email</label>
                                <input type="text" class="form-control" name="businuss_email" value="{{old('businuss_email')}}"   autofocus>

                            </div>
                            <div class="form-group">
                                <label>Payment Method</label>
                                <select name="paymentmethod" class="form-control" >
                                  <option value="" disabled selected>Select a Payment Method</option>
                                 
                                  <option value="COD">Cash on delivery</option>
                                  <option value="CIA">Cash in advance</option>
                                  <option value="Cheque">Cheque </option>
                                  <option value="PAA">Pay after acceptence</option>
                                </select>
                                
                            </div>
                            <div class="form-group">
                                <label>file</label>
                                <input type="file" class="form-control" name="file" value="{{old('file')}}"   autofocus>

                            </div>
                          
                             
                             
                    </div>
                    <div class="col-md-6">
                           
                            <div class="form-group">
                                <label>Product Generic Name</label>
                                <input type="text" class="form-control" name="product_generic_name" value="{{old('product_generic_name')}}" required  autofocus>

                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" name="description" rows="5"></textarea>
                                
                            </div>
                            <div class="form-group">
                                <label>Estimated order</label>
                                <input class="form-control" type="text" name="order" value="{{old('order')}}"  />
                            </div>
                            <div class="form-group">
                                <label>Quantity</label>
                                <input class="form-control" type="text" name="quantity" value="{{old('quantity')}}" />
                            </div>
                             <div class="form-group">
                                <label>Units</label>
                                <select name="units" class="form-control" >
                                  <option value="" disabled selected>Select a Unit</option>
                                 @php
                                 $units=App\unit::all();
                                 @endphp
                                 @foreach($units as $unit)
                                  <option value="{{$unit->unit}}">{{$unit->unit}}</option>
                                  @endforeach
                                </select>
                                
                            </div>
                            <div class="form-group">
                                <label style="margin-right: 20px">Product certificate</label>
                                <input type="radio" class="" name="product_certificate"   value="yes">Yes
                                 <input type="radio" class="" name="product_certificate"    value="no" style="margin-left: 20px">No

                            </div>
                            <div class="form-group">
                                <label style="margin-right: 20px">Company certificate</label>
                                <input type="radio"  name="company_certificate"    value="yes">Yes
                                <input type="radio"  name="company_certificate"    value="no" style="margin-left: 20px">No

                            </div>
                            
                             
                    </div>
                    <div class="col-md-12">
                      
                            <!-- <div class="checkbox">
                                <label>
                                    <input class="i-check" type="checkbox" />Sign Up to the Newsletter</label>
                            </div> -->
                         
                                    <input class="btn btn-primary" id="submit" type="submit" value="Save" />
                                    
                                <?php echo Form::close(); ?>
                            </div>
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
<script>
  $(document).ready(function(){
    $('select[name="category"]').change(function(){
     var id=$(this).val();
     $.ajax({
      url:'{{url('category/for/rfq')}}',
      method:'GET',
      data:{category:id},
      dataType:'json',
             error: function(xhr, status, error) {
  console.log(xhr.responseText);
},
    
      success:function(data){
        $("#subcat").remove();
        $("#subcats").html(data);
      }

     });
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