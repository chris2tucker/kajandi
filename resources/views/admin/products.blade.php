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
                    <li class="breadcrumb-current-item">Products</li>
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
                                <div class="panel-title">PRODUCTS
                                </div>
                            </div>
                            <div class="panel-body">
                                        <div class="col-md-4">
                                            <div class="section">
                                                <div class="text-default">
                                
                                <a href="{{ url('admin/addproduct') }}" class="btn btn-bordered btn-primary mb5"> ADD PRODUCTS</a>
                            					</div>
                                            </div>
                                        </div>

                                    <br>
                                    <br>



                                    <div class="col-md-12">
                    <div class="panel">
                    <div class="panel-menu p12 allcp-form theme-primary mtn">
                        <div class="row">
                            <div class="col-md-2 pb5">
                                <label class="field select">
                                    <select id="bulk-action" name="bulk-action">
                                        <option value="0">Actions</option>
                                        <option value="1">Edit</option>
                                        <option value="2">Delete</option>
                                        <option value="3">Active</option>
                                        <option value="4">Inactive</option>
                                    </select>
                                    <i class="arrow double"></i>
                                </label>
                            </div>
                            <div class="col-md-5 pb5">
                                <label class="field select">
                                    <select id="filter-category" name="filter-category">
                                        <option value="0">Filter by Category</option>
                                        <option value="1">iPhone</option>
                                        <option value="2">iPad</option>
                                        <option value="3">iMac</option>
                                    </select>
                                    <i class="arrow"></i>
                                </label>
                            </div>
                            <div class="col-md-5 pb5">
                                <label class="field select">
                                    <select id="filter-status" name="filter-status">
                                        <option value="0">Filter by Status</option>
                                        <option value="1">Active</option>
                                        <option value="2">Inactive</option>
                                        <option value="3">Low Stock</option>
                                        <option value="4">Out of Stock</option>
                                    </select>
                                    <i class="arrow"></i>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body pn">
                        <div class="table-responsive">
                            <table class="table allcp-form theme-warning tc-checkbox-1 fs13" id="table">
                                <thead>
                                <tr class="bg-light">
                                    <th class="text-center"></th>
                                    <th class="">Image</th>
                                    <th class="">Product Title</th>
                                    <th class="">SKU</th>
                                    <th class="">View</th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i = 1;
                                ?>
                                @foreach($products as $key)
                                
                                    <tr>
                                        <td class="text-center">{{ $i++ }}</td>
                                        <td class="w100"><img class="img-responsive mw40 ib mr10" title="user"
                                             src="{{url('/')}}/{{$key->image}}"></td>
                                        <td>{{$key->name}}</td>
                                        <td>{{$key->partnumber}}</td>
                                        <td>
                                            <a href="{{ url('admin/viewproduct/'.$key->id) }}" class="btn btn-primary">view</a>
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