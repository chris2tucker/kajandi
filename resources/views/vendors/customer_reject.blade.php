<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Outstanding Payment</title>
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
                    
                    
                    <li class="breadcrumb-current-item">Customer request</li>
                </ol>
            </div>

    </header>
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><em class="ti-user mr5"></em>Customer request</h3>
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
                                <div class="panel-title">Customer request
                                </div>
                            </div>
                           
                            <div class="panel-body pn">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped mg-t" id="table">
                                        <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Customer Name</th>
                                            <th>Credit limit</th>
                                            <th>Approved</th>
                                            
                                          </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                              <th>S/N</th>
                                            <th>Customer Name</th>
                                            <th>Credit limit</th>
                                            <th>Approved</th>
                                          </tr>
                                        </tfoot>
                                        <tbody>
                                        
                                         @foreach($vendor_reject as $key=>$vendor)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td><a href="" data-toggle='modal' data-target='#companyModal-{{$vendor->id}}'>{{ App\User::where('id',$vendor->customer_id)->first()->name }}</a></td>
                                                <form action="{{ route('vendors.vendor.approve',$vendor->id) }}" method="get" accept-charset="utf-8">
                                                 <td><input type="number" name="limit" placeholder="credit limit" required></td>
                                               
                                                <td><button type="submit" class="btn btn-danger" onclick="return confirm('Accepting the request automatically creates a Credit Relationship with Buyer. This means this Buyer can purchase products and services and pay in 15days or 30days. Depending on credit option selected. Kajandi.com.ng does not interfere or influence this relationship and will not be held accountable for any dispute that may arise from Credit Relationship');">Approve</button> </form>
                                                    <a href="" class="btn btn-sm btn-danger"  data-toggle="modal" data-target="#exampleModal-{{ $vendor->id }}">Reject</a></td>
                                            </tr>
                                            <div class='modal fade' id='companyModal-{{$vendor->id}}' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                              <div class='modal-dialog' role='document'>
                                                <div class='modal-content'>
                                                  <div class='modal-header'>
                                                    <h5 class='modal-title' id='exampleModalLabel'>Customer Details</h5>
                                                    
                                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                      <span aria-hidden='true'>&times;</span>
                                                    </button>
                                                  </div>
                                                  <div class='modal-body'>
                                                <div class="row">
                                                    <?php 
                                                    $customer=App\Customer::where('user_id','=',$vendor->customer_id)->first();
                                                   
                                                     ?>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                <label>Company name</label>
                                <input type="text" class="form-control" name="product_name" value="{{$customer->company_name}}"   autofocus readonly>

                            </div> 
                             <div class="form-group">
                                <label>Company website</label>
                                <input type="text" class="form-control" name="product_name" value="{{$customer->website}}"   autofocus readonly>

                            </div> 
                             <div class="form-group">
                                <label>Years of existance</label>
                                <input type="text" class="form-control" name="product_name" value="{{$customer->yearsofexitence}}"   autofocus readonly>

                            </div> 
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                <label>About company</label>
                                <input type="text" class="form-control" name="product_name" value="{{$customer->about}}"   autofocus readonly>

                            </div> 
                             <div class="form-group">
                                <label>Businuss type</label>
                                <input type="text" class="form-control" name="product_name" value="{{$customer->businesstype}}"   autofocus readonly>

                            </div> 
                             <div class="form-group">
                                <label>Company Rating</label>
                                <input type="text" class="form-control" name="product_name" value="{{$customer->company_ratings}}"   autofocus readonly>

                            </div> 
                                                    </div>
                                                </div>
                                                    
                                                  </div>
                                                  <div class='modal-footer'>
                                                   <!-- <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                                    <button type='submit' class='btn btn-primary'>Cancel Order</button>-->
                                                  </div>
                                                  </form>
                                                </div>
                                              </div>
                                            </div>
                                             <!-- Modal -->
                                            <div class="modal fade" id="exampleModal-{{ $vendor->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                              <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Why you want to cancel Request?</h5>
                                                    
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                    </button>
                                                  </div>
                                                  <div class="modal-body">
                                                    <form action="{{ route('vendors.vendor.reject',$vendor->id) }}" method="POST">
                                                        {{ csrf_field() }}
                                                         <div class="form-group">
                                                            <label for="message-text" class="col-form-label"></label>
                                                            <textarea class="form-control" id="message-text" cols="50" placeholder="Write this Reason" name="orderstatus"></textarea>
                                                          </div>
                                                    
                                                  </div>
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Reject</button>
                                                  </div>
                                                  </form>
                                                </div>
                                              </div>
                                            </div>
                                        @endforeach
                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                                

                                <!--  /form  -->



                    </div>



                </div>
            </div>
            <!--  /Column Center  -->




@include('includes.footer')
