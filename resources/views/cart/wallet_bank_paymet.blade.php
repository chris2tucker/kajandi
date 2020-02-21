@extends('layouts.pagelayout')
@section('content')

	<div class="gap"></div>
        <div class="container" style="width: 90%">
            <div class="" style="    text-align: center;
    margin-bottom: 40px;"><img src="{{url('img/logo-2.png')}}" alt="" style="    height: 100px;"></div>
            <div class="payment-success-title-area">
                <div class="row">
                    <h4 class=" col-sm-6" style="text-align: center;color: #1c6e93;">Kajandi payment slip</h4>
                   
                </div>
                
               
            </div>
            <div class="gap gap-small"></div>
            <div class="row row-col-gap">
                <div class="col-md-12">
                   <h3 class="widget-title">Order Information</h3>
                    <p>Pay the Exact amount ({{App\Http\Controllers\HomeController::converter($wallethistory->payment)}}) you entered into your online deposit into</p>
                    <div class="box">
                        <table class="table">
                            <thead>
                                <tr style="background: #4fc714;">
                                    <th>DESCRIPTION </th>
                                    <th>INFORMATION</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Payment ID</td>
                                    <td>{{$wallethistory->transactionid}}</td>
                                </tr>
                                <tr>
                                    <td>Account Name</td>
                                    <td>{{$bank->account_name}}</td>
                                </tr>
                                <tr>
                                    <td>Account Number</td>
                                    <td>{{$bank->account_number}}</td>
                                </tr>
                                <tr>
                                    <td>Account type</td>
                                    @if($bank->account_type==0)
                                    <td>Current Account</td>
                                    @else
                                    <td>Saving Account</td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>Sort Code</td>
                                    <td>{{$bank->sort_code}}</td>
                                </tr>  
                                
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
            <p>Make sure you include your payment ID({{$wallethistory->transactionid}}) in your Payment information. You can contact us for more information</p>
<h3><a href="{{url('page/contact')}}" title="">Contact us for more information</a></h3>

        </div>
        <button onclick="myFunction()" class="btn btn-primary" style="float: right;margin-right: 100px;
">Print this page</button>

<script>
function myFunction() {
  window.print();
}
</script>
        <div class="gap"></div>
       
@endsection