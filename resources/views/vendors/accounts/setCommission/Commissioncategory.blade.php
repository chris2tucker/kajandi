<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Commission Category</title>
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
                        <a href="{{url('admin/comission_catagory')}}">Comission Category</a>
                    </li>
                   
                </ol>
            </div>
            
        </header>
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><em class="ti-user mr5"></em>Comission Category</h3>
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
                                    Commission
                                </div>
                            </div>
                            <div class="panel-body pn">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped mg-t" id="table">
                                        <thead>
                                        <tr>
                                        	
                                            
                                            <th class="va-m">Name</th>
                                            <th class="va-m">Commission</th>
                                            <th class="va-m">Set Commission</th>
                                        </tr>
                                        </thead>
                                        
                                        <tbody>
                                        
                                          @foreach($catagory as $value)
                                            <tr>
                                            	
                                            	<td>{{$value->name}}</td>
                                                <td>{{$value->catagory_comission}}</td>
                                                <td>
                                                    <form method="post" action="{{url('admin/setcatagory/'.$value->id)}}">
                                                        {{csrf_field()}}
                                                        <input type="text" name="commission" > <button type="submit" class="btn btn-primary btn-xs">save</button>

                                                        

                                                    </form>

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