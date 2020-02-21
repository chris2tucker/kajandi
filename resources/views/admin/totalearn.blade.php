<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Requisition</title>
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
                    
                    
                    <li class="breadcrumb-current-item">top earn Vendor & Customer</li>
                </ol>
            </div>

    </header>
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><em class="ti-user mr5"></em>top earn Vendor & Customer</h3>
                </div>
            </div>

         
            <!--  /Column Left  -->

            <!--  Column Center  -->
            <div class="chute chute-center">

                <div class="mw1200 center-block">

                    <!--  Spec Form  -->
                    <div class="allcp-form">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title">Top Spending Customer 
                                </div>
                            </div>
                            <div class="panel-body">
                                   
                        <div class="col-md-12">
                       <?php 
                       $orderss= DB::table('orders')
         ->join('ordersdetail', 'ordersdetail.order_id', '=', 'orders.id')
         ->select('orders.user_id', 'ordersdetail.totalprice', DB::raw('sum(ordersdetail.totalprice) AS total'))
         ->groupBy('orders.user_id')->orderBy('total', 'DESC')
         ->get();
                      

                        ?>
                            
                            <div class="panel-body pn">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped mg-t" id="table">
                                        <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Customer Name</th>
                                            <th>Total Earned</th>
                                           
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                           <th>S/N</th>
                                            <th>Customer Name</th>
                                            <th>Total Earned</th>
                                            
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                                                $i = 1;
                                                ?>
                                            @foreach($orderss as $key=>$order)
                                                
                                                
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td> <a href="{{url('/admin/viewcustomers/'.$order->user_id)}}" title="">{{ App\User::find($order->user_id)->name }}</a> </td>
                                                    <td>{{App\Http\Controllers\HomeController::converter( $order->total) }}</td>
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
                     <?php 
                       $topearn= DB::table('orders')
         ->join('ordersdetail', 'ordersdetail.order_id', '=', 'orders.id')
         ->select('orders.vendor_id', 'ordersdetail.totalprice', DB::raw('sum(ordersdetail.totalprice) AS total'))
         ->where('orders.vendor_id','!=',NULL)
         ->groupBy('orders.vendor_id')->orderBy('total', 'DESC')
         ->get();
                      
                        ?>
                    <div class="allcp-form">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title">top earn Vendor
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
                                            <th>Vendor Name</th>
                                            <th>Total Earned</th>
                                           
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                           <th>S/N</th>
                                            <th>Vendor Name</th>
                                            <th>Total Earned</th>
                                            
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                          <?php
                                                $j = 1;
                                                ?>
                                            @foreach($topearn as $key=>$vendor)
                                                
                                            
                                                <tr>
                                                    <td>{{ $j++ }}</td>
                                                    <td>{{ App\User::find($vendor->vendor_id)->name }}</td>
                                                    <td>{{App\Http\Controllers\HomeController::converter( $vendor->total) }}</td>

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
                    <div class="allcp-form">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title">Products
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
                                            <th>Product Image</th>
                                            <th>Product Name</th>
                                            <th>Vendor Name</th>
                                            <th>Total earned</th>
                                           
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                           <th>S/N</th>
                                            <th>Product Image</th>
                                            <th>Product Name</th>
                                            <th>Vendor Name</th>
                                            <th>Total earned</th>
                                           
                                            
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                          <?php echo $view ?>     
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
            <!--  /Column Center  -->


@include('includes.footer')
