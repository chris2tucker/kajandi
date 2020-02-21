<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Product Detail</title>
    @include('includes.head')
</head>

@include('includes.header')
        <header id="topbar" class="alt">
            <div class="topbar-left">
                <ol class="breadcrumb">
                    <li class="breadcrumb-icon">
                        <a href="dashboard1.html">
                            <span class="fa fa-home"></span>
                        </a>
                    </li>
                    <li class="breadcrumb-active">
                        <a href="{{url('admin/index')}}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-link">
                        <a href="{{url('admin/adv_sec_1')}}">Product Detail</a>
                    </li>
                   
                </ol>
            </div>
            
        </header>

    <section id="content" class="table-layout animated fadeIn">

         
            <!-- -------------- /Column Left -------------- -->

            <!-- -------------- Column Center -------------- -->
            <div class="chute chute-center">

                <div class="mw1000 center-block">

                    <!-- -------------- Spec Form -------------- -->
                    <div class="allcp-form">
                        <div class="panel panel">
                            <div class="panel-heading">
                               <h4> {{$vendor_product->name}}</h4>
                            </div>
                            <div class="panel-body">

              
                            <div class="panel-body pn">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
                                                <ol class="carousel-indicators">
                                                  <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                                  <li data-target="#myCarousel" data-slide-to="1"></li>
                                                  <li data-target="#myCarousel" data-slide-to="2"></li>
                                                   <li data-target="#myCarousel" data-slide-to="3"></li>
                                                </ol>

                                                <!-- Wrapper for slides -->
                                                <div class="carousel-inner">
                                                  <div class="item active">
                                                   
                                                    <img src="{{URL::to('/')}}/{{$vendor_product->image_1}}" style="width:100%; height: 400px;">
                                                  </div>

                                                  <div class="item">
                                                   <img src="{{URL::to('/')}}/{{$vendor_product->image_2}}" style="width:100%; height: 400px;">
                                                  </div>
                                                
                                                  <div class="item">
                                                    <img src="{{URL::to('/')}}/{{$vendor_product->image_3}}" style="width:100%; height: 400px;">
                                                  </div>
                                                  <div class="item">
                                                    <img src="{{URL::to('/')}}/{{$vendor_product->image_4}}" style="width:100%; height: 400px;">
                                                  </div>
                                                </div>

                                                <!-- Left and right controls -->
                                                <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                                                  <span class="glyphicon glyphicon-chevron-left"></span>
                                                  <span class="sr-only">Previous</span>
                                                </a>
                                                <a class="right carousel-control" href="#myCarousel" data-slide="next">
                                                  <span class="glyphicon glyphicon-chevron-right"></span>
                                                  <span class="sr-only">Next</span>
                                                </a>
                                              </div>
                                              <hr>
                                              <h4>Description:</h4>
                                              <p class="product-page-desc"><?php echo $vendor_product->description ?></p>
                                    </div>
                                    <div class="col-sm-7">
                                        <div class="">
                                            <div class="">
                                                
                                               <div class="col-md-8">
                                                        <div class="box">
                                        
                                                            
                                                            <table
                                                            class="table table-striped product-page-features-table">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>Generic Name:</td>
                                                                        <td>{{$vendor_product->product_generic_name}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Manufacturer:</td>
                                                                        <td>{{$vendor_product->manufacture_name}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Model:</td>
                                                                        <td>{{$vendor_product->model_name}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Condition:</td>
                                                                        <td>{{$vendor_product->condition_name}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Availability:</td>
                                                                        <td>{{$vendor_product->availability}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Supply Type:</td>
                                                                        <td>{{$vendor_product->supplyType}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Color:</td>
                                                                        <td>{{$vendor_product->color}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Unit Of Measure:</td>
                                                                        <td>{{$vendor_product->unit_of_measure }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Minimum Order:</td>
                                                                        <td>{{$vendor_product->minimum_order_quantity }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Optional Price:</td>
                                                                        <td>{{$vendor_product->price_for_optional_unit }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Instant Price:</td>
                                                                        <td>{{$vendor_product->instant_price }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>15 Days Price:</td>
                                                                        <td>{{$vendor_product->pricewithin15days }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>30 Days Price:</td>
                                                                        <td>{{$vendor_product->pricewithin30days }}</td>
                                                                    </tr>
                                                                     <tr>
                                                                        <td>Weight Per Pack:</td>
                                                                        <td>{{$vendor_product->weight_per_packging }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Other Information:</td>
                                                                        <td>{{$vendor_product->other_information }}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Key Specification:</td>
                                                                        <td>{{$vendor_product->key_specification}}</td>
                                                                    </tr>

                                                                     <tr>
                                                                        <td>Dimensions Per Unit Length:</td>
                                                                        <td>{{$vendor_product->dimension_per_unit_length }}</td>
                                                                       
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Dimensions Per Unit Width:</td>
                                                                        <td>{{$vendor_product->dimension_per_unit_width }}</td>
                                                                    
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Dimensions Per Unit Height:</td>
                                                                        <td>{{$vendor_product->dimension_per_unit_height }}</td>
                                                                        
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Dimensions Per Unit weight:</td>
                                                                        <td>{{$vendor_product->dimension_per_unit_weight }}</td>
                                                                        
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Dimensions Per Unit Volume:</td>
                                                                        <td>{{$vendor_product->dimension_per_unit_volume  }}</td>
                                                                       
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Packaging Dimensions Per Unit Length:</td>
                                                                        <td>{{$vendor_product->pack_dimenshn_per_unit_length  }}</td>
                                                                       
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Packaging Dimensions Per Unit Width:</td>
                                                                        <td>{{$vendor_product->pack_dimenshn_per_unit_width  }}</td>
                                                                        
                                                                    </tr>
                                                                   
                                                                    <tr>
                                                                        <td>Packaging Dimensions Per Unit Height:</td>
                                                                        <td>{{$vendor_product->pack_dimenshn_per_unit_height  }}</td>
                                                                        
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Export Carton Dimension:</td>
                                                                        <td>{{$vendor_product->export_carton_dimension  }}</td>
                                                                        
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Export Carton Weight:</td>
                                                                        <td>{{$vendor_product->export_carton_dimension_weight  }}</td>
                                                                       
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Delivery With in State:</td>
                                                                        <td>{{$vendor_product->deliveryratestate }}</td>
                                                                        
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Delivery Within Geographic Range:</td>
                                                                        <td>{{$vendor_product->deliveryrateoutstatewithgeo  }}</td>
                                                                        
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Delivery Out Geographic Range:</td>
                                                                        <td>{{$vendor_product->deliveryrateoutsidegeo  }}</td>
                                                                        
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Duration Delivery Within State:</td>
                                                                        <td>{{$vendor_product->deliver_duration_with_stat   }}</td>
                                                                        
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Duration Delivery Within Geographic Range:</td>
                                                                        <td>{{$vendor_product->duration_delivery_within_geo_range   }}</td>
                                                                        
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Duration Delivery Outside Geographic Range:</td>
                                                                        <td>{{$vendor_product->duration_delivery_out_geo_range   }}</td>
                                                                        
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Payment Method:</td>
                                                                        <td>{{$vendor_product->payment_mehod   }}</td>
                                                                        
                                                                    </tr>
                                                                </tbody>
                                                                </table>


                                                        </div>
                                                    </div>



                                            </div>

                                        </div>



                                    </div>
                                </div>
                            </div>
                      

                                

                                <!-- -------------- /form -------------- -->



                            </div>
                        </div>

                    </div>



                </div>
            </div>
            <!-- -------------- /Column Center -------------- -->
@include('includes.footer')
