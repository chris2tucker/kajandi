@extends('layouts.pagelayout')
@section('content')

<style type="text/css">
	.row {
  display: flex; /* equal height of the children */
  width: 100%;
}
@media (max-width: 768px) {
  .col-xs-12 {
  	float: left;
    width: 100%;
  }
  .row {
  display: table-row; /* equal height of the children */
}
}


</style>

<link rel="stylesheet" type="text/css" href="{{URL::asset('/css/datatables.min.css') }}"/>
<script src="{{URL::asset('/js/canvasjs.min.js') }}"></script>

<div class="mfp-with-anim mfp-hide mfp-dialog clearfix" id="review-dialog">
            <h3 class="widget-title">Fund Account</h3>
            <hr />
                
                <div class="form-group">
                    <label>Amount</label>
                    <input class="form-control fund" type="number" />
                    <p class="alert alert-danger emailerror" style="display: none;">
                        Email field is empty
                    </p>
                </div>
                <input class="btn btn-primary addfund" type="submit" value="Send" />
                <p class="successtext" style="display: none; padding: 3px"></p>
            
            <div class="gap gap-small"></div>
        </div>

<div class="container" style="margin-bottom: -30px !important;width: 100%;margin: 0;">
	<br>
	<ol class="breadcrumb page-breadcrumb">
                    <li><a href="/">Home</a>
                    </li>
                    <li><a href="#">Dashboard</a>
                    </li>
                    <li class="active">{{Auth::user()->name}}</li>
                </ol>
                <br>
	<div class="row" style="margin: 0;">
		
		<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 dashpanel">
			<div class="gap gap-small"></div>
			@include('customers.customer_dasboard')
			<div class="gap gap-big"></div>
      <div class="gap gap-big"></div>
      <div class="gap gap-big"></div>
      <div class="gap gap-big"></div>
		</div>
		<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 box" >
      <div class="row">
        <div class="col-lg-4"></div>
        <div class="col-lg-4">
          <br><br><br>
          <h4>Change Wallet Password</h4>

          <p class="alert alert-success success" style="display: none;">
                Password Changed Successfully
            </p>

          <div class="form-group">
            <input type="password" name="password" class="form-control passwordval" placeholder="Old Wallet Password">
            <p class="alert alert-danger pass" style="display: none;">
                Password field is empty
            </p>      
          </div>
          <div class="form-group">
            <input type="password" name="newpassword" class="form-control newpassword" placeholder="New Wallet Password">
            <p class="alert alert-danger newpass" style="display: none;">
                New Password field is empty
            </p>
          </div>
          <div class="form-group">
            <input type="password" name="confirmpassword" class="form-control confirmpassword" placeholder="Confirm Password">
            <p class="alert alert-danger conpass" style="display: none;">
                Confirm Password field is empty
            </p>
            <p class="alert alert-danger passmatch" style="display: none;">
                The Passwords must match
            </p>
            <p class="alert alert-danger incorrect" style="display: none;">
                Incorrect Password
            </p>
          </div>
          <button class="btn btn-primary btn-block changepassword">Change</button>
        </div>
      </div>

    
      
      <div class="gap gap-big"></div>
      <div class="gap gap-big"></div>
      <div class="gap gap-big"></div>
      <div class="gap gap-big"></div>
		</div>
	</div>
</div>

@endsection
@section('script')
<script type="text/javascript">
	$(".navtoggle").click(function() {
  $( ".showtoggle" ).toggle( "slow", function() {
    // Animation complete.
  });
});

$('.addfund').click(function() {
  fund = $('.fund').val();
  url = ajaxurl+'addfund';
    $.get(
        url,
        {fund: fund},
        function(data) {
          location.reload();
        });
})

$(document).ready(function(){
    $('#myTable').DataTable();
});

$('.changepassword').click(function() {
    password = $('.passwordval').val();
    newpassword = $('.newpassword').val();
    confirmpassword = $('.confirmpassword').val();
    walletpassword = "<?php echo $walletpassword; ?>";

    if (password.length > 1 && newpassword.length > 1 && confirmpassword.length > 1 && (newpassword == confirmpassword) && (password == walletpassword)) {
    
      url = ajaxurl+'changewalletpassword';
    $.get(
        url,
        {password: password,
        newpassword: newpassword,
        confirmpassword: confirmpassword},
        function(data) {
          if (data == 'fales') {
            $('.conpass').hide();
            $('.pass').hide();
            $('.newpass').hide();
            $('.passmatch').hide();
            $('.incorrect').show();
          }else{
            $('.success').show();
            $('.passwordval').val('');
            $('.newpassword').val('');
            $('.confirmpassword').val('');
          }
        });

    }else if (password.length < 1) {
      $('.pass').show();
      $('.newpass').hide();
      $('.conpass').hide();
      $('.passmatch').hide();
      $('.incorrect').hide();
    }else if (newpassword.length < 1) {
      $('.newpass').show();
      $('.conpass').hide();
      $('.pass').hide();
      $('.passmatch').hide();
      $('.incorrect').hide();
    }else if(confirmpassword.length < 1){
      $('.conpass').show();
      $('.pass').hide();
      $('.newpass').hide();
      $('.passmatch').hide();
      $('.incorrect').hide();
    }else if (newpassword != confirmpassword) {
      $('.conpass').hide();
      $('.pass').hide();
      $('.newpass').hide();
      $('.incorrect').hide();
      $('.passmatch').show();
    }else if (password != walletpassword) {
      $('.conpass').hide();
      $('.pass').hide();
      $('.newpass').hide();
      $('.passmatch').hide();
      $('.incorrect').show();
    }

})

</script>
@endsection










