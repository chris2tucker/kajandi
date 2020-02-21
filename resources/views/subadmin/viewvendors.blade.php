@extends('layouts.subadminlayout')
@section('content')

	<!-- -------------- /Topbar Menu Wrapper -------------- -->

        <!-- -------------- Topbar -------------- -->
        <header id="topbar" class="alt">
            <div class="topbar-left">
                <ol class="breadcrumb">
                    <li class="breadcrumb-icon">
                        <a href="dashboard1.html">
                            <span class="fa fa-home"></span>
                        </a>
                    </li>
                    <li class="breadcrumb-active">
                        <a href="/admin/index">Dashboard</a>
                    </li>
                    <li class="breadcrumb-link">
                        <a href="/admin/vendors">Vendors</a>
                    </li>
                    <li class="breadcrumb-current-item">Add Vendor</li>
                </ol>
            </div>
            <div class="topbar-right">
                <div class="ib topbar-dropdown">
                    <label for="topbar-multiple" class="control-label">Reporting Period</label>
                    <select id="topbar-multiple" class="hidden">
                        <optgroup label="Filter By:">
                            <option value="1-1">Last 30 Days</option>
                            <option value="1-2" selected="selected">Last 60 Days</option>
                            <option value="1-3">Last Year</option>
                        </optgroup>
                    </select>
                </div>
                <div class="ml15 ib va-m" id="sidebar_right_toggle">
                    <div class="navbar-btn btn-group btn-group-number mv0">
                        <button class="btn btn-sm btn-default btn-bordered prn pln">
                            <i class="fa fa-bar-chart fs22 text-default"></i>
                        </button>
                        <button class="btn btn-primary btn-sm btn-bordered hidden-xs"> 3</button>
                    </div>
                </div>
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
                                <div class="panel-title">General Information
                                </div>
                            </div>
                            <div class="panel-body br-t">
                            <div class="allcp-form theme-primary">

                            @if(Session::has('message'))
                            <p class="alert alert-success alert-dismissable fade in">{{ Session::get('status') }}</p>
                            @endif

                            <form method="post" action="/subadmin/{{$vendors->User->id}}/editvendor">
                                {{ csrf_field() }}

                                <div class="section row mb10">
                                    <label for="store-name" class="field-label col-sm-2 ph10  text-center">Vendor Name:</label>

                                    <div class="col-sm-7 ph10">
                                        <label for="store-name" class="field prepend-icon">
                                            <input type="text" name="vendorname" id="business-name" class="gui-input" placeholder="vendor" value="{{$vendors->vendorname}}">
                                            <label for="store-name" class="field-icon">
                                                <i class="fa fa-user"></i>
                                            </label>
                                        </label>
                                    </div>
                                </div>

                                <div class="section row mb10">
                                    <label for="store-phone" class="field-label col-sm-2 ph10 text-center">Vendor Type:</label>

                                    <div class="col-sm-5 ph10">
                                    		<label class="field select">
	                                        <select id="location" name="vendor_type">
	                                        	<option value="">Select Vendor Type...</option>
	                                        	<option value="retailer" 
                                                    @if($vendors->vendor_type == 'retailer')
                                                        selected = 'selected'
                                                    @endif
                                                >Retailer</option>
	                                        	<option value="distributor" 
                                                    @if($vendors->vendor_type == 'distributor')
                                                        selected = 'selected'
                                                    @endif
                                                >Distributor</option>
	                                        	<option value="oem"
                                                    @if($vendors->vendor_type == 'oem')
                                                        selected = 'selected'
                                                    @endif
                                                >OEM</option>
	                                        	<option value="none"
                                                    @if($vendors->vendor_type == 'none')
                                                        selected = 'selected'
                                                    @endif
                                                >None</option>
	                                        </select>
	                                       </label>
                                    </div>
                                </div>

                                <div class="section row mb10">
                                    <label for="store-phone" class="field-label col-sm-2 ph10 text-center">Type of product:</label>

                                    <div class="col-sm-5 ph10">
                                    		<label class="field select">
	                                        <select id="location" name="producttype">
	                                        	<option value="">Select Product Type...</option>
	                                        	<option value="Goods"
                                                    @if($vendors->producttype == 'Goods')
                                                        selected = 'selected'
                                                    @endif
                                                >Goods</option>
	                                        	<option value="Services"
                                                    @if($vendors->producttype == 'Services')
                                                        selected = 'selected'
                                                    @endif
                                                >Services</option>
	                                        </select>
	                                       </label>
                                    </div>
                                </div>

                                <div class="section row mb10">
                                    <label for="store-phone" class="field-label col-sm-2 ph10 text-center">Location:</label>

                                    <div class="col-sm-5 ph10">
                                    		<label class="field select">
	                                        <select id="location" name="location">
	                                        	<option value="">Select Location...</option>
	                                        	<option value="Foreign"
                                                    @if($vendors->location == 'Foreign')
                                                        selected = 'selected'
                                                    @endif
                                                >Foreign</option>
	                                        	<option value="Local"
                                                    @if($vendors->location == 'Local')
                                                        selected = 'selected'
                                                    @endif
                                                >Local</option>
	                                        </select>
	                                       </label>
                                    </div>
                                </div>

                                <div class="section row mb10">
                                    <label for="store-address" class="field-label col-sm-2 ph10 text-center">Address:</label>

                                    <div class="col-sm-7 ph10">
                                        <label for="store-address" class="field prepend-icon">
                                            <input type="text" name="address" id="address" class="gui-input" placeholder="Address" value="{{$vendors->address}}">
                                        <label for="address" class="field-icon">
                                            <i class="fa fa-home"></i>
                                        </label>
                                        </label>
                                    </div>
                                </div>
                                <div class="section row mb10">
                                    <label for="store-email" class="field-label col-sm-2 ph10 text-center">email:</label>

                                    <div class="col-sm-7 ph10">
                                        <label for="store-email" class="field prepend-icon">
                                            <input type="text" name="email" id="store-email" class="gui-input" placeholder="info@site.com" value="{{$vendors->User->email}}">
                                            <label for="store-email" class="field-icon">
                                                <i class="fa fa-envelope-o"></i>
                                            </label>
                                        </label>
                                    </div>
                                </div>
                                <div class="section row mb10">
                                    <label for="store-country" class="field-label col-sm-2 ph10 text-center">Country:</label>

                                    <div class="col-sm-7 ph10">
                                        <label for="store-country" class="field prepend-icon">
                                            <input type="text" name="country" id="address" class="gui-input" placeholder="Country" value="{{$vendors->country}}">
                                        <label for="address" class="field-icon">
                                            <i class="fa fa-building-o"></i>
                                        </label>
                                        </label>
                                    </div>
                                </div>

                                <div class="section row mb10">
                                    <label for="store-country" class="field-label col-sm-2 ph10 text-center">URL/website:</label>

                                    <div class="col-sm-7 ph10">
                                        <label for="store-url" class="field prepend-icon">
				                            <input type="text" name="url" id="store-url" class="gui-input" placeholder="http://yoursite.com/shop" value="{{$vendors->url}}">
				                            <label for="store-url" class="field-icon">
				                                <i class="fa fa-link"></i>
				                            </label>
				                        </label>
                                    </div>
                                </div>

                                <div class="section row mb10">
                                    <label for="store-country" class="field-label col-sm-2 ph10 text-center">CAC No:</label>

                                    <div class="col-sm-7 ph10">
                                        <label for="store-url" class="field prepend-icon">
				                            <input type="text" name="cac" id="store-url" class="gui-input" placeholder="CAC No" value="{{$vendors->cac}}">
				                            <label for="store-url" class="field-icon">
				                                <i class="fa fa-qrcode"></i>
				                            </label>
				                        </label>
                                    </div>
                                </div>

                                <div class="section row mb10">
                                    <label for="store-phone" class="field-label col-sm-2 ph10 text-center">Workforce:</label>

                                    <div class="col-sm-7 ph10">
                                        <label for="store-phone" class="field prepend-icon">
                                            <input type="text" name="workforce" id="store-phone" class="gui-input" placeholder="Workforce" value="{{$vendors->workforce}}">
                                            <label for="store-phone" class="field-icon">
                                                <i class="fa fa-user"></i>
                                            </label>
                                        </label>
                                    </div>
                                </div>

                                <div class="section row mb10">
                                    <label for="store-phone" class="field-label col-sm-2 ph10 text-center">Years of Experience:</label>

                                    <div class="col-sm-7 ph10">
                                        <label for="store-phone" class="field prepend-icon">
                                            <input type="text" name="yearsofexp" id="store-phone" class="gui-input" placeholder="years of experience" value="{{$vendors->yearsofexp}}">
                                            <label for="store-phone" class="field-icon">
                                                <i class="fa fa-mobile-phone"></i>
                                            </label>
                                        </label>
                                    </div>
                                </div>

                                <div class="section row mb10">
                                    <label for="store-phone" class="field-label col-sm-2 ph10 text-center">Ratings:</label>

                                    <div class="col-sm-5 ph10">
                                    		<label class="field select">
	                                        <select id="ratings" name="ratings">
	                                        	<option value="">Select Rattings...</option>
	                                        	<option value="Experts" 
                                                    @if($vendors->ratings == 'Experts')
                                                        selected = 'selected'
                                                    @endif
                                                >Experts</option>
	                                        	<option value="Professional"
                                                    @if($vendors->ratings == 'Professional')
                                                        selected = 'selected'
                                                    @endif
                                                >Professional</option>
	                                        	<option value="Technicians"
                                                    @if($vendors->ratings == 'Technicians')
                                                        selected = 'selected'
                                                    @endif
                                                >Technicians</option>
	                                        </select>
	                                       </label>
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
                                    <label for="store-phone" class="field-label col-sm-2 ph10 text-center">Name:</label>

                                    <div class="col-sm-7 ph10">
                                        <label for="store-phone" class="field prepend-icon">
                                            <input type="text" name="contactname" id="store-phone" class="gui-input" placeholder="Name" value="{{$vendors->contactname}}">
                                            <label for="store-phone" class="field-icon">
                                                <i class="fa fa-user"></i>
                                            </label>
                                        </label>
                                    </div>
                                </div>
                                <div class="section row mb10">
                                    <label for="store-email" class="field-label col-sm-2 ph10 text-center">Phone number:</label>

                                    <div class="col-sm-7 ph10">
                                        <label for="store-email" class="field prepend-icon">
                                            <input type="text" name="contactphone" id="store-email" class="gui-input" placeholder="080-123-4567" value="{{$vendors->contactphone}}">
                                            <label for="store-email" class="field-icon">
                                                <i class="fa fa-phone"></i>
                                            </label>
                                        </label>
                                    </div>
                                </div>

                                <div class="section row mb10">
                                    <label for="store-email" class="field-label col-sm-2 ph10 text-center">email:</label>

                                    <div class="col-sm-7 ph10">
                                        <label for="store-email" class="field prepend-icon">
                                            <input type="text" name="contactemail" id="store-email" class="gui-input" placeholder="info@site.com" value="{{$vendors->contactemail}}">
                                            <label for="store-email" class="field-icon">
                                                <i class="fa fa-envelope-o"></i>
                                            </label>
                                        </label>
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
                                    <label for="store-phone" class="field-label col-sm-2 ph10 text-center">Name:</label>

                                    <div class="col-sm-7 ph10">
                                        <label for="store-phone" class="field prepend-icon">
                                            <input type="text" name="chairmanname" id="store-phone" class="gui-input" placeholder="Name" value="{{$vendors->chairmanname}}">
                                            <label for="store-phone" class="field-icon">
                                                <i class="fa fa-user"></i>
                                            </label>
                                        </label>
                                    </div>
                                </div>

                                <div class="section row mb10">
                                    <label for="store-email" class="field-label col-sm-2 ph10 text-center">Phone number:</label>

                                    <div class="col-sm-7 ph10">
                                        <label for="store-email" class="field prepend-icon">
                                            <input type="text" name="chairmanphone" id="store-email" class="gui-input" placeholder="080-123-4567" value="{{$vendors->chairmanphone}}">
                                            <label for="store-email" class="field-icon">
                                                <i class="fa fa-phone"></i>
                                            </label>
                                        </label>
                                    </div>
                                </div>

                                <div class="section row mb10">
                                    <label for="store-email" class="field-label col-sm-2 ph10 text-center">email:</label>

                                    <div class="col-sm-7 ph10">
                                        <label for="store-email" class="field prepend-icon">
                                            <input type="text" name="chairmanemail" id="store-email" class="gui-input" placeholder="info@site.com" value="{{$vendors->chairmanemail}}">
                                            <label for="store-email" class="field-icon">
                                                <i class="fa fa-envelope-o"></i>
                                            </label>
                                        </label>
                                    </div>
                                </div>

                                    

                            </div>
                        </div>

                        @include('layouts.errors')

                        <div class="panel-footer text-right">
                                <button type="submit" class="btn btn-bordered btn-primary mb5"> UPDATE</button>
                        </div>

                        </div>

                        </form>

                    </div>



                </div>
            </div>
            <!-- -------------- /Column Center -------------- -->

@endsection