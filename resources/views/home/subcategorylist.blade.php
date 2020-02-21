@extends('layouts.pagelayout')
@section('content')

<div class="container">
	<header class="page-header">
        <h1 class="page-title">{{$getcategory->name}}</h1>
        <ol class="breadcrumb page-breadcrumb">
            <li><a href="/">Home</a>
            </li>
            <li><a href="{{url('subcategorylist/'.$getcategory->slog)}}">{{$getcategory->name}}</a>
            </li>
        </ol>
        <ul class="category-selections clearfix">
            <li>
                <a class="fa fa-th-large category-selections-icon active" href="#"></a>
            </li>
            <li>
                <a class="fa fa-th-list category-selections-icon" href="#"></a>
            </li>
            <li><span class="category-selections-sign">Sort by :</span>
                <select class="category-selections-select">
                    <option selected="">Newest First</option>
                    <option>Best Sellers</option>
                    <option>Trending Now</option>
                    <option>Best Raited</option>
                    <option>Price : Lowest First</option>
                    <option>Price : Highest First</option>
                    <option>Title : A - Z</option>
                    <option>Title : Z - A</option>
                </select>
            </li>
            <li><span class="category-selections-sign">Items :</span>
                <select class="category-selections-select">
                    <option>9 / page</option>
                    <option selected="">12 / page</option>
                    <option>18 / page</option>
                    <option>All</option>
                </select>
            </li>
        </ul>
    </header>

  <div class="row">
    <div class="col-md-12">
        <div class="product" style="min-height: 500px;">
            <div class="row" style="margin-top: 20px;">
                
            
            @if(count($getsubcategory)>0)
            @foreach($getsubcategory as $sub)
                <div class="col-md-3">
                    <li style="list-style: none;"><i class="fa fa-arrow-right " aria-hidden="true"></i>
                        <a href="{{url('subcategory/'.$sub->slog)}}" title="">{{$sub->name}}</a></li>
                </div>
            @endforeach
            @endif
            </div>
        </div>
    </div>
      
  </div>

                
                        
                    
   
                    
                	</div>


@endsection