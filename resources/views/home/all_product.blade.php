@extends('layouts.pagelayout')
@section('content')

<div class="container">
	<header class="page-header">
        <h1 class="page-title"></h1>
        <ol class="breadcrumb page-breadcrumb">
            <li><a href="/">Home</a>
            </li>
            <li><a href="#">All Products</a>
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
    	<div class="col-md-3">
                    <aside class="category-filters">
                        <div class="category-filters-section">
                            <h3 class="widget-title-sm">Category</h3>
                            <input type="hidden" id="category" value="">
                            <input type="hidden" id="category_level" value="category">
                            <ul class="cateogry-filters-list">
                                @foreach($getcategory as $key)
                                    <li><a href="{{url('/category/'.$key->slog)}}">{{$key->name}}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="category-filters-section">
                            <h3 class="widget-title-sm">Sub Category</h3>
                            <input type="hidden" id="category" value="">
                            <input type="hidden" id="category_level" value="category">
                            <ul class="cateogry-filters-list">
                                @foreach($getsubcategory as $key)
                                    <li><a href="{{url('/subcategory/'.$key->slog)}}">{{$key->name}}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                            <div class="category-filters-section">
                                <h3 class="widget-title-sm">Price</h3>
                                <input type="text" id="price-slider" />
                            </div>

                        <form>
                            @if(!empty($manufacturer))
                            <div class="category-filters-section">
                                <h3 class="widget-title-sm">Manufacturer</h3>
                                <?php echo $manufacturer; ?>
                            </div>
                            @endif
                            @if(!empty($model))
                            <div class="category-filters-section">
                                <h3 class="widget-title-sm">Model</h3>
                                <?php echo $model; ?>
                            </div>
                            @endif
                            @if(!empty($condition))
                            <div class="category-filters-section">
                                <h3 class="widget-title-sm">Condition</h3>
                                <?php echo $condition; ?>
                            </div>
                            @endif
                            @if(!empty($source))
                            <div class="category-filters-section">
                                <h3 class="widget-title-sm">Source</h3>
                                <?php echo $source; ?>
                            </div>
                            @endif
                            @if(!empty($addon))
                            <div class="category-filters-section">
                                <h3 class="widget-title-sm">Addon</h3>
                                <?php echo $addon; ?>
                            </div>
                            @endif
                        </form>
                    </aside>
                </div>
        <div class="col-md-9">
                    <div class="row" id="data" data-gutter="15">
                        <?php echo $view ?>
                        
                    
                    
                	</div>

    	</div>
	</div>
</div>

@endsection