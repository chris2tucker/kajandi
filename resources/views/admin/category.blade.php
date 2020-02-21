<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Category</title>
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
                        <a href="{{url('admin/category')}}">Category</a>
                    </li>
                   
                </ol>
            </div>
            
        </header>
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><em class="ti-user mr5"></em>Category</h3>
                </div>
            </div>
<style type="text/css">
    #from_image {
    padding: 0px;
}
</style>

      <!-- -------------- Topbar -------------- -->
 

         
            <!-- -------------- /Column Left -------------- -->

            <!-- -------------- Column Center -------------- -->
            <div class="chute chute-center">

                <div class="mw1000 center-block">
                   

                    <!-- -------------- Spec Form -------------- -->
                    <div class="allcp-form">
                        <div class="panel">
                           
                           

                        <div class="col-md-12">
                        <div class="panel panel-default" id="spy3">
                            <div class="panel-heading">
                                <div class="panel-title hidden-xs">
                                   <a href="{{ url('admin/create_catagory') }}" class="btn btn-bordered btn-primary mb5">ADD CATEGORY</a>
                                </div>
                            </div>
                            <div class="panel-body pn">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped mg-t" id="table">
                                        <thead>
                                        <tr>
                                        	<th class="va-m">S/N</th>
                                            <th class="va-m">image</th>
                                            <th class="va-m">Name</th>
                                            <th class="va-m">Commision (%)</th>
                                            <th class="va-m">Action</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th class="va-m">S/N</th>
                                            <th class="va-m">image</th>
                                            <th class="va-m">Name</th>
                                            <th class="va-m">Commision (%)</th>
                                            <th class="va-m">Action</th>
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                        
                                          @foreach($category as $value)
                                            <tr>
                                            	<td>{{$value->id}}</td>
                                                <td><img src="{{URL::to('/')}}/public/img/{{$value->image}}" style="height: 50px;width: 50px;"></td>
                                            	<td>{{$value->name}}</td>
                                                <td>{{$value->catagory_comission}}</td>
                                                <td>
                                                    <a href="{{ url('/admin/edit_catagory/'.$value->id)}}" class="btn btn-primary btn-xs">Edit</a>
                                                    <a href="{{ url('/admin/delete_catagory/'.$value->id)}}" class="btn btn-danger btn-xs">Delete</a>
                                                </td>
                                        	</tr>
                                          @endforeach
                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    

                                

                                <!-- -------------- /form -------------- -->



                        </div>

                    </div>



                </div>
            </div>
            <!-- -------------- /Column Center -------------- -->

@include('includes.footer')