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
                    
                    <li class="breadcrumb-current-item">User Settings</li>
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
                        <div class="panel">
                            <div class="panel-heading">
                                <div class="panel-title">User Settings
                                </div>
                            </div>
                            <div class="panel-body br-t">
                            <div class="allcp-form theme-primary tab_product">

                            @if(Session::has('status'))
                            <p class="alert alert-success alert-dismissable fade in">{{ Session::get('status') }}</p>
                            @endif
                           

                            <div class="box-tab">

                                      
                            <form method="POST" action="{{ route('vendor.settings.update') }}" class="" id="form-product" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                      <div class="tab-content text-center">
                                        <div class="tab-pane fade active in" id="general">
                                          <div class="form-group">
                                                <div class="row">
                                                <label for="store-name" class="col-sm-2 control-label small">Name:<font color="red">*</font></label>
                                                <div class="col-sm-10">
                                                        <input type="text" name="name"  class="form-control" placeholder="Name" value="{{ Auth::User()->name }}">
                                                  </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                <label for="store-name" class="col-sm-2 control-label small">Email: <font color="red">*</font></label>
                                                <div class="col-sm-10">
                                                        <input type="email" name="email" id="business-name" class="form-control" placeholder="Enter Email" value="{{ Auth::User()->email }}">   
                                                  </div>
                                                </div>
                                            </div>
                                           
                                             <div class="form-group">
                                                <div class="section row mb10">
                                                   <label for="store-name" class="col-sm-2 control-label small">Phone:</label>
                                                     <div class="col-sm-10 ph10">
                                                    <input type="number" name="phone" placeholder="Enter Phone" class="form-control" value="{{ Auth::User()->phone }}">   
                                                    </div>
                                                </div>
                                            </div>
                                  
                                             <div class="form-group">
                                                <div class="section row mb10">
                                                   <label for="store-name" class="col-sm-2 control-label small">Password:</label>
                                                     <div class="col-sm-10 ph10">
                                                        <input type="Number" name="password" placeholder="Enter Password" class="form-control">   
                                                    </div>
                                                </div>
                                            </div>
                                           
                                            <?php
                                            $vendor=App\vendors::where('user_id','=',Auth::user()->id)->first();
                                             ?>
                                             <div class="form-group">
                                                <div class="section row mb10">
                                                   <label for="store-name" class="col-sm-2 control-label small">Image:</label>
                                                     <div class="col-sm-6 ph10">
                                                        <input type="file" name="image" class="form-control">   
                                                    </div>
                                                    <div class="col-sm-4">
                                                    <img src="{{url('img/products/'.$vendor->image)}}" alt="" style="height: 50px">
                                                </div>
                                                </div>
                                                
                                            </div>
                                            <div class="form-group">
                                                <div class="section row mb10">
                                                   <label for="store-name" class="col-sm-2 control-label small">Banner Image:</label>
                                                     <div class="col-sm-6 ph10">
                                                        <input type="file" name="banner" class="form-control">   
                                                    </div>
                                                    <div class="col-sm-4">
                                                    <img src="{{url('img/products/'.$vendor->banner)}}" alt="" style="height: 50px;">
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            
                                             <input type="hidden" name="vendor_id" value="{{$vendor->id}}">
                                            <div class="form-group">
                                                <div class="section row mb10">
                                                 <label for="store-name" class="col-sm-2 control-label small">Vendor Type:</label>
                                                 <div class="col-sm-10 ph10">
                                                    <select id="vendor_type" name="vendor_type" class="form-control">
                                                        <option value="" disabled selected>Select Vendor Type...</option>
                                                        <option value="retailer" @if($vendor->vendor_type=='retailer') selected @endif>Retailer</option>
                                                        <option value="distributor" @if($vendor->vendor_type=='distributor') selected @endif>Distributor</option>
                                                        <option value="oem" @if($vendor->vendor_type=='oem') selected @endif>OEM</option>
                                                        <option value="none"  @if($vendor->vendor_type=='none') selected @endif>None</option>
                                                    </select>   
                                                </div>
                                            </div>
                                        </div>
                                         <div class="form-group">
                                                <div class="section row mb10">
                                                 <label for="store-name" class="col-sm-2 control-label small">Product Type:</label>
                                                 <div class="col-sm-10 ph10">
                                                    <select id="producttype" name="producttype" class="form-control">
                                            <option value="">Select Product Type...</option>
                                            <option value="Goods"  @if($vendor->producttype=='Goods') selected @endif>Goods</option>
                                            <option value="Services" @if($vendor->producttype=='Services') selected @endif>Services</option>
                                          </select>  
                                                </div>
                                            </div>
                                        </div>

                                        @php
                            $countries=App\city::GroupBy('country_name')->get();
                          
                            @endphp
                              <div class="form-group">
                                                <div class="section row mb10">
                                                 <label for="store-name" class="col-sm-2 control-label small">Country:</label>
                                                 <div class="col-sm-10 ph10">
                                                      <select id="country" name="country" class="form-control">
                                            <option value="">Select Country...</option>
                                            @foreach($countries as $country)
                                            <option value="{{$country->country_name}}" @if($vendor->country==$country->country_name) selected @endif>{{$country->country_name}}</option>
                                            @endforeach
                                          </select>  
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                                <div class="section row mb10">
                                                 <label for="store-name" class="col-sm-2 control-label small">State:</label>
                                                 <div class="col-sm-10 ph10">
                                                      <select id="state" name="state" class="form-control">
                                            <option value="">Select State...</option>
                                             @php
                                            $billing_states=App\state::where('country_name',$vendor->country)->get();
                                            @endphp
                                             @foreach($billing_states as $bi)
                                            <option value="{{$bi->name}}" class="ops" @if($vendor->state==$bi->name) selected @endif>{{$bi->name}}</option>
                                            @endforeach
                                           
                                          </select>
                                                </div>
                                            </div>
                                        </div>
                                         <div class="form-group">
                                                <div class="section row mb10">
                                                 <label for="store-name" class="col-sm-2 control-label small">Location:</label>
                                                 <div class="col-sm-10 ph10">
                                                      <select id="location" name="location" class="form-control">
                                            <option value="">Select Location...</option>
                                               @php
                                    $states=App\city::where('state_name','=',$vendor->state)->get();
                                    @endphp
                                    @foreach($states as $st)
                                            <option value="{{$st->name}}" class="opss" @if($st->name==$vendor->location) selected @endif>{{$st->name}}</option>
                                            
                                           @endforeach
                                          </select>
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                            $(document).ready(function(){
                                $('select[name="country"]').change(function(){
                                    var value=$(this).val();
                                  $.ajax({
                                   url:"{{ url('vendor/country') }}",
                                   method:'get',
                                   data:{country:value},
                                   dataType:'json',
                                     error: function(xhr, status, error) {
                  console.log(xhr.responseText);
                },
                                   success:function(data){
                                    $('.ops').remove();
                                    $("#state").append(data.data);
                                   }
                               });
                                });
                                 $('select[name="state"]').change(function(){
                                    var value=$(this).val();
                                  $.ajax({
                                   url:"{{ url('vendor/state') }}",
                                   method:'get',
                                   data:{state:value},
                                   dataType:'json',
                                     error: function(xhr, status, error) {
                  console.log(xhr.responseText);
                },
                                   success:function(data){
                                    console.log(data);
                                    $('.opss').remove();
                                    $("#location").append(data.data);
                                   }
                               });
                                });
                            })
                        </script>
                        <div class="form-group">
                                                <div class="row">
                                                <label for="store-name" class="col-sm-2 control-label small">Address:<font color="red">*</font></label>
                                                <div class="col-sm-10">
                                                        <input id="address" type="text" class="form-control" name="address" value="{{ $vendor->address}}" required autofocus placeholder="Enter address">
                                                  </div>
                                                </div>
                                            </div>
                                             <div class="form-group">
                                                <div class="row">
                                                <label for="store-name" class="col-sm-2 control-label small">Websie:<font color="red">*</font></label>
                                                <div class="col-sm-10">
                                                         <input id="website" type="text" class="form-control" name="website" value="{{$vendor->url }}"  autofocus placeholder="Enter Website">
                                                  </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                <label for="store-name" class="col-sm-2 control-label small">Cac:<font color="red">*</font></label>
                                                <div class="col-sm-10">
                                                          <input id="phone" type="text" class="form-control" name="cac" value="{{ $vendor->cac }}"  autofocus placeholder="Enter cac">
                                                  </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                <label for="store-name" class="col-sm-2 control-label small">Workspace:<font color="red">*</font></label>
                                                <div class="col-sm-10">
                                                          <input id="workforce" type="text" class="form-control" name="workforce" value="{{ $vendor->workforce }}"  autofocus placeholder="Enter Workforce">
                                                  </div>
                                                </div>
                                            </div>
                                             <div class="form-group">
                                                <div class="row">
                                                <label for="store-name" class="col-sm-2 control-label small">Experience:<font color="red">*</font></label>
                                                <div class="col-sm-10">
                                                          <input id="experience" type="text" class="form-control" name="experience" value="{{ $vendor->yearsofexp}}"  autofocus placeholder="Enter Experience">
                                                  </div>
                                                </div>
                                            </div>
                                             <div class="form-group">
                                                <div class="section row mb10">
                                                 <label for="store-name" class="col-sm-2 control-label small">Rating:</label>
                                                 <div class="col-sm-10 ph10">
                                                      <select id="rating" name="rating" class="form-control">
                                            <option value="">Select Your rating...</option>
                                            <option value="expert" @if($vendor->ratings=='expert') selected @endif>expert</option>
                                            <option value="Professional" @if($vendor->ratings=='Professional') selected @endif>Professional</option>
                                            <option value="technicians" @if($vendor->ratings=='technicians') selected @endif>Technician</option>}
                                            option
                                          </select>
                                                </div>
                                            </div>
                                        </div>
                                         <div class="form-group">
                                                <div class="row">
                                                <label for="contactname" class="col-sm-2 control-label small">Contact Name:<font color="red">*</font></label>
                                                <div class="col-sm-10">
                                                          <input id="contactname" type="text" class="form-control" name="contactname" value="{{ $vendor->contactname}}"  autofocus placeholder="Contact Name">
                                                  </div>
                                                </div>
                                            </div>
                                             <div class="form-group">
                                                <div class="row">
                                                <label for="Contactphone" class="col-sm-2 control-label small">Contact Phone:<font color="red">*</font></label>
                                                <div class="col-sm-10">
                                                          <input id="contactphone" type="text" class="form-control" name="contactphone" value="{{ $vendor->contactphone}}"  autofocus placeholder="Contact Phone">
                                                  </div>
                                                </div>
                                            </div>
                                            
                                             <div class="form-group">
                                                <div class="row">
                                                <label for="contactemail" class="col-sm-2 control-label small">Contact Email:<font color="red">*</font></label>
                                                <div class="col-sm-10">
                                                          <input id="contactemail" type="text" class="form-control" name="contactemail" value="{{ $vendor->contactemail}}"  autofocus placeholder="Contact Email">
                                                  </div>
                                                </div>
                                            </div>
                                             <div class="form-group">
                                                <div class="row">
                                                <label for="chairnamname" class="col-sm-2 control-label small">chairman Name:<font color="red">*</font></label>
                                                <div class="col-sm-10">
                                                          <input id="chairmanname" type="text" class="form-control" name="chairmanname" value="{{ $vendor->chairmanname}}"  autofocus placeholder="Chairman Name">
                                                  </div>
                                                </div>
                                            </div>
                                             <div class="form-group">
                                                <div class="row">
                                                <label for="chairmanphone" class="col-sm-2 control-label small">Chairman Phone:<font color="red">*</font></label>
                                                <div class="col-sm-10">
                                                          <input id="chairmanphone" type="text" class="form-control" name="chairmanphone" value="{{ $vendor->chairmanphone}}"  autofocus placeholder="Chairman Phone">
                                                  </div>
                                                </div>
                                            </div>
                                             <div class="form-group">
                                                <div class="row">
                                                <label for="chairmanemail" class="col-sm-2 control-label small">Chairman Email:<font color="red">*</font></label>
                                                <div class="col-sm-10">
                                                          <input id="chairmanemail" type="text" class="form-control" name="chairmanemail" value="{{ $vendor->chairmanemail}}"  autofocus placeholder="Chairman Email">
                                                  </div>
                                                </div>
                                            </div>
                                        
                                    <button type="submit" class="btn btn-primary" style="margin-top: 10px;margin-left:18rem;">Save</button>
                                            
                                        </div>
                           
                             


                                </form>

                                      </div>

                                    </div>
                            </div>
                              




            

@include('includes_vendor.footer')


