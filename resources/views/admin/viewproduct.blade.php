@extends('layouts.adminlayout')
@section('content')


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
                        <a href="/admin/index">Dashboard</a>
                    </li>
                    <li class="breadcrumb-link">
                        <a href="/admin/products">Product</a>
                    </li>
                    <li class="breadcrumb-current-item">Add Product</li>
                </ol>
            </div>
            <div class="topbar-right">
                <div class="ib topbar-dropdown">
                    <label for="topbar-multiple" class="control-label">Reporting Period</label>
                    <select id="topbar-multiple" class="hidden">
                        <optgroup label="Filter By:">
                            <option value="1-1">Last 30 Days</option>
                            <option value="1-2" selected="selected">Last 60 Days</option>
                            <option value="1-3">Last Year</option>
                        </optgroup>
                    </select>
                </div>
                <div class="ml15 ib va-m" id="sidebar_right_toggle">
                    <div class="navbar-btn btn-group btn-group-number mv0">
                        <button class="btn btn-sm btn-default btn-bordered prn pln">
                            <i class="fa fa-bar-chart fs22 text-default"></i>
                        </button>
                        <button class="btn btn-primary btn-sm btn-bordered hidden-xs"> 3</button>
                    </div>
                </div>
            </div>
        </header>

	<section id="content" class="table-layout animated fadeIn">

         
            <!-- -------------- /Column Left -------------- -->

            <!-- -------------- Column Center -------------- -->
            <div class="chute chute-center">

                <div class="mw1000 center-block">

                    <!-- -------------- Spec Form -------------- -->
                    <div class="allcp-form">

                    <form method="post" action="{{ url('admin/updateviewproduct/'.$product->id) }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                        <div class="panel">
                            <div class="panel-heading">
                                <div class="panel-title">General Information
                                </div>
                            </div>
                            <div class="panel-body br-t">
                            <div class="allcp-form theme-primary">

                            @if(Session::has('status'))
                            <p class="alert alert-success alert-dismissable fade in">{{ Session::get('status') }}</p>
                            @endif
                            
                            

                                <div class="section row mbn">
                                    <div class="col-md-4 ph10">
                                        <div class="fileupload fileupload-new allcp-form" data-provides="fileupload">
                                            <div class="fileupload-preview thumbnail mb20">
                                                <img src="/{{$product->image}}" alt="holder" style="width: 277px; height: 140px">
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-5 ph10">
                                                    <span class="button btn-primary btn-file btn-block">
                                                      <span class="fileupload-new">Select</span>
                                                      <span class="fileupload-exists">Change</span>
                                                      <input type="file" name="image">
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8 ph10">
                                        <div class="section mb10">
                                            <label for="name21" class="field prepend-icon">
                                                <input type="text" name="name" class="event-name gui-input br-light light" placeholder="Product Name" value="{{$product->name}}">
                                                <label for="name21" class="field-icon">
                                                    <i class="fa fa-tag"></i>
                                                </label>
                                            </label>
                                        </div>
                                        <div class="section mb10">
                                            <label class="field prepend-icon">
                                            <textarea name="description" class="gui-textarea br-light bg-light textareaheight">{{$product->description}}</textarea>
                                                <label for="comment" class="field-icon">
                                                    <i class="fa fa-file"></i>
                                                </label>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                </div>
                                </div>
                                </div>

                                <br>

                                <div class="panel">
                            <div class="panel-heading">
                                <div class="panel-title">Product Information
                                </div>
                            </div>
                            <div class="panel-body br-t">
                            <div class="allcp-form theme-primary">

                                <div class="section row">
                                    <div class="col-md-4 ph10">
                                        <label for="product-category" class="field select">
                                            <select id="product-category" name="category" class="empty">
                                                <option value="" >Category...</option>
                                                
                                                <?php
                                                $set = '';
                                                        $set2 = '';

                                        foreach($category as $cat){
                                                    $value = '';
                                                    $set = $cat->id;
                                                    $set2 = $product->category;
                                            if($set == $set2){
                                                $value = 'selected=selected';
                                            }
                                            ?>
                                                <option value="<?php echo $cat->id; ?>" <?php echo $value; ?> > <?php echo $cat->name ?></option>
                                            <?php
                                            }
                                            ?>
                                            </select>
                                            <i class="arrow double"></i>
                                        </label>
                                    </div>
                                    <!-- -------------- /section -------------- -->

                                    <div class="col-md-4 ph10">
                                        <label for="product-category" class="field select">
                                            <select id="subcat" name="subcategory" class="empty">
                                                <option value="">Sub Category...</option>
                                                <?php
                                                $set = '';
                                                $set2 = '';
                                                foreach($subcategory as $subcat){
                                                        $value = '';
                                                    if($subcat->id == $product->category){
                                                        $value = 'selected';
                                                    }
                                                    ?>
                                                    <option value="<?php  echo $subcat->id; ?>" <?php echo $value ?> > <?php echo $subcat->name ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <i class="arrow double"></i>
                                        </label>
                                    </div>
                                    <!-- -------------- /section -------------- -->

                                    <div class="col-md-4 ph10">
                                        <label for="product-sku" class="field prepend-icon">
                                            <input type="text" name="partnumber" class="event-name gui-input br-light light" placeholder="Product Name" value="{{$product->partnumber}}">
                                            <label for="product-sku" class="field-icon">
                                                <i class="fa fa-barcode"></i>
                                            </label>
                                        </label>
                                    </div>
                                    <!-- -------------- /section -------------- -->

                                </div>

                                <br>

                                <br>

                                <div class="section row">
                                    <div class="col-md-4 ph10">
                                        <label for="product-unit" class="field prepend-icon">
                                            <input type="text" name="unit" id="product-unit" class="gui-input" placeholder="Product Unit" value="{{$product->unit}}">
                                            <label for="product-unit" class="field-icon">
                                                <i class="fa fa-barcode"></i>
                                            </label>
                                        </label>
                                    </div>
                                    <!-- -------------- /section -------------- -->

                                    <div class="col-md-4 ph10">
                                        <label for="product-weight" class="field prepend-icon">
                                            <input type="text" name="weight" id="product-weight" class="gui-input" placeholder="Product Weight" value="{{$product->weight}}">
                                            <label for="product-weight" class="field-icon">
                                                <i class="fa fa-barcode"></i>
                                            </label>
                                        </label>
                                    </div>
                                    <!-- -------------- /section -------------- -->

                                    <div class="col-md-4 ph10">
                                        <label for="product-length" class="field prepend-icon">
                                            <input type="text" name="length" id="product-length" class="gui-input" placeholder="Product Length" value="{{$product->length}}">
                                            <label for="product-length" class="field-icon">
                                                <i class="fa fa-barcode"></i>
                                            </label>
                                        </label>
                                    </div>
                                    <!-- -------------- /section -------------- -->

                                </div>

                                <br>

                                <div class="section row">
                                    <div class="col-md-4 ph10">
                                        <label class="field select">
                                            <select id="product-status" name="manufacturer" class="empty">
                                                <option value="0" selected="selected">Manufacturer</option>
                                                <?php
                                                $set = '';
                                                $set2 = '';
                                                foreach($productmanufacturer as $manufacturer){
                                                        $value = '';
                                                    if($manufacturer->id == $product->manufacturer){
                                                        $value = 'selected';
                                                    }
                                                    ?>

                                                    <option value="<?php  echo $manufacturer->id; ?>" <?php echo $value ?> > <?php echo $manufacturer->name ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <i class="arrow double"></i>
                                        </label>
                                    </div>
                                    <!-- -------------- /section -------------- -->

                                    <div class="col-md-4 ph10">
                                        <label for="product-model" class="field select">
                                            <select id="product-model" name="productmodel" class="empty">
                                                <option value="" selected="selected">Model</option>
                                                <?php
                                                $set = '';
                                                $set2 = '';
                                                foreach($productmodel as $model){
                                                        $value = '';
                                                    if($model->id == $product->model){
                                                        $value = 'selected';
                                                    }
                                                    ?>

                                                    <option value="<?php  echo $model->id; ?>" <?php echo $value ?> > <?php echo $model->name ?> </option>
                                                <?php
                                            }
                                                ?>
                                            </select>
                                            <i class="arrow double"></i>
                                        </label>
                                    </div>
                                    <!-- -------------- /section -------------- -->


                                </div>




                                </div>
                                </div>
                                <div class="panel-footer text-right">
                                    <div class="row text-left">
                                        @include('layouts.errors')
                                    </div>
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-bordered btn-primary mb5"> SAVE</button>
                                    </div>    
                                        
                                </div>
                                </div>

                                 

                   </form


                    </div>



                </div>
            </div>
            <!-- -------------- /Column Center -------------- -->

@endsection







