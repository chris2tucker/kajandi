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
                        <a href="/admin/index">Home</a>
                    </li>
                    <li class="breadcrumb-current-item">Vendors</li>
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
                                <div class="panel-title">VENDORS
                                </div>
                            </div>
                            <div class="panel-body">

                                    <br>
                                    <br>



                                    <div class="col-md-12">
                        <div class="panel panel-visible" id="spy3">
                            <div class="panel-heading">
                                <div class="panel-title hidden-xs">
                                    List of Vendors
                                </div>
                            </div>
                            <div class="panel-body pn">
                        <div class="table-responsive">
                            <table class="table allcp-form theme-warning tc-checkbox-1 fs13">
                                <thead>
                                <tr class="bg-light">
                                    <th class="">Name</th>
                                    <th class="">Email</th>
                                    <th class="">Ventor Type</th>
                                    <th class="">Ratings</th>
                                    <th class="">View</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($vendors as $vendor)
                                    <tr>
                                        <td class="">{{$vendor->vendorname}}</td>
                                        <td class="">{{$vendor->User->email}}</td>
                                        <td class="">{{$vendor->vendor_type}}</td>
                                        <td class="">{{$vendor->ratings}}</td>
                                        <td class=""><a href="/subadmin/{{$vendor->User->id}}/view" class="btn btn-bordered btn-primary mb5">View</a></td>
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