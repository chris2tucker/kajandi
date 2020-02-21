<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Bankdetails approve</title>
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
                    
                    
                    <li class="breadcrumb-current-item">Bankdetails approve</li>
                </ol>
            </div>

    </header>
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><em class="ti-user mr5"></em>Bankdetails approve</h3>
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
                                            <th>User Name</th>
                                            <th>Bank Name</th>
                                            <th>Account Name</th>
                                            <th>Account Number</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>S/N</th>
                                            <th>User Name</th>
                                            <th>Bank Name</th>
                                            <th>Account Name</th>
                                            <th>Account Number</th>
                                            <th>Status</th>
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach($bankdetails as $key=>$bank)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ App\User::where('id',$bank->user_id)->first()->name }}</td>
                                                    <td>{{ $bank->name }}</td>
                                                    <td>{{ $bank->account_name }}</td>
                                                    <td>{{ $bank->account_number }}</td>
                                                    <td>
                                                        @if($bank->status == null)
                                                            <a href="{{ route('admin.bank.store',$bank->id) }}" class="btn btn-success">Approve</a>
                                                        @else
                                                            <a href="" class="btn btn-danger">Cancel</a>
                                                        @endif
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
