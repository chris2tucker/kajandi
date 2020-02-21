<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Outstanding Payment</title>
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
                    
                    
                    <li class="breadcrumb-current-item">OutStanding payment</li>
                </ol>
            </div>

    </header>
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><em class="ti-user mr5"></em>Due and Outstanding Payment</h3>
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
                                <div class="panel-title">Due and Oustanding Payment
                                </div>
                            </div>
                           
                            <div class="panel-body pn">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped mg-t" id="table">
                                        <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Transaction Id</th>
                                            <th>Order number</th>
                                            <th>Customer</th>
                                            <th >Product</th>
                                            <th>Amount</th>
                                            <th>Transaction Date</th>
                                            <th>Due Date</th>
                                            <th>Payment</th>
                                            <th>Status</th>
                                          </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Transaction Id</th>
                                            <th>Order number</th>
                                            <th>Customer</th>
                                            <th >Product</th>
                                            <th>Amount</th>
                                            <th>Transaction Date</th>
                                            <th>Due Date</th>
                                            <th>Payment</th>
                                            <th>Status</th>
                                          </tr>
                                        </tfoot>
                                        <tbody>
                                        
                                          <?php echo $view ?>
                                        
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

@include('includes.footer')
