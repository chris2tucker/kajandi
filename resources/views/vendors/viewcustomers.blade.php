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
                        <a href="#">Customer</a>
                    </li>
                   
                </ol>
            </div>
            
        </header>
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><em class="ti-user mr5"></em>Customer</h3>
                </div>
            </div>


        <div class="chute chute-center">

            <div class="mw1000 center-block">

                <div class="allcp-form">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title">Customers
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
                                        <tr>
                                             <td>Website:</td>
                                             <td><?php echo $customer->website; ?></td>
                                        </tr>
                                        <tr>
                                             <td>Cac:</td>
                                             <td><?php echo $customer->cac; ?></td>
                                        </tr>
                                         <tr>
                                             <td>Company Rating:</td>
                                             <td><?php echo $customer->company_rating; ?></td>
                                        </tr>
                                         <tr>
                                             <td>State:</td>
                                             <td><?php echo $customer->state; ?></td>
                                        </tr>
                                         <tr>
                                             <td>City:</td>
                                             <td><?php echo $customer->city; ?></td>
                                        </tr>
                                         <tr>
                                             <td>company Name:</td>
                                             <td><?php echo $customer->company_name; ?></td>
                                        </tr>
                                        <tr>
                                        	<td>Status:</td>
                                        	<?php echo $btn; ?>
                                        </tr>
                                        <tr>
                                        	<td></td>
                                        	<td><?php echo $btn2; ?></td>
                                        </tr>
                                      
                                     </table> 
                                     <br><br><br><br>
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

	$(document).on('click', '.acceptuser', function() {
		id = $(this).attr('id');
            value = 'yes';
            url = ajaxurl+'/vendors/confirmcustomer';
		 $.get(
                        url,
                  {id: id,
                    value: value},
                  function(data) {
                  	window.location = ajaxurl+'/vendors/viewcustomers/'+data;
                  });
	})
    

        $('.declineuser').click(function () {
            id = $(this).attr('id');
            value = 'declined';
            url = ajaxurl+'/vendors/confirmcustomer';
                $.get(
                        url,
                  {id: id,
                    value: value},
                  function(data) {
                  	window.location = ajaxurl+'/vendors/viewcustomers/'+data;
                  });
        })
</script>


@include('includes_vendor.footer')






