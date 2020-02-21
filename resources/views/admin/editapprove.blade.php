<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Vendor Product</title>
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
                    <li class="breadcrumb-current-item">Vendors</li>
                </ol>
            </div>
            
        </header>

            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><em class="ti-user mr5"></em>VENDORS</h3>
                </div>
            </div>


         
            <!-- -------------- /Column Left -------------- -->

            <!-- -------------- Column Center -------------- -->
            <div class="chute chute-center">

                <div class="mw1000 center-block">

                    <!-- -------------- Spec Form -------------- -->
                    <div class="allcp-form">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a href="{{ url('admin/addvendor') }}" class="btn btn-bordered btn-primary mb5"><span class="ti-plus"></span> ADD VENDOR</a>
                                  <a href="{{ url('admin/edit/approve/vendors') }}" class="btn btn-bordered btn-primary mb5"><span class="ti-plus"></span> Edit Approve</a>
                            </div>
                            @php
                            $vendors=App\profilehistory::where('edits','=',0)->get();

                            @endphp
                           
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mg-t" id="table">
                                <thead>
                                <tr class="bg-light">
                                    
                                    <th class="">Name</th>
                                    <th class="">address</th>
                                    <th class="">Ventor Type</th>
                                    <th class="">Ratings</th>
                                    <th class="">country</th>
                                    <th class="">approve</th>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach($vendors as $vendor)
                                <tr>
                                    <td>{{$vendor->name}}</td>
                                    <td>{{$vendor->address}}</td>
                                    <td>{{$vendor->vendor_type}}</td>
                                    <td>{{$vendor->ratings}}</td>
                                    <td>{{$vendor->country}}</td>
                                    <td><<a href="{{url('admin/approve/vendor/'.$vendor->vendor_id)}}" title="">Approve</a></td>
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

            <!-- -------------- /Column Center -------------- -->


<script type="text/javascript">
    $(document).ready(function() {
    
} );
</script>

@include('includes.footer')