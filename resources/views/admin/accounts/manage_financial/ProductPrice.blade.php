<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Product Commission</title>
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
                        <a href="{{url('admin/product_price')}}">Product Price</a>
                    </li>
                   
                </ol>
            </div>
            
        </header>
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><em class="ti-user mr5"></em>Product Price</h3>
                </div>
            </div>
<style type="text/css">
    #from_image {
    padding: 0px;
}
</style>
<script type="text/javascript">
    $(document).ready(function () {

        $.getJSON("sample-data.json", function (data) {
            $('.table').createTable(data, {
                // General Style for Table
                borderWidth: '1px',
                borderStyle: 'solid',
                borderColor: '#DDDDDD',
                fontFamily: 'Verdana, Helvetica, Arial, FreeSans, sans-serif',

                // Table Header Style
                thBg: '#F3F3F3',
                thColor: '#0E0E0E',
                thHeight: '30px',
                thFontFamily: '"Open Sans Condensed", sans-serif',
                thFontSize: '14px',
                thTextTransform: 'capitalize',

                // Table Body/Row Style
                trBg: '#fff',
                trColor: '#0E0E0E',
                trHeight: '25px',
                trFontFamily: '"Open Sans", sans-serif',
                trFontSize: '13px',

                // Table Body's Column Style
                tdPaddingLeft: '10px',
                tdPaddingRight: '10px'
            });
        });
       
    });
</script>
<script>
$(document).ready(function(){
 

$(document).on('change','.vendor',function(e){

      
        var vendor_id = $(this).val();

        var url = ajaxurl+'admin/get_vendor_product_price';
        
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
            

            type: "POST",
            url: url,
            data: formData,
            dataType: 'json',
            success: function (data) {
            
            $('.product_price_tbl').createTable(data, {
                // General Style for Table
                borderWidth: '1px',
                borderStyle: 'solid',
                borderColor: '#DDDDDD',
                fontFamily: 'Verdana, Helvetica, Arial, FreeSans, sans-serif',

                // Table Header Style
                thBg: '#F3F3F3',
                thColor: '#0E0E0E',
                thHeight: '30px',
                thFontFamily: '"Open Sans Condensed", sans-serif',
                thFontSize: '14px',
                thTextTransform: 'capitalize',

                // Table Body/Row Style
                trBg: '#fff',
                trColor: '#0E0E0E',
                trHeight: '25px',
                trFontFamily: '"Open Sans", sans-serif',
                trFontSize: '13px',

                // Table Body's Column Style
                tdPaddingLeft: '10px',
                tdPaddingRight: '10px'
            });
               

             
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });

 
});
</script>

      <!-- -------------- Topbar -------------- -->
 

         
            <!-- -------------- /Column Left -------------- -->

            <!-- -------------- Column Center -------------- -->
            <div class="chute chute-center">

                <div class="mw1000 center-block">
                   

                    <!-- -------------- Spec Form -------------- -->
                    <div class="allcp-form">
                        <div class="panel">
                           
                           

                        <div class="col-md-12">
                        <div class="panel panel-default" id="spy3">
                            <div class="panel-heading">
                                <div class="panel-title hidden-xs">
                                    Product Price
                                </div>
                            </div>
                            <div class="panel-body pn">
                                <div class="form-group">
                                                <div class="row ">
                                                <label for="store-name" class="col-sm-2 control-label small">Vendor: <font color="red">*</font></label>
                                                    <div class="col-sm-10 ph10">
                                                            <select id="drop" name="condition" class="form-control chosen vendor">
                                                                <option value="">Select a Condition</option>
                                                                @foreach($vendor as $key=>$val)
                                                                    <option value="{{$key}}">{{$val}}</option>
                                                                @endforeach
                                                            </select>
                                                    </div>
                                                </div>
                                             </div>
                                <div class="table-responsive">
                                    

                                <div class="product_price_tbl">

                                    <table class="table table-bordered table-striped mg-t" id="table">
                                        <thead>
                                        <tr>
                                        	
                                            
                                            <th class="va-m">Name</th>
                                            <th class="va-m">Vandor Name</th>
                                            <th class="va-m">Price</th>
                                        </tr>
                                        </thead>
                                        
                                        <tbody>
                                        
                                          @foreach($product as $value)
                                            <tr>
                                            	
                                            	<td>{{$value->name}}</td>
                                                <td>{{$value->vendorname}}</td>
                                                <td>{{App\Http\Controllers\HomeController::converter($value->price)}}</td>
                                        	</tr>
                                          @endforeach
                                        
                                        </tbody>
                                    </table>
                                </div>
                                </div>
                            </div>
                        </div>
                    

                                

                                <!-- -------------- /form -------------- -->



                        </div>

                    </div>



                </div>
            </div>
            <!-- -------------- /Column Center -------------- -->

@include('includes.footer')