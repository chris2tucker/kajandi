<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Page Management</title>
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
                    
                    <li class="breadcrumb-current-item">Page Management</li>
                </ol>
            </div>
            
        </header>

            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><em class="ti-user mr5"></em>Pages</h3>
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
                               
                                
                                        <a href="{{ url('general/terms/create') }}" class="btn btn-bordered btn-primary mb5 btn_add"><span class="ti-plus"></span> ADD Page</a>

                                </div>
                           
                            &nbsp;
                            
                     <div class="panel-body">

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mg-t" id="table">
                                <thead>
                                <tr class="bg-light">
                                    <th>Title</th>
                                    <th class="">Actions</th>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach($pages as $page)
                                <tr>

                                    <td>{{$page->description}}</td>
                                    <td><a href="{{url('general/terms/'.$page->id)}}" title="">Edit</a>
                                    <a onclick="return window.confirm('Are you sure?'); event.preventDefault()  " href="{{url('general/terms/delete/'.$page->id)}}" title="">Delete</a></td>
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
} );
    })
</script>
@include('includes.footer')