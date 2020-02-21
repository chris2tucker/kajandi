<ul class="nav nav-pills nav-stacked" role="tablist">

          <li class=" {{ request()->is('customers/dashboard') ? 'active' : '' }}"><a href="{{url('/customers/dashboard')}}">Dashboard</a></li>
          @if(Auth::user()->user_type=='Customer')
          <li class="{{ request()->is('customers/profile') ? 'active' : '' }}" ><a href="{{url('/customers/profile')}}">Profile</a></li>
          @endif
          <!-- <li class="{{ request()->is('vendorproducts') ? 'active' : '' }}"><a href="{{ route('vendorproduct') }}">Vendor products</a></li>-->
          <li class="{{ request()->is('customers/orders') ? 'active' : '' }}"><a href="{{url('/customers/orders')}}">Orders</a></li>
          <li class="{{ request()->is('customers/report') ? 'active' : '' }}"><a href="{{url('/customers/report')}}">Report</a></li>
          <li class="{{ request()->is('customers/accounting') ? 'active' : '' }}"><a href="{{url('/customers/accounting')}}">Accounting</a></li>
          <li class="{{ request()->is('customers/wallet') ? 'active' : '' }}"><a href="{{url('/customers/wallet')}}">Wallet</a></li>
          <li class="{{ request()->is('customers/workplace') ? 'active' : '' }}"><a href="{{url('/customers/workplace')}}">WorkPlace</a></li>
              <li class="{{ request()->is('customers/dueandoutstanding') ? 'active' : '' }}"><a href="{{url('/customers/dueandoutstanding')}}">Due and Oustanding Payment</a></li>

          <li class="{{ request()->is('customers/addvendor') ? 'active' : '' }} "><a class="navtoggle" style="cursor: pointer;">Credit Vendors <i class="fa fa-sort-desc" aria-hidden="true"></i></a>
              <ul class="showtoggle" style="display: none; margin-left: 50px; margin-top: 1px;  margin-left: -10px; list-style-type: none;">
               <!-- <li style="width: 100%; margin-bottom: 20px"><a href="{{url('/customers/addvendor')}}" class="showcolor" style="padding: 5px; text-decoration: none;">Add Vendors</a></li>-->
               <li style="width: 100%; margin-bottom: 20px"><a href="{{url('/customer/vendors/list')}}" class="showcolor" style="padding: 5px; text-decoration: none;">Add Vendors</a></li>
                <li style="width: 100%;margin-bottom: 20px"><a href="{{url('/customers/addsupplier')}}" class="showcolor" style="padding: 5px; text-decoration: none;">My Vendor Products</a></li>
                <li style="width: 100%;"><a href="{{url('/favorite/credit/vendors')}}" class="showcolor" style="padding: 5px; text-decoration: none;">Favorite and credit vendors</a></li>
              </ul>
            </li>
            <li class="{{ request()->is('create/rfq') ? 'active' : '' }}"><a class="rfq" style="cursor: pointer;">RFQ <i class="fa fa-sort-desc" aria-hidden="true"></i></a>
              <ul class="showrfq" style="display: none; margin-left: 50px; margin-top: 1px;  margin-left: -10px; list-style-type: none;">
                <li style="width: 100%; margin-bottom: 20px"><a href="{{url('/create/rfq')}}" class="showcolor" style="padding: 5px; text-decoration: none;">Create Request for Quote (RFQ)</a></li>
                <li style="width: 100%;"><a href="{{url('/customers/rfq')}}" class="showcolor" style="padding: 5px; text-decoration: none;">View Quotations</a></li>
              </ul>
            </li>
        </ul>