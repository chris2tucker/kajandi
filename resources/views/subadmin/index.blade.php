@extends('layouts.subadminlayout')
@section('content')
<!-- -------------- /Topbar Menu Wrapper -------------- -->

        <!-- -------------- Topbar -------------- -->
        <header id="topbar" class="ph10">
            <div class="topbar-left">
                <ul class="nav nav-list nav-list-topbar pull-left">
                    <li class="active">
                        <a href="dashboard2.html">Overview</a>
                    </li>
                    <li>
                        <a href="sales-stats-products.html">Products</a>
                    </li>
                    <li>
                        <a href="sales-stats-purchases.html">Orders</a>
                    </li>
                    <li>
                        <a href="sales-stats-clients.html">Clients</a>
                    </li>
                    <li>
                        <a href="sales-stats-general-settings.html">Settings</a>
                    </li>
                </ul>
            </div>
            <div class="topbar-right hidden-xs hidden-sm mt5 mr35">
                <a href="sales-stats-purchases.html" class="btn btn-primary btn-sm ml10" title="New Order">
                    <span class="fa fa-plus pr5"></span><span class="fa fa-file-o pr5"></span></a>
                <a href="sales-stats-products.html" class="btn btn-primary btn-sm ml10" title="New Product">
                    <span class="fa fa-plus pr5"></span><span class="fa fa-shopping-cart pr5"></span></a>
                <a href="sales-stats-clients.html" class="btn btn-primary btn-sm ml10" title="New User">
                    <span class="fa fa-plus pr5"></span><span class="fa fa-user pr5"></span></a>
            </div>
        </header>
<section id="content" class="table-layout animated fadeIn">

            <!-- -------------- Column Center -------------- -->
            <div class="chute chute-center">

                <!-- -------------- Products Status Table -------------- -->
                <div class="row">
                    <div class="col-xs-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <span class="panel-title hidden-xs"> Products status</span>
                            </div>
                            <div class="panel-body pn">
                                <div class="table-responsive">
                                    <table class="table allcp-form theme-warning tc-checkbox-1 fs13">
                                        <thead>
                                        <tr class="bg-light">
                                            <th class="text-center"></th>
                                            <th class="">Image</th>
                                            <th class="">Product Title</th>
                                            <th class="">SKU</th>
                                            <th class="">Price</th>
                                            <th class="">Stock</th>
                                            <th class="text-right">Status</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class="text-center">
                                                <label class="option block mn">
                                                    <input type="checkbox" name="inputname" value="FR">
                                                    <span class="checkbox mn"></span>
                                                </label>
                                            </td>
                                            <td class="w100">
                                                <img class="img-responsive mw40 ib mr10" title="user"
                                                     src="assets/img/pages/products/1.jpg">
                                            </td>
                                            <td class="">Apple iPhone 5</td>
                                            <td class="">#123</td>
                                            <td class="">$500</td>
                                            <td class="">300</td>
                                            <td class="text-right">
                                                <div class="btn-group text-right">
                                                    <button type="button"
                                                            class="btn btn-success br2 btn-xs fs12 dropdown-toggle"
                                                            data-toggle="dropdown" aria-expanded="false"> Active
                                                        <span class="caret ml5"></span>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li>
                                                            <a href="#">Edit</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Delete</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Archive</a>
                                                        </li>
                                                        <li class="divider"></li>
                                                        <li class="active">
                                                            <a href="#">Active</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Inactive</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Low Stock</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Out of Stock</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">
                                                <label class="option block mn">
                                                    <input type="checkbox" name="inputname" value="FR">
                                                    <span class="checkbox mn"></span>
                                                </label>
                                            </td>
                                            <td class="w100">
                                                <img class="img-responsive mw40 ib mr10" title="user"
                                                     src="assets/img/pages/products/2.jpg">
                                            </td>
                                            <td class="">Apple iPhone 6</td>
                                            <td class="">#1234</td>
                                            <td class="">$600</td>
                                            <td class="">500</td>
                                            <td class="text-right">
                                                <div class="btn-group text-right">
                                                    <button type="button"
                                                            class="btn btn-success br2 btn-xs fs12 dropdown-toggle"
                                                            data-toggle="dropdown" aria-expanded="false"> Active
                                                        <span class="caret ml5"></span>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li>
                                                            <a href="#">Edit</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Delete</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Archive</a>
                                                        </li>
                                                        <li class="divider"></li>
                                                        <li class="active">
                                                            <a href="#">Active</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Inactive</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Low Stock</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Out of Stock</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">
                                                <label class="option block mn">
                                                    <input type="checkbox" name="inputname" value="FR">
                                                    <span class="checkbox mn"></span>
                                                </label>
                                            </td>
                                            <td class="w100">
                                                <img class="img-responsive mw40 ib mr10" title="user"
                                                     src="assets/img/pages/products/3.jpg">
                                            </td>
                                            <td class="">Apple iPad</td>
                                            <td class="">#2345</td>
                                            <td class="">$400</td>
                                            <td class="">300</td>
                                            <td class="text-right">
                                                <div class="btn-group text-right">
                                                    <button type="button"
                                                            class="btn btn-success br2 btn-xs fs12 dropdown-toggle"
                                                            data-toggle="dropdown" aria-expanded="false"> Active
                                                        <span class="caret ml5"></span>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li>
                                                            <a href="#">Edit</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Delete</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Archive</a>
                                                        </li>
                                                        <li class="divider"></li>
                                                        <li class="active">
                                                            <a href="#">Active</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Inactive</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Low Stock</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Out of Stock</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">
                                                <label class="option block mn">
                                                    <input type="checkbox" name="inputname" value="FR">
                                                    <span class="checkbox mn"></span>
                                                </label>
                                            </td>
                                            <td class="w100">
                                                <img class="img-responsive mw40 ib mr10" title="user"
                                                     src="assets/img/pages/products/4.jpg">
                                            </td>
                                            <td class="">Apple iPad Air</td>
                                            <td class="">#4563</td>
                                            <td class="">$800</td>
                                            <td class="">500</td>
                                            <td class="text-right">
                                                <div class="btn-group text-right">
                                                    <button type="button"
                                                            class="btn btn-success br2 btn-xs fs12 dropdown-toggle"
                                                            data-toggle="dropdown" aria-expanded="false"> Active
                                                        <span class="caret ml5"></span>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li>
                                                            <a href="#">Edit</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Delete</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Archive</a>
                                                        </li>
                                                        <li class="divider"></li>
                                                        <li class="active">
                                                            <a href="#">Active</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Inactive</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Low Stock</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Out of Stock</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">
                                                <label class="option block mn">
                                                    <input type="checkbox" name="inputname" value="FR">
                                                    <span class="checkbox mn"></span>
                                                </label>
                                            </td>
                                            <td class="w100">
                                                <img class="img-responsive mw40 ib mr10" title="user"
                                                     src="assets/img/pages/products/9.jpg">
                                            </td>
                                            <td class="">Apple iPhone 6S 32GB</td>
                                            <td class="">#1011</td>
                                            <td class="">$1195</td>
                                            <td class="text-danger">
                                                <b>0 - Sold Out</b>
                                            </td>
                                            <td class="text-right">
                                                <div class="btn-group text-right">
                                                    <button type="button"
                                                            class="btn btn-danger br2 btn-xs fs12 dropdown-toggle"
                                                            data-toggle="dropdown" aria-expanded="false"> Sold Out
                                                        <span class="caret ml5"></span>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li>
                                                            <a href="#">Edit</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Delete</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Archive</a>
                                                        </li>
                                                        <li class="divider"></li>
                                                        <li>
                                                            <a href="#">Active</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Inactive</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Low Stock</a>
                                                        </li>
                                                        <li class="active">
                                                            <a href="#">Out of Stock</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">
                                                <label class="option block mn">
                                                    <input type="checkbox" name="inputname" value="FR">
                                                    <span class="checkbox mn"></span>
                                                </label>
                                            </td>
                                            <td class="w100">
                                                <img class="img-responsive mw40 ib mr10" title="user"
                                                     src="assets/img/pages/products/10.jpg">
                                            </td>
                                            <td class="">Apple iPhone 6S 64GB</td>
                                            <td class="">#1012</td>
                                            <td class="">$1395</td>
                                            <td class="text-danger">
                                                <b>0 - Sold Out</b>
                                            </td>
                                            <td class="text-right">
                                                <div class="btn-group text-right">
                                                    <button type="button"
                                                            class="btn btn-danger br2 btn-xs fs12 dropdown-toggle"
                                                            data-toggle="dropdown" aria-expanded="false"> Sold Out
                                                        <span class="caret ml5"></span>
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li>
                                                            <a href="#">Edit</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Delete</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Archive</a>
                                                        </li>
                                                        <li class="divider"></li>
                                                        <li>
                                                            <a href="#">Active</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Inactive</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Low Stock</a>
                                                        </li>
                                                        <li class="active">
                                                            <a href="#">Out of Stock</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- -------------- Area Chart -------------- -->
                <div class="row">
                    <div class="col-md-6">
                        <!-- -------------- Area Chart -------------- -->
                        <div class="panel" id="pchart1">
                            <div class="panel-heading">
                                <span class="panel-title"> Best Sellers</span>
                            </div>
                            <div class="panel-body">
                                <div id="area-chart1" style="height: 420px; width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- -------------- Line Chart with Submenu Chart -------------- -->
                        <div class="panel" id="pchart9">
                            <div class="panel-heading">
                                <span class="panel-title fw600">Visitor Activity</span>
                            </div>
                            <div class="panel-body pn">
                                <div id="high-datamap" style="width: 100%; height: 300px; margin: 0 auto"></div>
                            </div>
                            <div class="panel-footer bg-light pn">
                                <div id="high-siblingmap" style="width: 100%; height: 150px; margin: 0 auto"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- -------------- Quick Links -------------- -->
                <div class="row">
                    <div class="col-md-9">
                        <!-- -------------- Filterable Column Chart -------------- -->
                        <div class="panel">
                            <div class="panel-heading">
              <span class="panel-title fw600">
                <i class="fa fa-pencil hidden"></i> Sales stats</span>
                            </div>
                            <div class="panel-body pn">


                                <div id="high-line2" style="width: 100%; height: 250px; margin: 0 auto"></div>


                                <div class="p15 pt5 mt15 bg-light br-t">
                                    <div class="table-responsive">
                                        <table class="table mbn allcp-form fs13 table-legend"
                                               data-chart-id="#high-line2">
                                            <thead>
                                            <tr class="">
                                                <th class="w30">ID</th>
                                                <th class="w50">Chart</th>
                                                <th>Year</th>
                                                <th class="text-right">Total Sales</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td class="fs15 fw600">1.</td>
                                                <td>
                                                    <label class="switch switch-warning block mbn">
                                                        <input type="checkbox" class="legend-switch" name="features"
                                                               id="s1"
                                                               value="0">
                                                        <label for="s1" data-on="ON" data-off="OFF"></label>
                                                        <span></span>
                                                    </label>
                                                </td>
                                                <td class="fs20 va-m fw600 text-muted">
                                                    2013
                                                </td>
                                                <td class="fs15 fw600 text-right">15,163</td>
                                            </tr>
                                            <tr>
                                                <td class="fs15 fw600">2.</td>
                                                <td>
                                                    <label class="switch switch-primary block mbn">
                                                        <input type="checkbox" class="legend-switch" name="features"
                                                               id="s2"
                                                               value="1">
                                                        <label for="s2" data-on="ON" data-off="OFF"></label>
                                                        <span></span>
                                                    </label>
                                                </td>
                                                <td class="fs20 va-m fw600 text-muted">
                                                    2014
                                                </td>
                                                <td class="fs15 fw600 text-right">19,858</td>
                                            </tr>
                                            <tr>
                                                <td class="fs15 fw600">3.</td>
                                                <td>
                                                    <label class="switch switch-alert block mbn">
                                                        <input type="checkbox" class="legend-switch" name="features"
                                                               id="s3"
                                                               value="3">
                                                        <label for="s3" data-on="ON" data-off="OFF"></label>
                                                        <span></span>
                                                    </label>
                                                </td>
                                                <td class="fs20 va-m fw600 text-muted">
                                                    2015
                                                </td>
                                                <td class="fs15 fw600 text-right">17,525</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="row">
                            <div class="col-sm-6 col-md-12 ph10">
                                <div class="panel panel-tile">
                                    <div class="panel-body">
                                        <div class="row pv10">
                                            <div class="col-xs-5 ph10"><img src="assets/img/pages/clipart0.png"
                                                                            class="img-responsive mauto" alt=""/></div>
                                            <div class="col-xs-7 pl5">
                                                <h6 class="text-muted">NEW ORDERS</h6>

                                                <h2 class="fs40 mt5 mbn">385</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-12 ph10">
                                <div class="panel panel-tile">
                                    <div class="panel-body">
                                        <div class="row pv10">
                                            <div class="col-xs-5 ph10"><img src="assets/img/pages/clipart1.png"
                                                                            class="img-responsive mauto" alt=""/></div>
                                            <div class="col-xs-7 pl5">
                                                <h6 class="text-muted">PRODUCTS SHIPPED</h6>

                                                <h2 class="fs40 mt5 mbn">97</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="hidden-sm col-md-12 ph10">
                                <div class="panel panel-tile">
                                    <div class="panel-body">
                                        <div class="row pv10">
                                            <div class="col-xs-5 ph10"><img src="assets/img/pages/clipart2.png"
                                                                            class="img-responsive mauto" alt=""/></div>
                                            <div class="col-xs-7 pl5">
                                                <h6 class="text-muted">HAPPY CUSTOMERS</h6>

                                                <h2 class="fs40 mt5 mbn">6789</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- -------------- Visitors Map -------------- -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel">
                            <div class="panel-heading">
                                <span class="panel-title">Visitors Map</span>
                            </div>
                            <div class="panel-body pn">
                                <div id="map1" style="width: 100%; height: 100%;" class="mh-400"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- -------------- Country List -------------- -->
                        <div class="panel">
                            <div class="panel-heading">
                                <span class="panel-title">Country List</span>
                            </div>
                            <div class="panel-body panel-scroller scroller-lg scroller-pn pn">
                                <table class="table mbn tc-icon-bold br-t">
                                    <thead>
                                    <tr class="hidden">
                                        <th>#</th>
                                        <th>First Name</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <span class="flag-sm flag-mx mr5 va-b"></span>Mexico
                                        </td>
                                        <td>33%</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="flag-sm flag-gb mr5 va-b"></span> Great Britain
                                        </td>
                                        <td>33%</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="flag-sm flag-ca mr5 va-b"></span>Canada
                                        </td>
                                        <td>33%</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="flag-sm flag-us mr5 va-b"></span>United States
                                        </td>
                                        <td>31%</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="flag-sm flag-cn mr5 va-b"></span> China
                                        </td>
                                        <td>22%</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="flag-sm flag-mx mr5 va-b"></span>Mexico
                                        </td>
                                        <td>33%</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="flag-sm flag-gb mr5 va-b"></span> Great Britain
                                        </td>
                                        <td>33%</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="flag-sm flag-ca mr5 va-b"></span>Canada
                                        </td>
                                        <td>33%</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="flag-sm flag-us mr5 va-b"></span>United States
                                        </td>
                                        <td>31%</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="flag-sm flag-cn mr5 va-b"></span> China
                                        </td>
                                        <td>22%</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="flag-sm flag-us mr5 va-b"></span>United States
                                        </td>
                                        <td>31%</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="flag-sm flag-cn mr5 va-b"></span> China
                                        </td>
                                        <td>22%</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- -------------- /Column Center -------------- -->

        </section>
@endsection