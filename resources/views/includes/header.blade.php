<body>
<script>

function switchVisible() {
  
            if (document.getElementById('big_image')) {

                if (document.getElementById('big_image').style.display == 'none') {
                    document.getElementById('big_image').style.display = 'block';
                    document.getElementById('small_image').style.display = 'none';
                }
                else {
                    document.getElementById('big_image').style.display = 'none';
                    document.getElementById('small_image').style.display = 'block';
                }
            }
}
  


    </script>
<div class="app">
    <header class="header header-fixed navbar">

      <div class="brand">
        <!-- toggle offscreen menu -->
      
        <a href="javascript:;" class="ti-menu off-left visible-xs" data-toggle="offscreen" data-move="ltr" ></a>
        <!-- /toggle offscreen menu -->

        <!-- logo -->
         <a href="{{URL::to('admin/index')}}" class="navbar-brand">
         <img id="big_image" class="logo_image" src="{{asset('img/logo-2.png')}}" alt="" style="height: 40px;width: 40px;margin-left: 50px;">
          <img id="small_image" class="logo_image" src="{{asset('images/test.jpg')}}" alt="" style="display: none">

        </a>
        <!-- /logo -->
      </div>

      <ul class="nav navbar-nav">
        <li class="hidden-xs">
          <!-- toggle small menu -->
          <a href="javascript:;" class="toggle-sidebar" onclick="switchVisible();">
            <i class="ti-menu" ></i>
          </a>
          <!-- /toggle small menu -->
        </li>
        <li class="header-search">
          <!-- toggle search -->
          <a href="javascript:;" class="toggle-search">
            <i class="ti-search"></i>
          </a>
          <!-- /toggle search -->
          <div class="search-container">
            <form role="search">
              <input type="text" class="form-control search" placeholder="type and press enter">
            </form>
          </div>
        </li>
       
      </ul>

      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown" style="margin-top: 30px">
                            <form action="homelayout_submit" method="get" accept-charset="utf-8">
                            {{csrf_field()}}
                            <select id="currency">
                                @if(Session::has('currency'))
                                @if(Session::get('currency')=='Naira')
                              <option value="Naira" selected>Naira</option>
                              <option value="Dollar" >Dollar</option>
                              <option value="Euro" >Euro</option>
                              <option value="Yen" >Yen</option>
                              @elseif(Session::get('currency')=='Dollar')
                              <option value="Dollar"selected>Dollar</option>
                              <option value="Naira" >Naira</option>
                             
                              <option value="Euro" >Euro</option>
                              <option value="Yen" >Yen</option>
                              @elseif(Session::get('currency')=='Euro')
                              <option value="Euro"selected>Euro</option>
                              <option value="Naira" >Naira</option>
                              <option value="Dollar" >Dollar</option>
                             
                              <option value="Yen" >Yen</option>
                              @elseif(Session::get('currency')=='Yen')
                              <option value="Yen" selected>Yen</option>
                              <option value="Naira" >Naira</option>
                              <option value="Dollar" >Dollar</option>
                              <option value="Euro" >Euro</option>
                             
                              @endif
                              @else
                              <option value="Naira" selected>Naira</option>
                              <option value="Dollar" >Dollar</option>
                              <option value="Euro" >Euro</option>
                              <option value="Yen" >Yen</option>
                              @endif
                            </select>
                            </form>
                        </li>
                         <script >
            $(document).ready(function(){
                $("#currency").change(function(){
                var curr=$(this).val();
                $.ajax({
                     url:"{{ url('currency') }}",
                     method:'GET',
                     data:{currency:curr},
                     dataType:'json',
                     success:function(data)
                     {console.log(data);
                        if(data=='yes'){
                            location.reload();
                        }
                     }
                })
            })
            });
        </script>
        <li class="dropdown ">
          <a href="javascript:;" data-toggle="dropdown">
            
            <?php 

            $messages=App\message::where('isread','=',0)->count();
             ?>
           
             <span class="ti-bell" style="font-size: 20px;"></span><span class="count">{{ $messages}}</span>
          </a>
          <ul class="dropdown-menu animated zoomIn drop">
            <div class="div-bell mess">
              
            </div>
          
        <div class="div-bell">
           <li class="bell">{{ $messages }} New Messages </li>
         <hr>
           </div>
            
          </ul>

        </li>
        
      <li class="dropdown ">
          <a href="javascript:;" data-toggle="dropdown">
            <img class="user_img" src="{{asset('public/images/avatar.jpg')}}">
            
            Hi {{Auth::User()->name}}
             <span class="caret"></span>
          </a>
          <ul class="dropdown-menu animated zoomIn">
         
           <li>
                      <a href="{{ route('logout') }}"
                              onclick="event.preventDefault()
                                document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                      </li>

            
          </ul>

        </li>
        
      </ul>
    </header>

   
    @include('includes.sidebar')
    <script type="text/javascript">
      $(document).ready(function(){
        setTimeout(function() {
          $('.success_message').fadeOut('fast');
        }, 5000); // <-- time in milliseconds

        setTimeout(function() {
          $('.error_message').fadeOut('fast');
        }, 5000); // <-- time in milliseconds

        setTimeout(function() {
          $('.error_any').fadeOut('fast');
        }, 5000);
    });

    </script>
     <section class="main-content">
        <!-- content wrapper -->
        <div class="content-wrap">
          <!-- inner content wrapper -->
          <div class="wrapper">
            <div class="row">           
                <div class="col-md-12 top-error">
	                  @if (Session::has('status'))
                        <div class="alert alert-success success_message">{{ Session::get('status') }}</div>
                        
                    @endif
                    @if (Session::has('errormsg'))
                        <div class="alert alert-danger error_message">{{ Session::get('errormsg') }}</div>
                    @endif
                    @if($errors->any())
                    <div class="alert alert-danger error_any"> @include('layouts.errors')</div>
                    @endif   
            </div>
        </div>

