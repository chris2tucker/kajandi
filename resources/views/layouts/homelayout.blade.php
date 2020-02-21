<!DOCTYPE HTML>
<html>

<head>
    <title>Kajandi</title>
   <link rel="icon" href="{{url('/img/logo-2.png')}}" sizes="16x16">
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="utf-8" http-equiv="encoding">
    <meta name="keywords" content="Template, html, premium, themeforest" />
    <meta name="description" content="TheBox - premium e-commerce template">
    <meta name="author" content="Tsoy">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href='http://fonts.googleapis.com/css?family=Roboto:500,300,700,400italic,400' rel='stylesheet' type='text/css'>
    <!-- <link href='https://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'> -->
    <!-- <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'> -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{URL::asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{URL::asset('css/selectize.bootstrap3.css') }}">
    <link rel="stylesheet" href="{{URL::asset('css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{URL::asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{URL::asset('css/mystyles.css') }}">
     <script src="{{URL::asset('js/jquery.js') }}"></script>
<script type="text/javascript">
    var ajaxurl = "<?php echo config('custom.ajaxurl')?>";
     var img_path = "<?php echo config('custom.img')?>";
</script>
<style type="text/css">
    #nav-account-dialog {
            max-width: 50%;
        }
        .validation_error{
            color: red;
            margin-top: 5px;
        }
</style>
</head>

<body>
    <div class="global-wrapper clearfix" id="global-wrapper">
        <div class="navbar-before mobile-hidden">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <p class="navbar-before-sign">Eprocurement! Inspired by Technology</p>
                    </div>
                    <div class="col-md-6">
                        <ul class="nav navbar-nav navbar-right navbar-right-no-mar">
                            @guest <li><a href="{{url('vendor/login')}}">Vendor Login</a>
                                @else
                                <li><a href="{{url('create/rfq')}}">Request for Quotations</a>
                                    @endguest
                            <li><a href="{{url('general/terms/view/4')}}">About Us</a>
                            </li>
                           
                            <li><a href="{{url('page/contact_us')}}">Contact Us</a>
                            </li>
                            <li><a href="{{url('general/terms/view/15')}}">FAQ</a>
                            </li>
                            <li><a href="{{url('wishlist')}}">Wishlist</a>
                            </li>
                            <li><a href="{{url('page/contact_us')}}">Help</a>
                            </li>
                            <li><a href="{{url('customer/vendors/list')}}" title="">vendors</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="mfp-with-anim mfp-hide mfp-dialog clearfix" id="nav-login-dialog">
            <h3 class="widget-title">Member Login</h3>
            <p>Welcome back. Login to get started</p>
            <hr />
                <p class="alert alert-danger loginformerror" style="display: none;">Email or Password incorrect</p>
                <form  accept-charset="utf-8" onsubmit="return false">
                    
                   
               
                <div class="form-group">
                    <label>Email or Username</label>
                    <input class="form-control loginemail" type="text" />
                    <p class="alert alert-danger emailerror" style="display: none;">
                        Email field is empty
                    </p>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input class="form-control loginpassword" type="password" />
                    <p class="alert alert-danger passworderror" style="display: none;">
                        Password field is empty
                    </p>
                </div>
                <div class="checkbox">
                    <label>
                        <input class="i-check" type="checkbox" />Remember Me</label>
                </div>
                <input class="btn btn-primary login" type="submit" value="Sign In" />
             </form>
            <div class="gap gap-small"></div>
            <ul class="list-inline">
                <li><a href="#nav-account-dialog" class="popup-text">Not Member Yet</a>
                </li>
                <li><a href="#nav-pwd-dialog" class="popup-text">Forgot Password?</a>
                </li>
            </ul>
        </div>
        <script >
                $(document).ready(function(){
                    $('.login').click(function() {
    loginemail = $('.loginemail').val();
    loginpassword = $('.loginpassword').val();
    if (loginemail.length < 1) {
        $('.emailerror').show();
        $('.passworderror').hide();
    }else if(loginpassword.length < 1){
        $('.emailerror').hide();
        $('.passworderror').show();
    }else{
        url = ajaxurl+'loginuser'
        $.get(
            url,
      {loginemail: loginemail,
        loginpassword: loginpassword},
      function(data) {
        if ($.trim(data)== 'true') {
            window.location='/';
        }else{
        $('.passworderror').hide();
        $('.emailerror').hide();
            $('.loginformerror').show();
        }
      });
    }
})
                })
            </script>
        <div class="mfp-with-anim mfp-hide mfp-dialog clearfix" id="nav-account-dialog">
            <h3 class="widget-title">Create Customer User</h3>
            <p>Ready to get best offers? Let's get started!</p>
            <hr />
            <div class="row">

            
                    <!--    <div class="col-md-4">
                      
                            <div class="form-group">
                                <label>Company name</label>
                                <input type="text" class="form-control company_name" name="company_name" value="{{ old('company_name') }}" autofocus>
                                <p class="validation_error company_nameerror" style="display: none;">
                                    Company Name field is empty
                                </p>

                            </div>
                            <div class="form-group">
                                <label>About Company</label>
                                <input class="form-control about_company" type="text" name="about_company" value="{{ old('about_company') }}" />
                                <p class="validation_error about_companyerror" style="display: none;">
                                    Company About field is empty
                                </p>

                            </div>
                            <div class="form-group">
                                <label>Company Description</label>
                                <textarea class="form-control" name="company_description" value="{{ old('company_description') }}" ></textarea>

                            </div>
                            <div class="form-group">
                                <label>Website-URL</label>
                                <input class="form-control website_url" type="text" name="website_url" value="{{ old('website_url') }}" />
                                <p class="validation_error website_urlerror" style="display: none;">
                                    Website Url field is empty
                                </p>
                            </div>
                            <div class="form-group">
                                <label>CAC Number</label>
                                <input class="form-control cac_number" type="text" name="cac_number" value="{{ old('cac_number') }}" />
                                <p class="validation_error cac_numbererror" style="display: none;">
                                    CAC Number field is empty
                                </p>
                            </div>
                            <div class="form-group">
                                <label>Type of Business</label>
                                <input class="form-control type_of_business" type="text" name="type_of_business" value="{{ old('type_of_business') }}" />
                                <p class="validation_error type_of_businesserror" style="display: none;">
                                    Type Of Busisness field is empty
                                </p>
                            </div>
                            <div class="checkbox">
                            <label>
                                <input class="i-check" type="checkbox" />Subscribe to the Newsletter</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                            <div class="form-group">
                                <label>Years of Existence</label>
                                <input class="form-control year_of_existence" type="text" name="year_of_existence" value="{{ old('year_of_existence') }}" />
                                <p class="validation_error year_of_existenceerror" style="display: none;">
                                    Year Of Existence field is empty
                                </p>
                            </div>
                            <div class="form-group">
                                <label>Phone of MD/Chairman</label>
                                <input class="form-control phone_of_MD_Chairman" type="text" name="phone_of_MD_Chairman" value="{{ old('phone_of_MD_Chairman') }}" />
                                <p class="validation_error phone_of_MD_Chairmanerror" style="display: none;">
                                    Phone of MD/Chairman field is empty
                                </p>
                            </div>
                            <div class="form-group">
                                <label>Email of MD/Chairman</label>
                                <input class="form-control email_of_MD_Chairman" type="text" name="email_of_MD_Chairman" value="{{ old('email_of_MD_Chairman') }}" />
                                <p class="validation_error email_of_MD_Chairmanerror" style="display: none;">
                                    Email of MD/Chairman field is empty
                                </p>
                            </div>
                            <div class="form-group">
                                <label>Phone of Contact Person</label>
                                <input class="form-control phone_of_contact_person" type="text" name="phone_of_contact_person" value="{{ old('phone_of_contact_person') }}" />
                                <p class="validation_error phone_of_contact_personerror" style="display: none;">
                                    Phone of Contact Person field is empty
                                </p>
                            </div>
                            <div class="form-group">
                                <label>Email of Contact Person</label>
                                <input class="form-control email_of_contact_person" type="text" name="email_of_contact_person" value="{{ old('email_of_contact_person') }}" />
                                <p class="validation_error email_of_contact_personerror" style="display: none;">
                                    Email of Contact Person field is empty
                                </p>
                            </div>
                            <div class="form-group">
                                <label>Company Rating</label>
                                <input class="form-control" type="text" name="company_rating" value="{{ old('company_rating') }}" />
                            </div>
                        </div>-->

                        @if ($errors->any())
                    @foreach ($errors->all() as $error)
                      <div class="alert alert-danger">
                        <li>{{ $error }}</li>
                      </div>
                    @endforeach
                  @endif
                    <form action="{{url('signup')}}" method="POST" >
                        {{csrf_field()}}
                        <div class="col-sm-12">
                        <div class="form-group">
                            <label>Name</label>
                            <input class="form-control name" name="name" type="text" />
                            <p class="validation_error nameerror" style="display: none;">
                                Name field is empty
                            </p>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input class="form-control email" name="email" type="text" />
                            <p class="validation_error emailerror1" style="display: none;">
                                Email field is empty
                            </p>
                            <p class="validation_error emailerror2" style="display: none;">
                                incorrect email field
                            </p>
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input class="form-control phonenumber" name="phone" type="number" pattern="^(?:\(\d{3}\)|\d{3})[- . ]?\d{3}[- . ]?\d{4}$" />
                            <p class="validation_error phoneerror" style="display: none;">
                                Phone field is empty
                            </p>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input class="form-control password" name="password" type="password" />
                            <p class="validation_error passworderror" style="display: none;">
                                Password field is empty
                            </p>
                        </div>
                        <div class="form-group">
                            <label>Repeat Password</label>
                            <input class="form-control repeatpassword" name="password_confirmation" type="password" />
                            <p class="validation_error repeatpassworderror" style="display: none;">
                                Repeat Password field is empty
                            </p>
                        </div>
                            <p class="validation_error passwordcorrespond" style="display: none;">
                                Password fields must correspond
                            </p>
                            
                         <div class="form-group">
                            <input type="checkbox" id="termsCheckBox" name="box">By creating an account, you agree to Kajandi's <a href="{{url('customer/terms/conditions')}}" title="" target="_blank"> Conditions of Use and Privacy Notice</a>.
                            
                        </div>
                        
                    </div>
                    <input class="btn btn-primary " id="submitButton" type="submit" value="Create Account" disabled />
                    </form>
                    <script >
                        $(document).ready(function(){
                            $('#termsCheckBox').change(function () {
    if ($(this).prop("checked")) {
        $('#submitButton').attr('disabled',false);
        
    }
    else{
         $('#submitButton').attr('disabled',true);
    }
    // not checked
});                     var auth='{{Auth::check()}}';
                        if(auth!=1){
                var check='{{$errors->any()}}';
                 if (check !='')
                    {
                 $.magnificPopup.open({
  items: {
    src: '#nav-account-dialog'
  },
  type: 'inline'
});
                    }
                }
                        })
                    </script>
                    </div>
                
            <div class="gap gap-small"></div>
            <ul class="list-inline">
                <li><a href="#nav-login-dialog" class="popup-text">Already Member</a>
                </li>
            </ul>
        </div>
 
          <div class="mfp-with-anim mfp-hide mfp-dialog clearfix" id="password_model">
            <h3 class="widget-title">Password Recovery</h3>
            <p>Enter your new password</p>
            <p class="alert alert-danger" style="display: none" id="error">Your email is not present in system</p>
              <p class="alert alert-success" style="display: none" id="success">Email is sent please check inbox</p>
            <hr />
            <form>
                <div class="form-group">
                    <label>New Password</label>
                    <input class="form-control" type="password" id="password" />
                </div>
                <input class="btn btn-primary pass" type="button" value="Recover Password" />
            </form>
        </div>
        <div class="mfp-with-anim mfp-hide mfp-dialog clearfix" id="nav-pwd-dialog">
            <h3 class="widget-title">Password Recovery</h3>
            <p>Enter Your Email and We Will Send the Instructions</p>
            <p class="alert alert-danger" style="display: none" id="error">Your email is not present in system</p>
              <p class="alert alert-success" style="display: none" id="success">Email is sent please check inbox</p>
            <hr />
            <form>
                <div class="form-group">
                    <label>Your Email</label>
                    <input class="form-control" type="text" id="recover" />
                </div>
                <input class="btn btn-primary recover-button" type="button" value="Recover Password" />
            </form>
            <script>
                 $(document).ready(function(){
                   $(".recover-button").click(function(){
                     var mail=$("input[id='recover']").val();
                    $.ajax({
      url:'{{url('recover/password')}}',
      method:'GET',
      data:{email:mail},
     
      success:function(data){
        console.log(data);
      if(data==1){
        $("#success").show();
        $("#error").hide();
      }
      else{
        $("#error").show();
        $("#success").hide();
      }
       
       
      }
    })
                   })
                 });



            </script>
        </div>
        <a href="#password_model" class="popup-text" id="abcc" style="display: hidden;"></a>
        @if(Session::has('userid'))
        <script>
            $(document).ready(function(){
                $("#abcc").trigger('click');
            })
        </script>
        @endif
        <script>
                 $(document).ready(function(){
                   $(".pass").click(function(){
                     var mail=$("input[id='password']").val();
                     var id='{{Session::get('userid')}}';
                    $.ajax({
      url:'{{url('reset/password/newpassword')}}',
      method:'GET',
      data:{password:mail,id:id},
     
      success:function(data){
        console.log(data);
       location.reload();
       
      }
    })
                   })
                 });



            </script>
        <nav class="navbar navbar-inverse navbar-main navbar-pad">
            <div class="container">
                <div class="navbar-header">
                    <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#main-nav-collapse" area_expanded="false"><span class="sr-only">Main Menu</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{url('/')}}" style="padding-top: 5px;padding-bottom: 0" >
                        <img src="{{url('img/logo-2.png')}}" alt="" style="    height: 37px;
    width: 37px;
    padding-left: 10px;">
                        Kajandi
                    </a>
                </div>
                <div class="rel">
                    <form class="navbar-form navbar-left navbar-main-search navbar-main-search-category" role="search" id="search_box">
                        @php 
                        $vendorid = Session::get('vender_id');
                        @endphp
                        <select class="navbar-main-search-category-select" name="depart" class="depart" id="department">
                            <option value="AllDepartmens" @if($vendorid=='AllDepartmens') selected="selected" @endif>All Departments</option>
                            <option value="allproudts" @if($vendorid=='allproudts') selected="selected" @endif>Products</option>
                            <option value="oem" @if($vendorid=='oem') selected="selected" @endif>Manufacturers</option>
                            <option value="distributor" @if($vendorid=='distributor') selected="selected" @endif>Distributors</option>
                            <option value="retailer" @if($vendorid=='retailer') selected="selected" @endif>Retailers</option>
                            
                        </select>
                        <div class="form-group">
                            <input class="form-control searchbox" id="searchbox" type="text" placeholder="Search the Entire Store..." />
                            <input type="hidden" name="qq" id="qq" >
                        </div>
                        <a class="fa fa-search navbar-main-search-submit" href="#" id="btn" style="z-index: 4"></a>
                    </form>
                    <a class="navbar-theme-img" href="{{url('mycart')}}">
                        <img src="img/ecommerce_banner.png" alt="Image Alternative text" style="width: 80px" title="Image Title" />
                    </a>
                </div>
            </div>
        </nav>
        <nav class="navbar-inverse navbar-main yamm">
            <div class="container" style="width: 90%;">
                <div class="collapse navbar-collapse navbar-collapse-no-pad" id="main-nav-collapse">
                    <ul class="nav navbar-nav navbar-nav-lg">
                        
                       @foreach($catagory as $key)
                        <li class="dropdown yamm-fw"><a href="{{url('/category/'.$key->cat_slog)}}"><span >{{$key->catagory_abbreviation}}</span>{{$key->cat_name}}<i class="drop-caret" data-toggle="dropdown"></i></a>
                            <ul class="dropdown-menu">
                                <li class="yamm-content">
                                    <div class="row row-eq-height row-col-border">
                                             @php
                                                     $subCategories = isset($sub_cat[$key->id]) ? $sub_cat[$key->id] : collect();
                                                    $subCategoriesChunks = $subCategories->chunk(ceil($subCategories->count()/4));
                                                     @endphp
                                        @foreach($subCategoriesChunks as $subCategoriesChunk)
                                                <div class="col-md-3">
                                                @foreach($subCategoriesChunk as $k)

                                           
                                            <ul class="dropdown-menu-items-list">
                                                <li><a href="{{url('subcategory/'.$k->sub_slog)}}">{{$k->Sub_name}}</a>
                                                   <!-- <p class="dropdown-menu-items-list-desc">Est urna arcu</p>-->
                                                </li>


                                            </ul>
                                            

                                            @endforeach
                                                </div>

                                            @endforeach
                                    </div>
                                    
                                </li>
                            </ul>
                        </li>
                        @endforeach
                    </ul>
                    <ul class="nav navbar-nav navbar-right navbar-right-no-mar navbar-nav-lg">
                        <?php
                        if (Auth::check()) {
                            $name = str_limit(Auth::user()->name, 10);
                            ?>
                             <li class="dropdown" style="height: 50px !important"><a href="#"><span ></span><i class="fa fa-bell" aria-hidden="true"><span class="counts"></span></i></a>
                            <ul class="dropdown-menu dropdown-menu-shipping-cart mess">
                               
                                
                            
                                
                            </ul>
                        </li>
                        <script>
          $(document).ready(function(){
            setInterval(function() {
             
              var id='{{Auth::user()->id}}';
    $.ajax({
      url:'{{url('unread/messages/customer')}}',
      method:'GET',
      data:{user:id},
     
      success:function(data){
        console.log(data);
        $('.messages').remove();
        $('.mess').append(data.table_data);
        $('.counts').text(data.counts);
       
      }
    })
}, 30 * 1000);
          })
        </script>
                        <li class="dropdown"><a href="" ><span >Hello,</span>{{$name}}</a>
                            <ul class="dropdown-menu dropdown-menu-shipping-cart" style="z-index: 9999">
                                <li>
                                    <a href="{{url('/customers/dashboard')}}">
                                        <span class="text-left" style="padding-right: 4px"><i class="fa fa-tachometer" aria-hidden="true"></i></span>
                                       Dashoard 
                                    </a>
                                    
                                </li>
                                <li>
                                    <a href="{{url('/mycart')}}">
                                        <span class="text-left" style="padding-right: 4px"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i></span>
                                    Shopping Cart
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('/customers/orders')}}">
                                        <span class="text-left" style="padding-right: 4px"><i class="fa fa-file-text-o" aria-hidden="true"></i></span>
                                    Orders
                                    </a>
                                </li>
                                 <li>
                                    <a href="{{url('/customers/addsupplier')}}">
                                        <span class="text-left" style="padding-right: 4px"><i class="fa fa-product-hunt" aria-hidden="true"></i></i></span>
                                    My Vendor Products
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('/signout')}}">
                                        <span class="text-left" style="padding-right: 4px"><i class="fa fa-power-off" aria-hidden="true"></i></span>
                                      Signout  
                                    </a>
                                    
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown"><a href="{{url('/mycart')}}"><span ></span><i class="fa fa-shopping-cart"></i></a>
                            <?php echo $cart; ?>
                            
                        </li>
                            <?php
                        }else{
                        ?>
                        <li><a href="#nav-login-dialog" data-effect="mfp-move-from-top" class="popup-text"><span >Hello, Sign in</span>Your Account</a>
                        </li>
                        
                        <li class="dropdown"><a href="{{url('mycart')}}"><span ></span><i class="fa fa-shopping-cart"></i></a>
                            <?php echo $cart; ?>
                        </li>
                        <?php
                        }
                        ?>
                        <li class="dropdown" style="margin-top: 30px">
                            <form action="homelayout_submit" method="get" accept-charset="utf-8">
                            {{csrf_field()}}
                            <select id="currency">
                                @if(Session::has('currency'))
                                @if(Session::get('currency')=='Naira')
                              <option value="Naira" selected>Naira</option>
                              
                              <option value="Dollar" >Dollar</option>
                              <option value="Euro" >Euro</option>
                              <option value="Yen" >Yen</option>
                              @elseif(Session::get('currency')=='Dollar')
                              <option value="Dollar"selected>Dollar</option>
                              <option value="Naira" >Naira</option>
                             
                              <option value="Euro" >Euro</option>
                              <option value="Yen" >Yen</option>
                              @elseif(Session::get('currency')=='Euro')
                              <option value="Euro"selected>Euro</option>
                              <option value="Naira" >Naira</option>
                              <option value="Dollar" >Dollar</option>
                             
                              <option value="Yen" >Yen</option>
                              @elseif(Session::get('currency')=='Yen')
                              <option value="Yen" selected>Yen</option>
                              <option value="Naira" >Naira</option>
                              <option value="Dollar" >Dollar</option>
                              <option value="Euro" >Euro</option>
                             
                              @endif
                              @else
                              <option value="Naira" selected>Naira</option>
                              <option value="Dollar" >Dollar</option>
                              <option value="Euro" >Euro</option>
                              <option value="Yen" >Yen</option>
                              @endif
                            </select>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <script >
            $(document).ready(function(){
                $("#currency").change(function(){
                var curr=$(this).val();
                $.ajax({
                     url:"{{ url('currency') }}",
                     method:'GET',
                     data:{currency:curr},
                     dataType:'json',
                     success:function(data)
                     {console.log(data);
                        if(data=='yes'){
                            location.reload();
                        }
                     }
                })
            })
            });
        </script>
        @guest
        @else
@if(Auth::user()->verify==0)
<div class="alert alert-danger" style="text-align: center;margin-left: 20%;margin-right: 20%;padding: 10px;">
                        Please verify your email account! We already sent you an email
                      </div>
@endif
@if(Auth::user()->user_type=='Customer')
@php
$user=App\Customer::where('user_id','=',Auth::user()->id)->first();
@endphp
@if($user->name==NULL ||$user->company_name==NULL || $user->about==NULL || $user->mdtel==NULL || $user->mdemail==NULL  || $user->contactpersontel==NULL || $user->contactpersonemail==NULL ||$user->billing_city==NULL ||$user->billing_state==NULL || $user->billing_address==NULL)
<div class="alert alert-danger" style="text-align: center;margin-left: 20%;margin-right: 20%;padding: 10px;">
                       <a href="{{url('customers/profile')}}" style="text-decoration: none;color: #a94442;"> Please Complete your Profile information in your Dashboard</a>
                      </div>
@endif

@endif
@endguest
@if(Session::has('message'))
<div class="alert alert-success" style="text-align: center;margin-left: 20%;margin-right: 20%;padding: 10px;">
                        {{Session::get('message')}}
                      </div>
@endif
@guest
@else
@php
$dueamounts=App\outstandingpayment::where('user_id','=',Auth::user()->id)->where('duedate','<',carbon\Carbon::today())->sum('totalprice');
@endphp
@if($dueamounts>0)
{{--<div class="alert alert-danger" style="text-align: center;margin-left: 20%;margin-right: 20%;padding: 10px;">--}}
{{--</div>--}}
@endif
@endguest
        @yield('content')

        <footer class="main-footer">
            <div class="container">
                <div class="row row-col-gap" data-gutter="60">
                    <div class="col-md-3">
                        <h4 class="widget-title-sm">TheBox Shop</h4>
                        <p>Nullam magnis magnis maecenas neque ut purus condimentum semper senectus feugiat et</p>
                         <ul class="main-footer-social-list">
                             @php 
                                    $social_links = Session::get('social_link');
                            @endphp
                            <li>
                                <a class="fa fa-facebook" @if($social_links) href="{{$social_links->facebook}}" @else href="#"  @endif></a>
                            </li>

                            <li>
                                <a class="fa fa-twitter" @if($social_links) href="{{$social_links->twitter}}" @else href="#"  @endif></a>
                            </li>
                            <li>
                                <a class="fa fa-pinterest" @if($social_links) href="{{$social_links->pinterest}}" @else href="#"  @endif></a>
                            </li>
                            <li>
                                <a class="fa fa-instagram"  @if($social_links) href="{{$social_links->instagram}}" @else href="#"  @endif></a>
                            </li>
                            <li>
                                <a class="fa fa-google-plus"  @if($social_links) href="{{$social_links->google}}" @else href="#"  @endif></a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h4 class="widget-title-sm">Popular Tags</h4>
                        <ul class="main-footer-tag-list">
                            @php
                            $tags=App\populartags::inRandomOrder()->paginate(12);
                            @endphp
                            @foreach($tags as $tag)
                           <li><a href="{{url('searchitems/'.$tag->tag)}}">{{$tag->tag}}</a>
                            </li>
                            @endforeach
                            
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h4 class="widget-title-sm">Newsletter</h4>
                        <form method="POST" action="{{url('newsletter')}}">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label>Sign up to the newsletter</label>
                                <input class="newsletter-input form-control" placeholder="Your e-mail address" name="email" type="text" required />
                            </div>
                            <input class="btn btn-primary" type="submit" value="Sign up" />
                        </form>
                    </div>
                    <div class="col-md-3">
                        <h4 class="widget-title-sm">Contact us</h4>
                        <form method="POST" action="{{url('contact_us')}}">
                            {{csrf_field()}}
                            <div class="form-group">
                            
                                <input class="newsletter-input form-control" placeholder="Your Name" name="name" required type="text" />
                            </div>
                            <div class="form-group">
                            
                                <input class="newsletter-input form-control" placeholder="Your e-mail address" name="email" required type="text" />
                            </div>
                            <div class="form-group">
                            
                                <textarea class="newsletter-input form-control" placeholder="Your message" name="message" required /></textarea>
                            </div>
                            <input class="btn btn-primary pull-right" type="submit" value="Send" />
                        </form>
                    </div>
                </div>
                <ul class="main-footer-links-list">
                    <li><a href="{{url('general/terms/view/4')}}">About Us</a>
                    </li>
                    <li><a href="{{url('general/terms/view/11')}}">Jobs</a>
                    </li>
                    <li><a href="{{url('general/terms/view/8')}}">Guidline</a>
                    </li>
                    <li><a href="{{url('page/contact_us')}}">Contact us</a>
                    </li>
                    
                    <li><a href="{{url('general/terms/view/7')}}">Privacy</a>
                    </li>
                    <li><a href="{{url('general/terms/view/3')}}">Terms</a>
                    </li>
                    <li><a href="{{url('general/terms/view/6')}}">Shipping</a>
                    </li>
                    <li><a href="{{url('general/terms/view/5')}}">Payments & Refunds</a>
                    </li>
                </ul>
            </div>
        </footer>
        <div class="copyright-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <p class="copyright-text">Copyright @kajandi2019. Designed by kajandi limited, all right reserved</p>
                    </div>
                    <div class="col-md-6">
                        <ul class="payment-icons-list">
                            <li>
                                <img src="img/payment/visa-straight-32px.png" title="Pay with Visa" />
                            </li>
                            <li>
                                <img src="img/payment/mastercard-straight-32px.png" title="Pay with Mastercard" />
                            </li>
                            <li>
                                <img src="img/payment/paypal-straight-32px.png"  title="Pay with Paypal" />
                            </li>
                            <li>
                                <img src="img/payment/visa-electron-straight-32px.png"  title="Pay with Visa-electron" />
                            </li>
                            <li>
                                <img src="img/payment/maestro-straight-32px.png"  title="Pay with Maestro" />
                            </li>
                            <li>
                                <img src="img/payment/discover-straight-32px.png" title="Pay with Discover" />
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{URL::asset('js/jquery.js') }}"></script>
    <script src="{{URL::asset('js/bootstrap.js') }}"></script>
    <script src="{{URL::asset('js/selectize.js') }}"></script>
    <script src="{{URL::asset('js/icheck.js') }}"></script>
    <script src="{{URL::asset('js/ionrangeslider.js') }}"></script>
    <script src="{{URL::asset('js/jqzoom.js') }}"></script>
    <script src="{{URL::asset('js/card-payment.js') }}"></script>
    <script src="{{URL::asset('js/owl-carousel.js') }}"></script>
    <script src="{{URL::asset('js/magnific.js') }}"></script>
    <script src="{{URL::asset('js/custom.js') }}"></script>
    <script src="{{URL::asset('js/script.js') }}"></script>





</body>

</html>
