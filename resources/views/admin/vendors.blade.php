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
                            


                           
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-bordered  mg-t" id="table">
                                <thead>
                                <tr class="bg-light">
                                    <th>#</th>
                                    <th class="">Image</th>
                                    <th class="">Name</th>
                                    <th class="">Email</th>
                                    <th class="">Ventor Type</th>
                                    <th class="">Ratings</th>
                                    <th>State</th>
                                    <th>City</th>
                                    <th class="">Status</th>
                                    <th >Verified</th>
                                    <th >vendor ID</th>
                                    <th class="">View</th>

                                </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $serial=1;
                                    @endphp
                                @foreach($vendors as $vendor)
                                    
                                    <tr @if($vendor->User) @if($vendor->User->status==0) bgcolor="lightgray" @endif @endif>
                                        <td>{{$serial}}</td>
                                        <td class="">@if($vendor->image)<img src="{{URL::to('/')}}/img/products/{{$vendor->image}}"  style="height: 50px;width: 50px;">@else <img src="{{URL::to('/')}}/public/images/default-avatar.jpg"  style="height: 50px;width: 50px;">  @endif</td>
                                        <td class=""><a href="{{url('vendors/'.$vendor->user_id)}}" title="">{{$vendor->vendorname}}</a></td>
                                        <td class=""><span style="font-weight: bold;">Email:</span>@if($vendor->User) {{$vendor->User->email}} @endif<br><!--<span style="font-weight: bold;">Password:</span>{{$vendor->password}}--></td>
                                        <td class="">{{$vendor->vendor_type}}</td>

                                        <td class="">{{$vendor->ratings}}</td>
                                        <td >{{$vendor->state}}</td>
                                        <td >{{$vendor->location}}</td>
                                        <td>
                                       @if($vendor->User) @if($vendor->User->status==0)
                                        <a href="{{ URL::to('admin/active_vendor/' . $vendor->user_id ) }}" class="btn btn-info btn-xs">Deactive</a>
                                        @else

                                        
                                             <a href="{{ URL::to('admin/deactive_vendor/' . $vendor->user_id ) }}" class="btn btn-warning btn-xs">Active</a>
                                        @endif  
                                        @endif
                                    </td>
                                    <td >@if($vendor->User->verify==1) yes @else no @endif</td>
                                    <td >{{$vendor->User->user_uniqueid}}</td>
                                        <td class="">
                                           
                                         <a href="{{ url('admin/'.$vendor->user_id.'/view') }}" class="btn btn-primary btn-xs">Edit</a>
                                            
                                        <a href="{{ URL::to('admin/vendor/destroy/' . $vendor->id ) }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure delete this item?')">Delete</a>
                                       @if($vendor->User) @if($vendor->User->status==0)
                                        <a href="{{ url('admin/active_vendor/'.$vendor->User->id) }}" class="btn btn-success btn-xs">Approve</a>
                                        @else
                                             <a href="{{ url('admin/deactive_vendor/'.$vendor->User->id) }}" class="btn btn-primary btn-xs">Reject</a>
                                        @endif  
                                        @endif
                                        </td>
                                        
                                    </tr>
                                    @php
                                    $serial++;
                                    @endphp
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