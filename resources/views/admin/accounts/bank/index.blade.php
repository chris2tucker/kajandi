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
                                    Ecommerace bank details
                                </div>
                            </div>
                            <div class="panel-body pn">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped mg-t" id="table">
                                        
                                        
                                        <tbody>
                                        
                                         @php
                                         if (!$bank) {
    $bank = new App\bankdetail();
}
                                         @endphp
                                           
                                            	<form action="{{url('admin/bank_details')}}" method="POST" accept-charset="utf-8">
                                                 {{csrf_field()}}
                                             
                                             <tr>	
                                             <td>Bank Name</td>
                                             <td><input type="text" name="name" @if($bank) 
                                               value="{{$bank->bank_name}}" @endif required></td>
                                             </tr>  
                                             <tr>   
                                             <td>Account Name</td>
                                             <td><input type="text" name="accountname"  @if($bank) 
                                               value="{{$bank->account_name}}" @endif required></td>
                                             </tr>  
                                             <tr>   
                                             <td>Account Number</td>
                                             <td><input type="text" name="number"  @if($bank) 
                                               value="{{$bank->account_number}}" @endif required></td>
                                             </tr> 
                                             <tr>   
                                             <td>Sort code</td>
                                             <td><input type="text" name="code"  @if($bank) 
                                               value="{{$bank->sort_code}}" @endif required></td>
                                             </tr>
                                             <tr>
                                                 <td>Account type</td>
                                                 <td>
                                                     <select name="account_type" style="width: 170px;">
                                                         <option value="0" @if($bank->account_type==0) selected @endif>Current</option>
                                                         <option value="1" @if($bank->account_type==1) selected @endif>Saving</option>
                                                         
                                                     </select>
                                                 </td>
                                             </tr> 
                                             <tr>
                                                <td></td>
                                                <td> <button type="submit" class="btn btn-primary">Save</button></td>
                                             </tr>    
                                                </form>


                                                        

                                                  
                                                
                                        	
                                          
                                        
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