<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Adv Section 1</title>
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
                        <a href="{{url('admin/adv_sec_1')}}">Adv Section 1</a>
                    </li>
                   
                </ol>
            </div>
            
        </header>

    <section id="content" class="table-layout animated fadeIn">

         
            <!-- -------------- /Column Left -------------- -->

            <!-- -------------- Column Center -------------- -->
            <div class="chute chute-center">

                <div class="mw1000 center-block">

                    <!-- -------------- Spec Form -------------- -->
                    <div class="allcp-form">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a href="{{ url('admin/adv_sec_1/create') }}" class="btn btn-bordered btn-primary mb5">ADD ADV SECTION 1</a>
                            </div>
                            <div class="panel-body">

              
                            <div class="panel-body pn">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped mg-t" id="table">
                                        <thead>
                                        <tr>
                                            
                                            <th class="va-m">Image</th>
                                            <th class="va-m">Vendor</th>
                                            <th class="va-m">Product</th>
                                            <th class="va-m">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        
                                          @foreach($adv_sec_1_data as $value)
                                            <tr>
                                                
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
                      

                                

                                <!-- -------------- /form -------------- -->



                            </div>
                        </div>

                    </div>



                </div>
            </div>
            <!-- -------------- /Column Center -------------- -->
@include('includes.footer')
