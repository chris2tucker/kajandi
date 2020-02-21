<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Requisition</title>
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
                    
                    
                    <li class="breadcrumb-current-item">Requisition</li>
                </ol>
            </div>

    </header>
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><em class="ti-user mr5"></em>Requisition</h3>
                </div>
            </div>

         
            <!--  /Column Left  -->

            <!--  Column Center  -->
            <div class="chute chute-center">

                <div class="mw1200 center-block">

                    <!--  Spec Form  -->
                    <div class="allcp-form">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title">Requisition
                                </div>
                            </div>
                            <div class="panel-body">
                                   
                        <div class="col-md-12">
                       
                            
                            <div class="panel-body pn">
                                <div class="table-responsive">
                                    <div>
                                   <!-- <div class="form-group">
                                        <label>Select filter:</label>
                                      <select class="pending-product form-control" id="sel1">
                                        <option value="0">Select filter</option>
                                        <option value="1">pending payment</option>
                                        <option value="2">data range 1-10</option>
                                        <option value="3">data range 1-50</option>
                                        <option value="4">data range 1-100</option>
                                        

                                      </select>
                                    </div>-->
                                    <div>
                                    <div class="form-group">
                                        <label>Select Category:</label>
                                      <select class="pending-category form-control" id="sel1">
                                        <option>Select category</option>
                                        @foreach(App\category::latest()->get() as $model)
                                            <option value="{{ $model->id }}">{{ $model->name }}</option>
                                        @endforeach

                                      </select>
                                    </div>
                                         </div>
                                     <div>
                                    <div class="form-group">
                                        <label>Select SubCategory:</label>
                                      <select class="pending-subcategory form-control" id="sel1">
                                        <option>Select Subcategory</option>
                                    @foreach(App\subcategory::latest()->get() as $model)
                                        <option value="{{ $model->id }}">{{ $model->name }}</option>
                                        @endforeach
                                      </select>
                                    </div>
                                         </div>    
                                    <table class="table table-bordered table-striped mg-t" id="table">

                                        <thead>

                                        <tr>
                                            <th>S/N</th>
                                            <th>Order Number</th>
                                            <th>Customer</th>
                                            <th>Quantity</th>
                                            <th>Total Price</th>
                                            <th>Payment Method</th>
                                            <th>Payment status</th>
                                            <th>Order Date</th>
                                            <th>Order Status</th>
                                            
                                            <th>Delivery Status</th>
                                            <!--<th>Order failed</th>-->
                                            <th>View</th>
                                            <th>Flag</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Order Number</th>
                                            <th>Customer</th>
                                            <th>Quantity</th>
                                            <th>Total Price</th>
                                            <th>Payment Method</th>
                                            <th>Order Date</th>
                                            <th>Order Status</th>
                                            <th>Oder Cancel reason</th>
                                            <th>Delivery Status</th>
                                          <!--   <th>Order failed</th>-->
                                            <th>View</th>
                                            <th>Flag</th>
                                        </tr>
                                        </tfoot>
                                        <tbody id="re">
                                        
                                          <?php echo $view ?>
                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
            

                                

                                <!--  /form  -->



                            </div>
                        </div>

                    </div>



                </div>
            </div>
            <!--  /Column Center  -->


<script type="text/javascript">
        $('.deliverystatus').change(function () {
            orderid = $(this).attr('id');
            value = $(this).val();
            url = ajaxurl+'/deliverystatus';
                $.get(
                        url,
                  {value: value,
                    orderid: orderid},
                  function(data) {
                    console.log(data);
                  });
        })

</script>
<script type="text/javascript">
        $('.pending-product').change(function () {
          orderid = $(this).attr('id');
            value = $(this).val();
           url = ajaxurl+'/order/pending';
             $.ajax({
                url:url,
                data: {value:value,
                    orderid: orderid},
                type: "GET",
               dataType: "Html",
               success:function(response){
                console.log(response)
                
               }
           });
        })
</script>
<script type="text/javascript">
        $('.pending-category').change(function () {
            value = $(this).val();
            
           url = ajaxurl+'/order/category';
             $.ajax({
                url:url,
                data: {value:value},
               type: "GET",
               dataType: "Html",
                error: function (request, status, error) {
        alert(request.responseText);
    },
               success:function(response){
                    console.log(response);
                $("#re").html(response)
               }
           });
        })
</script>
<script type="text/javascript">
        $('.pending-subcategory').change(function () {
            value = $(this).val();
           url = ajaxurl+'/order/subcategory';
             $.ajax({
                url:url,
                data: {value:value},
               type: "GET",
               dataType: "Html",
               success:function(response){
                $("#re").html(response)
               }
           });
        })
</script>
<script>
$(document).ready(function(){
 

$(document).on('change','.pending-category',function(e){

      
        var catagory_id = $(this).val();

        var url = ajaxurl+'admin/get_sub_catgory';



        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
            }
        })
            e.preventDefault(); 
        var formData = {
            
            catagory_id     : catagory_id,    
        }

        $.ajax({
            

            type: "GET",
            url: url,
            data: formData,
            dataType: 'json',
            success: function (data) {
            
               var select = $(".pending-subcategory"), options = '';
               
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

@include('includes.footer')

