<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Accounts</title>
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
                    <li class="breadcrumb-link">
                        <a href="{{url('aadmin/accounts')}}">Accounts</a>
                    </li>
                   
                </ol>
            </div>
            
        </header>

    <section id="content" class="table-layout animated fadeIn">

         
            <!-- -------------- /Column Left -------------- -->

            <!-- -------------- Column Center -------------- -->
        <div class="chute chute-center">

            <div class="mw1000 center-block">

             
                <div class="row">
                    <div class="col-sm-3">
                        <div class="panel-group">
                            <div class="panel ">
                              <div class="panel-heading border_danger">
                                <h4 class="panel-title">
                                  <a data-toggle="collapse" href="#collapse1" class="collapsbtn" >Set Commission <i class="fa fa-plus" style="float: right;"></i> 
                                    <i class="fa fa-minus" style="float: right; display: none;"></i></a>
                                </h4>
                              </div>
                              <div id="collapse1" class="panel-collapse collapse">
                                <ul class="list-group">
                                  <li class="list-group-item"><a href="{{url('admin/comission_catagory')}}" type="button" class="btn btn-block btn-primary btn-xs">Set Catagory Commission</a>
                                  <a href="{{url('admin/comission_Subcatagory')}}" type="button" class="btn btn-block btn-success btn-xs">Set Sub Catagory Commission</a>
                                  <a href="{{url('admin/productCommission')}}" type="button" class="btn btn-block btn-danger btn-xs">Set Product Commission</a>
                                  </li>
                                </ul>

                             </div>
                            </div>
                          </div>
                        
                    </div>


                    <div class="col-sm-3">
                        <div class="panel-group">
                            <div class="panel ">
                              <div class="panel-heading border_success">
                                <h4 class="panel-title">
                                  <a data-toggle="collapse" href="#collapse2" class="collapsbtn" >Manage Order Financials <i class="fa fa-plus" style="float: right;"></i> 
                                    <i class="fa fa-minus" style="float: right; display: none;"></i></a>
                                </h4>
                              </div>
                              <div id="collapse2" class="panel-collapse collapse">
                                <ul class="list-group">
                                  <li class="list-group-item"><a href="{{url('admin/product_price')}}" type="button" class="btn btn-block btn-primary btn-xs">Product Price</a>
                                  <a href="{{url('admin/totalOrderPrice')}}" type="button" class="btn btn-block btn-success btn-xs">Total Order price</a>
                                  </li>
                                </ul>

                             </div>
                            </div>
                          </div>
                        
                    </div>

                    <div class="col-sm-3">
                        <div class="panel-group">
                            <div class="panel ">
                              <div class="panel-heading border_primary">
                                <h4 class="panel-title">
                                  <a data-toggle="collapse" href="#collapse3" class="collapsbtn" >Customer/Buyer Financials Details <i class="fa fa-plus" style="float: right;"></i> 
                                    <i class="fa fa-minus" style="float: right; display: none;"></i></a>
                                </h4>
                              </div>
                              <div id="collapse3" class="panel-collapse collapse">
                                <ul class="list-group">
                                  <li class="list-group-item">
                                    <a href="{{url('admin/customer_outsatnding_payment')}}" type="button" class="btn btn-block btn-danger btn-xs">Outstanding Payment</a>
                                    <a href="{{url('admin/due_customer_payment')}}" type="button" class="btn btn-block btn-success btn-xs">Due Payemnt</a>
                                    <a href="{{url('admin/totalpurchase')}}" type="button" class="btn btn-block btn-primary btn-xs">Total Purchase</a>
                                    <!-- <a href="{{url('admin/totalOrderPrice')}}" type="button" class="btn btn-block btn-info btn-xs">Total Payments</a> -->
                                  </li>
                                </ul>

                             </div>
                            </div>
                          </div>
                        
                    </div>

                    <div class="col-sm-3">
                        <div class="panel-group">
                            <div class="panel ">
                              <div class="panel-heading border_primary">
                                <h4 class="panel-title">
                                  <a data-toggle="collapse" href="#collapse4" class="collapsbtn" >Vendor/Seller Financials Details <i class="fa fa-plus" style="float: right;"></i> 
                                    <i class="fa fa-minus" style="float: right; display: none;"></i></a>
                                </h4>
                              </div>
                              <div id="collapse4" class="panel-collapse collapse">
                                <ul class="list-group">
                                  <li class="list-group-item">
                                    <a href="{{url('admin/vendor_outstanding_payment')}}" type="button" class="btn btn-block btn-danger btn-xs">Outstanding Payment</a>
                                    <a href="{{url('admin/vendor_due_payment')}}" type="button" class="btn btn-block btn-success btn-xs">Due Payemnt</a>
                                    
                                  </li>
                                </ul>

                             </div>
                            </div>
                          </div>
                        
                    </div>

                </div> 
                <div class="row">
                   <div class="col-sm-3">
                        <div class="panel-group">
                            <div class="panel ">
                              <div class="panel-heading border_primary">
                                <h4 class="panel-title">
                                  <a data-toggle="collapse" href="#collapse5" class="collapsbtn" >Vendor/Seller Financials Details <i class="fa fa-plus" style="float: right;"></i> 
                                    <i class="fa fa-minus" style="float: right; display: none;"></i></a>
                                </h4>
                              </div>
                              <div id="collapse5" class="panel-collapse collapse">
                                <ul class="list-group">
                                  <li class="list-group-item">
                                    <a href="{{url('admin/bank_details')}}" type="button" class="btn btn-block btn-danger btn-xs">Ecommerace bank detail</a>
                                    
                                    
                                  </li>
                                </ul>

                             </div>
                            </div>
                          </div>
                        
                    </div>
                    <div class="col-sm-3">
                        <div class="panel-group">
                            <div class="panel ">
                              <div class="panel-heading border_primary">
                                <h4 class="panel-title">
                                  <a data-toggle="collapse" href="#collapse6" class="collapsbtn" >Payment <i class="fa fa-plus" style="float: right;"></i> 
                                    <i class="fa fa-minus" style="float: right; display: none;"></i></a>
                                </h4>
                              </div>
                              <div id="collapse6" class="panel-collapse collapse">
                                <ul class="list-group">
                                  <li class="list-group-item">
                                    <a href="{{url('admin/payment/approve')}}" type="button" class="btn btn-block btn-danger btn-xs">Payment Approve</a>
                                    
                                    
                                  </li>
                                  <li class="list-group-item">
                                    <a href="{{url('admin/payment/approved')}}" type="button" class="btn btn-block btn-danger btn-xs">Payment Approved</a>
                                    
                                    
                                  </li>
                                  <li class="list-group-item">
                                    <a href="{{url('admin/outstandingdue/payment/approve')}}" type="button" class="btn btn-block btn-danger btn-xs">Outstanding payment Approve</a>
                                    
                                    
                                  </li>
                                </ul>

                             </div>
                            </div>
                          </div>
                        
                    </div>
                   <!-- <div class="col-sm-3">
                        <div class="panel-group">
                            <div class="panel ">
                              <div class="panel-heading border_primary">
                                <h4 class="panel-title">
                                  <a data-toggle="collapse" href="#collapse7" class="collapsbtn" >Wallet <i class="fa fa-plus" style="float: right;"></i> 
                                    <i class="fa fa-minus" style="float: right; display: none;"></i></a>
                                </h4>
                              </div>-->
                              <!--<div id="collapse7" class="panel-collapse collapse">
                                <ul class="list-group">
                                  <li class="list-group-item">
                                    @php
                                    $wallet=App\wallethistory::where('transactiontype','=',3)->count();
                                    @endphp
                                    <a href="{{url('admin/wallet/pending')}}" type="button" class="btn btn-block btn-danger btn-xs">Wallet Pending<div class="badge badge-top bg-danger animated flash">{{$wallet}}</div></a>
                                    
                                    
                                  </li>
                                  <li class="list-group-item">
                                    <a href="{{url('admin/wallet/approved')}}" type="button" class="btn btn-block btn-danger btn-xs">Wallet Approved</a>
                                    
                                    
                                  </li>
                                 <li class="list-group-item">
                                    <a href="{{url('admin/payment/approved')}}" type="button" class="btn btn-block btn-danger btn-xs">Payment Approved</a>
                                    
                                    
                                  </li>
                                </ul>

                             </div>
                            </div>
                          </div>
                        
                    </div>-->
                    <div class="col-sm-3">
                        <div class="panel-group">
                            <div class="panel ">
                              <div class="panel-heading border_primary">
                                <h4 class="panel-title">
                                  <a data-toggle="collapse" href="#collapse8" class="collapsbtn" > Bank <i class="fa fa-plus" style="float: right;"></i> 
                                    <i class="fa fa-minus" style="float: right; display: none;"></i></a>
                                </h4>
                              </div>
                              <div id="collapse8" class="panel-collapse collapse">
                                <ul class="list-group">
                                  <li class="list-group-item">
                                    <a href="{{url('admin/vendor/bank')}}" type="button" class="btn btn-block btn-danger btn-xs">Vendor Bank</a>
                                    
                                    
                                  </li>
                                  <li class="list-group-item">
                                    <a href="{{url('admin/bank_details')}}" type="button" class="btn btn-block btn-danger btn-xs">Ecommerace Bank</a>
                                    
                                    
                                  </li>
                                 <!-- <li class="list-group-item">
                                    <a href="{{url('admin/payment/approved')}}" type="button" class="btn btn-block btn-danger btn-xs">Payment Approved</a>
                                    
                                    
                                  </li>-->
                                </ul>

                             </div>
                            </div>
                          </div>
                        
                    </div>
                  
                </div>




               
            </div>
        </div>

<script>

 $(".delete").on("submit", function(){
        
        return confirm("Do you want to delete this item?");
        
    });
    
</script>
            <!-- -------------- /Column Center -------------- -->
@include('includes.footer')
