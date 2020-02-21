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
                        <a href="#">Orders Detail</a>
                    </li>
                   
                </ol>
            </div>
            
        </header>
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><em class="ti-user mr5"></em>Orders Detail</h3>
                </div>
            </div>

        <div class="chute chute-center">

            <div class="mw1200 center-block">

                <div class="allcp-form">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">Requisition
                            </div>
                        </div>
                        <div class="panel-body">
                            <br>
                            <br>

                            <div class="col-md-12">
                                <div class="col-md-8">
                                     <table class="table">
                                        <tr>
                                            <td>Customer: </td>
                                            <td><?php echo $getcustomer->name; ?></td>
                                        </tr>
                                       <!-- <tr>
                                            <td>Phone:</td>
                                             <td><?php  $getorders->phone; ?></td>
                                        </tr>
                                        <tr>
                                             <td>Email:</td>
                                             <td><?php  $getcustomer->email; ?></td>
                                        </tr>
                                        <tr>-->
                                             <td>State: </td>
                                             <td><?php echo $getorders->orderstate; ?></td>
                                         </tr>
                                         <tr>
                                             <td>City: </td>
                                             <td><?php echo $getorders->ordercity; ?></td>
                                         </tr>
                                        <tr>
                                             <td>Shipping Address:</td>
                                             <td><?php echo $getorders->shipaddress; ?></td>
                                         </tr>
                                     </table> 
                                     <br><br><br><br>
                                </div>
                                <div class="col-md-4">
                                    <div class="pull-right">
                                        <p><b>Total: <?php echo App\Http\Controllers\HomeController::converter($totalprice); ?></b></p>
                                        <p><b>Quantity: <?php echo $totalquantity; ?></b></p>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped mg-t" id="table">
                                           <thead>
                                            <tr>
                                                <th>S/N</th>
                                                <th>Order Number</th>
                                                <th>Product</th>
                                                <th>Vendor</th>
                                                <th>Color</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th>Order Date</th>
                                                <th>Shipping Type</th>
                                                <th>Delivery Status</th>
                                            </tr>
                                            </thead>
                                            
                                            <tbody class="data">
                                            <?php echo $view ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
            <!-- -------------- /Column Center -------------- -->
    </section>


    
<script type="text/javascript">
    $(document).ready(function(){
    $('#myTable').DataTable();
});
    $('.deliverystatus').change(function () {
            orderid = $(this).attr('id');
            value = $(this).val();
            url = ajaxurl+'/orderdeliverystatus';
                $.get(
                        url,
                  {value: value,
                    orderid: orderid},
                  function(data) {
                  });
        })
</script>

@include('includes_vendor.footer')

