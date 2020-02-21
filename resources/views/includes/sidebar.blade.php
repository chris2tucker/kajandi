<style>
  .slimScrollBar{
    width: 15px !important;
  }
</style>
<section class="layout">
      <!-- sidebar menu -->
      <aside class="sidebar offscreen-left">
        <!-- main navigation -->
        <nav  class="main-navigation" data-height="auto" data-size="6px" data-distance="0" data-rail-visible="true" data-wheel-step="10" >
          <p class="nav-title">MENU</p>
          <ul class="nav">
            <!-- dashboard -->
            <li>
              <a href="{{URL::to('admin/index')}}">
                <i class="ti-home"></i>
                <span>Dashboard</span>
                
              </a>
            </li>
              <li class="">
                    <a href="javascript:void(0)" class="active">
                      <i class="toggle-accordion"></i>
                      <i class="ti-window"></i>
                      <span>Content</span>
                    </a>
                    <ul class="sub-menu" style="display: none;">
                      <li>
                        <a href="{{ url('admin/category') }}">
                         <span>Category</span>
                        </a>
                      </li>
                       <li>
                        <a href="{{ url('admin/units') }}">
                         <span>Units</span>
                        </a>
                      </li>
                      <li>
                        <a href="{{ url('admin/subcategory') }}">
                          <span>SubCategory</span>
                        </a>
                      </li>
                      <li>
                        <a href="{{ url('admin/today_fetured') }}">
                          <span>Today Featured</span>
                        </a>
                      </li>
                      <li>
                        <a href="{{ url('admin/tags') }}">
                          <span>Popular tags</span>
                        </a>
                      </li>
                      <li>
                        <a href="{{ url('admin/banner') }}">
                          <span>Banner</span>
                        </a>
                      </li>
                      <li>
                        <a href="{{ url('admin/adv_sec_1/') }}">
                          <span>Adv Section 1</span>
                        </a>
                      </li>
                      <li>
                        <a href="{{ url('admin/adv_sec_2') }}">
                          <span>Adv Section 2</span>
                        </a>
                      </li>
                       <li>
                        <a href="{{ url('admin/social') }}">
                          <span>Social Links</span>
                        </a>
                      </li>
                       <li>
                        <a href="{{ url('admin/currency') }}">
                          <span>Currency rates</span>
                        </a>
                      </li>

                      
                    </ul>
              </li>
        
           
               <li class="">
                  <a href="javascript:void(0)" class="active">
                    <i class="toggle-accordion"></i>
                    <i class="ti-window"></i>
                    <span>Products</span>
                  </a>
                  <ul class="sub-menu" style="display: none;">
                    <li>
                      <a href="{{ url('admin/manufacture') }}">
                       <span>Manufacture</span>
                      </a>
                    </li>
                     <li>
                      <a href="{{ url('manufacture/approve/page') }}">
                        @php
                        $approvemenu=App\editmanufecturer::all();
                        @endphp
                        <span>Approve Manufecturer<div class="badge badge-top bg-danger animated flash">
                  
                    @if(count($approvemenu)>0)
                      <span>{{count($approvemenu)}}</span>
                      @else
                      <span>0</span>
                    @endif
            </div></span>
                      </a>
                    </li>
                    <li>
                      <a href="{{ url('admin/model') }}">
                       <span>Model</span>
                      </a>
                    </li>
                    <li>
                      <a href="{{ url('model/approve/page') }}">
                        @php
                        $approvemodel=App\editmodel::all();
                        @endphp
                        <span>Approve Model<div class="badge badge-top bg-danger animated flash">
                  
                    @if(count($approvemodel)>0)
                      <span>{{count($approvemodel)}}</span>
                      @else
                      <span>0</span>
                    @endif
            </div></span>
                      </a>
                    </li>
                    <li>
                      <a href="{{ url('admin/condition') }}">
                       <span>Condition</span>
                      </a>
                    </li>
                    
                    <li>
                      <a href="{{ url('admin/vendorproduct') }}">
                       <span>Vendor Products</span>
                      </a>
                    </li>
                    <li>
                      <a href="{{ url('admin/lowstock') }}">
                        @php
                        $vendors=App\vendorproduct::where('stock_count','<',50)->count();
                        @endphp
                        <span>Lowstock Products<div class="badge badge-top bg-danger animated flash">
                  
                    @if($vendors>0)
                      <span>{{$vendors}}</span>
                      @else
                      <span>0</span>
                    @endif
            </div></span>
                      </a>
                    </li>
                    <li>
                      <a href="{{ url('admin/inventory') }}">
                        <span>Inventory</span>
                      </a>
                    </li>
                    <li>
                      <li>
                      <a href="{{ url('admin/promotion') }}">
                        <span>promotion</span>
                      </a>
                    </li>
                    <li>
                      <a href="{{ url('admin/aprove_reject_product') }}">
                        @php
                        $vendors=App\vendorproduct::where('product_status','0')->count();
                        @endphp
                        <span>Aprove and Reject<div class="badge badge-top bg-danger animated flash">
                  
                    @if($vendors>0)
                      <span>{{$vendors}}</span>
                      @else
                      <span>0</span>
                    @endif
            </div></span>
                      </a>
                    </li>
                    <li>
                      <a href="{{ url('admin/editApprove') }}">
                        <span>Aprove and Reject For Update Products
                        <div class="badge badge-top bg-danger animated flash">
                  @php 
                  $editProduct =DB::table('edit_product_history')
                       ->join('vendorproduct','vendorproduct.id','=','edit_product_history.product_id')
                       ->where('vendorproduct.edit_product_staus','no')
                       ->count();
                    @endphp
                    @if($editProduct)
                      <span>{{$editProduct}}</span>
                      @else
                      <span>0</span>
                    @endif
            </div></span>
                      </a>
                    </li>
                  
                       <li>
                        <a href="{{ route('admin.bank.approve') }}">
                          <span>Bankdetails Approve</span>
                        </a>
                      </li>
                       <li>
                        <a href="{{ route('admin.user.approve') }}">
                          <span>Userinformation Approve</span>
                        </a>
                      </li>
                      
                    
             
                  </ul>
            </li>
        <li>
          <a href="{{URL::to('admin/products/list')}}" title=""><i class="fa fa-users" aria-hidden="true"></i>Product list</a>
        </li>
            <li>
              <a href="{{ URL::to('admin/vendors') }}">
  				      <i class="fa fa-users" aria-hidden="true"></i>
                  <span>Vendors<div class="badge badge-top bg-danger animated flash">
                  @php 
                  $counter=0;
                  $vendors=App\vendors::all();
                  foreach($vendors as $vend){
                  $user=App\User::where('id','=',$vend->user_id)->first();
                  if($user){
                  if($user->status==0){
                  $counter=$counter+1;
                }
              }
                }
                    @endphp
                    @if($counter)
                      <span>{{$counter}}</span>
                      @else
                      <span>0</span>
                    @endif
            </div></span>
              </a>
            </li>
            <li>
              @php
              $getcustomer = App\User::where('user_type', 'Customer')->where('newuser','=',0)->count();
              @endphp
              <a href="{{ URL::to('admin/customers') }}">
  				      <i class="ti-layout-media-overlay-alt-2"></i>
                <span>Customers<div class="badge badge-top bg-danger animated flash">
                  
                    @if($getcustomer>0)
                      <span>{{$getcustomer}}</span>
                      @else
                      <span>0</span>
                    @endif
            </div></span>
              </a>
            </li>
             <li>
              <a href="{{ route('admin.login_details') }}">
                <i class="fa fa-users" aria-hidden="true"></i>
                  <span>Customer Activities</span>
              </a>
            </li>
             <li>
              <a href="{{ route('admin.details') }}">
                <i class="fa fa-users" aria-hidden="true"></i>
                  <span>products individually</span>
              </a>
            </li>
           <!--  <li>
              <a href="{{ route('admin.payment') }}">
                <i class="fa fa-users" aria-hidden="true"></i>
                  <span>payment approve</span>
              </a>
            </li>
             <li>
              <a href="{{ url('admin/payment/approved') }}">
                <i class="fa fa-users" aria-hidden="true"></i>
                  <span>payment Approved</span>
              </a>
            </li>-->
            <li>
              <a href="{{ URL::to('admin/requisition') }}">
                <i class="ti-layout-media-overlay-alt-2"></i>
                <span>Requisition<div class="badge badge-top bg-danger animated flash">
                  @php 
                  $order=App\orders::where('admin_read','=',0)->count();
                    @endphp
                    @if($order)
                      <span>{{$order}}</span>
                      @else
                      <span>0</span>
                    @endif
            </div></span>
              </a>
            </li>
             <li>
              <a href="{{ URL::to('admin/cancelledorders') }}">
                <i class="ti-layout-media-overlay-alt-2"></i>
                <span>Cancelled Orders</span>
              </a>
            </li>
              <li>
              <a href="{{ URL::to('admin/searchterm') }}">
                <i class="fa fa-users" aria-hidden="true"></i>
                  <span>term collect</span>
              </a>
            </li>
            <li>
              <a href="{{ route('admin.topearn') }}">
                <i class="fa fa-users" aria-hidden="true"></i>
                  <span>Top earning</span>
              </a>
            </li>

            <li>
              <a href="{{ URL::to('admin/veiw_customer_q_a') }}">
                <i class="ti-layout-media-overlay-alt-2"></i>
                <span>Customer Q & A<div class="badge badge-top bg-danger animated flash">
                  @php $customer_q_a = DB::table('customer_q_a')->where('answer_status','no')->count();
                    Session::put('customer_q_a',$customer_q_a);
                    @endphp
                    @if($customer_q_a)
                      <span>{{Session::get('customer_q_a')}}</span>
                      @else
                      <span>0</span>
                    @endif
            </div></span>
              </a>
            </li>

            
            <li>
              <a href="{{ URL::to('admin/outstanding') }}">
                <i class="ti-layout-media-overlay-alt-2"></i>
                <span>Outstanding Payment</span>
              </a>
            </li>
             <li>
              <a href="{{ URL::to('admin/rfq') }}">
                <i class="ti-layout-media-overlay-alt-2"></i>
                <span>RFQ </span>
              </a>
            </li>

            <li>
              <a href="{{ URL::to('admin/accounts') }}">
                <i class="ti-layout-media-overlay-alt-2"></i>
                <span>Accounts</span>
              </a>
            </li>
            <li class="">
                    <a href="javascript:void(0)" class="active">
                      <i class="toggle-accordion"></i>
                      <i class="ti-window"></i>
                      <span>Wallet</span>
                    </a>
                    <ul class="sub-menu" style="display: none;">
                      <li>
                        @php
                          $wallet=App\wallethistory::where('transactiontype','=',3)->count();
                           @endphp
                          <a href="{{url('admin/wallet/pending')}}" >Wallet Pending<div class="badge badge-top bg-danger animated flash">{{$wallet}}</div></a>
                                    
                      </li>
                      <li>
                        <a href="{{url('admin/wallet/approved')}}" >Wallet Approved</a>
                      </li>
                    </ul>
                  </li>

            <li>
              <a href="{{ URL::to('admin/users') }}">
                <i class="ti-layout-media-overlay-alt-2"></i>
                <span>Users Management</span>
              </a>
            </li>
             <li class="">
                  <a href="javascript:void(0)" class="active">
                    <i class="toggle-accordion"></i>
                    <i class="ti-window"></i>
                    <span>Static Pages</span>
                  </a>
                  <ul class="sub-menu" style="display: none;">
                    <li>
                      <a href="{{url('general/terms/create')}}" title="">
                        <span>Add New Page</span>
                      </a>
                    </li>
                    <li>
                      <a href="{{url('general/terms')}}" title="">
                        <span>Pages</span>
                      </a>
                    </li>
                  </ul>
            </li>
            <li>
              <a href="{{ URL::to('admin/shipping') }}">
                <i class="ti-layout-media-overlay-alt-2"></i>
                <span>Shipping Management</span>
              </a>
            </li>
           <li>
              <a href="{{ URL::to('admin/rfq') }}">
                <i class="ti-layout-media-overlay-alt-2"></i>
                <span>RFQ</span>
              </a>
            </li>
            <li>
              <a href="{{ URL::to('admin/message/panel') }}">
                <i class="ti-layout-media-overlay-alt-2"></i>
                <span>Messages</span>
              </a>
            </li>
            <li>
              <a href="{{ URL::to('admin/news/letter') }}">
                <i class="ti-layout-media-overlay-alt-2"></i>
                <span>Newsletter</span>
              </a>
            </li>
           <!-- <li>
              <a href="{{ URL::to('admin/wallet/pending') }}">
                <i class="ti-layout-media-overlay-alt-2"></i>
                <span>Wallet Pending</span>
              </a>
            </li>-->
          </ul>
        </nav>
      </aside>
      <!-- /sidebar menu -->
  