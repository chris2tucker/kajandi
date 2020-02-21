@extends('layouts.pagelayout')
@section('content')
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" rel="stylesheet">
<style type="text/css">
    .row {
        display: flex; /* equal height of the children */
        width: 100%;
    }
    @media (max-width: 768px) {
        .col-xs-12 {
            float: left;
            width: 100%;
        }
        .row {
            display: table-row; /* equal height of the children */
        }
    }


</style>

<div class="mfp-with-anim mfp-hide mfp-dialog clearfix" id="workplace-dialog">
    <h3 class="widget-title">Add Workplace</h3>
    <hr />
    <p class="alert alert-danger loginformerror" style="display: none;">Email or Password incorrect</p>
    <div class="form-group">
        <label>Name</label>
        <input class="form-control name" type="text" />
        <p class="alert alert-danger emailerror" style="display: none;">
            Email field is empty
        </p>
    </div>
    <input class="btn btn-primary addworkplace" type="submit" value="Add Workplace" />

    <div class="gap gap-small"></div>
</div>

<div class="container" style="margin-bottom: -30px !important;width: 100%;margin: 0;">
    <br>
    <ol class="breadcrumb page-breadcrumb">
        <li><a href="/">Home</a>
        </li>
        <li><a href="#">Orders</a>
        </li>
        <li class="active">{{Auth::user()->name}}</li>
    </ol>
    <br>
    <div class="row" style="width: 100%">

        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 dashpanel hidden-xs">
            <div class="gap gap-small"></div>
            @include('customers.customer_dasboard')
            <div class="gap gap-big"></div>
        </div>
        <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 box" >
            <div class="pull-left">
                <h2>Vendor products</h2>	
            </div>

           
            <br><br><br>
            <div class="table-responsive">
                <table id="example" class="display nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Product Name</th>
                            <th>Vendor Name</th>
                            <th>Total Price</th>
                            <th>instant price</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vendorproducts as $key=>$products)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $products->name }}</td>
                                <td>{{ App\User::where('id',$products->user_id)->first()->name }}</td>
                               <td>{{ $products->price }}</td>
                               <td>{{ $products->instant_price }}</td>
                               <td>{{ $products->created_at }}</td>
                               <td>{{ $products->updated_at }}</td>
                               <td>
                                   <a href="{{ route('accounting',$products->user_id) }}" class="btn btn-success">accounting details</a>
                               </td>
                            </tr>
                        @endforeach
                      
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection
@section('script')
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.print.min.js"></script>
<script type="text/javascript">

$(document).ready(function () {
    $('#example').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});

// body...


$(".navtoggle").click(function () {
    $(".showtoggle").toggle("slow", function () {
        // Animation complete.
    });
});


</script>
@endsection
















