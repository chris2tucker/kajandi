@extends('layouts.pagelayout')
@section('content')
<style>
  .heading_color{
    color:#486d97;
  }
  
</style>
<script>
$(document).ready(function(){
   $(document).on('click','#btn-more',function(){
       var id = $(this).data('id');
       var product_id= $('.product_id').val();

       $("#btn-more").html("Loading....");
       $.ajax({
           url : '{{ url("more/loaddata") }}',
           method : "POST",
           data : {id:id,product_id:product_id, _token:"{{csrf_token()}}"},
           dataType : "text",
           success : function (data)
           {
              if(data != '') 
              {
                  $('#remove-row').remove();
                  $('#load-data').append(data);
              }
              else
              {
                  $('#btn-more').html("No More Questions");
              }
           }
       });
   });

   $(document).on('click','#ask',function(){
       var question = $('.question').val();
       var product_id = $('.product_id').val();

    
       if(question != '')
            {
                questions =question;
            }else{

                alert('Question field is Empty');
            }
       
       $.ajax({
           url : '{{ url("save_q_a") }}',
           method : "POST",
           data : {question:questions,product_id:product_id, _token:"{{csrf_token()}}"},
           dataType : "text",
           success : function (data)
           {
            var obj = jQuery.parseJSON( data );
            var html ='<article class="product-page-qa"><div class="product-page-qa-question"><p class="product-page-qa-text">'+obj.question+'?</p><p class="product-page-qa-meta">asked by '+obj.user_name+' on '+obj.created_at+'</p></div></article>';
              
              $('#load-data').html(html);

           }
       });
   });

}); 
</script>

<link href="{{URL::asset('/css/star-rating.min.css') }}" media="all" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('/themes/krajee-svg/theme.css') }}" media="all" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('/themes/krajee-fa/theme.css') }}" media="all" rel="stylesheet" type="text/css" />

@php
$slog=App\vendorproduct::where('product_id','=',$products->id)->first();
$condition=App\condition::find($vendor_product->condition_id);
@endphp

<div class="container" style="width: 90%;">
            <header class="page-header">
                <h1 class="page-title">{{$products->name}}<small style="font-size:30%;" class="{{$condition->name != 'New' ? 'text-danger' : '' }}">({{$condition->name}})</small></h1>
                <ol class="breadcrumb page-breadcrumb">
                    <li><a href="{{url('/')}}">Home</a>
                    </li>
                    <li><a href="{{url('category/'.$category->slog)}}">{{$category->name}}</a>
                    </li>
                    <li><a href="{{url('subcategory/'.$subcategory->slog)}}">{{$subcategory->name}}</a>
                    </li>
                    <li><a href="{{url('product/'.$slog->slog)}}">{{$products->name}}</a>
                    </li>
                </ol>
            </header>
            <div class="row">
                <div class="col-md-5">
                    <div class="product-page-product-wrap jqzoom-stage">
                        <div class="clearfix">
                            <a href="{{url('/')}}/{{$product_image->image_1}}" id="jqzoom" data-rel="gal-1">
                                <img src="{{url('/')}}/{{$product_image->image_1}}" alt="Image Alternative text" title="Image Title" />
                            </a>
                        </div>
                    </div>
                    <ul class="jqzoom-list">
                        <li>
                            <a class="zoomThumbActive" href="javascript:void(0)" data-rel="{gallery:'gal-1', smallimage: '{{url('/')}}/{{$product_image->image_1}}', largeimage: '{{url('/')}}/{{$product_image->image_1}}'}">
                                <img src="{{url('/')}}/{{$product_image->image_1}}" alt="Image Alternative text" title="Image Title" />
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" data-rel="{gallery:'gal-1', smallimage: '{{url('/')}}/{{$product_image->image_2}}', largeimage: '{{url('/')}}/{{$product_image->image_2}}'}">
                                <img src="{{url('/')}}/{{$product_image->image_2}}" alt="Image Alternative text" title="Image Title" />
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" data-rel="{gallery:'gal-1', smallimage: '{{url('/')}}/{{$product_image->image_3}}', largeimage: '{{url('/')}}/{{$product_image->image_3}}'}">
                                <img src="{{url('/')}}/{{$product_image->image_3}}" alt="Image Alternative text" title="Image Title" />
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" data-rel="{gallery:'gal-1', smallimage: '{{url('/')}}/{{$product_image->image_4}}', largeimage: '{{url('/')}}/{{$product_image->image_4}}'}">
                                <img src="{{url('/')}}/{{$product_image->image_4}}" alt="Image Alternative text" title="Image Title" />
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-md-7">
                    <div class="row" data-gutter="10">
                        <div class="col-md-8">
                            <div class="box">
                                <div class="row">
                                    <div class="col-md-6">
                                        <span class="text-info">
                                            {{App\vendors::where('user_id',$vendorname->id)->first()->location}}, {{App\vendors::where('user_id',$vendorname->id)->first()->state}}
                                        </span>
                                    <?php
                                if ($reviewcount) {
                                    ?>
                                    <input class="input-3" name="input-3" value="{{$totalreview}}" class="rating-loading" data-size="xs">
                                    <p class="product-page-product-rating-sign">{{$reviewcount}} customer reviews</p>
                                    <?php
                                }
                                ?>
                                </div>
                                <div class="col-md-6 pull-right">
                                    <h6 class="pull-right">Sold by <a href="{{url('vendors/'.$vendorname->id)}}"><?php echo $vendorname->name; ?></a></h6>
                                </div>
                                </div>
                                
                               
                                
                                
                                <p class="product-page-desc">{{ $products->description }}</p>
                                <table
                                class="table table-striped product-page-features-table">
                                    <tbody>
                                        <tr>
                                            <td style="width: 40%;" class="heading_color">Generic Name:</td>
                                            <td>{{$vendor_product->product_generic_name}}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 40%;" class="heading_color">Manufacturer:</td>
                                            <td>@if($productmanufacturer){{$productmanufacturer->name}} @else NaN @endif</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 40%;" class="heading_color">Model:</td>
                                            <td> @if($productmodel){{$productmodel->name}} @else NaN @endif</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 40%;" class="heading_color">Availability:</td>
                                            <td>{{$getproducts->availability}}</td>
                                        </tr>
                                         <tr>
                                            <td style="width: 40%;" class="heading_color">Description:</td>
                                           @if(str_word_count($vendor_product->description)>10)
                                            <td id="half">{{substr($vendor_product->description,40)}} <a style="cursor: pointer;" id="readbutton">Read More</a></td>
                                            @else
                                            <td>{!! nl2br(e($vendor_product->description)) !!}</td>
                                            @endif
                                            <td id="full" style="display: none">{!! nl2br(e($vendor_product->description)) !!}
                                                <a style="cursor: pointer;" id="lessbutton">Read Less</a>
                                            </td>
                                        </tr>
                                        <script>
                                            $(document).ready(function(){
                                                $("#readbutton").click(function(){
                                                    $("#half").hide();
                                                    $("#full").show();
                                                })
                                                $("#lessbutton").click(function(){
                                                    $("#half").show();
                                                    $("#full").hide();
                                                })
                                            })
                                        </script>
                                        <tr>
                                            <td style="width: 40%;" class="heading_color">Supply Type:</td>
                                            <td>{{$vendor_product->supplyType}}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 40%;" class="heading_color">Color:</td>
                                            <td>{{$vendor_product->color}}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 40%;" class="heading_color">Unit Of Measure:</td>
                                            <td>{{$vendor_product->unit_of_measure }}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 40%;" class="heading_color">Minimum Order:</td>
                                            <td>{{$vendor_product->minimum_order_quantity }}</td>
                                        </tr>
                                        <!--<tr>
                                            <td>Optional Price:</td>
                                            <td>{{$vendor_product->price_for_optional_unit }}</td>
                                        </tr>-->
                                        <tr>
                                            <td style="width: 40%;" class="heading_color">Instant Price:</td>
                                            <td>{{App\Http\Controllers\HomeController::converter($vendor_product->instant_price) }}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 40%;" class="heading_color">15 Days Price:</td>
                                            <td>{{App\Http\Controllers\HomeController::converter($vendor_product->pricewithin15days)}}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 40%;" class="heading_color">30 Days Price:</td>
                                            <td>{{App\Http\Controllers\HomeController::converter($vendor_product->pricewithin30days)}}</td>
                                        </tr>
                                         <tr>
                                            <td style="width: 40%;" class="heading_color">Weight Per Pack:</td>
                                            <td>{{$vendor_product->weight_per_packging }}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 40%;" class="heading_color">Other Information:</td>
                                            <td>{{$vendor_product->other_information }}</td>
                                        </tr>

                                        <tr>
                                            <td style="width: 40%;" class="heading_color">Key Specification:</td>
                                            <td>{{$getproducts->key_specification}}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 40%;" class="heading_color">Condition:</td>

                                            <td>{{$condition->name}}</td>
                                        </tr>
                                         <tr>
                                            <td style="width: 40%;" class="heading_color">Model Number:</td>
                                            
                                            <td>{{$vendor_product->model_number}}</td>
                                        </tr>
                                         <tr>
                                            <td style="width: 40%;" class="heading_color">Serial Number:</td>
                                           
                                            <td>{{$vendor_product->serial_number}}</td>
                                        </tr>
                                       
                                    </tbody>
                                    </table>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="box-highlight">
                               @php
                               
                                    if(Session::has('currency')){
                                    $getPrice=App\currency::find(1);
                                    if(Session::get('currency')=='Dollar'){
                                    $price="$ ".$price*$getPrice->Dollar;
                                    }
                                    else if(Session::get('currency')=='Yen'){
                                    $price="¥ ".$price*$getPrice->Yen;
                                }
                                else if(Session::get('currency')=='Euro'){
                                $price="€ ".$price*$getPrice->Euro;
                            }
                            else{
                            $price="₦ ".$price;
                        }
                                    }
                                    else{
                                     $price="₦ ".$price;
                                }
                                    @endphp
                                <h5><input type="radio" name="payment" class='payment' value="1"  checked="checked"> {{$price }} -Instant Price</h5>
                                 <?php echo $amt ?>
                               
                                <!-- <h4>Instant Price</h4>
                                <input type="radio" name="price" value="{{$getproducts->instant_price}}" class="price_product" checked="checked"> <span class="">{{$getproducts->instant_price}}</span>
                                &nbsp;
                                <h4>15 Days Price</h4>
                                <input type="radio" name="price" value="{{$getproducts->pricewithin15days}}" class="price_product"> <span>{{$getproducts->pricewithin15days}}</span>
                                &nbsp;
                                <h4>30 Days Price</h4>
                                <input type="radio" name="price" value="{{$getproducts->pricewithin30days}}" class="price_product"> <span>{{$getproducts->pricewithin30days}}</span> -->
                                <?php 
                                 $PaymentDeliveryInformation=App\PaymentDeliveryInformation::where('product_id','=',$vendor_product->product_id)->first();
                                 if($vendor_product->stock_count>$PaymentDeliveryInformation->minimum_order_quantity){
                                                    $max=$vendor_product->stock_count;
                                                }
                                                else{
                                                    $max=$PaymentDeliveryInformation->minimum_order_quantity;
                                                }

                                 ?>  @if($vendor_product->stock_count > 1 && $vendor_product->stock_count>$PaymentDeliveryInformation->minimum_order_quantity)
                                                <span style="color:green;">In Stock</span>
                                          @else
                                                <span style="color:red;">Out of Stock</span>
                                          @endif
                                <ul class="product-page-actions-list">
                                   <li class="product-page-qty-item">

                                <button class="product-page-qty product-page-qty-minus">-</button>
                                <input class="product-page-qty product-page-qty-input productqty" type="number" value="{{$PaymentDeliveryInformation->minimum_order_quantity}}" 
                                min="{{$PaymentDeliveryInformation->minimum_order_quantity}}" size="1" maxlength="2" max="{{$max}}" onkeydown="return false">
                                <button class="product-page-qty product-page-qty-plus">+</button>
                                    </li> 
                                </ul>
                                <br>
                                <a class="btn btn-block btn-primary @if($vendor_product->stock_count > 1) addvendorproduct @endif" href="#" id="<?php echo $id ?>"><i class="fa fa-shopping-cart" ></i>Add to Cart</a>
                                <?php
                        if (Auth::check()) {
                            if ($wishlist) {
                            ?>
                                <a class="btn btn-block btn-default wishlistadd" id="<?php echo $id ?>"><i class="fa fa-star"></i>Wishlist</a>
                           <?php
                            }else{
                                ?>
                                <a class="btn btn-block btn-default wishlist" id="<?php echo $id ?>"><i class="fa fa-star"></i>Wishlist</a>
                                <?php
                            }
                            ?>
                                
                            <?php }
                             ?>
                                <div class="product-page-side-section">
                                    <h5 class="product-page-side-title">Share This Item</h5>
                                    <ul class="product-page-share-item">
                                       <!-- AddToAny BEGIN -->
<div class="a2a_kit a2a_kit_size_32 a2a_default_style">
<a class="a2a_dd" href="https://www.addtoany.com/share"></a>
<a class="a2a_button_facebook"></a>
<a class="a2a_button_twitter"></a>
<a class="a2a_button_email"></a>
</div>
<script async src="https://static.addtoany.com/menu/page.js"></script>
<!-- AddToAny END -->
                                    </ul>
                                </div>
                                <div class="product-page-side-section">
                                    <h5 class="product-page-side-title">Shipping & Returns</h5>
                                    @php
                                    $shipping=App\termscondition::find(10);

                                    @endphp
                                    <p class="product-page-side-text">
                                      @if($shipping)  {!!$shipping->terms!!} @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="gap"></div>
            <div class="tabbable product-tabs">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active"><a href="#tab-1" data-toggle="tab"><i class="fa fa-list nav-tab-icon"></i>Overview</a>
                    </li>
                    <li><a href="#tab-2" data-toggle="tab"><i class="fa fa-cogs nav-tab-icon"></i>Full Specs</a>
                    </li>
                    <li><a href="#tab-3" data-toggle="tab"><i class="fa fa-star nav-tab-icon"></i>Rating and Reviews</a>
                    </li>
                    <li><a href="#tab-4" data-toggle="tab"><i class="fa fa-plug nav-tab-icon"></i>Accessories</a>
                    </li>
                    <li><a href="#tab-5" data-toggle="tab"><i class="fa fa-comment nav-tab-icon"></i>Customer Q&A</a>
                    </li>
                       <li><a href="#tab-6" data-toggle="tab"><i class="fa fa-eye nav-tab-icon"></i>Specification</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="tab-1">
                        <div class="row row-eq-height product-overview-section">
                            <div class="col-md-6">
                                <img class="product-overview-img" src="{{url('/')}}/{{$product_image->image_1}}" alt="Image Alternative text" title="Image Title" />
                            </div>
                            <div class="col-md-6">
                                 <img class="product-overview-img" src="{{url('/')}}/{{$product_image->image_2}}" alt="Image Alternative text" title="Image Title" />
                            </div>
                        </div>
                        <div class="row row-eq-height product-overview-section">
                            <div class="col-md-6">
                                 <img class="product-overview-img" src="{{url('/')}}/{{$product_image->image_3}}" alt="Image Alternative text" title="Image Title" />
                            </div>
                            <div class="col-md-6">
                                 <img class="product-overview-img" src="{{url('/')}}/{{$product_image->image_4}}" alt="Image Alternative text" title="Image Title" />
                            </div>
                        </div>
                       
                    </div>
                    <div class="tab-pane fade" id="tab-2">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Specs:</th>
                                    <th>Details:</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="product-page-features-table-specs heading_color" >Dimensions Per Unit Length:</td>
                                    <td class="product-page-features-table-details">{{$vendor_product->dimension_per_unit_length }}</td>
                                   
                                </tr>
                                <tr>
                                    <td class="product-page-features-table-specs heading_color">Dimensions Per Unit Width:</td>
                                    <td class="product-page-features-table-details">{{$vendor_product->dimension_per_unit_width }}</td>
                                
                                </tr>
                                <tr>
                                    <td class="product-page-features-table-specs heading_color">Dimensions Per Unit Height:</td>
                                    <td class="product-page-features-table-details">{{$vendor_product->dimension_per_unit_height }}</td>
                                    
                                </tr>
                                <tr>
                                    <td class="product-page-features-table-specs heading_color">Dimensions Per Unit weight:</td>
                                    <td class="product-page-features-table-details">{{$vendor_product->dimension_per_unit_weight }}</td>
                                    
                                </tr>
                                <tr>
                                    <td class="product-page-features-table-specs heading_color">Dimensions Per Unit Volume:</td>
                                    <td class="product-page-features-table-details">{{$vendor_product->dimension_per_unit_volume  }}</td>
                                   
                                </tr>
                                <tr>
                                    <td class="product-page-features-table-specs heading_color">Packaging Dimensions Per Unit Length:</td>
                                    <td class="product-page-features-table-details">{{$vendor_product->pack_dimenshn_per_unit_length  }}</td>
                                   
                                </tr>
                                <tr>
                                    <td class="product-page-features-table-specs heading_color">Packaging Dimensions Per Unit Width:</td>
                                    <td class="product-page-features-table-details">{{$vendor_product->pack_dimenshn_per_unit_width  }}</td>
                                    
                                </tr>
                               
                                <tr>
                                    <td class="product-page-features-table-specs heading_color">Packaging Dimensions Per Unit Height:</td>
                                    <td class="product-page-features-table-details">{{$vendor_product->pack_dimenshn_per_unit_height  }}</td>
                                    
                                </tr>
                                <tr>
                                    <td class="product-page-features-table-specs heading_color">Export Carton Dimension:</td>
                                    <td class="product-page-features-table-details">{{$vendor_product->export_carton_dimension  }}</td>
                                    
                                </tr>
                                <tr>
                                    <td class="product-page-features-table-specs heading_color">Export Carton Weight:</td>
                                    <td class="product-page-features-table-details">{{$vendor_product->export_carton_dimension_weight  }}</td>
                                   
                                </tr>
                                <tr>
                                    <td class="product-page-features-table-specs heading_color"> Delivery Within State:</td>
                                    <td class="product-page-features-table-details">{{App\Http\Controllers\HomeController::converter($vendor_product->deliveryratestate) }}</td>
                                    
                                </tr>
                                <tr>
                                    <td class="product-page-features-table-specs heading_color">Delivery Within Geographic Range:</td>
                                    <td class="product-page-features-table-details">{{App\Http\Controllers\HomeController::converter($vendor_product->deliveryrateoutstatewithgeo)  }}</td>
                                    
                                </tr>
                                <tr>
                                    <td class="product-page-features-table-specs heading_color">Delivery Out of Geographic Range:</td>
                                    <td class="product-page-features-table-details">{{App\Http\Controllers\HomeController::converter($vendor_product->deliveryrateoutsidegeo)  }}</td>
                                    
                                </tr>
                                <tr>
                                    <td class="product-page-features-table-specs heading_color">Duration Delivery Within State:</td>
                                    <td class="product-page-features-table-details">{{$vendor_product->deliver_duration_with_stat}} days</td>
                                    
                                </tr>
                                <tr>
                                    <td class="product-page-features-table-specs heading_color">Duration Delivery Within Geographic Range:</td>
                                    <td class="product-page-features-table-details">{{$vendor_product->duration_delivery_within_geo_range }} days</td>
                                    
                                </tr>
                                <tr>
                                    <td class="product-page-features-table-specs heading_color">Duration Delivery Outside Geographic Range:</td>
                                    <td class="product-page-features-table-details">{{$vendor_product->duration_delivery_out_geo_range }} days</td>
                                    
                                </tr>
                                <tr>
                                    <td class="product-page-features-table-specs heading_color">Payment Method:</td>
                                    <td class="product-page-features-table-details">{{$vendor_product->payment_mehod   }}</td>
                                    
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="tab-3">
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="product-tab-rating-title">Overall Customer Rating:</h3>
                            </div>
                        </div>
                        <hr />
                        <?php echo $showreview; ?>
                        <div class="row">
                            <div class="col-md-6">
                                <?php
                                if ($reviewcount) {
                                    ?>
                                    <p class="category-pagination-sign">{{$reviewcount}} customer reviews found. Showing 1 - 5</p>
                                    <?php
                                }
                                ?>
                                
                            </div>
                            <div class="col-md-6">
                                <nav>
                                    <ul class="pagination category-pagination pull-right">
                                        <li class="active"><a href="#">1</a>
                                        </li>
                                        <li><a href="#">2</a>
                                        </li>
                                        <li><a href="#">3</a>
                                        </li>
                                        <li><a href="#">4</a>
                                        </li>
                                        <li><a href="#">5</a>
                                        </li>
                                        <li class="last"><a href="#"><i class="fa fa-long-arrow-right"></i></a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-4">
                        <div class="row">
                            <div class="col-md-12">
                                <h3>Additional Accessories</h3>
                                <ul class="product-accessory-list">
                            
                            @if($data_acceseries)
                               @foreach($data_acceseries as $key=>$val)
                                    @foreach($val as $k=>$v)
                                    <li class="product-accessory">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <a href="#">
                                                    <img class="product-accessory-img" src="{{url('/')}}/{{$v->image}}" alt="Image Alternative text" title="Image Title" />
                                                </a>
                                            </div>
                                            <div class="col-md-7">
                                                <ul class="product-page-product-rating">
                                                    <li class="rated"><i class="fa fa-star"></i>
                                                    </li>
                                                    <li class="rated"><i class="fa fa-star"></i>
                                                    </li>
                                                    <li class="rated"><i class="fa fa-star"></i>
                                                    </li>
                                                    <li class="rated"><i class="fa fa-star"></i>
                                                    </li>
                                                    <li class="rated"><i class="fa fa-star"></i>
                                                    </li>
                                                </ul>
                                                <h5 class="product-accessory-title"><a href="{{url('product/'.$v->slog)}}">{{$v->name}}</a></h5>
                                            </div>
                                            <div class="col-md-3">
                                                <p class="product-accessory-price">{{App\Http\Controllers\HomeController::converter($v->price)}}</p><a class="btn btn-primary" href="{{url('product/'.$v->slog)}}"> View </a>
                                            </div>
                                        </div>
                                    </li>
                                        @endforeach
                                   @endforeach
                                @endif
                                </ul>
                            </div>
                            
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-5">
                        <div class="row">
                            <div class="error"></div>
                            <div class="col-md-8 col-md-offset-2">
                                <form class="product-page-qa-form" action="{{url('save_q_a')}}" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="product_id" value="{{$vendor_product->product_id}}" class="product_id">
                                    <div class="row" data-gutter="10">
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <input class="form-control question" type="text" placeholder="Have a question? Feel free to ask."  name="question" />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <input class="btn btn-primary btn-block" type="button" value="Ask" id="ask" />
                                        </div>
                                    </div>
                                </form>
                                 <div id="load-data">
                                @foreach($q_a as $k)
                               
                                <article class="product-page-qa">
                                    <div class="product-page-qa-question">
                                        <p class="product-page-qa-text">{{$k->question}}?</p>
                                        <p class="product-page-qa-meta">asked on {{$k->created_at}}</p>
                                    </div>
                                    @if($k->answer)
                                    <div class="product-page-qa-answer">
                                        <p class="product-page-qa-text">{{$k->answer}}</p>
                                        <p class="product-page-qa-meta">answered on {{$k->answer_date}}</p>
                                    </div>
                                    @endif
                                </article>
                                @endforeach
                             </div>

                                <div id="remove-row">
                                <button id="btn-more" @foreach($q_a as $ke) data-id="{{$ke->id}}"   @endforeach class="nounderline btn-block mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent btn btn-primary" > Load More </button>
                                </div>
                               
                                
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-6">
                        <div class="row">
                            <div class="error"></div>
                            <div class="col-md-8 col-md-offset-2">  
                                {!!$products->additional_specification!!} 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="gap"></div>
            <h3 class="widget-title">You Might Also Like</h3>
            <div class="row" data-gutter="15">
                <?php echo $view ?>
            </div>
        </div>

@endsection
@section('script')
<script src="{{URL::asset('/js/star-rating.min.js') }}" type="text/javascript"></script>
<script src="{{URL::asset('/themes/krajee-svg/theme.js') }}"></script>
<script src="{{URL::asset('/themes/krajee-fa/theme.js') }}"></script>
<script src="{{URL::asset('/js/locales/de.js') }}"></script>


<script type="text/javascript">
    $(document).on('ready', function(){
    $('.input-3').rating({displayOnly: true, step: 0.1});
});
</script>
@endsection