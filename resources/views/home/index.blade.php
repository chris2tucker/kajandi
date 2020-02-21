@extends('layouts.homelayout')
@section('content')
<style type="text/css">
    .banner-category-title {
    text-transform: uppercase;
    letter-spacing: 1px;
    font-size: 12px;
    margin-bottom: 3px;
    height: 70px;
    /* min-width: 139px; */
}
.banner-link {
    color: #fff;
}
.product-img-wrap {
    position: relative;
    height: 150px;
    overflow: hidden;
    margin: 20px;
    margin-bottom: 10px;
    min-height: 153px;
}
.banner-category-img {
    margin-bottom: 13px;
    width: 45px !important;
    display: inline-block !important;
    height: 90px !important;
}
.product-caption-title {
    font-weight: 400;
    font-family: 'Open Sans', arial, helvetica, sans-serif;
    margin-bottom: 6px;
    font-size: 14px;
    letter-spacing: 1px;
    height: 40px;
    overflow: hidden;
    line-height: 1.3em;
    color: #0d0d0d;
}
.banner-caption-top {
    padding: 10px;
}
</style>

<div class="container" style="width: 90%;">
            <div class="gap gap-small"></div>
            <div class="row row-sm-gap" data-gutter="10">
                <div class="col-md-3">
                    <div class="clearfix">
                        <ul class="overflow-auto dropdown-menu dropdown-menu-category dropdown-menu-category-hold dropdown-menu-category-sm">
                            @foreach($category as $key)

                            <li><a href="{{url('/category/'.$key->cat_slog)}}"><img src="{{URL::to('/')}}/public/img/{{$key->image}}" style="height: 31px;width: 31px;" class="dropdown-menu-category-icon" ><div>{{$key->cat_name}}</div></a>
                                <div class="dropdown-menu-category-section">
                                    <div class="dropdown-menu-category-section-inner">
                                        <div class="dropdown-menu-category-section-content">
                                            <div class="row">
                                                <div class="col-md-12">

                                                    <h5 class="dropdown-menu-category-title">{{$key->cat_name}}</h5>
                                                    <ul class="row dropdown-menu-category-list">

                                                    @foreach($sub_cate as $keys => $value)
                                                      @foreach($value as $k)
                                                      @if($key->id == $k->category_id)
                                                            <li class="col-md-4"><a href="{{url('subcategory/'.$k->sub_slog)}}">{{$k->Sub_name}}</a>
                                                                <p></p>
                                                            </li>
                                                     @endif
                                                     @endforeach
                                                    @endforeach
                                                    </ul>

                                                </div>
                                                
                                            </div>
                                        </div>

                                      <!--  <img class="dropdown-menu-category-section-theme-img" src="img/test_cat/2-i.png" alt="Image Alternative text" title="Image Title" style="right: -10px;" />-->
                                    </div>
                                </div>
                            </li>

                            @endforeach
                            
                        </ul>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="owl-carousel owl-loaded owl-nav-dots-inner owl-carousel-curved" data-options='{"items":1,"loop":true,"autoplay":true,"autoplayTimeout":2000,"autoplayHoverPause":true}'>
                        @foreach($banar_data as $key)
                        <div class="owl-item">

                            <div class="slider-item" style="background-image:url({{URL::to('/')}}/public/img/{{$key->banar_image}}); height:490px;">
                                <div class="slider-item-inner slider-item-inner-container">
                                    <div class="slider-item-caption-right slider-item-caption-white slider-item-caption-sm">
                                        <h4 class="slider-item-caption-title">{{$key->banar_text}}</h4>
                                        <p class="slider-item-caption-desc">100% Guarantee</p><a class="btn btn-lg btn-ghost btn-white" href="{{$key->banar_url}}">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>

            <div class="gap"></div>
            <div class="owl-carousel owl-loaded owl-nav-dots-inner owl-carousel-curved" data-options='{"items":3,"loop":true,"autoplay":true,"autoplayTimeout":2000,"autoplayHoverPause":true}'>
                @foreach($adv_sec_1 as $key)
               
               <div class="owl-item">
                    <div class="banner" style="background-image:url({{URL::to('/')}}/public/img/{{$key->img}});">
                        <a class="banner-link" href="{{url('product/'.$key->p_slog)}}"></a>
                        <div class="banner-caption-top">
                            <h5 class="banner-title">{{$key->name}}</h5>
                            <p class="banner-desc">{{$key->other_information}}</p>
                            <p class="vendor_name">Vendor: {{$key->vendorname}}</p>
                            <p class="vendor_price">Price: {{App\Http\COntrollers\HomeController::converter($key->price)}}</p>

                            <p class="banner-shop-now">Shop Now <i class="fa fa-caret-right"></i>
                            </p>
                        </div>
                       
                    </div>
                </div>
                @endforeach
                
            </div>


            <div class="gap"></div>
            <h3 class="widget-title">Today Featured</h3>
            <div class="owl-carousel owl-loaded owl-nav-out" data-options='{"items":5,"loop":true,"nav":true,"autoplay":true,"autoplayTimeout":2000,"autoplayHoverPause":true}'>

                @foreach($today_featured as $key)
                @php
                 $reviewCount=DB::table('review')->where('product_id','=',$key->product_id)->count();
                      $reviews=DB::table('review')->where('product_id','=',$key->product_id)->sum('rating');
              if($reviewCount>0){
                      $ratingss=(int)($reviews/$reviewCount);
                    }
                    else{
                      $ratingss=0;
                    }
                @endphp
                <div class="owl-item">
                    <div class="product  owl-item-slide">
                        <div class="product-img-wrap">
                            <img class="product-img" src="{{ asset('public/img/' . $key->today_image) }}" alt="Image Alternative text" title="Image Title" />
                        </div>
                        <a class="product-link" href="{{url('product/'.$key->slog)}}"></a>
                        <div class="product-caption">
                            <ul class="product-caption-rating">
                                @if($ratingss>0)
                                      @if($ratingss==1)
                                       <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li><i class='fa fa-star'></i>
                                        </li>
                                      @elseif($ratingss==2)
                                       <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li><i class='fa fa-star'></i>
                                        </li>
                                      @elseif($ratingss==3)
                                       <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li><i class='fa fa-star'></i>
                                        </li>
                                      @elseif($ratingss=4)
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
                                      @else
                                       <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class="rated"><i class='fa fa-star'></i>
                                        </li>
                                      @endif
                                       @else
                                        <li class=''><i class='fa fa-star'></i>
                                        </li>
                                        <li class=''><i class='fa fa-star'></i>
                                        </li>
                                        <li class=''><i class='fa fa-star'></i>
                                        </li>
                                        <li class=''><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        @endif
                            </ul>
                            <h5 class="product-caption-title">{{$key->name}}</h5>
                            <div class="product-caption-price"><span class="product-caption-price-new">{{App\Http\Controllers\HomeController::converter($key->price)}}</span>
                          

                            </div>
                        </div>
                    </div>

                </div>
                @endforeach
            </div>

            </div>

             <div class="gap"></div>
        <div class="container" style="padding: 0;">
            

            <div class="gap"></div>
            <div class="owl-carousel owl-loaded owl-nav-dots-inner owl-carousel-curved" data-options='{"items":2,"loop":true,"autoplay":true,"autoplayTimeout":2000,"autoplayHoverPause":true}'>
                @foreach($adv_sec_2 as $key)
                <div class="owl-item">
                    <div class="banner" style="background-image:url({{URL::to('/')}}/public/img/{{$key->img}})">
                    <a class="banner-link" href="{{url('product/'.$key->p_slog)}}">
                        <div class="banner-caption-left">
                            <h5 class="banner-title">{{$key->name}}</h5>
                            <p class="banner-desc">{{$key->other_information}}</p>
                            <p class="vendor_name">Vendor: {{$key->vendorname}}</p>
                            <p class="vendor_price">Price: {{App\Http\Controllers\HomeController::converter($key->price)}}</p>
                            <p class="banner-shop-now">Shop Now <i class="fa fa-caret-right"></i>
                            </p>
                        </div>
                       </a>
                        
                    </div>
                </div>
                @endforeach
                
            </div>

            <div class="gap"></div>
        <div class="container" style="padding: 0;">
            <h3 class="widget-title-lg">Shop by Category</h3>
            <div class="row row-sm-gap" data-gutter="15">
                @foreach($catagories as $key)
                @php

                $countproduct = DB::table('vendorproduct')->where('category',$key->id)->where('product_status','1')->count(); @endphp
                <div class="col-md-2">

                    <a class="banner-category" href="{{url('category/'.$key->slog )}}" style="    padding: 0;padding-top: 5px;">
                        <img class="banner-category-img" src="{{URL::to('/')}}/public/img/{{$key->image}}" alt="Image Alternative text" title="Image Title" style="height: 150px;width: 150px !IMPORTANT;" />
                        <h5 class="banner-category-title catagory_home_title">{{ $key->name }} </h5>
                        <span>Total Products : {{$countproduct}}</span>
                    </a>
                </div>
                @endforeach
            </div>
            
        </div>
        <div class="gap"></div>
</div>

@endsection