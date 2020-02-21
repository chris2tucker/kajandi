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
                        <a href="/admin/products">Vendor Product</a>
                    </li>
                    <li class="breadcrumb-current-item">Edit Vendor Product</li>
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

                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">Select Product
                            </div>
                        </div>
                        <div class="panel-body br-t">
                            <div class="allcp-form theme-primary">

                                <div class="section row">

                                    <div class="col-md-4 ph10">
                                        <label for="product-category" class="field select">
                                            <select class="productcategory empty getproduct" name="productid" >
                                                <option value="0">Products...</option>
                                                <?php
                                                foreach($product as $prod){
                                                $value = '';
                                                    if($prod->id == $vendorproduct->product_id){
                                                        $value = 'selected=selected';
                                                    }
                                                    ?>
                                                    <option value="{{$prod->id}}" <?php echo $value ?> >{{$prod->name}}</option>
                                                    <?php
                                                }
                                                ?>
                                        </select>
                                            <i class="arrow double"></i>
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    {!! Form::model($vendorproduct, ['url' => ['admin/updatevendorproduct', $vendorproduct->id], 'enctype' => 'multipart/form-data']) !!}
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
                            
                            
                            <div class="viewproduct">
                                <div class="section row mbn">
                                    <div class="col-md-4 ph10">
                                        <div class="fileupload fileupload-new allcp-form" data-provides="fileupload">
                                            <div class="fileupload-preview thumbnail mb20">
                                            <?php
                                            if (empty($vendorproduct->image)) {
                                                ?>
                                                <img src="{{url('/')}}/{{$products->image}}" alt="holder">
                                                <?php
                                            }else{
                                                ?>
                                                <img src="{{url('/')}}/{{$vendorproduct->image}}">
                                                <?php
                                            }
                                            ?>
                                                
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
                                                <input type="text" name="productname" id="name21"
                                                       class="event-name gui-input br-light light"
                                                       placeholder="Product Name" value="{{$products->name}}">
                                                <label for="name21" class="field-icon">
                                                    <i class="fa fa-tag"></i>
                                                </label>
                                            </label>
                                        </div>
                                        <div class="section mb10">
                                            <label class="field prepend-icon">
                                            {{ Form::textarea('description', $value = $products->description, ['class' => 'gui-textarea br-light bg-light textareaheight', 'id' => 'name21', 'placeholder' => 'Product Description']) }}
                                                <label for="comment" class="field-icon">
                                                    <i class="fa fa-file"></i>
                                                </label>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <br>

                                <div class="section row">
                                    <div class="col-md-4 ph10">
                                        <label for="product-category" class="field select">
                                            <select class="productcategory" name="productcategory" class="empty">
                                                <option value="">Category</option>
                                                <option value="{{$vendorproduct->category}}" selected="selected" >{{$category->name}}</option>
                                                
                                            </select>
                                            <i class="arrow double"></i>
                                        </label>
                                    </div>
                                    <!-- -------------- /section -------------- -->

                                    <div class="col-md-4 ph10">
                                        <label for="product-category" class="field select">
                                            <select id="subcat" name="productsubcategory" class="empty">
                                                <option value="">Subcategory</option>
                                                <option value="{{$vendorproduct->subcategory}}" selected="selected">{{$subcategory->name}}</option>
                                            </select>
                                            <i class="arrow double"></i>
                                        </label>
                                    </div>
                                    <!-- -------------- /section -------------- -->

                                     <div class="col-md-4 ph10">
                                        <label for="product-sku" class="field prepend-icon">
                                            {{ Form::text('partnumber', $value = $products->partnumber, ['class' => 'gui-input', 'id' => 'product-sku', 'placeholder' => 'Part Number']) }}
                                            <label for="product-sku" class="field-icon">
                                                <i class="fa fa-barcode"></i>
                                            </label>
                                        </label>
                                    </div>

                                    <input type='hidden' name='product_id' value=<?php echo $vendorproduct->product_id; ?> >
                                    <!-- -------------- /section -------------- -->


                                </div>

                                <div class='section row'>
                                    <div class='col-md-4 ph10'>
                                        <label for='product-unit' class='field prepend-icon'>
                                            <input type='text' name='unit' id='product-unit' class='gui-input' placeholder='Product Unit' value="<?php echo $products->unit ?>">
                                            <label for='products-unit' class='field-icon'>
                                                <i class='fa fa-barcode'></i>
                                            </label>
                                        </label>
                                    </div>
                                    <!-- -------------- /section -------------- -->

                                    <div class='col-md-4 ph10'>
                                        <label for='product-weight' class='field prepend-icon'>
                                            <input type='text' name='weight' id='product-weight' class='gui-input' placeholder='Product Weight' value="<?php echo $products->weight ?>">
                                            <label for='product-weight' class='field-icon'>
                                                <i class='fa fa-barcode'></i>
                                            </label>
                                        </label>
                                    </div>
                                    <!-- -------------- /section -------------- -->

                                    <div class='col-md-4 ph10'>
                                        <label for='product-length' class='field prepend-icon'>
                                            <input type='text' name='length' id='product-length' class='gui-input' placeholder='Product Length' value="<?php echo $products->length ?>" >
                                            <label for='product-length' class='field-icon'>
                                                <i class='fa fa-barcode'></i>
                                            </label>
                                        </label>
                                    </div>
                                    <!-- -------------- /section -------------- -->

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
                                        <label class="field select">
                                            {{Form::select('availability', ['yes' => 'Available', 'no' => 'Unavailable'], null, ['class' => 'empty', 'id' => 'product-status']) }}
                                            <i class="arrow double"></i>
                                        </label>
                                    </div>
                                    <!-- -------------- /section -------------- -->

                                    <div class="col-md-4 ph10">
                                        <label for="product-quantity" class="field prepend-icon">
                                            {{ Form::number('unit', $value = null, ['class' => 'gui-input', 'id' => 'product-quantity', 'placeholder' => 'Quantity']) }}
                                            <label for="product-quantity" class="field-icon">
                                                <i class="fa fa-sort-amount-desc"></i>
                                            </label>
                                        </label>
                                    </div>
                                    <!-- -------------- /section -------------- -->

                                     <!-- -------------- /section -------------- -->

                                    <div class="col-md-4 ph10">
                                        <label for="product-price" class="field prepend-icon">
                                            {{ Form::number('price', $value = null, ['class' => 'gui-input', 'id' => 'product-price', 'placeholder' => 'Price...']) }}
                                            <label for="product-price" class="field-icon">
                                                <i class="fa fa-usd"></i>
                                            </label>
                                        </label>
                                    </div>

                                   
                                </div>

                                <div class="section row">

                                    <div class="col-md-4 ph10">
                                        <label for="product-price-15days" class="field prepend-icon">
                                            <input type="number" name="pricewithin15days" id="product-price-15days" class="gui-input" placeholder="Price within 15 days" value="<?php echo $vendorproduct->pricewithin15days ?>">
                                            <label for="product-price-15days" class="field-icon">
                                                <i class="fa fa-sort-amount-desc"></i>
                                            </label>
                                        </label>
                                    </div>
                                    <!-- -------------- /section -------------- -->

                                    <div class="col-md-4 ph10">
                                        <label for="product-price-30days" class="field prepend-icon">
                                            <input type="number" name="pricewithin30days" id="product-price-30days" class="gui-input" placeholder="Price within 30 days" value="<?php echo $vendorproduct->pricewithin30days ?>">
                                            <label for="product-price-30days" class="field-icon">
                                                <i class="fa fa-sort-amount-desc"></i>
                                            </label>
                                        </label>
                                    </div>

                                    
                                </div>

                                <div class="section row">
                                    <div class="col-md-4 ph10">
                                        <label for="product-delivery-rate-state" class="field prepend-icon">
                                            <input type="number" name="deliveryratestate" id="product-delivery-rate-state" class="gui-input" placeholder="Delivery Rate Within State" value="<?php echo $vendorproduct->deliveryratestate ?>">
                                            <label for="product-delivery-rate-state" class="field-icon">
                                                <i class="fa fa-usd"></i>
                                            </label>
                                        </label>
                                    </div>
                                    <!-- -------------- /section -------------- -->

                                    <div class="col-md-4 ph10">
                                        <label for="product-delivery-rate-outstate-with-geozone" class="field prepend-icon">
                                            <input type="number" name="deliveryrateoutstatewithgeo" id="product-delivery-rate-outstate-with-geozone" class="gui-input" placeholder="Delivery Rate Outside State within Geo Zone" value="<?php echo $vendorproduct->deliveryrateoutstatewithgeo ?>">
                                            <label for="product-delivery-rate-outstate-with-geozone" class="field-icon">
                                                <i class="fa fa-usd"></i>
                                            </label>
                                        </label>
                                    </div>

                                    <div class="col-md-4 ph10">
                                        <label for="product-delivery-rate-outside-geozone" class="field prepend-icon">
                                            <input type="number" name="deliveryrateoutsidegeo" id="product-delivery-rate-outside-geozone" class="gui-input" placeholder="Delivery Outside Geo Zone" value="<?php echo $vendorproduct->deliveryrateoutsidegeo ?>">
                                            <label for="product-delivery-rate-outside-geozone" class="field-icon">
                                                <i class="fa fa-usd"></i>
                                            </label>
                                        </label>
                                    </div>

                                </div>

                                <div class="section row">
                                    <div class="col-md-4 ph10">
                                        <label class="field select">
                                            <select id="product-status" name="condition" class="empty">
                                                <option value="" selected="selected">Condition</option>
                                                <?php
                                                $set = '';
                                                $set2 = '';

                                                foreach($condition as $val){
                                                    $value = '';
                                                    $set = $val->id;
                                                    $set2 = $vendorproduct->condition_id;
                                                    if($set == $set2){
                                                        $value = 'selected=selected';
                                                    }
                                                    ?>
                                                    <option value="<?php echo $val->id ?>" <?php echo $value ?> ><?php echo $val->name ?></option>
                                                    <?php
                                                }
                                                    ?>
                                            </select>
                                            <i class="arrow double"></i>
                                        </label>
                                    </div>
                                    <!-- -------------- /section -------------- -->

                                    <div class="col-md-4 ph10">
                                        <label class="field select">
                                            <select id="product-status" name="source" class="empty">
                                                <option value="" selected="selected">Source</option>
                                                <?php
                                                foreach($source as $value){
                                                    $val = '';
                                                    if ($value->id == $vendorproduct->source_id) {
                                                        $val = 'selected=selected';
                                                    }
                                                
                                                ?>
                                                    <option value="<?php echo $value->id ?>" <?php echo $val; ?> > <?php echo $value->name ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <i class="arrow double"></i>
                                        </label>
                                    </div>
                                    <!-- -------------- /section -------------- -->

                                    <div class="col-md-4 ph10">
                                        <label class="field select">
                                            {{Form::select('payondelivery', ['yes' => 'Yes', 'no' => 'No'], null, ['class' => 'empty', 'id' => 'product-status']) }}
                                            <i class="arrow double"></i>
                                        </label>
                                    </div>
                                </div>

                                <div class="section row">
                                    <div class="col-md-4 ph10">
                                        <label class="field select">
                                            <select id="product-status" name="addon" class="empty">
                                                <option value="0" selected="selected">Addon</option>
                                                <?php
                                                foreach($productaddon as $value){
                                                    $val = '';
                                                    if ($value->id == $vendorproduct->addon_id) {
                                                        $val = 'selected=selected';
                                                    }
                                                ?>
                                                    <option value="<?php echo $value->id ?>" <?php echo $val ?> > <?php echo $value->name ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <i class="arrow double"></i>
                                        </label>
                                    </div>
                                    <!-- -------------- /section -------------- -->

                                    <div class="col-md-4 ph10">
                                        <label class="field select">
                                            <select id="product-status" name="strengthofmaterial" class="empty">
                                                <option value="0" selected="selected">Strength of material</option>
                                                <?php
                                                foreach($strengthofmaterial as $value){
                                                    $val = '';
                                                    if ($value->id == $vendorproduct->strengthofmaterial) {
                                                        $val = 'selected=selected';
                                                    }
                                                ?>
                                                    <option value="<?php echo $value->id; ?>" <?php echo $val; ?> >{{$value->name}}</option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                            <i class="arrow double"></i>
                                        </label>
                                    </div>

                                     <div class="col-md-4 ph10">
                                        <label class="field select">
                                            <select id="product-status" name="vendor" class="empty">
                                                <option value="0" selected="selected">Vendor</option>
                                                <?php
                                                $set = '';
                                                $set2 = '';
                                                foreach($vendors as $name){
                                                    $value = '';
                                                    $set = $vendorproduct->user_id;
                                                $set2 = $name->user_id;
                                                    if($set == $set2){
                                                        $value = 'selected=selected';
                                                    }
                                                    ?>
                                                    <option value="<?php echo $name->user_id; ?>" <?php echo $value; ?> > <?php echo $name->vendorname; ?></option>
                                                <?php
                                            }
                                                ?>
                                            </select>
                                            <i class="arrow double"></i>
                                        </label>
                                    </div>

                                    

                                </div>

                                <div class="section row">
                                    <div class="col-md-4 ph10">
                                        <label class="field select">
                                            {{Form::select('addon_type', ['Warranty' => 'Warranty', 'Guarantee' => 'Guarantee'], null, ['class' => 'empty', 'id' => 'product-status']) }}
                                            <i class="arrow double"></i>
                                        </label>
                                    </div>
                                    <!-- -------------- /section -------------- -->

                                    <<div class="col-md-4 ph10">
                                            <label><b>color: </b> </label>
                                            <input type="color"  name="color" value="<?php echo $vendorproduct->color ?>">
                                    </div>

                                </div>

                                </div>
                                </div>
                                </div>

                                

                                <div class="panel">
                            <div class="panel-heading">
                                <div class="panel-title">Product Remark
                                </div>
                            </div>
                            <div class="panel-body br-t">
                            <div class="allcp-form theme-primary">

                                <div class="section row">
                                    <div class="col-md-8">
                                        <div class="section mb10">
                                            <label class="field prepend-icon">
                                              {{ Form::textarea('remark', $value = null, ['class' => 'gui-textarea br-light bg-light textareaheight', 'id' => 'comment', 'placeholder' => 'Product Remark']) }}
                                            <label for="comment" class="field-icon">
                                                <i class="fa fa-file"></i>
                                            </label>
                                            </label>
                                        </div>
                                    </div>
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
                            {!! Form::close() !!}


                    </div>



                </div>
            </div>
            <!-- -------------- /Column Center -------------- -->

@endsection







