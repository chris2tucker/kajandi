<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Add Page</title>
    @include('includes.head')
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js"></script>
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
                    
                    
                    <li class="breadcrumb-current-item">Add Page</li>
                </ol>
            </div>

    </header>
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><em class="ti-user mr5"></em>Add Page</h3>
                </div>
            </div>

         
            <!-- -------------- /Column Left -------------- -->

            <!-- -------------- Column Center -------------- -->
            <div class="chute chute-center">

                <div class="mw1200 center-block">

                    <!-- -------------- Spec Form -------------- -->
                    <form action="{{url('general/terms/')}}" method="post" accept-charset="utf-8">

                    <div class="allcp-form">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <input class="form-control" name="description" type="text" placeholder="Page Title">
                                </div>
                            </div>
                            <div class="panel-body">
                                   
                        <div class="col-md-12">
                       
                            
                            {{ csrf_field() }}
                               <div class="panel-body pn">
                                <div class="table-responsive">
                                    <textarea  name="terms" id="summernote"></textarea>

                                </div>
                            </div>
                            <button type="submit"  class="pull-right btn  btn-primary" style="margin-right:  20px;" >Save</button>
                        </div>
            

                                

                                <!-- -------------- /form -------------- -->



                            </div>
                        </div>

                    </div>

                    </form>


                </div>
            </div>
            <!-- -------------- /Column Center -------------- -->
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 300, 

        });
    });
  </script>



@include('includes.footer')
