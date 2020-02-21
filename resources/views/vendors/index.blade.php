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


    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <a href="{{url('admin/')}}">
                <section class="dash-tile bg-primary">
                  <div class="tile-title title-heading text-center bg-primary">
                    <a href="javascript:;" class="widget-refresh"><i class="ti-reload pull-right"></i></a>
                    <a href="javascript:;"><i class="ti-menu pull-left"></i></a>
                    <span style="margin-left:10px;">Total Products</span>
                  </div>
                  <div class="tile-stats"><b>{{$productscount->count()}}</b>
                  </div>
                  
                </section>
            </a>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
                <section class="dash-tile bg-danger">
                  <div class="tile-title title-heading text-center bg-danger">
                    <a href="javascript:;" class="widget-refresh"><i class="ti-reload pull-right"></i></a>
                    <a href="javascript:;"><i class="ti-menu pull-left"></i></a>
                    <span style="margin-left:10px;">Total Pending product</span>
                  </div>
                  <div class="tile-stats"><b>{{ $pending }}</b>
                  </div>
                  
                </section>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
                <section class="dash-tile bg-success">
                  <div class="tile-title title-heading text-center bg-sucess">
                    <a href="javascript:;" class="widget-refresh"><i class="ti-reload pull-right"></i></a>
                    <a href="javascript:;"><i class="ti-menu pull-left"></i></a>
                    <span style="margin-left:10px;">Total Customer</span>
                  </div>
                  <div class="tile-stats"><b>{{ $getcustomer->count() }}</b>
                  </div>
                  
                </section>
        </div>
         <div class="col-md-3 col-sm-6 col-xs-12">
                <section class="dash-tile bg-success">
                  <div class="tile-title title-heading text-center bg-sucess">
                    <a href="javascript:;" class="widget-refresh"><i class="ti-reload pull-right"></i></a>
                    <a href="javascript:;"><i class="ti-menu pull-left"></i></a>
                    <span style="margin-left:10px;">Total Outstanding Payment</span>
                  </div>
                  <div class="tile-stats"><b>{{App\Http\Controllers\HomeController::converter( $getoutstandingpayment) }}</b>
                  </div>
                  
                </section>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
                <section class="dash-tile bg-success">
                  <div class="tile-title title-heading text-center bg-sucess">
                    <a href="javascript:;" class="widget-refresh"><i class="ti-reload pull-right"></i></a>
                    <a href="javascript:;"><i class="ti-menu pull-left"></i></a>
                    <span style="margin-left:10px;">Sales</span>
                  </div>
                  <div class="tile-stats"><b>{{ $sales }}</b>
                  </div>
                  
                </section>
        </div>
         <div class="col-md-3 col-sm-6 col-xs-12">
                <section class="dash-tile bg-success">
                  <div class="tile-title title-heading text-center bg-sucess">
                    <a href="javascript:;" class="widget-refresh"><i class="ti-reload pull-right"></i></a>
                    <a href="javascript:;"><i class="ti-menu pull-left"></i></a>
                    <span style="margin-left:10px;">Total earning</span>
                  </div>
                  <div class="tile-stats"><b>{{App\Http\Controllers\HomeController::converter( $totalearned) }}</b>
                  </div>
                  
                </section>
        </div>
         <div class="col-md-3 col-sm-6 col-xs-12">
                <section class="dash-tile bg-success">
                  <div class="tile-title title-heading text-center bg-sucess">
                    <a href="javascript:;" class="widget-refresh"><i class="ti-reload pull-right"></i></a>
                    <a href="javascript:;"><i class="ti-menu pull-left"></i></a>
                    <span style="margin-left:10px;">Due payment</span>
                  </div>
                  <div class="tile-stats"><b>{{ App\Http\Controllers\HomeController::converter($getduepayment) }}</b>
                  </div>
                  
                </section>
        </div>
             
              
    </div>
       
          <div class="panel-body pn">
          	<h4>Products List</h4><br>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mg-t" id="table">
                                <thead>
                                <tr class="bg-light">
                                    <th class="text-center">S/N</th>
                                    <th class="">Image</th>
                                    <th class="">Product Title</th>
                                    <th class="">Vendor</th>
                                    <th class="">SKU</th>
                                    <th class="">Price</th>
                                    <th class="">commision (%)</th>
                                    <th class="">Stock</th>
                                    <th class="text-right">Status</th>
                                    <th class="">Action</th>

                                </tr>
                                </thead>
                                <tbody>
                   					<?php echo $view ?>
                               
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="container">
                      <div class="row">
                        <div class="col-md-3">
                          @if($bankdetails == null)
                            @else
                            <div class="bank-details">
                            <div class="bank-header">
                              <h2><a href="{{ url('vendors/bank') }}">Bank details</a></h2>
                            </div>
                            <div class="bank-main">
                              <div>Bank Name: <span>{{ $bankdetails->bank_name }}</span></div>
                              <div>Account Name: <span>{{ $bankdetails->account_name }}</span></div>
                              <div>Account Number: <span>{{ $bankdetails->account_number }}</span></div>
                            </div>
                          </div>
                          @endif
                        </div>
                        <div class="col-md-9">
                          <div class="bank-details">
                            <div class="bank-header">
                              <h2><a href="{{ url('vendors/settings') }}">Your Profile</a></h2>
                            </div>
                            <div class="bank-main">
                              <div>Your Name: <span>{{ Auth::User()->name }}</span></div>
                              <div>Your Email: <span>{{ Auth::User()->email }}</span></div>
                              <div>Your Phone: <span>{{ Auth::User()->phone }}</span></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

@include('includes_vendor.footer')