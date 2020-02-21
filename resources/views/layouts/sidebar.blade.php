@inject('request', 'Illuminate\Http\Request')
<!-- Left side column. contains the sidebar -->
<ul class="nav sidebar-menu">
                <li class="sidebar-label pt30">Menu</li>

                <li>

                <a href="/admin/index" class="active">
                        <span class="fa fa-dashboard"></span>
                        <span class="sidebar-title">Dashboard</span>
                    </a>
                </li>

                <li>

                <a class="accordion-toggle" href="#">
                        <span class="fa fa-dashboard"></span>
                        <span class="sidebar-title">PRODUCTS</span>
                        <span class="caret"></span>
                    </a>
                    <ul class="nav sub-nav">
                        
                        <li>
                            <a href="{{ url('admin/vendorproduct') }}">
                                <span class="glyphicon glyphicon-tags"></span> VENDOR PRODUCTS </a>
                        </li>

                         <li>
                            <a href="{{ url('admin/aprove_reject_product') }}">
                                <span class="glyphicon glyphicon-tags"></span>APROVE AND REJECT </a>
                        </li> 

                        
                    </ul>
                </li>
                <li>

                <a href="{{ url('admin/vendors') }}" >
                        <span class="fa fa-dashboard"></span>
                        <span class="sidebar-title">VENDORS</span>
                    </a>
                </li>

                <li>

                <a href="{{ url('admin/customers') }}">
                        <span class="fa fa-dashboard"></span>
                        <span class="sidebar-title">CUSTOMERS</span>
                    </a>
                </li>

                <li>
                    <a class="accordion-toggle" href="#">
                        <span class="fa fa-share-square-o"></span>
                        <span class="sidebar-title">REQUISITION</span>
                        <span class="caret"></span>
                    </a>
                    <ul class="nav sub-nav">
                        <li>
                            <a href="{{url('admin/requisition')}}">
                                <span class="glyphicon glyphicon-tags"></span> TRACK REQUISITION</a>
                        </li>
                       <!--  <li>
                            <a href="sales-stats-products.html">
                                <span class="glyphicon glyphicon-tags"></span> MANAGE REQUISITION </a>
                        </li> -->
                    </ul>
                </li>

                <li>
                    <a class="accordion-toggle" href="#">
                        <span class="fa fa-share-square-o"></span>
                        <span class="sidebar-title">Content</span>
                        <span class="caret"></span>
                    </a>
                    <ul class="nav sub-nav">
                        <li>
                            <a href="{{ url('admin/category') }}">
                                <span class="glyphicon glyphicon-tags"></span> CATEGORY</a>
                        </li>
                        <li>
                            <a href="{{ url('admin/subcategory') }}">
                                <span class="glyphicon glyphicon-tags"></span>SUB CATEGORY </a>
                        </li>
                        <li>
                            <a href="{{ url('admin/today_fetured') }}">
                                <span class="glyphicon glyphicon-tags"></span> TODAY FEATURED </a>
                        </li>

                        <li>
                            <a href="{{ url('admin/banner') }}">
                                <span class="glyphicon glyphicon-tags"></span>BANNER </a>
                        </li>

                        <li>
                            <a href="{{ url('admin/adv_sec_1') }}">
                                <span class="glyphicon glyphicon-tags"></span> ADV SECTION 1 </a>
                        </li>
                        <li>
                            <a href="{{ url('admin/adv_sec_2') }}">
                                <span class="glyphicon glyphicon-tags"></span> ADV SECTION 2 </a>
                        </li>

                        
                    </ul>
                </li>

                 <li>

                <a href="{{ url('admin/outstanding') }}" >
                        <span class="fa fa-dashboard"></span>
                        <span class="sidebar-title">OUTSTANDING PAYMENT</span>
                    </a>
                </li> 

                <li>
                    <a class="accordion-toggle" href="#">
                        <span class="fa fa-share-square-o"></span>
                        <span class="sidebar-title">GENERAL SETTINGS</span>
                        <span class="caret"></span>
                    </a>
                    <ul class="nav sub-nav">
                        <li>
                            <a href="{{url('admin/users')}}">
                                <span class="glyphicon glyphicon-tags"></span> USER SETTINGS</a>
                        </li>
                        <!-- <li>
                            <a href="sales-stats-products.html">
                                <span class="glyphicon glyphicon-tags"></span> ADMIN SETTINS </a>
                        </li> -->
                    </ul>
                </li>

                </li>
            </ul>