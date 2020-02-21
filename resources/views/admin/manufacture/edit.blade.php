<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Manufacture</title>
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
                        <a href="{{url('admin/manufacture')}}">Manufacture</a>
                    </li>
                    <li class="breadcrumb-current-item">Edit Manufacture</li>
                </ol>
            </div>
            
        </header>
 

            <div class="chute chute-center">

                <div class="mw1000 center-block">

                    <!-- -------------- Spec Form -------------- -->
                    <div class="allcp-form">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title">Edit Manufacture
                                </div>
                            </div>
                            <div class="panel-body br-t">
                            <div class="allcp-form theme-primary">

                            {{ Form::model($manufacture, array('url' => array('admin/manufacture', $manufacture->id), 'method' => 'PUT','enctype'=>'multipart/form-data')) }}
                                {{ csrf_field() }}


                                <div class="section row mb10">
                                    <label for="store-name" class="col-sm-2 control-label small">Manufacture:</label>
                                    <div class="col-sm-10 ph10">
                                        <input type="text" name="name" id="business-name" class="form-control" value="{{$manufacture->name}}" >
                                    </div>
                                </div>

                                 <div class="panel-footer text-right">
                                    <button type="submit" class="btn btn-bordered btn-primary mb5"> SAVE</button>
                                </div>

                                </div>
                                </div>
                                </div>

                               
                        </div>

               

                       

                        </div>

                       {{ Form::close() }}

                    </div>



                </div>
            </div>
            <!-- -------------- /Column Center -------------- -->

@include('includes.footer')


