<?php
    use Illuminate\Routing\Route as IlluminateRoute;
    use App\Http\Validator\CaseInsensitiveUriValidator;
use Illuminate\Routing\Matching\UriValidator;

$validators = IlluminateRoute::getValidators();
$validators[] = new CaseInsensitiveUriValidator;
IlluminateRoute::$validators = array_filter($validators, function($validator) {
    return get_class($validator) !== UriValidator::class;
});
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::resource('vendors/model', 'Vendor\ModelController');
Route::resource('vendors/manufacture', 'Vendor\ManufactureController');
Route::get('admin/topearn','Vendor\SettingsController@top_earn')->name('admin.topearn');

Route::get('admin/searchterm','AdminController@search_term')->name('admin.searchterm')->middleware('auth');
Route::get('/order/pending','AdminController@order_pending');
Route::get('/order/category','AdminController@order_category');
Route::get('/order/subcategory','AdminController@order_subcategory');
Route::get('admin/login_details','AdminController@login_details')->name('admin.login_details');

Route::get('admin/login_details/{id}','AdminController@customer_details')->name('admin.customer.details');

Route::get('admin/topearn','AdminController@topearn')->name('admin.topearn')->middleware('auth');
Route::get('admin/bankdetails','Admin\ApproveController@approve')->name('admin.bank.approve')->middleware('auth');

Route::get('admin/bankdetails/store/{id}','Admin\ApproveController@store')->name('admin.bank.store')->middleware('auth');

Route::get('admin/user/approve','Admin\ApproveController@user')->name('admin.user.approve')->middleware('auth');

Route::get('admin/user/approve/{id}','Admin\ApproveController@user_approve')->name('admin.user_approve')->middleware('auth');
Route::get('admin/product_details','Admin\ProductdetailsController@index')->name('admin.details')->middleware('auth');
Route::get('admin/accounting_details/{id}','Admin\ProductdetailsController@details')->name('admin.accounting')->middleware('auth');


Route::get('admin/payment/approve','Admin\ProductdetailsController@payment')->name('admin.payment')->middleware('auth');
Route::get('admin/payment/approved','Admin\ProductdetailsController@approved')->name('admin.pay.approved')->middleware('admin_user');
Route::get('admin/payment/approve/{id}','Admin\ProductdetailsController@approve')->name('admin.payment.approve')->middleware('auth');

Route::get('admin/failed/{id}','Admin\ProductdetailsController@failed')->name('admin.failed')->middleware('auth');

Route::get('admin/pending/{id}','Admin\ProductdetailsController@pending')->name('admin.pending')->middleware('auth');

Route::get('accounting/{id}','Customer\VendorproductController@accounting')->name('accounting');

Route::get('vendors/order_status/{id}','Vendor\OrderController@active')->name('vendor.orderstatus');

Route::get('vendors/order_cancel/{id}','Vendor\OrderController@cancel')->name('vendor.ordercancel');

Route::get('vendors/orderpayment','Vendor\OrderController@paymentstatus')->name('vendor.paymentstatus');

Route::get('vendorproducts','Customer\VendorproductController@index')->name('vendorproduct');

Route::get('vendors/customer_request','Vendor\SettingsController@customer_request');
Route::get('vendors/vendor/approve{id}','Vendor\SettingsController@approve')->name(
'vendors.vendor.approve');
Route::post('vendors/vendor/reject/{id}','Vendor\SettingsController@reject')->name(
'vendors.vendor.reject');
Route::get('order/approve/{id}','HomeController@approve');
Route::get('order/delivered/{id}','HomeController@delivered');
Route::get('admin/register', array('as' => 'create', 'uses' => 'Auth\RegisterController@admin_register_form'));

Route::post('admin/register_admin', array('as' => 'create', 'uses' => 'Auth\RegisterController@register_admin'));


Route::get('admin/login', array('as' => 'create', 'uses' => 'Auth\RegisterController@admin_login_view'));
Route::post('admin/login_to', array('as' => 'create', 'uses' => 'Auth\RegisterController@admin_login'));

Route::get('vendor/login', array('as' => 'create', 'uses' => 'Auth\RegisterController@vendor_login_view'));
Route::post('vendor/login_to', array('as' => 'create', 'uses' => 'Auth\RegisterController@vendor_login'));
Route::post('admin/admin_logout',  'Auth\RegisterController@admin_logout')->name('admin_logout');
Route::get('vendor/register',function(){
	return view('auth.vendor.vendor_register');
})->name('vendor.register.page');
Route::post('vendor/register','Auth\RegisterController@vender_register')->name('vendor.register');
Route::get('vendors/companyguidelines','Vendor\companyguidelinesController@companyguidelines')->name('vendor.companyguidelines');
Route::get('vendors/commissions','Vendor\companyguidelinesController@commissions')->name('vendor.commissions');
Route::get('vendors/outstandingpayment','Vendor\OutstandingController@index')->name('vendor.outstanding');

Route::group(['middleware' => 'admin_user'], function () {
//Admin Contoller
Route::get('admin/index', array('as' => 'create', 'uses' => 'AdminController@index'));
Route::get('admin/vendor/bank','Admin\AccountController@vendor')->name('admin.vendor.bank');
Route::get('admin/shipping','Admin\ProductController@shipping')->name('shipping.admin');
Route::get('admin/shipping/add','Admin\ProductController@addshipping')->name('shipping.admin.add');
Route::get('admin/city/edit/{id}','Admin\ProductController@editcity')->name('admin.city.edit');
Route::get('admin/state/edit/{id}','Admin\ProductController@editstate')->name('admin.state.edit');
Route::get('admin/country/edit/{id}','Admin\ProductController@editcountry')->name('admin.country.edit');
Route::post('admin/city/edit/{id}','Admin\ProductController@updatecity')->name('admin.city.edit');
Route::post('admin/state/edit/{id}','Admin\ProductController@updatestate')->name('admin.state.edit');
Route::post('admin/country/edit/{id}','Admin\ProductController@updatecountry')->name('admin.country.edit');
Route::post('admin/shipping/add','Admin\ProductController@storeshipping')->name('shipping.admin.store');
Route::get('admin/shipping/edit/{id}','Admin\ProductController@editshipping')->name('shipping.edit');
Route::post('admin/shipping/edit/{id}','Admin\ProductController@updateshipping')->name('shipping.update');
Route::get('admin/shipping/city','Admin\ProductController@addcity')->name('shipping.city');
Route::post('admin/shipping/city','Admin\ProductController@city')->name('shipping.city.add');
Route::get('admin/shipping/state','Admin\ProductController@addstate')->name('shipping.state');
Route::post('admin/shipping/state','Admin\ProductController@state')->name('shipping.addstate');
Route::get('admin/shipping/country','Admin\ProductController@addcountry')->name('shipping.country');
Route::post('admin/shipping/country','Admin\ProductController@country')->name('shipping.addcountry');
Route::get('get/states/shipping','Admin\ProductController@getstate')->name('shipping.getstate');
Route::get('shipping/city/list','Admin\ProductController@list')->name('shipping.city.list');
Route::get('admin/category', array('as' => 'create', 'uses' => 'AdminController@category'));
Route::get('admin/create_catagory', array('as' => 'create', 'uses' => 'AdminController@create_catagory'));

Route::get('admin/subcategory', array('as' => 'create', 'uses' => 'AdminController@subcategory'));

Route::post('admin/addcategory', array('as' => 'create', 'uses' => 'AdminController@addcategory'));
Route::get('admin/tags','AdminController@tags');
Route::get('admin/create_tag','AdminController@create_tag');
Route::post('admin/add_tag','AdminController@save_tag');
Route::get('admin/delete_tag/{id}','AdminController@delete_tag');
Route::get('admin/edit_tag/{id}','AdminController@edit_tag');
Route::post('admin/edit_tag/{id}','AdminController@update_tag');
Route::get('admin/edit_catagory/{id}', array('as' => 'create', 'uses' => 'AdminController@edit_catagory'));
Route::post('admin/edit_category_update/{id}', array('as' => 'create', 'uses' => 'AdminController@edit_category_update'));
Route::get('admin/delete_catagory/{id}', array('as' => 'create', 'uses' => 'AdminController@delete_catagory'));


Route::post('admin/addsubcategory', array('as' => 'create', 'uses' => 'AdminController@addsubcategory'));
Route::get('admin/add_subcatagory', array('as' => 'create', 'uses' => 'AdminController@add_subcatagory'));
Route::get('admin/edit_subcatagory/{id}', array('as' => 'create', 'uses' => 'AdminController@edit_subcatagory'));

Route::post('admin/update_subcategory/{id}', array('as' => 'create', 'uses' => 'AdminController@update_subcategory'));
Route::get('admin/delete_sub_catagory/{id}', array('as' => 'create', 'uses' => 'AdminController@delete_sub_catagory'));

Route::resource('admin/adv_sec_1', 'Admin\AdvertiseMent_1Controller');
Route::put('admin/adv_sec_1/update/{id}', 'Admin\AdvertiseMent_1Controller@update');
Route::get('admin/adv_sec_1/destroy/{id}', 'Admin\AdvertiseMent_1Controller@destroy');


Route::resource('admin/adv_sec_2', 'Admin\AdvertiseMent_2Controller');
Route::put('admin/adv_sec_2/update/{id}', 'Admin\AdvertiseMent_2Controller@update');
Route::get('admin/adv_sec_2/destroy/{id}', 'Admin\AdvertiseMent_2Controller@destroy');

Route::resource('admin/banner', 'Admin\BannerController');
Route::put('admin/banner/update/{id}', 'Admin\BannerController@update');
Route::get('admin/banner/destroy/{id}', 'Admin\BannerController@destroy');
Route::get('admin/get_vendor_product', 'Admin\AdvertiseMent_1Controller@get_vendor_product');

Route::get('admin/today_fetured', 'Admin\TodayFeauredController@index');
Route::post('admin/get_vendor_product', 'Admin\TodayFeauredController@get_vendor_product');
Route::post('admin/save_today_featured', 'Admin\TodayFeauredController@store');
Route::get('admin/edit_featured/{id}', 'Admin\TodayFeauredController@edit_today_featured');
Route::post('admin/today_feature_update/{id}', 'Admin\TodayFeauredController@today_feature_update');
Route::get('admin/delete_today_feature/{id}', 'Admin\TodayFeauredController@delete_today_feature');
Route::get('admin/add_today_fetured', 'Admin\TodayFeauredController@create');

Route::resource('admin/manufacture', 'Admin\ManufactureController');
Route::resource('admin/model', 'Admin\ModelController');
Route::resource('admin/condition', 'Admin\ConditionController');
Route::get('admin/accounts', 'Admin\AccountController@accounts');

Route::get('admin/comission_catagory', 'Admin\AccountController@CommissionCatagory');
Route::get('admin/comission_Subcatagory', 'Admin\AccountController@CommissionSubCatagory');
Route::get('admin/productCommission', 'Admin\AccountController@productCommission');
Route::get('admin/bank_details','Admin\AccountController@bankdetails');
Route::post('admin/bank_details','Admin\AccountController@saveBank');
Route::post('admin/setcatagory/{id}', 'Admin\AccountController@set_commission_catagory');
Route::post('admin/setSubcatagory/{id}', 'Admin\AccountController@set_commission_subcatagory');
Route::post('admin/setproduct/{id}', 'Admin\AccountController@set_commission_product');

Route::get('admin/ProductDetail/{id}', array('as' => 'edit', 'uses' => 'Admin\ProductController@DetailProduct'));
//Route::get('admin/manufacture', 'Admin\ManufactureController@index');
Route::get('admin/inventory', array('as' => 'edit', 'uses' => 'Admin\ProductController@inventory'));

Route::post('admin/AddInvetory/{id}', array('as' => 'edit', 'uses' => 'Admin\ProductController@AddInvetory'));




Route::post('admin/addnewvendor', array('as' => 'create', 'uses' => 'AdminController@addnewvendor'));

Route::get('admin/vendorproduct', array('as' => 'create', 'uses' => 'AdminController@vendorproduct'));

Route::get('/admin/addvendorproduct', array('as' => 'create', 'uses' => 'AdminController@addvendorproduct'));
Route::get('/admin/edit/approve/vendors', array('as' => 'create', 'uses' => 'AdminController@editapprove'));
Route::get('/admin/approve/vendor/{id}', array('as' => 'create', 'uses' => 'AdminController@approvevendor'));
Route::get('admin/promotion', array('as' => 'create', 'uses' => 'AdminController@promotion'));
Route::post('/admin/updatevendorproduct/{id}', array('as' => 'create', 'uses' => 'AdminController@updatevendorproduct'));

Route::get('/admin/viewvendorproduct/{id}', array('as' => 'create', 'uses' => 'AdminController@viewvendorproduct'));

Route::get('admin/getproduct', array('as' => 'create', 'uses' => 'AdminController@getproduct'));

Route::get('admin/vendors', array('as' => 'create', 'uses' => 'AdminController@vendors'));
Route::get('admin/vendors/detail/{id}',array('as'=>'create','uses'=>'AdminController@vendorsDetail'));
Route::get('admin/vendor/destroy/{id}', array('as' => 'create', 'uses' => 'AdminController@vendor_destroy'));
Route::get('admin/active_vendor/{id}', array('as' => 'create', 'uses' => 'AdminController@active_vendor'));
Route::get('admin/deactive_vendor/{id}', array('as' => 'create', 'uses' => 'AdminController@deactive_vendor'));



Route::get('admin/addvendor', array('as' => 'create', 'uses' => 'AdminController@addvendor'));

Route::get('admin/{id}/view', array('as' => 'viewvendors', 'uses' => 'AdminController@viewvendors'));

Route::post('admin/{id}/editvendor', array('as' => 'create', 'uses' => 'AdminController@editvendor'));

Route::get('admin/products', array('as' => 'create', 'uses' => 'AdminController@products'));

Route::get('admin/addproduct', array('as' => 'create', 'uses' => 'AdminController@addproduct'));

Route::post('/admin/createvendorproduct', array('as' => 'create', 'uses' => 'AdminController@createvendorproduct'));

Route::post('admin/createproduct', array('as' => 'create', 'uses' => 'AdminController@createproduct'));

Route::get('admin/changecat', array('as' => 'create', 'uses' => 'AdminController@changecat'));

Route::get('admin/viewproduct/{id}', array('as' => 'create', 'uses' => 'AdminController@viewproduct'));

Route::post('admin/updateviewproduct/{id}', array('as' => 'create', 'uses' => 'AdminController@updateviewproduct'));

Route::get('admin/requisition', array('as' => 'create', 'uses' => 'AdminController@requisition'));
Route::get('admin/cancelledorders', array('as' => 'create', 'uses' => 'AdminController@cancelled'));
Route::get('admin/ordersdetail/{id}', array('as' => 'create', 'uses' => 'AdminController@ordersdetail'));
 Route::get('admin/order/status/{id}', array('as' => 'create', 'uses' => 'AdminController@status'));

    Route::get('admin/order/cancel/{id}', array('as' => 'create', 'uses' => 'AdminController@cancel'));
Route::get('admin/customers', array('as' => 'create', 'uses' => 'AdminController@customers'));

Route::get('admin/viewcustomers/{id}', array('as' => 'create', 'uses' => 'AdminController@viewcustomers'));
Route::get('admin/viewcustomers/wallet/{id}', array('as' => 'create', 'uses' => 'AdminController@viewcustomerswallet'));

Route::get('admin/outstanding', array('as' => 'create', 'uses' => 'AdminController@outstanding'));

Route::get('deliverystatus', array('as' => 'create', 'uses' => 'AdminController@deliverystatus'));


Route::get('admin/addcustomer', array('as' => 'create', 'uses' => 'Admin\CustomersController@create'));
Route::post('admin/savecustomer', array('as' => 'create', 'uses' => 'Admin\CustomersController@store'));
Route::get('admin/editcustomer/{id}', array('as' => 'edit', 'uses' => 'Admin\CustomersController@edit'));
Route::post('admin/updatecustomer/{id}', array('as' => 'update', 'uses' => 'Admin\CustomersController@update'));
Route::get('admin/deletecustomer/{id}', array('as' => 'edit', 'uses' => 'Admin\CustomersController@destroy'));



Route::get('admin/add_products', array('as' => 'create', 'uses' => 'Admin\ProductController@create'));
Route::post('admin/store_product', array('as' => 'create', 'uses' => 'Admin\ProductController@store'));
Route::get('admin/edit_product/{id}', array('as' => 'edit', 'uses' => 'Admin\ProductController@edit'));
Route::post('admin/updateproduct/{id}', array('as' => 'update', 'uses' => 'Admin\ProductController@update'));
Route::get('admin/delete_product/{id}', array('as' => 'edit', 'uses' => 'Admin\ProductController@delete'));



Route::get('admin/aprove_reject_product', array('as' => 'edit', 'uses' => 'Admin\ProductController@aprove_reject_product'));
Route::get('admin/approveproduct/{id}', array('as' => 'update', 'uses' => 'Admin\ProductController@approve'));
Route::get('admin/deactiveproduct/{id}', array('as' => 'update', 'uses' => 'Admin\ProductController@deactive'));
Route::get('admin/activeproduct/{id}', array('as' => 'update', 'uses' => 'Admin\ProductController@active'));


Route::get('admin/get_sub_catgory', array('as' => 'create', 'uses' => 'Admin\ProductController@get_sub_catgory'));
Route::get('admin/users', array('as' => 'create', 'uses' => 'AdminController@users'));
Route::get('admin/create/user','AdminController@createUser');
Route::post('admin/create/user','AdminController@saveUser');
Route::get('admin/user/edit/{id}','AdminController@editUser');
Route::post('admin//user/edit/{id}','AdminController@updateUser');
Route::get('admin/social', array('as' => 'create', 'uses' => 'AdminController@social_link_view'));
Route::get('admin/currency','AdminController@currency')->name('admin.currency');
Route::post('admin/currency','AdminController@updatecurrency')->name('admin.currency.update');
Route::post('admin/social_link_post', array('as' => 'create', 'uses' => 'AdminController@social_link_post'));

Route::get('admin/veiw_customer_q_a', array('as' => 'create', 'uses' => 'AdminController@veiw_customer_q_a'));

Route::get('admin/answer/{id}', array('as' => 'create', 'uses' => 'AdminController@save_q_a_answer'));


Route::get('admin/product_price', array('as' => 'create', 'uses' => 'Admin\AccountController@product_price'));
Route::get('admin/totalOrderPrice', array('as' => 'create', 'uses' => 'Admin\AccountController@total_order_price_vendor'));

Route::post('admin/get_vendor_product_price', array('as' => 'create', 'uses' => 'Admin\AccountController@get_vendor_product_price'));
Route::post('admin/get_vendor_total_order_price', array('as' => 'create', 'uses' => 'Admin\AccountController@get_vendor_total_order_price'));

Route::get('admin/customer_outsatnding_payment', array('as' => 'create', 'uses' => 'Admin\AccountController@outstanding_customer_payment'));

Route::post('admin/outstanding_detail', array('as' => 'create', 'uses' => 'Admin\AccountController@outstandnig_detail_order'));

Route::get('admin/due_customer_payment', array('as' => 'create', 'uses' => 'Admin\AccountController@due_customer_payment'));

Route::post('admin/due_detail_order', array('as' => 'create', 'uses' => 'Admin\AccountController@due_detail_order'));

Route::get('admin/totalpurchase', array('as' => 'create', 'uses' => 'Admin\AccountController@total_purchase'));
Route::post('admin/total_purchase', array('as' => 'create', 'uses' => 'Admin\AccountController@total_purchase_detail'));

Route::get('admin/vendor_outstanding_payment', array('as' => 'create', 'uses' => 'Admin\AccountController@vendor_outstanding_payment'));

Route::post('admin/get_vendor_outstanding_payment', array('as' => 'create', 'uses' => 'Admin\AccountController@get_vendor_outstanding_payment'));

Route::get('admin/vendor_due_payment', array('as' => 'create', 'uses' => 'Admin\AccountController@vendor_due_payment'));

Route::post('admin/get_vendor_due_payment', array('as' => 'create', 'uses' => 'Admin\AccountController@get_vendor_due_payment'));


Route::get('admin/editApprove', array('as' => 'edit', 'uses' => 'Admin\ProductController@editApprove'));

Route::post('admin/aproveProduct', array('as' => 'edit', 'uses' => 'Admin\ProductController@aproveProduct'));

Route::post('admin/approveReject',array('as' => 'edit', 'uses' => 'Admin\ProductController@rejectProduct'));

});
Route::post('save_q_a', array('as' => 'create', 'uses' => 'CustomersController@save_q_a'));
Route::post('more/loaddata','CustomersController@loadDataAjax' );
Route::get('orderdeliverystatus', array('as' => 'create', 'uses' => 'AdminController@orderdeliverystatus'));
//Subadmin Controller
Route::get('subadmin/index', array('as' => 'create', 'uses' => 'SubadminController@index'));

Route::get('subadmin/products', array('as' => 'create', 'uses' => 'SubadminController@products'));
Route::get('vendors/bank','VendorsController@bank')->name('vendors.bank');

Route::post('vendors/bank/store','VendorsController@bank_store')->name('vendors.bank.store');

Route::get('vendors/settings','Vendor\SettingsController@settings')->name('vendor.settings');
Route::post('vendors/settings/update','Vendor\SettingsController@update')->name('vendor.settings.update');

Route::get('vendors/order','Vendor\OrderController@index')->name('vendor.order.index');

Route::post('vendor/order/status/{id}','Vendor\OrderController@status')->name('vendor.order.status');


Route::get('subadmin/viewproduct/{id}', array('as' => 'create', 'uses' => 'SubadminController@viewproduct'));

Route::post('subadmin/updateviewproduct/{id}', array('as' => 'create', 'uses' => 'SubadminController@updateviewproduct'));

Route::get('subadmin/addproduct', array('as' => 'create', 'uses' => 'SubadminController@addproduct'));

Route::post('subadmin/createproduct', array('as' => 'create', 'uses' => 'SubadminController@createproduct'));

Route::get('subadmin/vendors', array('as' => 'create', 'uses' => 'SubadminController@vendors'));

Route::get('subadmin/{id}/view', array('as' => 'viewvendors', 'uses' => 'SubadminController@viewvendors'));

Route::post('subadmin/{id}/editvendor', array('as' => 'create', 'uses' => 'SubadminController@editvendor'));

Route::group(['middleware' => 'vendore_user'], function () {
//Vendor Controller
Route::get('vendors/index', array('as' => 'create', 'uses' => 'VendorsController@index'));
Route::get('vendors/customer/create', array('as' => 'create', 'uses' => 'VendorsController@customer_create'));

    Route::post('vendors/customer/store', array('as' => 'create', 'uses' => 'VendorsController@customer_store'));
Route::get('vendors/products', array('as' => 'create', 'uses' => 'VendorsController@products'));
Route::get('vendor/deactivate_product/{id}', array('as' => 'create', 'uses' => 'VendorsController@deactive_product'));
Route::get('vendor/activate_product/{id}', array('as' => 'create', 'uses' => 'VendorsController@active_product'));
Route::get('vendors/viewproduct/{id}', array('as' => 'create', 'uses' => 'VendorsController@viewproduct'));

Route::post('vendors/updateviewproduct/{id}', array('as' => 'create', 'uses' => 'VendorsController@updateviewproduct'));

Route::get('vendors/addvendorproduct', array('as' => 'create', 'uses' => 'VendorsController@addvendorproduct'));

Route::post('vendor/createvendorproduct', array('as' => 'create', 'uses' => 'VendorsController@createvendorproduct'));

Route::get('vendors/requisition', array('as' => 'create', 'uses' => 'VendorsController@requisition'));
Route::get('cancelled/vendors/requisition', array('as' => 'create', 'uses' => 'VendorsController@cancelledrequisition'));
Route::get('vendors/ordersdetail/{id}', array('as' => 'create', 'uses' => 'VendorsController@ordersdetail'));

Route::get('vendors/credit_customers', array('as' => 'create', 'uses' => 'VendorsController@credit_customers'));
Route::get('vendors/favourite', array('as' => 'create', 'uses' => 'VendorsController@favourite'))->name('vendor.favourite');
    Route::get('vendors/favourite/customers',array('as' => 'create', 'uses' => 'VendorsController@favourite_customer'))->name('vendor.favourite_customer');

Route::get('vendors/reject/{id}', array('as' => 'create', 'uses' => 'VendorsController@reject'));
     Route::get('vendors/accept/{id}', array('as' => 'create', 'uses' => 'VendorsController@accept'));
Route::get('vendors/viewcustomers/{id}', array('as' => 'create', 'uses' => 'VendorsController@viewcustomers'));

Route::get('vendors/confirmcustomer', array('as' => 'create', 'uses' => 'VendorsController@confirmcustomer'));


Route::get('vendor/add_products', array('as' => 'create', 'uses' => 'Vendor\ProductController@create'));
Route::post('vendor/store_product', array('as' => 'create', 'uses' => 'Vendor\ProductController@store'));
Route::get('vendor/edit_product/{id}', array('as' => 'edit', 'uses' => 'Vendor\ProductController@edit'));
Route::post('vendor/updateproduct/{id}', array('as' => 'update', 'uses' => 'Vendor\ProductController@update'));
Route::get('vendor/delete_product/{id}', array('as' => 'edit', 'uses' => 'Vendor\ProductController@delete'));

Route::get('vendor/inventory', array('as' => 'edit', 'uses' => 'Vendor\ProductController@inventory'));
Route::post('vendor/add_inventory/{id}', array('as' => 'edit', 'uses' => 'Vendor\ProductController@add_inventory'));

Route::get('get_sub_catgory', array('as' => 'create', 'uses' => 'Vendor\ProductController@get_sub_catgory'));

});
//Home controller
Route::get('/', array('as' => 'create', 'uses' => 'HomeController@index'));

Route::get('category/{id}', array('as' => 'create', 'uses' => 'HomeController@category'))->middleware(['customer_user','category']);

Route::get('subcategory/{id}', array('as' => 'create', 'uses' => 'HomeController@subcategory'))->middleware(['customer_user','category']);
Route::get('subcategorylist/{id}','HomeController@subcategorylist')->name('subcategory.list');
Route::get('product/{id}', array('as' => 'create', 'uses' => 'HomeController@products'))->middleware('category');

Route::get('/login-register', array('as' => 'create', 'uses' => 'HomeController@login_register'));

Route::get('/signout', array('as' => 'create', 'uses' => 'HomeController@signout'));

Route::get('/loginuser', array('as' => 'create', 'uses' => 'HomeController@loginuser'));

Route::get('/signupuser', array('as' => 'create', 'uses' => 'HomeController@signupuser'));

Route::post('signup', array('as' => 'create', 'uses' => 'HomeController@signup'));

Route::post('signin', array('as' => 'create', 'uses' => 'HomeController@signin'));

Route::get('/vendors/{id}', array('as' => 'create', 'uses' => 'HomeController@getvendor'))->middleware(['auth','customer_user']);

Route::get('vendors/{id}/{cat}', array('as' => 'create', 'uses' => 'HomeController@getvendorcategory'));

Route::get('searchsiterequest', array('as' => 'create', 'uses' => 'HomeController@searchsiterequest'));

Route::get('searchautocomplete', array('as' => 'create', 'uses' => 'HomeController@searchautocomplete'));
Route::get('searchitems/{qq}','HomeController@searchitems')->name('search.items');
Route::get('searchcategory', array('as' => 'create', 'uses' => 'HomeController@searchcategory'));

Route::get('searchsubcategory', array('as' => 'create', 'uses' => 'HomeController@searchsubcategory'));

Route::get('addtowhishlist', array('as' => 'create', 'uses' => 'HomeController@addtowhishlist'));

Route::get('followvendor', array('as' => 'create', 'uses' => 'HomeController@followvendor'));

Route::get('allproudts', array('as' => 'create', 'uses' => 'HomeController@all_products'));
Route::get('vendortype/{id}', array('as' => 'create', 'uses' => 'HomeController@vendor_type_product'));
Route::get('shipo', array('as' => 'create', 'uses' => 'CustomersController@shipo'));

//customers controller
Route::get('addvendorproduct', array('as' => 'create', 'uses' => 'CustomersController@addvendorproduct'));

Route::get('/mycart', array('as' => 'create', 'uses' => 'CustomersController@viewcart'))->middleware('customer_user');

Route::get('/updateproduct', array('as' => 'create', 'uses' => 'CustomersController@updateproduct'));

Route::get('/checkout', array('as' => 'create', 'uses' => 'CustomersController@checkout'))->middleware('customer_user');

Route::post('/checkoutorder', array('as' => 'create', 'uses' => 'CustomersController@checkoutorder'));

Route::post('/checkoutorderoffline', array('as' => 'create', 'uses' => 'CustomersController@checkoutorderoffline'));

Route::post('/signincheckout', array('as' => 'create', 'uses' => 'CustomersController@signincheckout'));

Route::post('/deleteproduct', array('as' => 'create', 'uses' => 'CustomersController@deleteproduct'));

Route::get('/payorder/{id}', array('as' => 'payorder', 'uses' => 'CustomersController@payorder'));

Route::get('validatepayment', array('as' => 'create', 'uses' => 'CustomersController@validatepayment'));

Route::get('validatecashless', array('as' => 'create', 'uses' => 'CustomersController@validatepaymentcashless'));

Route::get('/ordersummary/{id}', array('as' => 'create', 'uses' => 'CustomersController@ordersummary'));

Route::get('/customers/dashboard', array('as' => 'create', 'uses' => 'CustomersController@dashboard'))->middleware(['auth','customer_user']);
Route::get('/customers/profile','CustomersController@profile')->name('customers.profile')->middleware(['auth','customer_user']);
Route::post('/customers/profile','CustomersController@updateProfile')->name('customers.profile.update');
Route::get('/customers/orders', array('as' => 'create', 'uses' => 'CustomersController@orders'))->middleware(['auth','customer_user']);

Route::get('/customers/ordersdetail/{id}', array('as' => 'create', 'uses' => 'CustomersController@ordersdetail'));

Route::get('/customers/wallet', array('as' => 'create', 'uses' => 'CustomersController@wallet'));

Route::get('/changeoderworkplace', array('as' => 'create', 'uses' => 'CustomersController@changeoderworkplace'));

Route::get('/changeoderdetailsworkplace', array('as' => 'create', 'uses' => 'CustomersController@changeoderdetailsworkplace'));

Route::get('/customers/report', array('as' => 'create', 'uses' => 'CustomersController@report'))->middleware(['auth','customer_user']);

Route::get('/getreportdate', array('as' => 'create', 'uses' => 'CustomersController@getreportdate'));

Route::get('customers/accounting', array('as' => 'create', 'uses' => 'CustomersController@accounting'))->middleware(['auth','customer_user']);

Route::get('addworkplace', array('as' => 'create', 'uses' => 'CustomersController@addworkplace'));

Route::get('customers/addsupplier', array('as' => 'create', 'uses' => 'CustomersController@addsupplier'))->middleware(['auth','customer_user']);
Route::get('/customers/reorder/{id}', array('as' => 'create', 'uses' => 'CustomersController@reorder'));

Route::get('getaccounting', array('as' => 'create', 'uses' => 'CustomersController@getaccounting'));

Route::get('getaccountingsum', array('as' => 'create', 'uses' => 'CustomersController@getaccountingsum'));

Route::get('addcustomersvendor', array('as' => 'create', 'uses' => 'CustomersController@addcustomersvendor'));

Route::get('searchdata', array('as' => 'create', 'uses' => 'CustomersController@searchdata'));

Route::get('customers/addvendor', array('as' => 'create', 'uses' => 'CustomersController@addvendor'));

Route::get('searchvendor', array('as' => 'create', 'uses' => 'CustomersController@searchvendor'));

Route::get('addcustvendor', array('as' => 'create', 'uses' => 'CustomersController@addcustvendor'));

Route::get('getsubcategory', array('as' => 'create', 'uses' => 'CustomersController@getsubcategory'));
Route::get('getcategory', array('as' => 'create', 'uses' => 'CustomersController@getcategory'));


Route::get('requestvendor', array('as' => 'create', 'uses' => 'CustomersController@requestvendor'));

Route::get('requestvendorid', array('as' => 'create', 'uses' => 'CustomersController@requestvendorid'));
Route::get('requestuserid', array('as' => 'create', 'uses' => 'CustomersController@requestvendorsid'));

Route::get('getreportsum', array('as' => 'create', 'uses' => 'CustomersController@getreportsum'));

Route::get('getaccountsum', array('as' => 'create', 'uses' => 'CustomersController@getaccountsum'));

Route::get('addreview', array('as' => 'create', 'uses' => 'CustomersController@addreview'));

Route::get('wallet', array('as' => 'create', 'uses' => 'CustomersController@wallet'));

Route::get('addfund', array('as' => 'create', 'uses' => 'CustomersController@addfund'));

Route::get('customers/accounthistory', array('as' => 'create', 'uses' => 'CustomersController@accounthistory'));

Route::get('customers/walletsetting', array('as' => 'create', 'uses' => 'CustomersController@walletsetting'))->middleware(['auth','customer_user']);

Route::get('paywithwallet', array('as' => 'create', 'uses' => 'CustomersController@paywithwallet'));

Route::get('changewalletpassword', array('as' => 'create', 'uses' => 'CustomersController@changewalletpassword'));

Route::get('customers/dueandoutstanding', array('as' => 'create', 'uses' => 'CustomersController@dueandoutstanding'))->middleware(['auth','customer_user']);

Route::get('sendduedate', array('as' => 'create', 'uses' => 'CustomersController@sendduedate'));

Route::get('paywithwalletoutstand', array('as' => 'create', 'uses' => 'CustomersController@paywithwalletoutstand'));

Route::get('paywallet', array('as' => 'create', 'uses' => 'CustomersController@paywallet'));

Route::get('paywithcard', array('as' => 'create', 'uses' => 'CustomersController@paywithcard'));

Route::get('stripe', 'StripeController@payWithStripe')->name('stripform');
// Route for stripe post request.
Route::post('stripe', 'StripeController@postPaymentWithStripe')->name('addmoney/stripe');



    Route::get('payment-status',array('as'=>'payment.status','uses'=>'PaymentController@paymentInfo'));
    Route::get('payment',array('as'=>'payment','uses'=>'PaymentController@payment'));
    Route::get('payment-cancel', function () {
       return 'Payment has been canceled';
    });


//terms and condition url for admin
    Route::get('customers/terms/create','TermsconditionController@getcustomerterms')->name('customers.terms.create');

Route::post('customer/terms/update','TermsconditionController@customerterms')->name('customer.terms.update');
Route::get('vendor/terms/create','TermsconditionController@getvendorterms')->name('vendor.terms.create');
Route::post('vendor/terms/information','TermsconditionController@companyinformation')->name('vendor.terms.information');

Route::get('vendor/terms/informations','TermsconditionController@informations')->name('vendor.terms.informations');
Route::get('general/terms/create','TermsconditionController@createPage')->name('vendor.terms.create.page');
Route::get('general/terms/{id}','TermsconditionController@generalterms')->name('vendor.terms.general');
Route::post('vendor/terms/update','TermsconditionController@vendorterms')->name('vendor.terms.update');
Route::post('general/terms/{id}','TermsconditionController@generaltermsupdate')->name('general.terms.update');
Route::post('general/terms/','TermsconditionController@generaltermsstore')->name('general.terms.store');
Route::get('general/terms/','TermsconditionController@pages')->name('general.terms.pages');
Route::get('general/terms/delete/{id}','TermsconditionController@generaltermsdelete')->name('general.terms.delete');
Route::get('customer/terms/conditions','TermsconditionController@showcustomerterms')->name('customer.terms.show')->middleware('guest');

Route::get('vendor/terms/conditions','TermsconditionController@showvendorterms')->name('customer.terms.show')->middleware('guest');
Route::get('general/terms/view/{id}','TermsconditionController@getgeneralterms')->name('general.terms.view');
Route::get('verify/{email}/{token}','HomeController@verify')->name('verify.user');

Route::get('currency','HomeController@currency')->name('currency.changer');

Route::get('requestforQuatation','CustomersController@quatation')->middleware('customer_user')->name('customer.quatation');



Route::get('customer/vendors/list','CustomersController@vendorsList')->name('vendors.customer.list')->middleware(['auth','customer_user']);
Route::get('vendorsearch','CustomersController@vendorsearchr')->name('vender.customer.search');

Route::get('searchterms','HomeController@searchterms')->name('search.filter');


Route::get('vendor/country','HomeController@vendorcountry')->name('vendor.country');
Route::get('vendor/state','HomeController@vendorstate')->name('vendor.state');
Route::get('vendor/country/a','HomeController@vendorcountrybil')->name('vendor.country.a');
Route::get('vendor/state/v','HomeController@vendorstatebil')->name('vendor.state.b');
View::composer('includes_vendor.header',function ($view){
    $notifications = Auth::User()->notifications()->latest()->get();
    $view->with('notifications',$notifications);
});

Route::get('create/rfq','CustomersController@create_rfq')->middleware(['auth','customer_user'])->name('create.rfq');
Route::post('create/rfq','CustomersController@store_rfq')->middleware('customer_user')->name('create.rfq');
Route::get('vendor/rfq','CustomersController@vendorRFQ')->middleware('vendore_user')->name('vendor.rfq');
Route::post('vendor/rfq/{id}','CustomersController@placebid')->middleware('vendore_user')->name('place.bid');
Route::get('admin/rfq','AdminController@adminRFQ')->middleware('admin_user')->name('admin.rfq');
Route::get('rfq/selected/{id}/{vendor_id}','CustomersController@selected')->middleware('auth')->name('rfq.selected');
//Route::get('admin/rfq','CustomersController@adminRFQ')->middleware('admin_user')->name('admin.rfq');
Route::get('admin/lowstock','CustomersController@lowstock')->middleware('admin_user')->name('admin.rfq');
Route::get('customers/rfq','CustomersController@customerRFQ')->middleware(['auth','customer_user'])->name('customer.rfq');
Route::get('category/for/rfq','CustomersController@getsubcategory_for_rfq')->middleware('customer_user')->name('category.for.rfq');
Route::get('view/quotations/{id}','CustomersController@viewquotes')->middleware('customer_user')->name('view.quotations');
Route::get('vendor/promote_product/{id}','VendorsController@promote_product')->middleware('vendore_user')->name('vendor.promote.product');
Route::get('admin/promote/{id}','AdminController@promoteProduct')->middleware('admin_user')->name('admin.promote.product');
Route::get('admin/cancelPromotion/{id}','AdminController@cencelPromotion')->middleware('admin_user')->name('admin.cancel.promotion');
Route::post('customer/send/message','messageController@create')->middleware('customer_user')->name('customer.send.message');
Route::get('vendor/message/panel','messageController@index')->middleware('vendore_user')->name('vendor.message.panel');
Route::get('vendor/message/{id}','messageController@user')->middleware('vendore_user')->name('vendor.message.useer');
Route::post('vendor/reply/{id}','messageController@reply')->middleware('vendore_user')->name('vendor.reply');
Route::get('admin/message/panel','messageController@admin')->middleware('admin_user')->name('admin.message.panel');
Route::get('admin/messages/{id}','messageController@customer_list')->middleware('admin_user')->name('admin.vendor.list');
Route::get('admin/messages/{vendor_id}/{cus_id}','messageController@customer_message')->middleware('admin_user')->name('admin.message.customer');
Route::get('favorite/credit/vendors','CustomersController@showfavorite')->middleware('customer_user')->name('favorite.credit.vendors');
Route::get('favorite/vendor','CustomersController@setfavorite')->middleware('customer_user')->name('favorite.set');
Route::get('unfavorite/vendor','CustomersController@unfavorite')->middleware('customer_user')->name('unfavorite.set');
Route::get('unread/messages','messageController@unreadVendors')->middleware('vendore_user')->name('unread.message');
Route::get('unread/messages/customer','messageController@unreadcustomer')->middleware('customer_user')->name('customer.unread.message');
Route::get('manufacture/approve/page','Admin\ManufactureController@approve')->middleware('admin_user')->name('admin.manufacture.approve');
Route::get('model/approve/page','Admin\ModelController@approve')->middleware('admin_user')->name('admin.model.approve');
Route::get('admin/model/{id}/approve','Admin\ModelController@approveModel')->middleware('admin_user')->name('admin.model.approved');
Route::get('admin/model/{id}/reject','Admin\ModelController@reject')->middleware('admin_user')->name('admin.model.reject');
Route::get('admin/manufacture/{id}/approve','Admin\ManufactureController@approveman')->middleware('admin_user')->name('admin.manufacture.approved');
Route::get('admin/manufacture/{id}/reject','Admin\ManufactureController@reject')->middleware('admin_user')->name('admin.manufacture.reject');
Route::post('workplace/selected/{id}','CustomersController@workplaceSelected')->middleware('customer_user')->name('workplace.selected.item');
Route::post('/pay/{option?}', 'StripeController@redirectToGateway')->name('pay'); 
Route::get('/payment/callback', 'StripeController@handleGatewayCallback');
Route::post('payondeliver/{id}','CustomersController@updateDeliveryoption')->name('payondeliver.update');
Route::post('pay/bank/wallet','StripeController@paywallet')->name('pay.bank.wallet.paid')->middleware('auth');
Route::post('pay/bank/checkout','StripeController@paybank')->name('pay.bank.checkout')->middleware('auth');
Route::get('wishlist','CustomersController@wishlist')->name('wishlist.list')->middleware(['auth','customer_user']);
Route::get('admin/wallet/pending','StripeController@pending')->name('admin.wallet.pending')->middleware('admin_user');
Route::get('admin/wallet/approved','StripeController@approved')->name('admin.wallet.approved')->middleware('admin_user');
Route::get('wallet/pending/{id}/{user_id}','StripeController@approve_wallet')->name('approve.wallet')->middleware('admin_user');
Route::get('recover/password','HomeController@recover');
Route::get('/reset/password/{email}/{token}','HomeController@reset');
Route::get('reset/password/newpassword','HomeController@newpass');
Route::get('admin/products/list','AdminController@ProductsList')->name('admin.products.list')->middleware('admin_user');
Route::get('set/sortby','AdminController@sortby');
Route::get('set/sortby/vendor','AdminController@sortvendor');
Route::get('set/pagination','AdminController@paginations');
Route::get('admin/update/payment/{id}','AdminController@verifypayment')->name('admin.verify.payment')->middleware('admin_user');
Route::get('venodors/credit/customer/{id}','VendorsController@updatecredit')->name('vendor.credit.limit')->middleware('vendore_user');
Route::get('get_payment/{id}','AdminController@getpayment')->name('get.payment.COD')->middleware('admin_user');
Route::get('admin/shipping/manual_shipping','Admin\ProductController@mannual_shipping')->name('admin.shipping.manual_shipping')->middleware('admin_user');
Route::get('admin/shipping/manual_shipping/{shipping}','Admin\ProductController@edit_mannual_shipping')->name('admin.shipping.edit_manual_shipping')->middleware('admin_user');
Route::post('admin/shipping/manual_shipping/{shipping}','Admin\ProductController@update_mannual_shipping')->name('admin.shipping.update_manual_shipping')->middleware('admin_user');
Route::post('admin/shipping/mannual_shipping','Admin\ProductController@save_mannual')->name('admin.shipping.save.manual_shipping')->middleware('admin_user');
Route::post('newsletter','HomeController@newsletter')->name('newsletter.save');
Route::post('contact_us','HomeController@contact_us')->name('contact_us.send');
Route::get('page/contact_us','HomeController@pagecontact')->name('contact_us.page');
Route::get('bank/order/{id}','StripeController@bankOrderSummary')->middleware('auth')->name('bank.order.summary');
Route::get('customers/workplace','CustomersController@workplace')->middleware(['auth','customer_user'])->name('customer.workplace');
Route::get('admin/units','HomeController@units')->middleware('admin_user');
Route::get('admin/add_unit','HomeController@addunit')->middleware('admin_user');
Route::post('admin/add_unit','HomeController@saveunit')->middleware('admin_user');
Route::get('admin/unit/{id}','HomeController@editunit')->middleware('admin_user');
Route::post('admin/unit/{id}','HomeController@updateunit')->middleware('admin_user');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('recept/{ordernumber}','StripeController@ordersrecept')->middleware('auth')->name('customer.recept');
Route::get('admin/posted/payment/{id}','AdminController@postPayment')->middleware('admin_user')->name('admin.posted.payment');
Route::get('admin/cancel/payment/{id}','AdminController@cancelpostPayment')->middleware('admin_user')->name('admin.posted.payment');
Route::get('outstanding/slip/{id}/{paymenttype?}','StripeController@outstandingBankPayment')->middleware('auth')->name('customer.outstanding.payment');
Route::get('admin/outstandingdue/payment/approve','StripeController@dueandoutstandingpayment');
Route::get('admin/outstandingdue/amount/pay/{id}','StripeController@markasapproved');
Route::get('admin/news/letter','AdminController@newsletters');