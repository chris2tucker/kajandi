<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Edit Customer</title>
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
                        <a href="{{url('admin/adv_sec_1')}}">Customer</a>
                    </li>
                    <li class="breadcrumb-current-item">Edit Customer</li>
                </ol>
            </div>
            
        </header>
            <div class="chute chute-center">

                <div class="mw1000 center-block">

                    <!-- -------------- Spec Form -------------- -->
                    <div class="allcp-form">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title">Edit Customer
                                </div>
                            </div>
                            <div class="panel-body br-t">
                            <div class="allcp-form theme-primary">

                          

                             <div class="box-lg">
                        <div class="row" data-gutter="60">
                           <div class="col-md-4">
                        <form method="POST" action="{{ url('admin/updatecustomer/'.$customer->id) }}" aria-label="{{ __('Register') }}">
                             {{ csrf_field() }}
                      
                            <div class="form-group">
                                <label>Company name</label>
                                <input type="text" class="form-control" name="company_name" value="{{ $customer->company_name}}" autofocus>

                            </div>
                            <div class="form-group">
                                <label>About Company</label>
                                <input class="form-control" type="text" name="about_company" value="{{ $customer->about }}" />
                            </div>
                           
                            <div class="form-group">
                                <label>Website-URL</label>
                                <input class="form-control" type="text" name="website_url" value="{{ $customer->website }}" />
                            </div>
                            <div class="form-group">
                                <label>CAC Number</label>
                                <input class="form-control" type="text" name="cac_number" value="{{ $customer->cac }}" />
                            </div>
                            <div class="form-group">
                                <label>Type of Business</label>
                                <input class="form-control" type="text" name="type_of_business" value="{{ $customer->businesstype }}" />
                            </div>
                            <div class="form-group">
                                <label>Years of Existence</label>
                                <input class="form-control" type="text" name="year_of_existence" value="{{ $customer->yearsofexitence }}" />
                            </div>
                            <input class="btn btn-primary" type="submit" value="Save" />
                    </div>
                    <div class="col-md-4">
                            
                            <div class="form-group">
                                <label>Phone of MD/Chairman</label>
                                <input class="form-control" type="text" name="phone_of_MD_Chairman" value="{{ $customer->mdtel }}" />
                            </div>
                            <div class="form-group">
                                <label>Email of MD/Chairman</label>
                                <input class="form-control" type="text" name="email_of_MD_Chairman" value="{{ $customer->mdemail }}" />
                            </div>
                            <div class="form-group">
                                <label>Phone of Contact Person</label>
                                <input class="form-control" type="text" name="phone_of_contact_person" value="{{ $customer->contactpersontel }}" />
                            </div>
                            <div class="form-group">
                                <label>Email of Contact Person</label>
                                <input class="form-control" type="text" name="email_of_contact_person" value="{{ $customer->contactpersonemail }}" />
                            </div>
                            <div class="form-group">
                                <label>Company Rating</label>
                                <input class="form-control" type="text" name="company_rating" value="{{ $customer->company_rating }}" />
                            </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                                <label>Name</label>
       
                                <input type="text" class="form-control" name="name" value="{{ $user->name }}">

                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" value="{{ $user->email }}">

                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password" value="">
                            </div>
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" class="form-control" name="password_confirmation" value="">
                             </div>
                             <div class="form-group">
                                <label>Country</label>
                                 @php
                            $countries=App\country::all();
                            
                            @endphp
                                <select id="country" name="country" class="form-control" >
                                            <option value="">Select Country...</option>
                                            @foreach($countries as $country)
                                            <option value="{{$country->name}}" @if($country->name==$customer->country) selected @endif >{{$country->name}}</option>
                                            @endforeach
                                          </select>
                            </div>
                            <div class="form-group">
                                <label>State</label>
                                   <select id="state" name="state" class="form-control" >
                                            <option value="">Select State...</option>
                                         @php
                                    $states=App\state::where('country_name','=',$customer->country)->get();
                                    @endphp
                                           
                                          
                                        
                                          @foreach($states as $st)
                                          <option class="ops" @if($customer->state) @if($customer->state==$st->name) selected @endif @endif value="{{$st->name}}">{{$st->name}}</option>
                                          
                                           @endforeach
                                          </select>
                                          </select>
                                
                            </div>
                             <div class="form-group">
                                <label>city</label>
                                <select id="city" name="city" class="form-control" >
                                            <option value="">Select Location...</option>
                                             @php
                                    $states=App\city::where('state_name','=',$customer->state)->get();
                                    @endphp
                                           
                                           
                                           @foreach($states as $st)
                                           <option class="opss" @if($customer->city) @if($customer->city==$st->name) selected @endif @endif value="{{$st->name}}">{{$st->name}}</option>
                                           
                                           @endforeach
                                          
                           
                                </select>
                                
                            </div>
                            <div class="form-group">
                                <label>Billing Country</label>
                                 @php
                            $countries=App\country::all();
                            
                            @endphp
                                <select id="billing_country" name="billing_country" class="form-control" >
                                            <option value="">Select Country...</option>
                                            @foreach($countries as $country)
                                            <option value="{{$country->name}}" @if($country->name==$customer->billing_country) selected @endif >{{$country->name}}</option>
                                            @endforeach
                                          </select>
                            </div>
                            <div class="form-group">
                                <label>Billing State</label>
                                   <select id="billing_state" name="billing_state" class="form-control" >
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
                                <select id="billing_city" name="billing_city" class="form-control" >
                                            <option value="">Select City...</option>
                                             @php
                                            $billing_states=App\city::where('state_name',$customer->billing_state)->get();
                                            @endphp
                                         @foreach($billing_states as $bi)
                                           <option class="cit" selected value="{{$bi->name}}" @if($customer->billing_city) @if($customer->billing_city==$bi->name) selected @endif @endif>{{$bi->name}}</option>
                                           @endforeach
                                          
                           
                                </select>
                                
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                               <input type="text" name="address" placeholder="Address here" value="{{$customer->address}}">
                                          
                           
                                
                                
                            </div>
                             <div class="form-group">
                                <label>Billing Address</label>
                               <input type="text" name="billing_address" placeholder="Address here" value="{{$customer->billing_address}}">
                                          
                           
                                
                                
                            </div>
                            <!-- <div class="checkbox">
                                <label>
                                    <input class="i-check" type="checkbox" />Sign Up to the Newsletter</label>
                            </div> -->
                         
                                    
                                <?php echo Form::close(); ?>
                            </div>
                        </div>
                    </div>
                    </div>



                </div>
            </div>
            <!-- -------------- /Column Center -------------- -->
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
                                    $('.ops').remove();
                                    $("#state").append(data.data);
                                     
                                   }
                               });
                                });
                                $('select[name="state"]').change(function(){
                                    var value=$(this).val();
                                   if($('input[name="same_billing"').prop('checked')==true){
                                       $("#billing_state").append('<option value="'+value+'" selected class="ops">'+value+'</option>');
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
                                    $("#city").append(data.data);
                                  
                                   }
                               });
                                });
                                $('select[name="city"]').change(function(){
                                  var value=$(this).val();
                                  if($('input[name="same_billing"').prop('checked')==true){
                                       $("#billing_city").append('<option value="'+value+'" class="opss" selected>'+value+'</option>');
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
@include('includes.footer')


