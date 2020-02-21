@extends('layouts.pagelayout')
@section('content')
<?php
if(Auth::user()){
	$user=App\User::find(Auth::user()->id);
	$customer=App\Customer::where('user_id','=',$user->id)->first();
	//dd($customer);
}

  ?>
<div class="container" style="margin-bottom: -30px !important;width: 100%;margin: 0;">
	<br>
	<ol class="breadcrumb page-breadcrumb">
                    <li><a href="{{url('/')}}">Home</a>
                    </li>
                    <li><a href="{{url('customers/profile')}}">Dashboard</a>
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
        <div class="col-lg-12">
          <div class="row" data-gutter="60">
          	<div class="col-md-12">
          		 @if ($errors->any())
                    @foreach ($errors->all() as $error)
                      <div class="alert alert-danger">
                        <li>{{ $error }}</li>
                      </div>
                    @endforeach
                  @endif
                  <input class="btn btn-primary submit" id="submit" style="display: none;" type="submit" value="Save" />
                                    <button class="btn btn-primary pull-left edit" id="edit" type="button">Click to Edit</button>
          	</div>
                           <div class="col-md-6">

                        <form method="POST" action="{{ url('/customers/profile') }}" aria-label="{{ __('Register') }}" id="form">
                             {{ csrf_field() }}
                      
                            <div class="form-group">
                                <label>Company name</label>
                                <input type="text" class="form-control" name="company_name" value="{{ $customer->company_name }}"  readonly autofocus>

                            </div>
                            <div class="form-group">
                                <label>About Company</label>
                                <input class="form-control" type="text" name="about_company" value="{{$customer->about}}" readonly/>
                            </div>
                           <!-- <div class="form-group">
                                <label>Company Description</label>
                                <textarea class="form-control" name="company_description" value="{{ old('company_description') }}" readonly ></textarea>
                            </div>-->
                            <div class="form-group">
                                <label>User Type</label>
                                 <input class="form-control" type="text" name="user_type" value="{{ $customer->user_type }}" readonly/>
                            </div>
                          <!--<div class="form-group">
                                <label>Website-URL</label>
                                <input class="form-control" type="text" name="website_url" value="{{ $customer->website }}" readonly/>
                            </div>-->
                          <!--  <div class="form-group">
                                <label>CAC Number</label>
                                <input class="form-control" type="text" name="cac_number" value="{{ $customer->cac }}" readonly/>
                            </div>-->
                            <div class="form-group">
                                <label>Type of Business</label>
                                <input class="form-control" type="text" name="type_of_business" value="{{ $customer->businesstype }}" readonly/>
                            </div>
                             <div class="form-group">
                                <label>Country</label>
                                 @php
                            $countries=App\country::all();
                            
                            @endphp
                                <select id="country" name="country" class="form-control" disabled>
                                            <option value="">Select Country...</option>
                                            @foreach($countries as $country)
                                            <option value="{{$country->name}}" @if($country->name==$customer->country) selected @endif >{{$country->name}}</option>
                                            @endforeach
                                          </select>
                            </div>
                           
                             <div class="form-group">
                                <label>State</label>
                                   <select id="state" name="state" class="form-control" disabled>
                                    @php
                                    $states=App\state::where('country_name','=',$customer->country)->get();
                                    @endphp
                                            <option value="">Select State...</option>
                                          
                                        
                                          @foreach($states as $st)
                                          <option class="ops" @if($customer->state) @if($customer->state==$st->name) selected @endif @endif value="{{$st->name}}">{{$st->name}}</option>
                                          
                                           @endforeach
                                          </select>
                                
                            </div>
                             <div class="form-group">
                                <label>city</label>
                                <select id="city" name="city" class="form-control" disabled>
                                  @php
                                    $states=App\city::where('state_name','=',$customer->state)->get();
                                    @endphp
                                            <option value="">Select Location...</option>
                                           
                                           @foreach($states as $st)
                                           <option class="opss" @if($customer->city) @if($customer->city==$st->name) selected @endif @endif value="{{$st->name}}">{{$st->name}}</option>
                                           
                                           @endforeach
                                           
                                          
                           
                                </select>
                                
                            </div>
                             <div class="form-group">
                                <label>Address 1</label>
                                <input class="form-control" type="text" name="address" value="{{ $customer->address }}" readonly/>
                            </div>
                             <div class="form-group">
                                <label>Address 2</label>
                                <input class="form-control" type="text" name="address_2" value="{{ $customer->address_2 }}" readonly/>
                            </div>
                             <div class="form-group">
                                <label>Zip</label>
                                <input class="form-control" type="text" name="zip" value="{{ $customer->zip }}" readonly/>
                                <input type="checkbox" name="same_billing" value="Same Billing Address" disabled @if($customer->same_billing)checked @endif>Same Billing Address</input>
                            </div>
                    </div>
                    <div class="col-md-6">
                         <!--   <div class="form-group">
                                <label>Years of Existence</label>
                                <input class="form-control" type="text" name="year_of_existence" value="{{ $customer->yearsofexitence }}" readonly/>
                            </div>-->
                            <div class="form-group">
                                <label>Phone of MD/Chairman</label>
                                <input class="form-control" type="text" name="phone_of_MD_Chairman" value="{{ $customer->mdtel }}" readonly/>
                            </div>
                            <div class="form-group">
                                <label>Email of MD/Chairman</label>
                                <input class="form-control" type="text" name="email_of_MD_Chairman" value="{{ $customer->mdemail }}"readonly />
                            </div>
                            <div class="form-group">
                                <label>Phone of Contact Person</label>
                                <input class="form-control" type="text" name="phone_of_contact_person" value="{{ $customer->contactpersontel }}"readonly />
                            </div>
                            <div class="form-group">
                                <label>Email of Contact Person</label>
                                <input class="form-control" type="text" name="email_of_contact_person" value="{{ $customer->contactpersonemail }}" readonly />
                            </div>
                          <!--  <div class="form-group">
                                <label>Company Rating</label>
                                <input class="form-control" type="text" name="company_rating" value="{{ $customer->company_rating}}" readonly/>
                            </div>-->
                            <div class="form-group">
                               <label>Billing Country</label>
                              <select id="billing_country" name="billing_country" class="form-control" disabled>
                                            <option value="">Select Country...</option>
                                            @foreach($countries as $country)
                                            <option value="{{$country->name}}" @if($country->name==$customer->billing_country) selected @endif >{{$country->name}}</option>
                                            @endforeach
                                          </select>
                            </div>
                           
                             <div class="form-group">
                                <label>Billing State</label>
                                   <select id="billing_state" name="billing_state" class="form-control" disabled>
                                            <option value="">Select State...</option>
                                            @php
                                            $billing_states=App\state::where('country_name',$customer->billing_country)->get();
                                            @endphp
                                         @foreach($billing_states as $bi)
                                          <option class="st"  value="{{$bi->name}}" @if($customer->billing_state) @if($customer->billing_state==$bi->name) selected @endif @endif>{{$bi->name}}</option>
                                          @endforeach
                                           
                                          </select>
                                
                            </div>
                             <div class="form-group">
                                <label>Billing city</label>
                                <select id="billing_city" name="billing_city" class="form-control" disabled>
                                            <option value="">Select Location...</option>
                                           @php
                                            $billing_states=App\city::where('state_name',$customer->billing_state)->get();
                                            @endphp
                                         @foreach($billing_states as $bi)
                                           <option class="cit" selected value="{{$bi->name}}" @if($customer->billing_city) @if($customer->billing_city==$bi->name) selected @endif @endif>{{$bi->name}}</option>
                                           @endforeach
                                          
                           
                                </select>
                                
                            </div>
                             <div class="form-group">
                                <label>Billing Address 1</label>
                                <input class="form-control" type="text" name="billing_address" value="{{ $customer->billing_address }}" readonly/>
                            </div>
                             <div class="form-group">
                                <label>Address 2</label>
                                <input class="form-control" type="text" name="billing_address_2" value="{{ $customer->billing_address_2 }}" readonly/>
                            </div>
                             <div class="form-group">
                                <label>Billing Zip</label>
                                <input class="form-control" type="text" name="billing_zip" value="{{ $customer->billing_zip }}" readonly/>
                            </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" value="{{ $user->name}}" readonly>

                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" value="{{$user->email }}"readonly>

                            </div>
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input type="number" class="form-control" name="phone" value="{{$user->phone }}"readonly>

                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password"readonly>
                            </div>
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" class="form-control" name="password_confirmation"readonly>
                            </div>
                            <!-- <div class="checkbox">
                                <label>
                                    <input class="i-check" type="checkbox" />Sign Up to the Newsletter</label>
                            </div> -->
                         
                                  
                                </form>
                                  <input class="btn btn-primary submit" id="submit" style="display: none;" type="submit" value="Save" />
                                    <button class="btn btn-primary pull-left edit" id="edit" type="button">Click to Edit</button>
                            </div>
                        </div>
        </div>
      </div>
      <br>
      <br>

      <div class="row">
        <div class="col-md-12">
          <div id="chartContainer" style="width: 100% !important"></div>
        </div>  
      </div>
      <div class="gap gap-big"></div>
      <div class="gap gap-big"></div>
      <div class="gap gap-big"></div>
      <div class="gap gap-big"></div>
		</div>
	</div>
</div>
<script >
	$(document).ready(function(){
    $('.submit').click(function(){
      $("#form").submit();
    })
		$(".edit").click(function(){
			$(".edit").hide();
			$(".submit").show();
			$('input[name="company_name"').prop('readonly',false);
			$('input[name="about_company"').prop('readonly',false);
			$('input[name="website_url"').prop('readonly',false);
			$('input[name="cac_number"').prop('readonly',false);
			$('input[name="type_of_business"').prop('readonly',false);
			$('input[name="year_of_existence"').prop('readonly',false);
			$('input[name="email_of_MD_Chairman"').prop('readonly',false);
			$('input[name="phone_of_MD_Chairman"').prop('readonly',false);
			$('input[name="phone_of_contact_person"').prop('readonly',false);
			$('input[name="email_of_contact_person"').prop('readonly',false);
			$('input[name="company_rating"').prop('readonly',false);
      $('input[name="phone"').prop('readonly',false);
      $('input[name="user_type"]').prop('readonly',false);
			$('input[name="name"').prop('readonly',false);
			$('input[name="email"').prop('readonly',false);
			$('input[name="password"').prop('readonly',false);
			$('input[name="password_confirmation"').prop('readonly',false);
      $('select[name="country"]').attr('disabled',false);
       $('select[name="state"]').attr('disabled',false);
        $('select[name="city"]').attr('disabled',false);
         $('input[name="address"]').prop('readonly',false);
          $('input[name="address_2"]').prop('readonly',false);
           $('input[name="zip"]').prop('readonly',false);
            $('select[name="billing_country"]').attr('disabled',false);
       $('select[name="billing_state"]').attr('disabled',false);
        $('select[name="billing_city"]').attr('disabled',false);
         $('input[name="billing_address"]').prop('readonly',false);
          $('input[name="billing_address_2"]').prop('readonly',false);
           $('input[name="billing_zip"]').prop('readonly',false);
           $('input[name="same_billing"]').prop('disabled',false);
		});
    $('input[name="same_billing"').change(function(){
      var country=$('input[name="country"]').val();
      var state=$('input[name="state"]').val();
      var city=$('input[name="city"]').val();
      var address=$('input[name="address"]').val();
      var address_2=$('input[name="address_2"').val();
      var zip=$('input[name="zip"]').val();
      if($(this).prop('checked')==true){
$('input[name="billing_country"]').val(country);
       $('input[name="billing_state"]').val(state);
        $('input[name="billing_city"]').val(city);
         $('input[name="billing_address"]').val(address);
          $('input[name="billing_address_2"]').val(address_2);
           $('input[name="billing_zip"]').val(zip);
      }
    });

	})
</script>
<script>
                             $(document).ready(function(){
                                $('select[name="country"]').change(function(){
                                    var value=$(this).val();

                                    if($('input[name="same_billing"').prop('checked')==true){
                                      $('.countries').remove();
                                       $("#billing_country").append('<option class="countries" value="'+value+'"  selected>'+value+'</option>');
                                    }
                                     $.ajax({
                                   url:"{{ url('vendor/country') }}",
                                   method:'get',
                                   data:{country:value},
                                   dataType:'json',
                                     error: function(xhr, status, error) {
                  console.log(xhr.responseText);
                },
                                   success:function(data){
                                    console.log(data);
                                    $('.ops').remove();
                                    if($('input[name="same_billing"').prop('checked')==true){
                                      $('.st').remove();
                                    }
                                    $("#state").append(data.data);
                                     
                                   }
                               });
                                });
                                $('select[name="state"]').change(function(){
                                    var value=$(this).val();
                                   if($('input[name="same_billing"').prop('checked')==true){
                                       $("#billing_state").append('<option value="'+value+'" selected class="st">'+value+'</option>');
                                    }
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
                                    if($('input[name="same_billing"').prop('checked')==true){
                                      $('.cit').remove();
                                    }

                                    $("#city").append(data.data);
                                  
                                   }
                               });
                                });
                                $('select[name="city"]').change(function(){
                                  var value=$(this).val();
                                  if($('input[name="same_billing"').prop('checked')==true){
                                       $("#billing_city").append('<option value="'+value+'" class="cit" selected>'+value+'</option>');
                                    }
                                })
                            })
                        </script>
                        <script>
                             $(document).ready(function(){
                                $('select[name="billing_country"]').change(function(){
                                    var value=$(this).val();
                                     $.ajax({
                                   url:"{{ url('vendor/country/a') }}",
                                   method:'get',
                                   data:{country:value},
                                   dataType:'json',
                                     error: function(xhr, status, error) {
                  console.log(xhr.responseText);
                },
                                   success:function(data){
                                    $('.st').remove();
                                    $("#billing_state").append(data.data);

                                   }
                               });
                                });
                                $('select[name="billing_state"]').change(function(){
                                    var value=$(this).val();
                                   
                                                $.ajax({
                                   url:"{{ url('vendor/state/v') }}",
                                   method:'get',
                                   data:{state:value},
                                   dataType:'json',
                                     error: function(xhr, status, error) {
                  console.log(xhr.responseText);
                },
                                   success:function(data){
                                    $('.cit').remove();
                                    $("#billing_city").append(data.data);
                                   }
                               });
                                });
                                $("input[name='address'").keyup(function(){
                                  var value=$(this).val();
                                  if($('input[name="same_billing"').prop('checked')==true){
                                    $("input[name='billing_address']").val(value);
                                  }
                                });
                                 $("input[name='address_2'").keyup(function(){
                                  var value=$(this).val();
                                  if($('input[name="same_billing"').prop('checked')==true){
                                    $("input[name='billing_address_2']").val(value);
                                  }
                                });
                                  $("input[name='zip'").keyup(function(){
                                  var value=$(this).val();
                                  if($('input[name="same_billing"').prop('checked')==true){
                                    $("input[name='billing_zip']").val(value);
                                  }
                                });
                                  $('input[name="same_billing"').change(function(){
                                    if($(this).prop('checked')==false){
                                  
                                      $('select[name="billing_state"]').find('.st').remove();
                                      $('select[name="billing_city"]').find('.cit').remove();
                                      $("input[name='billing_address']").val('');
                                      $("input[name='billing_address_2']").val('');
                                      $("input[name='billing_zip']").val('');
                                    }
                                  });
                            })
                        </script>
@endsection