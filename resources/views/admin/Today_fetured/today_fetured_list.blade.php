<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Today Featured</title>
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
                        <a href="{{url('admin/today_fetured')}}">Today Featured</a>
                    </li>
                   
                </ol>
            </div>
            
        </header>
         <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><em class="ti-user mr5"></em>Today Featured</h3>
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
                                <a href="{{ url('admin/add_today_fetured') }}" class="btn btn-bordered btn-primary mb5">ADD TODAY FEATURED</a>
                            </div>
                    
                            <div class="panel-body pn">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped mg-t" id="table">
                                        <thead>
                                        <tr>
                                            <th class="va-m">S/N</th>
                                            <th>Image</th>
                                            <th>Vendor Name</th>
                                            <th>Product Name</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        
                                        <tbody>
                                        
                                          @foreach($today_featured as $key)
                                            <tr>
                                                <td>{{$key->id}}</td>
                                                   <td><img class="" src="{{ asset('public/img/' . $key->today_image) }}"  height="50" width="50"></td>
                                                    <td>{{$key->vendorname}}</td>
                                                    <td>{{$key->name}}</td>
                                                    <td>
                                                        <a href="{{ url('/admin/edit_featured/'.$key->id) }}" class="btn btn-primary btn-xs">Edit</a>
                                                        <a href="{{ url('/admin/delete_today_feature/'.$key->id) }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure?')">Delete</a>
                                                    </td>

                                            </tr>
                                          @endforeach
                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                       

                                

                                <!-- -------------- /form -------------- -->



                            </div>
                        </div>

                    </div>



                </div>
            </div>
            <!-- -------------- /Column Center -------------- -->
@include('includes.footer')
