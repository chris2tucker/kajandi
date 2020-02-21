@extends('layouts.adminlayout')
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
                        <a href="/admin/index">Home</a>
                    </li>
                    <li class="breadcrumb-current-item">Sub Category</li>
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
                                <div class="panel-title">Sub Categories
                                </div>
                            </div>
                            <div class="panel-body">

                             @if(Session::has('status'))
                            <p class="alert alert-success alert-dismissable fade in">{{ Session::get('status') }}</p>
                            @endif
                             @include('layouts.errors')
                             <div class="col-md-4">
                                            <div class="section">
                                                <div class="text-default">
                                
                                                 <a href="{{ url('admin/adv_sec_1/create') }}" class="btn btn-bordered btn-primary mb5">ADD ADV SECTION 1</a>
                                                </div>
                                            </div>
                                        </div>

                                
                                <br>
                                <br>

                <div class="col-md-12">
                        <div class="panel panel-visible" id="spy3">
                            <div class="panel-heading">
                                <div class="panel-title hidden-xs">
                                    List of Advertisement Section 1
                                </div>
                            </div>
                            <div class="panel-body pn">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover" id="table" cellspacing="0"
                                           width="100%">
                                        <thead>
                                        <tr>
                                            <th class="va-m">S/N</th>
                                            <th class="va-m">Image</th>
                                            <th class="va-m">Vendor</th>
                                            <th class="va-m">Product</th>
                                            <th class="va-m">Action</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th class="va-m">S/N</th>
                                            <th class="va-m">Image</th>
                                            <th class="va-m">Vendor</th>
                                            <th class="va-m">Product</th>
                                            <th class="va-m">Action</th>
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                        
                                          @foreach($adv_sec_1_data as $value)
                                            <tr>
                                                <td>{{$value->id}}</td>
                                                <td><img src="{{URL::to('/')}}/public/img/{{$value->image}}" style="height: 50px;width: 50px;"></td>
                                                <td>{{$value->vendorname}}</td>
                                                <td>{{$value->name}}</td>
                                                
                                                <td>
                                                    
                                                    <a href="{{ URL::to('admin/adv_sec_1/' . $value->id . '/edit') }}" class="btn btn-primary btn-xs">Edit</a>
                                                    <a href="{{ URL::to('admin/adv_sec_1/destroy/' . $value->id ) }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure delete this item?')">Delete</a>
                                                </td>
                                            </tr>
                                          @endforeach
                                        
                                        </tbody>
                                    </table>
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
@endsection
