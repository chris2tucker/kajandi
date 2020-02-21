<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Shipping Managment</title>
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
                    
                    <li class="breadcrumb-current-item">Shipping Managment</li>
                </ol>
            </div>
            
        </header>

            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><em class="ti-user mr5"></em>Shipping</h3>
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
                               
                                
                                        <a href="{{ url('admin/shipping/add') }}" class="btn btn-bordered btn-primary mb5 btn_add"><span class="ti-plus"></span> ADD Shipping</a>
                                        <a href="{{ url('admin/shipping/city') }}" class="btn btn-bordered btn-primary mb5 btn_add"><span class="ti-plus"></span> ADD City</a>
                                        <a href="{{ url('admin/shipping/state') }}" class="btn btn-bordered btn-primary mb5 btn_add"><span class="ti-plus"></span> ADD State</a>
                                        <a href="{{ url('admin/shipping/country') }}" class="btn btn-bordered btn-primary mb5 btn_add"><span class="ti-plus"></span> ADD Country</a>
                                         <a href="{{ url('admin/shipping/manual_shipping') }}" class="btn btn-bordered btn-primary mb5 btn_add"><span class="ti-plus"></span>Mannual Shipping </a>
                                    
                                </div>
                           
                            &nbsp;
                            
                     <div class="panel-body">

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mg-t" id="table">
                                <thead>
                                <tr class="bg-light">
                                    <th class="text-center"></th>
                                    <!--<th class="">State</th>
                                    <th class="">City</th>
                                    <th>Country</th>-->
                                    <th>Zone</th>
                                    <th class="">Amount/kg</th>
                                    <th class="">Amount/volumn</th>
                                    <th class="">Action</th>

                                </tr>
                                </thead>
                                <tbody>
                                @if(count($shipping)>0)
                                @foreach($shipping as $ship)
                                <tr>
                                    <td>{{$ship->id}}</td>
                                   <!-- <td>{{$ship->state}}</td>
                                    <td>{{$ship->city}}</td>
                                    <td>{{$ship->country}}</td>-->
                                    <td>{{$ship->zone}}</td>
                                    <td>{{$ship->ammount_per_kg}}</td>
                                    <td>{{$ship->ammount_per_valume}}</td>
                                    <td><a href="{{url('admin/shipping/edit/'.$ship->id)}}" title="">Edit</a></td>
                                </tr>

                                @endforeach

                                @endif
                                
                               
                                </tbody>
                            </table>
           
                    </div>
                                <!-- -------------- /form -------------- -->



                            </div>
                            <div class="panel-body">

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mg-t" id="city">
                                <thead>
                                <tr class="bg-light">
                                    <th class="text-center"></th>
                                    <!--<th class="">State</th>
                                    <th class="">City</th>
                                    <th>Country</th>-->
                                    <th>City</th>
                                   <th>State</th>
                                   <th>Country</th>
                                    <th class="">Action</th>

                                </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $cities=App\city::all();
                                    @endphp

                                @if(count($cities)>0)
                                @foreach($cities as $city)
                                <tr>
                                    <td>{{$city->id}}</td>
                                   <!-- <td>{{$ship->state}}</td>
                                    <td>{{$ship->city}}</td>
                                    <td>{{$ship->country}}</td>-->
                                    <td>{{$city->name}}</td>
                                    <td>{{$city->state_name}}</td>
                                    <td>{{$city->country_name}}</td>
                                    
                                    <td><a href="{{url('admin/city/edit/'.$city->id)}}" title="">Edit</a></td>
                                </tr>

                                @endforeach

                                @endif
                                
                               
                                </tbody>
                            </table>
           
                    </div>
                                <!-- -------------- /form -------------- -->



                            </div>
                            <div class="panel-body">

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mg-t" id="country">
                                <thead>
                                <tr class="bg-light">
                                    <th class="text-center"></th>
                                    <!--<th class="">State</th>
                                    <th class="">City</th>
                                    <th>Country</th>-->
                                    <th>Country</th>
                                   
                                    <th class="">Action</th>

                                </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $cities=App\country::all();
                                    @endphp

                                @if(count($cities)>0)
                                @foreach($cities as $city)
                                <tr>
                                    <td>{{$city->id}}</td>
                                   <!-- <td>{{$ship->state}}</td>
                                    <td>{{$ship->city}}</td>
                                    <td>{{$ship->country}}</td>-->
                                    <td>{{$city->name}}</td>
                                    
                                    <td><a href="{{url('admin/country/edit/'.$city->id)}}" title="">Edit</a></td>
                                </tr>

                                @endforeach

                                @endif
                                
                               
                                </tbody>
                            </table>
           
                    </div>
                                <!-- -------------- /form -------------- -->



                            </div>
                            <div class="panel-body">

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mg-t" id="state">
                                <thead>
                                <tr class="bg-light">
                                    <th class="text-center"></th>
                                    <!--<th class="">State</th>
                                    <th class="">City</th>
                                    <th>Country</th>-->
                                    <th>State</th>
                                   <th>Country</th>
                                   <th >Zone</th>
                                    <th class="">Action</th>

                                </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $cities=App\state::all();
                                    @endphp

                                @if(count($cities)>0)
                                @foreach($cities as $city)
                                <tr>
                                    <td>{{$city->id}}</td>
                                   <!-- <td>{{$ship->state}}</td>
                                    <td>{{$ship->city}}</td>
                                    <td>{{$ship->country}}</td>-->
                                    <td>{{$city->name}}</td>
                                    <td>{{$city->country_name}}</td>
                                    <td >{{$city->zone}}</td>
                                   <td><a href="{{url('admin/state/edit/'.$city->id)}}" title="">Edit</a></td>
                                </tr>

                                @endforeach

                                @endif
                                
                               
                                </tbody>
                            </table>
           
                    </div>
                                <!-- -------------- /form -------------- -->



                            </div>
                            <div class="panel-body">
                                <div class="panel-heading">Manual Shipping</div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mg-t" id="manual">
                                <thead>
                                <tr class="bg-light">

                                    <th>Product</th>
                                   <th>City</th>
                                   <th >Shipping</th>
                                    <th class="">Action</th>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach($manualShipping as $shipping)
                                <tr>
                                    <td>{{$shipping->product ? $shipping->product->name : $shipping->vendorproduct_id}}</td>
                                    <td>{{$shipping->city}}</td>
                                    <td>{{$shipping->shipping}}</td>
                                   <td><a href="{{url('admin/shipping/manual_shipping/'.$shipping->id)}}" title="">Edit</a></td>
                                </tr>

                                @endforeach


                                </tbody>
                            </table>

                    </div>
                                <!-- -------------- /form -------------- -->



                            </div>
                        </div>

                    </div>



                </div>
            </div>
<script>
    $(document).ready(function(){
        $(document).ready( function () {
    $('#city').DataTable();
} );
            $(document).ready( function () {
    $('#country').DataTable();
} );
                $(document).ready( function () {
                    $('#state').DataTable();
                    $('#manual').DataTable();
} );
    })
</script>
@include('includes.footer')