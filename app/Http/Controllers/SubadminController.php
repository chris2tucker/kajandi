<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\category;
use App\subcategory;
use App\vendors;
use App\User;
use App\productmodel;
use App\products;
use App\condition;
use App\productmanufacturer;
use App\productaddon;
use App\source;
use App\strengthofmaterial;
use App\productimages;
use Illuminate\Support\Facades\Hash;

class SubadminController extends Controller
{
    public function index()
    {
    	return view('subadmin.index');
    }

    public function products()
    {
        $products = products::all();
        return view('subadmin.products', compact('products'));
    }

    public function viewproduct($id)
    {
        $id = $id;
        $category = category::all();
        $subcategory = subcategory::all();
        $productmodel = productmodel::all();
        $productmanufacturer = productmanufacturer::all();
        $condition = condition::all();
        $vendors = vendors::all();
        $productaddon = productaddon::all();
        $source = source::all();
        $strengthofmaterial = strengthofmaterial::all();
        $product = products::find($id);
        return view('subadmin.viewproduct', compact('product', 'category', 'productaddon', 'subcategory', 'productmodel', 'vendors', 'productmanufacturer', 'condition', 'source', 'strengthofmaterial'));
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
        return view('subadmin.addproduct', compact('category', 'productaddon', 'subcategory', 'productmodel', 'vendors', 'productmanufacturer', 'condition', 'source', 'strengthofmaterial'));
    }

    public function updateviewproduct($id)
    {
        $id = $id;

        $source = source::where('id', request('source'))->first();

        $strengthofmaterial = strengthofmaterial::where('id', request('strengthmaterial'))->first();

        $productaddon = productaddon::where('id', request('addons'))->first();

        $condition = condition::where('id', request('condition'))->first();

        $total = $source->value + $strengthofmaterial->value + $productaddon->value + $condition->value;

        $price = request('price');

        $totalavg = $price + $total;

        $product = products::where('id', $id)->update(array('name' => request('name'),
            'user_id' => request('vendor'),
            'partnumber' => request('partnumber'),
            'description' => request('description'),
            'category' => request('category'),
            'subcategory' => request('subcategory'),
            'unit' => request('unit'),
            'model' => request('model'),
            'manufacturer' => request('manufacturer'),
            'condition' => request('condition'),
            'price' => request('price'),
            'remark' => request('remark'),
            'source' => request('source'),
            'strengthmaterial' => request('strengthmaterial'),
            'addons' => request('addons'),
            'payondelivery' => request('payondelivery'),
            'availability' => request('availability'),
            'valueanalysis' => $totalavg
            ));

            session()->flash('status', 'Product Updated Successful!');
        return back();
    }

    public function createproduct(Request $request)
    {
        $this->validate(request(), [

            'productname' => 'required',
            'productdescription' => 'required',
            'productcategory' => 'required',
            'productsubscategory' => 'required',
            'availability' => 'required',
            'productquantity' => 'required',
            'price' => 'required',
            'vendor' => 'required',
            'condition' => 'required',
            'source' => 'required',
            'payondelivery' => 'required',
            'addon' => 'required',
            'strengthofmaterial' => 'required',
            'remark' => 'required',
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

	$source = source::where('id', request('source'))->first();

        $strengthofmaterial = strengthofmaterial::where('id', request('strengthofmaterial'))->first();

        $productaddon = productaddon::where('id', request('addon'))->first();

        $condition = condition::where('id', request('condition'))->first();

        $total = $source->value + $strengthofmaterial->value + $productaddon->value + $condition->value;

        $price = request('price');

        $totalavg = $price + $total;
            

        $products = new products;
        $products->name = request('productname');
        $products->user_id = request('vendor');   
        $products->image = $images;    
        $products->partnumber = request('partnumber');
        $products->description = request('productdescription');
        $products->category = request('productcategory');
        $products->subcategory = request('productsubscategory');
        $products->unit = request('productquantity');
        $products->model = request('productmodel');
        $products->manufacturer = request('manufacturer');
        $products->condition = request('condition');
        $products->price = request('price');
        $products->remark = request('remark');
        $products->source = request('source');
        $products->strengthmaterial = request('strengthofmaterial');
        $products->addons = request('addon');
        $products->payondelivery = request('payondelivery');
        $products->availability = request('availability');
        $products->valueanalysis = $totalavg;
        $products->save();
        $product_id = $products->id;

       

        session()->flash('status', 'Product added successful!');
        return back()->with('status', 'Product added successful!'); 

    }

    public function vendors()
    {
    	$vendors = vendors::all();
    	return view('subadmin.vendors', compact('vendors'));
    	# code...
    }

    public function viewvendors($id)
    {
        $vendors = vendors::where('user_id',$id)->first();
        return view('subadmin/viewvendors', compact('vendors'));
    }

    public function editvendor($id)
    {
        
        $this->validate(request(), [

            'vendorname' => 'required',
            'vendor_type' => 'required',
            'producttype' => 'required',
            'location' => 'required',
            'address' => 'required',
            'country' => 'required',
            'location' => 'required',
            'ratings' => 'required',
            'contactname' => 'required',
            'contactphone' => 'required',
            'email' => 'required'
            ]); 


        $email = trim(request('email'));



        $getmail = User::where('id', $id)->first();
        if ($getmail->email == $email) {
         
         $user = User::where('id', $id)->update(array('email' => request('email'),
                'user_type' => request('vendor_type')
            ));

        }else{
            $this->validate(request(), [

            'email' => 'required|unique:users'

            ]); 

            $user = User::where('id', $id)->update(array('email' => request('email'),
                'user_type' => request('vendor_type')
            ));            
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
            'vendor_type'    => request('vendor_type')
            ));

            session()->flash('status', 'Vendor Profile Updated!');
        return back()->with('status', 'Vendor Profile Updated!');

    }

}