<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Vendor Product</title>
    @include('includes_vendor.head')
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js"></script>
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
                        <a href="{{url('vendor/index')}}">Dashboard</a>
                    </li>
                    
                    <li class="breadcrumb-current-item">Add Bank Information</li>
                </ol>
            </div>
            
        </header>


 


    <section id="content" class="table-layout animated fadeIn">

         
            <!-- -------------- /Column Left -------------- -->

            <!-- -------------- Column Center -------------- -->
            <div class="chute chute-center">

                <div class="mw1000 center-block">

                    <!-- -------------- Spec Form -------------- -->
                    <div class="allcp-form">
                        <div class="panel">
                            <div class="panel-heading">
                                <div class="panel-title">Add Bank Details
                                </div>
                            </div>
                            <div class="panel-body br-t">
                            <div class="allcp-form theme-primary tab_product">

                            @if(Session::has('status'))
                            <p class="alert alert-success alert-dismissable fade in">{{ Session::get('status') }}</p>
                            @endif
                           

                            <div class="box-tab">

                                      
                            <form method="POST" action="{{ route('vendors.bank.store') }}" class="" id="form-product" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                      <div class="tab-content text-center">
                                        <div class="tab-pane fade active in" id="general">
                                          <div class="form-group">
                                                <div class="row">
                                                <label for="store-name" class="col-sm-2 control-label small">Name:<font color="red">*</font></label>
                                                <div class="col-sm-10">
                                                        <input type="text" name="name"  class="form-control" placeholder="Name" value="{{ $bankdetails == null ? '' : $bankdetails->name }}">
                                                  </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                <label for="store-name" class="col-sm-2 control-label small">Bank Name: <font color="red">*</font></label>
                                                <div class="col-sm-10">
                                                        <input type="text" name="bank_name" id="business-name" class="form-control" placeholder="Bank Name" value="{{
                                                        $bankdetails == null ? '' : $bankdetails->bank_name }}">   
                                                  </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                <label for="store-name" class="col-sm-2 control-label small">Account Name: <font color="red">*</font></label>
                                                <div class="col-sm-10">
                                                        <input type="text" name="account_name" id="business-name" class="form-control" placeholder="Account Name" value="{{
                                                        $bankdetails == null ? '' : $bankdetails->account_name }}">   
                                                  </div>
                                                </div>
                                            </div>
                                                      <div class="form-group">
                                             <div class="row">
                                                <label for="store-name" class="col-sm-2 control-label small">Account Type:<font color="red">*</font></label>
                                                    <div class="col-sm-10 ph10">
                                                            <select id="vendor" name="account_type" class="form-control chosen">
                                                                <option value="">Select Account Type </option>
                                                                <option value="0"{{ ($bankdetails == null ? '' : $bankdetails->account_type == 0) ? 'selected' : '' }}>Current</option>
                                                                <option {{ ($bankdetails == null ? '' : $bankdetails->account_type == 1 )? 'selected' : '' }} value="1">Saving</option>
                                                                
                                                            </select>
                                                           
                                                         
                                                    </div>
                                              </div>
                                            </div>
                                             <div class="form-group">
                                                <div class="section row mb10">
                                                   <label for="store-name" class="col-sm-2 control-label small">Account Number:</label>
                                                     <div class="col-sm-10 ph10">
                                                        <input type="Number" name="account_number" class="form-control" value="{{ $bankdetails == null ? '' : $bankdetails->account_number }}">   
                                                    </div>
                                                </div>
                                            </div>
                                  

                                           
                                            

                                    <button type="submit" class="btn btn-primary" style="margin-top: 10px;margin-left:18rem;">Save</button>
                                            
                                        </div>
                            <!-- ---------------------------------------------End First Tab General---------------------------------------------------->

                             


                                </form>

                                      </div>

                                    </div>
                            </div>
                              




                              
            <!-- -------------- /Column Center -------------- -->

@include('includes_vendor.footer')


