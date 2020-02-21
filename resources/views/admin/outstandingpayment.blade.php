<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Payment approve</title>
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
                    
                    <li class="breadcrumb-current-item">payment approve</li>
                </ol>
            </div>
            
        </header>

            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><em class="ti-user mr5"></em>payment approve</h3>
                </div>
            </div>

         
         
            <!--  /Column Left  -->

            <!--  Column Center  -->
            <div class="chute chute-center">

                <div class="mw1000 center-block">

                    <!--  Spec Form  -->
                    <div class="allcp-form">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                               
                                
                                      
                                    
                                </div>
                           
                            &nbsp;
                            
                     <div class="panel-body">

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mg-t" id="table">
                                <thead>
                                <tr class="bg-light">
                                    <th class="text-center"></th>
                                    
                                    <th class="">Payment ID</th>
                                
                                  
                                    <th>Customer Name</th>
                                    <th class="">totalprice</th>
                                    <th class="">Action</th>

                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($outstandingpayment as $key=>$order)
                                    
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $order->paymentID }}</td>
                                            
                                            <td><a href="{{url('/admin/viewcustomers/'.$order->user_id)}}" title="">{{ App\User::Where('id',$order->user_id)->first()->name }}</a></td>
                                            <td>{{App\Http\Controllers\HomeController::converter( $order->totalprice) }}</td>
                                            <td>
                                                
                                                    <a href="{{ url('admin/outstandingdue/amount/pay/'.$order->id) }}" class="btn btn-info">approve payment</a>
                                                
                                            </td>
                                        </tr>
                                        
                                    @endforeach
                                </tbody>
                            </table>
           
                    </div>
                                <!--  /form  -->



                            </div>
                        </div>

                    </div>



                </div>
            </div>

<script>

 $(".delete").on("click", function(){
        
        return confirm("Do you want to delete this item?");
        
    });
    
</script>
@include('includes.footer')