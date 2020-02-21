<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Today Featured</title>
    @include('includes.head')
</head>

@include('includes.header')
<script src="{{URL::asset('assets/js/jquery-3.3.1.min.js') }}"></script>
  <script>
$(document).ready(function(){

$(document).on('change','.vendor',function(e){

      
        var vendor_id = $(this).val();

        var url = ajaxurl+'admin/get_vendor_product';



        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
            }
        })
            e.preventDefault(); 
        var formData = {
            
            vendor_id     : vendor_id,    
        }

        $.ajax({
            

            type: "GET",
            url: url,
            data: formData,
            dataType: 'json',
            success: function (data) {
            
               var select = $(".product_name"), options = '';
               
               select.empty();      

               for(var i=0;i<data.length; i++)
               {
                options += "<option value='"+data[i].id+"'>"+ data[i].name +"</option>";              
               }

                select.append(options);  

             
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
});
</script>

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
                        <a href="{{url('admin/add_today_fetured')}}">Today Featured</a>
                    </li>
                    <li class="breadcrumb-current-item">Edit Today Featured</li>
                </ol>
            </div>
            
        </header>
         
            <!-- -------------- /Column Left -------------- -->

            <!-- -------------- Column Center -------------- -->
            <div class="chute chute-center">

                <div class="mw1000 center-block">

                    <!-- -------------- Spec Form -------------- -->
                    <div class="allcp-form">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title">General Information
                                </div>
                            </div>
                            <div class="panel-body br-t">
                            <div class="allcp-form theme-primary">

                            <form method="POST" action="{{ url('/admin/today_feature_update/'.$today_featured->id) }}" class="form-horizontal" enctype="multipart/form-data">
                                {{ csrf_field() }}


                                <div class="section row mb10">
                                    <label for="store-name" class="col-sm-2 control-label small">Vendors:<font color="red">*</font></label>

                                    <div class="col-sm-10 ph10">
                                            <select id="country" name="vendor" class="vendor form-control">
                                                <option value="">Select a Vendor</option>
                                                @foreach($vendor as $key=>$val)
                                                    <option value="{{$key}}" @if($today_featured->vendor_id==$key) selected="selected" @endif>{{$val}}</option>
                                                @endforeach
                                            </select>
                                           
                                    </div>
                                </div>

                                <div class="section row mb10">
                                    <label for="store-name" class="col-sm-2 control-label small">Vendor Product:<font color="red">*</font></label>

                                    <div class="col-sm-10 ph10">
                                            <select id="country" name="product_name" class="product_name form-control">
                                                @foreach($vendor_products as $key)
                                                <option value="{{$key->id}}" @if($today_featured->vendor_product_id==$key->id) selected="selected" @endif>{{$key->name}}</option>

                                                @endforeach
                                                
                                            </select>
                                            
                                    </div>
                                </div>

                                <div class="section row mb10">
                                    <label for="store-name" class="col-sm-2 control-label small">Image:</label>

                                    <div class="col-sm-10 ph10">

                                            <input type="file" name="image" id="business-name" class="form-control image" >
                                          
                                    </div>
                                </div>

                                 <div class="panel-footer text-right">
                                    <button type="submit" class="btn btn-bordered btn-primary mb5"> SAVE</button>
                                </div>

                                </div>
                                </div>
                                </div>

                               
                        </div>

               

                       

                        </div>

                         </form>

                    </div>



                </div>
            </div>
            <!-- -------------- /Column Center -------------- -->
@include('includes.footer')


