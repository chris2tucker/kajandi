<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Vendor Product</title>
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
                    <li class="breadcrumb-current-item">Edit Category</li>
                </ol>
            </div>
            
        </header>
            <!-- -------------- /Column Left -------------- -->

            <!-- -------------- Column Center -------------- -->
            <div class="chute chute-center">

                <div class="mw1000 center-block">

                    <!-- -------------- Spec Form -------------- -->
                    <div class="allcp-form">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title">Edit Category
                                </div>
                            </div>
                            <div class="panel-body br-t">
                            <div class="allcp-form theme-primary">

                            @if(Session::has('status'))
                            <p class="alert alert-success alert-dismissable fade in">{{ Session::get('status') }}</p>
                            @endif
                            @include('layouts.errors')

                            <form method="post" action="{{ url('admin/edit_category_update/'.$catagory->id) }}"  enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <div class="section row mb10">
                                    <label for="store-name" class="col-sm-2 control-label small">Category Name:</label>

                                    <div class="col-sm-10 ph10">
                                            <input type="text" name="name" id="business-name" class="form-control" placeholder="Category Name" value="{{$catagory->name}}">
                                    </div>
                                </div>

                                <div class="section row mb10">
                                    <label for="store-name" class="col-sm-2 control-label small">Category Description:</label>

                                    <div class="col-sm-10 ph10">
                                            <input type="text" name="category_description" id="business-name" class="form-control" placeholder="Category Description" value="{{$catagory->category_description}}">
                                    </div>
                                </div>

                                <div class="section row mb10">
                                    <label for="store-name" class="col-sm-2 control-label small">Abbreviation:</label>

                                    <div class="col-sm-10 ph10">
                                            <input type="text" name="catagory_abbreviation" id="business-name" class="form-control" placeholder="Category Abbreviation" value="{{$catagory->catagory_abbreviation}}">  
                                    </div>
                                </div>

                                <div class="section row mb10">
                                    <label for="store-name" class="col-sm-2 control-label small">Image:</label>

                                    <div class="col-sm-10 ph10">
                                            <input type="file" name="image" id="business-name" class="form-control image" >    
                                    </div>
                                </div>
                              

                                 <div class="section row mb10">
                                    <label for="store-name" class="col-sm-2 control-label small">Add Menu</label>

                                    <div class="col-sm-7 ph10">
                                        
                                            <input type="radio" name="add_menu"  class="" value="yes" @if($catagory->add_menu=='yes') checked="checked" @endif> Yes
                                            &nbsp;
                                            <input type="radio" name="add_menu"  class="" value="no" @if($catagory->add_menu=='no') checked="checked" @endif> No
                                     
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

                        </form>

                    </div>



                </div>
            </div>
            <!-- -------------- /Column Center -------------- -->

@include('includes.footer')