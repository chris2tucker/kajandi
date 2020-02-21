<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Customers activities</title>
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
                    
                    
                    <li class="breadcrumb-current-item">Customers activities</li>
                </ol>
            </div>

    </header>
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><em class="ti-user mr5"></em>Customers activities</h3>
                </div>
            </div>
        <div class="chute chute-center">

            <div class="mw1200 center-block">

                <div class="allcp-form">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">Customers activities
                            </div>
                        </div>
                        <div class="panel-body">
                            <br>
                            <br>

                            <div class="col-md-12">
                                <div class="col-md-8">
                                     <table class="table">
                                        <tr>
                                            <td>Customer: </td>
                                            <td><a href="{{url('/admin/viewcustomers/'.$user->id)}}">{{ $user->name }}</a></td>
                                        </tr>
                                        <tr>
                                             <td>Phone:</td>
                                             <td>{{ $user->phone }}</td>
                                        </tr>
                                        <tr>
                                             <td>Email:</td>
                                             <td>{{ $user->email }}</td>
                                        </tr>
                                       
                                     </table> 
                                     <br><br><br><br>
                                </div>
                                <div class="col-md-4">
                                    <div class="pull-right">
                                       
                                        
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
                                <div class="col-lg-12">
                                    <h4>Products purchased</h4><br>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover" id="table" >
                                           <thead>
                                            <tr>
                                                <th>S/N</th>
                                                <th>Order Number</th>
                                                <th>Vendor Name</th>
                                                <th>Payment type</th>
                                                <th>phone</th>
                                                <th>Shipping Address</th>
                                                <th>order city</th>
                                                <th>payment</th>
                                                <th>dateorder</th>
                                                
                                            </tr>
                                            </thead>
                                            
                                            <tbody class="data">
                                                @foreach($products as $key=>$product)
                                               
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $product->ordernumber }}</td>
                                                        <td>{{ App\User::where('id',$product->user_id)->first()->name }}</td>
                                                        <td>{{ $product->paymenttype }}</td>
                                                        <td>{{ $product->phone }}</td>
                                                        <td>{{ $product->shipaddress }}</td>
                                                        <td>{{ $product->ordercity }}</td>
                                                        <td>{{ $product->payment }}</td>
                                                        <td>{{ $product->dateordered }}</td>
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
        </div>
            <!-- -------------- /Column Center -------------- -->
    </section>


    


@include('includes.footer')
