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
                        <a href="{{url('admin/subcategory')}}">Sub Category</a>
                    </li>
                    <li class="breadcrumb-current-item">Edit Sub Category</li>
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
                                <div class="panel-title">Edit SubCategory
                                </div>
                            </div>
                            <div class="panel-body br-t">
                            <div class="allcp-form theme-primary">


                            <form method="post" action="{{ url('admin/update_subcategory/'.$subcategory->id) }}"  enctype="multipart/form-data">
                                {{ csrf_field() }}


                                <div class="section row mb10">
                                    <label for="store-name" class="col-sm-2 control-label small">Category Name:<font color="red">*</font></label>

                                    <div class="col-sm-10 ph10">
                                            <select id="country" name="category" class="form-control">
                                                <option value="">Select a Category</option>
                                                @foreach($category as $value)
                                                    <option value="{{$value->id}}" @if($subcategory->category_id==$value->id) selected ="selected" @endif>{{$value->name}}</option>
                                                @endforeach
                                            </select>
                                            
                                    </div>
                                </div>

                                <div class="section row mb10">
                                    <label for="store-name" class="col-sm-2 control-label small">Sub Category Name:<font color="red">*</font></label>

                                    <div class="col-sm-10 ph10">
                                            <input type="text" name="name" id="business-name" class="form-control" placeholder="Sub Category Name" value="{{$subcategory->name}}">
                                    </div>
                                </div>

                                <div class="section row mb10">
                                    <label for="store-name" class="col-sm-2 control-label small">Description:<font color="red">*</font></label>

                                    <div class="col-sm-10 ph10">
                                            <input type="text" name="sub_category_description" id="business-name" class="form-control" placeholder="Sub Category Description" value="{{$subcategory->sub_category_description}}">
                                        
                                    </div>
                                </div>

                                <div class="section row mb10">
                                    <label for="store-name" class="col-sm-2 control-label small">Abbreviation:<font color="red">*</font></label>

                                    <div class="col-sm-10 ph10">
                                            <input type="text" name="sub_catagory_abbreviation" id="business-name" class="form-control" placeholder="Sub Category Abbreviation" value="{{$subcategory-> sub_catagory_abbreviation }}">
                                    </div>
                                </div>
                                 

                                <div class="section row mb10">
                                    <label for="store-name" class="col-sm-2 control-label small">Image</label>

                                    <div class="col-sm-10 ph10">
                                            <input type="file" name="image" id="business-name" class="form-control image" >
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