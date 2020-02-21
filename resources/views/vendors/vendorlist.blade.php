@extends('layouts.pagelayout')
@section('content')
<div class="container" style="width: 90%;">
	<header class="page-header">
        <h1 class="page-title">Vendors</h1>
        <ol class="breadcrumb page-breadcrumb">
            <li><a href="{{url('/')}}">Home</a>
            </li>
            <li><a href="{{url('customer/vendors/list')}}">Vendors</a>
            </li>
        </ol>
        <ul class="category-selections clearfix">
           
             <li><span class="category-selections-sign">Sort by :</span>
                <select class="category-selections-select" id="sort">
                  <option @if(Session::has('sortvendors')) @if(Session::get('sortvendors')=='Newest First') selected @endif @else selected @endif >Newest First</option>
                    <option @if(Session::has('sortvendors')) @if(Session::get('sortvendors')=='Professional') selected @endif @endif >Professional</option>
                    <option @if(Session::has('sortvendors')) @if(Session::get('sortvendors')=='Expert') selected @endif @endif>Expert</option>
                    <option @if(Session::has('sortvendors')) @if(Session::get('sortvendors')=='Title : A - Z') selected @endif @endif>Title : A - Z</option>
                    <option @if(Session::has('sortvendors')) @if(Session::get('sortvendors')=='Title : Z - A') selected  @endif @endif>Title : Z - A</option>
                </select>
            </li>
            <li><span class="category-selections-sign">Items :</span>
                <select class="category-selections-select" id="pagination">
                   <option @if(Session::has('pagination')) @if(Session::get('pagination')=='9 / page') selected @endif @else selected @endif >9 / page</option>
                    <option @if(Session::has('pagination')) @if(Session::get('pagination')=='12 / page') selected @endif  @endif>12 / page</option>
                    <option @if(Session::has('pagination')) @if(Session::get('pagination')=='18 / page') selected @endif  @endif>18 / page</option>
                    <option @if(Session::has('pagination')) @if(Session::get('pagination')=='All') selected @endif  @endif>All</option>
                </select>
                </select>
            </li>
        </ul>
    </header>

    <div class="row">
    	<div class="col-md-3">
                    <aside class="category-filters">
                        <div class="category-filters-section">
                            <h3 class="widget-title-sm">Vendors</h3>
                            
                            <input type="hidden" id="category_level" value="category">
                            <ul class="cateogry-filters-list">
                                
                                    <li><a href="#">List</a>
                                </li>
                                
                            </ul>
                        </div>
                            

                        <form>
                             <div class="category-filters-section">
                                <h3 class="widget-title-sm">Categories</h3>
                                <select name="categories" class="form dropdown_filter" style="width: 100%">
                                    <option value="">All</option>
                                    
                                   <?php echo $categories; ?>
                                </select>
                               <!-- <?php  $categories; ?>-->
                            
                             
                            </div>
                           <div class="category-filters-section">
                                <h3 class="widget-title-sm">Subcategories</h3>
                                <select name="subcategories" class="form dropdown_filter" style="width: 100%">
                                    <option value="">All</option>
                                    
                                    <?php echo $subcategories;  ?>
                                </select>
                               <!-- <?php  $subcategories; ?>-->
                            
                             
                            </div>
                            
                            <div class="category-filters-section">
                                <h3 class="widget-title-sm">Location</h3>
                                
                            <?php echo $location; ?>
                            </div>
                            <div class="category-filters-section">
                                <h3 class="widget-title-sm">Supplier Type</h3>
                                <div class='checkbox'>
                                <label>
                                    <input class=' form vender_filter' name='supplier[]' type='checkbox' value='oem' style="position: relative;" />Oem<span class='category-filters-amount'></span>
                                </label>
                            </div>
                            <div class='checkbox'>
                                <label>
                                    <input class=' form vender_filter' name='supplier[]' type='checkbox' value='retailer' style="position: relative;" />Retailer<span class='category-filters-amount'></span>
                                </label>
                            </div>
                             <div class='checkbox'>
                                <label>
                                    <input class=' form vender_filter' name='supplier[]' type='checkbox' value='destributer' style="position: relative;" />distributer<span class='category-filters-amount'></span>
                                </label>
                            </div>
                            </div>
                           
                            
                           
                           
                          
                            
                          
                           
                            
                            

                        </form>
                    </aside>
                </div>
        <div class="col-md-9">
                    <div class="row" id="data" data-gutter="15">
                    @foreach($vendors as $key)
                    @php 
                    $status=App\User::find($key->user_id);
                    @endphp
                    @if($status->status==1)
                        <div class='col-md-4'>
                               
                            <div class='product '>
                                <ul class='product-labels'>
                                    
                                </ul>
                                <div class='product-img-wrap' style="padding: 0;
    margin: 0;
    height: 300px;">
                                    <img class='product-img-primary' src="{{url('/img/products')}}/{{$key->image}}" alt='Image Alternative text' title='Image Title'  />
                                    <img class='product-img-alt' src="{{url('/img/products/')}}/{{$key->image}}" alt='Image Alternative text' title='Image Title' />
                                </div>
                                <a class='product-link' href='{{url('vendors/'.$key->user_id)}}'></a>
                                <div class='product-caption'>
                                    <ul class='product-caption-rating'>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li><i class='fa fa-star'></i>
                                        </li>
                                    </ul>
                                    <h5 class='product-caption-title'>{{$key->vendorname}}</h5>
                                    
                                    <div class='product-caption-price'></div>
                                    <ul class="product-caption-feature-list">
                                       
                                    </ul>
                                    
                                   
                                 </diV>   
                            </div>
                        </div>

<!--/ wrapper -->
@endif
                
                    @endforeach
   
                     {{ $vendors->links() }}
                	</div>

    	</div>
	</div>
</div>
<script>
    $(document).ready(function(){
        $('.vender_filter').click(function() {
        
    val = $('.form').serialize();
   
   
        url = ajaxurl+'vendorsearch'
    
    
    
    $('body').addClass('overlay');
    $.get(
      url,
      {val : val,
        
      },
      function(data) {
    $('body').removeClass('overlay');
        $('#data').html(data);
      });
});
        $('.dropdown_filter').change(function() {
        
    val = $('.form').serialize();
   
   
        url = ajaxurl+'vendorsearch'
    
    
    
    $('body').addClass('overlay');
    $.get(
      url,
      {val : val,
        
      },
      function(data) {
    $('body').removeClass('overlay');
        $('#data').html(data);
      });
});
    })
</script>
<script>
    $(document).ready(function(){
        var id=$("#sort").change(function(){
            
            var value=$(this).val();
         $.ajax({
                     url:"{{ url('set/sortby/vendor') }}",
                     method:'GET',
                     data:{id:value},
                     dataType:'json',
                              error: function(xhr, status, error) {
  console.log(xhr.responseText);
},
                     success:function(data){
                        location.reload();
                    }
                    });
        });
          var id=$("#pagination").change(function(){
            
            var value=$(this).val();
         $.ajax({
                     url:"{{ url('set/pagination') }}",
                     method:'GET',
                     data:{id:value},
                     dataType:'json',
                              error: function(xhr, status, error) {
  console.log(xhr.responseText);
},
                     success:function(data){
                        location.reload();
                    }
                    });
        });
    })
</script>
@endsection