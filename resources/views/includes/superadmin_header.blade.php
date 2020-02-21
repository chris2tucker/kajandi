<body>
<div class="app">
    <header class="header header-fixed navbar">

      <div class="brand">
        <!-- toggle offscreen menu -->
        <a href="javascript:;" class="ti-menu off-left visible-xs" data-toggle="offscreen" data-move="ltr"></a>
        <!-- /toggle offscreen menu -->

        <!-- logo -->
        <a href="index.html" class="navbar-brand">
          <img src="{{asset('images/logo.png')}}" alt="">
        </a>
        <!-- /logo -->
      </div>

      <ul class="nav navbar-nav">
        <li class="hidden-xs">
          <!-- toggle small menu -->
          <a href="javascript:;" class="toggle-sidebar">
            <i class="ti-menu"></i>
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

      

        </li>
        
      </ul>
    </header>
   
    @include('includes.super_admin_sidbar') 
     <section class="main-content">
        <!-- content wrapper -->
        <div class="content-wrap">
          <!-- inner content wrapper -->
          <div class="wrapper">
            <div class="row">           
                <div class="col-md-12 top-error">
	                  @if (Session::has('message'))
                        <div class="alert alert-success">{{ Session::get('message') }}</div>
                    @endif
                    @if (Session::has('errormsg'))
                        <div class="alert alert-danger">{{ Session::get('errormsg') }}</div>
                    @endif
                    @if($errors->any())
                    <div class="alert alert-danger">{{$errors->first()}}</div>
                    @endif   
            </div>
        </div>