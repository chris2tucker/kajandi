<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Welcome to Dashboard</title>
    @include('includes.head')
    <style type="text/css">
       .text-center {
        text-align: center;
        padding: 14px;
    }
        #jobs_past {
        width: 100%;
    }
    #jobs_upcoming {
        width: 100%;
    }
     .online-profile {
      width: 61px;
      border-radius: 50px;
      margin-left: 19px;
    }
    .online-user h4 {
      margin-left: 15px;
      margin-bottom: 20px;
    }
    .online-status {
      border: 1px solid green;
      position: absolute;
      margin-left: -11px;
      margin-top: 6px;
      padding: 4px;
      background: green;
      border-radius: 17px;
    }

    </style>
</head>
@include('includes.header')
<!-- -------------- /Topbar Menu Wrapper -------------- -->
    <div class="row" style="margin-top: 50px;">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <a href="{{url('admin/')}}">
                <section class="dash-tile bg-primary">
                  <div class="tile-title title-heading text-center bg-primary">
                    <a href="javascript:;" class="widget-refresh"><i class="ti-reload pull-right"></i></a>
                    <a href="javascript:;"><i class="ti-menu pull-left"></i></a>
                    <span>Total Order</span>
                  </div>
                  <div class="tile-stats"><b>{{$order}}</b>
                  </div>
                  
                </section>
            </a>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
                <section class="dash-tile bg-danger">
                  <div class="tile-title title-heading text-center bg-danger">
                    <a href="javascript:;" class="widget-refresh"><i class="ti-reload pull-right"></i></a>
                    <a href="javascript:;"><i class="ti-menu pull-left"></i></a>
                    <span>Total Vendor</span>
                  </div>
                  <div class="tile-stats"><b>{{$vendor_count}}</b>
                  </div>
                  
                </section>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
                <section class="dash-tile bg-success">
                  <div class="tile-title title-heading text-center bg-sucess">
                    <a href="javascript:;" class="widget-refresh"><i class="ti-reload pull-right"></i></a>
                    <a href="javascript:;"><i class="ti-menu pull-left"></i></a>
                    <span>Total Customer</span>
                  </div>
                  <div class="tile-stats"><b>{{$customer_count}}</b>
                  </div>
                  
                </section>
        </div>
         <div class="col-md-3 col-sm-6 col-xs-12">
                <section class="dash-tile bg-success">
                  <div class="tile-title title-heading text-center bg-sucess">
                    <a href="javascript:;" class="widget-refresh"><i class="ti-reload pull-right"></i></a>
                    <a href="javascript:;"><i class="ti-menu pull-left"></i></a>
                    <span>Total Earned</span>
                  </div>
                  <?php 
                  $totalearned=App\accounts::find(1);

                   ?>
                  <div class="tile-stats"><b>@if($totalearned) {{App\Http\Controllers\HomeController::converter($totalearned->total_commission)}} @else 0 @endif</b>
                  </div>
                  
                </section>
        </div>

             
              
    </div>
  <!--  <div class="row">
         <div class="online-user">
           <h4>List login of users</h4>
         </div>
         <div class="user-online">
          @foreach($users as $user)
            @if($user->isOnline())
              <img class="online-profile" src="{{ asset('profile/'.$user->image) }}"><span class="online-status"></span>
            @endif
          @endforeach
           

         </div> 
       </div>-->
        <!-- -------------- Topbar -------------- -->
         <div class="panel-body pn">
            <h4>Pending delivery</h4><br>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mg-t" id="table">
                                <thead>
                                <tr class="bg-light">
                                 <th>S/N</th>
                                <th>Order Number</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>Delivery Status</th>
                                <th>Order Date</th>
                                <th>Action</th>

                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $key=>$order)
                                       @foreach($order->orderdetails as $orderdetail)
                                      <tr>
                                          <td>{{ $key + 1 }}</td>
                                          <td>{{ $orderdetail->ordernumber }}</td>
                                          <td>{{ $orderdetail->quantity }}</td>
                                          <td>{{ App\Http\Controllers\HomeController::converter($orderdetail->price) }}</td>
                                      
                                       
                                          <td>
                                                
                                         
                                          @if($order->deliverystatus == 'pending')
                                          <h5  style='padding: 5px; text-align: center'><a href="{{ URL::to('order/approve',$order->id) }}" class="btn btn-danger">Pending</a></h5>
                                          @else
                                           <h5  style='padding: 5px; text-align: center'><a href="{{ URL::to('order/delivered',$order->id) }}" class="btn btn-success">Delivered</a></h5>
                                           @endif
                                         
                                         
                                              
                                          </td>
                                          <td>{{$order->dateordered}}</td>
                                          <td>
                                              <a href='{{ URL::to('/admin/ordersdetail',$orderdetail->id) }}' class='btn btn-primary'>View</a>
                                             <!-- <a href='{{ URL::to('/customers/reorder',$orderdetail->id) }}' class='btn btn-primary'>Reorder</a>-->
                                          </td>
                                      </tr>
                                      @endforeach
                                  @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

        <div class="panel-body pn">
            <h4>Newly registered members (buyers and sellers)</h4><br>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mg-t" id="table">
                                <thead>
                                <tr class="bg-light">
                                    <th class="text-center">S/N</th>
                                    <th class="">Name</th>
                                    <th class="">Email</th>
                                    <th class="">Phone</th>
                                    <th class="">User type</th>
                                    <th class="text-right">Created At</th>
                                    <th class="">Updated At</th>

                                </tr>
                                </thead>
                                <tbody>
                                  @foreach($vendors as $key=>$vendor)
                                    <tr>
                                      <td>{{ $key + 1 }}</td>
                                      <td>{{ $vendor->name }}</td>
                                      <td>{{ $vendor->email }}</td>
                                      <td>{{ $vendor->phone }}</td>

                                      <td>{{ $vendor->user_type }}</td>
                                      
                                      <td>{{ $vendor->created_at }}</td>
                                      <td>{{ $vendor->updated_at }}</td>
                                    

                                    </tr>
                                  @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
             <div class="panel-body pn">
            <h4>Pending Products</h4><br>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mg-t" id="table">
                                <thead>
                                <tr class="bg-light">
                                      <th>S/N</th>
                                      <th>Product Name</th>
                                      <th>Product price</th>
                                      <th>Product Status</th>
                                      <th>Created At</th>
                                      <th>Update At</th>

                                </tr>
                                </thead>
                                <tbody>
                                  @foreach($products as $key=>$product)
                         
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>${{ $product->price }}</td>
                                       
                                    
                                     
                                        <td>
                                              
                                       
                                        @if($product->product_status == false)
                                        <h5>Pending</h5>
                                        @else
                                         <h5  style='padding: 5px; text-align: center'><a href="" class="btn btn-success">Approved</a></h5>
                                         @endif
                                       
                                       
                                            
                                        </td>
                                        <td>{{ $product->created_at }}</td>
                                         <td>{{ $product->updated_at }}</td>
                                    </tr>
                                
                                      @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div> 
          <div class="panel-body pn">
            <h4>Outstanding and Due payments</h4><br>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mg-t" id="table">
                                <thead>
                                <tr class="bg-light">
                                      <th>S/N</th>
                                      <th>Order Number</th>
                                      <th>quantity</th>
                                      <th>price</th>
                                      <th>Date Order</th>
                                      <th>Duedate</th>
                                      <th>Created At</th>
                                      <th>Updated At</th>

                                </tr>
                                </thead>
                                <tbody>
                                   @foreach($dues as $key=>$due)
                         
                                  <tr>
                                      <td>{{ $key + 1 }}</td>
                                      <td>{{ $due->ordernumber }}</td>
                                      <td>{{ $due->quantity }}</td>
                                      <td>${{ $due->price }}</td>
                                     <td>{{ $due->totalprice }}</td>
                                      <td>{{ $due->dateordered }}</td>
                                   <td>{{ $due->duedate }}</td>
                                    
                                      <td>{{ $due->created_at }}</td>
                                       <td>{{ $due->updated_at }}</td>
                                  </tr>
                              
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>               
       
       
@include('includes.footer')