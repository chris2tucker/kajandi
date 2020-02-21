<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Currency Rate</title>
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
                    
                    
                    <li class="breadcrumb-current-item">Currency Rate</li>
                </ol>
            </div>

    </header>
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><em class="ti-user mr5"></em>Currency Rates</h3>
                </div>
            </div>

         
            <!-- -------------- /Column Left -------------- -->

            <!-- -------------- Column Center -------------- -->
            <div class="chute chute-center">

                <div class="mw1200 center-block">
                    @if(Session::has('message'))
                    <div class="alert alert-success">
                        {{Session::get('message')}}
                        
                    </div>
                    @endif

                    <!-- -------------- Spec Form -------------- -->
                    <div class="allcp-form">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title">Currency Rates
                                </div>
                            </div>
                           
                            <div class="panel-body pn">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped mg-t" id="table">
                                        <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Dollar($)</th>
                                            <th>Yen(¥)</th>
                                            <th >Euro(€)</th>
                                            <th ></th>
                                          </tr>
                                        </thead>
                                       <tr>
                                        <td></td>
                                           <form action="{{url('admin/currency')}}" method="post" accept-charset="utf-8">
                                               {{csrf_field()}}
                                               <td>
                                                   <input type="text" class="form-control" name="dollar" value="{{$PreviousRates->Dollar}}" required>
                                               </td>
                                               <td>
                                                   <input type="text" class="form-control" name="yen" value="{{$PreviousRates->Yen}}" required>
                                               </td>
                                               <td>
                                                   <input type="text" class="form-control" name="euro" value="{{$PreviousRates->Euro}}" required>
                                               </td>
                                               <td>
                                                   <button type="submit"  class="btn btn-primary" name="submit" >Save</button> 
                                               </td>
                                           </form>
                                       </tr>
                                        <tbody>
                                        
                                          
                                        
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
