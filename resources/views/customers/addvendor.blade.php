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


<div class="container" style="margin-bottom: -30px !important;width: 100%;margin: 0">
	<br>
	<ol class="breadcrumb page-breadcrumb">
                    <li><a href="/">Home</a>
                    </li>
                    <li><a href="#">Supplier Research and Selection</a>
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
				<h2>My Vendor Products</h2>	
			</div>
			
			<div>
			<div class="gap gap-small"></div>
		<div class="col-xs-12">
			<label for="categories">Categories</label>
			<select name="categories" class="categories">
            	<option value="all">All Categories</option>
            @foreach($categories as $category)
            	<option value="{{$category->id}}">{{$category->name}}</option>
            @endforeach
        	</select>
			<button class="btn btn-primary searchdata">Search</button>

		</div>
				

			<div class="gap gap-big"></div>

		
			<div class="col-md-12 datavalue" data-gutter="15">
        <h3>Your Vendors</h3>
        <br>
        <table id="myTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>S/N</th>
            <th>Vendor</th>
            <th>Location</th>
            <th>Status</th>
            <th class="text-center">Contact</th>
          </tr>
      </thead>
      <tfoot>
          <tr>
            <th>S/N</th>
            <th>Vendor</th>
            <th>Location</th>
            <th>Status</th>
            <th class="text-center">Contact</th>
          </tr>
      </tfoot>
      <tbody class="data">

          <?php echo $view ?>
        </tbody>
        </tbody>
    </table>
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

    $(document).on('click','.requestuser', function() {
        id = $(this).attr('id');
      url = ajaxurl+'/requestvendor';
        $.get(
          url,
          {id : id},
          function(data) {
            $('.showrequest'+id).html(data);
          });
      })

      $(document).on('click','.requestuserid', function() {
        id = $(this).attr('id');
      url = ajaxurl+'/requestvendorid';
        $.get(
          url,
          {id : id},
          function(data) {
            $('.showrequestid'+id).html(data);
          });
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

  		$('.searchdata').click(function() {
  			categories = $('.categories').val();
  			url = ajaxurl+'/searchvendor';
  			$.get(
					url,
		      {categories: categories},
		      function(data) {
		        $('.data').html(data);
		      });
  		})

      $(document).on('click','.addvendor', function() {
        id = $(this).attr('id');
        url = ajaxurl+'/addcustvendor';
        $.get(
          url,
          {id: id},
          function(data) {
            $('.ven'+id).html(data);
          });
      })
  </script>

@endsection
















