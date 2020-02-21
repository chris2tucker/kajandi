<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CVendor Outstanding Detail</title>
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
                        <a href="{{url('admin/vendor_outstanding_payment')}}">Vendor outstanding Payment</a>
                    </li>
                   
                </ol>
            </div>
            
        </header>
        <script>
$(document).ready(function(){
 

$(document).on('change','.vendor',function(e){

      
        var vendor_id = $(this).val();

        var url = ajaxurl+'admin/get_vendor_outstanding_payment';
        
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
            
            $('.outstanding_payment').createTable(data.outstanding, {
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
                thPaddingLeft: '10px',

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

        $('.total_price').html(data.total_price.total_price);
               
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });

 
});
</script>


    <section id="content" class="table-layout animated fadeIn">

         
            <!-- -------------- /Column Left -------------- -->

            <!-- -------------- Column Center -------------- -->
            <div class="chute chute-center">

                <div class="mw1000 center-block">

                    <!-- -------------- Spec Form -------------- -->
                    <div class="allcp-form">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                               Outstanding Payment 
                            </div>
                            <div class="panel-body">
                                    <div class="form-group">
                                                <div class="row ">
                                                <label for="store-name" class="col-sm-2 control-label small">Vendor: <font color="red">*</font></label>
                                                    <div class="col-sm-10 ph10">
                                                            <select id="drop" name="condition" class="form-control chosen vendor">
                                                                <option value="">Select a Vendors</option>
                                                                @foreach($vendors as $key=>$val)
                                                                    <option value="{{$key}}">{{$val}}</option>
                                                                @endforeach
                                                            </select>
                                                    </div>
                                                </div>
                                             </div>
              
                            <div class="panel-body pn">
                                <div class="table-responsive">

                                    <div class="outstanding_payment">
                                    
                                </div>
                            </div>
                      

                                <table class="table account_table">
                                    <tbody>    
                                        <tr>
                                        <td colspan="6" class="first"></td>
                                        <td colspan="4"><strong>Total Price:</strong></td>
                                        <td colspan="3"><div class="total_price">0.0</div></td>
                                    </tr>
                                   
                                    </tr>
                                </tbody> 
                                    </table>

                                <!-- -------------- /form -------------- -->



                            </div>
                        </div>

                    </div>



                </div>
            </div>
            <!-- -------------- /Column Center -------------- -->
@include('includes.footer')
