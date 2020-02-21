<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Products</title>
    @include('includes.head')
</head>

@include('includes.header')
<style type="text/css">
    .img_product {
    width: 51px;
}
.box {
    border: 1px solid #0094ff;
    margin-bottom: 10px;
    border-bottom-right-radius: 20px;
    border-bottom-left-radius: 20px;
}
.box h4 {
    background: #0094ff;
    color: white;
    padding: 8px;
    margin: 0;
}
.box p {color:#333;padding:10px;}
.box {
    -moz-border-radius-topright:5px;
    -moz-border-radius-topleft:5px;
    -webkit-border-top-right-radius:5px;
    -webkit-border-top-left-radius:5px;
}
.detail_title {
    font-size: 15px;
    font-weight: bold;
}

</style>
<script type="text/javascript">
    
$(document).ready(function(){


   $(document).on('click','.btn_approve',function(e){

      
        var id = $(this).attr('id');
     console.log(id);
        
        

        var url = ajaxurl+'admin/aproveProduct';
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
            }
        })
            e.preventDefault(); 
        var formData = {
            
            id  : id,    
        }

        $.ajax({
            

            type: "POST",
            url: url,
            data: formData,
            dataType:'json',
            success: function (data) { 
               
               location.reload();     
            },
            error: function (data) {
                location.reload();   

            }
        });
    });
    $(document).on('click','.btn_reject',function(e){

      
        var id = $(this).attr('id');
     console.log(id);
        
        

        var url = ajaxurl+'admin/approveReject';
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
            }
        })
            e.preventDefault(); 
        var formData = {
            
            id  : id,    
        }

        $.ajax({
            

            type: "POST",
            url: url,
            data: formData,
            dataType:'json',
            success: function (data) { 
               
               location.reload();     
            },
            error: function (data) {
                location.reload();   

            }
        });
    });
});
</script>
 <header id="topbar" class="alt">
            <div class="topbar-left">
                <ol class="breadcrumb">
                    <li class="breadcrumb-icon">
                        <a href="{{url('admin/index')}}">
                            <span class="fa fa-home"></span>
                        </a>
                    </li>
                    <li class="breadcrumb-active">
                        <a href="{{url('admin/index')}}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-link">
                        <a href="#">Update Products Approve</a>
                    </li>
                   
                </ol>
            </div>
            
        </header>
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><em class="ti-user mr5"></em>Products Update Approve</h3>
                </div>
            </div>

         
            <!-- -------------- /Column Left -------------- -->

            <!-- -------------- Column Center -------------- -->
            <div class="chute chute-center">

                <div class="mw1200 center-block">

                    <!-- -------------- Spec Form -------------- -->
                    <div class="allcp-form">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Products Approve
                            </div>
                            <div class="panel-body">
                            



                                  
               
                 
                    <div class="panel-body pn">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mg-t" id="table">
                                <thead>
                                <tr class="bg-light">
                                    <th class="">Product Name</th>
                                    <th>Vendor Name</th>
                                    <th>Vendor Email</th>
                                    <th>Date</th>
                                    <th class="">Detail</th>
                                    
                                    

                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($vendor_product as $product)
                                    <tr>
                                      <td>{{$product->name}}</td>
                                      <td>{{App\User::find($product->user_id)->name}}</td>
                                      <td>{{App\User::find($product->user_id)->email}}</td>
                                      <td>{{$product->updated_at}}</td>
                                      <td><button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#edit_model_{{$product->id}}">Approval Detail</button></td>
                                    </tr>

                                      <div class="modal fade" id="edit_model_{{$product->id}}" role="dialog">
                                        <div class="modal-dialog">
                                        
                                          <!-- Modal content-->
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                              <h4 class="modal-title">{{$product->name}}</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="box">
                                                    <h4>Name</h4>
                                                    <p><span class="detail_title">Old Name: </span> {{$product->name}}<br>
                                                        <span class="detail_title">New Name: </span> {{$product->p_name}}

                                                    </p>
                                                </div>

                                                <div class="box">
                                                    <h4>Price</h4>
                                                    <p><span class="detail_title">Old Price: </span>  {{App\Http\Controllers\HomeController::converter($product->instant_price)}}<br>
                                                        <span class="detail_title">New Price: </span> {{App\Http\Controllers\HomeController::converter($product->p_price)}}

                                                    </p>
                                                </div>

                                                <div class="box">
                                                    <h4>Stock</h4>
                                                    <p><span class="detail_title">Old Name: </span> {{$product->stock_count}}<br>
                                                        <span class="detail_title">New Name: </span> {{$product->quantity}}

                                                    </p>
                                                </div>
                                                <div class="box">
                                                    <h4>15 Days price</h4>
                                                    <p><span class="detail_title">Old 15 Days Price: </span> {{App\Http\Controllers\HomeController::converter($product->pricewithin15days)}}<br>
                                                        <span class="detail_title">New 15 Days Price: </span> {{App\Http\Controllers\HomeController::converter($product->days_15_price) }}

                                                    </p>
                                                </div>
                                                <div class="box">
                                                    <h4>30 Days price</h4>
                                                    <p><span class="detail_title">Old 30 Days Price: </span> {{App\Http\Controllers\HomeController::converter($product->pricewithin30days)}}<br>
                                                        <span class="detail_title">New 30 Days Price: </span>  {{App\Http\Controllers\HomeController::converter($product->days_30_price) }}

                                                    </p>
                                                </div>
                                                <div class="box">
                                                    <h4>Delivery rate state</h4>
                                                    <p><span class="detail_title">Old  Delivery rate state: </span> {{App\Http\Controllers\HomeController::converter($product->deliveryratestate)}}<br>
                                                        <span class="detail_title">New Delivery rate state: </span> {{App\Http\Controllers\HomeController::converter($product->deliveryrate_state) }}

                                                    </p>
                                                </div>
                                                <div class="box">
                                                    <h4>Delivery rate outstate with geo</h4>
                                                    <p><span class="detail_title">Old  Delivery rate outstate with geo: </span> {{App\Http\Controllers\HomeController::converter($product->deliveryrateoutstatewithgeo)}}<br>
                                                        <span class="detail_title">New Delivery rate outstate with geo: </span> {{App\Http\Controllers\HomeController::converter($product->deliveryrateoutstatewith_geo) }}

                                                    </p>
                                                </div>
                                                <div class="box">
                                                    <h4>Delivery rate outside geo</h4>
                                                    <p><span class="detail_title">Old  Delivery rate outside geo: </span> {{App\Http\Controllers\HomeController::converter($product->deliveryrateoutsidegeo)}}<br>
                                                        <span class="detail_title">New  Delivery rate outside geo: </span> {{App\Http\Controllers\HomeController::converter($product->deliveryrate_outsidegeo)}}

                                                    </p>
                                                </div>
                                                 <div class="box">
                                                    <h4>Part Number</h4>
                                                    <p><span class="detail_title">Old Part Number: </span>  {{$product->part_number}}<br>
                                                        <span class="detail_title">New Part Number: </span> {{$product->part}}

                                                    </p>
                                                </div>
                                                 <div class="box">
                                                    <h4>Category</h4>
                                                    <p><span class="detail_title">Old Category: </span>  {{App\category::find($product->category)->name}}
                                                         <br>
                                                        <span class="detail_title">New Category: </span> @if($product->cat) {{App\category::find($product->cat)->name}} @endif

                                                    </p>
                                                </div>
                                                 <div class="box">
                                                    <h4>Sub Category</h4>
                                                    <p><span class="detail_title">Old  Sub Category: </span>   {{App\subcategory::find($product->subcategory)->name}} <br>
                                                        <span class="detail_title">New Sub Category: </span>@if($product->subcat)  {{App\subcategory::find($product->subcat)->name}}
                                                        @endif

                                                    </p>
                                                </div>
                                                 <div class="box">
                                                    <h4>Other Information</h4>
                                                    <p><span class="detail_title">Old  Information: </span>   {{$product->other_information}} <br>
                                                        <span class="detail_title">New Information </span>{{$product->key_information_p}}
                                                        

                                                    </p>
                                                </div>
                                                <div class="box">
                                                    <h4>Description</h4>
                                                    <p><span class="detail_title">Old  Description: </span>   {{$product->description}} <br>
                                                        <span class="detail_title">New Description </span>{{$product->description_p}}
                                                        

                                                    </p>
                                                </div>
                                                 <div class="box">
                                                    <h4>Images</h4>
                                                    <?php 
                                                    $image=App\productimages::where('product_id','=',$product->product_id)->first();

                                                     ?>
                                                    <p><span class="detail_title">Image 1: </span>   <img src="{{url('/'.$image->image_1)}}" alt="" style="height: 200px;width: 200px;margin-left: 100px;"> <br>
                                                        <span class="detail_title">Image 2: </span><img src="{{url('/'.$image->image_2)}}" alt="" style="height: 200px;width: 200px;margin-left: 100px;"> <br>
                                                         <span class="detail_title">Image 3: </span><img src="{{url('/'.$image->image_3)}}" alt="" style="height: 200px;width: 200px;margin-left: 100px;"> <br>
                                                          <span class="detail_title">Image 4: </span><img src="{{url('/'.$image->image_4)}}" alt="" style="height: 200px;width: 200px;margin-left: 100px;"> <br>
                                                        
                                                    </p>
                                                </div>
                                                <button class="btn btn-success btn_approve"  id="{{$product->product_id}}">APPROVE</button>
                                                <button class="btn btn-danger btn_reject"  id="{{$product->product_id}}">REJECT</button>
                                                
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                          </div>
                                          
                                        </div>
                                      </div>

                                   @endforeach
                              
                               
                                </tbody>
                            </table>
                        </div>
                    </div>
                

                                

                                <!-- -------------- /form -------------- -->



                            </div>
                        </div>

                    </div>



                </div>
            </div>
   

        <script>

 $(".delete").on("click", function(){
        
        return confirm("Do you want to delete this item?");
        
    });
    
</script>

            <!-- -------------- /Column Center -------------- -->
@include('includes_vendor.footer')
