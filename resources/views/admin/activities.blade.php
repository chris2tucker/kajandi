<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Requisition</title>
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
                    
                    
                    <li class="breadcrumb-current-item">Requisition</li>
                </ol>
            </div>

    </header>
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><em class="ti-user mr5"></em>Requisition</h3>
                </div>
            </div>

         
            <!--  /Column Left  -->

            <!--  Column Center  -->
            <div class="chute chute-center">

                <div class="mw1200 center-block">

                    <!--  Spec Form  -->
                    <div class="allcp-form">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title">Requisition
                                </div>
                            </div>
                            <div class="panel-body">
                                   
                        <div class="col-md-12">
                       
                            
                            <div class="panel-body pn">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped mg-t" id="table">
                                        <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Customer Name</th>
                                            <th>User Type</th>
                                            <th>Last login date</th>
                                            <th>View</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                           <th>S/N</th>
                                            <th>Customer Name</th>
                                            <th>User Type</th>
                                            <th>Last login date</th>
                                            <th>View</th>
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach($customers as $key=>$customer)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $customer->name }}</td>
                                                    <td>{{ $customer->user_type }}</td>
                                                    <td>{{ $customer->created_at }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.customer.details',$customer->id) }}" class="btn btn-primary">View</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
            

                                

                                <!--  /form  -->



                            </div>
                        </div>

                    </div>



                </div>
            </div>
            <!--  /Column Center  -->


@include('includes.footer')
