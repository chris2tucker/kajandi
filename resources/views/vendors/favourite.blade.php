<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Favourite customer</title>
    @include('includes_vendor.head')
</head>

@include('includes_vendor.header')
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
                        <a href="#">favourite customer</a>
                    </li>
                   
                </ol>
            </div>
            
        </header>
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><em class="ti-user mr5"></em>Favourite customer</h3>
                </div>
            </div>

         
           
            <div class="chute chute-center">

                <div class="mw1200 center-block">

                
                    <div class="allcp-form">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title">Favourite customer
                                </div>
                            </div>
                         


               
                  
         
                    <div class="panel-body pn">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mg-t" id="table">
                                <thead>
                                <tr class="bg-light">
                                    <th class="text-center"></th>
                                    <th class="">Customer Name</th>
                                    <th class="">Status</th>
                                    <th class="">Vendor Name</th>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($favourite_customers as $key=>$customers)

                                        <tr>
                                            <td>{{ $key +1 }}</td>
                                            <td>{{ App\User::where('id',$customers->customer_id)->first()->name }}</td>
                                            <td>{{ $customers->status }}</td>
                                            <td>{{ App\User::where('id',$customers->vendor_id)->first()->name }}</td>
                                        </tr>
                                    @endforeach
                               
                                </tbody>
                            </table>
                        </div>
                   
                   

                                

                                <!-- -------------- /form -------------- -->



                            </div>
                        </div>

                    </div>



                </div>
            </div>
    

@include('includes_vendor.footer')