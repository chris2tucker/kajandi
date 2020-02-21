<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Adv Section 1</title>
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
                        <a href="{{url('admin/adv_sec_1')}}">Adv Section 1</a>
                    </li>
                    <li class="breadcrumb-current-item">Add  Adv Section 1</li>
                </ol>
            </div>
            
        </header>
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


    

         
            <!-- -------------- /Column Left -------------- -->

            <!-- -------------- Column Center -------------- -->
            <div class="chute chute-center">

                <div class="mw1000 center-block">

                    <!-- -------------- Spec Form -------------- -->
                    <div class="allcp-form">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title">Add Adv Section 1
                                </div>
                            </div>
                            <div class="panel-body br-t">
                            <div class="allcp-form theme-primary">

                            @if(Session::has('status'))
                            <p class="alert alert-success alert-dismissable fade in">{{ Session::get('status') }}</p>
                            @endif
                            @include('layouts.errors')

                            <form method="post" action="{{ url('admin/adv_sec_1') }}"  enctype="multipart/form-data">
                                {{ csrf_field() }}


                                <div class="section row mb10">
                                    <label for="store-name" class="col-sm-2 control-label small">Vendors:</label>

                                    <div class="col-sm-10 ph10">
                                            <select id="country" name="vendor" class="vendor form-control">
                                                <option value="">Select a Vendor</option>
                                                @foreach($vendor as $key=>$val)
                                                    <option value="{{$key}}">{{$val}}</option>
                                                @endforeach
                                            </select>
                                    </div>
                                </div>

                                <div class="section row mb10">
                                    <label for="store-name" class="col-sm-2 control-label small">Vendor Product:</label>

                                    <div class="col-sm-10 ph10">
                                            <select id="country" name="product_name" class="product_name form-control">
                                                
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


