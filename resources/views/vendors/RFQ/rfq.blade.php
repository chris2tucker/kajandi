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
                    
                    
                    <li class="breadcrumb-current-item">Request for Quotations</li>
                </ol>
            </div>

    </header>
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><em class="ti-user mr5"></em>Request for Quotations</h3>
                </div>
            </div>

         
            <!-- -------------- /Column Left -------------- -->

            <!-- -------------- Column Center -------------- -->
            <div class="chute chute-center">

                <div class="mw1200 center-block">

                    <!-- -------------- Spec Form -------------- -->
                    <div class="allcp-form">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title">Quotations
                                </div>
                            </div>
                           
                            <div class="panel-body pn">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped mg-t" id="table">
                                        <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Category</th>
                                            <th >Sub-category</th>
                                            <th >File</th>
                                            <th>Quantity</th>
                                            <th>Duration</th>
                                            <th>Payment Method</th>
                                            <th>User Name</th>
                                            
                                            <th>Bid amount</th>
                                            <th>Bid note</th>
                                            <th>Place Bid</th>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                            @foreach($rfq as $rf)
                                            <tr>
                                                <td ><a href="" data-toggle='modal' data-target='#rfq-{{$rf->id}}'>{{$rf->product_name}}</a></td>
                                                <?php
                                                    $category=App\category::find($rf->category);
                                                    $subcategory=App\subcategory::find($rf->subcategory);
                                                    $user=App\User::find($rf->user_id);
                                                    $bids=App\rfqvendor::where('rfq_id','=',$rf->id)->where('vendor_id','=',Auth::user()->id)->first();

                                                  ?>
                                                <td >{{$category->name}}</td>
                                                <td >{{$subcategory->name}}</td>
                                                <td><a href="{{url('/'.$rf->file)}}" title="" download>file</a></td>
                                                <td >{{$rf->quantity}}</td>
                                                <td >{{$rf->duration}}</td>
                                                <td >{{$rf->paymentMethod}}</td>
                                                <td ><a href="" data-toggle='modal' data-target='#companyModal-{{$user->id}}'>{{$user->name}}</a></td>
                                                <form action="{{url('vendor/rfq/'.$rf->id)}}" method="POST" accept-charset="utf-8">
                                                {{csrf_field()}}
                                                <td>@if($bids==NULL)<input type="number" name="bid" required> @else {{App\Http\Controllers\HomeController::converter($bids->bid)}} @endif</td>
                                                <td>@if($bids==NULL)<input type="text" name="bidnote" required> @else {{$bids->note}} @endif</td>
                                                <td>@if($bids==NULL)<button type="submit" class="bn btn-primary">Bid</button>
                                                @else
                                                <p>placed bid</p>
                                            @endif</td>
                                                </form>
                                                

                                            </tr>
                                            
                                    <div class='modal fade' id='companyModal-{{$user->id}}' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                              <div class='modal-dialog' role='document'>
                                                <div class='modal-content'>
                                                  <div class='modal-header'>
                                                 <!--   <h5 class='modal-title' id='exampleModalLabel'>Why you want to cancel this order?</h5> -->
                                                    
                                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                      <span aria-hidden='true'>&times;</span>
                                                    </button>
                                                  </div>
                                                  <div class='modal-body'>
                                                <div class="row">
                                                    <?php 
                                                    $customer=App\Customer::where('user_id','=',$user->id)->first();
                                                   
                                                     ?>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                <label>Company name</label>
                                <input type="text" class="form-control" name="product_name" @if($customer) value="{{$customer->company_name}}" @endif  autofocus readonly>

                            </div> 
                             <div class="form-group">
                                <label>Company website</label>
                                <input type="text" class="form-control" name="product_name" @if($customer) value="{{$customer->website}}"  @endif autofocus readonly>

                            </div> 
                             <div class="form-group">
                                <label>Years of existance</label>
                                <input type="text" class="form-control" name="product_name" @if($customer) value="{{$customer->yearsofexitence}}" @endif   autofocus readonly>

                            </div> 
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                <label>About company</label>
                                <input type="text" class="form-control" name="product_name" @if($customer) value="{{$customer->about}}" @endif  autofocus readonly>

                            </div> 
                             <div class="form-group">
                                <label>Businuss type</label>
                                <input type="text" class="form-control" name="product_name" @if($customer) value="{{$customer->businesstype}}" @endif   autofocus readonly>

                            </div> 
                             <div class="form-group">
                                <label>Company Rating</label>
                                <input type="text" class="form-control" name="product_name" @if($customer) value="{{$customer->company_ratings}}" @endif  autofocus readonly>

                            </div> 
                                                    </div>
                                                </div>
                                                    
                                                  </div>
                                                  <div class='modal-footer'>
                                                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                                 <!--   <button type='submit' class='btn btn-primary'>SAVE</button> -->
                                                  </div>
                                                  </form>
                                                </div>
                                              </div>
                                            </div>
                                            <div class='modal fade' id='rfq-{{$rf->id}}' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                              <div class='modal-dialog' role='document'>
                                                <div class='modal-content'>
                                                  <div class='modal-header'>
                                                    <h5 class='modal-title' id='exampleModalLabel'>Product Details</h5>
                                                    
                                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                      <span aria-hidden='true'>&times;</span>
                                                    </button>
                                                  </div>
                                                  <div class='modal-body'>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                           <div class="form-group">
                                <label>Product name</label>
                                <input type="text" class="form-control" name="product_name" value="{{$rf->product_name}}"   autofocus readonly>

                            </div> 
                            <div class="form-group">
                                <label>Category name</label>
                                <input type="text" class="form-control" name="product_name" value="{{$category->name}}"   autofocus readonly>

                            </div> 
                            <div class="form-group">
                                <label>Sub-category name</label>
                                <input type="text" class="form-control" name="product_name" value="{{$subcategory->name}}"   autofocus readonly>

                            </div>
                            <div class="form-group">
                                <label>Genric name</label>
                                <input type="text" class="form-control" name="product_name" value="{{$rf->generic_name}}"   autofocus readonly>

                            </div>
                            <div class="form-group">
                                <label> file</label>
                                <a href="{{url('/'.$rf->file)}}" class="form-control" title="" download>Download</a>

                            </div>
                            <div class="form-group">
                                <label>Orders</label>
                                <input type="text" class="form-control" name="product_name" value="{{$rf->order}}"   autofocus readonly>

                            </div>
                        </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                <label>Unit</label>
                                <input type="text" class="form-control" name="product_name" value="{{$rf->unit}}"   autofocus readonly>

                            </div>
                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="text" class="form-control" name="product_name" value="{{$rf->quantity}}"   autofocus readonly>

                            </div>
                            <div class="form-group">
                                <label>Duration</label>
                                <input type="text" class="form-control" name="product_name" value="{{$rf->duration}}"   autofocus readonly>

                            </div>
                            <div class="form-group">
                                <label>Payment Method</label>
                                <input type="text" class="form-control" name="product_name" value="{{$rf->paymentMethod}}"   autofocus readonly>

                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" name="product_name" value="{{$rf->businuss_email}}"   autofocus readonly>

                            </div>
                            <div class="form-group">
                                <label>Product certificate</label>
                                <input type="text" class="form-control" name="product_name" value="{{$rf->product_certificate}}"   autofocus readonly>

                            </div>
                            </div>
                                                        
                                                    </div>
                                                </div>
                                              </div>
                                            </div>
                                            @endforeach

                                        </tbody>    
                                        <tfoot>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Category</th>
                                            <th >Sub-category</th>
                                            <th>File</th>
                                            <th>Quantity</th>
                                            <th>Duration</th>
                                            <th>Payment Method</th>
                                            <th>User Name</th>
                                            <th>Bid amount </th>
                                            <th>Bid note</th>
                                            <th>Place bid</th>
                                          </tr>
                                        </tfoot>
                                        <tbody>
                                        
                                          
                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                                

                                <!-- -------------- /form -------------- -->



                    </div>



                </div>
            </div>
            <!-- -------------- /Column Center -------------- -->




@include('includes.footer')
