@extends('layouts.pagelayout')
@section('content')

<script src="/js/paginathing.js"></script>
    
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

<div class="mfp-with-anim  mfp-hide mfp-dialog2 clearfix" id="workplace-dialog">
            <h3 class="widget-title">Add Vendors</h3>
            <hr />
                <div class="form-group">
                	<div class="col-xs-6">
                		<select name="vendor" class="form-control vendor_id">
	                    	<option value="">Select Vendor</option>
	                    @foreach($vendors as $vendor)
	                    	<option value="{{$vendor->user_id}}">{{$vendor->vendorname}}</option>
	                    @endforeach
                    	</select>
                	</div>
                	<div class="col-xs-4">
                		<input class="btn btn-primary addcustvendor" type="submit" class="sendreq" value="Send Request" />
                	</div>
                    
                <br>
                <div class="col-md-12 vendoradd" style="display: none;">
                	<p class="alert alert-danger" >
                        Request Sent Successfully
                    </p>
                </div>
                    
                </div>
            
            <div class="gap gap-small"></div>
            <div class="gap gap-small"></div>
            <table class="table">
            	<tr>
            		<th>S/N</th>
            		<th>Vendor</th>
            		<th>Status</th>
            	</tr>
            	<?php echo $getcustomersvendor ?>
            </table>
            <div class="gap gap-small"></div>
        </div>

<div class="container" style="margin-bottom: -30px !important;width: 100%;margin: 0">
	<br>
	<ol class="breadcrumb page-breadcrumb">
                    <li><a href="{{url('/')}}">Home</a>
                    </li>
                    <li><a href="{{url('customers/addsupplier')}}">Supplier Research and Selection</a>
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
		<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 box">
			<div class="pull-left">
				<h2>Supplier Research and Selection</h2>	
			</div>
			
			
			<div>
			<div class="gap gap-small"></div>
		<div class="col-xs-12">
			<label for="vendors">Vendors</label>
			<select name="vendors" class="vendors">
			<!--	<option value="all">All vendors</option>-->
				<?php echo $getvendors ?>
			</select>
			<label for="categories">Categories</label>
			<select name="categories" class="categories" style="width: 200px">
            	<option value="all">All Categories</option>
            @foreach($categories as $category)
            	<option value="{{$category->id}}">{{$category->name}}</option>
            @endforeach
        	</select>
			<label for="subcategories">Sub Categories</label>
			<select name="subcategories" class="subcategories" style="width: 150px">
            	<option value="all">All Categories</option>
        	</select>
          <input type="text" name="product" placeholder="search product" class="product" style="height: 30px;">
			<button class="btn btn-primary searchdata">Search</button>
      <button class="btn btn-primary " onclick="location.reload();">reset</button>

		</div>
				

			<div class="gap gap-big"></div>

		
			<div class="col-md-12 datavalue" data-gutter="15">
                <?php echo $view; ?>
            </div>



		</div>
			
		</div>
	</div>
</div>
@endsection
@section('script')
</script>
<script type="text/javascript">
	$(document).ready(function(){
    $('#myTable').DataTable();
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

  		$('.daterange').click(function() {
  			from = $( "#from" ).val();
  			to = $( "#to" ).val();

  			if (from.length > 0 && to.length > 0) {
  				url = ajaxurl+'/getreportdate';
				$.get(
						url,
			      {from: from,
			      	to: to},
			      function(data) {
			        $('.data').html(data);
			      });
  			}
  		})
  		$('.addcustvendor').click(function() {
  			// body...
  			vendor = $('.vendor_id').val();
  			if (vendor.length > 0) {
  				url = ajaxurl+'/addcustomersvendor';
  			$.get(
					url,
		      {vendor: vendor},
		      function(data) {
		        $('.vendoradd').show();
		      });
  			}
  			
  		})
  		$('.searchdata').click(function() {
  			vendors = $('.vendors').val();
  			categories = $('.categories').val();
  			subcategories = $('.subcategories').val();
        product=$('.product').val();
  			url = ajaxurl+'/searchdata';
  			$.get(
					url,
		      {vendors: vendors,
		      categories: categories,
		  		subcategories: subcategories,
          products:product},
		      function(data) {
		        $('.datavalue').html(data);
		      });
  		})

      $('.vendors').change(function() {
        vendor = $(this).val();
        url = ajaxurl+'/getcategory';
        $.get(
          url,
           {vendor: vendor},
          function(data) {
            $('.categories').html(data);
          });
      })
      $('.categories').change(function() {
        category = $(this).val();
        url = ajaxurl+'/getsubcategory';
        $.get(
          url,
           {category: category},
          function(data) {
            $('.subcategories').html(data);
          });
      })
  </script>

@endsection
















