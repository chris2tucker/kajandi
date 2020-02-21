<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Customers</title>
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
                    
                    
                    <li class="breadcrumb-current-item">Customer</li>
                </ol>
            </div>

    </header>
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><em class="ti-user mr5"></em>Customers</h3>
                </div>
            </div>

        <div class="chute chute-center">

            <div class="mw1000 center-block">

                <div class="allcp-form">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             <a href="{{url('admin/addcustomer')}}" class="btn btn-bordered btn-primary mb5"> ADD CUSTOMER</a>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-12">
                                
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped mg-t" id="table">
                                           <thead>
                                            <tr>
                                                <th>S/N</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>State</th>
                                                <th>City</th>
                                                <th>Orders</th>
                                                <th >Status</th>
                                                <th >User ID</th>
                                                <th>View Orders</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                <th>S/N</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Orders</th>
                                                <th >Status</th>
                                                <th >User ID</th>
                                                <th>View Orders</th>
                                            </tr>
                                            </tfoot>
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
    $(document).ready(function() {
        $( ".delete" ).click(function() {
           return confirm("Are you sure delete!");
    });
    
} );
</script>
@include('includes.footer')