<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Add Customer</title>
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
                    
                    <li class="breadcrumb-current-item">Add Customer</li>
                </ol>
            </div>
            
        </header>


 


    <section id="content" class="table-layout animated fadeIn">

         
            <!--  /Column Left  -->

            <!--  Column Center -->
            <div class="chute chute-center">

                <div class="mw1000 center-block">

                    <!--  Spec Form  -->
                    <div class="allcp-form">
                        <div class="panel">
                            <div class="panel-heading">
                                <div class="panel-title">Add Customer
                                </div>
                            </div>
                            <div class="panel-body br-t">
                            <div class="allcp-form theme-primary tab_product">

                            @if(Session::has('status'))
                            <p class="alert alert-success alert-dismissable fade in">{{ Session::get('status') }}</p>
                            @endif
                           

                            <div class="box-tab">

                                      
                            <form method="POST" action="{{ url('vendors/customer/store') }}" class="" id="form-product" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                      <div class="tab-content text-center">
                                        <div class="tab-pane fade active in" id="general">
                                         

                                           
                                        <div class="form-group">
                                             <div class="row">
                                                <label for="store-name" class="col-sm-2 control-label small">Select Customer:<font color="red">*</font></label>
                                                    <div class="col-sm-10 ph10">
                                                            <select id="vendor" name="customer_id" class="form-control chosen">
                                                                <option value="">Select Customer</option>
                                                               @foreach($customers as $customer)
                                                                <option value="{{ $customer->id }}" >{{ $customer->name }}</option>
                                                               
                                                                @endforeach
                                                            </select>
                                                           
                                                         
                                                    </div>
                                              </div>
                                            </div>
                                             <div class="form-group">
                                             <div class="row">
                                                <label for="store-name" class="col-sm-2 control-label small">Customer Status:<font color="red">*</font></label>
                                                    <div class="col-sm-10 ph10">
                                                            <select id="vendor" name="status" class="form-control chosen">
                                                                <option value="">Customer status</option>
                                                              
                                                                <option value="yes">approved</option>
                                                               <option value="pending">pending</option>
                                                               
                                                            </select>
                                                           
                                                         
                                                    </div>
                                              </div>
                                            </div>
                                  

                                           
                                            

                                    <button type="submit" class="btn btn-primary" style="margin-top: 10px;margin-left:18rem;">Save</button>
                                            <br><br><br><br><br><br><br><br><br><br><br><br><br>
                                        </div>
                            <!-- -End First Tab General-->

                             


                                </form>

                                      </div>

                                    </div>
                            </div>
                              




                              
            <!--  /Column Center  -->

@include('includes_vendor.footer')


