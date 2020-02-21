<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Add Banner</title>
    @include('includes.head')
</head>

@include('includes.header')
 


    <!-- -------------- /Topbar Menu Wrapper -------------- -->

        <!-- -------------- Topbar -------------- -->
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
                        <a href="{{url('admin/banner')}}">Banner</a>
                    </li>
                    <li class="breadcrumb-current-item">Add Banner</li>
                </ol>
            </div>
            
        </header>

    <section id="content" class="table-layout animated fadeIn">

         
            <!-- -------------- /Column Left -------------- -->

            <!-- -------------- Column Center -------------- -->
            <div class="chute chute-center">

                <div class="mw1000 center-block">

                    <!-- -------------- Spec Form -------------- -->
                    <div class="allcp-form">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title">Edit Banner
                                </div>
                            </div>
                            <div class="panel-body br-t">
                            <div class="allcp-form theme-primary">

                            @if(Session::has('status'))
                            <p class="alert alert-success alert-dismissable fade in">{{ Session::get('status') }}</p>
                            @endif
                            @include('layouts.errors')

                            {{ Form::model($banner, array('url' => array('admin/banner/update', $banner->id), 'method' => 'PUT','enctype'=>'multipart/form-data')) }}
                                {{ csrf_field() }}


                                <div class="section row mb10">
                                    <label for="store-name" class="col-sm-2 control-label small">Banner Text:<font color="red">*</font></label>

                                    <div class="col-sm-10 ph10">
                                            <input type="text" name="banar_text" id="business-name" class="form-control" placeholder="Banner Text" value="{{$banner->banar_text}}">
                                    </div>
                                </div>

                                <div class="section row mb10">
                                    <label for="store-name" class="col-sm-2 control-label small">Banner url:<font color="red">*</font></label>

                                    <div class="col-sm-10 ph10">
                                            <input type="text" name="banar_url" id="business-name" class="form-control" placeholder="Banner Url" value="{{$banner->banar_url}}" >

                                    </div>
                                </div>

                                <div class="section row mb10">
                                    <label for="store-name" class="col-sm-2 control-label small">Banner Image: <font color="red">*</font></label>

                                    <div class="col-sm-10 ph10">
                                            <input accept="image/*"  type="file" name="banar_image" id="business-name" class="form-control image" >
                                            
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


