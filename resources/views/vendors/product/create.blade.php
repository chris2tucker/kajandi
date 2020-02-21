<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Vendor Product</title>
    @include('includes_vendor.head')
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js"></script>
</head>

@include('includes_vendor.header')
<header id="topbar" class="alt">
            <div class="topbar-left">
                <ol class="breadcrumb">
                    <li class="breadcrumb-icon">
                        <a href="dashboard1.html">
                            <span class="fa fa-home"></span>
                        </a>
                    </li>
                    <li class="breadcrumb-active">
                        <a href="{{url('vendor/index')}}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-link">
                        <a href="{{url('vendors/products')}}">Vendors Product</a>
                    </li>
                    <li class="breadcrumb-current-item">Add Vendor Product</li>
                </ol>
            </div>
            
        </header>

  <script>
$(document).ready(function(){
 

$(document).on('change','#catagory',function(e){

      
        var catagory_id = $(this).val();

        var url = ajaxurl+'get_sub_catgory';



        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
            }
        })
            e.preventDefault(); 
        var formData = {
            
            catagory_id     : catagory_id,    
        }

        $.ajax({
            

            type: "GET",
            url: url,
            data: formData,
            dataType: 'json',
            success: function (data) {
            
               var select = $("#subcatagory"), options = '';
               
               select.empty();      

               for(var i=0;i<data.length; i++)
               {
                options += "<option value='"+data[i].id+"'>"+ data[i].name +"</option>";              
               }

                select.append(options);  

             
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });

 
});
</script>

 <script>
jQuery(document).ready(function($) {
    $("#product_keyword").tagsinput();
    $("#accessories").tagsinput();

    
});
</script>


    <section id="content" class="table-layout animated fadeIn">
        <div class="alert alert-danger" style="font-weight: bold;">
            Kindly add new <a href="{{url('/vendors/manufacture')}}" title="">manufacturer</a>  and <a href="{{url('/vendors/model')}}" title="">model</a>  if they not found in list! Thanks
        </div>
         
            <!-- -------------- /Column Left -------------- -->

            <!-- -------------- Column Center -------------- -->
            <div class="chute chute-center">

                <div class="mw1000 center-block">

                    <!-- -------------- Spec Form -------------- -->
                    <div class="allcp-form">
                        <div class="panel">
                            <div class="panel-heading">
                                <div class="panel-title">General Information
                                </div>
                            </div>
                            <div class="panel-body br-t">
                            <div class="allcp-form theme-primary tab_product">

                            @if(Session::has('status'))
                            <p class="alert alert-success alert-dismissable fade in">{{ Session::get('status') }}</p>
                            @endif
                           

                            <div class="box-tab">

                                      <ul class="nav nav-tabs">
                                        <li class="active"><a href="#general" data-toggle="tab">General</a>
                                        </li>
                                        <li><a href="#data" data-toggle="tab">Data</a>
                                        </li>
                                        <li><a href="#payment_delvery_information" data-toggle="tab">Payment & Deliver Information</a>
                                        </li>
                                        <li><a href="#image" data-toggle="tab">Images</a>
                                        </li>
                                        <li><a href="#specification" data-toggle="tab">Additional Specification</a>
                                        </li>
                                      </ul>
                            <form method="POST" action="{{ url('vendor/store_product') }}" class="" id="form-product" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                      <div class="tab-content text-center">
                                        <div class="tab-pane fade active in" id="general">
                                          <div class="form-group">
                                                <div class="row">
                                                <label for="store-name" class="col-sm-2 control-label small">Product Name:<font color="red">*</font></label>
                                                <div class="col-sm-10">
                                                        <input type="text" name="name"  class="form-control" placeholder="Product Name" value="{{ old('name') }}">
                                                  </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                <label for="store-name" class="col-sm-2 control-label small">Generic Name: <font color="red">*</font></label>
                                                <div class="col-sm-10">
                                                        <input type="text" name="product_generic_name" id="business-name" class="form-control" placeholder="Product Generic Name" value="{{ old('product_generic_name') }}">   
                                                  </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                             <div class="row">
                                                <label for="store-name" class="col-sm-2 control-label small">Vendor:<font color="red">*</font></label>
                                                    <div class="col-sm-10 ph10">
                                                            <select id="vendor" name="vendor" class="form-control chosen" disabled="disabled">
                                                                <option value="">Select vendor </option>
                                                                @foreach($vendor as $key=>$val)
                                                                <option value="{{$key}}" @if($userid==$key) selected="selected" @endif>{{$val}}</option>
                                                                @endforeach
                                                            </select>
                                                            <input type="hidden" name="vendor" value="{{Auth::User()->id }}">
                                                         
                                                    </div>
                                              </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="section row mb10">
                                                   <label for="store-name" class="col-sm-2 control-label small">Description:</label>
                                                     <div class="col-sm-10 ph10">
                                                        <textarea name="description" id="business-name" class="form-control" placeholder="Description..."></textarea>   
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                 <div class="section row mb10">
                                                    <label for="store-name" class="col-sm-2 control-label small">Keywords:</label>
                                                    <div class="col-sm-10 ph10">
                                                            <input type="text" name="product_keyword" id="product_keyword" class="form-control tagsinput" placeholder="Keywords" id="tags_1" value="{{ old('product_keyword') }}">
                                                      </div>
                                                    </div>
                                            </div>
                                            
                                        </div>
                            <!-- ---------------------------------------------End First Tab General---------------------------------------------------->

                                        <div class="tab-pane fade" id="data">
                                            <div class="form-group">
                                                <div class="row">
                                                    <label for="store-name" class="col-sm-2 control-label small">Part Number:</label>
                                                    <div class="col-sm-10 ph10">
                                                            <input type="text" name="part_number" id="business-name" class="form-control" placeholder="Part Number"  value="{{ old('part_number') }}">

                                                     </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <div class="row">
                                                    <label for="store-name" class="col-sm-2 control-label small">Model Number:</label>
                                                    <div class="col-sm-10 ph10">
                                                            <input type="text" name="model_number" id="business-name" class="form-control" placeholder="Model Number"  value="{{ old('model_number') }}">

                                                     </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <div class="row">
                                                    <label for="store-name" class="col-sm-2 control-label small">Serial Number:</label>
                                                    <div class="col-sm-10 ph10">
                                                            <input type="text" name="serial_number" id="business-name" class="form-control" placeholder="Serial Number"  value="{{ old('serial_number') }}">

                                                     </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row ">
                                                    <label for="store-name" class="col-sm-2 control-label small">Manufacture: <font color="red">*</font></label>
                                                            <div class="col-sm-10 ph10">
                                                                <select id="" name="manufacturer" class="form-control chosen">
                                                                    <option value="">Select a Manufacture</option>
                                                                    <option value="NaN">Not Applicable (N/A)</option>
                                                                    @foreach($manufacture as $key=>$val)
                                                                        <option value="{{$key}}">{{$val}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row ">
                                                <label for="store-name" class="col-sm-2 control-label small">Model: <font color="red">*</font></label>
                                                    <div class="col-sm-10 ph10">
                                                            <select id="" name="model" class="form-control chosen">
                                                                <option value="">Select a Model</option>
                                                                 <option value="nan">Not Applicable (N/A)</option>
                                                                @foreach($model as $key=>$val)
                                                                    <option value="{{$key}}">{{$val}}</option>
                                                                @endforeach
                                                            </select>
                                                    </div>
                                                </div>
                                             </div>
                                             <div class="form-group">
                                                <div class="row ">
                                                <label for="store-name" class="col-sm-2 control-label small">Condition: <font color="red">*</font></label>
                                                    <div class="col-sm-10 ph10">
                                                            <select id="drop" name="condition" class="form-control chosen">
                                                                <option value="">Select a Condition</option>
                                                                @foreach($condition as $key=>$val)
                                                                    <option value="{{$key}}">{{$val}}</option>
                                                                @endforeach
                                                            </select>
                                                    </div>
                                                </div>
                                             </div>

                                             <div class="form-group">
                                                <div class="section row mb10">
                                                    <label for="store-name" class="col-sm-2 control-label small">Catagory: <font color="red">*</font></label>
                                                        <div class="col-sm-10 ph10">
                                                                <select id="catagory" name="category" class="form-control chosen">
                                                                    <option value="">Select a Category</option>
                                                                    @foreach($catagory as $key=>$val)
                                                                        <option value="{{$val}}">{{$key}}</option>
                                                                    @endforeach
                                                                </select>
                                                              
                                                        </div>
                                                    </div>
                                             </div>
                                             <div class="form-group">
                                                 <div class="section row mb10">
                                                    <label for="store-name" class="col-sm-2 control-label small">Sub Catagory: <font color="red">*</font></label>
                                                        <div class="col-sm-10 ph10">
                                                                <select id="subcatagory" name="subcategory" class="form-control"></select>
                                                                
                                                        </div>
                                                    </div>
                                                </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <label for="store-name" class="col-sm-2 control-label small">Stock Count:</label>
                                                    <div class="col-sm-10 ph10">
                                                            <input type="text" name="stock_count" id="business-name" class="form-control" placeholder="Enter Stock" value="{{ old('stock_count') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label small">Accessories:</label>
                                                <div class="col-sm-10">
                                                  <select data-placeholder="Please select Accessories from your product list..."  multiple class="chosen" name="accessories[]"> 
                                                    @foreach($vendor_products as $key=>$val)
                                                        <option value="{{$key}}"> {{$val}}</option>
                                                    @endforeach
                                                  </select>
                                                </div>
                                              </div>
                                            <div class="section row mb10">
                                                <label for="store-name" class="col-sm-2 control-label small">Other Information</label>
                                                <div class="col-sm-10 ph10">
                                                        <input type="text" name="other_information" id="business-name" class="form-control" placeholder="Other information" value="{{ old('other_information') }}">  
                                                  </div>
                                            </div>
                                            <div class="section row mb10">
                                                <label for="store-name" class="col-sm-2 control-label small">Key Specification:</label>
                                                <div class="col-sm-10 ph10">
                                                        <textarea name="key_specification" id="business-name" class="form-control" placeholder="Key Specification:"></textarea>
                                                  </div>
                                            </div>

                                            <div class="section row mb10">
                                                <label for="store-name" class="col-sm-2 control-label small">Dimensions Per Unit:</label>
                                                <div class="col-sm-2 ph10">
                                                        <input type="text" name="dimension_per_unit_length" id="business-name" class="form-control" placeholder="Length(C/M)" value="{{ old('dimension_per_unit_length') }}">
                                                    
                                                  </div>
                                                  <div class="col-sm-2 ph10">
                                                        <input type="text" name="dimension_per_unit_width" id="business-name" class="form-control" placeholder="Width(C/M)" value="{{ old('dimension_per_unit_width') }}">
                                                  </div>
                                               

                                                 <div class="col-sm-2 ph10">
                                                        <input type="text" name="dimension_per_unit_weight" id="business-name" class="form-control" placeholder="Weight(Kg)" value="{{ old('dimension_per_unit_weight') }}">
                                                  </div>

                                                  <div class="col-sm-2 ph10">
                                                        <input type="text" name="dimension_per_unit_volume" id="business-name" class="form-control" placeholder="Volume(CM3)" value="{{ old('dimension_per_unit_volume') }}">
                                                  </div>
                                            </div>

                                            <div class="section row mb10">
                                                <label for="store-name" class="col-sm-2 control-label small">Supply Type:</label>
                                                    <div class="col-sm-10 ph10">
                                                            <select id="country" name="supplyType" class="form-control">
                                                                <option value="">Select a Supply Type</option>
                                                                <option value="OEM/Manufacturer">OEM / Manufacturer</option>
                                                                <option value="Distributor">Distributor</option>
                                                                <option value="Wholesaler">Wholesaler</option>
                                                                <option value="Retailer">Retailer</option>
                                                            </select>
                                                        
                                                    </div>
                                             </div>


                                            <div class="section row mb10">
                                                <label for="store-name" class="col-sm-2 control-label small">Color:</label>
                                                <div class="col-sm-7 ph10">
                                                        <input type="text" name="color" id="business-name" class="form-control" placeholder="Color" value="{{ old('color') }}">  
                                                  </div>
                                             </div>
                                          
                                        </div>

                        <!-- ---------------------------------End Tab Data----------------------------------------- -->


                                        <div class="tab-pane fade" id="payment_delvery_information">
                                         
                                            <div class="section row mb10">
                                                <label for="store-name" class="col-sm-2 control-label small">Minimum Order Qty:</label>
                                                <div class="col-sm-10 ph10">
                                                        <input type="text" name="minimum_order_quantity" id="business-name" class="form-control" placeholder="Enter minimum order quantity" value="{{ old('minimum_order_quantity') }}">  
                                                  </div>
                                            </div>
                                            <div class="section row mb10">
                                                <label for="store-name" class="col-sm-2 control-label small">Unit of Measure:</label>
                                                    <div class="col-sm-10 ph10">
                                                            <select id="country" name="unit_of_measure" class="form-control chosen">
                                                                <option value="">Select a Unit Measure</option>
                                                               @php
                                                                $units=App\unit::all();
                                                                @endphp
                                                                
                                                                @foreach($units as $unit)
                                                                <option value="{{$unit->unit}}" >{{$unit->unit}}</option>
                                                                @endforeach
                                                            </select>

                                                    </div>

                                             </div>

                                             
                                        <!--    <div class="section row mb10">
                                                <label for="store-name" class="col-sm-2 control-label small">Price for Optional Units:</font></label>
                                                <div class="col-sm-10 ph10">
                                                        <input type="text" name="price_for_optional_unit" id="business-name" class="form-control" placeholder="Enter price for optional units(in Nigerian Naira)" value="{{ old('price_for_optional_unit') }}">
                                                  </div>
                                            </div> -->

                                            <div class="section row mb10">
                                                <label for="store-name" class="col-sm-2 control-label small">Price:<font color="red">*</font></label>

                                                <div class="col-sm-10 ph10">
                                                    <div class="col-sm-4">
                                                        <input type="text" name="instant_price" id="business-name" class="form-control" placeholder="Enter instant price (in Nigerian Naira)" value="{{ old('instant_price') }}">
                                                    </div>
                                                    <div class="col-sm-4 ph10">
                                                        <input type="text" name="pricewithin15days" id="business-name" class="form-control" placeholder="Enter 15 days price(in Nigerian Naira)" value="{{ old('pricewithin15days') }}">
                                                    </div>
                                                    <div class="col-sm-4 ph10">
                                                        <input type="text" name="pricewithin30days" id="business-name" class="form-control" placeholder="Enter 30 days price(in Nigerian Naira)" value="{{ old('pricewithin30days') }}">
                                                    </div>
                                                    <div class="text-danger col-sm-12">Consider <a href="{{url('general/terms/view/16')}}" target="_blank" >commission</a> charged for your  product sub-category while fixing prices</div>

                                                </div>
                                        </div>

                                           <div class="section row mb10">
                                                <label for="store-name" class="col-sm-2 control-label small">Pack. Dim. Per Unit:</label>
                                                <div class="col-sm-3 ph10">
                                                        <input type="text" name="pack_dimenshn_per_unit_length" id="business-name" class="form-control" placeholder="Enter Length" value="{{ old('pack_dimenshn_per_unit_length') }}">
                                                  </div>
                                                  <div class="col-sm-3 ph10">
                                                        <input type="text" name="pack_dimenshn_per_unit_width" id="business-name" class="form-control" placeholder="Enter Width" value="{{ old('pack_dimenshn_per_unit_width') }}">
                                                  </div>
                                               

                                                 <div class="col-sm-3 ph10">
                                                        <input type="text" name="pack_dimenshn_per_unit_height" id="business-name" class="form-control" placeholder="Enter Height" value="{{ old('pack_dimenshn_per_unit_height') }}">
                                                  </div>     
                                             </div>


                                            <div class="section row mb10">
                                                 <label for="store-name" class="field-label col-sm-2 ph10  text-center"></label>
                                                <div class="col-sm-3 ph10">
                                                        <input type="text" name="weight_per_packging" id="business-name" class="form-control" placeholder="Enter weight per packaging" value="{{ old('weight_per_packging') }}">
                                                  </div>
                                                  <div class="col-sm-3 ph10">
                                                        <input type="text" name="export_carton_dimension" id="business-name" class="form-control" placeholder="Enter export carton dimension" value="{{ old('export_carton_dimension') }}">
                                                  </div>
                                               

                                                 <div class="col-sm-3 ph10">
                                                        <input type="text" name="export_carton_dimension_weight" id="business-name" class="form-control" placeholder="Enter export carton weigth" value="{{ old('export_carton_dimension_weight') }}">

                                                  </div>
                                            </div>


                                            <div class="section row mb10">
                                            <label for="store-name" class="col-sm-2 control-label small">Delivery Rate:<font color="red">(Add 0 for free delivery)</font></label>
                                            <div class="col-sm-3 ph10">
                                                <input type="text" name="deliveryratestate" id="business-name" class="form-control" placeholder="Delivery within state" value="{{ old('deliveryratestate') }}">
                                              </div>
                                              <div class="col-sm-3 ph10">
                                                <input type="text" name="deliveryrateoutstatewithgeo" id="business-name" class="form-control" placeholder="Delivery within geo range" value="{{ old('deliveryrateoutstatewithgeo') }}">
                                              </div>

                                             <div class="col-sm-3 ph10">
                                                    <input type="text" name="deliveryrateoutsidegeo" id="business-name" class="form-control" placeholder="Delivery outside geographical range" value="{{ old('deliveryrateoutsidegeo') }}">
                                              </div>    
                                            </div>

                                            <div class="section row mb10">
                                                 <label for="store-name" class="col-sm-2 control-label small"></label>
                                                <div class="col-sm-3 ph10">
                                                        <input type="text" name="deliver_duration_with_stat" id="business-name" class="form-control" placeholder="Duration delivery within state" value="{{ old('deliver_duration_with_stat') }}">
                                                  </div>
                                                  <div class="col-sm-3 ph10">
                                                        <input type="text" name="duration_delivery_within_geo_range" id="business-name" class="form-control" placeholder="Duration delivery within geo range" value="{{ old('duration_delivery_within_geo_range') }}">
                                                  </div>

                                                 <div class="col-sm-3 ph10">
                                                        <input type="text" name="duration_delivery_out_geo_range" id="business-name" class="form-control" placeholder="Duration delivery outside geo range" value="{{ old('duration_delivery_out_geo_range') }}">
                                                  </div>
                                            </div>
                                            <div class="section row mb10">
                                                <label for="store-name" class="col-sm-2 control-label small">Payment Method: <font color="red">*</font></label>
                                                    <div class="col-sm-10 ph10">
                                                            <select id="country" name="payment_mehod" class="form-control">
                                                                <option value="">Select Payment Method</option>
                                                                <option value="CIA">Cash in Advance (CIA)</option>
                                                                <option value="COD">Cash on Delivery (COD)</option>
                                                            </select>
                                                            
                                                    </div>
                                             </div>

                                        </div>

                                        <!-- -------------------------------------------End Tab Payment Delivery Information---------------------------------------------------- -->

                                    <div class="tab-pane fade" id="image">


                                        <div class="section row mb10">
                                            <label for="store-name" class="col-sm-2 control-label small">Image 1:<font color="red">*</font><small style="color:red;">(Each Image must not be above 2mb)</small></label>
                                            <div class="col-sm-10 ph10">
                                                    <input type="file" name="image_1" id="business-name" class="form-control">
                                            </div>
                                        </div>


                                        <div class="section row mb10">
                                            <label for="store-name" class="col-sm-2 control-label small">Image 2:<font color="red">*</font><small style="color:red;">(Each Image must not be above 2mb)</small></label>
                                            <div class="col-sm-10 ph10">
                                                    <input type="file" name="image_2" id="business-name" class="form-control">
                                            </div>
                                        </div>
                                        <div class="section row mb10">
                                            <label for="store-name" class="col-sm-2 control-label small">Image 3:<font color="red">*</font><small style="color:red;">(Each Image must not be above 2mb)</small></label>
                                            <div class="col-sm-10 ph10">
                                                <input type="file" name="image_3" id="business-name" class="form-control">
                                            </div>
                                        </div>
                                        <div class="section row mb10">
                                            <label for="store-name" class="col-sm-2 control-label small">Image 4:<font color="red">*</font><small style="color:red;">(Each Image must not be above 2mb)</small></label>
                                            <div class="col-sm-10 ph10">
                                                    <input type="file" name="image_4" id="business-name" class="form-control">
                                            </div>
                                        </div>





                                    </div>
                                    <div class="tab-pane fade" id="specification">


                                       <div class="section row mb10">
                                           <textarea name="specification" id="summernote"></textarea>
                                       </div>


                                    </div>

                                    <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Save</button>

                                </form>

                                      </div>

                                    </div>
                            </div>
                              


<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 300, 

        });
    });
  </script>

                              
            <!-- -------------- /Column Center -------------- -->

@include('includes_vendor.footer')


