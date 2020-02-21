<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Search term collect</title>
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
                    
                    
                    <li class="breadcrumb-current-item">Search term collect</li>
                </ol>
            </div>

    </header>
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><em class="ti-user mr5"></em>Search term collect</h3>
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
                                <div class="panel-title">Search term collect
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
                                            <th>keyword</th>
                                            <th>total view</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                           <th>S/N</th>
                                            <th>keyword</th>
                                            <th>total view</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach($terms as $key=>$term)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $term->name }}</td>
                                                    <td>{{ $term->count }}</td>
                                                    <td>{{ $term->created_at }}</td>
                                                    <td>{{ $term->updated_at }}</td>
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
