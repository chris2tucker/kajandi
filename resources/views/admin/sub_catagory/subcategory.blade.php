<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sub Category</title>
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
                        <a href="{{url('admin/category')}}">Sub Category</a>
                    </li>
                   
                </ol>
            </div>
            
        </header>

         <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><em class="ti-user mr5"></em>SubCategory</h3>
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
                                <a href="{{ url('admin/add_subcatagory') }}" class="btn btn-bordered btn-primary mb5">ADD SUB CATEGORY</a>
                            </div>
                          
              
                            
                            <div class="panel-body pn">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped mg-t" id="table">
                                        <thead>
                                        <tr>
                                        	<th class="va-m">S/N</th>
                                            <th class="va-m">Name</th>
                                            <th class="va-m">Category</th>
                                             <th class="va-m">Commision (%)</th>
                                            <th class="va-m">Action</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th class="va-m">S/N</th>
                                            <th class="va-m">Name</th>
                                            <th class="va-m">Category</th>
                                             <th class="va-m">Commision (%)</th>
                                            <th class="va-m">Action</th>
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                        
                                          @foreach($subcategory as $value)
                                            <tr>
                                            	<td>{{$value->id}}</td>
                                            	<td>{{$value->name}}</td>
                                                <td>{{$value->category->name}}</td>
                                                <td>{{$value->sub_commission}}</td>
                                                <td>
                                                    
                                                    <a href="{{ url('/admin/edit_subcatagory/'.$value->id)}}" class="btn btn-primary btn-xs">Edit</a>
                                                    <a href="{{ url('/admin/delete_sub_catagory/'.$value->id)}}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure?')">Delete</a>
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