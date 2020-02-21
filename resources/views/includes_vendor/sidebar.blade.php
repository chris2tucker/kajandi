<style>
  .slimScrollBar{
    width: 15px !important;
  }
</style>
<section class="layout">
      <!-- sidebar menu -->
      <aside class="sidebar offscreen-left">
        <!-- main navigation -->
        <nav class="main-navigation" data-height="auto" data-size="6px" data-distance="0" data-rail-visible="true" data-wheel-step="10">
          <p class="nav-title">MENU</p>
          <ul class="nav">
            <!-- dashboard -->
            <li>
              <a href="{{URL::to('vendors/index')}}">
                <i class="ti-home"></i>
                <span>Dashboard</span>
                
              </a>
            </li>
             
        
           
               <li class="">
                  <a href="javascript:;" class="active">
                    <i class="toggle-accordion"></i>
                    <i class="ti-window"></i>
                    <span>Products</span>
                  </a>
                  <ul class="sub-menu" style="display: none;">
                   
                    @if(Auth::user()->status==1)
                    <li>
                      <a href="{{ url('vendors/products') }}">
                       <span>My Products</span>
                      </a>
                    </li>
                   
                    @endif
                     <li>
              <a href="{{ url('vendors/model') }}">
               
                <span>My Product Model</span>
                
              </a>
            </li>
              <li>
              <a href="{{ url('vendors/manufacture') }}">
                
                <span>My Product Manufacturers</span>
                
              </a>
            </li>
                  </ul>
                  </li>
                  
             <li>
              <a href="{{ route('vendors.bank') }}">
                <i class="ti-home"></i>
                <span>Bank Details</span>
                
              </a>
            </li>
             <!--<li>
              <a href="{{ route('vendor.order.index') }}">
                <i class="ti-layout-media-overlay-alt-2"></i>
                <span>Order</span>
              </a>
            </li> -->
            <!-- <li>
              <a href="{{ route('vendor.paymentstatus') }}">
                <i class="ti-layout-media-overlay-alt-2"></i>
                <span>Accept Payment</span>
              </a>
            </li>-->
            <li class="">
                  <a href="javascript:;" class="active">
                    <i class="toggle-accordion"></i>
                    <i class="ti-window"></i>
                    <span>Customers</span>
                  </a>
                  <ul class="sub-menu" style="display: none;">
                    <li>
                      <a href="{{ URL::to('vendors/credit_customers') }}">
                       <span>Customers list</span>
                      </a>
                    </li>
                     <li>
                      <a href="{{ URL::to('vendors/customer/create') }}">
                       <span>Add customer</span>
                      </a>
                    </li>
                    <li>
                      <a href="{{ URL::to('vendors/favourite/customers') }}">
                       <span>favourite customer</span>
                      </a>
                    </li>
                  </ul>
            </li>
             <li>
              <a href="{{ url('vendors/customer_request') }}">
                <i class="ti-home"></i>
                <span>Customer Requests<div class="badge badge-top bg-danger animated flash">
                  @php 
                   $vendor_reject = App\customersvendor::where('vendor_id',Auth::User()->id)->where('status','pending')->count();
                    @endphp
                    @if($vendor_reject)
                      <span>{{$vendor_reject}}</span>
                      @else
                      <span>0</span>
                    @endif
            </div></span>
                
              </a>
            </li>
          <li>
              <a href="{{ URL::to('vendors/outstandingpayment') }}">
                <i class="ti-layout-media-overlay-alt-2"></i>
                <span>Due & outstanding</span>
              </a>
            </li>
            <li>
              <a href="{{ URL::to('vendors/requisition') }}">
                <i class="ti-layout-media-overlay-alt-2"></i>
                <span>Requisition/Orders<div class="badge badge-top bg-danger animated flash">
                  @php 
                  $order=App\orders::where('vendor_read','=',0)->where('vendor_id','=',Auth::user()->id)->count();
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
              <a href="{{ URL::to('cancelled/vendors/requisition') }}">
                <i class="ti-layout-media-overlay-alt-2"></i>
                <span>Cancelled Orders<div class="badge badge-top bg-danger animated flash">
                  @php 
                  $order=App\Orders::where('orderstatus','=','cancel')->where('vendor_id','=',Auth::user()->id)->count();
                    @endphp
                    @if($order)
                      <span>{{$order}}</span>
                      @else
                      <span>0</span>
                    @endif
            </div></span>
              </a>
            </li>
            <li class="">
                  <a href="javascript:;" class="active">
                    <i class="toggle-accordion"></i>
                    <i class="ti-window"></i>
                    <span>User Settings</span>
                  </a>
                  <ul class="sub-menu" style="display: none;">
                    <li>
                      <a href="{{ route('vendor.settings') }}">
                       <span>User Settings</span>
                      </a>
                    </li>
                   
               
                  </ul>
            </li>
           <li>
              <a href="{{ route('vendor.companyguidelines') }}">
                <i class="ti-layers"></i>
                <span>guidelines</span>
                
              </a>
            </li>
            <li>
              <a href="{{ route('vendor.commissions') }}">
                <i class="ti-gift"></i>
                <span>commissions</span>
                
              </a>
            </li>
             <li>
              <a href="{{ url('vendor/message/panel') }}">
                <i class="ti-gift"></i>
                <span>Message system</span>
                
              </a>
            </li>
            <li>
              <a href="{{ url('vendor/rfq') }}">
                <i class="ti-gift"></i>
                <span>RFQ</span><div class="badge badge-top bg-danger animated flash">
                  @php 
                   $rfq=App\rfq::all();
                   $rfqcount=0;
                   foreach($rfq as $rf){
                   $vendor=App\rfqvendor::where('rfq_id','=',$rf->id)->where('vendor_id','=',Auth::user()->id)->first();
                  
                   if($vendor){
                 }
                 else{
                 $rfqcount=$rfqcount+1;
               }
                 }
                    @endphp
                    @if($rfqcount)
                      <span>{{$rfqcount}}</span>
                      @else
                      <span>0</span>
                    @endif
            </div></span>
                
              </a>
            </li>
           <li>
              <a href="{{ url('page/contact_us') }}">
                <i class="ti-gift"></i>
                <span>Contact us</span>
                
              </a>
            </li>
           
            
          </ul>
        </nav>
      </aside>
      <!-- /sidebar menu -->
  