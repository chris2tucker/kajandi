<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>users</title>
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
                    
                    
                    <li class="breadcrumb-current-item">Users</li>
                </ol>
            </div>

    </header>
    <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header"><em class="ti-user mr5"></em>Users</h3>
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
                                <div class="panel-title">Users
                                </div>
                                <a href="{{url('admin/create/user')}}" title="" class="btn btn-primary">Add User</a>
                            </div>
                            
                            <div class="panel-body pn">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped mg-t" id="table">
                                        <thead>
                                        <tr>
                                            
                
                                            <th class="va-m">Name</th>
                                            <th class="va-m">Email</th>
                                            <th class="va-m">User Type</th>
                                        </tr>
                                        </thead>
                               
                                       
                                        <tbody>
                                        
                                          @foreach($user as $key)
                                            <tr>
                                                <td>{{$key->name}}</td>
                                                <td>{{$key->email}}</td>
                                                
                                                <td>
                                                    {{$key->user_type}}
                                                </td>
                                                <td>
                                                    <a href="{{url('admin/user/edit/'.$key->id)}}" title="">Edit</a>
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
            <!-- -------------- /Column Center -------------- -->
@include('includes.footer')
