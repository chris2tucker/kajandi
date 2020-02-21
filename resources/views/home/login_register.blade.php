@extends('layouts.pagelayout')
@section('content')

<div class="container">
            <div class="row">
                <div class="col-md-12">
                    <header class="page-header">
                        <h1 class="page-title">Register Customer</h1>
                        @if(Session::has('status'))
                            <p class="alert alert-success alert-dismissable fade in">{{ Session::get('status') }}</p>
                            @endif
                            @include('layouts.errors')

                    </header>
                    <div class="box-lg">
                        <div class="row" data-gutter="60">
                           <div class="col-md-4">
                        <form method="POST" action="{{ url('signup') }}" aria-label="{{ __('Register') }}">
                             {{ csrf_field() }}
                      
                            <div class="form-group">
                                <label>Company name</label>
                                <input type="text" class="form-control" name="company_name" value="{{ old('company_name') }}" autofocus>

                            </div>
                            <div class="form-group">
                                <label>About Company</label>
                                <input class="form-control" type="text" name="about_company" value="{{ old('about_company') }}" />
                            </div>
                            <div class="form-group">
                                <label>Company Description</label>
                                <textarea class="form-control" name="company_description" value="{{ old('company_description') }}" ></textarea>
                            </div>
                            <div class="form-group">
                                <label>Website-URL</label>
                                <input class="form-control" type="text" name="website_url" value="{{ old('website_url') }}" />
                            </div>
                            <div class="form-group">
                                <label>CAC Number</label>
                                <input class="form-control" type="text" name="cac_number" value="{{ old('cac_number') }}" />
                            </div>
                            <div class="form-group">
                                <label>Type of Business</label>
                                <input class="form-control" type="text" name="type_of_business" value="{{ old('type_of_business') }}" />
                            </div>
                    </div>
                    <div class="col-md-4">
                            <div class="form-group">
                                <label>Years of Existence</label>
                                <input class="form-control" type="text" name="year_of_existence" value="{{ old('year_of_existence') }}" />
                            </div>
                            <div class="form-group">
                                <label>Phone of MD/Chairman</label>
                                <input class="form-control" type="text" name="phone_of_MD_Chairman" value="{{ old('phone_of_MD_Chairman') }}" />
                            </div>
                            <div class="form-group">
                                <label>Email of MD/Chairman</label>
                                <input class="form-control" type="text" name="email_of_MD_Chairman" value="{{ old('email_of_MD_Chairman') }}" />
                            </div>
                            <div class="form-group">
                                <label>Phone of Contact Person</label>
                                <input class="form-control" type="text" name="phone_of_contact_person" value="{{ old('phone_of_contact_person') }}" />
                            </div>
                            <div class="form-group">
                                <label>Email of Contact Person</label>
                                <input class="form-control" type="text" name="email_of_contact_person" value="{{ old('email_of_contact_person') }}" />
                            </div>
                            <div class="form-group">
                                <label>Company Rating</label>
                                <input class="form-control" type="text" name="company_rating" value="{{ old('company_rating') }}" />
                            </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">

                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                            </div>
                            <div class="form-group">
                                <label>Passwprd</label>
                                <input type="password" class="form-control" name="password">
                            </div>
                            <div class="form-group">
                                <label>Confirm Passwprd</label>
                                <input type="password" class="form-control" name="password_confirmation">
                            </div>
                            <!-- <div class="checkbox">
                                <label>
                                    <input class="i-check" type="checkbox" />Sign Up to the Newsletter</label>
                            </div> -->
                         
                                    <input class="btn btn-primary" type="submit" value="Create Account" />
                                <?php echo Form::close(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="gap gap-small"></div>

@endsection