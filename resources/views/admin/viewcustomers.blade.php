<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Customers Detail</title>
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
                    
                    
                    <li class="breadcrumb-current-item">Customers Detail</li>
                </ol>
            </div>

    </header>
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><em class="ti-user mr5"></em>Customers Detail</h3>
                </div>
            </div>
            <?php 
            $total=0;
            $outstandingpayment=App\outstandingpayment::where('user_id','=',$getcustomer->id)->where('duedate','>=',carbon\Carbon::today()->todatestring())->where('payment','=','pending')->sum('totalprice');
            
             $duepayment=App\outstandingpayment::where('user_id','=',$getcustomer->id)->where('duedate','<',carbon\Carbon::today()->todatestring())->where('payment','=','pending')->sum('totalprice');
             $orders=App\orders::where('user_id','=',$getcustomer->id)->get();
             foreach ($orders as  $ordr) {
                $orderdetail=App\ordersdetail::where('order_id','=',$ordr->id)->sum('totalprice');
                $total=$total+$orderdetail;
             }
 $favourite_vendor =App\favoritevendor::where('customer_id',$getcustomer->id)->where('favorite','=',1)->get();
        
            
             ?>
             <div class="row">
                 <div class="col-md-3 col-sm-6 col-xs-12">
                <section class="dash-tile bg-danger">
                  <div class="tile-title title-heading text-center bg-danger">
                    <a href="javascript:;" class="widget-refresh"><i class="ti-reload pull-right"></i></a>
                    <a href="javascript:;"><i class="ti-menu pull-left"></i></a>
                    <span>$outstanding Amout</span>
                  </div>
                  <div class="tile-stats"><b>{{App\Http\Controllers\HomeController::converter($outstandingpayment)}}</b>
                  </div>
                  
                </section>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
                <section class="dash-tile bg-danger">
                  <div class="tile-title title-heading text-center bg-danger">
                    <a href="javascript:;" class="widget-refresh"><i class="ti-reload pull-right"></i></a>
                    <a href="javascript:;"><i class="ti-menu pull-left"></i></a>
                    <span>Due Amount</span>
                  </div>
                  <div class="tile-stats"><b>{{App\Http\Controllers\HomeController::converter($duepayment)}}</b>
                  </div>
                  
                </section>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
                <section class="dash-tile bg-danger">
                  <div class="tile-title title-heading text-center bg-danger">
                    <a href="javascript:;" class="widget-refresh"><i class="ti-reload pull-right"></i></a>
                    <a href="javascript:;"><i class="ti-menu pull-left"></i></a>
                    <span>Total Spent</span>
                  </div>
                  <div class="tile-stats"><b>{{App\Http\Controllers\HomeController::converter($total)}}</b>
                  </div>
                  
                </section>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
                <section class="dash-tile bg-danger">
                  <div class="tile-title title-heading text-center bg-danger">
                    <a href="javascript:;" class="widget-refresh"><i class="ti-reload pull-right"></i></a>
                    <a href="javascript:;"><i class="ti-menu pull-left"></i></a>
                    <span>Last Login</span>
                  </div>
                  <div class="tile-stats"><b>{{$getcustomer->updated_at}}</b>
                  </div>
                  
                </section>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
                <section class="dash-tile bg-danger">
                  <div class="tile-title title-heading text-center bg-danger">
                      <a class="pull-right text-info text-sm" href="{{url('admin/viewcustomers/wallet/'.$getcustomer->id)}}">History</a>
                    <a href="javascript:;"><i class="ti-menu pull-left"></i></a>
                    <span>Wallet Amount</span>
                  </div>
                  @php
                 $wallet=App\wallet::where('user_id','=',$getcustomer->id)->first();
                  @endphp

                  <div class="tile-stats">@if($wallet) <b>{{App\Http\Controllers\HomeController::converter($wallet->balance)}}</b> @else <b>Empty</b> @endif
                  </div>
                  
                </section>
        </div>
             </div>
        <div class="chute chute-center">

            <div class="mw1000 center-block">

                <div class="allcp-form">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">Requisition
                            </div>
                        </div>
                        <div class="panel-body">

                            <div class="col-md-12">
                                
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped mg-t" id="table">
                                        <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Order Number</th>
                                            <th>Quantity</th>
                                            <th>Total Price</th>
                                            <th>Payment Status</th>
                                            <th>Order Date</th>
                                            <th>Delivery Status</th>
                                            <th>View</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Order Number</th>
                                            <th>Quantity</th>
                                            <th>Total Price</th>
                                            <th>Payment Status</th>
                                            <th>Order Date</th>
                                            <th>Delivery Status</th>
                                            <th>View</th>
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                        
                                          <?php echo $view ?>
                                        
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                             <div class="col-lg-12">
                                    <h4>Favourite Vendor</h4><br>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover" id="table" >
                                           <thead>
                                            <tr>
                                                <th>S/N</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>phone</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                            </tr>
                                            </thead>
                                            
                                            <tbody class="data">
                                                @foreach($favourite_vendor as $key=>$vendor)
                                                @php

                                                @endphp
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ App\User::where('id',$vendor->vendor_id)->first()->name }}</td>
                                                        <td>{{ App\User::where('id',$vendor->vendor_id)->first()->email }}</td>
                                                        <td>{{ App\User::where('id',$vendor->vendor_id)->first()->phone }}</td>
                                                        <td>{{ App\User::where('id',$vendor->vendor_id)->first()->created_at }}</td>
                                                        <td>{{ App\User::where('id',$vendor->vendor_id)->first()->updated_at }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
            <!-- -------------- /Column Center -------------- -->
    </section>

@include('includes.footer')