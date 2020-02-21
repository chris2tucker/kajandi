@extends('layouts.pagelayout')
@section('content')

<div class="container">
	<header class="page-header">
        <h1 class="page-title"></h1>
        <ol class="breadcrumb page-breadcrumb">
            <li><a href="/">Home</a>
            </li>
            <li><a href="#">Vendors</a>
            </li>
        </ol>
       
    </header>

    <div class="row">
        <div class="col-md-9">
                    <div class="row" id="data" data-gutter="15">
                    @foreach($vendors as $key)
                       <div class='col-md-4'>
                            <div class='product '>
                                <ul class='product-labels'></ul>
                                <div class='product-img-wrap'>
                                    @if($key->image)<img src="{{URL::to('/')}}/public/img/{{$key->image}}"  style="height: 180px;" class='product-img-primary'>@else <img src="{{URL::to('/')}}/public/images/default-avatar.jpg"  style="height: 180px;" class='product-img-primary'>  @endif

                                    @if($key->image)<img src="{{URL::to('/')}}/public/img/{{$key->image}}"  style="height: 180px;" class='product-img-alt'>@else <img src="{{URL::to('/')}}/public/images/default-avatar.jpg"  style="height: 180px;" class='product-img-alt'>  @endif   
                                </div>
                                <a class='product-link' href='{{url('vendors/'.$key->user_id)}}'></a>
                                <div class='product-caption'>
                                    <ul class='product-caption-rating'>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li><i class='fa fa-star'></i>
                                        </li>
                                    </ul>
                                    <h5 class='product-caption-title'>{{$key->vendorname}}</h5>
                                    
                                    </div>
                                    
                                </div>
                            </div>
                        
                        @endforeach
                    
                    
                	</div>

    	</div>
	</div>
</div>

@endsection