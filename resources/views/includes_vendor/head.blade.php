<link rel="icon" href="{{url('/img/logo-2.png')}}" sizes="16x16">  
  <link rel="stylesheet" href="{{ URL::asset('public/css/vendor/bootstrap/dist/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{URL::asset('public/css/dataTables.bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('public/css/styles/font-awesome.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('public/css/styles/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('public/css/styles/animate.css') }}">
{{--  <link rel="stylesheet" href="{{ URL::asset('public/css/styles/sublime.skins.css') }}" id="skin"> --}}
  <link rel="stylesheet" href="{{ URL::asset('public/css/styles/sublime.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('public/css/styles/martial.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('public/css/toastr.min.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('public/css/vendor/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('public/css/vendor/chosen_v1.4.0/chosen.min.css') }}">
 <link rel="stylesheet" href="{{URL::asset('public/bootstrap-datepicker/css/bootstrap-material-datetimepicker.css') }}">
 <link rel="stylesheet" href="{{URL::asset('public/css/buttons.dataTables.min.css') }}">



<link rel="stylesheet" href="{{URL::asset('public/css/vendor/datatables/media/css/jquery.dataTables.css') }}">

 <script src="{{ URL::asset('public/css/vendor/modernizr.js') }}"></script> 



    
  <script src="{{ URL::asset('public/js/jquery.min.js') }}"></script> 
   

  


 <script src="{{ URL::asset('public/css/vendor/jquery/dist/jquery.js') }}"></script> 

   <script src="{{ URL::asset('public/css/vendor/switchery/dist/switchery.js') }}"></script>
  <script src="{{ URL::asset('public/css/vendor/bootstrap/dist/js/bootstrap.js') }}"></script>
  <script src="{{ URL::asset('public/css/vendor/slimScroll/jquery.slimscroll.js') }}"></script>
  <script src="{{ URL::asset('public/css/vendor/jquery.easing/jquery.easing.js') }}"></script>
  <script src="{{ URL::asset('public/css/vendor/jquery_appear/jquery.appear.js') }}"></script>
  <script src="{{ URL::asset('public/css/vendor/jquery.placeholder.js') }}"></script>
  <script src="{{ URL::asset('public/css/vendor/fastclick/lib/fastclick.js') }}"></script>
  <script src="{{ URL::asset('public/css/vendor/blockUI/jquery.blockUI.js') }}"></script>
  
  
  
 
  
<script src="{{ URL::asset('public/js/http _momentjs.com_downloads_moment-with-locales.min.js') }}"></script>
  <script src="{{ URL::asset('public/bootstrap-datepicker/js/bootstrap-material-datetimepicker.js') }}"></script>
  <script src="{{ URL::asset('public/css/vendor/fuelux/pillbox.js') }}"></script>
  <script src="{{ URL::asset('public/css/vendor/chosen_v1.4.0/chosen.jquery.min.js') }}"></script>
  <script src="{{ URL::asset('public/css/vendor/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
   <script src="{{ URL::asset('public/js/toastr.min.js') }}"></script>


 

  
  <script src="{{ URL::asset('public/css/vendor/parsleyjs/dist/parsley.min.js') }}"></script>
 
  
  <script src="{{ URL::asset('public/css/vendor/parsleyjs/dist/parsley.min.js') }}"></script>
  <script src="{{ URL::asset('public/js/ideal-postcodes-2.2.0.min.js') }}"></script>
  <script src="{{ URL::asset('public/css/vendor/datatables/media/js/jquery.dataTables.js') }}"></script>
  <script src="{{ URL::asset('public/css/vendor/chosen_v1.4.0/chosen.jquery.min.js') }}"></script>
  
 <script src="{{ URL::asset('public/js/button/jquery.dataTables.min.js') }}"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>


<script src="{{ URL::asset('public/js/button/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('public/js/button/buttons.flash.min.js') }}"></script>
<script src="{{ URL::asset('public/js/button/jszip.min.js') }}"></script>
<script src="{{ URL::asset('public/js/button/pdfmake.min.js') }}"></script>
<script src="{{ URL::asset('public/js/button/vfs_fonts.js') }}"></script>
<script src="{{ URL::asset('public/js/button/buttons.html5.min.js') }}"></script>
<script src="{{ URL::asset('public/js/button/buttons.print.min.js') }}"></script>


  <script>
  
				
  	 var ajaxurl = "<?php echo config('custom.ajaxurl')?>";
	 var siteurl = "<?php echo config('custom.siteurl')?>";
	  
	 
  </script>


@yield('scripts')
@yield('script_src')


<script>
$(document).ready(function($) {
      $("input[name='enable']").click(function(){
               if ($(this).is(':checked')) {               
                    $('input.textbox:text').css('background','#eee');
                   var clint_line1 = $('#clint_line1').val();
                   var client_line2 = $('#client_line2').val();
                   var client_town = $('#client_town').val();
                   var client_postcode = $('#client_postcode').val();
                   var client_country = $('#client_country').val();
                   var email = $('#email').val();
                   var name = $('#name').val();
                     $('#billing_street_1').val(clint_line1);
                    $('#billing_street_2').val(client_line2);
                    $('#billing_town').val(client_town);
                    $('#billing_postcode').val(client_postcode);
                    $('#billing_country').val(client_country);
                    $('#billing_name').val(name);
                    $('#billing_email').val(email);
                   


                 }               
               else if ($(this).not(':checked')) {                     
                    
                             $('input.textbox:text').css('background','#fff'); 
                            $('#billing_street_1').val(clint_line1);
                            $('#billing_street_2').val('');
                            $('#billing_town').val('');
                            $('#billing_postcode').val('');
                            $('#billing_country').val('');
                            $('#billing_name').val('');
                            $('#billing_email').val('');                          
                           }           
 }); 
 
 jQuery('#date_event').bootstrapMaterialDatePicker({
      time: false ,
			minDate : new Date(),
      format : 'YYYY-MM-DD',   
      clearButton: true,
      switchOnClick : true    
        });

 jQuery('#event_date_ifram').bootstrapMaterialDatePicker({
      time: false ,
      minDate : new Date(),
      format : 'YYYY-MM-DD',   
      clearButton: true,
      switchOnClick : true    
        });

 jQuery('#Schudel_date').bootstrapMaterialDatePicker({
      time: false ,
      minDate : new Date(),
      format : 'YYYY-MM-DD',
      clearButton: true,
      switchOnClick : true    
        });
jQuery('#send_date').bootstrapMaterialDatePicker({
      time: false ,
      minDate : new Date(),
      format : 'YYYY-MM-DD',
      clearButton: true,
      switchOnClick : true    
        });
jQuery('#booking_date').bootstrapMaterialDatePicker({
      time: false ,
      minDate : new Date(),
      format : 'YYYY-MM-DD',
      clearButton: true,
      switchOnClick : true    
        });
jQuery('#bookingdate_event').bootstrapMaterialDatePicker({
      time: false ,
      minDate : new Date(),
      format : 'YYYY-MM-DD',
      clearButton: true,
      switchOnClick : true    
        });

 jQuery('#booking_arrival').bootstrapMaterialDatePicker({
            date: false,
            format: 'HH:mm',
        clearButton: true,
        switchOnClick : true
        });

 jQuery('#booking_start').bootstrapMaterialDatePicker({
        date: false,
        format: 'HH:mm',
        clearButton: true,
        switchOnClick : true
        });
 jQuery('#booking_finish').bootstrapMaterialDatePicker({
            date: false,
            format: 'HH:mm',
        clearButton: true,
        switchOnClick : true
        });

  jQuery('#start-time').bootstrapMaterialDatePicker({
    date: false,
    format: 'HH:00',
		clearButton: true,
    switchOnClick : true
  }).on('changeTime', function() {
    alert($(this).val());
  });
		
		 jQuery('#finish-time').bootstrapMaterialDatePicker({
            date: false,
            format: 'HH:00',
  			clearButton: true,
        switchOnClick : true
        });
		jQuery('#arival-time').bootstrapMaterialDatePicker({
           
            date: false,
            format: 'HH:00',
            clearButton: true,
             switchOnClick : true
        });
    
		
	 
		
		jQuery('#arrivaltime').bootstrapMaterialDatePicker({
            date: false,
            format: 'HH:00',
			     clearButton: true,
           switchOnClick : true
        });
		jQuery('#actstarttime').bootstrapMaterialDatePicker({
            date: false,
            format: 'HH:00',
			     clearButton: true,
           switchOnClick : true
        });

		jQuery('#finishtime').bootstrapMaterialDatePicker({
					date: false,
					format: 'HH:00',
					clearButton: true,
          switchOnClick : true
				}); 
				
				

});

$(document).ready(function () {
    $('.top_setting').on('change', function () {
    
        $('.sidebar_setting').addClass('open');
    });

    
});

$(function() {

  $('#invoice_required').change(function(){
  if($(this).prop("checked")) {
    $('#inv').hide();
    } else {
    $('#inv').show(); 
    }
});
  
});
</script>
  
    
   
    


<meta charset="utf-8">
                









    