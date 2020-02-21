<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Vendor</title>
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
                        <a href="{{url('admin/vendors')}}">Vendors</a>
                    </li>
                    <li class="breadcrumb-current-item">Add Vendor</li>
                </ol>
            </div>
            
        </header>

         
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
                            <div class="allcp-form theme-primary">

                          

                            <form method="post" action="{{ url('admin/addnewvendor') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <div class="section row mb10">
                                    <label for="store-name" class="col-sm-2 control-label small">Image:</label>

                                    <div class="col-sm-10 ph10">
                                            <input type="file" name="image" id="business-name" class="form-control image" >
                                            
                                    </div>
                                </div>

                                <div class="section row mb10">
                                    <label for="store-name" class="col-sm-2 control-label small">Vendor Name:</label>
                                    <div class="col-sm-10 ph10">
                                            <input type="text" name="vendorname" id="business-name" class="form-control" placeholder="vendor">
                                    </div>
                                </div>

                                <div class="section row mb10">
                                    <label for="store-phone" class="col-sm-2 control-label small">Vendor Type:</label>
                                    <div class="col-sm-10 ph10">
	                                        <select id="location" name="vendor_type" class="form-control">
	                                        	<option value="">Select Vendor Type...</option>
	                                        	<option value="retailer">Retailer</option>
	                                        	<option value="distributor">Distributor</option>
	                                        	<option value="oem">OEM</option>
	                                        	<option value="none">None</option>
	                                        </select>
	                                       
                                    </div>
                                </div>

                                <div class="section row mb10">
                                    <label for="store-phone" class="col-sm-2 control-label small">Type of product:</label>

                                    <div class="col-sm-10 ph10">
	                                        <select id="location" name="producttype" class="form-control">
	                                        	<option value="">Select Product Type...</option>
	                                        	<option value="Goods">Goods</option>
	                                        	<option value="Services">Services</option>
	                                        </select>
                                    </div>
                                </div>

                                <!--<div class="section row mb10">
                                    <label for="store-phone" class="col-sm-2 control-label small">Location:</label>

                                    <div class="col-sm-10 ph10">
	                                        <select id="location" name="location" class="form-control">
	                                        	<option value="">Select Location...</option>
	                                        	<option value="Foreign">Foreign</option>
	                                        	<option value="Local">Local</option>
	                                        </select>
                                    </div>
                                </div>-->
                                 <div class="section row mb10">
                                    <label for="store-phone" class="col-sm-2 control-label small">Country:</label>

                                     @php
                            $countries=App\country::all();
                            
                            @endphp
                            <div class="col-sm-10 ph10">
                                 <select id="country" name="country" class="form-control">
                                            <option value="">Select Country...</option>
                                            @foreach($countries as $country)
                                            <option value="{{$country->name}}">{{$country->name}}</option>
                                            @endforeach
                                          </select>

                                @if ($errors->has('city'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                @endif
                            </div>
                                </div>
                              
                        <div class="section row mb10">
                                    <label for="store-phone" class="col-sm-2 control-label small">State:</label>
                            <div class="col-sm-10 ph10">
                                 <select id="state" name="state" class="form-control">
                                            <option value="">Select State...</option>
                                           
                                          </select>

                                @if ($errors->has('location'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('location') }}</strong>
                                    </span>
                                @endif
                            </div>
                                </div>

                                <div class="section row mb10">
                                    <label for="store-phone" class="col-sm-2 control-label small">Location:</label>

                                    <div class="col-sm-10 ph10">
                                            <select id="location" name="location" class="form-control">
                                            <option value="">Select Location...</option>
                                           
                                          </select>

                                @if ($errors->has('location'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('location') }}</strong>
                                    </span>
                                @endif
                                        
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
                                    $("select[name='location']").append(data.data);
                                   }
                               });
                                });
                            })
                        </script>
                                <div class="section row mb10">
                                    <label for="store-address" class="col-sm-2 control-label small">Address:</label>

                                    <div class="col-sm-10 ph10">
                                            <input type="text" name="address" id="address" class="form-control" placeholder="Address"> 
                                    </div>
                                </div>
                                <div class="section row mb10">
                                    <label for="store-email" class="col-sm-2 control-label small">Email:</label>

                                    <div class="col-sm-10 ph10">
                                            <input type="text" name="email" id="store-email" class="form-control" placeholder="info@site.com">
                                    </div>
                                </div>
                                <div class="section row mb10">
                                    <label for="store-email" class="col-sm-2 control-label small">Password:</label>

                                    <div class="col-sm-10 ph10">
                                            <input type="password" name="password" id="store-email" class="form-control" placeholder="******">
                                    </div>
                                </div>
                               <!-- <div class="section row mb10">
                                    <label for="store-country" class="col-sm-2 control-label small">Country:</label>

                                    <div class="col-sm-10 ph10">
                                            <input type="text" name="country" id="address" class="form-control" placeholder="Country">
                                    </div>
                                </div>-->

                                <div class="section row mb10">
                                    <label for="store-country" class="col-sm-2 control-label small">URL/website:</label>

                                    <div class="col-sm-10 ph10">
				                            <input type="text" name="url" id="store-url" class="form-control" placeholder="http://yoursite.com/shop">  
                                    </div>
                                </div>

                                <div class="section row mb10">
                                    <label for="store-country" class="col-sm-2 control-label small">CAC No:</label>

                                    <div class="col-sm-10 ph10">
				                            <input type="text" name="cac" id="store-url" class="form-control" placeholder="CAC No">
                                    </div>
                                </div>

                                <div class="section row mb10">
                                    <label for="store-phone" class="col-sm-2 control-label small">Workforce:</label>

                                    <div class="col-sm-10 ph10">
                                            <input type="text" name="workforce" id="store-phone" class="form-control" placeholder="Workforce" >
                                    </div>
                                </div>

                                <div class="section row mb10">
                                    <label for="store-phone" class="col-sm-2 control-label small">Years of Experience:</label>

                                    <div class="col-sm-10 ph10">
                                            <input type="text" name="yearsofexp" id="store-phone" class="form-control" placeholder="years of experience">    
                                    </div>
                                </div>

                                <div class="section row mb10">
                                    <label for="store-phone" class="col-sm-2 control-label small">Ratings:</label>

                                    <div class="col-sm-5 ph10">
	                                        <select id="ratings" name="ratings" class="form-control">
	                                        	<option value="">Select ratings...</option>
	                                        	<option value="experts">Experts</option>
	                                        	<option value="professional">Professional</option>
	                                        	<option value="technicians">Technicians</option>
	                                        </select>
                                    </div>
                                </div>

                                

                                

                                </div>
                                </div>
                                </div>

                        <div class="panel">
                            <div class="panel-heading">
                                <div class="panel-title">Contact Person
                                </div>
                            </div>
                            <div class="panel-body br-t">
                            <div class="allcp-form theme-primary">
                                <div class="section row mb10">
                                    <label for="store-phone" class="col-sm-2 control-label small">Name:</label>

                                    <div class="col-sm-10 ph10">
                                            <input type="text" name="contactname" id="store-phone" class="form-control" placeholder="Name">
                                    </div>
                                </div>
                                <div class="section row mb10">
                                    <label for="store-email" class="col-sm-2 control-label small">Phone number:</label>

                                    <div class="col-sm-10 ph10">
                                            <input type="text" name="contactphone" id="store-email" class="form-control" placeholder="080-123-4567">
                                    </div>
                                </div>

                                <div class="section row mb10">
                                    <label for="store-email" class="col-sm-2 control-label small">email:</label>

                                    <div class="col-sm-10 ph10">
                                            <input type="text" name="contactemail" id="store-email" class="form-control" placeholder="info@site.com">
                                    </div>
                                </div>
                               </div>
                               </div>
                               </div>


                               <div class="panel">
                            <div class="panel-heading">
                                <div class="panel-title">MD/CHAIRMAN
                                </div>
                            </div>
                            <div class="panel-body br-t">
                            <div class="allcp-form theme-primary">

                                <div class="section row mb10">
                                    <label for="store-phone" class="col-sm-2 control-label small">Name:</label>

                                    <div class="col-sm-10 ph10">
                                            <input type="text" name="chairmanname" id="store-phone" class="form-control" placeholder="Name">
                                    </div>
                                </div>

                                <div class="section row mb10">
                                    <label for="store-email" class="col-sm-2 control-label small">Phone number:</label>

                                    <div class="col-sm-10 ph10">
                                            <input type="text" name="chairmanphone" id="store-email" class="form-control" placeholder="080-123-4567">
                                    </div>
                                </div>

                                <div class="section row mb10">
                                    <label for="store-email" class="col-sm-2 control-label small">email:</label>

                                    <div class="col-sm-10 ph10">
                                            <input type="text" name="chairmanemail" id="store-email" class="form-control" placeholder="info@site.com">
                                    </div>
                                </div>

                                    

                            </div>
                        </div>

                        <div class="panel-footer text-right">
                                <button type="submit" class="btn btn-bordered btn-primary mb5"> SAVE</button>
                        </div>

                        </div>

                        </form>

                    </div>



                </div>
            </div>
            <!-- -------------- /Column Center -------------- -->
@include('includes.footer')