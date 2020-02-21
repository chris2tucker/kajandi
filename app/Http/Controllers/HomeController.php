<?php

namespace App\Http\Controllers;

use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facade;
use App\category;
use App\subcategory;
use App\vendors;
use App\User;
use App\productmodel;
use App\products;
use App\vendorproduct;
use App\condition;
use App\wallet;
use App\productmanufacturer;
use App\productaddon;
use App\source;
use App\strengthofmaterial;
use App\productimages;
use App\Role;
use App\carts;
use App\ordersdetail;
use App\orders;
use App\workplace;
use App\customersvendor;
use App\wishlist;
use App\city;
use App\review;
use App\customersverification;
use App\outstandingpayment;
use App\PaymentDeliveryInformation;
use carbon\Carbon;
use App\unit;
use Cart;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Customer;
use Session;
use App\SocialLinks;
use App\walletusers;
use Illuminate\Support\Facades\Mail;
use App\Mail\validationMail;
use App\Mail\contact_us;
use App\Mail\resetpassword;
use App\currency;
use Search;
use App\shippingInformations;
use App\Notification;
use App\favoritevendor;
use App\term;
use App\newslatter;
class HomeController extends Controller
{
    public function recover(Request $Request){
        if($Request->ajax()){
            $email=$Request->get('email');
            $User=User::where('email','=',$email)->first();
            if($User){
                $User->remember_token=Str::random(70);
                $User->save();
                 Mail::to($User->email)->send(new resetpassword($User));
                return json_encode(1);
            }
            else{
                return json_encode(0);
            }
        }
    }
    public function reset($email,$token){
    $user=User::where('email','=',$email)->where('remember_token','=',$token)->first();
    if($user){
    session()->flash('userid', $user->id);  
}
    return redirect('/');
    }
    public function newpass(Request $Request){
        if($Request->ajax()){
            $newpassword=$Request->get('password');
            $id=$Request->get('id');
            $user=User::find($id);
            if($user){
                $user->password=Hash::make($newpassword);
                $user->remember_token=NULL;
                $user->save();
                return json_encode($user);
            }
           
        }
    }

    public function approve($id)
    {
         $ordersdetail = orders::find($id);
        $ordersdetail->deliverystatus = 'delivered';
        $ordersdetail->save();
        $orders=ordersdetail::where('ordernumber','=',$ordersdetail->ordernumber)->get();
        foreach ($orders as $order) {
           $order->deliverystatus='delivered';
           $order->deliverydate=Carbon::now()->toDateString();
           $order->save();
        }


        return back();
    }

    public function delivered($id)
    {
        $ordersdetail = ordersdetail::find($id);
        $ordersdetail->deliverystatus = 0;
        $ordersdetail->save();


        return back();
    }

    public function index()
    {
        $cart = $this->cart();
        $banar_data = DB::table('banner')->get();
        $catagory = DB::table('categories')
                        ->select('categories.*','categories.name as cat_name','categories.slog as cat_slog','categories.id as id')
                        ->where('categories.add_menu','yes')
                        ->get();
                        //side menu
                        $category = DB::table('categories')
                        ->select('categories.*','categories.name as cat_name','categories.slog as cat_slog','categories.id as id')
                        ->get();
        $catagories = DB::table('categories')
                        ->select('categories.*','categories.name as cat_name','categories.slog as cat_slog','categories.id as id')
                        ->get();

        $sub_cat =  array();
        foreach ($catagory as $key) {

             $subcatagory = DB::table('subcategories')
                        ->select('subcategories.*','subcategories.name as Sub_name','subcategories.slog as sub_slog','subcategories.category_id as category_id')
                        ->where('category_id',$key->id)
                    ->get();
            $sub_cat[$key->id] = $subcatagory;
            
        }
        $sub_cate =  array();
        foreach ($category as $key) {

             $subcategory = DB::table('subcategories')
                        ->select('subcategories.*','subcategories.name as Sub_name','subcategories.slog as sub_slog','subcategories.category_id as category_id')
                        ->where('category_id',$key->id)
                    ->get();
            $sub_cate[] = $subcategory;
            
        }

         $adv_sec_1 = DB::table('adv_sec_1')
                            ->select('adv_sec_1.*','vendors.vendorname','vendorproduct.name','adv_sec_1.id as id','vendorproduct.*','vendorproduct.slog as p_slog','adv_sec_1.image as img')
                            ->leftjoin('vendors','vendors.id','=','adv_sec_1.vendor_id')
                           ->leftjoin('vendorproduct','vendorproduct.id','=','adv_sec_1.product_id')->get();

        $adv_sec_2 =DB::table('adv_sec_2')
                            ->select('adv_sec_2.*','vendors.vendorname','vendorproduct.name','adv_sec_2.id as id','vendorproduct.*','vendorproduct.slog as p_slog','adv_sec_2.image as img')
                            ->leftjoin('vendors','vendors.id','=','adv_sec_2.vendor_id')
                           ->leftjoin('vendorproduct','vendorproduct.id','=','adv_sec_2.product_id')->get();


        $today_featured = DB::table('today_featured')
                            ->select('today_featured.*','vendors.*','vendorproduct.*','today_featured.id as id','today_featured.image as today_image')
                           ->leftjoin('vendors','vendors.id','=','today_featured.vendor_id')
                           ->leftjoin('vendorproduct','vendorproduct.id','=','today_featured.vendor_product_id')
                            ->get();
        $social_link = SocialLinks::first();
        //dd($social_link);
       Session::put('catagory', $catagory);
       Session::put('sub_cat',$sub_cat);
       Session::put('social_link',$social_link);

      


       


        return view('home.index', compact('cart','banar_data','catagory','category','sub_cate','sub_cat','adv_sec_1','adv_sec_2','catagories','today_featured'));
    }

    public static function cart()
    {
        $myurl =  asset('/');

        # code...
        $view = '';
        $totalamt = 0;
        if (Auth::check()) {
            $getcart = carts::where('user_id', Auth::user()->id)->first();
            if ($getcart) {
                $getcart = carts::where('user_id', Auth::user()->id)->get();

                $view .= "<ul class='dropdown-menu dropdown-menu-shipping-cart' style='z-index: 9999;'>";

                foreach($getcart as $row) {

                    $getproducts = vendorproduct::where('id', $row->product_id)->first();
                    //dd($getproducts);
                    $products = products::where('id', $getproducts->product_id)->first();

                    if(!empty($getproducts->image)){
                        $image = $getproducts->image;
                    }
                    else{
                        $image = $products->image;
                    }

                    $total = number_format($row->totalprice);
                    $totalamt +=$row->totalprice;

                    
                            $view  .=  "<li>
                                    <a class='dropdown-menu-shipping-cart-img' href='$myurl/product/$getproducts->slog'>
                                        <img src='$myurl/$image' alt='Image Alternative text' title='Image Title'>
                                    </a>
                                    <div class='dropdown-menu-shipping-cart-inner'>
                                        <p class='dropdown-menu-shipping-cart-price'>".HomeController::converter($row->totalprice)."</p>
                                        <p class='dropdown-menu-shipping-cart-item'><a href='$myurl/product/$row->product_id'>$products->name</a>
                                        </p>
                                    </div>
                                </li>";
                }
                $totalamt = ($totalamt);

                            $view .= "<li>
                                    <p class='dropdown-menu-shipping-cart-total'>Total: ".HomeController::converter($totalamt)."</p>
                                    <a href='$myurl/mycart' class='dropdown-menu-shipping-cart-checkout btn btn-primary'>Cart</a>
                                </li>
                            </ul>";

            }else{
                $view = "<ul class='dropdown-menu dropdown-menu-shipping-cart' style='z-index: 9999;'>
                <div class='text-center'><i class='fa fa-cart-arrow-down empty-cart-icon'></i>
                <p class='lead'>You haven't Fill Your Shopping Cart Yet</p><a class='btn btn-primary btn-lg' href='$myurl'>Start Shopping <i class='fa fa-long-arrow-right'></i></a>
            </div></ul>";
            }
        }else{

            $getcart = Cart::count();

            if ($getcart >= 1) {
                $cartbag = 'not empty';

                $view .= "<ul class='dropdown-menu dropdown-menu-shipping-cart' style='z-index: 9999;'>";

        foreach(Cart::content() as $row) {


        $getproducts = vendorproduct::where('id', $row->id)->first();
        $products = products::where('id', $getproducts->product_id)->first();

        if(!empty($getproducts->image)){
            $image = $getproducts->image;
        }
        else{
            $image = $products->image;
        }

            $price = number_format($row->price);
            $total = number_format($row->total);
            $subtotal = Cart::subtotal();
            $tax = Cart::tax();
            $totalamt = Cart::total();


            $view  .=  "<li>
                                    <a class='dropdown-menu-shipping-cart-img' href='$myurl/product/$row->options->size'>
                                        <img src='$myurl/$image' alt='Image Alternative text' title='Image Title'>
                                    </a>
                                    <div class='dropdown-menu-shipping-cart-inner'>
                                        <p class='dropdown-menu-shipping-cart-price'>$$total</p>
                                        <p class='dropdown-menu-shipping-cart-item'><a href='$myurl/product/$row->id'>$products->name</a>
                                        </p>
                                    </div>
                                </li>";
        }
            $view .= "<li>
                                    <p class='dropdown-menu-shipping-cart-total'>Total: $$totalamt</p>
                                    <a href='$myurl/mycart' class='dropdown-menu-shipping-cart-checkout btn btn-primary'>Cart</a>
                                </li>
                            </ul>";
    }else{
        $cartbag = '';

        $view = "<ul class='dropdown-menu dropdown-menu-shipping-cart'>
                <div class='text-center'><i class='fa fa-cart-arrow-down fa-4x'></i>
                <p class='lead' style='font-size: 16px'>You haven't Fill Your Shopping Cart Yet</p><a class='btn btn-primary btn-lg' href='$myurl'>Start Shopping <i class='fa fa-long-arrow-right'></i></a>
            </div></ul>";

    }


        }

        return $view;
    }

    public function login_register()
    {
        $cart = $this->cart();
        return view('home.login_register', compact('cart'));
    }

    public function signin()
    {
        $this->validate(request(), [

            'email' => 'required|email',
            'password' => 'required'

            ]);

        $email = request('email');
        $password = request('password');

        if (Auth::attempt(['email' => $email, 'password' => $password])) {

            if (Auth::user()->user_type == 'Admin') {
                return view('admin.index');
            }elseif (Auth::user()->user_type == 'Sub-Admin') {
                return view('subadmin.index');
            }
            elseif (Auth::user()->user_type == 'Vendor') {
                return redirect('vendors/index');

            }elseif (Auth::user()->user_type == 'Customer') {
                $getcart = Cart::count();

                if ($getcart >= 1) {
                    # code...

                    foreach(Cart::content() as $row) {


            $getproducts = vendorproduct::where('id', $row->id)->first();
            $products = products::where('id', $getproducts->product_id)->first();
            $getcart = carts::where('product_id', $row->id)->where('user_id', Auth::user()->id)->first();

            if ($getcart) {
                $getcartqty = $getcart->quantity;
                $newqty = $getcartqty + $row->qty;
                $totalprice = $newqty * $row->price;
                $updatecart = carts::where('product_id', $row->id)->where('user_id', Auth::user()->id)->update(array('quantity' =>  $newqty, 'totalprice' => $totalprice));
            }else{
                $cart = new carts;
                $cart->user_id = Auth::user()->id;
                $cart->product_id = $row->id;
                $cart->price = $row->price;
                $cart->quantity = $row->qty;
                $cart->totalprice = $row->total;
                $cart->save();
            }

            
                
            }
            Cart::destroy();

                }
                return redirect()->intended('/');
            }

            

        }

        session()->flash('status', 'E-mail or Password incorrect');  
        return back()->with('status', 'E-mail or Password incorrect'); 

    }

    public function signup(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'phone'=>'required|numeric',
            /*'company_name' => 'required',
            'about_company' => 'required',
            'website_url' => 'required',
            'cac_number' => 'required',
            'type_of_business' => 'required',
            'year_of_existence' => 'required',
            'phone_of_MD_Chairman' => 'required',
            'email_of_MD_Chairman' => 'required',
            'phone_of_contact_person' => 'required',
            'email_of_contact_person' => 'required',
            'company_rating' => 'required',*/


            ]);

        $email = request('email');
        $password = request('password');
        $name = request('name');

        $role_customer = Role::where('name', 'Customer')->first();

        $user = new User;
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->verification_token=Str::random(60);
        $user->user_uniqueid=uniqid();
        $user->user_type = 'Customer';
        if($user->save())
         {
            $customer = new Customer;
            $customer->company_name = request('company_name');
            $customer->name = $name;
            $customer->user_id = $user->id;
            $customer->user_type='Customer';
            $customer->about = request('about_company');
            $customer->website = request('website_url');
            $customer->cac = request('cac_number');
            $customer->businesstype = request('type_of_business');
            $customer->yearsofexitence = request('year_of_existence');
            $customer->mdtel = request('phone_of_MD_Chairman');
            $customer->mdemail = request('email_of_MD_Chairman');
            $customer->contactpersontel = request('phone_of_contact_person');
            $customer->contactpersonemail  = request('email_of_contact_person');
            $customer->company_rating  = request('company_rating');
            $customer->save();


         }

        $user->roles()->attach($role_customer);
        $welletuser = new walletusers;
        $welletuser->user_id = $user->id;
        $welletuser->password = request('password');
        $welletuser->save();
        if($welletuser){
            $wallet=new wallet;
            $wallet->user_id=$user->id;
            $wallet->balance=0;
            $wallet->save();
        }
        if (Auth::attempt(['email' => $email, 'password' => $password])) {

            $getcart = Cart::count();

            if ($getcart >= 1) {
                # code...

                foreach(Cart::content() as $row) {


        $getproducts = vendorproduct::where('id', $row->id)->first();
        $products = products::where('id', $getproducts->product_id)->first();
        $getcart = carts::where('product_id', $row->id)->where('user_id', Auth::user()->id)->first();

        if ($getcart) {
            $getcartqty = $getcart->quantity;
            $newqty = $getcartqty + $row->qty;
            $totalprice = $newqty * $row->price;
            $updatecart = carts::where('product_id', $row->id)->where('user_id', Auth::user()->id)->update(array('quantity' =>  $newqty, 'totalprice' => $totalprice));
        }else{
            $cart = new carts;
            $cart->user_id = Auth::user()->id;
            $cart->product_id = $row->id;
            $cart->price = $row->price;
            $cart->quantity = $row->qty;
            $cart->totalprice = $row->total;
            $cart->save();
        }

        
            
        }
        Cart::destroy();

            }
                Mail::to($request->email)->send(new validationMail($user));
            return redirect()->intended('/');
        }
    }

    public function signout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function category($id)
    {
        $sortIdentity='id';
        $sorting='ASC';
        if(Session::has('sortby')){
        if(Session::get('sortby')=='Newest First'){
            $sortIdentity='id';
            $sorting='ASC';
        }
        else if(Session::get('sortby')=='Price : Lowest First'){
            $sortIdentity='price';
        $sorting='ASC';
        }
        else if(Session::get('sortby')=='Price : Highest First'){
            $sortIdentity='price';
        $sorting='DESC';
        }
        else if(Session::get('sortby')=='Title : A - Z'){
            $sortIdentity='name';
        $sorting='ASC';
        }
        else{
$sortIdentity='name';
        $sorting='DESC';
        }
    }
    $pagination=20;
    if(Session::has('pagination')){
        if(Session::get('pagination')=='9 / page'){
            $pagination=9;
        }
        else if(Session::get('pagination')=='12 / page'){
            $pagination=12;
        }
        else if(Session::get('pagination')=='18 / page'){
            $pagination=18;
        }
        else{
            $pagination=20;
        }
    }

        $getcat = category::where('slog', $id)->first();
        $id = $getcat->id;

        $getcategory = category::where('id', $id)->first();
        $getsubcategory = subcategory::where('category_id', $id)->get();
        $getproducts = vendorproduct::where('category', $id)->where('product_status','1')->where('availability','=','yes')->orderBy($sortIdentity,$sorting)->paginate($pagination);
        
        $getproductmanu = vendorproduct::where('category', $id)->where('product_status','1')->groupBy('manufacturer_id')->get();
        $getproductmodel = vendorproduct::where('category', $id)->where('product_status','1')->groupBy('model_id')->get();
        $getproductcondition = vendorproduct::where('category', $id)->groupBy('condition_id')->get();
        $getsource = vendorproduct::where('category', $id)->groupBy('source_id')->get();
        $getaddon = vendorproduct::where('category', $id)->groupBy('addon_id')->get();
        $getpaymentmethod=DB::select("SELECT * FROM vendorproduct,payment_delivery_information WHERE vendorproduct.product_id=payment_delivery_information.product_id AND vendorproduct.category=$id GROUP BY payment_delivery_information.payment_mehod ");
        $getunit=vendorproduct::where('category',$id)->where('unit','!=',NULL)->groupBy('unit')->get();
       
        $getcolor=vendorproduct::where('category',$id)->groupBy('color')->get();
        $getlocation=DB::select('SELECT * FROM vendorproduct,vendors WHERE vendorproduct.user_id=vendors.user_id AND vendorproduct.category='.$id.' GROUP BY vendors.location');
        $getsupply_type=vendorproduct::where('category',$id)->groupBy('supplyType')->get();
        
        $model = '';
        $countmanu = '';
        $countmodel = '';
        $manufacturer = '';
        $condition = '';
        $source = '';
        $addon = '';
        $deliverytype='';
        $units='';
        $countunits='';
        $colors='';
        $countcolors='';
        $location='';
        $countlocation='';
        $supply='';
        $countsupply='';
        foreach ($getproductmanu as $key) {
        
            $getmanu = productmanufacturer::where('id', $key->manufacturer_id)->first();
            $countmanu = vendorproduct::where('category', $id)->where('manufacturer_id', $key->manufacturer_id)->count();
            if($getmanu){
            $manufacturer .= "<div class='checkbox'>
                                <label>
                                    <input class='form iCheck-helper' name='manufacturer[]' type='checkbox' value=$key->manufacturer_id style='position:relative;'/>$getmanu->name<span class='category-filters-amount'>($countmanu)</span>
                                </label>
                            </div>";
                        }

        }

        foreach ($getproductmodel as $keys) {
            $getmodel = productmodel::where('id', $keys->model_id)->first();
            $countmodel = vendorproduct::where('category', $id)->where('model_id', $keys->model_id)->count();
            if($getmodel){
            $model .= "<div class='checkbox'>
                                <label>
                                    <input class=' form iCheck-helper' name='model[]' type='checkbox' style='position:relative;' value=$keys->model_id />$getmodel->name<span class='category-filters-amount'>($countmodel)</span>
                                </label>
                            </div>";
                        }
        }

        foreach ($getproductcondition as $keys) {
        
            $getcondition = condition::where('id', $keys->condition_id)->first();
            $countcondition = vendorproduct::where('category', $id)->where('condition_id', $keys->condition_id)->count();
            if($getcondition){
            $condition .= "<div class='checkbox'>
                                <label>
                                    <input class='form iCheck-helper' name='condition[]' type='checkbox' style='position:relative;' value=$keys->condition_id />$getcondition->name<span class='category-filters-amount'>($countcondition)</span>
                                </label>
                            </div>";
                        }
        }
        foreach ($getsource as $keys) {
            $getsource = source::where('id', $keys->source_id)->first();
            if($getsource){
            $countsource = vendorproduct::where('category', $id)->where('source_id', $keys->source_id)->count();
            $source .= "<div class='checkbox'>
                                <label>
                                    <input class='form iCheck-helper' name='source[]' type='checkbox' style='position:relative;' value=$keys->source_id />$getsource->name<span class='category-filters-amount'>($countsource)</span>
                                </label>
                            </div>";
                        }
        }

         foreach ($getpaymentmethod as $method) {
            
           /* $getsource = source::where('id', $keys->source_id)->first();
            if($getsource){
            $countsource = vendorproduct::where('category', $id)->where('source_id', $keys->source_id)->count(); */
            if($method->payment_mehod){
            $deliverytype .= "<div class='checkbox'>
                                <label>
                                    <input class='form iCheck-helper' name='payment[]' type='checkbox'  value=$method->payment_mehod style='position:relative;' />$method->payment_mehod<span class='category-filters-amount'></span>
                                </label>
                            </div>";
                        }
                    }
                    foreach ($getunit as $uni) {
                            $countunits=vendorproduct::where('category',$id)->where('unit','=',$uni->unit)->count();
                             if($countunits>0){
         $units .= "<div class='checkbox'>
                                <label>
                                    <input class=' form iCheck-helper' name='units[]' type='checkbox' style='position:relative;' value='$uni->unit' />$uni->unit<span class='category-filters-amount'>($countunits)</span>
                                </label>
                            </div>";
                        }
                    }
                    
                    foreach ($getcolor as $color) {
                       if($color->color){
                            $countcolors=vendorproduct::where('category',$id)->where('color','=',$color->color)->count();
                             if($countcolors>0){
                       
         $colors .= "<div class='checkbox'>
                                <label>
                                    <input class=' form iCheck-helper' name='color[]' type='checkbox' style='position:relative;' value=$color->color />$color->color<span class='category-filters-amount'>($countcolors)</span>
                                </label>
                            </div>";
                        }
                    }
                    }
                    foreach ($getlocation as $locations) {
                     
                            $countlocation=vendors::where('location','=',$locations->location)->count();

                             if($countlocation>0){
                        
         $location .= "<div class='checkbox'>
                                <label>
                                    <input class=' form iCheck-helper' name='location[]' type='checkbox' style='position:relative;' value=$locations->location />$locations->location<span class='category-filters-amount'>($countlocation)</span>
                                </label>
                            </div>";
                        }
                    
                    }
             foreach ($getsupply_type as $supplytype) {
                     
                          
                       if($supplytype->supplyType){
                            $countsupply=vendorproduct::where('category',$id)->where('supplyType','=',$supplytype->supplyType)->count();
                             if($countsupply>0){
                       
         $supply .= "<div class='checkbox'>
                                <label>
                                    <input class=' form iCheck-helper' name='supply[]' type='checkbox' style='position:relative;' value=$supplytype->supplyType />$supplytype->supplyType<span class='category-filters-amount'>($countsupply)</span>
                                </label>
                            </div>";
                        }
                    }
                    
                    
                    }

      /*  foreach ($getaddon as $keys) {
            $getadd = productaddon::where('id', $keys->addon_id)->first();
            $countaddon = vendorproduct::where('category', $id)->where('addon_id', $keys->addon_id)->count();
            $addon .= "<div class='checkbox'>
                                <label>
                                    <input class='i-check form iCheck-helper' name='addon[]' type='checkbox' value=$keys->addon_id />$getadd->name<span class='category-filters-amount'>($countaddon)</span>
                                </label>
                            </div>";
        }
*/
        $view = '';     

        foreach($getproducts as $key){

            $products = products::where('id', $key->product_id)->first();

        if(!empty($key->image)){
            $image = $key->image;
        }
        else{
            $image = $products->image;
        }

        $price = number_format($key->price);


        $view .= "";
        }


    $cart = $this->cart();
        return view('home.category', compact('getcategory', 'getproducts','getsubcategory', 'view', 'cart', 'manufacturer', 'model', 'condition', 'source', 'addon', 'id','deliverytype','units','colors','location','supply'));
    }

    public function products($id)
    {
        $slog = explode("_", $id);
        $id = end($slog);

        $myurl =  asset('/');
        $user = \Auth::User();
        if($user)
        {
        $userid = $user->id;
        }else{
            $userid = 0;
        }

        $getproducts = vendorproduct::where('id', $id)->first();

        $vendor_product = DB::table('vendorproduct')
                            ->select('vendorproduct.*','payment_delivery_information.*')
                           ->leftjoin('payment_delivery_information','payment_delivery_information.product_id','=','vendorproduct.id')
                            ->where('vendorproduct.id', $id)->first();
        

        $products = products::where('id', $getproducts->product_id)->first();
        $category = category::where('id', $getproducts->category)->first();
        $subcategory = subcategory::where('id', $getproducts->subcategory)->first();
        $condition =condition::where('id', $getproducts->condition_id)->first();
        $source = source::where('id', $getproducts->source_id)->first();
        $productmodel = productmodel::where('id', $getproducts->model_id)->first();
        $productmanufacturer = productmanufacturer::where('id', $getproducts->manufacturer_id)->first();
        $amt = '';

        $similarprod = vendorproduct::where('subcategory', $getproducts->subcategory)->take(4)->get();
        $wishlist = false;

        //this code gets the days interval for payment
        if (Auth::check()) {
            $getwishlist = wishlist::where('user_id', Auth::user()->id)->where('product_id', $id)->first();
            if ($getwishlist) {
               $wishlist = true;
            }

            if ($getproducts->pricewithin15days > 0 || $getproducts->pricewithin30days > 0) {
                //to get verification access
                $getcustomersvendoreaccess = customersverification::where('user_id', Auth::user()->id)->where('verification', 'yes')->first();
                //dd($getcustomersvendoreaccess);

                if ($getcustomersvendoreaccess) {

                    //to get if the vendor is the customer's vendor
                    $customersvendor = customersvendor::where('customer_id', Auth::user()->id)->where('vendor_id',$getproducts->user_id)->where('status', 'yes')->first();

                    if ($customersvendor) {
                        
                        //to get if the user has an outstanding payment
                        $outstandingpayment = outstandingpayment::where('user_id', Auth::user()->id)->where('payment', 'pending')->where('duedate','<',Carbon::today()->toDateString())->sum('totalprice');
                        $limit = DB::table('outstandingpayment')->where('user_id', Auth::user()->id)->where('payment', 'pending')->where('duedate','>',Carbon::today()->toDateString())->sum('totalprice');
                        

                        if ($outstandingpayment>0 || $limit>=$customersvendor->limitted) {
                            
                            if ($getproducts->pricewithin15days > 0) {
                                if(Session::has('currency')){
                                    $getPrice=currency::find(1);
                                    if(Session::get('currency')=='Dollar'){
                                    $price="$ ".$getproducts->pricewithin15days*$getPrice->Dollar;
                                    }
                                    else if(Session::get('currency')=='Yen'){
                                    $price="¥ ".$getproducts->pricewithin15days*$getPrice->Yen;
                                }
                                else if(Session::get('currency')=='Euro'){
                                $price="€ ".$getproducts->pricewithin15days*$getPrice->Euro;
                            }
                            else{
                            $price="₦ ".$getproducts->pricewithin15days;
                        }
                                    }
                                    else{
                                     $price="₦ ".$getproducts->pricewithin15days;
                                }
                               // $days15 = number_format($price);
                                $amt .= "<h5><s><input type='radio' name='payment' class='payment' value='2' disabled> ".$price." -Pay in 15 days</s></h5>";
                            }

                            if ($getproducts->pricewithin30days > 0) {
                                if(Session::has('currency')){
                                    $getPrice=currency::find(1);
                                    if(Session::get('currency')=='Dollar'){
                                    $price="$ ".$getproducts->pricewithin30days*$getPrice->Dollar;
                                    }
                                    else if(Session::get('currency')=='Yen'){
                                    $price="¥ ".$getproducts->pricewithin30days*$getPrice->Yen;
                                }
                                else if(Session::get('currency')=='Euro'){
                                $price="€ ".$getproducts->pricewithin30days*$getPrice->Euro;
                            }
                            else{
                            $price="₦ ".$getproducts->pricewithin30days;
                        }
                                    }
                                    else{
                                     $price="₦ ".$getproducts->pricewithin30days;
                                }
                               // $days30 = number_format($price);
                                $amt .= "<h5><s><input type='radio' name='payment' class='payment' value='3' disabled> ".$price." -Pay in 30 days</s></h5>";
                            } 

                        }else{

                            if ($getproducts->pricewithin15days > 0) {
                                if(Session::has('currency')){
                                    $getPrice=currency::find(1);
                                    if(Session::get('currency')=='Dollar'){
                                    $price="$ ".$getproducts->pricewithin15days*$getPrice->Dollar;
                                    }
                                    else if(Session::get('currency')=='Yen'){
                                    $price="¥ ".$getproducts->pricewithin15days*$getPrice->Yen;
                                }
                                else if(Session::get('currency')=='Euro'){
                                $price="€ ".$getproducts->pricewithin15days*$getPrice->Euro;
                            }
                            else{
                            $price="₦ ".$getproducts->pricewithin15days;
                        }
                                    }
                                    else{
                                     $price="₦ ".$getproducts->pricewithin15days;
                                }
                                //$days15 = number_format($price);
                                $amt .= "<h5><input type='radio' name='payment' class='payment' value='2'> ".$price." -Pay in 15 days</h5>";
                            }

                            if ($getproducts->pricewithin30days > 0) {
                                if(Session::has('currency')){
                                    $getPrice=currency::find(1);
                                    if(Session::get('currency')=='Dollar'){
                                    $price="$ ".$getproducts->pricewithin30days*$getPrice->Dollar;
                                    }
                                    else if(Session::get('currency')=='Yen'){
                                    $price="¥ ".$getproducts->pricewithin30days*$getPrice->Yen;
                                }
                                else if(Session::get('currency')=='Euro'){
                                $price="€ ".$getproducts->pricewithin30days*$getPrice->Euro;
                            }
                            else{
                            $price="₦ ".$getproducts->pricewithin30days;
                        }
                                    }
                                    else{
                                     $price="₦ ".$getproducts->pricewithin30days;
                                }
                               // $days30 = number_format($price);
                                $amt .= "<h5><input type='radio' name='payment' class='payment' value='3'> ".$price." -Pay in 30 days</h5>";
                            }

                        }

                    }else{
                        if ($getproducts->pricewithin15days > 0) {
                            if(Session::has('currency')){
                                    $getPrice=currency::find(1);
                                    if(Session::get('currency')=='Dollar'){
                                    $price="$ ".$getproducts->pricewithin15days*$getPrice->Dollar;
                                    }
                                    else if(Session::get('currency')=='Yen'){
                                    $price="¥ ".$getproducts->pricewithin15days*$getPrice->Yen;
                                }
                                else if(Session::get('currency')=='Euro'){
                                $price="€ ".$getproducts->pricewithin15days*$getPrice->Euro;
                            }
                            else{
                            $price="₦ ".$getproducts->pricewithin15days;
                        }
                                    }
                                    else{
                                     $price="₦ ".$getproducts->pricewithin15days;
                                }
                           // $days15 = number_format($price);
                            $amt .= "<h5><s><input type='radio' name='payment' class='payment' value='2' disabled> ".$price." -Pay in 15 days</s></h5>";
                        }

                        if ($getproducts->pricewithin30days > 0) {
                            if(Session::has('currency')){
                                    $getPrice=currency::find(1);
                                    if(Session::get('currency')=='Dollar'){
                                    $price="$ ".$getproducts->pricewithin30days*$getPrice->Dollar;
                                    }
                                    else if(Session::get('currency')=='Yen'){
                                    $price="¥ ".$getproducts->pricewithin30days*$getPrice->Yen;
                                }
                                else if(Session::get('currency')=='Euro'){
                                $price="€ ".$getproducts->pricewithin30days*$getPrice->Euro;
                            }
                            else{
                            $price="₦ ".$getproducts->pricewithin30days;
                        }
                                    }
                                    else{
                                     $price="₦ ".$getproducts->pricewithin30days;
                                }
                           // $days30 = number_format($price);
                            $amt .= "<h5><s><input type='radio' name='payment' class='payment' value='3' disabled> ".$price." -Pay in 30 days</s></h5>";
                        } 
                    }

                   
                    
                }else{
                   if ($getproducts->pricewithin15days > 0) {
                    if(Session::has('currency')){
                                    $getPrice=currency::find(1);
                                    if(Session::get('currency')=='Dollar'){
                                    $price="$ ".$getproducts->pricewithin15days*$getPrice->Dollar;
                                    }
                                    else if(Session::get('currency')=='Yen'){
                                    $price="¥ ".$getproducts->pricewithin15days*$getPrice->Yen;
                                }
                                else if(Session::get('currency')=='Euro'){
                                $price="€ ".$getproducts->pricewithin15days*$getPrice->Euro;
                            }
                            else{
                            $price="₦ ".$getproducts->pricewithin15days;
                        }
                                    }
                                    else{
                                     $price="₦ ".$getproducts->pricewithin15days;
                                }
                       // $days15 = number_format($price);
                        $amt .= "<h5><s><input type='radio' name='payment' class='payment' value='2' disabled> ".$price." -Pay in 15 days</s></h5>";
                    }

                    if ($getproducts->pricewithin30days > 0) {
                        if(Session::has('currency')){
                                    $getPrice=currency::find(1);
                                    if(Session::get('currency')=='Dollar'){
                                    $price="$ ".$getproducts->pricewithin30days*$getPrice->Dollar;
                                    }
                                    else if(Session::get('currency')=='Yen'){
                                    $price="¥ ".$getproducts->pricewithin30days*$getPrice->Yen;
                                }
                                else if(Session::get('currency')=='Euro'){
                                $price="€ ".$getproducts->pricewithin30days*$getPrice->Euro;
                            }
                            else{
                            $price="₦ ".$getproducts->pricewithin30days;
                        }
                                    }
                                    else{
                                     $price="₦ ".$getproducts->pricewithin30days;
                                }
                       // $days30 = number_format($price);
                        $amt .= "<h5><s><input type='radio' name='payment' class='payment' value='3' disabled> ".$price." -Pay in 30 days</s></h5>";
                    } 
                }


            }
            
        }

        $view = '';

        foreach($similarprod as $key){

            $product = products::where('id', $key->product_id)->first();
            $ratingss=$this->ratings($key->product_id);
        if(!empty($key->image)){
            $images = $key->image;
        }
        else{
            $images = $product->image;
        }
         if(Session::has('currency')){
                                    $getPrice=currency::find(1);
                                    if(Session::get('currency')=='Dollar'){
                                    $price="$ ".$key->price*$getPrice->Dollar;
                                    }
                                    else if(Session::get('currency')=='Yen'){
                                    $price="¥ ".$key->price*$getPrice->Yen;
                                }
                                else if(Session::get('currency')=='Euro'){
                                $price="€ ".$key->price*$getPrice->Euro;
                            }
                            else{
                            $price="₦ ".$key->price;
                        }
                                    }
                                    else{
                                     $price="₦ ".$key->price;
                                }
      //  $prices = number_format($key->price);

        $product_image = productimages::where('product_id', $id)->first();
        


        $view .= "<div class='col-md-3'>
                            <div class='product '>
                                <ul class='product-labels'></ul>
                                <div class='product-img-wrap'>
                                    <img class='product-img-primary' src=' $myurl/$images' alt='Image Alternative text' title='Image Title' />
                                    <img class='product-img-alt' src=' $myurl/$images' alt='Image Alternative text' title='Image Title' />
                                </div>
                                <a class='product-link' href='".$myurl."product/$key->slog'></a>
                                <div class='product-caption'>
                                    <ul class='product-caption-rating'>
                                        ";
                                     if($ratingss>0){
                                      if($ratingss==1){
                                      $view .=" <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li><i class='fa fa-star'></i>
                                        </li>";
                                    }
                                      elseif($ratingss==2){
                                       $view .="<li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li><i class='fa fa-star'></i>
                                        </li>";
                                    }
                                      elseif($ratingss==3){
                                      $view=" <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li><i class='fa fa-star'></i>
                                        </li>";
                                    }
                                      elseif($ratingss=4){
                                       $view .="<li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li><i class='fa fa-star'></i>
                                        </li>";
                                    }
                                      else{
                                       $view .="<li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>";
                                    }
                                      
                                       }
                                       else{
                                       $view .="<li class=''><i class='fa fa-star'></i>
                                        </li>
                                        <li class=''><i class='fa fa-star'></i>
                                        </li>
                                        <li class=''><i class='fa fa-star'></i>
                                        </li>
                                        <li class=''><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>";
                                    }
                                        
                                    $view.="
                                    </ul>
                                    <h5 class='product-caption-title'>$product->name</h5>
                                    <div class='product-caption-price'><span class='product-caption-price-new'>".HomeController::converter($key->price)."</span>
                                    </div>
                                    <ul class='product-caption-feature-list'>
                                        <li>Free Shipping</li>
                                    </ul>
                                </div>
                            </div>
                        </div>";
        }

        //to get customers review
        $review = review::where('product_id', $id)->first();
        $reviewcount = '';
        $showreview = '';
        $totalreview = '';
        $sumrating = '';

        if ($review) {
            # code...
            $reviewcount = review::where('product_id', $id)->count();
            $sumrating = review::where('product_id', $id)->sum('rating');
            $totalreview = $sumrating/$reviewcount;
            $getreview = review::where('product_id', $id)->get();
            

            foreach ($getreview as $key) {

                $name = User::where('id', $key->user_id)->first();

                $time = strtotime($key->created_at);
                $reviewdate = date('d/m/Y', $time);
                $showreview .= "<article class='product-review'>
                                    
                                    <div class='product-review-content'>
                                        <input class='input-3' name='input-3' value=$key->rating class='rating-loading' data-size='xs'>
                                        <p class='product-review-meta'>by  on $reviewdate</p>
                                        <p class='product-review-body'>$key->review</p>
                                        
                                    </div>
                                </article>";
            }
        }



        $price = $getproducts->price;
        $id = $getproducts->id;

        if(!empty($getproducts->image)){
            $image = $getproducts->image;
        }
        else{
            $image = $products->image;
        }
        $vendorname = User::where('id', $getproducts->user_id)->first();

        if (Auth::check()) {
            $nofification = new Notification;
            $nofification->user_id = $vendorname->id;
            $nofification->notification = Auth::User()->name ." visited your " .$getproducts->name." products";
            $nofification->save();
        }

        $accessories_array = $vendor_product->accessories;
        $accessories = explode(',',$accessories_array);
        //dd($accessories);

        $data_acceseries = array();
        foreach ($accessories as $k => $v) {
          
             $prduct = DB::table('vendorproduct')
                          ->select('vendorproduct.*','products.image')
                           ->leftjoin('products','products.id','=','vendorproduct.product_id')
                        ->where('vendorproduct.id',$v)
                        ->get(); 
            $data_acceseries[] =  $prduct;         
           
        }

    $q_a = DB::table('customer_q_a')
                            ->select('customer_q_a.*','vendorproduct.*','customer_q_a.id as id')
                           ->leftjoin('vendorproduct','vendorproduct.id','=','customer_q_a.product_id')
                            ->where('customer_q_a.product_id', $id)
                            ->orderBy('customer_q_a.created_at','DESC')
                            ->limit(1)
                            ->get();
    //dd($q_a);
 
   


     
        $cart = $this->cart();
        return view('home.products', compact('getproducts', 'products', 'category', 'subcategory', 'price', 'image', 'view', 'condition', 'source', 'productmodel', 'productmanufacturer', 'id', 'cart', 'amt', 'vendorname', 'wishlist','showreview', 'reviewcount', 'totalreview','vendor_product','product_image','data_acceseries','q_a','userid'));


    }

    public function loginuser()
        {
            $loginemail = $_GET['loginemail'];
            $loginpassword = $_GET['loginpassword'];

            if (Auth::attempt(['email' => $loginemail, 'password' => $loginpassword])) {
                $getcart = Cart::count();

            if ($getcart >= 1) {
                # code...

                foreach(Cart::content() as $row) {


        $getproducts = vendorproduct::where('id', $row->id)->first();
        $products = products::where('id', $getproducts->product_id)->first();
        $getcart = carts::where('product_id', $row->id)->where('user_id', Auth::user()->id)->where('payoptions', 1)->first();

        if ($getcart) {
            $getcartqty = $getcart->quantity;
            $newqty = $getcartqty + $row->qty;
            $totalprice = $newqty * $row->price;
            $updatecart = carts::where('product_id', $row->id)->where('user_id', Auth::user()->id)->where('payoptions', 1)->update(array('quantity' =>  $newqty, 'totalprice' => $totalprice));
        }else{
            $cart = new carts;
            $cart->user_id = Auth::user()->id;
            $cart->product_id = $row->id;
            $cart->price = $row->price;
            $cart->quantity = $row->qty;
            $cart->totalprice = $row->total;
            $cart->payoptions = 1;
            $cart->save();
        }

        
            
        }
        Cart::destroy();

            }
                return 'true';
            }else{
                return 'false';
            }
        }
//popup signup users
        public function signupuser()
        {
            $name = $_GET['name'];
            $email = $_GET['email'];
            $password = $_GET['password'];
            $repeatpassword = $_GET['repeatpassword'];
            $phonenumber = $_GET['phonenumber'];

            $role_customer = Role::where('name', 'Customer')->first();

        $user = new User;
        $user->name = $name;
        $user->email = $email;
        $user->phone = $phonenumber;
        $user->password = Hash::make($password);
        $user->user_type = 'Customer';
       if($user->save())
         {
            $customer = new Customer;
            $customer->company_name = request('company_name');
            $customer->name = $name;
            $customer->user_id = $user->id;
            $customer->user_type='Customer';
            $customer->about = request('about_company');
            $customer->website = request('website_url');
            $customer->cac = request('cac_number');
            $customer->businesstype = request('type_of_business');
            $customer->yearsofexitence = request('year_of_existence');
            $customer->mdtel = request('phone_of_MD_Chairman');
            $customer->mdemail = request('email_of_MD_Chairman');
            $customer->contactpersontel = request('phone_of_contact_person');
            $customer->contactpersonemail  = request('email_of_contact_person');
            $customer->company_rating  = request('company_rating');
            $customer->save();


         }

        $user->roles()->attach($role_customer);

        $welletuser = new walletusers;
        $welletuser->user_id = $user->id;
        $welletuser->password = request('password');
        $welletuser->save();

        if (Auth::attempt(['email' => $email, 'password' => $password])) {

            $getcart = Cart::count();

            if ($getcart >= 1) {
                # code...

                foreach(Cart::content() as $row) {


        $getproducts = vendorproduct::where('id', $row->id)->first();
        $products = products::where('id', $getproducts->product_id)->first();
        $getcart = carts::where('product_id', $row->id)->where('user_id', Auth::user()->id)->where('payoptions', 1)->first();

        if ($getcart) {
            $getcartqty = $getcart->quantity;
            $newqty = $getcartqty + $row->qty;
            $totalprice = $newqty * $row->price;
            $updatecart = carts::where('product_id', $row->id)->where('user_id', Auth::user()->id)->where('payoptions', 1)->update(array('quantity' =>  $newqty, 'totalprice' => $totalprice));
        }else{
            $cart = new carts;
            $cart->user_id = Auth::user()->id;
            $cart->product_id = $row->id;
            $cart->price = $row->price;
            $cart->quantity = $row->qty;
            $cart->totalprice = $row->total;
            $cart->payoptions = 1;
            $cart->save();
        }

        
            
        }
        Cart::destroy();
    }
            return 'true';
        }
        }

        public function getvendor($id)
        {
            if(!Session::has('catagory')){
                return redirect('/');
        }
            $id = $id;
            $getproduct = vendorproduct::where('user_id', $id)->groupBy('category')->get();
             if (Auth::check()) {
                $nofification = new Notification;
                foreach ($getproduct as  $value) {
                   $nofification->user_id = $value->user_id;
                }
                
                $nofification->notification =  Auth::User()->name." visited your profile";
                $nofification->save();
            }
            $view = '';
            $num = '';
            $val = '';
            $follow = '';
            $myurl = asset('/');

            if (Auth::check()) {
                $customersvendor = favoritevendor::where('customer_id', Auth::user()->id)->where('vendor_id', $id)->first();
                if ($customersvendor) {
                    if($customersvendor->favorite==1)
                    {$follow = "<button class='btn btn-default pull-right follow' id='unfavorite'>unfavorite</button>";}
                else{
                    $follow = "<button class='btn btn-default pull-right follow' id='favorite'>favorite</button>";
                }
                }else{
                    $follow = "<button class='btn btn-default pull-right follow' id='favorite'>favorite</button>";
                }
                
            }

            $category = "<ul style='list-style-type: none'>";

            foreach ($getproduct as $key) {
                $categories = category::where('id', $key->category)->first();
                $countcat = vendorproduct::where('user_id', $id)->where('category', $key->category)->count();
                $category .= "<li><a href='".$myurl."vendors/$id/$key->category'>$categories->name ($countcat) <b style='font-weight: bolder'><i class='fa fa-angle-right pull-right caret-icon' name='filter-category-buckets' data-category-id='4'></i></b></a></li><br>";
            }
            $category .="</ul>";


        $cart = $this->cart();

        $vendorname = User::where('id', $id)->first();


            $sql = vendorproduct::where('user_id', $id)->where('delete_product','=',0)->where('product_status','=',1)->where('availability','=','yes')->get();

            $view .= "<ul class='paginate' style='list-style-type:none'>";
            foreach ($sql as $key) {
                
            $products = products::where('id', $key->product_id)->first();
               if(!empty($key->image)){
                $image = $key->image;
                }
                else{
                    $image = $products->image;
                }
                $price = number_format($key->price);
                $ratingss=$this->ratings($key->product_id);
            $view .= "<li><div class='col-md-4' style='margin-bottom: 10px'>
                        <div class='product '>
                            
                            <div class='product-img-wrap'>
                                <img class='product-img-primary' src='".$myurl."$image' style='height: 250px' alt='Image Alternative text' title='Image Title'>
                                <img class='product-img-alt' src='".$myurl."$image' alt='Image Alternative text' style='height:250px' title='Image Title'>
                            </div>
                            <div class='product-caption'>
                                <ul class='product-caption-rating'>
                                     ";
                                     if($ratingss>0){
                                      if($ratingss==1){
                                      $view .=" <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li><i class='fa fa-star'></i>
                                        </li>";
                                    }
                                      elseif($ratingss==2){
                                       $view .="<li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li><i class='fa fa-star'></i>
                                        </li>";
                                    }
                                      elseif($ratingss==3){
                                      $view=" <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li><i class='fa fa-star'></i>
                                        </li>";
                                    }
                                      elseif($ratingss=4){
                                       $view .="<li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li><i class='fa fa-star'></i>
                                        </li>";
                                    }
                                      else{
                                       $view .="<li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>";
                                    }
                                      
                                       }
                                       else{
                                       $view .="<li class=''><i class='fa fa-star'></i>
                                        </li>
                                        <li class=''><i class='fa fa-star'></i>
                                        </li>
                                        <li class=''><i class='fa fa-star'></i>
                                        </li>
                                        <li class=''><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>";
                                    }
                                        
                                    $view.="
                                   
                                </ul>
                                <h5 class='product-caption-title'><a href='".$myurl."/product/$key->slog'>$products->name</a></h5>
                                <div class='product-caption-price'><span class='product-caption-price-new'><span style='font-size: 18px'> ".HomeController::converter($key->price)." </span><br> <span class='add$key->id'><button class='btn btn-sm btn-primary addproducttocart1' id=$key->id>add to cart</button></span></span>
                                </div>
                            </div>
                        </div>
                    </div></li>";

            }
            $view .= "</ul>
                        <script type='text/javascript'>
                    $('.paginate').paginathing({
                    perPage: 12,
                    limitPagination: $val
                    })
                    </script>";

             $vendorproduct = Vendorproduct::where('user_id',$id)->first();
             $orders=orders::where('vendor_id',$id)->where('payment','=','yes')->get();
             $totalcustomer=orders::where('vendor_id',$id)->where('payment','=','yes')->groupBy('user_id')->get();
             $totalprice=0;
             foreach ($orders as $key => $order) {
                $ordersamount=ordersdetail::where('order_id','=',$order->id)->sum('totalprice');
                $totalprice=$totalprice+$ordersamount;
             }
           // $totalprice = $vendorproduct::sum('price');

            //$totalcustomer = customersvendor::where('vendor_id',$id)->get();


            return view('home.vendorpage', compact('category', 'cart', 'vendorname', 'view', 'id', 'follow','vendorproduct','totalprice','totalcustomer'));
        }

        public function getvendorcategory($id, $cat)
        {
            $id = $id;
            $getproduct = vendorproduct::where('user_id', $id)->where('availability','=','yes')->groupBy('category')->get();
            $view = '';
            $num = '';
            $val = '';
            $myurl = asset('/');
            $category = "<ul>";

            foreach ($getproduct as $key) {
                $categories = category::where('id', $key->category)->first();
                $countcat = vendorproduct::where('user_id', $id)->where('category', $key->category)->count();
                $category .= "<li><a href='".$myurl."vendors/$id/$key->category'>$categories->name ($countcat)</a></li>";
            }
            $category .="</ul>";


        $cart = $this->cart();

        $vendorname = User::where('id', $id)->first();


            $sql = vendorproduct::where('user_id', $id)->where('availability','=','yes')->where('category', $cat)->get();

            $view .= "<ul class='paginate' style='list-style-type:none'>";
            foreach ($sql as $key) {
                
            $products = products::where('id', $key->product_id)->first();
               if(!empty($key->image)){
                $image = $key->image;
                }
                else{
                    $image = $products->image;
                }
                $price = number_format($key->price);

            $view .= "<li><div class='col-md-4' style='margin-bottom: 10px'>
                        <div class='product '>
                           
                            <div class='product-img-wrap'>
                                <img class='product-img-primary' src='".$myurl."$image' style='height: 250px' alt='Image Alternative text' title='Image Title'>
                                <img class='product-img-alt' src='".$myurl."$image' alt='Image Alternative text' style='height:250px' title='Image Title'>
                            </div>
                            <div class='product-caption'>
                                <ul class='product-caption-rating'>
                                    <li class='rated'><i class='fa fa-star'></i>
                                    </li>
                                    <li class='rated'><i class='fa fa-star'></i>
                                    </li>
                                    <li class='rated'><i class='fa fa-star'></i>
                                    </li>
                                    <li><i class='fa fa-star'></i>
                                    </li>
                                    <li><i class='fa fa-star'></i>
                                    </li>
                                </ul>
                                <h5 class='product-caption-title'><a href='".$myurl."/product/$key->slog'>$products->name</a></h5>
                                <div class='product-caption-price'><span class='product-caption-price-new'><span style='font-size: 18px'> ".HomeController::converter($key->price)." </span><br> <span class='add$key->id'><button class='btn btn-sm addproducttocart1' id=$key->id>add to cart</button></span></span>
                                </div>
                            </div>
                        </div>
                    </div></li>";

            }
            $view .= "</ul>
                        <script type='text/javascript'>
                    $('.paginate').paginathing({
                    perPage: 12,
                    limitPagination: $val
                    })
                     </script>";
                      $vendorproduct = Vendorproduct::where('user_id',$id)->first();

             $orders=orders::where('vendor_id',$id)->where('payment','=','yes')->get();
             $totalcustomer=orders::where('vendor_id',$id)->where('payment','=','yes')->groupBy('user_id')->get();
             $totalprice=0;
             foreach ($orders as $key => $order) {
                $ordersamount=ordersdetail::where('order_id','=',$order->id)->sum('totalprice');
                $totalprice=$totalprice+$ordersamount;
             }
              if (Auth::check()) {
                $customersvendor = favoritevendor::where('customer_id', Auth::user()->id)->where('vendor_id', $id)->first();
                if ($customersvendor) {
                    if($customersvendor->favorite==1)
                    {$follow = "<button class='btn btn-default pull-right follow' id='unfavorite'>unfavorite</button>";}
                else{
                    $follow = "<button class='btn btn-default pull-right follow' id='favorite'>favorite</button>";
                }
                }else{
                    $follow = "<button class='btn btn-default pull-right follow' id='favorite'>favorite</button>";
                }
                
            }
            return view('home.vendorcatpage', compact('category', 'cart', 'vendorname', 'view','id','vendorproduct','orders','totalcustomer','totalprice','follow'));   
        }

        public function searchsiterequest()
        {
            $val = $_GET['val'];
            $view = "<div class='row tt-dropdown-menu' style='display: block; list-style-type: none'>";

            $getcategory = category::where('name', 'like', '%'.$val.'%')->first();

            if ($getcategory) {
                $getcat = category::where('name', 'like', '%'.$val.'%')->limit(4)->get();

                $view .= "<div class='col-md-12'><b>Categories</b></div>";
                foreach ($getcat as $key) {
                    $getproduct = category::where('id', $key->id)->get();
                    $view .= "<a href='' class='hovereffect' style='width: 100%'>
                    <div class='col-md-12'>
                    $key->name
                    </div>
                    </a>";
                }
            }

            $getproduct = products::where('name', 'like', '%'.$val.'%')->first();

            if ($getproduct) {
                $getprod = products::where('name', 'like', '%'.$val.'%')->limit(4)->get();

                $view .= "<div class='col-md-12'><b>Products</b></div>";
                foreach ($getprod as $key) {
                    $getprods = vendorproduct::where('product_id', $key->id)->limit(4)->get();
                    foreach ($getprods as $keys) {

                        $getproducts = vendorproduct::where('id', $keys->id)->first();
        $products = products::where('id', $getproducts->product_id)->first();

                         if(!empty($getproducts->image)){
                            $image = $getproducts->image;
                        }
                        else{
                            $image = $products->image;
                        }

                        $view .= "<a href style='width: 100%' class='hovereffect'><div class='col-md-12'>
                                    <img src=/$image alt='Image Alternative text' title='Image Title' style='float: left; width: 50px; height: 30px; margin-right: 8px' />
                                    $key->name
                                    </div></a>";
                    }
                }
            }

            $view .= "</div>";
            return $view;

        }

        public function appendValue($data, $type, $element)
        {
            // operate on the item passed by reference, adding the element and type
            foreach ($data as $key => & $item) {
                $item[$element] = $type;
            }
            return $data;       
        }

    public function appendURL($data, $prefix)
    {
        // operate on the item passed by reference, adding the url based on slug
        foreach ($data as $key => & $item) {
         //   $item['url'] = url('/searchitems/'.$item['name']);
            $item['url'] = url('/searchitems/'.Session::get('query'));
        }
        return $data;       
    }
    public function appendURLvendor($data, $prefix)
    {
        // operate on the item passed by reference, adding the url based on slug
        foreach ($data as $key => & $item) {
            $item['url'] = url($prefix.'/'.$item['user_id']);
        }
        return $data;       
    }


    public function searchautocomplete(Request $request)
    {

        $vendor_id = $request->depart;
        $request->session()->put('query', $request->q);
        if($vendor_id){
            $vendorid= $request->session()->put('vender_id', $vendor_id);
             
        }else{

            $vendorid = Session::get('vender_id'); 
        }
        $vendorid = Session::get('vender_id');

    if($vendorid=='AllDepartmens')
      {

        $query =$request->q;

        /*if(!$query && $query == '') return Response::json(array(), 400);*/

        $products = vendorproduct::where('name','like','%'.$query.'%')->orwhere('product_generic_name','like','%'.$query.'%')->orwhere('description','like','%'.$query.'%')->orWhere('part_number','like','%'.$query.'%')->orWhere('key_specification','like','%'.$query.'%')->orWhere('other_information','like','%'.$query.'%')->orWhere('model_number','like','%'.$query.'%')->orWhere('serial_number','like','%'.$query.'%')
            ->orderBy('name','asc')
            ->take(5)
            ->get(array('slog','name','image','product_generic_name','part_number','key_specification','other_information','model_number','serial_number'))->toArray();
       

        $categories = category::where('name','like','%'.$query.'%')
            ->take(5)
            ->get(array('slog', 'name'))
            ->toArray();

        $sub_categories = subcategory::where('name','like','%'.$query.'%')
            ->take(5)
            ->get(array('slog', 'name'))
            ->toArray();
        $part_numbers = vendorproduct::where('part_number','like','%'.$query.'%')
            ->orderBy('name','asc')
            ->take(5)
            ->get(array('slog','name','image','product_generic_name','part_number','key_specification','other_information'))->toArray();

        $vendors = vendors::where('vendorname','like','%'.$query.'%')->where('delete_colunm','=',0)->orderBy('vendorname','asc')
            ->select('vendorname as name','user_id')
            ->take(5)
            ->get()->toArray();

        // Data normalization
        $products = $this->appendValue($products, 'img/category_icon.png','image');
        $categories = $this->appendValue($categories, 'img/category_icon.png','image');
        $sub_categories = $this->appendValue($sub_categories, 'img/category_icon.png','image');
        $part_numbers = $this->appendValue($part_numbers, 'img/category_icon.png','image');

        $products   = $this->appendURL($products, 'product');
        $categories  = $this->appendURL($categories, 'category');
        $sub_categories  = $this->appendURL($sub_categories, 'subcategory');
        $part_numbers   = $this->appendURL($part_numbers, 'product');

        // Add type of data to each item of each set of results
        $products = $this->appendValue($products, 'product', 'class');
        $categories = $this->appendValue($categories, 'category', 'class');
        $sub_categories = $this->appendValue($sub_categories, 'subcategory', 'class');
       
        $vendors = $this->appendValue($vendors, 'img/category_icon.png','image');
        $vendors   = $this->appendURLvendor($vendors, 'vendors');
        $vendors = $this->appendValue($vendors, 'vendors', 'class');
        // Merge all data into one array
        $data = array_merge($products, $categories,$sub_categories,$vendors,$part_numbers);
   # code...
            
        return Response::json(array(
            'data'=>$data
        ));
    }elseif($vendorid=='allproudts'){
        $query =$request->q;
        $products = vendorproduct::where('name','like','%'.$query.'%')->orwhere('product_generic_name','like','%'.$query.'%')->orwhere('description','like','%'.$query.'%')->orWhere('part_number','like','%'.$query.'%')->orWhere('key_specification','like','%'.$query.'%')->orWhere('other_information','like','%'.$query.'%')->orWhere('model_number','like','%'.$query.'%')->orWhere('serial_number','like','%'.$query.'%')
            ->orderBy('name','asc')
            ->take(10)
            ->get(array('slog','name','image','product_generic_name','part_number','key_specification','other_information','model_number','serial_number'))->toArray();
        $products = $this->appendValue($products, 'img/category_icon.png','image');
        $products   = $this->appendURL($products, 'product');
        $products = $this->appendValue($products, 'product', 'class');

        $data1 = array_merge($products);
   # code...
            
        return Response::json(array(
            'data'=>$data1
        ));

    }else{

            $query =$request->q;

            $vendorid = Session::get('vender_id');

             
            $vendors = vendors::where('vendor_type',$vendorid)->where('vendorname','like','%'.$query.'%')->where('delete_colunm','=',0)->orderBy('vendorname','asc')
                    ->select('vendorname as name','user_id','vendor_type')
                    ->take(5)
                    ->get()->toArray();

            $products = vendorproduct::where('name','like','%'.$query.'%')->orwhere('product_generic_name','like','%'.$query.'%')->orwhere('description','like','%'.$query.'%')->orWhere('part_number','like','%'.$query.'%')->orWhere('key_specification','like','%'.$query.'%')->orWhere('other_information','like','%'.$query.'%')->orWhere('model_number','like','%'.$query.'%')->orWhere('serial_number','like','%'.$query.'%')
                    ->orderBy('name','asc')
                    ->take(5)
                    ->get(array('slog','name','image','product_generic_name','part_number','key_specification','other_information','model_number','serial_number'))->toArray();
            

            $products = $this->appendValue($products, 'img/category_icon.png','image');
            $products   = $this->appendURL($products, 'product');
            $products = $this->appendValue($products, 'product', 'class');

            $vendors = $this->appendValue($vendors, 'img/category_icon.png','image');
            $vendors   = $this->appendURLvendor($vendors, 'vendors');
            $vendors = $this->appendValue($vendors, 'vendors', 'class');
           if(count($vendors)>0){
             $data2 = array_merge($vendors);
           }else{
            $data2 = array_merge($products);
           }
            
            return Response::json(array(
                    'data'=>$data2
                ));


    }
      
       

    }

    public function searchcategory()
    {
        parse_str($_GET['val'], $formdata);
        $price = $_GET['price'];

        $price = explode(";", $price);
        $min =$price[0];
        $max =$price[1]; 
        $location=[];
        $category = $_GET['category'];
        $product = DB::table('vendorproduct');
        $query = $product->where('category',$category)->whereBetween('price',[$min,$max]);
        $value = '';
        $view = '';
        if (!empty($formdata)) {
            $data = array();
            if (!empty($formdata['manufacturer'])) {
                # code...
                $data[] = $formdata['manufacturer'];

                foreach ($data as $key) {
                    foreach ($key as $value) {
                      /*  $query = $product->orWhere(function($query) use ($value, $category, $max, $min)
                                    {
                                        $query->where('category', $category)
                                        ->whereBetween('price', [$min, $max])
                                        ->where('manufacturer_id', $value);
                                    });
                        */
                                    $man[]=$value;
                    }
                    
                }
                $query->whereIn('manufacturer_id',$man);
            }

            if (!empty($formdata['model'])) {
                # code...
                unset($data);
                $data[] = $formdata['model'];

                foreach ($data as $key) {
                    foreach ($key as $value) {
                    /*    $query = $product->Where(function($query) use ($value, $category, $max, $min)
                                    {
                                        $query->where('category', $category)
                                        ->whereBetween('price', [$min, $max])
                                        ->where('model_id', $value);
                                    }); */
                                    $modal[]=$value;
                    }
                    
                }
                    $query->whereIn('model_id',$modal);
            }

            if (!empty($formdata['condition'])) {
                # code...
                unset($data);
                $data[] = $formdata['condition'];

                foreach ($data as $key) {
                    foreach ($key as $value) {

                      /*  $query = $product->Where(function($query) use ($value, $category, $max, $min)
                                    {
                                        $query->where('category', $category)
                                        ->whereBetween('price', [$min, $max])
                                        ->where('condition_id', $value);
                                    });
                                    */
                                    $cond[]=$value;
                    }
                    
                }
                $query->whereIn('condition_id',$cond);

            }

            if (!empty($formdata['source'])) {
                # code...
                unset($data);
                $data[] = $formdata['source'];

                    foreach ($data as $key) {
                    foreach ($key as $value) {
                        /*$query = $product->Where(function($query) use ($value, $category, $max, $min)
                                    {
                                        $query->where('category', $category)
                                        ->whereBetween('price', [$min, $max])
                                        ->where('source_id', $value);
                                    });*/
                        $source[]=$value;
                    }
                    
                }
                $query=$product->whereIn('source_id',$source);

            }

            if (!empty($formdata['units'])) {
                # code...
                unset($data);
                $data[] = $formdata['units'];

                foreach ($data as $key) {
                    foreach ($key as $value) {
                       /* $query = $product->Where(function($query) use ($value, $category, $max, $min)
                                    {
                                        $query->where('category', $category)
                                        ->whereBetween('price', [$min, $max])
                                        ->where('addon_id', $value);
                                    }); */
                                    $unitss[]=$value;
                    }
                    
                }
                $query=$product->whereIn('unit',$unitss);
            }
             if (!empty($formdata['color'])) {
                # code...
                unset($data);
                $data[] = $formdata['color'];
                foreach ($data as $key) {
                    foreach ($key as $value) {
                        $result[]=$value;
                    /*    $query = $product->Where(function($query) use ($value, $category, $max, $min)
                                    {
                                       
                                        $query->orwhere('color', $value);
                                    }); */
                    }
                    
                }

                $query=$product->whereIn('color',$result);
            }
            if (!empty($formdata['supply'])) {
                # code...
                unset($data);
                $data[] = $formdata['supply'];
                foreach ($data as $key) {
                    foreach ($key as $value) {
                        $result[]=$value;
                    /*    $query = $product->Where(function($query) use ($value, $category, $max, $min)
                                    {
                                       
                                        $query->orwhere('color', $value);
                                    }); */
                    }
                    
                }

                $query=$product->whereIn('supplyType',$result);
            }
            if (!empty($formdata['location'])) {
                # code...
                unset($data);
                $data[] = $formdata['location'];
                foreach ($data as $key) {
                    foreach ($key as $value) {
                        $location[]=$value;
                    /*    $query = $product->Where(function($query) use ($value, $category, $max, $min)
                                    {
                                       
                                        $query->orwhere('color', $value);
                                    }); */
                    }
                    
                }

                
            }
             if (!empty($formdata['pricing'])) {
                # code...
                unset($data);
                $data[] = $formdata['pricing'];
                foreach ($data as $key) {
                    foreach ($key as $value) {
                        if($value=='instant_price'){
                            $query==$product->where('instant_price','!=',NULL);
                        }
                        else if($value=='pricewithin15days'){
                            $query=$product->where('pricewithin15days','!=',NULL);
                        }
                        else if($value=='within30days'){
                            $query=$product->where('pricewithin30days','!=',NULL);
                        }
                    /*    $query = $product->Where(function($query) use ($value, $category, $max, $min)
                                    {
                                       
                                        $query->orwhere('color', $value);
                                    }); */
                    }
                    
                }

               
            }
             if (!empty($formdata['payment'])) {
                # code...
                unset($data);
                $data[] = $formdata['payment'];
                $products=[];
                foreach ($data as $key) {
                    foreach ($key as $value) {
                        $payment_delivery_information=PaymentDeliveryInformation::where('payment_mehod','=',$value)->get();
                        if(count($payment_delivery_information)>0){
                            foreach ($payment_delivery_information as $pay) {
                           $products[]=$pay->product_id;
                            }
                        }
                       
                    /*    $query = $product->Where(function($query) use ($value, $category, $max, $min)
                                    {
                                       
                                        $query->orwhere('color', $value);
                                    }); */
                    }
                    
                }
                if(count($products)>0){
               $query=$product->whereIn('product_id',$products);
           }
            }

            
        }else{

            $query = $query; /*$product->whereBetween('price', [$min, $max])->where('category', $category); */
        }
$myurl =  asset('/');
        $querys = $query->get(); 
       
            foreach ($querys as $key) {
                $product=products::find($key->product_id);

                $price = number_format($key->price);
                    $instance='Not Listed';
                            $within15days='Not Listed';
                            $within30days='Not Listed';
                                    if(Session::has('currency')){
                                    $getPrice=currency::find(1);
                                    if(Session::get('currency')=='Dollar'){
                                    $price="$ ".$key->price*$getPrice->Dollar;
                                    if($key->instant_price){
                                    $instance="$ ".$key->instant_price*$getPrice->Dollar;
                                    }
                                    if($key->pricewithin15days){
                                    $within15days="$ ".$key->pricewithin15days*$getPrice->Dollar;
                                    }
                                    if($key->pricewithin30days){
                                    $within30days="$ ".$key->pricewithin30days*$getPrice->Dollar;
                                    }
                                    }
                                    else if(Session::get('currency')=='Yen'){
                                    $price="¥ ".$key->price*$getPrice->Yen;
                                     if($key->instant_price){
                                    $instance="¥ ".$key->instant_price*$getPrice->Yen;
                                    }
                                    if($key->pricewithin15days){
                                    $within15days="¥ ".$key->pricewithin15days*$getPrice->Yen;
                                    }
                                    if($key->pricewithin30days){
                                    $within30days="¥ ".$key->pricewithin30days*$getPrice->Yen;
                                    }
                                }
                                else if(Session::get('currency')=='Euro'){
                                $price="€ ".$key->price*$getPrice->Euro;
                                 if($key->instant_price){
                                    $instance="€ ".$key->instant_price*$getPrice->Euro;
                                    }
                                    if($key->pricewithin15days){
                                    $within15days="€ ".$key->pricewithin15days*$getPrice->Euro;
                                    }
                                    if($key->pricewithin30days){
                                    $within30days="€ ".$key->pricewithin30days*$getPrice->Euro;
                                    }
                            }
                            else{
                            $price="₦ ".$key->price;
                             if($key->instant_price){
                                    $instance="₦ ".$key->instant_price;
                                    }
                                    if($key->pricewithin15days){
                                    $within15days="₦ ".$key->pricewithin15days;
                                    }
                                    if($key->pricewithin30days){
                                    $within30days="₦ ".$key->pricewithin30days;
                                    }
                        }
                                    }
                                    else{
                                     $price="₦ ".$key->price;
                                      if($key->instant_price){
                                    $instance="₦ ".$key->instant_price;
                                    }
                                    if($key->pricewithin15days){
                                    $within15days="₦ ".$key->pricewithin15days;
                                    }
                                    if($key->pricewithin30days){
                                    $within30days="₦ ".$key->pricewithin30days;
                                    }
                                }
                                $category=category::find($key->category);
                               $modal=productmodel::find($key->model_id);
                               $manufactoror=productmanufacturer::find($key->manufacturer_id);
                               
                              
                           $source='Not Listed';
                           if($key->source_id){
                           $sources=source::find($key->source_id);
                           $source=$sources->name;
                       }
                       $condition='Not Listed';
                       if($key->condition_id){
                       $con=condition::find($key->condition_id);
                       $condition=$con->name;
                   }
                   
                   $vendor=vendors::where('user_id','=',$key->user_id)->first();
               $reviewCount=DB::table('review')->where('product_id','=',$key->product_id)->count();
                      $reviews=DB::table('review')->where('product_id','=',$key->product_id)->sum('rating');
                      if($reviewCount>0){
                      $ratingss=(int)($reviews/$reviewCount);
                    }
                    else{
                      $ratingss=0;
                    }
                    if(count($location)>0){
                       
                        $locationget=vendors::where('user_id','=',$key->user_id)->whereIn('location',$location)->get();
                        if(count($locationget)>0){
                            $isCountinue=true;
                        }
                        else{
                            $isCountinue=false;
                        }
                    }
                    else{
                        $isCountinue=true;
                    }
                    if($isCountinue){
                        $modalName = $modal ? $modal->name : '';
                        $manufactororName = $manufactoror ? $manufactoror->name : '';
            $view .= "<div class='col-md-4'>
                            <div class='product 'data-title='$key->id' data-id='$key->name' data-category='$category->name' data-model='$modalName' data-manufactoror='$manufactororName' data-instance='$instance' data-within15='$within15days' data-within30='$within30days'
                            data-source='$source' data-price='$price' data-condition='$condition' data-vendor='$vendor->vendorname' data-location='$vendor->country'>
                                <ul class='product-labels'></ul>
                                <div class='product-img-wrap'>

                                    <img class='product-img-primary' src='".$myurl."/$product->image' alt='Image Alternative text' title='Image Title' style='height: 250px' />
                                    <img class='product-img-alt' src='".$myurl."/$product->image' alt='Image Alternative text' title='Image Title' style='height: 250px' />
                                </div>
                                <a class='product-link' href='".$myurl."/product/$key->slog'></a>
                                <div class='product-caption'>
                                    <ul class='product-caption-rating'>
                                        ";
                                     if($ratingss>0){
                                      if($ratingss==1){
                                      $view .=" <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li><i class='fa fa-star'></i>
                                        </li>";
                                    }
                                      elseif($ratingss==2){
                                       $view .="<li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li><i class='fa fa-star'></i>
                                        </li>";
                                    }
                                      elseif($ratingss==3){
                                      $view=" <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li><i class='fa fa-star'></i>
                                        </li>";
                                    }
                                      elseif($ratingss=4){
                                       $view .="<li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li><i class='fa fa-star'></i>
                                        </li>";
                                    }
                                      else{
                                       $view .="<li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>";
                                    }
                                      
                                       }
                                       else{
                                       $view .="<li class=''><i class='fa fa-star'></i>
                                        </li>
                                        <li class=''><i class='fa fa-star'></i>
                                        </li>
                                        <li class=''><i class='fa fa-star'></i>
                                        </li>
                                        <li class=''><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>";
                                    }
                                        
                                    $view.="
                                    </ul>
                                    <h5 class='product-caption-title'>$key->name</h5>
                                    <div class='product-caption-price'><span class='product-caption-price-new'>$price</span>
                                    </div>
                                   
                                    <a class='btn btn-info addToCompare' style='position: absolute; right: 0;top: 70%;'>Compare</a>
                                </div>
                            </div>
                        </div>";
                    }
                }

return $view;
    }

    public function searchsubcategory()
    {
        parse_str($_GET['val'], $formdata);
        $price = $_GET['price'];
        $location=[];
        $price = explode(";", $price);
        $min =$price[0];
        $max =$price[1]; 

        $category = $_GET['category'];
        $product = DB::table('vendorproduct');
        $query = $product->where('subcategory',$category)->whereBetween('price',[$min,$max]);
        $value = '';
        $view = '';
        if (!empty($formdata)) {
            $data = array();
            if (!empty($formdata['manufacturer'])) {
                # code...
                $data[] = $formdata['manufacturer'];

                foreach ($data as $key) {
                    foreach ($key as $value) {
                      /*  $query = $product->orWhere(function($query) use ($value, $category, $max, $min)
                                    {
                                        $query->where('category', $category)
                                        ->whereBetween('price', [$min, $max])
                                        ->where('manufacturer_id', $value);
                                    });
                        */
                                    $man[]=$value;
                    }
                    
                }
                $query->whereIn('manufacturer_id',$man);
            }

            if (!empty($formdata['model'])) {
                # code...
                unset($data);
                $data[] = $formdata['model'];

                foreach ($data as $key) {
                    foreach ($key as $value) {
                    /*    $query = $product->Where(function($query) use ($value, $category, $max, $min)
                                    {
                                        $query->where('category', $category)
                                        ->whereBetween('price', [$min, $max])
                                        ->where('model_id', $value);
                                    }); */
                                    $modal[]=$value;
                    }
                    
                }
                    $query->whereIn('model_id',$modal);
            }

            if (!empty($formdata['condition'])) {
                # code...
                unset($data);
                $data[] = $formdata['condition'];

                foreach ($data as $key) {
                    foreach ($key as $value) {

                      /*  $query = $product->Where(function($query) use ($value, $category, $max, $min)
                                    {
                                        $query->where('category', $category)
                                        ->whereBetween('price', [$min, $max])
                                        ->where('condition_id', $value);
                                    });
                                    */
                                    $cond[]=$value;
                    }
                    
                }
                $query->whereIn('condition_id',$cond);

            }

            if (!empty($formdata['source'])) {
                # code...
                unset($data);
                $data[] = $formdata['source'];

                    foreach ($data as $key) {
                    foreach ($key as $value) {
                        /*$query = $product->Where(function($query) use ($value, $category, $max, $min)
                                    {
                                        $query->where('category', $category)
                                        ->whereBetween('price', [$min, $max])
                                        ->where('source_id', $value);
                                    });*/
                        $source[]=$value;
                    }
                    
                }
                $query=$product->whereIn('source_id',$source);

            }

            if (!empty($formdata['units'])) {
                # code...
                unset($data);
                $data[] = $formdata['units'];

                foreach ($data as $key) {
                    foreach ($key as $value) {
                       /* $query = $product->Where(function($query) use ($value, $category, $max, $min)
                                    {
                                        $query->where('category', $category)
                                        ->whereBetween('price', [$min, $max])
                                        ->where('addon_id', $value);
                                    }); */
                                    $unitss[]=$value;
                    }
                    
                }
                $query=$product->whereIn('unit',$unitss);
            }
             if (!empty($formdata['color'])) {
                # code...
                unset($data);
                $data[] = $formdata['color'];
                foreach ($data as $key) {
                    foreach ($key as $value) {
                        $result[]=$value;
                    /*    $query = $product->Where(function($query) use ($value, $category, $max, $min)
                                    {
                                       
                                        $query->orwhere('color', $value);
                                    }); */
                    }
                    
                }

                $query=$product->whereIn('color',$result);
            }
            if (!empty($formdata['supply'])) {
                # code...
                unset($data);
                $data[] = $formdata['supply'];
                foreach ($data as $key) {
                    foreach ($key as $value) {
                        $result[]=$value;
                    /*    $query = $product->Where(function($query) use ($value, $category, $max, $min)
                                    {
                                       
                                        $query->orwhere('color', $value);
                                    }); */
                    }
                    
                }

                $query=$product->whereIn('supplyType',$result);
            }
            if (!empty($formdata['location'])) {
                # code...
                unset($data);
                $data[] = $formdata['location'];
                foreach ($data as $key) {
                    foreach ($key as $value) {
                        $location[]=$value;
                    /*    $query = $product->Where(function($query) use ($value, $category, $max, $min)
                                    {
                                       
                                        $query->orwhere('color', $value);
                                    }); */
                    }
                    
                }

                
            }
             if (!empty($formdata['pricing'])) {
                # code...
                unset($data);
                $data[] = $formdata['pricing'];
                foreach ($data as $key) {
                    foreach ($key as $value) {
                        if($value=='instant_price'){
                            $query==$product->where('instant_price','!=',NULL);
                        }
                        else if($value=='pricewithin15days'){
                            $query=$product->where('pricewithin15days','!=',NULL);
                        }
                        else if($value=='within30days'){
                            $query=$product->where('pricewithin30days','!=',NULL);
                        }
                    /*    $query = $product->Where(function($query) use ($value, $category, $max, $min)
                                    {
                                       
                                        $query->orwhere('color', $value);
                                    }); */
                    }
                    
                }

               
            }
             if (!empty($formdata['payment'])) {
                # code...
                unset($data);
                $data[] = $formdata['payment'];
                $products=[];
                foreach ($data as $key) {
                    foreach ($key as $value) {
                        $payment_delivery_information=PaymentDeliveryInformation::where('payment_mehod','=',$value)->get();
                        if(count($payment_delivery_information)>0){
                            foreach ($payment_delivery_information as $pay) {
                           $products[]=$pay->product_id;
                            }
                        }
                       
                    /*    $query = $product->Where(function($query) use ($value, $category, $max, $min)
                                    {
                                       
                                        $query->orwhere('color', $value);
                                    }); */
                    }
                    
                }
                if(count($products)>0){
               $query=$product->whereIn('product_id',$products);
           }
            }

            
        }else{

            $query = $query; /*$product->whereBetween('price', [$min, $max])->where('category', $category); */
        }
$myurl =  asset('/');
        $querys = $query->get(); 
           
            foreach ($querys as $key) {
                $product=products::find($key->product_id);

                $price = number_format($key->price);
                    $instance='Not Listed';
                            $within15days='Not Listed';
                            $within30days='Not Listed';
                                    if(Session::has('currency')){
                                    $getPrice=currency::find(1);
                                    if(Session::get('currency')=='Dollar'){
                                    $price="$ ".$key->price*$getPrice->Dollar;
                                    if($key->instant_price){
                                    $instance="$ ".$key->instant_price*$getPrice->Dollar;
                                    }
                                    if($key->pricewithin15days){
                                    $within15days="$ ".$key->pricewithin15days*$getPrice->Dollar;
                                    }
                                    if($key->pricewithin30days){
                                    $within30days="$ ".$key->pricewithin30days*$getPrice->Dollar;
                                    }
                                    }
                                    else if(Session::get('currency')=='Yen'){
                                    $price="¥ ".$key->price*$getPrice->Yen;
                                     if($key->instant_price){
                                    $instance="¥ ".$key->instant_price*$getPrice->Yen;
                                    }
                                    if($key->pricewithin15days){
                                    $within15days="¥ ".$key->pricewithin15days*$getPrice->Yen;
                                    }
                                    if($key->pricewithin30days){
                                    $within30days="¥ ".$key->pricewithin30days*$getPrice->Yen;
                                    }
                                }
                                else if(Session::get('currency')=='Euro'){
                                $price="€ ".$key->price*$getPrice->Euro;
                                 if($key->instant_price){
                                    $instance="€ ".$key->instant_price*$getPrice->Euro;
                                    }
                                    if($key->pricewithin15days){
                                    $within15days="€ ".$key->pricewithin15days*$getPrice->Euro;
                                    }
                                    if($key->pricewithin30days){
                                    $within30days="€ ".$key->pricewithin30days*$getPrice->Euro;
                                    }
                            }
                            else{
                            $price="₦ ".$key->price;
                             if($key->instant_price){
                                    $instance="₦ ".$key->instant_price;
                                    }
                                    if($key->pricewithin15days){
                                    $within15days="₦ ".$key->pricewithin15days;
                                    }
                                    if($key->pricewithin30days){
                                    $within30days="₦ ".$key->pricewithin30days;
                                    }
                        }
                                    }
                                    else{
                                     $price="₦ ".$key->price;
                                      if($key->instant_price){
                                    $instance="₦ ".$key->instant_price;
                                    }
                                    if($key->pricewithin15days){
                                    $within15days="₦ ".$key->pricewithin15days;
                                    }
                                    if($key->pricewithin30days){
                                    $within30days="₦ ".$key->pricewithin30days;
                                    }
                                }
                                $category=category::find($key->category);
                               $modal=productmodel::find($key->model_id);
                               $manufactoror=productmanufacturer::find($key->manufacturer_id);
                               
                              
                           $source='Not Listed';
                           if($key->source_id){
                           $sources=source::find($key->source_id);
                           $source=$sources->name;
                       }
                       $condition='Not Listed';
                       if($key->condition_id){
                       $con=condition::find($key->condition_id);
                       $condition=$con->name;
                   }
                   
                   $vendor=vendors::where('user_id','=',$key->user_id)->first();
                
                    $ratingss=$this->ratings($key->product_id);
                     if(count($location)>0){
                       
                        $locationget=vendors::where('user_id','=',$key->user_id)->whereIn('location',$location)->get();
                        if(count($locationget)>0){
                            $isCountinue=true;
                        }
                        else{
                            $isCountinue=false;
                        }
                    }
                    else{
                        $isCountinue=true;
                    }
                    if($isCountinue){
                        $modalName = $modal ? $modal->name : '';
                        $manufactororName = $manufactoror ? $manufactoror->name : '';
            $view .= "<div class='col-md-4'>
                            <div class='product 'data-title='$key->id' data-id='$key->name' data-category='$category->name' data-model='$modalName' data-manufactoror='$manufactororName' data-instance='$instance' data-within15='$within15days' data-within30='$within30days'
                            data-source='$source' data-price='$price' data-condition='$condition' data-vendor='$vendor->vendorname' data-location='$vendor->country'>
                                <ul class='product-labels'></ul>
                                <div class='product-img-wrap'>

                                    <img class='product-img-primary' src='".$myurl."/$product->image' alt='Image Alternative text' title='Image Title' style='height: 250px' />
                                    <img class='product-img-alt' src='".$myurl."/$product->image' alt='Image Alternative text' title='Image Title' style='height: 250px' />
                                </div>
                                <a class='product-link' href='".$myurl."/product/$key->slog'></a>
                                <div class='product-caption'>
                                    <ul class='product-caption-rating'>
                                    ";
                                     if($ratingss>0){
                                      if($ratingss==1){
                                      $view .=" <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li><i class='fa fa-star'></i>
                                        </li>";
                                    }
                                      elseif($ratingss==2){
                                       $view .="<li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li><i class='fa fa-star'></i>
                                        </li>";
                                    }
                                      elseif($ratingss==3){
                                      $view=" <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>
                                        <li><i class='fa fa-star'></i>
                                        </li>";
                                    }
                                      elseif($ratingss=4){
                                       $view .="<li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li><i class='fa fa-star'></i>
                                        </li>";
                                    }
                                      else{
                                       $view .="<li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>";
                                    }
                                      
                                       }
                                       else{
                                       $view .="<li class=''><i class='fa fa-star'></i>
                                        </li>
                                        <li class=''><i class='fa fa-star'></i>
                                        </li>
                                        <li class=''><i class='fa fa-star'></i>
                                        </li>
                                        <li class=''><i class='fa fa-star'></i>
                                        </li>
                                        <li ><i class='fa fa-star'></i>
                                        </li>";
                                    }
                                        
                                    $view.="
                                    </ul>
                                    <h5 class='product-caption-title'>$key->name</h5>
                                    <div class='product-caption-price'><span class='product-caption-price-new'>$price</span>
                                    </div>
                                    
                                    <a class='btn btn-info addToCompare' style='position: absolute; right: 0;top: 70%;'>Compare</a>
                                </div>
                            </div>
                        </div>";
                    }
                }

return $view;
    }

    public function addtowhishlist()
    {
        $id = $_GET['id'];

        $getwishlist = wishlist::where('user_id', Auth::user()->id)->where('product_id', $id)->first();
        if ($getwishlist) {
            
        }else{
            $wishlist = new wishlist;
        $wishlist->user_id = Auth::user()->id;
        $wishlist->product_id = $id;
        $wishlist->save();
        }
   
    }

    public function subcategory($id)
    {
        $sortIdentity='id';
        $sorting='ASC';
        if(Session::has('sortby')){
        if(Session::get('sortby')=='Newest First'){
            $sortIdentity='id';
            $sorting='ASC';
        }
        else if(Session::get('sortby')=='Price : Lowest First'){
            $sortIdentity='price';
        $sorting='ASC';
        }
        else if(Session::get('sortby')=='Price : Highest First'){
            $sortIdentity='price';
        $sorting='DESC';
        }
        else if(Session::get('sortby')=='Title : A - Z'){
            $sortIdentity='name';
        $sorting='ASC';
        }
        else{
$sortIdentity='name';
        $sorting='DESC';
        }
    }
    $pagination=20;
    if(Session::has('pagination')){
        if(Session::get('pagination')=='9 / page'){
            $pagination=9;
        }
        else if(Session::get('pagination')=='12 / page'){
            $pagination=12;
        }
        else if(Session::get('pagination')=='18 / page'){
            $pagination=18;
        }
        else{
            $pagination=20;
        }
    }
        $subcategory = subcategory::where('slog', $id)->first();
        $category = category::where('id', $subcategory->category_id)->first();
        $id = $subcategory->id;
        $view = '';
        $vendorproduct = vendorproduct::where('subcategory', $id)->where('product_status','1')->where('availability','=','yes')->orderBy($sortIdentity,$sorting)->paginate($pagination);
        $getproductmanu = vendorproduct::where('subcategory', $id)->where('product_status','1')->groupBy('manufacturer_id')->get();
        $getproductmodel = vendorproduct::where('subcategory', $id)->where('product_status','1')->groupBy('model_id')->get();
        $getproductcondition = vendorproduct::where('subcategory', $id)->where('product_status','1')->groupBy('condition_id')->get();
        $getsource = vendorproduct::where('subcategory', $id)->groupBy('source_id')->get();
        $getpaymentmethod=DB::select("SELECT * FROM vendorproduct,payment_delivery_information WHERE vendorproduct.product_id=payment_delivery_information.product_id AND vendorproduct.category=$category->id GROUP BY payment_delivery_information.payment_mehod ");
        $getunit=vendorproduct::where('subcategory',$id)->where('unit','!=',NULL)->groupBy('unit')->get();
        $getcolor=vendorproduct::where('subcategory',$id)->groupBy('color')->get();
        $getaddon = vendorproduct::where('subcategory', $id)->groupBy('addon_id')->get();
         $getlocation=DB::select('SELECT * FROM vendorproduct,vendors WHERE vendorproduct.user_id=vendors.user_id AND vendorproduct.subcategory='.$id.' GROUP BY vendors.location');
         $getsupply_type=vendorproduct::where('subcategory',$id)->groupBy('supplyType')->get();
        $model = '';
        $countmanu = '';
        $countmodel = '';
        $manufacturer = '';
        $condition = '';
        $source = '';
        $addon = '';
        $deliverytype='';
        $units='';
        $countunits='';
        $colors='';
        $countcolors='';
        $location='';
        $countlocation='';
        $supply='';
        $countsupply='';
        foreach ($getproductmanu as $key) {
            
            $getmanu = productmanufacturer::where('id', $key->manufacturer_id)->first();
            $countmanu = vendorproduct::where('subcategory', $id)->where('manufacturer_id', $key->manufacturer_id)->count();
            if($getmanu){
            $manufacturer .= "<div class='checkbox'>
                                <label>
                                    <input class='form iCheck-helper' name='manufacturer[]' style='position:relative;' type='checkbox' value=$key->manufacturer_id />$getmanu->name<span class='category-filters-amount'>($countmanu)</span>
                                </label>
                            </div>";
                        }

        }

        foreach ($getproductmodel as $keys) {
            $getmodel = productmodel::where('id', $keys->model_id)->first();
            $countmodel = vendorproduct::where('subcategory', $id)->where('model_id', $keys->model_id)->count();
            if($getmodel){
            $model .= "<div class='checkbox'>
                                <label>
                                    <input class='form iCheck-helper' name='model[]' style='position:relative;' type='checkbox' value=$keys->model_id />$getmodel->name<span class='category-filters-amount'>($countmodel)</span>
                                </label>
                            </div>";
                        }
        }

       foreach ($getproductcondition as $keys) {
            $getcondition = condition::where('id', $keys->condition_id)->first();
            $countcondition = vendorproduct::where('subcategory', $id)->where('condition_id', $keys->condition_id)->count();
            $condition .= "<div class='checkbox'>
                                <label>
                                    <input class='form iCheck-helper' name='condition[]' style='position:relative;' type='checkbox' value=$keys->condition_id />$getcondition->name<span class='category-filters-amount'>($countcondition)</span>
                                </label>
                            </div>";
        }
         /*foreach ($getsource as $keys) {
            $getsource = source::where('id', $keys->source_id)->first();
            $countsource = vendorproduct::where('subcategory', $id)->where('source_id', $keys->source_id)->count();
            $source .= "<div class='checkbox'>
                                <label>
                                    <input class='i-check form' name='source[]' type='checkbox' value=$keys->source_id />$getsource->name<span class='category-filters-amount'>($countsource)</span>
                                </label>
                            </div>";
        }
        foreach ($getaddon as $keys) {
            $getadd = productaddon::where('id', $keys->addon_id)->first();
            $countaddon = vendorproduct::where('subcategory', $id)->where('addon_id', $keys->addon_id)->count();
            $addon .= "<div class='checkbox'>
                                <label>
                                    <input class='i-check form' name='addon[]' type='checkbox' value=$keys->addon_id />$getadd->name<span class='category-filters-amount'>($countaddon)</span>
                                </label>
                            </div>";
        }*/

        foreach ($getsource as $keys) {
            $getsource = source::where('id', $keys->source_id)->first();
            if($getsource){
            $countsource = vendorproduct::where('subcategory', $id)->where('source_id', $keys->source_id)->count();
            $source .= "<div class='checkbox'>
                                <label>
                                    <input class='form iCheck-helper' name='source[]' type='checkbox' style='position:relative;' value=$keys->source_id />$getsource->name<span class='category-filters-amount'>($countsource)</span>
                                </label>
                            </div>";
                        }
        }

         foreach ($getpaymentmethod as $method) {
            
           /* $getsource = source::where('id', $keys->source_id)->first();
            if($getsource){
            $countsource = vendorproduct::where('category', $id)->where('source_id', $keys->source_id)->count(); */
            if($method->payment_mehod){
            $deliverytype .= "<div class='checkbox'>
                                <label>
                                    <input class='form iCheck-helper' name='payment[]' type='checkbox' style='position:relative;' value=$method->payment_mehod />$method->payment_mehod<span class='category-filters-amount'></span>
                                </label>
                            </div>";
                        }
                    }
                    foreach ($getunit as $uni) {
                            $countunits=vendorproduct::where('subcategory',$id)->where('unit','=',$uni->unit)->count();
                             if($countunits>0){
         $units .= "<div class='checkbox'>
                                <label>
                                    <input class='form iCheck-helper' name='units[]' type='checkbox' style='position:relative;' value='$uni->unit' />$uni->unit<span class='category-filters-amount'>($countunits)</span>
                                </label>
                            </div>";
                        }
                    }

                    foreach ($getcolor as $color) {
                        if($color->color){
                            $countcolors=vendorproduct::where('subcategory',$id)->where('color','=',$color->color)->count();
                             if($countcolors>0){
         $colors .= "<div class='checkbox'>
                                <label>
                                    <input class='form iCheck-helper' name='color[]' type='checkbox' style='position:relative;' value=$color->color />$color->color<span class='category-filters-amount'>($countcolors)</span>
                                </label>
                            </div>";
                        }
                        }
                    }
                     foreach ($getlocation as $locations) {
                     
                            $countlocation=vendors::where('location','=',$locations->location)->count();

                             if($countlocation>0){
                        
         $location .= "<div class='checkbox'>
                                <label>
                                    <input class=' form iCheck-helper' name='location[]' type='checkbox' style='position:relative;' value=$locations->location />$locations->location<span class='category-filters-amount'>($countlocation)</span>
                                </label>
                            </div>";
                        }
                    
                    }
                     foreach ($getsupply_type as $supplytype) {
                     
                        
                       if($supplytype->supplyType){

                            $countsupply=vendorproduct::where('subcategory',$id)->where('supplyType','=',$supplytype->supplyType)->count();
                        
                             if($countsupply>0){
                       
         $supply .= "<div class='checkbox'>
                                <label>
                                    <input class=' form iCheck-helper' name='supply[]' type='checkbox' style='position:relative;' value=$supplytype->supplyType />$supplytype->supplyType<span class='category-filters-amount'>($countsupply)</span>
                                </label>
                            </div>";
                        }
                    }
                    
                    
                    }
        

        foreach($vendorproduct as $key){

            $products = products::where('id', $key->product_id)->first();

        if(!empty($key->image)){
            $image = $key->image;
        }
        else{
            $image = $products->image;
        }

        $price = number_format($key->price);

$myurl =  asset('/');
        $view .= "";
        }

        $cart = $this->cart();
        return view('home.subcategory', compact('vendorproduct',  'view', 'cart', 'manufacturer', 'model', 'condition', 'source', 'addon', 'id', 'category', 'subcategory','deliverytype','units','colors','location','supply'));
    }
 
    public function followvendor()
    {
        $id = $_GET['id'];

        $getcustomersvendor = customersvendor::where('customer_id', Auth::user()->id)->where('vendor_id', $id)->first();
            if ($getcustomersvendor) {
                # code...
            }else{

        $addcustomersvendor = new customersvendor;
        $addcustomersvendor->customer_id = Auth::user()->id;
        $addcustomersvendor->vendor_id = $id;
        $addcustomersvendor->status = 'pending';
        $addcustomersvendor->save();
    }
    }


    public function all_products()
    {

        //$getcat = category::where('slog', $id)->first();
        //$id = $getcat->id;

        $getcategory = category::get();
        $getsubcategory = subcategory::get();
        $getproducts = vendorproduct::where('product_status','1')->get();
        $getproductmanu = vendorproduct::where('product_status','1')->groupBy('manufacturer_id')->get();
        $getproductmodel = vendorproduct::where('product_status','1')->groupBy('model_id')->get();
        $getproductcondition = vendorproduct::groupBy('condition_id')->get();
        $getsource = vendorproduct::groupBy('source_id')->get();
        $getaddon = vendorproduct::groupBy('addon_id')->get();
        $model = '';
        $countmanu = '';
        $countmodel = '';
        $manufacturer = '';
        $condition = '';
        $source = '';
        $addon = '';

        foreach ($getproductmanu as $key) {
            
            $getmanu = productmanufacturer::where('id', $key->manufacturer_id)->first();
            $countmanu = vendorproduct::where('manufacturer_id', $key->manufacturer_id)->count();
            $manufacturer .= "<div class='checkbox'>
                                <label>
                                    <input class='i-check form iCheck-helper' name='manufacturer[]' type='checkbox' value=$key->manufacturer_id />$getmanu->name<span class='category-filters-amount'>($countmanu)</span>
                                </label>
                            </div>";

        }

        foreach ($getproductmodel as $keys) {
            $getmodel = productmodel::where('id', $keys->model_id)->first();
            $countmodel = vendorproduct::where('model_id', $keys->model_id)->count();
            $model .= "<div class='checkbox'>
                                <label>
                                    <input class='i-check form iCheck-helper' name='model[]' type='checkbox' value=$keys->model_id />$getmodel->name<span class='category-filters-amount'>($countmodel)</span>
                                </label>
                            </div>";
        }

        foreach ($getproductcondition as $keys) {
            $getcondition = condition::where('id', $keys->condition_id)->first();
            $countcondition = vendorproduct::where('condition_id', $keys->condition_id)->count();
            $condition .= "<div class='checkbox'>
                                <label>
                                    <input class='i-check form iCheck-helper' name='condition[]' type='checkbox' value=$keys->condition_id />$getcondition->name<span class='category-filters-amount'>($countcondition)</span>
                                </label>
                            </div>";
        }
        /*foreach ($getsource as $keys) {
            $getsource = source::where('id', $keys->source_id)->first();
            $countsource = vendorproduct::where('category', $id)->where('source_id', $keys->source_id)->count();
            $source .= "<div class='checkbox'>
                                <label>
                                    <input class='i-check form iCheck-helper' name='source[]' type='checkbox' value=$keys->source_id />$getsource->name<span class='category-filters-amount'>($countsource)</span>
                                </label>
                            </div>";
        }
        foreach ($getaddon as $keys) {
            $getadd = productaddon::where('id', $keys->addon_id)->first();
            $countaddon = vendorproduct::where('category', $id)->where('addon_id', $keys->addon_id)->count();
            $addon .= "<div class='checkbox'>
                                <label>
                                    <input class='i-check form iCheck-helper' name='addon[]' type='checkbox' value=$keys->addon_id />$getadd->name<span class='category-filters-amount'>($countaddon)</span>
                                </label>
                            </div>";
        }
*/
        $view = '';     

        foreach($getproducts as $key){

            $products = products::where('id', $key->product_id)->first();

        if(!empty($key->image)){
            $image = $key->image;
        }
        else{
            $image = $products->image;
        }

        $price = number_format($key->price);


        $view .= "<div class='col-md-4'>
                            <div class='product '>
                                <ul class='product-labels'></ul>
                                <div class='product-img-wrap'>
                                    <img class='product-img-primary' src='http://localhost/tucker/$image' alt='Image Alternative text' title='Image Title' style='height: 180px' />
                                    <img class='product-img-alt' src='http://localhost/tucker/$image' alt='Image Alternative text' title='Image Title' style='height: 180px' />
                                </div>
                                <a class='product-link' href='".url('product/'.$key->slog)."'></a>
                                <div class='product-caption'>
                                    <ul class='product-caption-rating'>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li><i class='fa fa-star'></i>
                                        </li>
                                    </ul>
                                    <h5 class='product-caption-title'>$products->name</h5>
                                    <div class='product-caption-price'><span class='product-caption-price-new'>$ $price</span>
                                    </div>
                                    <ul class='product-caption-feature-list'>
                                        <li>Free Shipping</li>
                                    </ul>
                                </div>
                            </div>
                        </div>";
        }


    $cart = $this->cart();
        return view('home.all_product', compact('getcategory', 'getproducts','getsubcategory', 'view', 'cart', 'manufacturer', 'model', 'condition', 'source', 'addon', 'id'));
    }


    public function vendor_type_product($id)
    {
        $vendors = vendors::where('vendor_type',$id)->get();
        
        $cart = $this->cart();
        return view('home.vendors', compact('vendors', 'cart'));
    }
    public function verify($email,$token){

    $user=User::where('email','=',$email)->where('verification_token','=',$token)->where('verify','=',0)->first();
    if($user){
        $user->verify=1;
        $user->save();
        if($user->user_type=='Customer'){
        return redirect('/')->with('message','Your account verify successfully');
    }
        else if($user->user_type=='Vendor'){
            return redirect('vendor/login')->with('message','Your account verify successfully');
        }
    }
    else{
        return redirect('/')->with('message','We could not verify your account');
    }
}
    public function currency(Request $request){
        if($request->ajax()){
            $currency=$request->get('currency');
            Session::put('currency',$currency);
            echo json_encode('yes');
        }
    }
    public function subcategorylist($id){
        $getcategory=category::where('slog',$id)->first();
        $getsubcategory=subcategory::where('category_id','=',$getcategory->id)->get();

        $cart = $this->cart();
        return view('home.subcategorylist',compact('cart','getcategory','getsubcategory'));
    }
     public function searchitems($qq){
         $sortIdentity='id';
        $sorting='ASC';
        if(Session::has('sortby')){
        if(Session::get('sortby')=='Newest First'){
            $sortIdentity='id';
            $sorting='ASC';
        }
        else if(Session::get('sortby')=='Price : Lowest First'){
            $sortIdentity='price';
        $sorting='ASC';
        }
        else if(Session::get('sortby')=='Price : Highest First'){
            $sortIdentity='price';
        $sorting='DESC';
        }
        else if(Session::get('sortby')=='Title : A - Z'){
            $sortIdentity='name';
        $sorting='ASC';
        }
        else{
$sortIdentity='name';
        $sorting='DESC';
        }
    }
    $pagination=20;
    if(Session::has('pagination')){
        if(Session::get('pagination')=='9 / page'){
            $pagination=9;
        }
        else if(Session::get('pagination')=='12 / page'){
            $pagination=12;
        }
        else if(Session::get('pagination')=='18 / page'){
            $pagination=18;
        }
        else{
            $pagination=20;
        }
    }
        $parts = preg_split('/\s+/', $qq);

        $query=DB::table('vendorproduct');
        foreach ($parts as $part) {
            $term = term::where('name',$part)->first();
      if ($term == null) {
          $terms = new term();
          $terms->name = $part;
          $terms->count = 1;
          $terms->save();
      }else{
            $term->increment('count');
            $term->save();
      }
        }
        foreach ($parts as $key) {
            $query=$query->orWhere(function($query) use ($key){
                $query->orWhere('name','like','%'.$key.'%');
            });
        }
        foreach ($parts as $key) {
           $query=$query->orWhere(function($query) use($key){
            $query->orwhere('product_generic_name','like','%'.$key.'%');
           });
        }
        foreach ($parts as $key) {
           $query=$query->orWhere(function($query) use($key){
            $query->orwhere('part_number','like','%'.$key.'%');
           });
        }
        foreach ($parts as $key) {
           $query=$query->orWhere(function($query) use($key){
            $query->orwhere('model_number','like','%'.$key.'%');
           });
        }
        foreach ($parts as $key) {
           $query=$query->orWhere(function($query) use($key){
            $query->orwhere('serial_number','like','%'.$key.'%');
           });
        }
         foreach ($parts as $key) {
           $query=$query->orWhere(function($query) use($key){
            $query->orwhere('key_specification','like','%'.$key.'%');
           });
        }
         foreach ($parts as $key) {
           $query=$query->orWhere(function($query) use($key){
            $query->orwhere('other_information','like','%'.$key.'%');
           });
        }
        foreach ($parts as $key) {
            $manufacturer=productmanufacturer::where('name','like','%'.$key.'%')->get();
            if(count($manufacturer)>0){
                foreach ($manufacturer as $key) {
                   $query->orwhere('manufacturer_id','=',$key->id);
                }
            }
        }
         foreach ($parts as $key) {
            $model=productmodel::where('name','like','%'.$key.'%')->get();
            if(count($model)>0){
                foreach ($model as $key) {
                   $query->orwhere('model_id','=',$key->id);
                }
            }
        }
        $search=$query->orderBy($sortIdentity,$sorting)->paginate($pagination);
       /* $search=Search::search(
      "vendorproduct" ,
      ['name' , 'product_generic_name','part_number',] ,
      $qq  ,
      ['name' , 'product_generic_name', 'part_number','product_id','slog','image','category','subcategory','model_id','source_id','manufacturer_id','condition_id','user_id','id','price'],
      ['product_id'  , 'asc'] ,
      true ,
      30
); */
$model = '';
        $countmanu = '';
        $countmodel = '';
        $manufacturer = '';
        $condition = '';
        $source = '';
        $addon = '';
        $deliverytype='';
        $units='';
        $location='';
        $supply='';
        $countunits='';
        $colors='';
        $countcolors='';
        
         $getproductcondition=(clone $query)->groupBy('condition_id')->get();
         $q1=$query->get();
         $getpaymentmethod=DB::select("SELECT * FROM vendorproduct,payment_delivery_information WHERE vendorproduct.product_id=payment_delivery_information.product_id AND vendorproduct.product_id IN (".implode(',', $search->pluck('product_id')->toArray()).") GROUP BY payment_delivery_information.payment_mehod ");
         $getsource = vendorproduct::whereIn('product_id', $q1->pluck('product_id'))->groupBy('source_id')->get();
         $getunit=vendorproduct::whereIn('product_id', $search->pluck('product_id'))->where('unit','!=',NULL)->groupBy('unit')->get();
         $getlocation=DB::select('SELECT * FROM vendorproduct,vendors WHERE vendorproduct.user_id=vendors.user_id AND vendorproduct.product_id IN ('.implode(",", $search->pluck("product_id")->toArray()).') GROUP BY vendors.location');
         $getsupply_type=vendorproduct::whereIn('product_id', $search->pluck('product_id'))->groupBy('supplyType')->get();
         $getcolor=vendorproduct::whereIn('product_id', $search->pluck('product_id'))->groupBy('color')->get();

         foreach ($getproductcondition as $keys) {
            $getcondition = condition::where('id','=',$keys->condition_id)->first();
           $countcondition = $q1->where('condition_id', $keys->condition_id)->count();
            $condition .= "<div class='checkbox'>
                                <label>
                                    <input class='form iCheck-helper' name='condition[]' type='checkbox' value=$keys->condition_id style='position:relative;' />$getcondition->name<span class='category-filters-amount'>($countcondition)</span>
                                </label>
                            </div>";
        }
         foreach ($getsource as $keys) {
             $getsource = source::where('id', $keys->source_id)->first();
             if($getsource){
                 $countsource = vendorproduct::whereIn('product_id', $q1->pluck('id'))->where('source_id', $keys->source_id)->count();
                 $source .= "<div class='checkbox'>
                                <label>
                                    <input class='form iCheck-helper' name='source[]' type='checkbox' style='position:relative;' value=$keys->source_id />$getsource->name<span class='category-filters-amount'>($countsource)</span>
                                </label>
                            </div>";
             }
         }
         $getproductmodel=(clone $query)->groupBy('model_id')->get();
         $q2=$query->get();

         foreach ($getproductmodel as $keys) {
            if ($keys->model_id) {
                $getmodel = productmodel::where('id', $keys->model_id)->first();
                $countmodel = $q2->where('model_id', $getmodel->id)->count();
                $model .= "<div class='checkbox'>
                                <label>
                                    <input class='form iCheck-helper' name='model[]' type='checkbox' value=$keys->model_id style='position:relative;' />$getmodel->name<span class='category-filters-amount'>($countmodel)</span>
                                </label>
                            </div>";
            }
        }
        $getproductmanu=(clone $query)->groupBy('manufacturer_id')->get();
        $q3=$query->get();
        foreach ($getproductmanu as $key) {
            if ($key->manufacturer_id) {
                $getmanu = productmanufacturer::where('id', $key->manufacturer_id)->first();
                $countmanu = $q3->where('manufacturer_id', $key->manufacturer_id)->count();
                $manufacturer .= "<div class='checkbox'>
                                <label>
                                    <input class='form iCheck-helper' name='manufacturer[]' type='checkbox' value=$key->manufacturer_id style='position:relative;' />$getmanu->name<span class='category-filters-amount'>($countmanu)</span>
                                </label>
                            </div>";

            }
        }
      
       
        $getsource=(clone $query)->groupBy('source_id')->get();
         $q4=$query->get();
        foreach ($getsource as $keys) {
            $getsource = source::where('id', $keys->source_id)->first();
            if($getsource){
            $countsource = $q4->where('source_id', $keys->source_id)->count();
            $source .= "<div class='checkbox'>
                                <label>
                                    <input class='form iCheck-helper' name='source[]' type='checkbox' value=$keys->source_id style='position:relative;' />$getsource->name<span class='category-filters-amount'>($countsource)</span>
                                </label>
                            </div>";
                        }
        }

         foreach ($getpaymentmethod as $method) {

             /* $getsource = source::where('id', $keys->source_id)->first();
              if($getsource){
              $countsource = vendorproduct::where('category', $id)->where('source_id', $keys->source_id)->count(); */
             if($method->payment_mehod){
                 $deliverytype .= "<div class='checkbox'>
                                <label>
                                    <input class='form iCheck-helper' name='payment[]' type='checkbox'  value=$method->payment_mehod style='position:relative;' />$method->payment_mehod<span class='category-filters-amount'></span>
                                </label>
                            </div>";
             }
         }
         foreach ($getunit as $uni) {
             $countunits=vendorproduct::whereIn('product_id',$search->pluck('product_id'))->where('unit','=',$uni->unit)->count();
             if($countunits>0){
                 $units .= "<div class='checkbox'>
                                <label>
                                    <input class=' form iCheck-helper' name='units[]' type='checkbox' style='position:relative;' value='$uni->unit' />$uni->unit<span class='category-filters-amount'>($countunits)</span>
                                </label>
                            </div>";
             }
         }
         foreach ($getlocation as $locations) {

             $countlocation=vendors::where('location','=',$locations->location)->count();

             if($countlocation>0){

                 $location .= "<div class='checkbox'>
                                <label>
                                    <input class=' form iCheck-helper' name='location[]' type='checkbox' style='position:relative;' value=$locations->location />$locations->location<span class='category-filters-amount'>($countlocation)</span>
                                </label>
                            </div>";
             }

         }

         foreach ($getsupply_type as $supplytype) {


             if($supplytype->supplyType){
                 $countsupply=vendorproduct::whereIn('product_id',$search->pluck('product_id'))->where('supplyType','=',$supplytype->supplyType)->count();
                 if($countsupply>0){

                     $supply .= "<div class='checkbox'>
                                <label>
                                    <input class=' form iCheck-helper' name='supply[]' type='checkbox' style='position:relative;' value=$supplytype->supplyType />$supplytype->supplyType<span class='category-filters-amount'>($countsupply)</span>
                                </label>
                            </div>";
                 }
             }


         }
         foreach ($getcolor as $color) {
             if($color->color){
                 $countcolors=vendorproduct::whereIn('product_id',$search->pluck('product_id'))->where('color','=',$color->color)->count();
                 if($countcolors>0){

                     $colors .= "<div class='checkbox'>
                                <label>
                                    <input class=' form iCheck-helper' name='color[]' type='checkbox' style='position:relative;' value=$color->color />$color->color<span class='category-filters-amount'>($countcolors)</span>
                                </label>
                            </div>";
                 }
             }
         }
        $cart = $this->cart();
        return view('search.search',compact('search','cart','manufacturer','qq','model','source','condition', 'deliverytype', 'units', 'location', 'supply', 'color'));
    }
    public function searchterms(Request $request){
        $parts = preg_split('/\s+/', $request->get('search'));
        $query=DB::table('vendorproduct');
        foreach ($parts as $key) {
            $query=$query->orWhere(function($query) use ($key){
                $query->orWhere('name','like','%'.$key.'%');
            });
        }
        foreach ($parts as $key) {
           $query=$query->orWhere(function($query) use($key){
            $query->orwhere('product_generic_name','like','%'.$key.'%');
           });
        }
        foreach ($parts as $key) {
           $query=$query->orWhere(function($query) use($key){
            $query->orwhere('part_number','like','%'.$key.'%');
           });
        }
        foreach ($parts as $key) {
            $manufacturer=productmanufacturer::where('name','like','%'.$key.'%')->get();
            if(count($manufacturer)>0){
                foreach ($manufacturer as $key) {
                   $query->orwhere('manufacturer_id','=',$key->id);
                }
            }
        }
         foreach ($parts as $key) {
            $model=productmodel::where('name','like','%'.$key.'%')->get();
            
            if(count($model)>0){
                foreach ($model as $key) {
                   $query->orwhere('model_id','=',$key->id);
                }
            }
        }

       $array=[];
        $query=$query->get();
       foreach ($query as $que) {
          $array[]= (int) $que->id;
       }
        /** @var Builder $products */
        $products=DB::table('vendorproduct')->whereIn('id',$array);
        parse_str($_GET['val'], $formdata);
        $price = $_GET['price'];

        $price = explode(";", $price);
        $min = (float) $price[0];
        $max = (float) $price[1];

        $myurl =  asset('/');
        $products=$products->whereBetween('price',[$min,$max]);
        $value = '';
        $view = '';
      
        if (!empty($formdata)) {
            $data = array();
            if (!empty($formdata['manufacturer'])) {
                # code...
                $data[] = $formdata['manufacturer'];

                foreach ($data as $key) {
                    foreach ($key as $value) {

                      /*  $query = $product->orWhere(function($query) use ($value, $category, $max, $min)
                                    {
                                        $query->where('category', $category)
                                        ->whereBetween('price', [$min, $max])
                                        ->where('manufacturer_id', $value);
                                    });
                        */
                                    $man[]=$value;
                    }
                    
                }
                $products=$products->whereIn('manufacturer_id',$man);
                
            }
             if (!empty($formdata['model'])) {
                # code...
                unset($data);
                $data[] = $formdata['model'];

                foreach ($data as $key) {
                    foreach ($key as $value) {
                    /*    $query = $product->Where(function($query) use ($value, $category, $max, $min)
                                    {
                                        $query->where('category', $category)
                                        ->whereBetween('price', [$min, $max])
                                        ->where('model_id', $value);
                                    }); */
                                    $modal[]=$value;
                    }
                    
                }
                    $products=$products->whereIn('model_id',$modal);
            }

            if (!empty($formdata['condition'])) {
                # code...
                unset($data);
                $data[] = $formdata['condition'];

                foreach ($data as $key) {
                    foreach ($key as $value) {

                      /*  $query = $product->Where(function($query) use ($value, $category, $max, $min)
                                    {
                                        $query->where('category', $category)
                                        ->whereBetween('price', [$min, $max])
                                        ->where('condition_id', $value);
                                    });
                                    */
                                    $cond[]=$value;
                    }
                    
                }
                $products=$products->whereIn('condition_id',$cond);
            }

            if (!empty($formdata['source'])) {
                # code...
                unset($data);
                $data[] = $formdata['source'];

                    foreach ($data as $key) {
                    foreach ($key as $value) {
                        /*$query = $product->Where(function($query) use ($value, $category, $max, $min)
                                    {
                                        $query->where('category', $category)
                                        ->whereBetween('price', [$min, $max])
                                        ->where('source_id', $value);
                                    });*/
                        $source[]=$value;
                    }
                    
                }
                $products=$products->whereIn('source_id',$source);

            }
        }
        
        $products=$products->get();
      
        foreach ($products as $key) {

             $product=products::find($key->product_id);

                $price = number_format($key->price);
                    $instance='Not Listed';
                            $within15days='Not Listed';
                            $within30days='Not Listed';
                                    if(Session::has('currency')){
                                    $getPrice=currency::find(1);
                                    if(Session::get('currency')=='Dollar'){
                                    $price="$ ".$key->price*$getPrice->Dollar;
                                    if($key->instant_price){
                                    $instance="$ ".$key->instant_price*$getPrice->Dollar;
                                    }
                                    if($key->pricewithin15days){
                                    $within15days="$ ".$key->pricewithin15days*$getPrice->Dollar;
                                    }
                                    if($key->pricewithin30days){
                                    $within30days="$ ".$key->pricewithin30days*$getPrice->Dollar;
                                    }
                                    }
                                    else if(Session::get('currency')=='Yen'){
                                    $price="¥ ".$key->price*$getPrice->Yen;
                                     if($key->instant_price){
                                    $instance="¥ ".$key->instant_price*$getPrice->Yen;
                                    }
                                    if($key->pricewithin15days){
                                    $within15days="¥ ".$key->pricewithin15days*$getPrice->Yen;
                                    }
                                    if($key->pricewithin30days){
                                    $within30days="¥ ".$key->pricewithin30days*$getPrice->Yen;
                                    }
                                }
                                else if(Session::get('currency')=='Euro'){
                                $price="€ ".$key->price*$getPrice->Euro;
                                 if($key->instant_price){
                                    $instance="€ ".$key->instant_price*$getPrice->Euro;
                                    }
                                    if($key->pricewithin15days){
                                    $within15days="€ ".$key->pricewithin15days*$getPrice->Euro;
                                    }
                                    if($key->pricewithin30days){
                                    $within30days="€ ".$key->pricewithin30days*$getPrice->Euro;
                                    }
                            }
                            else{
                            $price="₦ ".$key->price;
                             if($key->instant_price){
                                    $instance="₦ ".$key->instant_price;
                                    }
                                    if($key->pricewithin15days){
                                    $within15days="₦ ".$key->pricewithin15days;
                                    }
                                    if($key->pricewithin30days){
                                    $within30days="₦ ".$key->pricewithin30days;
                                    }
                        }
                                    }
                                    else{
                                     $price="₦ ".$key->price;
                                      if($key->instant_price){
                                    $instance="₦ ".$key->instant_price;
                                    }
                                    if($key->pricewithin15days){
                                    $within15days="₦ ".$key->pricewithin15days;
                                    }
                                    if($key->pricewithin30days){
                                    $within30days="₦ ".$key->pricewithin30days;
                                    }
                                }
                                $category=category::find($key->category);
                               $modal=productmodel::find($key->model_id);
                               $manufactoror=productmanufacturer::find($key->manufacturer_id);
                               
                              
                           $source='Not Listed';
                           if($key->source_id){
                           $sources=source::find($key->source_id);
                           $source=$sources->name;
                       }
                       $condition='Not Listed';
                       if($key->condition_id){
                       $con=condition::find($key->condition_id);
                       $condition=$con->name;
                   }
                   
                   $vendor=vendors::where('user_id','=',$key->user_id)->first();
             $view .= "<div class='col-md-4'>
                            <div class='product >
                                <ul class='product-labels'></ul>
                                <div class='product-img-wrap'>

                                    <img class='product-img-primary' src='".$myurl."/$product->image' alt='Image Alternative text' title='Image Title' style='height: 250px' />
                                    <img class='product-img-alt' src='".$myurl."/$product->image' alt='Image Alternative text' title='Image Title' style='height: 250px' />
                                </div>
                                <a class='product-link' href='".$myurl."/product/$key->slog'></a>
                                <div class='product-caption'>
                                    <ul class='product-caption-rating'>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li class='rated'><i class='fa fa-star'></i>
                                        </li>
                                        <li><i class='fa fa-star'></i>
                                        </li>
                                    </ul>
                                    <h5 class='product-caption-title'>$key->name</h5>
                                    <div class='product-caption-price'><span class='product-caption-price-new'>$price</span>
                                    </div>
                                    
                                    <a class='btn btn-info addToCompare' style='position: absolute; right: 0;top: 70%;'>Compare</a>
                                </div>
                            </div>
                        </div>";
                    }
                        return $view;
        
    }
    public function newsletter(Request $request){
    $this->validate(request(), [
            'email' => 'required|email'
            ]);
    $newsletter=new newslatter;
    $newsletter->email=$request->email;
    $newsletter->save();
    return back()->with('message','Email is added as Newsletter!');
    }
    public function contact_us(Request $request){
        $this->validate(request(),[
            'name'=>'required',
            'email'=>'required|email',
            'message'=>'required'
        ]);
         Mail::to('kajandilimited@gmail.com')->send(new contact_us($request->name,$request->email,$request->message));
         return back()->with('message','Your message is delivered successfully!');
    }
    public function pagecontact(){
        $cart=$this->cart();
        return view('home.contact_us',compact('cart'));
    }
    public function vendorcountry(Request $request){
        if($request->ajax()){
            $options='';
            $country=$request->get('country');
            $cities=city::where('country_name','=',$country)->groupBy('state_name')->get();
            if(count($cities)>0){
                foreach ($cities as  $value) {
                    $options .=' <option value="'.$value->state_name.'" class="ops">'.$value->state_name.'</option>';
                }
            }
            $data=array('data'=>$options);
            return json_encode($data);
        }
    }
    public function vendorstate(Request $request){
if($request->ajax()){
            $options='';
            $country=$request->get('state');
            $cities=city::where('state_name','=',$country)->groupBy('name')->get();
            if(count($cities)>0){
                foreach ($cities as  $value) {
                    $options .=' <option value="'.$value->name.'" class="opss">'.$value->name.'</option>';
                }
            }
            $data=array('data'=>$options);
            return json_encode($data);
        }    }
        public function vendorcountrybil(Request $request){
        if($request->ajax()){
            $options='';
            $country=$request->get('country');
            $cities=city::where('country_name','=',$country)->groupBy('state_name')->get();
            if(count($cities)>0){
                foreach ($cities as  $value) {
                    $options .=' <option value="'.$value->state_name.'" class="st">'.$value->state_name.'</option>';
                }
            }
            $data=array('data'=>$options);
            return json_encode($data);
        }
    }
    public function vendorstatebil(Request $request){
if($request->ajax()){
            $options='';
            $country=$request->get('state');
            $cities=city::where('state_name','=',$country)->groupBy('name')->get();
            if(count($cities)>0){
                foreach ($cities as  $value) {
                    $options .=' <option value="'.$value->name.'" class="cit">'.$value->name.'</option>';
                }
            }
            $data=array('data'=>$options);
            return json_encode($data);
        }    }
    //currency conversion 
    public static function converter($price)
    {
        if (is_numeric($price)) {
            if (Session::has('currency')) {
                if ($price > 99) {
                    $getPrice = currency::find(1);
                    if (Session::get('currency') == 'Dollar') {
                        $price = "$ " . number_format((float)$price * $getPrice->Dollar);
                    } else {
                        if (Session::get('currency') == 'Yen') {
                            $price = "¥ " . number_format($price * $getPrice->Yen);

                        } else {
                            if (Session::get('currency') == 'Euro') {
                                $price = "€ " . number_format($price * $getPrice->Euro);


                            } else {
                                $price = "₦ " . number_format($price);

                            }
                        }
                    }
                } else {
                    $getPrice = currency::find(1);
                    if (Session::get('currency') == 'Dollar') {
                        $price = "$ " . ($price * $getPrice->Dollar);
                    } else {
                        if (Session::get('currency') == 'Yen') {
                            $price = "¥ " . ($price * $getPrice->Yen);

                        } else {
                            if (Session::get('currency') == 'Euro') {
                                $price = "€ " . ($price * $getPrice->Euro);


                            } else {
                                $price = "₦ " . ($price);

                            }
                        }
                    }
                }

            } else {

                $price = "₦ " . number_format($price);

            }

        }
return $price;
    }
    public static function redirectback(){
        return redirect('/');
    }
    public static function ratings($product_id){
         $reviewCount=DB::table('review')->where('product_id','=',$product_id)->count();
                      $reviews=DB::table('review')->where('product_id','=',$product_id)->sum('rating');
                      if($reviewCount>0){
                     return  $ratingss=(int)($reviews/$reviewCount);
                    }
                    else{
                     return $ratingss=0;
                    }
    }
    public function units(){
        return view('admin.unit.index');
    }
    public function addunit(){
        return view('admin.unit.create');
    }
    public function saveunit(Request $request){
        $this->validate(request(),[
            'unit'=>'required|unique:units',

        ]);
        $unit=new unit;
        $unit->unit=$request->unit;
        $unit->save();
        return redirect('/admin/units')->with('message','Unit added successfully');
    }
    public function editunit($id){
        $unit=unit::find($id);
        return view('admin.unit.edit',compact('unit'));
    }
    public function updateunit(Request $request,$id){
        $this->validate(request(),[
            'unit'=>'required|unique:units',

        ]);
        $unit=unit::find($id);
        $unit->unit=$request->unit;
        $unit->save();
        return redirect('/admin/units')->with('message','Unit updated successfully');
    }
    }

   
    

























