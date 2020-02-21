@extends('layouts.homelayout')
@section('content')
<div class="container">
	
	<header class="page-header">
        <h1 class="page-title">Terms & Conditions</h1>
        <ol class="breadcrumb page-breadcrumb">
            <li><a href="/">Home</a>
            </li>
            <li><a href="{{url('/customer/terms/conditions')}}">Terms & Conditions</a>
            </li>
        </ol>
        
    </header>
	<div class="row">
		<div class="col-sm-12" style="min-height: 500px;background-color: #fff;padding: 50px;margin-bottom: 20px;">
			{!!$customerterms->terms!!}
		</div>
		
	</div>
	</div>
@endsection