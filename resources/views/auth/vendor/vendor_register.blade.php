
@include('includes.head')

@include('includes.headerlogin')
<script type="text/javascript">
      $(document).ready(function(){
       
        setTimeout(function() {
          $('.error_message').fadeOut('fast');
        }, 5000); // <-- time in milliseconds

        
    });

    </script>

<html>
<head>
    <title>Login - Ecommerce</title>
</head>

<body class="bg-primary">

  <div class="cover" style="background-image: url('public/images/cover3.jpg')"></div>

  <div class="overlay bg-primary"></div>

  <div class="center-wrapper">
    <div class="center-content">
      <div class="row no-m">
        <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
          <section class="panel bg-white no-b">
            <a href="{{url('/')}}" title=""><img src="{{url('img/logo.png')}}" alt="" style="    height: 100px;
    width: 200px;
    margin-left: 100px;"></a>
            <ul class="switcher-dash-action">
              <li style="width: 100%;"><a href="#" class="selected">Register As Vendor</a>
              </li>
             
            </ul>
            <div class="p15">
              @if (Session::has('message'))
                        <div class="alert alert-success success_message">{{ Session::get('message') }}</div>
                        
                 @endif
                @if (Session::has('errormsg'))
                        <div class="alert alert-danger error_message">{{ Session::get('errormsg') }}</div>
                    @endif
                    <form class="form-horizontal" method="POST" action="{{URL::to('vendor/register') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                         <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                            

                            <div class="col-md-12">
                                 <label for="files" class="btn">Select Image <small style="color: red;">(Image must not be above 2mb )</small></label>
                                <input id="image"  type="file" class="form-control" name="image" value="{{ old('image') }}" required autofocus placeholder="Enter Name">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('vendorname') ? ' has-error' : '' }}">
                             

                            <div class="col-md-12">
                                <input id="vendorname" type="text" class="form-control" name="vendorname" value="{{ old('vendorname') }}" required autofocus placeholder="Enter Name">

                                @if ($errors->has('vendorname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('vendorname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            

                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="Enter Email">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            

                            <div class="col-md-12">
                                <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}"  autofocus placeholder="Enter Phone">

                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control" name="password" required placeholder="Enter Password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                         <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            

                            <div class="col-md-12">
                                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required placeholder="Confirm Password">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('vendor_type') ? ' has-error' : '' }}">
                            

                            <div class="col-md-12">
                                <select id="vendor_type" name="vendor_type" class="form-control">
                                            <option value="" disabled selected>Select Vendor Type...</option>
                                            <option value="retailer">Retailer</option>
                                            <option value="distributor">Distributor</option>
                                            <option value="oem">OEM</option>
                                            <option value="none">None</option>
                                          </select>

                                @if ($errors->has('vendor_type'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('vendor_type') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('producttype') ? ' has-error' : '' }}">
                            

                            <div class="col-md-12">
                                 <select id="producttype" name="producttype" class="form-control">
                                            <option value="">Select Product Type...</option>
                                            <option value="Goods">Goods</option>
                                            <option value="Services">Services</option>
                                          </select>

                                @if ($errors->has('producttype'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('producttype') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                            
                            @php
                            $countries=App\country::all();
                            
                            @endphp
                            <div class="col-md-12">
                                 <select id="country" name="country" class="form-control">
                                            <option value="">Select Country...</option>
                                            @foreach($countries as $country)
                                            <option value="{{$country->name}}">{{$country->name}}</option>
                                            @endforeach
                                          </select>

                                @if ($errors->has('city'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                       
                        <div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
                          
                            <div class="col-md-12">
                                 <select id="state" name="state" class="form-control">
                                            <option value="">Select State...</option>
                                           
                                          </select>

                                @if ($errors->has('location'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('location') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
                            
                            @php
                            $countries=App\shippingInformations::groupBy('country')->get();
                            
                            @endphp
                            <div class="col-md-12">
                                 <select id="location" name="location" class="form-control">
                                            <option value="">Select Location...</option>
                                           
                                          </select>

                                @if ($errors->has('location'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('location') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                         <script>
                             $(document).ready(function(){
                                $('select[name="country"]').change(function(){
                                    var value=$(this).val();
                                     $.ajax({
                                   url:"{{ url('vendor/country') }}",
                                   method:'get',
                                   data:{country:value},
                                   dataType:'json',
                                     error: function(xhr, status, error) {
                  console.log(xhr.responseText);
                },
                                   success:function(data){
                                    $('.ops').remove();
                                    $("#state").append(data.data);
                                   }
                               });
                                });
                                $('select[name="state"]').change(function(){
                                    var value=$(this).val();
                                   
                                                $.ajax({
                                   url:"{{ url('vendor/state') }}",
                                   method:'get',
                                   data:{state:value},
                                   dataType:'json',
                                     error: function(xhr, status, error) {
                  console.log(xhr.responseText);
                },
                                   success:function(data){
                                    $('.opss').remove();
                                    $("#location").append(data.data);
                                   }
                               });
                                });
                            })
                        </script>
                        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                            

                            <div class="col-md-12" >
                                <input id="address" type="text" class="form-control" name="address" value="{{ old('address') }}" required autofocus placeholder="Enter address">

                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('website') ? ' has-error' : '' }}">
                            

                            <div class="col-md-12">
                                <input id="website" type="text" class="form-control" name="website" value="{{ old('website') }}"  autofocus placeholder="Enter Website">

                                @if ($errors->has('website'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('website') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('cac') ? ' has-error' : '' }}">
                            

                            <div class="col-md-12">
                                <input id="phone" type="text" class="form-control" name="cac" value="{{ old('cac') }}"  autofocus placeholder="Enter cac">

                                @if ($errors->has('cac'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cac') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('workforce') ? ' has-error' : '' }}">
                            

                            <div class="col-md-12">
                                <input id="workforce" type="text" class="form-control" name="workforce" value="{{ old('workforce') }}"  autofocus placeholder="Enter Workforce">

                                @if ($errors->has('workforce'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('workforce') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('experience') ? ' has-error' : '' }}">
                            

                            <div class="col-md-12">
                                <input id="experience" type="text" class="form-control" name="experience" value="{{ old('experience') }}"  autofocus placeholder="Enter Experience (in years)">

                                @if ($errors->has('experience'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('experience') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                         
                         
                         
                        <div class="form-group{{ $errors->has('rating') ? ' has-error' : '' }}">
                            

                            <div class="col-md-12">
                                 <select id="rating" name="rating" class="form-control">
                                            <option value="">Select Your rating...</option>
                                            <option value="expert">Experts</option>
                                            <option value="professional">Professional</option>
                                            <option value="technicians">Technician</option>}
                                            option
                                          </select>

                                @if ($errors->has('rating'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('rating') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('personname') ? ' has-error' : '' }}">
                            

                            <div class="col-md-12">
                                <input id="personname" type="text" class="form-control" name="personname" value="{{ old('personname') }}" required autofocus placeholder="Enter contact person name">

                                @if ($errors->has('personname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('personname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('personphone') ? ' has-error' : '' }}">
                            

                            <div class="col-md-12">
                                <input id="personphone" type="text" class="form-control" name="personphone" value="{{ old('personphone') }}" required autofocus placeholder="Enter contact person phone number">

                                @if ($errors->has('personphone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('personphone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                         <div class="form-group{{ $errors->has('personemail') ? ' has-error' : '' }}">
                            

                            <div class="col-md-12">
                                <input id="personemail" type="text" class="form-control" name="personemail" value="{{ old('personemail') }}"  autofocus placeholder="Enter Contact person Email">

                                @if ($errors->has('personemail'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('personemail') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('mdname') ? ' has-error' : '' }}">
                            

                            <div class="col-md-12">
                                <input id="mdname" type="text" class="form-control" name="mdname" value="{{ old('mdname') }}"  autofocus placeholder="Enter MD/Chairman Name">

                                @if ($errors->has('mdname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mdname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('mdemail') ? ' has-error' : '' }}">
                            

                            <div class="col-md-12">
                                <input id="mdemail" type="email" class="form-control" name="mdemail" value="{{ old('mdemail') }}"  autofocus placeholder="Enter MD/Chairman email">

                                @if ($errors->has('mdemail'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mdemail') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('mdphone') ? ' has-error' : '' }}">
                            

                            <div class="col-md-12">
                                <input id="mdphone" type="text" class="form-control" name="mdphone" value="{{ old('mdphone') }}"  autofocus placeholder="Enter MD/Chairman phone number">

                                @if ($errors->has('mdphone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mdphone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="checkbox">
                                    <label style="color:black">
                                        <input type="checkbox" name="terms" {{ old('remember') ? 'checked' : '' }}> <p style="margin-left: 15px;">Agree to Kajandi's <a href="{{url('vendor/terms/conditions')}}"  target="_blank">Conditions of Use and Privacy Notice</a>.</p>
                                    </label>
                                </div>

                            </div>
                            <div class="col-md-2"></div>
                            <div class="col-md-4">
                                <a  href="{{url('vendor/login')}}" style="color:black">
                                    Already have account?
                                </a>
                            </div>
                           </div> 
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" id="submit" disabled class="btn btn-primary btn-lg btn-block">
                                    Sign Up
                                </button>

                                
                            </div>
                        </div>
                    </form>
            </div>
          </section>
          <p class="text-center">
            Copyright &copy;
            <span id="year" class="mr5"></span>
            <span>Ecommerce</span>
          </p>
        </div>
      </div>

    </div>
  </div>
  <script type="text/javascript">
    var el = document.getElementById("year"),
      year = (new Date().getFullYear());
    el.innerHTML = year;
  </script>
  <script >
  	$(document).ready(function(){
  		$("input[name='terms']").change(function(){
  			
  			if($(this).prop('checked')==true){
  				$("#submit").prop('disabled',false);
  			}
  			else{
  				$("#submit").prop('disabled',true);
  			}
  		})
  	})
  </script>
</body>
<footer class="main-footer">
            <div class="container" style="height: 350px;">
                <div class="row row-col-gap" data-gutter="60">
                    <div class="col-md-3">
                        <h4 class="widget-title-sm">TheBox Shop</h4>
                        <p>Velit proin tempus accumsan ridiculus taciti tempor consequat aliquam felis lacinia lorem</p>
                        @php 

                            $social_link = Session::get('social_link');
                        @endphp
                        <ul class="main-footer-social-list">
                            <li>
                                <a class="fa fa-facebook" @if(! empty($social_link->facebook)) href="{{$social_link->facebook}}" @else href="#"  @endif></a>
                            </li>
                            <li>
                                <a class="fa fa-twitter"  @if(! empty($social_link->twitter)) href="{{$social_link->twitter}}" @else href="#"  @endif></a>
                            </li>
                            <li>
                                <a class="fa fa-pinterest"  @if(! empty($social_link->pinterest)) href="{{$social_link->pinterest}}" @else href="#"  @endif></a>
                            </li>
                            <li>
                                <a class="fa fa-instagram"  @if(! empty($social_link->instagram)) href="{{$social_link->instagram}}" @else href="#"  @endif></a>
                            </li>
                            <li>
                                <a class="fa fa-google-plus" @if(! empty($social_link->google)) href="{{$social_link->google}}" @else href="#"  @endif></a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h4 class="widget-title-sm">Popular Tags</h4>
                        <ul class="main-footer-tag-list">
                            <li><a href="{{url('searchitems/new')}}">New Season</a>
                            </li>
                            <li><a href="{{url('searchitems/watche')}}">Watches</a>
                            </li>
                            <li><a href="{{url('searchitems/woman')}}">woman</a>
                            </li>
                            <li><a href="{{url('searchitems/classic')}}">classic</a>
                            </li>
                            <li><a href="{{url('searchitems/modern')}}">modern</a>
                            </li>
                            <li><a href="{{url('searchitems/blue')}}">blue</a>
                            </li>
                            <li><a href="{{url('searchitems/shoe')}}">shoes</a>
                            </li>
                            <li><a href="{{url('searchitems/running')}}">running</a>
                            </li>
                            <li><a href="{{url('searchitems/jeans')}}">jeans</a>
                            </li>
                            <li><a href="{{url('searchitems/sports')}}">sports</a>
                            </li>
                            <li><a href="{{url('searchitems/laptop')}}">laptops</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h4 class="widget-title-sm">Newsletter</h4>
                        <form method="POST" action="{{url('newsletter')}}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label>Sign up to the newsletter</label>
                                <input class="newsletter-input form-control" placeholder="Your e-mail address" name="email" required type="text" />
                            </div>
                            <input class="btn btn-primary" type="submit" value="Sign up" />
                        </form>
                    </div>
                    <div class="col-md-3">
                        <h4 class="widget-title-sm">Contact us</h4>
                        <form  method="POST" action="{{url('contact_us')}}">
                            {{ csrf_field() }}
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
                    <li><a href="#">Jobs</a>
                    </li>
                    <li><a href="{{url('general/terms/view/8')}}">Guidline</a>
                    </li>
                    <li><a href="#">Support & Customer Service</a>
                    </li>
                    <li><a href="#">Blog</a>
                    </li>
                    <li><a href="{{url('general/terms/view/7')}}">Privacy</a>
                    </li>
                    <li><a href="{{url('general/terms/view/3')}}">Terms</a>
                    </li>
                    <li><a href="#">Press</a>
                    </li>
                    <li><a href="{{url('general/terms/view/6')}}">Shipping</a>
                    </li>
                    <li><a href="{{url('general/terms/view/5')}}">Payments & Refunds</a>
                    </li>
                </ul>
            </div>
        </footer>
</html>





 