@extends('layouts.pagelayout')
@section('content')
<div class="container" style="width: 90%;">
	<header class="page-header">
        <h1 class="page-title">Contact us</h1>
        <ol class="breadcrumb page-breadcrumb">
            <li><a href="{{url('/')}}">Home</a>
            </li>
            <li><a href="{{url('page/contact_us')}}">Contact us</a>
            </li>
        </ol>
        <ul class="category-selections clearfix">
           
           
        </ul>
    </header>

    <div class="row">
    	<div class="col-md-3">
                    <aside class="category-filters">
                        <div class="category-filters-section">
                            <h3 class="widget-title-sm">Contact Info</h3>
                          </div>
                        </aside>
                </div>
        <div class="col-md-9">
                    <div class="product">
                      <form action="{{url('contact_us')}}" method="POST" >
                        {{csrf_field()}}
                        <div class="form-group">
                                <label>Name </label>
                                <input type="text" class="form-control" name="name" value="{{old('name')}}" required placeholder="Enter Your Name" autofocus>

                            </div>
                             <div class="form-group">
                                <label>Email </label>
                                <input type="email" class="form-control" name="email" value="{{old('email')}}" required placeholder="Enter Your Email" autofocus>

                            </div>
                             <div class="form-group">
                                <label>Message </label>
                                <textarea name="message" rows="10" class="form-control" required></textarea>
                              

                            </div>
                            <div class="form-group">
                              <input class="btn btn-primary" id="submit" type="submit" value="Send Message" />
                            </div>
                      </form>
                    </div>
                </div>
                        
                    
                	</div>

    	</div>

@endsection