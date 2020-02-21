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

<div class="container" style="margin-bottom: -30px !important">
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

            <div class="pull-right">
                <button class="btn btn-primary popup-text" href="#workplace-dialog" data-effect="mfp-move-from-top">Add Work Place</button>
            </div>
            <br><br><br>
            <div class="table-responsive">
                <table id="example" class="display nowrap" style="width:100%">
                    <thead>
                        <tr>
                           
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vendorproducts as $key=>$products)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $products->name }}</td>
                                <td><img src="{{URL::to('/')}}/public/img/{{$value->image}}" style="height: 50px;width: 50px;"></td>
                                <td>f</td>
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
    $('.addworkplace').click(function () {
        val = $('.name').val();
        if (val.length > 0) {
            url = ajaxurl + 'addworkplace';
            $.get(
                    url,
                    {val: val},
                    function (data) {
                        location.reload();
                    });
        }
    });
$(".orderworkplace").change(function () {
    var id = $(this).attr('id');
    var workplace_id = $(".workplace-id-" + id).val();
    $.ajax({
        type: 'GET',
        url: "{{ route('update-order-workplace') }}",
        data: {
            "id": id,
            "workplace_id": workplace_id
        }, success: function (data) {
            if (data == 1) {
                alert("Successfully Edit Workstation.");
            } else {
                alert("Workstation Edit Fail.");
            }
        }
    });
});

$(".navtoggle").click(function () {
    $(".showtoggle").toggle("slow", function () {
        // Animation complete.
    });
});
$(".rfq").click(function() {
  $( ".showrfq" ).toggle( "slow", function() {
    // Animation complete.
  });
});
$('.deliverystatus').change(function () {
    orderid = $(this).attr('id');
    value = $(this).val();
    url = ajaxurl + 'deliverystatus';
    $.get(
            url,
            {
                value: value,
                orderid: orderid},
            function (data) {
            });
})

</script>
@endsection
















