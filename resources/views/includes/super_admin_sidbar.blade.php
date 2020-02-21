<section class="layout">
      <!-- sidebar menu -->
      <aside class="sidebar offscreen-left">
        <!-- main navigation -->
        <nav class="main-navigation" data-height="auto" data-size="6px" data-distance="0" data-rail-visible="true" data-wheel-step="10">
          <p class="nav-title">MENU</p>
          <ul class="nav">
            <!-- dashboard -->
            <li>
              <a href="{{ URL::to('super_admin') }}">
                <i class="ti-home"></i>
                <span>Dashboard</span>
                
              </a>
            </li>
            <!-- /dashboard -->

            <!-- customizer -->
            <li>
              <a href="{{ URL::to('users') }}">
              <i class="fa fa-user" aria-hidden="true"></i>

                <span>Users</span>
              </a>
            </li>
      
            <li>
         
              <a href="{{ URL::to('role_view') }}" >
                <i class="fa fa-child"></i>
                 <span>Role</span>
              </a>
            </li>
        
            <!-- /customizer -->

            <!-- ui -->
            <li>
              <a href="{{ URL::to('view_permission') }}">
  				      <i class="fa fa-users" aria-hidden="true"></i>
                  <span>Permission</span>
              </a>
            </li>
            <li>
              <a href="{{ URL::to('assign_role_permission') }}">
  				      <i class="ti-layout-media-overlay-alt-2"></i>
                <span>Assign Permission</span>
              </a>
            </li>
            
            
             
          </ul>
        </nav>
      </aside>
      <!-- /sidebar menu -->
  