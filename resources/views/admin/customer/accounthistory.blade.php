<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Wallet History</title>
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
                        <a href="{{url('admin/customers')}}">Customer</a>
                    </li>
                   
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
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Wallet History
                            </div>
                            <div class="panel-body">

              
                            <div class="panel-body pn">
                                <div class="table-responsive">

                                    <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th >Transaction Type</th>
                                            <th>Transaction Id</th>
                                            <th>Amount</th>
                                            <th>Balance</th>
                                            <th>Transaction Date</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>S/N</th>
                                            <th >Transaction Type</th>
                                            <th>Transaction Id</th>
                                            <th>Amount</th>
                                            <th>Balance</th>
                                            <th>Transaction Date</th>
                                        </tr>
                                        </tfoot>
                                        <tbody class="data">

                                        <?php echo $view ?>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                      

                                

                                <!-- -------------- /form -------------- -->



                            </div>
                        </div>

                    </div>



                </div>
            </div>
            <!-- -------------- /Column Center -------------- -->
@include('includes.footer')
