<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Product Commission</title>
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
                        <a href="{{url('admin/bankdetails')}}">Bank Details</a>
                    </li>
                   
                </ol>
            </div>
            
        </header>
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><em class="ti-user mr5"></em>Bank Details</h3>
                </div>
            </div>
<style type="text/css">
    #from_image {
    padding: 0px;
}
</style>

      <!-- -------------- Topbar -------------- -->
 

         
            <!-- -------------- /Column Left -------------- -->

            <!-- -------------- Column Center -------------- -->
            <div class="chute chute-center">

                <div class="mw1000 center-block">
                   

                    <!-- -------------- Spec Form -------------- -->
                    <div class="allcp-form">
                        <div class="panel">
                           
                           

                        <div class="col-md-12">
                        <div class="panel panel-default" id="spy3">
                            <div class="panel-heading">
                                <div class="panel-title hidden-xs">
                                    Vendor bank details
                                </div>
                            </div>
                            <div class="panel-body pn">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped mg-t" id="table">
                                        <thead>
                                            <tr><td>Vendor Name</td>
                                            <td>Bank Name</td>
                                            <td>Account Number</td>
                                            <td>Account Name</td>
                                            <td>Account Type</td>
                                            </tr>
                                        </thead>
                                        @foreach($bankdetail as $bank)
                                       <tr> <td>{{$bank->name}}</td>
                                        <td>{{$bank->bank_name}}</td>
                                        <td>{{$bank->account_number}}</td>
                                        <td>{{$bank->account_name}}</td>
                                        @if($bank->account_type==0)
                                        <td>Current</td>
                                        @else
                                        <td>Saving</td>
                                        @endif
                                        </tr>
                                        @endforeach
                                        <tbody>
                                        
                                         
                                           
                                                        

                                                        

                                                  
                                                
                                        	
                                          
                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    

                                

                                <!-- -------------- /form -------------- -->



                        </div>

                    </div>



                </div>
            </div>
            <!-- -------------- /Column Center -------------- -->

@include('includes.footer')