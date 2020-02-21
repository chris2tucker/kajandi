<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Units</title>
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
                        <a href="{{url('admin/units')}}">Units</a>
                    </li>
                   
                </ol>
            </div>
            
        </header>

         <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><em class="ti-user mr5"></em>Units</h3>
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
                                <a href="{{ url('admin/add_unit') }}" class="btn btn-bordered btn-primary mb5">ADD NEW UNIT</a>
                            </div>
                          
              
                            
                            <div class="panel-body pn">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped mg-t" id="table">
                                        <thead>
                                        <tr>
                                            <th class="va-m">S/N</th>
                                            <th class="va-m">Name</th>
                                           
                                            <th class="va-m">Action</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th class="va-m">S/N</th>
                                            <th class="va-m">Name</th>
                                          
                                            <th class="va-m">Action</th>
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                        @php
                                        $units=App\unit::all();
                                        @endphp
                                          @foreach($units as $unit)
                                            <tr>
                                                <td>{{$unit->id}}</td>
                                                <td>{{$unit->unit}}</td>
                                              
                                                <td>
                                                    
                                                    <a href="{{ url('/admin/unit/'.$unit->id)}}" class="btn btn-primary btn-xs">Edit</a>
                                                   
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