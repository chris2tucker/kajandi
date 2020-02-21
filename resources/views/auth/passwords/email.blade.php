
@include('includes.head')

@include('includes.headerlogin')
<script type="text/javascript">
      $(document).ready(function(){
       
        setTimeout(function() {
          $('.error_message').fadeOut('fast');
        }, 5000); // <-- time in milliseconds

        
    });

    </script>

<html>
<head>
    <title>Login - Ecommerce</title>
</head>

<body class="bg-primary">

  <div class="cover" style="background-image: url('public/images/cover3.jpg')"></div>

  <div class="overlay bg-primary"></div>

  <div class="center-wrapper">
    <div class="center-content">
      <div class="row no-m">
        <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
          <section class="panel bg-white no-b">
            <ul class="switcher-dash-action">
              <li style="width: 100%;"><a href="#" class="selected">Reset Password</a>
              </li>
             
            </ul>
            <div class="p15">
              @if (Session::has('message'))
                        <div class="alert alert-success success_message">{{ Session::get('message') }}</div>
                        
                 @endif
                @if (Session::has('errormsg'))
                        <div class="alert alert-danger error_message">{{ Session::get('errormsg') }}</div>
                    @endif
                    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            

                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="Enter Email">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                    

                        

                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">
                                    Send Reset Link
                                </button>

                                
                            </div>
                        </div>
                    </form>
            </div>
          </section>
          <p class="text-center">
            Copyright &copy;
            <span id="year" class="mr5"></span>
            <span>Ecommerce</span>
          </p>
        </div>
      </div>

    </div>
  </div>
  <script type="text/javascript">
    var el = document.getElementById("year"),
      year = (new Date().getFullYear());
    el.innerHTML = year;
  </script>
</body>

</html>















