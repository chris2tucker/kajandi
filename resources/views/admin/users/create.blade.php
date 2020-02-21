<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Shipping Managment</title>
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
                    
                    <li class="breadcrumb-current-item">Add User</li>
                </ol>
            </div>
            
        </header>

         
            <!-- -------------- /Column Left -------------- -->

            <!-- -------------- Column Center -------------- -->
            <div class="chute chute-center">

                <div class="mw1000 center-block">

                    <!-- -------------- Spec Form -------------- -->
                    <div class="allcp-form">
                        <div class="panel">
                            <div class="panel-heading">
                                <div class="panel-title">Add User
                                </div>
                            </div>
                            <div class="panel-body br-t">
                            <div class="allcp-form theme-primary">

                          

                            <form method="post" action="{{ url('admin/create/user') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                 <div class="section row mb10">
                                    <label for="store-name" class="col-sm-2 control-label small">Name:</label>
                                    <div class="col-sm-10 ph10">
                                           <input type="text" name="name" id="business-name" class="form-control" placeholder="Name" required>
                                           
                                    </div>
                                </div>
                                

                                <div class="section row mb10">
                                    <label for="store-name" class="col-sm-2 control-label small">Email:</label>
                                    <div class="col-sm-10 ph10">
                                            <input type="email" name="email" id="business-name" class="form-control" placeholder="Email" required>
                                            
                                    </div>
                                </div>
                                  <div class="section row mb10">
                                    <label for="store-name" class="col-sm-2 control-label small">Phone:</label>
                                    <div class="col-sm-10 ph10">
                                            <input type="number" name="phone" id="business-name" class="form-control" placeholder="phone" required>
                                            
                                    </div>
                                </div>
                                 <div class="section row mb10">
                                    <label for="store-name" class="col-sm-2 control-label small">password:</label>
                                    <div class="col-sm-10 ph10">
                                            <input type="password" name="password" id="business-name" class="form-control" placeholder="Password" required>
                                            
                                    </div>
                                </div>
                            
                                
                                
                                

                                

                            
                                

                                

                                </div>
                                </div>
                                </div>

                        


                               <div class="panel">
                            <div class="panel-heading">
                                
                            </div>
                            <div class="panel-body br-t">
                            <div class="allcp-form theme-primary">

                                

                               

                                    

                            </div>
                        </div>

                        <div class="panel-footer text-right">
                                <button type="submit" class="btn btn-bordered btn-primary mb5"> SAVE</button>
                        </div>

                        </div>

                        </form>

                    </div>



                </div>
            </div>
            <!-- -------------- /Column Center -------------- -->
           
@include('includes.footer')