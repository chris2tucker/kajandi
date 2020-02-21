<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard</title>
    @include('includes_vendor.head')
</head>

@include('includes_vendor.header')
<style type="text/css">
    .img_product {
    width: 51px;
}
</style>
 <header id="topbar" class="alt">
            <div class="topbar-left">
                <ol class="breadcrumb">
                    <li class="breadcrumb-icon">
                        <a href="{{url('admin/index')}}">
                            <span class="fa fa-home"></span>
                        </a>
                    </li>
                    <li class="breadcrumb-active">
                        <a href="{{url('admin/index')}}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-link">
                        <a href="#">Order List</a>
                    </li>
                   
                </ol>
            </div>
            
        </header>
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><em class="ti-user mr5"></em>Orders List</h3>
                </div>
            </div>

         
            <!-- -------------- /Column Left -------------- -->

            <!-- -------------- Column Center -------------- -->
            <div class="chute chute-center">

                <div class="mw1200 center-block">

                    <!-- -------------- Spec Form -------------- -->
                    <div class="allcp-form">
                        <div class="panel panel-default">
                            
                            <div class="panel-body">
                            



                                  
               
                 
                    <div class="panel-body pn">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mg-t" id="table">
                                <thead>
                                <tr class="bg-light">
                                    <th class="text-center">S/N</th>
                                    <th class="">Product Name</th>
                                    <th class="">Order Id</th>
                                    <th class="">Order Date</th>
                                    <th class="">Company Name</th>
                                    <th class="">Payment Type</th>
                                    <th class="">Total Price</th>
                                      <th>Payment status</th>
                                    <th class="text-right">Status</th>
                                    <th class="">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $key=>$order)
                                        @foreach($order->orderdetails as $orderdetail)
                                        
                                        
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $orderdetail->products->name }}</td>
                                                <td>{{ $orderdetail->order_id }}</td>
                                                <td>{{  $orderdetail->dateordered }}</td>
                                                <td>{{ $order->user->name }}</td>
                                                <td>{{ $order->paymenttype }}</td>
                                                <td>{{ $orderdetail->totalprice }}</td>
                                                <td>{{ $order->orderstatus }}</td>
                                                   <td>
                                                     @if($order->payment == 'yes')
                                                         <h5  style='padding: 5px; text-align: center'><a href="{{ URL::to('order/paymentdeactive',$order->id) }}" class="btn btn-primary">Yes</a></h5>
                                                        @else
                                                        <h5  style='padding: 5px; text-align: center'><a href="{{ URL::to('order/paymentactive',$order->id) }}" class="btn btn-warning">No</a></h5>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="" class="btn btn-sm btn-danger"  data-toggle="modal" data-target="#exampleModal-{{ $order->id }}">cancel order</a>
                                                 </td>
                                            </tr>
                                           <!-- Modal -->
                                            <div class="modal fade" id="exampleModal-{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                              <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Why you want to cancel this order?</h5>
                                                    
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                    </button>
                                                  </div>
                                                  <div class="modal-body">
                                                    <form action="{{ route('vendor.order.status',$order->id) }}" method="POST">
                                                        {{ csrf_field() }}
                                                         <div class="form-group">
                                                            <label for="message-text" class="col-form-label"></label>
                                                            <textarea class="form-control" id="message-text" cols="50" placeholder="Write this Reason" name="orderstatus"></textarea>
                                                          </div>
                                                    
                                                  </div>
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Cancel Order</button>
                                                  </div>
                                                  </form>
                                                </div>
                                              </div>
                                            </div>
                                        @endforeach
                                    @endforeach
                               
                                </tbody>
                            </table>
                        </div>
                    </div>
                

                                

                                <!-- -------------- /form -------------- -->



                            </div>
                        </div>

                    </div>



                </div>
            </div>

            <!-- Button trigger modal -->



   

        <script>

 $(".delete").on("click", function(){
        
        return confirm("Do you want to delete this item?");
        
    });
    
</script>

            <!-- -------------- /Column Center -------------- -->
@include('includes_vendor.footer')
