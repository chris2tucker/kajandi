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
    .vendor-image {
      border-radius: 66px;
      height: 127px;
    }
    .vendor-name {
  margin-left: -8px;
  font-size: 22px;
  margin-top: 4px;
}
.vendor-email {
  font-size: 30px;
  margin: 0 -47px 0px;
}
.vendor-phone {
  font-size: 20px;
  margin: 0 -10px 0 -6px;
}

.Approved {
  margin: 0 -23px;
  color: black;
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
                <h2></h2>	
            </div>

           
           <br><br><br><br>
            <div class="container">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                       <img class="vendor-image" style="width: 130px;" src="{{ asset('profile/'.$user->image) }}"> 
                       <div class="vendor-name">{{ $user->name }}</div>
                       <div class="vendor-email">{{ $user->email }}</div>
                       <div class="vendor-phone">{{ $user->phone }}</div>
                       <div class="vendor-status">
                            @if($user->status == 1)
                            <h2 class="Approved">Approved</h2>
                            @else
                                <h2>penning</h2>
                            @endif
                       </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>
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

@endsection
















