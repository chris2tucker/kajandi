<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Banner</title>
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
                        <a href="{{url('admin/banner')}}">Banner</a>
                    </li>
                   
                </ol>
            </div>
            
        </header>
         
     <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><em class="ti-user mr5"></em>Banner</h3>
                </div>
            </div>
            <div class="chute chute-center">

                <div class="mw1000 center-block">

                    <!-- -------------- Spec Form -------------- -->
                    <div class="allcp-form">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a href="{{ url('admin/banner/create') }}" class="btn btn-bordered btn-primary mb5">ADD BANNER</a>
                            </div>
                            


                
                            <div class="panel-body pn">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped mg-t" id="table">
                                        <thead>
                                        <tr>
                                         
                                            <th class="va-m">Image</th>
                                            <th class="va-m">Banner Text</th>
                                            <th class="va-m">Banner URL</th>
                                            <th class="va-m">Action</th>
                                        </tr>
                                        </thead>
                                        
                                        <tbody>
                                        
                                          @foreach($banner as $value)
                                            <tr>
                                                <td><img src="{{URL::to('/')}}/public/img/{{$value->banar_image }}" style="height: 50px;width: 50px;"></td>
                                                <td>{{$value->banar_text}}</td>
                                                <td>{{$value->banar_url}}</td>
                                                
                                                <td>
                                                    
                                                    <a href="{{ URL::to('admin/banner/' . $value->id . '/edit') }}" class="btn btn-primary btn-xs">Edit</a>
                                                    <a href="{{ URL::to('admin/banner/destroy/' . $value->id ) }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure delete this item?')">Delete</a>
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
