<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>accounting details</title>
    <style type="text/css">
        .vendor-profile-img img {
            width: 207px;
            margin-left: 80px;
            border-radius: 46px;
        }

        .vendor-name {
            margin-left: 103px;
        }
        .vendor-name h4 {
            font-size: 27px;
        }
        .vendor-email {
            margin-left: 43px;
        }
        .vendor-email h4 {
            font-size: 43px;
        }
        .vendor-phone {
            margin-left: 101px;
        }
        .vendor-phone h4 {
            font-size: 29px;
        }
    </style>
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
                    
                    <li class="breadcrumb-current-item">accounting details</li>
                </ol>
            </div>
            
        </header>

            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><em class="ti-user mr5"></em>accounting details</h3>
                </div>
            </div>

         <div class="chute chute-center">

                <div class="mw1200 center-block">

                    <!--  Spec Form  -->
                    <div class="allcp-form">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title">Orders
                                </div>
                            </div>
                            <div class="panel-body">
                                   
                        <div class="col-md-12">
                       
                            
                            <div class="panel-body pn">
                                <div class="table-responsive"> 
                                    <table class="table table-bordered table-striped mg-t" id="table">

                                        <thead>

                                        <tr>
                                             <th>S/N</th>
                                            <th>Order Number</th>
                                            <th>Customer</th>
                                            <th>Quantity</th>
                                            <th>Total Price</th>
                                            <th>Payment Method</th>
                                            <th>Order Date</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Order Number</th>
                                            <th>Customer</th>
                                            <th>Quantity</th>
                                            <th>Total Price</th>
                                            <th>Payment Method</th>
                                            <th>Order Date</th>
                                        </tr>
                                        </tfoot>
                                        <tbody id="re">
                                        
                                          @foreach($orders as $key => $orderde)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $orderde->order->ordernumber }}</td>
                                            <td>{{ $orderde->order->user->name }}</td>
                                            <td>{{ $orderde->quantity }}</td>
                                            <td>{{ $orderde->totalprice }}</td>
                                            <td>{{ $orderde->order->paymenttype }}</td>
                                            <td>{{ $orderde->order->dateordered }}</td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
            

                                

                                <!--  /form  -->



                            </div>
                        </div>

                    </div>



                </div>
            </div>
         
           <div class="chute chute-center">

                <div class="mw1200 center-block">

                    <!--  Spec Form  -->
                    <div class="allcp-form">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title">products
                                </div>
                            </div>
                            <div class="panel-body">
                                   
                        <div class="col-md-12">
                       
                            
                            <div class="panel-body pn">
                                <div class="table-responsive"> 
                                    <table class="table table-bordered table-striped mg-t" id="table">

                                        <thead>

                                        <tr>
                                            <th>Product Name</th>
                                            <th>Product Vendor Name</th>
                                            <th>Product Description</th>
                                            <th>Product Stock</th>
                                            <th>Product part Number</th>
                                           
                                        </tr>
                                        </thead>
                                        <tbody id="re">
                                        

                                        <tr>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ App\User::where('id',$product->user_id)->first()->name }}</td>
                                            <td>{{ $product->description }}</td>
                                            <td>{{ $product->stock_count }}</td>
                                            <td>{{ $product->part_number }}</td>
                                        </tr>
                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
            

                                

                                <!--  /form  -->



                            </div>
                        </div>

                    </div>



                </div>
            </div>

@include('includes.footer')