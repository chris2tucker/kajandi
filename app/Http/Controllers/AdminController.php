<?php

namespace App\Http\Controllers;

use App\wallethistory;
use App\workplace;
use Illuminate\Http\Request;
use App\category;
use App\subcategory;
use App\vendors;
use App\User;
use App\productmodel;
use App\products;
use App\vendorproduct;
use App\condition;
use App\productmanufacturer;
use App\productaddon;
use App\source;
use App\strengthofmaterial;
use App\productimages;
use App\ordersdetail;
use App\orders;
use App\orderpayment;
use App\outstandingpayment;
use App\Role;
use Input;
use Illuminate\Support\Facades\Hash;
use Redirect;
use Session;
use App\shipping;
use DB;
use App\SocialLinks;
use App\Customer_QA;
use App\Customer;
use App\currency;
use App\Notifications\Ordercancel;
use App\Notifications\Orderactive;
use App\Notifications\ActiveVendor;
use App\Notifications\DeactiveVendor;
use Illuminate\Support\Facades\Notification;
use App\TodayFeatured;
use App\profilehistory;
use Auth;
use App\customersvendor;
use App\term;
use App\favoritevendor;
use Illuminate\Support\Facades\Mail;
use App\Mail\customerNotify;
use App\populartags;
use carbon\Carbon;
use App\rfq;
use App\newslatter;
class AdminController extends Controller
{
    public function index()
    {
        $customer_q_a = Customer_QA::where('answer_status','no')->count();
        $vendor_count = vendors::count();
        $customer_count = Customer::count();
        $order = orders::where('deliverystatus','pending')->count();

       Session::put('customer_q_a',$customer_q_a);
        $orders = Orders::where('deliverystatus','pending')->get();
         $vendors = User::where('user_type','Vendor')->orWhere('user_type','Customer')->latest()->take(5)->get();

         $products = vendorproduct::where('product_status',0)->get();
         $dues = outstandingpayment::where('user_id',Auth::User()->id)->get();
         $users = User::all();
         
        return view('admin.index',compact('vendor_count','customer_count','order','orders','vendors','products','dues','users'));
    }

    public function category()
    {
    	$category = category::all();
    	return view('admin.category', compact('category'));
    }

    public function create_catagory()
    {

        return view('admin.catagory.addcatagory');
    }

    public function addcategory(Request $request)
    {
    	$this->validate(request(), [

    		'name' => 'required',
            'category_description' => 'required',
            'catagory_abbreviation' => 'required',

    		]);

        $category = request('name');
        $slog = str_slug($category);
        $slog = str_replace('/', '__', $slog);


        $newcategory = new category;
        $newcategory->name = request('name');
        $newcategory->category_description = request('category_description');
        $newcategory->catagory_abbreviation = request('catagory_abbreviation');
        $newcategory->add_menu = request('add_menu');
        
        $newcategory->slog = $slog;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            
            $destination = public_path('img');
            $file->move($destination,$file->getClientOriginalName());
            $file_name = $file->getClientOriginalName();

            $newcategory->image        = $file_name;
            }
        $newcategory->save();
        

        Session::flash('status', 'Category Added Successful!');
    	return Redirect::to('admin/category');
    }

    public function edit_catagory($id)
    {

        $catagory = category::find($id);
        return view('admin.catagory.editcatagory', compact('catagory'));
    }

    public function edit_category_update(Request $request,$id)
    {

        $this->validate(request(), [

            'name' => 'required',
            'category_description' => 'required',
            'catagory_abbreviation' => 'required',

            ]);

        $category = request('name');
        $slog = str_slug($category);
        $slog = str_replace('/', '__', $slog);


        $newcategory = category::find($id);
        $newcategory->name = request('name');
        $newcategory->category_description = request('category_description');
        $newcategory->catagory_abbreviation = request('catagory_abbreviation');
        $newcategory->add_menu = request('add_menu');
        
        $newcategory->slog = $slog;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            
            $destination = public_path('img');
            $file->move($destination,$file->getClientOriginalName());
            $file_name = $file->getClientOriginalName();

            $newcategory->image        = $file_name;
            }
        $newcategory->save();
        

        Session::flash('status', 'Category Update Successful!');
        return Redirect::to('admin/category');

    }

    public function delete_catagory($id)
    {

        $category = category::find($id);
        $category->delete();

        Session::flash('status', 'Category Delete Successful!');
        return Redirect::to('admin/category');
    }

    public function subcategory()
    {
    	$category = category::all();
    	$subcategory = subcategory::all();
    	return view('admin.sub_catagory.subcategory', compact('category', 'subcategory'));
    }


    public function add_subcatagory()
    {
        $category = category::all();
        $subcategory = subcategory::all();
        return view('admin.sub_catagory.add_subcatagory', compact('category', 'subcategory'));
    }

    public function addsubcategory(Request $request)
    {
    	$this->validate(request(), [

    		'name' => 'required',
    		'category' => 'required'

    		]);

        $category = request('name');
        $slog = str_slug($category);
        $slog = str_replace('/', '__', $slog);

    	$subcategory = new subcategory;
    	$subcategory->category_id = request('category');
    	$subcategory->name = request('name');
        $subcategory->slog = $slog;
        $subcategory->sub_category_description = request('sub_category_description');
        $subcategory->sub_catagory_abbreviation = request('sub_catagory_abbreviation');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            
            $destination = public_path('img');
            $file->move($destination,$file->getClientOriginalName());
            $file_name = $file->getClientOriginalName();

            $subcategory->image        = $file_name;
            }
    	$subcategory->save();

        session()->flash('status', 'Subcategory Added Successful!');

    	return Redirect::to('admin/subcategory');
    }

    public function edit_subcatagory($id)
    {
      $category = category::all();
      $subcategory = subcategory::find($id);
       return view('admin.sub_catagory.edit_subcatagory', compact('category', 'subcategory')); 
    }

    public function update_subcategory(Request $request,$id)
    {
        $this->validate(request(), [

            'name' => 'required',
            'category' => 'required'

            ]);

        $category = request('name');
        $slog = str_slug($category);
        $slog = str_replace('/', '__', $slog);

        $subcategory = subcategory::find($id);
        $subcategory->category_id = request('category');
        $subcategory->name = request('name');
        $subcategory->slog = $slog;
        $subcategory->sub_category_description = request('sub_category_description');
        $subcategory->sub_catagory_abbreviation = request('sub_catagory_abbreviation');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            
            $destination = public_path('img');
            $file->move($destination,$file->getClientOriginalName());
            $file_name = $file->getClientOriginalName();

            $subcategory->image        = $file_name;
            }
        $subcategory->save();

        session()->flash('status', 'Subcategory Update Successful!');

        return Redirect::to('admin/subcategory');
    }

    public function delete_sub_catagory($id)
    {
       $subcategory = subcategory::find($id);
       $subcategory->delete();

       session()->flash('status', 'Subcategory Delete Successful!');
        return Redirect::to('admin/subcategory'); 
    }

    public function vendors()
    {
    	$vendors = vendors::orderBy('id','DESC')->get();
    	return view('admin.vendors', compact('vendors'));
    	# code...
    }
    public function vendorsDetail($id){
      $vendor=vendors::find($id);

    }
    public function vendor_destroy($id)
    {

        $vendors = vendors::find($id);
        $vendors->delete();
        session()->flash('status', 'Vendor Delete Successful!');
        return Redirect::to('admin/vendors');
    }


    public function active_vendor($id)
    {
        $user = User::find($id);
        $user->status = '1';
        $user->save();
        $vendor=vendors::where('user_id','=',$id)->first();
        if($vendor){
            $vendor->delete_colunm=0;
            $vendor->save();
        }
        $vendorproduct=vendorproduct::where('availability','=','no')->where('user_id','=',$id)->get();
        foreach ($vendorproduct as $key => $value) {
            $value->availability='yes';
            $value->save();
        }
        $user->notify(new DeactiveVendor($user));
        session()->flash('status', 'Vendor Active Successful!');
        return Redirect::to('admin/vendors');
        
    }
    public function deactive_vendor($id)
    {


        $user = User::find($id);
        $user->status = '0';
        $user->save();
        $vendor=vendors::where('user_id','=',$id)->first();
        if($vendor){
            $vendor->delete_colunm=1;
            $vendor->save();
        }
        $vendorproduct=vendorproduct::where('availability','=','yes')->where('user_id','=',$id)->get();
        foreach ($vendorproduct as $key => $value) {
            $value->availability='no';
            $value->save();
        }
         $user->notify(new ActiveVendor($user));
        session()->flash('status', 'Vendor Deactive Successful!');
        return Redirect::to('admin/vendors');
        
    }


    public function addvendor()
    {
    	return view('admin.addvendor');
    }

//to add new vendors
    public function addnewvendor(Request $request)
    {

        $this->validate(request(), [
            'image' => 'required',
            'vendorname' => 'required',
            'vendor_type' => 'required',
            'producttype' => 'required',
            'location' => 'required',
            'address' => 'required',
            'country' => 'required',
            'location' => 'required',
            
            'contactname' => 'required',
            'contactphone' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            

            ]); 

        $role_vendor = Role::where('name', 'Vendor')->first();


        $user = new User;
        $user->email = request('email');
        $user->name = request('vendorname');
        $user->user_type = 'Vendor';
        $user->password = bcrypt(request('password'));
        $user->verify=1;
        $user->status=1;
        $user->save();
        $user_id = $user->id;

        $user->roles()->attach($role_vendor);

      
        
        $vendors = new vendors;
        $vendors->user_id = $user_id;
        $vendors->vendorname = request('vendorname');
        $vendors->address = request('address');
        $vendors->country = request('country');
        $vendors->url = request('url');
        $vendors->cac = request('cac');
        $vendors->workforce = request('workforce');
        $vendors->yearsofexp = request('yearsofexp');
        $vendors->ratings = request('ratings');
        $vendors->contactname = request('contactname');
        $vendors->contactphone = request('contactphone');
        $vendors->contactemail = request('contactemail');
        $vendors->chairmanname = request('chairmanname');
        $vendors->chairmanemail = request('chairmanemail');
        $vendors->chairmanphone = request('chairmanphone');
        $vendors->password = request('password');
        $vendors->producttype = request('producttype');
        $vendors->location = request('location');
        $vendors->state=request('state');
        $vendors->vendor_type    = request('vendor_type');
       if ($request->hasFile('image')) {
                 $image = $request->file('image');
            $filename = time().'-'.$image->getClientOriginalName(). '.' . $image->getClientOriginalExtension();
            $path = base_path('img\products');
            $image->move($path, $filename);
            $images = $filename;

                $vendors->image        = $images;
                }
        $vendors->save();
        
        session()->flash('status', 'Vendor added successful!');  
 
        return Redirect::to('admin/vendors');     
    }

    public function viewvendors($id)
    {
        $vendors = vendors::where('user_id',$id)->first();
        return view('admin/viewvendors', compact('vendors'));
    }

    public function editvendor(Request $request,$id)
    {
        $vendor = vendors::where('user_id',$id)->first();
        
        $this->validate(request(), [

            'vendorname' => 'required',
            'vendor_type' => 'required',
            'producttype' => 'required',
            'location' => 'required',
            'address' => 'required',
            'country' => 'required',
            'location' => 'required',
            
            'contactname' => 'required',
            'contactphone' => 'required',
            'email' => 'required'
            ]); 


        $email = trim(request('email'));



        $getmail = User::where('id', $id)->first();
        if ($getmail->email == $email) {
         
         $user = User::where('id', $id)->update(array('email' => request('email'),
                'user_type' => request('vendor_type'))
            );
            if(request('password')){
                $user->password=bcrypt(request('password'));
                $user->save();
            }

        }else{
            $this->validate(request(), [

            'email' => 'required|unique:users'

            ]); 

            $user = User::where('id', $id)->update(array('email' => request('email'),
                'user_type' => request('vendor_type')
            ));            
        }
        if ($request->hasFile('image')) {
               
                 $image = $request->file('image');
            $filename = time().'-'.$image->getClientOriginalName(). '.' . $image->getClientOriginalExtension();
            $path = base_path('img\products');
            $image->move($path, $filename);
            $images = $filename;

                $vendors_image        = $images;
                
             }else{

                $vendors_image = $vendor->image;
            }

        $vendors = vendors::where('user_id', $id)->update(array('vendorname' => request('vendorname'),
            'address' => request('address'),
            'country' => request('country'),
            'url' => request('url'),
            'cac' => request('cac'),
            'workforce' => request('workforce'),
            'yearsofexp' => request('yearsofexp'),
            'ratings' => request('ratings'),
            'contactname' => request('contactname'),
            'contactphone' => request('contactphone'),
            'contactemail' => request('contactemail'),
            'chairmanname' => request('chairmanname'),
            'chairmanemail' => request('chairmanemail'),
            'chairmanphone' => request('chairmanphone'),
            'producttype' => request('producttype'),
            'location' => request('location'),
            'state'=>request('state'),
            'vendor_type'    => request('vendor_type'),
            'password'    => request('password'),
            'image'=> $vendors_image
            ));

            session()->flash('status', 'Vendor Profile Updated!');
       return Redirect::to('admin/vendors');

    }

    public function products()
    {
        $products = products::all();
        return view('admin.products', compact('products'));
    }

    public function addproduct()
    {
        $category = category::all();
        $subcategory = subcategory::all();
        $productmodel = productmodel::all();
        $productmanufacturer = productmanufacturer::all();
        $condition = condition::all();
        $vendors = vendors::all();
        $productaddon = productaddon::all();
        $source = source::all();
        $strengthofmaterial = strengthofmaterial::all();
        return view('admin.addproduct', compact('category', 'productaddon', 'subcategory', 'productmodel', 'vendors', 'productmanufacturer', 'condition', 'source', 'strengthofmaterial'));
    }

    public function createproduct(Request $request)
    {
        $this->validate(request(), [

            'productname' => 'required',
            'productdescription' => 'required',
            'productcategory' => 'required',
            'productsubscategory' => 'required',
            'partnumber' => 'required',
            'unit' => 'required',
            'manufacturer' => 'required',
            'productmodel' => 'required',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif'
            ]);

            if($request->file('image')){

            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = public_path('img/products/');
            $image->move($path, $filename);
            $images = 'img/products/'.$filename;
}else{
            $images = '';
}

            

        $products = new products;
        $products->name = request('productname'); 
        $products->image = $images;    
        $products->partnumber = request('partnumber');
        $products->description = request('productdescription');
        $products->unit = request('unit');
        $products->weight = request('weight');
        $products->length = request('length');
        $products->category = request('productcategory');
        $products->subcategory = request('productsubscategory');
        $products->manufacturer = request('manufacturer');
        $products->model = request('productmodel');
        $products->save();
        $product_id = $products->id;

       

        session()->flash('status', 'Product added successful!');
        return back()->with('status', 'Product added successful!'); 

    }

    public function changecat()
    {
        $val = request('val');
        $getcat = subcategory::where('category_id', $val)->get();

        $view = '<option value="">Sub Category...</option>';

        foreach ($getcat as $key) {
            $view .= "<option value=$key->id>$key->name</option>";    
        }
        echo $view;
    }

    public function viewproduct($id)
    {
        $id = $id;
        $category = category::all();
        $subcategory = subcategory::all();
        $product = products::where('id', $id)->first();
        $productmodel = productmodel::all();
        $productmanufacturer = productmanufacturer::all();
        return view('admin.viewproduct', compact('product', 'category', 'subcategory', 'productmodel', 'productmanufacturer'));
    }

    public function updateviewproduct($id, Request $request)
    {
        $id = $id;



            if($request->file('image')){

                        $image = $request->file('image');
                        $filename = time() . '.' . $image->getClientOriginalExtension();
                        $path = public_path('/img/products/');
                        $image->move($path, $filename);
                        $images = 'img/products/'.$filename;
            }else{
                $getproduct = products::where('id', $id)->first();
                        $images = $getproduct->image;
            }
            

        $product = products::where('id', $id)->update(array('name' => request('name'),
            'image' => $images,
            'partnumber' => request('partnumber'),
            'description' => request('description'),
            'unit' => request('unit'),
            'weight' => request('weight'),
            'length' => request('length'),
            'category' => request('category'),
            'manufacturer' => request('manufacturer'),
            'model' => request('productmodel'),
            'subcategory' => request('subcategory')
            ));

            session()->flash('status', 'Product Updated Successful!');
        return back();
    }

    public function vendorproduct()
    {
        $vendorproduct = vendorproduct::where('product_status','1')->where('edit_product_staus','yes')->where('delete_product','=',0)->get();
        $view = '';
        $i = 0;
        $myurl =  asset('/');
        foreach($vendorproduct as $key){
        $i++;
        $getproduct = products::where('id', $key->product_id)->first();
        $vendor = vendors::where('user_id', $key->user_id)->first();
        $shippingtype=shipping::where('vendorproduct_id','=',$key->id)->first();
         if (empty($key->image)) {
            $img="/$getproduct->image";
        }else{
            $img="/$key->image";
        }

        $view   .=  "<tr>
                    <td class='text-center'>$i</td>
                    <td class='w100'><img class='img-responsive mw40 ib mr10 product_image' title='user'
                                             src='$myurl/$img'></td>
                    </td>
                    <td><a href='$myurl/admin/ProductDetail/$key->id'>$getproduct->name</a></td>
                    <td><a href='$myurl/vendors/".$vendor->user_id."'>$vendor->vendorname</a></td>
                    <td>$key->part_number</td>
                    <td>".HomeController::converter($key->price)."</td>
                    <td>$key->stock_count</td>
                    <td>$shippingtype->shipping_type</td>
                    <td >$key->model_number</td>
                    <td >$key->serial_number</td>
                    <td class='text-right'>";
                        if($key->availability == 'yes'){
        $view .=     "<a href='$myurl/admin/deactiveproduct/$key->id' class='btn btn-success br2 btn-xs fs12 dropdown-toggle'>Deactive</a>";
                    }
                        else{
           $view .=     "<a href='$myurl/admin/activeproduct/$key->id' class='btn btn-warning br2 btn-xs fs12 dropdown-toggle'>active</a>";
                    }
            $view .= "</td>
                    <td>
                        <a href='$myurl/admin/edit_product/$key->id' class='btn btn-primary btn-xs'>Edit</a>
                        <a href='$myurl/admin/delete_product/$key->id' class='btn btn-danger btn-xs delete'>Delete</a>
                    </td>
                </tr>";
        }
        return view('admin/vendorproduct', compact('vendorproduct', 'view'));
    }
     public function promotion()
    {
        $vendorproduct = vendorproduct::where('promotion','=',1)->get();
        return view('admin.productpromotion',compact('vendorproduct'));
    }
    public function promoteProduct($id){
        $vendorproduct=vendorproduct::find($id);
        $vendors=vendors::where('user_id','=',$vendorproduct->user_id)->first();
        $product=products::find($vendorproduct->product_id);
        $ispresent=TodayFeatured::where('vendor_product_id','=',$vendorproduct->id)->first();
        if($ispresent){
            $ispresent->vendor_id = $vendors->id;
        $ispresent->vendor_product_id = $vendorproduct->id;
        $ispresent->image=$product->image;
        $ispresent->save();
        }else{
            $today_featured = new TodayFeatured();
        $today_featured->vendor_id = $vendors->id;
        $today_featured->vendor_product_id = $vendorproduct->id;
        $today_featured->image=$product->image;
        $today_featured->save();
        }
        $vendorproduct->promotion=0;
        $vendorproduct->save();
        return back()->with('status','Promoted successfully');
    }
    public function cencelPromotion($id){
        $vendorproduct=vendorproduct::find($id);
        $vendorproduct->promotion=0;
        $vendorproduct->save();
        return back()->with('status','successfully cancel promotion');
    }

    public function addvendorproduct()
    {
        $products = products::all();
        $productmodel = productmodel::all();
        $productmanufacturer = productmanufacturer::all();
        $condition = condition::all();
        $vendors = vendors::all();
        $productaddon = productaddon::all();
        $source = source::all();
        $strengthofmaterial = strengthofmaterial::all();
        return view('admin/addvendorproduct', compact('products', 'productmodel', 'productmanufacturer', 'productaddon', 'vendors', 'source', 'strengthofmaterial', 'condition'));
    }

    public function getproduct()
    {
        $product = request('val');
        $getproduct = products::where('id', $product)->first();
        $category = category::where('id', $getproduct->category)->first();
        $subcategory = subcategory::where('id', $getproduct->subcategory)->first();
        $manufacturer = productmanufacturer::where('id', $getproduct->manufacturer)->first();
        $model = productmodel::where('id', $getproduct->model)->first();

        $view = "<div class='section row mbn'>
                                    <div class='col-md-4 ph10'>
                                        <div class='fileupload fileupload-new allcp-form' data-provides='fileupload'>
                                            <div class='fileupload-preview thumbnail mb20'>
                                                <img alt='holder' src=/$getproduct->image>
                                            </div>
                                            <div class='row'>
                                                <div class='col-xs-5 ph10'>
                                                    <span class='button btn-primary btn-file btn-block'>
                                                      <span class='fileupload-new'>Select</span>
                                                      <span class='fileupload-exists'>Change</span>
                                                      <input type='file' name='image'>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='col-md-8 ph10'>
                                        <div class='section mb10'>
                                            <label for='name21' class='field prepend-icon'>
                                                <input type='text' name='productname' id='name21'
                                                       class='event-name gui-input br-light light'
                                                       placeholder='Product Name' value='$getproduct->name'>
                                                <label for='name21' class='field-icon'>
                                                    <i class='fa fa-tag'></i>
                                                </label>
                                            </label>
                                        </div>
                                        <div class='section mb10'>
                                            <label class='field prepend-icon'>
                          <textarea style='height: 160px;' class='gui-textarea br-light bg-light' id='comment'
                                    name='productdescription' placeholder='Product Description'>$getproduct->description</textarea>
                                                <label for='comment' class='field-icon'>
                                                    <i class='fa fa-file'></i>
                                                </label>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <br>

                                <div class='section row'>
                                    <div class='col-md-4 ph10'>
                                        <label for='product-category' class='field select'>
                                            <select class='productcategory' name='productcategory' class='empty'>
                                                <option selected='selected' value=$getproduct->category>$category->name</option>
                                               
                                            </select>
                                            <i class='arrow double'></i>
                                        </label>
                                    </div>
                                    <!-- -------------- /section -------------- -->

                                    <div class='col-md-4 ph10'>
                                        <label for='product-category' class='field select'>
                                            <select id='subcat' name='productsubcategory' class='empty'>
                                                <option selected='selected' value=$getproduct->subcategory>$subcategory->name</option>
                                            </select>
                                            <i class='arrow double'></i>
                                        </label>
                                    </div>
                                    <!-- -------------- /section -------------- -->

                                     <div class='col-md-4 ph10'>
                                        <label for='product-sku' class='field prepend-icon'>
                                            <input type='text' name='partnumber' id='product-sku' class='gui-input' placeholder='Part Number' value=$getproduct->partnumber>
                                            <label for='product-sku' class='field-icon'>
                                                <i class='fa fa-barcode'></i>
                                            </label>
                                        </label>
                                    </div>
                                    <input type='hidden' name='product_id' value=$getproduct->id>
                                    <!-- -------------- /section -------------- -->


                                </div>

                                <div class='section row'>
                                    <div class='col-md-4 ph10'>
                                        <label for='product-unit' class='field prepend-icon'>
                                            <input type='text' name='unit' id='product-unit' class='gui-input' placeholder='Product Unit' value=$getproduct->unit>
                                            <label for='product-unit' class='field-icon'>
                                                <i class='fa fa-barcode'></i>
                                            </label>
                                        </label>
                                    </div>
                                    <!-- -------------- /section -------------- -->

                                    <div class='col-md-4 ph10'>
                                        <label for='product-weight' class='field prepend-icon'>
                                            <input type='text' name='weight' id='product-weight' class='gui-input' placeholder='Product Weight' value=$getproduct->weight>
                                            <label for='product-weight' class='field-icon'>
                                                <i class='fa fa-barcode'></i>
                                            </label>
                                        </label>
                                    </div>
                                    <!-- -------------- /section -------------- -->

                                    <div class='col-md-4 ph10'>
                                        <label for='product-length' class='field prepend-icon'>
                                            <input type='text' name='length' id='product-length' class='gui-input' placeholder='Product Length' value=$getproduct->length>
                                            <label for='product-length' class='field-icon'>
                                                <i class='fa fa-barcode'></i>
                                            </label>
                                        </label>
                                    </div>
                                    <!-- -------------- /section -------------- -->

                                </div>

                                <br>

                                <div class='section row'>
                                    <div class='col-md-4 ph10'>
                                        <label class='field select'>
                                            <select id='product-status' name='manufacturer' class='empty'>
                                                

                                                    <option selected='selected' value=$getproduct->manufacturer > $manufacturer->name</option>
                                                
                                            </select>
                                            <i class='arrow double'></i>
                                        </label>
                                    </div>
                                    <!-- -------------- /section -------------- -->

                                    <div class='col-md-4 ph10'>
                                        <label for='product-model' class='field select'>
                                            <select id='product-model' name='productmodel' class='empty'>
                                                    <option selected='selected' value=$getproduct->model> $model->name </option>
                                                
                                            </select>
                                            <i class='arrow double'></i>
                                        </label>
                                    </div>
                                </div>";
        echo $view;
    }

    public function createvendorproduct(Request $request)
    {
        $this->validate(request(), [
            'manufacturer' => 'required',
            'productmodel' => 'required',
            'productname' => 'required',
            'productdescription' => 'required',
            'productcategory' => 'required',
            'productsubcategory' => 'required',
            'availability' => 'required',
            'productquantity' => 'required',
            'price' => 'required',
            'vendor' => 'required',
            'condition' => 'required',
            'source' => 'required',
            'payondelivery' => 'required',
            'addon' => 'required',
            'strengthofmaterial' => 'required',
            'remark' => 'required'
            ]);

            if($request->file('image')){

            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = public_path('img/products/');
            $image->move($path, $filename);
            $images = 'img/products/'.$filename;
}else{
            $prod_id = request('product_id');
            $getproduct = products::where('id', $prod_id)->first();
            $images = $getproduct->image;
}

        $totalavg = 'analysis';
        $productname = request('productname');

        


        $products = new vendorproduct;
        $products->user_id = request('vendor'); 
        $products->product_id = request('product_id');
        $products->name = request('productname');
        $products->image = $images;
        $products->price = request('price');
        $products->pricewithin15days = request('pricewithin15days');
        $products->pricewithin30days = request('pricewithin30days');
        $products->remark = request('remark');
        $products->payondelivery = request('payondelivery');
        $products->availability = request('availability');
        $products->category = request('productcategory');
        $products->subcategory = request('productsubcategory');
        $products->addon_id = request('addon');
        $products->model_id = request('productmodel');
        $products->source_id = request('source');
        $products->manufacturer_id = request('manufacturer');
        $products->condition_id = request('condition');
        $products->unit = request('productquantity');
        $products->strengthofmaterial = request('strengthofmaterial');
        $products->valueanalysis = $totalavg;
        $products->deliveryratestate = request('deliveryratestate');
        $products->deliveryrateoutstatewithgeo = request('deliveryrateoutstatewithgeo');
        $products->deliveryrateoutsidegeo = request('deliveryrateoutsidegeo');
        $products->color = request('color');
        $products->addon_type = request('addon_type');
        $products->save();
        


       

        session()->flash('status', 'Product added successful!');
        return back()->with('status', 'Product added successful!'); 
    }

    public function viewvendorproduct($id)
    {
        
        $vendorproduct = vendorproduct::where('id', $id)->first();
        $products = products::where('id', $vendorproduct->product_id)->first();
        $product = products::all();
        $productmodel = productmodel::all();
        $productmanufacturer = productmanufacturer::all();
        $condition = condition::all();
        $vendors = vendors::all();
        $productaddon = productaddon::all();
        $source = source::all();
        $strengthofmaterial = strengthofmaterial::all();
        $category = category::where('id', $vendorproduct->category)->first();
        $subcategory = subcategory::where('id', $vendorproduct->subcategory)->first();
        return view('admin.viewvendorproduct', compact('product', 'products', 'vendorproduct','category', 'productaddon', 'subcategory', 'productmodel', 'vendors', 'productmanufacturer', 'condition', 'source', 'strengthofmaterial'));
    }

    public function updatevendorproduct($id, Request $request)
    {
        $id = $id;

        if($request->file('image')){

            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = public_path('img/vendorproduct/');
            $image->move($path, $filename);
            $images = 'img/vendorproduct/'.$filename;
}else{

                $getvendorproduct = vendorproduct::where('id', $id)->first();
                        $getproduct = products::where('id', $getvendorproduct->product_id)->first();
                        $images = $getproduct->image;
            }

        $product = vendorproduct::where('id', $id)->update(array('user_id' => request('vendor'),
            'product_id' => request('product_id'),
            'image' => $images,
            'price' => request('price'),
            'pricewithin15days' => request('pricewithin15days'),
            'pricewithin30days' => request('pricewithin30days'),
            'remark' => request('remark'),
            'payondelivery' => request('payondelivery'),
            'availability' => request('availability'),
            'category' => request('productcategory'),
            'subcategory' => request('productsubcategory'),
            'addon_id' => request('addon'),
            'source_id' => request('source'),
            'condition_id' => request('condition'),
            'unit' => request('unit'),
            'strengthofmaterial' => request('strengthofmaterial'),
            'deliveryratestate' => request('deliveryratestate'),
            'deliveryrateoutstatewithgeo' => request('deliveryrateoutstatewithgeo'),
            'deliveryrateoutsidegeo' => request('deliveryrateoutsidegeo'),
            'color' => request('color'),
            'addon_type' => request('addon_type')
            ));

            session()->flash('status', 'Vendor Product Updated Successful!');
        return back();
    }

//this function is for the requisition page
    public function requisition()
    {
        $getorders = orders::where('payment', 'yes')->orwhere('payment','pending ')->first();
        $orders = orders::where('payment', 'yes')->orWhere('payment','pending')->orderBy('id', 'desc')->get();
        $num = 0;
        $view = '';

        $myurl =  asset('/');

        if ($getorders) {
                
                

                foreach ($orders as $key) {
                  


        $selected = '';
                    $num ++;
                    $quantity = ordersdetail::where('order_id', $key->id)->sum('quantity');
                    $prices = ordersdetail::where('order_id', $key->id)->sum('totalprice');
                    $customer = User::where('id', $key->user_id)->first();
                    $orderpayment = orderpayment::where('user_id', $key->user_id)->where('ordernumber', $key->ordernumber)->first();
                    
                    if ($orderpayment) {
                        $payment = $orderpayment->payment_type;
                    }else{
                        $payment = '';
                    }
                    if($key->admin_read==1){
                $view .= "<tr>";
            }
            else{
                $view .= "<tr style='background-color:#acacad;'>";
            }
               

                $price = number_format($prices);

          $view .= "<td>$num</td>
                    <td>$key->ordernumber</td>
                    <td><a href='$myurl/admin/viewcustomers/$key->user_id'>$customer->name</a></td>
                    <td>$quantity</td>
                    <td>".HomeController::converter($prices)."</td>
                    <td>$payment</td>
                    <td>$key->payment</td>
                    <td>$key->dateordered</td>";
                     $view .= "<td>
                         <select class='pending-product form-control' id='$key->id'>
                            <option value='5'";
                                if ($key->orderstatus == 'pending') {
                                $view .= "selected=selected";
                            }

                            $view .=">pending</option>
                            <option value='6'";
                                if ($key->orderstatus == 'ready') {
                                $view .= "selected=selected";
                            }

                            $view .=">Ready to Ship</option>
                            <option value='7'";
                                if ($key->orderstatus == 'shipped') {
                                $view .= "selected=selected";
                            }

                            $view .=">Shipped</option>
                            <option value='8'";
                                if ($key->orderstatus == 'delivery') {
                                $view .= "selected=selected";
                            }

                            $view .=">Delivered</option>

                            <option value='9'";
                                if ($key->orderstatus == 'faild') {
                                $view .= "selected=selected";
                            }

                            $view .=">Failed Delivery</option>
                            <option value='10'";
                                if ($key->orderstatus == 'return') {
                                $view .= "selected=selected";
                            }

                            $view .=">Returned</option>
                     </td>";
                     $view .= "<td>
                        <select class='deliverystatus form-control' id='$key->id'>
                            <option value='pending' ";
                            if ($key->deliverystatus == 'pending') {
                                $view .= "selected=selected";
                            }
                        $view .=">pending</option>
                            <option value='delivered' ";
                            if ($key->deliverystatus == 'delivered') {
                                $view .= "selected=selected";
                            }
                        $view .=">delivered</option>
                        </select>
                    </td>";
                 /*   $view .="<td>";
                        if ($key->failed == null) {
                             $view .= "<a href='$myurl/admin/failed/$key->id' class='btn btn-info btn-sm'>pending</a>";
                        }else{
                            $view .= "<a href='$myurl/admin/pending/$key->id' class='btn btn-danger btn-sm'>failed</a>";
                        } */
                    $view .="</td>";
                    $view .="<td><a href='$myurl/admin/ordersdetail/$key->id' class='btn btn-primary btn-sm'>View</a>";
                    if($key->payment=='pending'){

                        $view .="<a href='' class='btn btn-sm btn-info'  data-toggle='modal' data-target='#exampleModal-$key->id'>Verify Payment</a>";
                    }
                    $view.="</td>
                    <td>
                        <div class='checkbox'>
                          <input type='checkbox' value=''>
                        </div>
                    </td>
                    </tr><div class='modal fade' id='exampleModal-$key->id' tabindex='-1' role='dialog'  aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                              <div class='modal-dialog' role='document'>
                                                <div class='modal-content'>
                                                  <div class='modal-header'>
                                                    <h5 class='modal-title' id='exampleModalLabel'>Why you want to verify payment for this order?</h5>
                                                    
                                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                      <span aria-hidden='true'>&times;</span>
                                                    </button>
                                                  </div>
                                                  <div class='modal-body'>
                                                    <form action='".$myurl."/admin/update/payment/$key->id' method='get'>
                                                       
                                                      
                                                    
                                                  </div>
                                                  <div class='modal-footer'>
                                                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                                    <button type='submit' class='btn btn-primary'>Verify Payment</button>
                                                  </div>
                                                  </form>
                                                </div>
                                              </div>
                                            </div>
                    
                    ";

                }
             
            }
        return view('admin.requisition', compact('view'));

    }
   /* {   $update = orders::where('admin_read', 0)->update(array('admin_read' => 1));
    
        $getorders = orders::where('payment', 'yes')->first();
        $orders = orders::where('payment', 'yes')->orderBy('id', 'desc')->get();
        $num = 0;
        $view = '';

        $myurl =  asset('/');

        if ($getorders) {
                
                

                foreach ($orders as $key) {
                  


        $selected = '';
                    $num ++;
                    $quantity = ordersdetail::where('order_id', $key->id)->sum('quantity');
                    $price = ordersdetail::where('order_id', $key->id)->sum('totalprice');
                    $customer = User::where('id', $key->user_id)->first();
                    $orderpayment = orderpayment::where('user_id', $key->user_id)->where('ordernumber', $key->ordernumber)->first();
                    
                    if ($orderpayment) {
                        $payment = $orderpayment->payment_type;
                    }else{
                        $payment = '';
                    }

                $view .= "<tr>";

               

                $price = number_format($price);

          $view .= "<td>$num</td>
                    <td>$key->ordernumber</td>
                    <td><a href='$myurl/admin/viewcustomers/$key->user_id'>$customer->name</a></td>
                    <td>$quantity</td>
                    <td>$ $price</td>
                    <td>$payment</td>
                    <td>$key->dateordered</td>";
                     $view .= "<td>";
                        if ($key->orderstatus == 'active') {
                                $view .= "<a href='$myurl/admin/order/cancel/$key->id' class='btn btn-warning btn-sm'>Active</a>";
                            }else{
                                 $view .= "<a href='$myurl/admin/order/status/$key->id' class='btn btn-warning btn-sm'>Pending</a>";
                            }
                       
                     $view .= "</td>";
                     $view .= "<td>$key->order_cancel_reason</td>
                    <td>
                        <select class='deliverystatus form-control' id='$key->id'>
                            <option value='pending' ";
                            if ($key->deliverystatus == 'pending') {
                                $view .= "selected=selected";
                            }
                        $view .=">pending</option>
                            <option value='delivered' ";
                            if ($key->deliverystatus == 'delivered') {
                                $view .= "selected=selected";
                            }
                        $view .=">delivered</option>
                        </select>
                     </td>";
                    $view .="<td>";
                        if ($key->failed == null) {
                             $view .= "<a href='$myurl/admin/failed/$key->id' class='btn btn-info btn-sm'>pending</a>";
                        }else{
                            $view .= "<a href='$myurl/admin/pending/$key->id' class='btn btn-danger btn-sm'>failed</a>";
                        }
                    $view .="</td>";
                    $view .="<td><a href='$myurl/admin/ordersdetail/$key->id' class='btn btn-primary btn-sm'>View</a></td>
                    </tr>";

                }
             
            }
        return view('admin.requisition', compact('view'));

    }*/

    public function ordersdetail($id)
    {   $od=orders::find($id);
        $od->admin_read=1;
        $od->save();
        $num = 0;
            $view = '';
            $myurl =  asset('/');
            $commission=0.0;
            $vendor_price =0.0;

            $totalquantity = ordersdetail::where('order_id', $id)->sum('quantity');
            $totalprice = ordersdetail::where('order_id', $id)->sum('totalprice');
            $totalprice = ($totalprice);

            $ordersdetail = ordersdetail::where('order_id', $id)->get();
            $getorders = orders::where('id', $id)->first();
            $getcustomer = User::where('id',$getorders->user_id)->first();

                foreach ($ordersdetail as $key) {
                    $num ++;

                    if ($key->payoptions == 1) {
                        $payment = 'cash';
                    }elseif ($key->payoptions == 2) {
                        $payment = '15 days';
                    }elseif ($key->payoptions == 3) {
                        $payment = '30 days';
                    }

                $view .= "<tr>";

                $getproducts = vendorproduct::where('id', $key->product_id)->first();
                $vendorname = vendors::where('user_id', $getproducts->user_id)->first();
                $products = products::where('id', $getproducts->product_id)->first();
                $orderpayment=orderpayment::where('ordernumber','=',$key->ordernumber)->first();
                $shippingtype=shipping::where('vendorproduct_id','=',$getproducts->id)->first();
                if (!empty($key->workplace_id)) {
                        $workplace = $key->workplace_id;
                    }else{
                        $workplace = '';
                    }

                if(!empty($getproducts->image)){
                    $image = $getproducts->image;
                }
                else{
                    $image = $products->image;
                }

                $price = $key->totalprice;
                $com = $key->commission;
                $commission += $key->commission;
                $vendor_price = $price - $com;
                $v_price = number_format($vendor_price);

          $view .= "<td>$num</td>
                    <td>$key->ref_id</td>
                    <td class='table-shopping-cart-img'>
                        <a href='$myurl/product/$getproducts->slog'>
                            <img src='$myurl/$image' alt='Image Alternative text' style='height: 50px' title='Image Title' />
                            <br>
                            $products->name
                        </a>
                    </td>
                    <td><a href='$myurl/vendors/$vendorname->user_id'>$vendorname->vendorname</a></td>
                    <td>$key->quantity</td>
                    <td>".HomeController::converter($price)." <br>$payment</td>
                    <td>$key->dateordered</td>
                     <td>".HomeController::converter($key->commission)."</td>
                    <td>".HomeController::converter($key->total_price_without_comission)."</td>
                    <td>".HomeController::converter($key->totalprice)."</td>";
                    $view .= "<td>";
                    if ($key->payondelivery) {
                        $view .= 'COD';
                    } else if($key->payoptions !=1){
                        $orderpayment=orderpayment::where('ordernumber','=',$key->ordernumber)->where('ordersdetail_id','=',$key->id)->first();
                        if($orderpayment){
                            $view .=$orderpayment->payment_type;
                        }
                        else{
                            $view .="paylatter";
                        }
                    }else{
                        $view .=$orderpayment->payment_type;
                        }
                                            if($key->payment_get==NULL){
                            $view .="<a href='$myurl/get_payment/$key->id' class='btn btn-default'>verify Payment</a>";
                        }
                    $view .= "</td>";
                    $view .="<td>".HomeController::converter( $vendor_price)."</td>
                    <td>$shippingtype->shipping_type</td>
                    <td>
                        <select class='deliverystatus form-control' id='$key->id'>
                            <option value='pending' ";
                            if ($key->deliverystatus == 'pending') {
                                $deliverydate = '';
                                $view .= "selected=selected";
                            }
                        $view .=">pending</option>
                            <option value='delivered' ";
                            if ($key->deliverystatus == 'delivered') {
                                $deliverydate = '<h6>Delivered on '.$key->deliverydate.'</h6>';
                                $view .= "selected=selected";
                            }
                        $view .=">delivered</option>
                        </select>
                        
                    </td>";
                    if($key->paymentposted==1){
                         $view .="<td><a href='$myurl/admin/cancel/payment/$key->id' >Cancel Posted Payment</a> </td></tr>";
                    }
                    else{
                        $view .="<td><a href='$myurl/admin/posted/payment/$key->id' >Post Payment</a> </td>";
                    }
                    if($key->orderstatus=='cancel'){
                        $view .="<td>Order Cancelled</td>";
                    }
                    else{
                        $view .="<td></td>";
                    }
                    if($key->order_cancel_reason !=NULL){
                        $view .="<td>$key->order_cancel_reason</td></tr>";
                    }else{
                        $view .="<td></td></tr>";
                    }

                    

                }

        return view('admin.ordersdetail', compact('view', 'totalquantity', 'totalprice', 'getorders', 'getcustomer','commission'));
    }

    public function customers()
    {
        $getcustomer = User::where('user_type', 'Customer')->orderBy('id','DESC')->get();
        $view = '';
        $num = 0;
        $myurl =  asset('/');
        foreach ($getcustomer as $key) {
             $customer=Customer::where('user_id','=',$key->id)->first();
             if($customer){
                $user=User::find($customer->user_id);
            $num ++;
            $getorders = orders::where('user_id', $key->id)->where('payment', 'yes')->count();

            $view .= "<tr>
                        <td>$num</td>
                        <td><a href='$myurl/admin/viewcustomers/$key->id' class='customer_link'>$key->name</a></td>
                        <td>$key->email</td>
                        <td>$customer->state</td>
                        <td>$customer->city</td>
                        <td>$getorders</td>";
                        if($key->verify==1){
                                $view .=" <td>Verified</td>";
                        }
                        else{
                                $view .=" <td>Unverified</td>";
                        }
                        $view .="<td>$user->user_uniqueid</td><td><a href='$myurl/admin/viewcustomers/$key->id' class='btn btn-primary btn-xs'>view</a>
                        <a href='$myurl/admin/editcustomer/$key->id' class='btn btn-info btn-xs'>Edit</a>
                        <a href='$myurl/admin/deletecustomer/$key->id' class='btn btn-danger btn-xs delete'>Delete</a></td>
                    </tr>";
                }
        }
        return view('admin.customers', compact('view'));
    }
    public function getpayment($id){
        $ordersdetail=ordersdetail::find($id);
        $ordersdetail->payment_get='yes';
        $ordersdetail->save();
        return back();
    }

    public function viewcustomerswallet($id)
    {
        $customer = User::where('id', $id)->first();
        $viewhistory = wallethistory::where('user_id', $customer->id)->orderBy('id', 'desc')->get();
        $view = "";
        $no = 0;
        if ($viewhistory) {
            foreach ($viewhistory as $key) {
                # code...
                $no ++;

                if ($key->transactiontype == 1) {
                    $transactiontype = "Deposit";
                }elseif($key->transactiontype == 2){
                    $transactiontype = "Purchase";
                }else{
                    $transactiontype="Pending payment";
                }

                $view .= "<tr>
                            <td>$no</td>
                            <td>$transactiontype</td>
                            <td>$key->transactionid</td>
                            <td>".HomeController::converter($key->payment)."</td>
                            <td>".HomeController::converter($key->balance)."</td>
                            <td>$key->date</td>
                        </tr>";
            }
        }

        return view('admin.customer.accounthistory', compact('viewhistory', 'view'));
    }

    public function viewcustomers($id)
    {
        $getcustomer = User::where('id', $id)->first();
        $getcustomer->newuser=1;
        $getcustomer->save();
        $orders = orders::where('payment', 'yes')->where('user_id', $id)->orderBy('id', 'desc')->get();
        $view = '';
        $num = 0;
        $myurl =  asset('/');

        foreach ($orders as $key) {
                    $num ++;
              
                    $quantity = ordersdetail::where('order_id', $key->id)->sum('quantity');
                    $price = ordersdetail::where('order_id', $key->id)->sum('totalprice');
                    
                    

                $view .= "<tr>";

               

                $price = ($price);

          $view .= "<td>$num</td>
                    <td>$key->ordernumber</td>
                    <td>$quantity</td>
                    <td>".HomeController::converter($price)."</td>
                    <td>Paid</td>
                    <td>$key->dateordered</td>
                    <td>
                    <select class='deliverystatus form-control' id='$key->id'>
                            <option value='pending' ";
                            if ($key->deliverystatus == 'pending') {
                                $view .= "selected=selected";
                            }
                        $view .=">pending</option>
                            <option value='delivered' ";
                            if ($key->deliverystatus == 'delivered') {
                                $view .= "selected=selected";
                            }
                        $view .=">delivered</option>
                        </select>
                    </td>
                    <td><a href='$myurl/admin/ordersdetail/$key->id' class='btn btn-primary btn-sm'>View</a></td>
                    </tr>";

                }

    return view('admin.viewcustomers', compact('view', 'getcustomer'));

    }

    public function deliverystatus()
    {
        $value = $_GET['value'];
        $orderid = $_GET['orderid'];
        $update = orders::where('id', $orderid)->update(array('deliverystatus' => $value));
        $orderdetails=ordersdetail::where('order_id','=',$orderid)->get();
 
        foreach ($orderdetails as $ordr) {
           $ordr->deliverystatus=$value;
           $ordr->deliverydate=Carbon::now()->toDateString();
           $ordr->save();
        }
    }

    public function orderdeliverystatus()
    {
        $value = $_GET['value'];
        $orderid = $_GET['orderid'];
        $date = '';
        $delivery=1;
        if ($value == 'delivered') {
            $delivery='delivered';
           $date = date('Y/m/d');
        }else{
             $delivery='pending';
        }
        $update = ordersdetail::find($orderid);
        $update->deliverystatus = $delivery;
         $update->deliverydate = $date;
         $update->save();
        
    }

    public function outstanding()
    {

            $num = 0;
            $view = '';
            $validwallet = '';
            $myurl =  asset('/');
           

                $getoutstandingpayment = outstandingpayment::orderBy('id','DESC')->get();

                foreach ($getoutstandingpayment as $keys) {

                    $user = User::where('id', $keys->user_id)->first();

                    $num += 1;

                    $key = ordersdetail::where('ordernumber', $keys->ordernumber)->first();

                    $outstandingpayment = outstandingpayment::where('id', $keys->id)->first();
                    $duetotal = $outstandingpayment->totalprice;
                    $orders=orders::where('ordernumber','=',$keys->ordernumber)->first();

                $payoptions = '';
                if ($key->payoptions != '1') {
                        if ($key->payoptions == '2') {
                            $payoptions = '<br>15 days Payment';
                        }elseif ($key->payoptions == '3') {
                            $payoptions = '<br>30 days Payment';
                        }
                    }

                $view .= "
                            <tr style='font-size: 14px'>";              
                   $getproducts = vendorproduct::where('id', $key->product_id)->first();
                   $vendorname = vendors::where('user_id', $getproducts->user_id)->first();
                $products = products::where('id', $getproducts->product_id)->first();
                   if(!empty($getproducts->image)){
                    $image = $getproducts->image;
                    }
                    else{
                        $image = $products->image;
                    }

//                    if (!empty($key->workplace_id)) {
//                        $workplace = workplace::where('user_id', Auth::user()->id)->where('id', $key->workplace_id)->first();
//                        $workplacename = $workplace->name;
//                    }else{
//                        $workplacename = '';
//                    }

                    $price = number_format($key->totalprice);
                $description = str_limit($getproducts->remark, 120);
                $unitprice = number_format($key->price);

                if ($key->deliverystatus != 'delivered') {
                    $delivery = "<button class='btn btn-xs btn-danger'>Pending</button>";
                }else{
                    $delivery = "<h5 class='bg-success' style='padding: 5px; text-align: center'>Delivered on ".$key->deliverydate."</h5>";
                }

                    $view .= "<td>$num</td>
                            <td>$key->ref_id</td>
                            <td><a href='$myurl/admin/ordersdetail/$orders->id'>$key->ordernumber</a></td>
                            <td><a href='$myurl/admin/viewcustomers/$user->id'>$user->name</a></td>

                            <td class='table-shopping-cart-img'>

                                <a href='$myurl/product/$getproducts->slog' style='color: #000'>
                                <div class='col-md-2'>
                                <img src='$myurl/$image' alt='Image Alternative text' title='Image Title' style='width: 40px' />
                                </div>
                                <div class='col-md-10'>
                                    <p style='font-size: 14px'><strong>$products->name</strong><br>
                                    $description</p>
                                    <p>".HomeController::converter($key->price)." X $key->quantity = ".HomeController::converter($key->totalprice)." $payoptions</p> 
                                    <p style='color: #8D8A97 !important'>Product Properties: Color $key->color</p>
                                </div>
                                </a>
                            </td>
                            <td>".HomeController::converter($key->totalprice)."</td>
                            <td>$keys->dateordered</td>
                            <td>$keys->duedate</td>
                            <td>$keys->payment</td>";
                       
                            if(date("Y/m/d")<$keys->duedate )
                            {
                                $view .="<td class='btn btm-danger'>outstanding payment</td>";
                            }
                            else {
                                $view .="<td class='btn btm-success'>Due payment</td>";
                            }
                            
                            

                $view .= "</tr>";

                }

        return view('admin.outstanding', compact('view'));
    }




public function users()
{

   $user = User::where('user_type','Admin')->get();

   return view('admin.users.index', compact('user')); 
}
public function createUser(){
    return view('admin.users.create');
}
public function saveUser(Request $request){
    $this->validate($request,[
        'name'=>'required',
        'email'=>'required|email|unique:users',
        'phone'=>'required|numeric',
        'password'=>'required',
    ]);
    $user=new User;
    $user->name=$request->name;
    $user->email=$request->email;
    $user->phone=$request->phone;
    $user->password=Hash::make($request->password);
    $user->user_type='Admin';
    $user->status=1;
    $user->approve='approve';
    $user->save();
    $userrole=DB::table('user_role')->insert(
    ['user_id' => $user->id, 'role_id' => 1]
);
    return redirect('admin/users')->with('message','User is created successfully!');
}
public function editUser($id){
    $user=User::find($id);
    return view('admin.users.edit',compact('user'));
}
public function updateUser(Request $request,$id){
    $user=User::find($id);
    $user->name=$request->name;
    $user->email=$request->email;
    $user->phone=$request->phone;
    if($request->password){
        $user->password=Hash::make($request->password);
    }
    $user->save();
    return redirect('admin/users')->with('message','User Updated successfully');
}

public function social_link_view()
{
      $user = \Auth::User();
      $userid = $user->id;
      $social_link = SocialLinks::where('user_id',$userid)->first();
      return view('admin.social.create', compact('social_link')); 

}

public function social_link_post(Request $request)
{

    $user = \Auth::User();
    $userid = $user->id;
    $social = SocialLinks::where('user_id',$userid)->first();
    if($social)
    {
       $social_link = SocialLinks::find($social->id);
       $social_link->user_id = $userid;
       $social_link->facebook = $request->facebook;
       $social_link->twitter = $request->twitter;
       $social_link->pinterest = $request->pinterest;
       $social_link->instagram = $request->instagram;
       $social_link->google = $request->google;
       $social_link->save();

   }else{

           $social_link = new SocialLinks;
           $social_link->user_id = $userid;
           $social_link->facebook = $request->facebook;
           $social_link->twitter = $request->twitter;
           $social_link->pinterest = $request->pinterest;
           $social_link->instagram = $request->instagram;
           $social_link->google = $request->google;
           $social_link->save();
   }
    
   session()->flash('status', 'Social Links Saved Successful!');
   return back();

}


public function veiw_customer_q_a(Request $request)
{
    $q_a = DB::table('customer_q_a')
            ->select('customer_q_a.*','vendorproduct.*','customer_q_a.id as id')
           ->leftjoin('vendorproduct','vendorproduct.id','=','customer_q_a.product_id')
        ->orderBy('customer_q_a.answer_status')
            ->get();
    $q_a = $q_a->sortBy('answer_status');
    return view('admin.customer_q_a.index', compact('q_a'));

}


public function save_q_a_answer(Request $request,$id)
{

    $q_a = Customer_QA::find($id);
    $q_a->answer = $request->answer;
    $q_a->answer_date = date('Y/m/d');
    
    $q_a->answer_status = 'yes';
    $q_a->save();

    $customer_q_a = Customer_QA::where('answer_status','no')->count();
    Session::put('customer_q_a',$customer_q_a);

     session()->flash('status', 'Answer Send Successfully!');
     return back();
    
}
public function currency(){
    $PreviousRates=currency::find(1);
    return view('admin.currency',compact('PreviousRates'));
}
public function updatecurrency(Request $request){
    $this->validate($request,[
        'dollar'=>'required|numeric|not_in:0',
        'yen'=>'required|numeric|not_in:0',
        'euro'=>'required|numeric|not_in:0'
    ]);
$currency=currency::find(1);
$currency->Dollar=$request->dollar;
$currency->Yen=$request->yen;
$currency->Euro=$request->euro;
$currency->save();
return redirect()->back()->with('message','Rates Updated Successfully');
}
public function status($id)
    {
        $order = Orders::find($id);
        $order->orderstatus = 'active';
        $order->save();
        $customer = User::where('id',$order->user_id)->first();
        $vendor = User::where('id',$order->vendor_id)->first();
        $vendor->notify(new Ordercancel($vendor));
        $customer->notify(new Ordercancel($customer));
        return back()->with('status','Your Order successfully Actived');
    }

    public function cancel($id)
    {
        $order = Orders::find($id);
        $order->orderstatus = 'cancel';
        $order->save();
         $customer = User::where('id',$order->user_id)->first();
        $vendor = User::where('id',$order->vendor_id)->first();
        $vendor->notify(new Orderactive($vendor));
        $customer->notify(new Orderactive($customer));
        return back()->with('status','Your Order successfully Cancel');
    }
    public function editapprove(){

        return view('admin.editapprove');
    }
    public function approvevendor($id){
        $edited=profilehistory::where('vendor_id','=',$id)->first();
        $vendor=vendors::find($id);
        if($vendor){
            $vendor->vendorname=$edited->name;
            $vendor->address=$edited->address;
            $vendor->country=$edited->country;
            $vendor->cac=$edited->cac;
            $vendor->workforce=$edited->workforce;
            $vendor->yearsofexp=$edited->yearsofexp;
            $vendor->ratings=$edited->ratings;
            $vendor->producttype=$edited->producttype;
            $vendor->location=$edited->location;
            $vendor->vendor_type=$edited->vendor_type;
            $vendor->url=$edited->url;
            $vendor->save();
            $edited->edits=1;
            $edited->save();
        }
        return back()->with('status','Vendor approved!');
    }
     public function login_details()
    {
        $customers =  User::where('user_type','Customer')->latest()->get();
        return view('admin.activities',compact('customers'));
    }
    public function customer_details($id)
    {
        $user = User::where('id',$id)->first();
        $favourite_vendor = favoritevendor::where('customer_id',$id)->where('favorite','=',1)->get();
        
        $products = Orders::where('user_id',$id)->get();

        return view('admin.customerdetails',compact('favourite_vendor','products','user'));
    }
     public function topearn()
    {

       $vendors = User::where('user_type','Vendor')->latest()->get();
       $customers = User::where('user_type','Customer')->latest()->get();
       $vendorproduct = DB::table('ordersdetail')
         ->select('ordersdetail.product_id','ordersdetail.order_id', 'ordersdetail.totalprice', DB::raw('sum(ordersdetail.totalprice) AS total'))
         ->groupBy('ordersdetail.product_id')->orderBy('total', 'DESC')
         ->get();
        $view = '';
        $i = 0;
        $myurl =  asset('/');
        foreach($vendorproduct as $key){
        $i++;
        $getproduct = products::where('id', $key->product_id)->first();
        $order=orders::find($key->order_id);
        $vendor = vendors::where('user_id', $order->vendor_id)->first();

         if (empty($key->image)) {
            $img="/$getproduct->image";
        }else{
            $img="/$key->image";
        }

        $view   .=  "<tr>
                    <td class='text-center'>$i</td>
                    <td class='w100'><img class='img-responsive mw40 ib mr10 product_image' title='user'
                                             src='$myurl/$img'></td>
                    </td>
                    <td>$getproduct->name</td>
                    <td>$vendor->vendorname</td>
                    <td>".HomeController::converter($key->total)."</td>";
        }

        return view('admin.totalearn',compact('vendors','customers','view'));
    }
     public function search_term()
   {
      $terms = term::orderBy('count','DESC')->get();
      return view('admin.search',compact('terms'));
   }
    public function order_pending(Request $request)
   {
        if ($request->value == 5) {
         $order = Orders::where('id',$request->orderid)->first();
          $order->orderstatus = "pending";
          $order->save();
        }
           if ($request->value == 6) {
            $order = Orders::where('id',$request->orderid)->first();
            $order->orderstatus = "ready";
            $order->save();
        }
           if ($request->value == 7) {
            $order = Orders::where('id',$request->orderid)->first();
            $order->orderstatus = "shipped";
            $order->save();
           
        }
           if ($request->value == 8) {
            $order = Orders::where('id',$request->orderid)->first();
            $order->orderstatus = "delivery";
            $order->save();
        }
           if ($request->value == 9) {
            $order = Orders::where('id',$request->orderid)->first();
            $order->orderstatus = "failed";
            $order->save();
        }
        if ($request->value == 10) {
            $order = Orders::where('id',$request->orderid)->first();
            $order->orderstatus = "return";
            $order->save();
        }
   }
   public function cancelled(){
    $orders=orders::where('orderstatus','=','cancel')->get();
    return view('admin.cancelledorders',compact('orders'));
   }
   public function ProductsList(){

        $vendorproduct = vendorproduct::where('product_status','1')->where('edit_product_staus','yes')->where('delete_product','=',0)->get();
        $view = '';
        $i = 0;
        $myurl =  asset('/');
        foreach($vendorproduct as $key){
        $i++;
        $getproduct = products::where('id', $key->product_id)->first();
        $vendor = vendors::where('user_id', $key->user_id)->first();
        $subcategory=subcategory::where('id','=',$key->subcategory)->first();
        $category=category::where('id','=',$key->category)->first();
        if(!empty($key->commision))
        {
            $commission = $key->commision;
        }elseif(!empty($subcategory->sub_commission)){

            $commission = $subcategory->sub_commission;
        }elseif(!empty($category->sub_commission)){

            $commission = $category->catagory_comission;
        }
        else{
            $commission=0;
        }
         if (empty($key->image)) {
            $img="/$getproduct->image";
        }else{
            $img="/$key->image";
        }

        $view   .=  "<tr>
                    <td class='text-center'>$i</td>
                    <td class='w100'><img class='img-responsive mw40 ib mr10 product_image' title='user'
                                             src='$myurl/$img'></td>
                    </td>
                    <td><a href='$myurl/admin/ProductDetail/$key->id'>$getproduct->name</a></td>
                    <td>$vendor->vendorname</td>
                    <td>$key->part_number</td>
                    <td>".HomeController::converter($key->price)."</td>
                    <td>$key->stock_count</td>
                    <td>$commission %</td>
                    <td>$category->name</td>
                    <td>$subcategory->name</td>";
        }
        return view('admin/productlist', compact('vendorproduct', 'view'));
   }
   public function order_subcategory(Request $request)
   {
       $category =  Subcategory::find($request);
      $products = Products::where('model',$request->value)->get();
      foreach ($products as $key => $product) {
        $orders = ordersdetail::where('product_id',$product->id)->get();
      }
      $orders = orders::where('payment', 'yes')->get();
        
        $num = 0;
        $view = '';
        $myurl =  asset('/');
        
                
                
                foreach ($orders as $key) {
                  
        $selected = '';
                    $num ++;
                    $quantity = ordersdetail::where('order_id', $key->id)->sum('quantity');
                    $price = ordersdetail::where('order_id', $key->id)->sum('totalprice');
                    $customer = User::where('id', $key->user_id)->first();
                    $orderpayment = orderpayment::where('user_id', $key->user_id)->where('ordernumber', $key->ordernumber)->first();
                    
                    if ($orderpayment) {
                        $payment = $orderpayment->payment_type;
                    }else{
                        $payment = '';
                    }
                $view .= "<tr>";
               
                $price = number_format($price);
          $view .= "<td>$num</td>
                    <td>$key->ordernumber</td>
                    <td><a href='$myurl/admin/viewcustomers/$key->user_id'>$customer->name</a></td>
                    <td>$quantity</td>
                    <td>".HomeController::converter($price)."</td>
                    <td>$payment</td>
                    <td>$key->dateordered</td>";
                     $view .= "<td>";
                        if ($key->orderstatus == 'active') {
                                $view .= "<a href='$myurl/admin/order/cancel/$key->id' class='btn btn-success btn-sm'>Active</a>";
                            }else{
                                 $view .= "<a href='$myurl/admin/order/status/$key->id' class='btn btn-warning btn-sm'>Pending</a>";
                            }
                       
                     $view .= "</td>";
                     $view .= "<td>$key->order_cancel_reason</td>
                    <td>
                        <select class='deliverystatus form-control' id='$key->id'>
                            <option value='pending' ";
                            if ($key->deliverystatus == 'pending') {
                                $view .= "selected=selected";
                            }
                        $view .=">pending</option>
                            <option value='delivered' ";
                            if ($key->deliverystatus == 'delivered') {
                                $view .= "selected=selected";
                            }
                        $view .=">delivered</option>
                        </select>
                    </td>";
                    $view .="<td>";
                        if ($key->failed == null) {
                             $view .= "<a href='$myurl/admin/failed/$key->id' class='btn btn-info btn-sm'>pending</a>";
                        }else{
                            $view .= "<a href='$myurl/admin/pending/$key->id' class='btn btn-danger btn-sm'>failed</a>";
                        }
                    $view .="</td>";
                    $view .="<td><a href='$myurl/admin/ordersdetail/$key->id' class='btn btn-primary btn-sm'>View</a></td>
                    <td>
                        <div class='checkbox'>
                          <input type='checkbox' value=''>
                        </div>
                    </td>
                    </tr>
                    
                    ";
                }
             
            
            return $view;
   }
   public function sortby(Request $request){
    if($request->ajax()){
        $value=$request->get('id');
        Session::put('sortby',$value);
        return json_encode('set');
    }
   }
    public function sortvendor(Request $request){
    if($request->ajax()){
        $value=$request->get('id');
        Session::put('sortvendors',$value);
        return json_encode('set');
    }
   }
   public function paginations(Request $request){
     if($request->ajax()){
        $value=$request->get('id');
        Session::put('pagination',$value);
        return json_encode('set');
    }
   }
   public function verifypayment($id){
    $order=orders::find($id);
    $order->payment='yes';
    $order->save();
    $user=User::find($order->user_id);
    $orderdetails=ordersdetail::where('order_id','=',$order->id)->get();
    foreach ($orderdetails as $orders) {
        if ($orders->payoptions === 1 && $orders->payondelivery === null) {
            $orders->ispaid=1;
            $orders->payment_get='yes';
            $orders->save();
        }
    }
    Mail::to($user->email)->send(new customerNotify($order->ordernumber));
    return redirect()->back();
   }
   public function tags(){
    return view('admin.tags.index');
   }
   public function create_tag(){
    return view('admin.tags.create');
   }
   public function save_tag(Request $request){
    $this->validate(request(), [

            'name' => 'required',
            

            ]);
    $tag=new populartags;
    $tag->tag=$request->name;
    $tag->save();
    return redirect('/admin/tags')->with('message','Tag created successfully');
   }
   public function delete_tag($id){
    $tag=populartags::find($id);
    $tag->delete();
    return back();
   }
   public function edit_tag($id){
    $tag=populartags::find($id);
    return view('admin.tags.edit',compact('tag'));
   }
   public function update_tag(Request $request,$id){
    $this->validate(request(), [

            'name' => 'required',
            

            ]);
    $tag=populartags::find($id);
    $tag->tag=$request->name;
    $tag->save();
    return redirect('admin/tags')->with('message','Tag edited successfully');
   }
   public function order_category(Request $request)
   {
       $category =  Category::find($request->value);
      $products = Products::where('category',$request->value)->get();
      $num = 0;
        $view = '';
        $myurl =  asset('/');
      foreach ($products as $key => $product) {
        //$orders = ordersdetail::where('product_id',$product->id)->get();
        $orders=DB::SELECT('SELECT * from orders,ordersdetail WHERE ordersdetail.ordernumber=orders.ordernumber AND  ordersdetail.product_id='.$product->id.'');
        
      
      //$orders = orders::where('payment', 'yes')->get();
        
        
        
                
                
                foreach ($orders as $key) {
                  
        $selected = '';
                    $num ++;
                    $quantity = ordersdetail::where('order_id', $key->id)->sum('quantity');
                    $price = ordersdetail::where('order_id', $key->id)->sum('totalprice');
                    $customer = User::where('id', $key->user_id)->first();
                    $orderpayment = orderpayment::where('user_id', $key->user_id)->where('ordernumber', $key->ordernumber)->first();
                    
                    if ($orderpayment) {
                        $payment = $orderpayment->payment_type;
                    }else{
                        $payment = '';
                    }
                $view .= "<tr>";
               
                $price = ($price);
          $view .= "<td>$num</td>
                    <td>$key->ordernumber</td>
                    <td><a href='$myurl/admin/viewcustomers/$key->user_id'>$customer->name</a></td>
                    <td>$quantity</td>
                    <td>".HomeController::converter($price)."</td>
                    <td>$payment</td>
                    <td>$key->dateordered</td>";
                     $view .= "<td>";
                        if ($key->orderstatus == 'active') {
                                $view .= "<a href='$myurl/admin/order/cancel/$key->id' class='btn btn-success btn-sm'>Active</a>";
                            }else{
                                 $view .= "<a href='$myurl/admin/order/status/$key->id' class='btn btn-warning btn-sm'>Pending</a>";
                            }
                       
                     $view .= "</td>";
                     $view .= "<td>$key->order_cancel_reason</td>
                    <td>
                        <select class='deliverystatus form-control' id='$key->id'>
                            <option value='pending' ";
                            if ($key->deliverystatus == 'pending') {
                                $view .= "selected=selected";
                            }
                        $view .=">pending</option>
                            <option value='delivered' ";
                            if ($key->deliverystatus == 'delivered') {
                                $view .= "selected=selected";
                            }
                        $view .=">delivered</option>
                        </select>
                    </td>";
                    $view .="<td>";
                        if ($key->orderstatus == null || $key->orderstatus=='pending') {
                             $view .= "<a href='$myurl/admin/failed/$key->id' class='btn btn-info btn-sm'>pending</a>";
                        }else{
                            $view .= "<a href='$myurl/admin/pending/$key->id' class='btn btn-danger btn-sm'>failed</a>";
                        }
                    $view .="</td>";
                    $view .="<td><a href='$myurl/admin/ordersdetail/$key->id' class='btn btn-primary btn-sm'>View</a></td>
                    <td>
                        <div class='checkbox'>
                          <input type='checkbox' value=''>
                        </div>
                    </td>
                    </tr>
                    
                    ";
                }
             }
            
            return $view;
   }
   public function adminRFQ(){
    $rfq=rfq::all();
    return view('admin.rfq',compact('rfq'));
   }
   public function postPayment($id){
    $ordersdetail=ordersdetail::find($id);
    $ordersdetail->paymentposted=1;
    $ordersdetail->save();
    return back();
   }
    public function cancelpostPayment($id){
    $ordersdetail=ordersdetail::find($id);
    $ordersdetail->paymentposted=0;
    $ordersdetail->save();
    return back();
   }
   public function newsletters(){
    $newsletters=newslatter::all();
    return view('admin.newsletter',compact('newsletters'));
   }
}










