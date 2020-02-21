<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Requisition</title>
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
                    
                    
                    <li class="breadcrumb-current-item">Requisition</li>
                </ol>
            </div>

    </header>
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><em class="ti-user mr5"></em>Requisition</h3>
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
                                <div class="panel-title">Pending wallets
                                </div>
                            </div>
                            <div class="panel-body">
                                   
                        <div class="col-md-12">
                       
                            
                            <div class="panel-body pn">
                                <div class="table-responsive">
                                    <div>
                                    
                                    
                                        
                                    <table class="table table-bordered table-striped mg-t" id="table">

                                        <thead>

                                        <tr>
                                           
                                            <th>Transaction number</th>
                                            <th>Customer</th>
                                            <th>amount</th>
                                            <th>Date</th>
                                            <th>actions</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                          
                                            <th>Transaction number</th>
                                            <th>Customer</th>
                                            <th>amount</th>
                                            <th>Date</th>
                                            <th>actions</th>
                                        </tr>
                                        </tfoot>
                                        <tbody id="re">
                                        @foreach($getpending as $pend)
                                        <tr>
                                          <td>{{$pend->transactionid}}</td>
                                          <td>{{App\User::find($pend->user_id)->name}}</td>
                                          <td>{{App\Http\Controllers\HomeController::converter($pend->payment)}}</td>
                                          <td>{{$pend->created_at->toDateString()}}</td>
                                          <td><a href="{{url('wallet/pending/'.$pend->id.'/'.App\User::find($pend->user_id)->id)}}" title="">Approve</a></td>
                                        </tr>

                                        @endforeach
                                          
                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
            

                                

                                <!--  /form  -->



                            </div>
                        </div>

                    </div>



                </div>
            </div>
            <!--  /Column Center  -->


<script type="text/javascript">
        $('.deliverystatus').change(function () {
            orderid = $(this).attr('id');
            value = $(this).val();
            url = ajaxurl+'/deliverystatus';
                $.get(
                        url,
                  {value: value,
                    orderid: orderid},
                  function(data) {
                  });
        })

</script>
<script type="text/javascript">
        $('.pending-product').change(function () {
          orderid = $(this).attr('id');
            value = $(this).val();
           url = ajaxurl+'/order/pending';
             $.ajax({
                url:url,
                data: {value:value,
                    orderid: orderid},
               type: "GET",
               dataType: "Html",
               success:function(response){
                console.log(response)
                
               }
           });
        })
</script>
<script type="text/javascript">
        $('.pending-category').change(function () {
            value = $(this).val();
           url = ajaxurl+'/order/category';
             $.ajax({
                url:url,
                data: {value:value},
               type: "GET",
               dataType: "Html",
               success:function(response){
                $("#re").html(response)
               }
           });
        })
</script>
<script type="text/javascript">
        $('.pending-subcategory').change(function () {
            value = $(this).val();
           url = ajaxurl+'/order/pending';
             $.ajax({
                url:url,
                data: {value:value},
               type: "GET",
               dataType: "Html",
               success:function(response){
                $("#re").html(response)
               }
           });
        })
</script>
@include('includes.footer')

