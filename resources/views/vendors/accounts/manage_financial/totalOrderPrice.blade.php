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
                        <a href="{{url('admin/product_price')}}">Total Order Price</a>
                    </li>
                   
                </ol>
            </div>
            
        </header>
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><em class="ti-user mr5"></em>Total Orders Price </h3>
                </div>
            </div>
<style type="text/css">
    #from_image {
    padding: 0px;
}
</style>
<script>
$(document).ready(function(){
 

$(document).on('change','.vendor',function(e){

      
        var vendor_id = $(this).val();

        var url = ajaxurl+'admin/get_vendor_total_order_price';
        
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
            
            $('.product_price_tbl').createTable(data.order, {
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

        $('.total_price_with_commission').html(data.TotalPrice_with_commission.totalprice_with_comission);
        $('.total_price_without_commission').html(data.TotalPrice_without_commission.totalprice_without_comission);
         $('.total_commission').html(data.Total_commission.total_comission);        
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


                                </div>
                                <table class="table account_table">
                                    <tbody>    
                                        <tr>
                                        <td colspan="6" class="first"></td>
                                        <td colspan="4"><strong>Total Price With Comission</strong></td>
                                        <td colspan="3"><div class="total_price_with_commission">0.0</div></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="first"></td>
                                        <td colspan="4"><strong>Total Price Without Commission</strong></td>
                                        <td colspan="3" class="total_price_without_commission">0.0</td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="first"></td>
                                        <td colspan="4"><strong>Total Commission</strong></td>
                                        <td colspan="3" class="total_commission">0.0</td>
                                    </tr>
                                </tbody> 
                                    </table>
                                
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