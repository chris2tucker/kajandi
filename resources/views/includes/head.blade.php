<link rel="icon" href="{{url('/img/logo-2.png')}}" sizes="16x16">  
  <link rel="stylesheet" href="{{ URL::asset('public/css/vendor/bootstrap/dist/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{URL::asset('css/styles.css') }}">
  <link rel="stylesheet" href="{{URL::asset('public/css/dataTables.bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('public/css/styles/font-awesome.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('public/css/styles/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('public/css/styles/animate.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('public/css/styles/sublime.skins.css') }}" id="skin">
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
   <script src="{{ URL::asset('public/js/JSON-to-Table.min.1.0.0.js') }}"></script>


 

  
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

    
    $('.panel-collapse').on('show.bs.collapse', function () {
  $(this).parent('.panel').find('.fa-minus').show();
  $(this).parent('.panel').find('.fa-plus').hide();
});
$('.panel-collapse').on('hide.bs.collapse', function () {
  $(this).parent('.panel').find('.fa-minus').hide();
  $(this).parent('.panel').find('.fa-plus').show();
});

 }); 
 

</script>
  
    
   
    


<meta charset="utf-8">
                









    