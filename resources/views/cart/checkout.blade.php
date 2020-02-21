@extends('layouts.pagelayout')
@section('content')

	<div class="container">
            <header class="page-header">
                <h1 class="page-title">Checkout Order</h1>
            </header>
            <div class="row row-col-gap" data-gutter="60">
                
                

                     <?php
                    if (Auth::check()) {
                    ?>
                    <div class="col-md-5">
                    <h3 class="widget-title">Billing Details</h3>

                    <div class="row text-left">
                        @include('layouts.errors')
                    </div>
                        <?php echo Form::open(['url' => '/checkoutorder']); ?>
                        <input type="hidden" name="ship" value="{{$ship}}">
                        <div class="form-group">
                            <label>First &amp; Last Name</label>
                            <input class="form-control" name="name" type="text" value="{{Auth::user()->name}}" />
                        </div>
                        <div class="form-group">
                            <label>E-mail</label>
                            <input class="form-control" name="email" type="text" value="{{Auth::user()->email}}"/>
                        </div>
                        <?php
                                    $shipping=App\state::all();
                                  
                                    $state='';
                                    $city='';
                                    $address='';
                                    $phone='';
                                    if(Auth::check()){
                                        $customer=App\Customer::where('user_id','=',Auth::user()->id)->first();
                                        
                                        $states=$customer->billing_state;
                                        $city=$customer->billing_city;
                                        $address=$customer->billing_address;
                                        $phone=$customer->contactpersontel;
                                        $cities=App\city::where('state_name','=',$states)->get();
                                        
                                    }
                                    else{
                                        $cities=App\city::all();
                                    }

                                    /*echo Form::select('state', array('' => '- Select -', 'Abuja FCT' => 'Abuja FCT', 'Abia' => 'Abia', 'Adamawa' => 'Adamawa', 'Akwa Ibom'=>'Akwa Ibom', 'Anambra' => 'Anambra', 'Bauchi' => 'Bauchi', 'Bayelsa'=>'Bayelsa', 'Benue'=>'Benue', 'Borno'=>'Borno', 'Cross River'=>'Cross River', 'Delta'=>'Delta', 'Ebonyi'=>'Ebonyi', 'Edo'=>'Edo', 'Ekiti'=>'Ekiti', 'Enugu'=>'Enugu', 'Gombe'=>'Gombe', 'Imo'=>'Imo', 'Jigawa'=>'Jigawa', 'Kaduna'=>'Kaduna', 'Kano'=>'Kano', 'Katsina'=>'Katsina', 'Kebbi'=>'Kebbi', 'Kogi'=>'Kogi', 'Kwara'=>'Kwara', 'Lagos'=>'Lagos', 'Nassarawa'=>'Nassarawa', 'Niger'=>'Niger', 'Ogun'=>'Ogun', 'Ondo'=>'Ondo', 'Osun'=>'Osun', 'Oyo'=>'Oyo', 'Plateau'=>'Plateau', 'Rivers'=>'Rivers', 'Sokoto'=>'Sokoto', 'Taraba'=>'Taraba', 'Yobe'=>'Yobe', 'Zamfara'=>'Zamfara') ,'', $attributes = array('class' => 'form-control'));*/
                                    ?>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input class="form-control" type="text" name="phone" value="{{$phone}}" />
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>State</label>
                                    <br>

                                    <select name="state" class="form-control" >
                                        <option value="" >-Select a state-</option>
                                        
                                        @foreach($shipping as $state)
                                        <option value="{{$state->name}}"
                                            @if($state->name==$states) 
                                            selected
                                            @endif>{{$state->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>City</label>
                                     <select name="city" class="form-control" >
                                        <option value="" >-Select a city-</option>  
                                        @foreach($cities as $cit)
                                        <option value="{{$cit->name}}"
                                            @if($cit->name==$city) 
                                            selected
                                            @endif class="opss">{{$cit->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <script>
                            $(document).ready(function(){
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
                                    $("select[name='city']").append(data.data);
                                   }
                               });
                                });
                            })
                        </script>
                        <div class="form-group">
                            <label>Address</label>
                            <input class="form-control" type="text" name="address" value="{{$address}}" />
                        </div>
                        <div>
                            <button class="btn btn-primary">Proceed Payment</button>
                        </div>
                    <?php echo Form::close(); ?>
                </div>
                    <?php
                    }else{
                    ?>
                        <div class="col-md-12">
                            <h2 class="widget-title">Billing Details</h2>
                        </div>
                        
                    
                    <br>
                    <div class="col-md-4">
                                <h3 class="widget-title">Sign in</h3>

                                @if(Session::has('status'))
                            <p class="alert alert-success alert-dismissable fade in">{{ Session::get('status') }}</p>
                            @endif

                                <?php echo Form::open(['url' => 'signincheckout']); ?>
                                    <div class="form-group">
                                        <?php
                                        echo Form::label('email', 'E-mail');
                                        echo Form::text('email',$value = null, ['class' => 'form-control']);
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <?php
                                        echo Form::label('password', 'Password');
                                        echo Form::password('password', ['class' => 'form-control']);
                                        ?>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input class="i-check" type="checkbox" />Remember me</label>
                                    </div>
                                    <input class="btn btn-primary" type="submit" value="Sign in" />
                                <?php echo Form::close(); ?>
                                <br /><a href="#">Forgot Your Password?</a>
                            </div>
                    <div class="col-md-4">

                    <div class="row text-left">
                        @include('layouts.errors')
                    </div>
                        <h3 class="widget-title">Register</h3>
                        <?php echo Form::open(['url' => '/checkoutorderoffline']); ?>
                        <div class="form-group">
                            <?php
                            echo Form::label('name', 'First &amp; Last Name');
                            echo Form::text('name',$value = null, ['class' => 'form-control']);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php
                            echo Form::label('email', 'E-mail');
                            echo Form::text('email',$value = null, ['class' => 'form-control']);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php
                            echo Form::label('phone_number', 'Phone Number');
                            echo Form::text('phone_number',$value = null, ['class' => 'form-control']);
                            ?>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                        echo Form::label('password', 'Password');
                                        echo Form::password('password', ['class' => 'form-control']);
                                        ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    echo Form::label('password_confirmation', 'Repeat Password');
                                    echo Form::password('password_confirmation', ['class' => 'form-control']);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>State</label>
                                    <br>
                                    <?php
                                    echo Form::select('state', array('' => '- Select -', 'Abuja FCT' => 'Abuja FCT', 'Abia' => 'Abia', 'Adamawa' => 'Adamawa', 'Akwa Ibom'=>'Akwa Ibom', 'Anambra' => 'Anambra', 'Bauchi' => 'Bauchi', 'Bayelsa'=>'Bayelsa', 'Benue'=>'Benue', 'Borno'=>'Borno', 'Cross River'=>'Cross River', 'Delta'=>'Delta', 'Ebonyi'=>'Ebonyi', 'Edo'=>'Edo', 'Ekiti'=>'Ekiti', 'Enugu'=>'Enugu', 'Gombe'=>'Gombe', 'Imo'=>'Imo', 'Jigawa'=>'Jigawa', 'Kaduna'=>'Kaduna', 'Kano'=>'Kano', 'Katsina'=>'Katsina', 'Kebbi'=>'Kebbi', 'Kogi'=>'Kogi', 'Kwara'=>'Kwara', 'Lagos'=>'Lagos', 'Nassarawa'=>'Nassarawa', 'Niger'=>'Niger', 'Ogun'=>'Ogun', 'Ondo'=>'Ondo', 'Osun'=>'Osun', 'Oyo'=>'Oyo', 'Plateau'=>'Plateau', 'Rivers'=>'Rivers', 'Sokoto'=>'Sokoto', 'Taraba'=>'Taraba', 'Yobe'=>'Yobe', 'Zamfara'=>'Zamfara') ,'', $attributes = array('class' => 'form-control'));
                                    ?>
                                    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                        echo Form::label('city', 'City');
                                        echo Form::text('city',$value = null, ['class' => 'form-control']);
                                        ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php
                            echo Form::label('address', 'Address');
                            echo Form::text('address',$value = null, ['class' => 'form-control']);
                            ?>
                        </div>
                        <div>
                            <button class="btn btn-primary">Proceed Payment</button>
                        </div>
                    <?php echo Form::close(); ?>
                </div>
                    <?php
                    }
                    ?>
                    
                
                <div class="col-md-4">
                    <br>
                    <h3 class="widget-title">Order Info</h3>
                    <div class="box">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>QTY</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php echo $view ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

@endsection