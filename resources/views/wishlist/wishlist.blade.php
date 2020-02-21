@extends('layouts.pagelayout')
@section('content')
<script type="text/javascript">
$(document).ready(function() {
$(".open").on("click", function(){
    var id = $(this).attr('id');
  $("#popup_"+id).addClass("active");
  $("#popup_overlay_"+id).addClass("active");
});

//removes the "active" class to .popup and .popup-content when the "Close" button is clicked 
$(".close").on("click", function(){
    var id = $(this).attr('id');

  $("#popup_"+id).removeClass("active");
  $("#popup_overlay_"+id).removeClass("active");
});

$('.quick_acces_add_to_cart').on('click', function () {
    productid = $(this).attr('id');
  productqty = $("#qty"+productid).val();
  paymentid = $('input:radio.payment:checked').val();
 // $("#radio1").prop("checked", true);
  //price = $('.price_product').val();
  price = $("input[name='price']:checked").val()
  //alert(price);
    var cart = $('.fa.fa-shopping-cart');
    var imgtodrag = $(this).parent('.item').find("img").eq(0);
  url = ajaxurl+'addvendorproduct';
   $.get(
      url,
      { paymentid : paymentid,
        productid: productid,
        productqty: productqty,
        price:price},
      function(data) {
       

        console.log(imgtodrag);
        if (imgtodrag) {
            var imgclone = imgtodrag.clone()
                .offset({
                top: imgtodrag.offset().top,
                left: imgtodrag.offset().left
            })
                .css({
                'opacity': '0.5',
                    'position': 'absolute',
                    'height': '150px',
                    'width': '150px',
                    'z-index': '9999',
                    'bottom':'0',
                    'left':'0',
                    'right':'0',
                    'top':'0'
                    
            })
                .appendTo($('body'))
                .animate({
                'top': cart.offset().top + 10,
                    'left': cart.offset().left + 10,
                    'width': 75,
                    'height': 75
            }, 1000, 'easeInOutExpo');
            
            setTimeout(function () {
                cart.effect("shake", {
                    times: 2
                }, 200);
            }, 1500);

            imgclone.animate({
                'width': 0,
                    'height': 0
            }, function () {
                $(this).detach()
            });
        }
$("#product_view_"+productid).modal('hide');

        
      });
        
    });


$(document).on('click','.requestuserid', function() {
        id = $(this).attr('id');
      url = ajaxurl+'/requestvendorid';
        $.get(
          url,
          {id : id},
          function(data) {
            $('.show').html(data);
          });
      })

});
</script>
<div class="container" style="width: 90%;">
    <header class="page-header">
        <h1 class="page-title">Wishlist</h1>
        <ol class="breadcrumb page-breadcrumb">
            <li><a href="{{url('/')}}">Home</a>
            </li>
            <li><a href="{{url('wishlist')}}">WishList</a>
            </li>
        </ol>
        <ul class="category-selections clearfix">
           
            <li><span class="category-selections-sign">Sort by :</span>
                <select class="category-selections-select" id="sort">
                    
                    <option @if(Session::has('sortby')) @if(Session::get('sortby')=='Newest First') selected @endif @else selected @endif >Newest First</option>
                    <option @if(Session::has('sortby')) @if(Session::get('sortby')=='Price : Lowest First') selected @endif @endif >Price : Lowest First</option>
                    <option @if(Session::has('sortby')) @if(Session::get('sortby')=='Price : Highest First') selected @endif @endif>Price : Highest First</option>
                    <option @if(Session::has('sortby')) @if(Session::get('sortby')=='Title : A - Z') selected @endif @endif>Title : A - Z</option>
                    <option @if(Session::has('sortby')) @if(Session::get('sortby')=='Title : Z - A') selected  @endif @endif>Title : Z - A</option>
                </select>
            </li>
            <li><span class="category-selections-sign">Items :</span>
                <select class="category-selections-select" id="pagination">
                    
                     <option @if(Session::has('pagination')) @if(Session::get('pagination')=='9 / page') selected @endif @else selected @endif >9 / page</option>
                    <option @if(Session::has('pagination')) @if(Session::get('pagination')=='12 / page') selected @endif  @endif>12 / page</option>
                    <option @if(Session::has('pagination')) @if(Session::get('pagination')=='18 / page') selected @endif  @endif>18 / page</option>
                    <option @if(Session::has('pagination')) @if(Session::get('pagination')=='All') selected @endif  @endif>All</option>
                </select>
            </li>
        </ul>
    </header>

    <div class="row">
        
        <div class="col-md-9">
                    <div class="row" id="data" data-gutter="15">
                    @foreach($getproducts as $key)
                    <?php
                     $products = DB::table('products')->where('id', $key->product_id)->first();
                      $condition=DB::table('condition')->where('id',$key->condition_id)->first();
                      $reviewCount=DB::table('review')->where('product_id','=',$key->product_id)->count();
                      $reviews=DB::table('review')->where('product_id','=',$key->product_id)->sum('rating');
                      if($reviewCount>0){
                      $ratingss=(int)($reviews/$reviewCount);
                    }
                    else{
                      $ratingss=0;
                    }
                     if(!empty($key->image)){
                            $image = $key->image;
                        }
                        else{
                            $image = $products->image;
                        }
                     ?>
                        <div class='col-md-4'>
                            @php
                            $instance='Not Listed';
                            $within15days='Not Listed';
                            $within30days='Not Listed';
                                    if(Session::has('currency')){
                                    $getPrice=App\currency::find(1);
                                    if(Session::get('currency')=='Dollar'){
                                    $price="$ ".$key->price*$getPrice->Dollar;
                                    if($key->instant_price){
                                    $instance="$ ".$key->instant_price*$getPrice->Dollar;
                                    }
                                    if($key->pricewithin15days){
                                    $within15days="$ ".$key->pricewithin15days*$getPrice->Dollar;
                                    }
                                    if($key->pricewithin30days){
                                    $within30days="$ ".$key->pricewithin30days*$getPrice->Dollar;
                                    }
                                    }
                                    else if(Session::get('currency')=='Yen'){
                                    $price="¥ ".$key->price*$getPrice->Yen;
                                     if($key->instant_price){
                                    $instance="¥ ".$key->instant_price*$getPrice->Yen;
                                    }
                                    if($key->pricewithin15days){
                                    $within15days="¥ ".$key->pricewithin15days*$getPrice->Yen;
                                    }
                                    if($key->pricewithin30days){
                                    $within30days="¥ ".$key->pricewithin30days*$getPrice->Yen;
                                    }
                                }
                                else if(Session::get('currency')=='Euro'){
                                $price="€ ".$key->price*$getPrice->Euro;
                                 if($key->instant_price){
                                    $instance="€ ".$key->instant_price*$getPrice->Euro;
                                    }
                                    if($key->pricewithin15days){
                                    $within15days="€ ".$key->pricewithin15days*$getPrice->Euro;
                                    }
                                    if($key->pricewithin30days){
                                    $within30days="€ ".$key->pricewithin30days*$getPrice->Euro;
                                    }
                            }
                            else{
                            $price="₦ ".$key->price;
                             if($key->instant_price){
                                    $instance="₦ ".$key->instant_price;
                                    }
                                    if($key->pricewithin15days){
                                    $within15days="₦ ".$key->pricewithin15days;
                                    }
                                    if($key->pricewithin30days){
                                    $within30days="₦ ".$key->pricewithin30days;
                                    }
                        }
                                    }
                                    else{
                                     $price="₦ ".$key->price;
                                      if($key->instant_price){
                                    $instance="₦ ".$key->instant_price;
                                    }
                                    if($key->pricewithin15days){
                                    $within15days="₦ ".$key->pricewithin15days;
                                    }
                                    if($key->pricewithin30days){
                                    $within30days="₦ ".$key->pricewithin30days;
                                    }
                                }
                                $category=App\category::find($key->category);
                               $modal=App\productmodel::find($key->model_id);
                               $manufactoror=App\productmanufacturer::find($key->manufacturer_id);
                               
                              
                           $source='Not Listed';
                           if($key->source_id){
                           $sources=App\source::find($key->source_id);
                           $source=$sources->name;
                       }
                       $condition='Not Listed';
                       if($key->condition_id){
                       $con=App\condition::find($key->condition_id);
                       $condition=$con->name;
                   }
                   $vendorspro=App\vendorproduct::where('product_id','=',$key->product_id)->first();

                   $vendor=App\vendors::where('user_id','=',$vendorspro->user_id)->first();

                        $modalName = $modal ? $modal->name : '';
                        $manufactororName = $manufactoror ? $manufactoror->name : '';
                                    @endphp
                               
                            <div class='product 'data-title="{{$key->id}}" data-id="{{$key->name}}" data-category="{{$category->name}}" data-model="{{$modalName}}" data-manufactoror="{{$manufactororName}}" data-instance="{{App\Http\Controllers\HomeController::converter($key->instant_price)}}" data-within15="{{App\Http\Controllers\HomeController::converter($key->pricewithin15days)}}" data-within30="{{App\Http\Controllers\HomeController::converter($key->pricewithin30days)}}"
                            data-source="{{$source}}" data-price="{{App\Http\Controllers\HomeController::converter($key->price)}}" data-condition="{{$condition}}" data-vendor="{{$vendor->vendorname}}" data-location="{{$vendor->country}}" data-model="{{$key->model_number}}" data-serial="{{$key->serial_number}}">
                                <ul class='product-labels'>
                                    
                                </ul>
                                <div class='product-img-wrap'>
                                    <img class='product-img-primary' src="{{url('/')}}/{{$image}}" alt='Image Alternative text' title='Image Title' style='height: 250px' />
                                    <img class='product-img-alt' src="{{url('/')}}/{{$image}}" alt='Image Alternative text' title='Image Title' style='height: 250px' />
                                </div>
                                <a class='product-link' href='{{url('product/'.$key->slog)}}'></a>
                                <div class='product-caption'>
                                    <ul class='product-caption-rating'>
                                      @if($ratingss>0)
                                      @if($ratingss==1)
                                       <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li><i class='fa fa-star'></i>
                                        </li>
                                      @elseif($ratingss==2)
                                       <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li><i class='fa fa-star'></i>
                                        </li>
                                      @elseif($ratingss==3)
                                       <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li><i class='fa fa-star'></i>
                                        </li>
                                      @elseif($ratingss=4)
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
                                      @else
                                       <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class="rated"><i class='fa fa-star'></i>
                                        </li>
                                      @endif
                                       @else
                                        <li class=''><i class='fa fa-star'></i>
                                        </li>
                                        <li class=''><i class='fa fa-star'></i>
                                        </li>
                                        <li class=''><i class='fa fa-star'></i>
                                        </li>
                                        <li class=''><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        @endif
                                    </ul>
                                    <h5 class='product-caption-title'>{{$key->name}}<strong style="font-size: 10px;">({{$condition}})</strong></h5>
                                    
                                    <div class='product-caption-price'><span class='product-caption-price-new'>{{App\Http\Controllers\HomeController::converter($key->price)}}</span> @php
                                       $isPayonDeliveryAvailable=App\PaymentDeliveryInformation::where('product_id','=',$key->product_id)->first();
                                        @endphp
                                        @if($isPayonDeliveryAvailable->payment_mehod =='COD')
                                        <h8>(Pay on Delivery {{$key->payondelivery}})</h8>
                                        @endif</div>
                                    <ul class="product-caption-feature-list">
                                       
                                    </ul>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#product_view_{{$key->product_id}}"><i class="fa fa-search"></i> Quick View</button>
                                    <a class="btn btn-info  addToCompare" style="position: absolute; right: 0;top: 70%;">Compare</a>
                                 </diV>   
                            </div>
                        </div>

<!--/ wrapper -->

                <div class="modal fade product_view" id="product_view_{{$key->product_id}}">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <a href="#" data-dismiss="modal" class="class pull-right"><span class="glyphicon glyphicon-remove"></span></a>
                                <h3 class="modal-title"> Quick View</h3>
                            </div>
                            <div class="modal-body">
                             
                                <div class="row ">
                                    <div class="col-md-6 product_img ">
                                        <?php 
                                           $product_image = DB::table('product_image')->where('product_id',$key->product_id)->first();
                                         ?>
                                            <div class="product-page-product-wrap jqzoom-stage items">
                                                
                                                <div class="clearfix ">
                                                    

                                                    <a href="{{url('/')}}/{{$product_image->image_1}}" class="jqzoom " data-rel="gal-{{$key->id}}">
                                                        <img src="{{url('/')}}/{{$product_image->image_1}}" alt="item"  />
                                                    </a>
                                                     
                                                </div>
                                            </div>
                                            <ul class="jqzoom-list">
                                                <li>
                                                    <a class="zoomThumbActive" href="javascript:void(0)" data-rel="{gallery:'gal-{{$key->id}}', smallimage: '{{url('/')}}/{{$product_image->image_1}}', largeimage: '{{url('/')}}/{{$product_image->image_1}}'}">
                                                        <img src="{{url('/')}}/{{$product_image->image_1}}" alt="Image Alternative text" title="Image Title" />
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)" data-rel="{gallery:'gal-{{$key->id}}', smallimage: '{{url('/')}}/{{$product_image->image_2}}', largeimage: '{{url('/')}}/{{$product_image->image_2}}'}">
                                                        <img src="{{url('/')}}/{{$product_image->image_2}}" alt="Image Alternative text" title="Image Title" />
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)" data-rel="{gallery:'gal-{{$key->id}}', smallimage: '{{url('/')}}/{{$product_image->image_3}}', largeimage: '{{url('/')}}/{{$product_image->image_3}}'}">
                                                        <img src="{{url('/')}}/{{$product_image->image_3}}" alt="Image Alternative text" title="Image Title" />
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)" data-rel="{gallery:'gal-{{$key->id}}', smallimage: '{{url('/')}}/{{$product_image->image_4}}', largeimage: '{{url('/')}}/{{$product_image->image_4}}'}">
                                                        <img src="{{url('/')}}/{{$product_image->image_4}}" alt="Image Alternative text" title="Image Title" />
                                                    </a>
                                                </li>
                                            </ul>
                                    </div>

                                    <div class="col-md-6 product_content">
        
                                        <h4>{{$key->name}}</h4>
                                        <?php 
                                        $vendorspro=App\vendorproduct::where('product_id','=',$key->product_id)->first();

                                            $vendor = DB::table('vendors')->where('user_id',$vendorspro->user_id)->first();
                                         ?>
                                         <p>Vendor Name: {{$vendor->vendorname}} </p>
                                         <p style="">Vendor Type: {{$vendor->vendor_type}} </p>
                                         <p style="">Location: {{$vendor->location}} , {{$vendor->state}} </p>

                                        <p>Model Number: {{$key->model_number}} </p>
                                         <p style="">Serial Number: {{$key->serial_number}} </p>
                                        <h5><input type="radio" name="payment{{$key->id}}" class='payment' id="radio1" value="1" checked > {{App\Http\Controllers\HomeController::converter($key->price )}} -Instant Price</h5>
                                         
                                         <?php 
                                         if (Auth::check()) {

                                            $getcustomersvendoreaccess = DB::table('customersverification')->where('user_id', Auth::user()->id)->where('verification', 'yes')->first();

                                         if ($getcustomersvendoreaccess) {
                                            $customersvendor = DB::table('customersvendor')->where('customer_id', Auth::user()->id)->where('vendor_id',$vendor->user_id)->where('status', 'yes')->first();

                                         if ($customersvendor) {
                                            $outstandingpayment = DB::table('outstandingpayment')->where('user_id', Auth::user()->id)->where('payment', 'pending')->where('duedate','<',carbon\carbon::today()->toDateString())->sum('totalprice');
                                            $limit = DB::table('outstandingpayment')->where('user_id', Auth::user()->id)->where('payment', 'pending')->where('duedate','>',carbon\carbon::today()->toDateString())->sum('totalprice');
                                            
                                            if ($outstandingpayment>0 || $limit>=$customersvendor->limitted) {
                                         ?>
                                                <h5><s><input type="radio" name="payment" class='payment' value="2"  disabled> {{App\Http\Controllers\HomeController::converter($key->pricewithin15days)}}</s> -Pay in 15 days</h5>
                                                <h5><s><input type="radio" name="payment" class='payment' value="3"  disabled> {{App\Http\Controllers\HomeController::converter($key->pricewithin30days)}}</s> -Pay in 30 days</h5>

                                            <?php
                                            }else{?>

                                                <h5><input type="radio" name="payment{{$key->id}}" class='payment' value="2" > {{App\Http\Controllers\HomeController::converter($key->pricewithin15days)}} -Pay in 15 days</h5>
                                                <h5><input type="radio" name="payment{{$key->id}}" class='payment' value="3"> {{App\Http\Controllers\HomeController::converter($key->pricewithin30days)}} -Pay in 30 days</h5>

                                           <?php }

                                          }else{?>

                                            <h5><s><input type="radio" name="payment" class='payment' value="2"  disabled> {{App\Http\Controllers\HomeController::converter($key->pricewithin15days)}}</s> - 15 days</h5>
                                                <h5><s><input type="radio" name="payment" class='payment' value="3"  disabled> {{App\Http\Controllers\HomeController::converter($key->pricewithin30days)}}</s> -Pay in 30 days</h5>
                                         <?php }
                                         }else{?>
                                            <h5><s><input type="radio" name="payment" class='payment' value="2"  disabled> {{App\Http\Controllers\HomeController::converter($key->pricewithin15days)}}</s> -Pay in 15 days</h5>
                                                <h5><s><input type="radio" name="payment" class='payment' value="3"  disabled> {{App\Http\Controllers\HomeController::converter($key->pricewithin30days)}}</s> -Pay in 30 days</h5>

                                       <?php  }

                                        }?>
                                        <?php
                                                $PaymentDeliveryInformation=App\PaymentDeliveryInformation::where('product_id','=',$key->product_id)->first();
                                                if($key->stock_count>$PaymentDeliveryInformation->minimum_order_quantity){
                                                    $max=$key->stock_count;
                                                }
                                                else{
                                                    $max=$PaymentDeliveryInformation->minimum_order_quantity;
                                                }

                                                  ?>
                                         @if($key->stock_count > 1 && $key->stock_count>$PaymentDeliveryInformation->minimum_order_quantity)
                                                <span style="color:green;">In Stock</span>
                                          @else
                                                <span style="color:red;">Out of Stock</span>
                                          @endif
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <ul class="product-page-actions-list">
                                                   <li class="product-page-qty-item">
                                                <button class="product-page-qty product-page-qty-minus">-</button>
                                                
                                                <input class="product-page-qty product-page-qty-input productqty" id="qty{{$key->product_id}}" type="number" value="{{$PaymentDeliveryInformation->minimum_order_quantity}}" size="1" maxlength="2" max="{{$max}}" min="{{$PaymentDeliveryInformation->minimum_order_quantity}}" onkeydown="return false">
                                                <button class="product-page-qty product-page-qty-plus">+</button>
                                                    </li> 
                                                </ul>
                                            </div>
                                            <?php
                                            if(Auth::user())
                                            {
                                              $getwishlist = DB::table('wishlist')->where('user_id', Auth::user()->id)->where('product_id', $key->product_id)->first();  
                                            } 
                                            

                                            
                                            ?>
                                             
                                        
                                            <!-- end col -->
                                            
                                            <!-- end col -->
                                        </div>
                                        <div class="space-ten"></div>
                                        <br>
                                        <div class="btn-ground item">
                                            <img src="{{url('/')}}/{{$product_image->image_1}}" alt="item"  class="image_pop" style="display: none;" />
                                            @if($key->stock_count > 1)
                                            
                                            <button type="button" class="btn btn-primary quick_acces_add_to_cart" id="{{$key->product_id}}"><span class="glyphicon glyphicon-shopping-cart"></span> Add To Cart</button>

                                            @else
                                            
                                            <button type="button" class="btn btn-primary" id="{{$key->product_id}}"><span class="glyphicon glyphicon-shopping-cart" disabled></span> Add To Cart</button>
                                            @endif
                                            <?php if (Auth::check()) {
                                                if ($getwishlist) {
                                                ?>
                                                    <button type="button" class="btn btn-primary wishlistadd" id="<?php echo $key->id ?>"><span class="glyphicon glyphicon-heart"></span> Add To Wishlist</button>
                                               <?php
                                                }else{
                                                    ?>
                                                    <button type="button" class="btn btn-primary wishlist" id="<?php echo $key->id ?>"><span class="glyphicon glyphicon-heart"></span> Add To Wishlist</button>
                                                   <br>
                                                <?php
                                                }
                                                ?>
                                                    
                                                <?php }
                                                 ?>
                                                  <br>
                                                  <br>
                                            <?php 
                                            if(Auth::check()){
                                                $customersvendor = DB::table('customersvendor')->where('customer_id', Auth::user()->id)->where('vendor_id', $key->user_id)->first();
                                            }
                                                if (!empty($customersvendor)) {
                                                        if ($customersvendor->status == 'yes') {?>
                                                         <p class='bg-primary text-center' style='padding: 3px;'>Contacted</p>
                                                   <?php }elseif ($customersvendor->verification == 'pending') {?>
                                                        <p class='bg-success text-center' style='padding: 3px;'>Pending</p>
                                                    <?php }
                                                    else{ ?>
                                                    <button class='btn btn-primary btn-sm requestuseidr' id="$key->id">Request Invitation</button>
                                                   <?php }
                                                }else{?>
                                                 <div class="show">
                                                   <button type="button" class="btn btn-primary requestuserid" id="<?php echo $key->id  ?>"><span class="glyphicon glyphicon-heart"></span> Request to Vendor</button>
                                                 </div>
                                              <?php  }
                                            ?>
                                         
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                        
                    @endforeach
   
                 
                    </div>

        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        var id=$("#sort").change(function(){
            
            var value=$(this).val();
         $.ajax({
                     url:"{{ url('set/sortby') }}",
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