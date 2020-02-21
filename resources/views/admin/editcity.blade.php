<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Shipping Managment</title>
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
                        <a href="{{url('admin/shipping')}}">Shipping Managment</a>
                    </li>
                    <li class="breadcrumb-current-item">Add Shipping</li>
                </ol>
            </div>
            
        </header>

         
            <!-- -------------- /Column Left -------------- -->

            <!-- -------------- Column Center -------------- -->
            <div class="chute chute-center">

                <div class="mw1000 center-block">

                    <!-- -------------- Spec Form -------------- -->
                    <div class="allcp-form">
                        <div class="panel">
                            <div class="panel-heading">
                                <div class="panel-title">Shipping
                                </div>
                            </div>
                            <div class="panel-body br-t">
                            <div class="allcp-form theme-primary">

                          

                            <form method="post" action="{{ url('admin/city/edit/'.$city->id) }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="section row mb10">
                                    <label for="store-name" class="col-sm-2 control-label small">Country:</label>
                                    <div class="col-sm-10 ph10">
                                           <!-- <input type="text" name="state" id="business-name" class="form-control" placeholder="State">-->
                                            <select name="country" class="form-control" id="country"   >
                                                <option value="" selected disabled>Select a country</option>
                                                @php
                                                $countries=App\country::all();
                                                @endphp
                                                @foreach($countries as $country)
                                                <option value="{{$country->name}}" @if($country->name==$city->country_name) selected @endif>{{$country->name}}</option>
                                                option
                                                @endforeach
                                            </select>
                                    </div>
                                </div>
                                

                                <div class="section row mb10">
                                    <label for="store-name" class="col-sm-2 control-label small">State:</label>
                                    <div class="col-sm-10 ph10">
                                           <!-- <input type="text" name="state" id="business-name" class="form-control" placeholder="State">-->
                                            <select name="state" class="form-control" id="state"  >
                                               <option value="{{$city->state_name}}" selected>{{$city->state_name}}</option>
                                               
                                            </select>
                                    </div>
                                </div>

                                
                            
                                <div class="section row mb10">
                                    <label for="store-address" class="col-sm-2 control-label small">City</label>

                                    <div class="col-sm-10 ph10">
                                            <input type="text" name="city" id="city" class="form-control" value="{{$city->name}}" placeholder="City"> 
                                    </div>
                                </div>
                                
                                

                                

                            
                                

                                

                                </div>
                                </div>
                                </div>

                        


                               <div class="panel">
                            <div class="panel-heading">
                                
                            </div>
                            <div class="panel-body br-t">
                            <div class="allcp-form theme-primary">

                                

                               

                                    

                            </div>
                        </div>

                        <div class="panel-footer text-right">
                                <button type="submit" class="btn btn-bordered btn-primary mb5"> SAVE</button>
                        </div>

                        </div>

                        </form>

                    </div>



                </div>
            </div>
            <!-- -------------- /Column Center -------------- -->
            <script>
                $(document).ready(function(){
                    $("#country").change(function(){
                        var country=$(this).val();
                        $.ajax({
                            url:"{{url('get/states/shipping')}}",
                            method:"GET",
                            data:{country:country},
                            dataType:"json",
                             success:function(data)
                 {
                    console.log(data);
                    $('.abc').remove();
                    $("#state").append(data);
                 }



                        });
                    })
                })
            </script>
@include('includes.footer')