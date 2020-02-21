<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Commissions</title>
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
                        <a href="#">commissions</a>
                    </li>
                   
                </ol>
            </div>
            
        </header>
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><em class="ti-user mr5"></em>Commissions List</h3>
                </div>
            </div>

         
            <!-- -------------- /Column Left -------------- -->

            <!-- -------------- Column Center -------------- -->
            <div class="chute chute-center">

                <div class="mw1200 center-block">

                    <!-- -------------- Spec Form -------------- -->
                    <div class="allcp-form">
                        <div class="panel panel-default">
                            
                            <div class="panel-body">
                            



                                  
               
                 
                    <div class="panel-body pn">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mg-t" id="table">
                                <thead>
                                <tr class="bg-light">
                                    <th class="text-center">S/N</th>
                                    <th class="">Category Name</th>
                                    <th>Category Commissions</th>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($category as $key=>$cat)
                                      
                                        
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $cat->name }}</td>
                                                <td>{{ $cat->catagory_comission  }}%</td>
                                                
                                                
                                            </tr>
                                            @endforeach
                                           <!-- Modal -->
                                        
                               
                                </tbody>
                            </table>
                        </div>
                    </div>
                
                    
                    <div class="panel-body pn">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mg-t" id="table">
                                <thead>
                                <tr class="bg-light">
                                    <th class="text-center">S/N</th>
                                    <th class="">Sub-category Name</th>
                                    <th>sub-category Commissions</th>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($subcategory as $key=>$sub)
                                      
                                        
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $sub->name }}</td>
                                                <td>{{$sub->sub_commission }}%</td>
                                                
                                                
                                            </tr>
                                            @endforeach
                                           <!-- Modal -->
                                        
                               
                                </tbody>
                            </table>
                        </div>
                    </div>
                                <div class="panel-body pn">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mg-t" id="table">
                                <thead>
                                <tr class="bg-light">
                                    <th class="text-center">S/N</th>
                                    <th class="">Product Name</th>
                                    <th>Product Commissions</th>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $key=>$pro)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $pro->name }}</td>
                                                <td>{{$pro->commision }}%</td>
                                                
                                                
                                            </tr>
                                            @endforeach
                                           <!-- Modal -->
                                        
                               
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

            <!-- Button trigger modal -->



   

        <script>

 $(".delete").on("click", function(){
        
        return confirm("Do you want to delete this item?");
        
    });
    
</script>

            <!-- -------------- /Column Center -------------- -->
@include('includes_vendor.footer')
