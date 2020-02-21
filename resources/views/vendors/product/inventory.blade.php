<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Inventory</title>
    @include('includes_vendor.head')
</head>

@include('includes_vendor.header')
<style type="text/css">
    .img_product {
    width: 51px;
}
</style>
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
                        <a href="#">Vendor Product</a>
                    </li>
                   
                </ol>
            </div>
            
        </header>
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><em class="ti-user mr5"></em>Inventory</h3>
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
                                <a href="{{url('vendor/add_products')}}" class="btn btn-bordered btn-primary mb5"> ADD PRODUCTS</a>
                            </div>
                            <div class="panel-body">
                            



                                  
               
                 
                    <div class="panel-body pn">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mg-t" id="table">
                                <thead>
                                <tr class="bg-light">
                                    <th class="">Product Title</th>
                                    <th class="">Price</th>
                                    <th class="">Number in Stock</th>
                                    <th class="">Add Inventory</th>

                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($vendor_product as $product)
                                    <tr>
                                      <td>{{$product->name}}</td>
                                      <td>{{$product->instant_price}}</td>
                                      <td>{{$product->stock_count}}</td>
                                      <td>
                                          
                                        <form action="{{url('vendor/add_inventory/'.$product->id)}}" method="post">
                                            {{csrf_field()}}
                                            <input type="text" name="unit">
                                            <button type="submit">save</button>
                                        </form>

                                      </td>
                                   

                                    </tr>
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
