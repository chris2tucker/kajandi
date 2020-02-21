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
                    
                    
                    <li class="breadcrumb-current-item">Aprove and Reject</li>
                </ol>
            </div>

    </header>

            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><em class="ti-user mr5"></em>VENDORS PRODUCTS</h3>
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
                                <div class="panel-title">Approve and Reject Products
                                </div>
                            </div>
                        

               
                            <div class="panel-body ">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped mg-t" id="table">
                                        <thead>
                                        <tr>
                                            <th class="va-m">S/N</th>
                                            <th class="va-m">Image</th>
                                            <th class="va-m">Image 2</th>
                                            <th class="va-m">Image 3</th>
                                            <th class="va-m">Image 4</th>
                                            <th class="va-m">Vendor</th>
                                            <th class="va-m">Product</th>
                                            <th class="va-m">Action</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th class="va-m">S/N</th>
                                            <th class="va-m">Image</th>
                                            <th class="va-m">Image 2</th>
                                            <th class="va-m">Image 3</th>
                                            <th class="va-m">Image 4</th>
                                            <th class="va-m">Vendor</th>
                                            <th class="va-m">Product</th>
                                            <th class="va-m">Action</th>
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                        
                                          @foreach($vendor_product as $key)
                                          @php
                                          $getproduct = DB::table('products')->where('id',$key->product_id)->first();
                                          $vendor = DB::table('vendors')->where('user_id',$key->user_id)->first();
                                           if (empty($key->image)) {
                                                $img="/$getproduct->image";
                                            }else{
                                                $img="/$key->image";
                                            }
                                            $productImages=App\productimages::where('product_id','=',$key->id)->first();

                                          @endphp
                                            <tr>
                                                <td>{{$key->id}}</td>
                                                <td><img src="{{URL::to('/')}}{{$img}}" style="height: 50px;width: 50px;"></td>
                                                <td><img src="{{URL::to('/')}}/{{$productImages->image_2}}" style="height: 50px;width: 50px;"></td>
                                                <td><img src="{{URL::to('/')}}/{{$productImages->image_3}}" style="height: 50px;width: 50px;"></td>
                                                <td><img src="{{URL::to('/')}}/{{$productImages->image_4}}" style="height: 50px;width: 50px;"></td>
                                                <td><a href="{{url('vendors/'.$key->user_id)}}" title=""></a>{{$vendor->vendorname}}</td>
                                                <td><a href="{{url('admin/ProductDetail/'.$key->id)}}" title="">{{$key->name}}</a></td>
                                                
                                                <td>
                                                    
                                                    <a href="{{url('admin/approveproduct/'.$key->id)}}" class="btn btn-primary btn-xs" > Approve </a>
                                                    <a href="{{url('admin/edit_product/'.$key->id)}}" title="">View & Edit</a>
                                                </td>
                                            </tr>
                                          @endforeach
                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                                

                                <!-- -------------- /form -------------- -->



                            </div>
                        </div>

                    </div>



            <!-- -------------- /Column Center -------------- -->
@include('includes.footer')
