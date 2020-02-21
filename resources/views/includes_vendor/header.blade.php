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
    <style>
      .drop {
        width: 241px;
        overflow-y: scroll;
        height: 400px;
      }
      .div-bell {
        margin-top: 17px;
        margin-left: 22px;
        background: white;
      }
      .count {
  position: absolute;
  top: 5px;
  border: 1px solid black;
  background: black;
  color: white;
  border-radius: 21px;
  padding-left: 4px;
  padding-right: 4px;
  padding-top: 1px;
  padding-bottom: 1px;
  left: 28px;
  font-size: 9px;
}

    </style>
<div class="app">
    <header class="header header-fixed navbar">

      <div class="brand">
        <!-- toggle offscreen menu -->
      
        <a href="javascript:;" class="ti-menu off-left visible-xs" data-toggle="offscreen" data-move="ltr" ></a>
        <!-- /toggle offscreen menu -->

        <!-- logo -->
        <a href="{{URL::to('/home')}}" class="navbar-brand">
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
            <form action="{{ url('vendors/companyguidelines') }}" role="search">
             {{ csrf_field() }}
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
         <li class="dropdown ">
          <a href="javascript:;" data-toggle="dropdown">
            
            
           
             <span class="ti-bell" style="font-size: 20px;"></span><span class="count">{{ $notifications->count() }}</span>
          </a>
          <ul class="dropdown-menu animated zoomIn drop">

            <div class="div-bell mess">
              
            </div>
          @foreach($notifications as $nofify)
        <div class="div-bell">
           <li class="bell">{{ $nofify->notification }}</li>
         <hr>
           </div>
            @endforeach
          </ul>

        </li>
        <script>
          $(document).ready(function(){
            setInterval(function() {
             
              var id='{{Auth::user()->id}}';
    $.ajax({
      url:'{{url('unread/messages')}}',
      method:'GET',
      data:{user:id},
     
      success:function(data){
        console.log(data);
        $('.messages').remove();
        $('.mess').append(data.table_data);
        var counts='{{$notifications->count()}}';
        $('.count').text(Number(counts)+Number(data.counts));
      }
    })
}, 30 * 1000);
          })
        </script>
       
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
            @php
            $user=Auth::user()->id;
            $vendors=App\vendors::where('user_id','=',$user)->first();
           
            @endphp
            @if($vendors)
           <img class="user_img" src="{{asset('img/products/'.$vendors->image)}}">
            @endif
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

   
    @include('includes_vendor.sidebar')
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
            <div class="row" style="margin-top: 40px;">           
                <div class="col-md-12 top-error">
	                  @if (Session::has('status'))
                        <div class="alert alert-success success_message">{{ Session::get('status') }}</div>
                        
                    @endif
                    @if (Session::has('errormsg'))
                        <div class="alert alert-danger error_message">{{ Session::get('errormsg') }}</div>
                    @endif
                    @if($errors->any())
                     @include('layouts.errors')
                    @endif   
                  @guest
                  @else
                  @if(Auth::user()->verify==0)
                  <div class="alert alert-danger" style="text-align: center">
                        Please verify your account! We already sent email
                      </div>
                  @endif
                  @if(Auth::user()->status==0)
                  <div class="alert alert-danger" style="text-align: center;">
                    Your Account is yet to be verified by the Administrator. You cannot add products now. Your Products can only be displayed on our site when your accoount is verified.
                    
                  </div>
                  @endif
                  @endguest
            </div>
        </div>

