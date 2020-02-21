<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon;
use Hash;
use Session;
use App\category;
use Illuminate\Support\Facades\Redirect;
use Crypt;
use View;
use App\TodayFeatured;
use Response;
use App\productimages;
use App\PaymentDeliveryInformation;
use App\vendorproduct;
use App\products;
use App\productmanufacturer;
use App\productmodel;
use App\subcategory;
use App\condition;
use App\EditProducts;
use App\shipping;
use App\shippingInformations;
use App\state;
use App\city;
use App\country;
use App\mannual_shipping;
use App\vendors;
use App\Customer;
class ProductController extends Controller
{
    
    public function index()
    {



        $catagory = category::pluck('id','name');


        return View::make('admin.product.create',compact('catagory'));
    }


    public function create()
    {

        $vendor = DB::table('vendors')->pluck('vendorname','user_id');
        //dd($vendor);
        $catagory = category::pluck('id','name');

        $manufacture = productmanufacturer::pluck('name','id');
        $model = productmodel::pluck('name','id');
        $condition = condition::pluck('name','id');
        $vendor_products = vendorproduct::where('product_status','1')->pluck('name','id');




        return View::make('admin.product.create' , compact('vendor','catagory','manufacture','model','vendor_products','condition'));
    }


    public function store(Request $request)
    {

        $this->validate($request, [
            'name'=> 'required|max:100',
            'product_generic_name'=> 'required',
            'vendor'=> 'required',
            'category'=> 'required',
            'subcategory'=> 'required',
            'instant_price'=> 'required',
            'image_1'=> 'required|max:2000',
            'image_2'=>'max:2000',
            'image_3'=>'max:2000',
            'image_4'=>'max:2000',
             'deliveryratestate'=>'required',
            'deliveryrateoutstatewithgeo'=>'required',
            'deliveryrateoutsidegeo'=>'required',
           
            
         ]);
      


        $product = new products();
        $product->name = $request->name;
        $product->category=$request->category;
        $product->subcategory=$request->subcategory;
        $product->manufacturer=$request->manufacturer;
        $product->model=$request->model;
        $product->additional_specification=$request->specification;
       if($request->file('image_1')){

            $image = $request->file('image_1');
            $filename = time().'-'.$image->getClientOriginalName(). '.' . $image->getClientOriginalExtension();
            $path = base_path('img/products');
            $image->move($path, $filename);
            $images = 'img/products/'.$filename;
            }else{
             $images = '';
            }
             $product->image  = $images;
            $product->save();
        $ccessories_array = $request->accessories;
        if($ccessories_array)
        {
           $accessories  = implode(",",$ccessories_array); 
        }else{

            $accessories='';
        }
        

        $vendor_product = new vendorproduct();
        $vendor_product->name=$request->name;
        $vendor_product->product_id=$product->id;
        $vendor_product->user_id=$request->vendor;
        $vendor_product->condition_id=$request->condition;
        $vendor_product->product_generic_name=$request->product_generic_name;
        $vendor_product->description=$request->description;
        $vendor_product->product_keyword=$request->product_keyword;
        $vendor_product->part_number=$request->part_number;
        $vendor_product->category=$request->category;
        $vendor_product->subcategory=$request->subcategory;
        $vendor_product->manufacturer_id=$request->manufacturer;
        $vendor_product->model_id=$request->model;
        $vendor_product->stock_count=$request->stock_count;
        $vendor_product->unit=$request->unit_of_measure;
        $vendor_product->accessories=$accessories;
        $vendor_product->other_information=$request->other_information;
        $vendor_product->key_specification=$request->key_specification;
        $vendor_product->key_specification=$request->key_specification;
        $vendor_product->supplyType=$request->supplyType;
        $vendor_product->color=$request->color;
        $vendor_product->price=$request->instant_price;
        $vendor_product->pricewithin15days=$request->pricewithin15days;
        $vendor_product->pricewithin30days=$request->pricewithin30days;
        $vendor_product->instant_price= $request->instant_price;
        $vendor_product->deliveryratestate= $request->deliveryratestate;
        $vendor_product->deliveryrateoutstatewithgeo= $request->deliveryrateoutstatewithgeo;
        $vendor_product->deliveryrateoutsidegeo= $request->deliveryrateoutsidegeo;
         $vendor_product->model_number=$request->model_number;
        $vendor_product->serial_number=$request->serial_number;
        $vendor_product->availability= "yes";
        $vendor_product->product_status=1;
        
        $vendor_product->save();
        $product_id = $vendor_product->id;

        $slog = str_replace([" ","/"], "_", $vendor_product->name);
        $slog_name = $slog.'_'.$product_id;

        $updatevendor = vendorproduct::where('id', $product_id)->update(array('slog' => $slog_name));

        $payment_delivery_info =  new PaymentDeliveryInformation();
        $payment_delivery_info->product_id= $vendor_product->id;
        $payment_delivery_info->dimension_per_unit_length= $request->dimension_per_unit_length;
        $payment_delivery_info->dimension_per_unit_width= $request->dimension_per_unit_width;
        $payment_delivery_info->dimension_per_unit_weight= $request->dimension_per_unit_weight;
        $payment_delivery_info->dimension_per_unit_volume= $request->dimension_per_unit_volume;
        $payment_delivery_info->minimum_order_quantity= $request->minimum_order_quantity;
        $payment_delivery_info->unit_of_measure= $request->unit_of_measure;
        $payment_delivery_info->price_for_optional_unit= $request->price_for_optional_unit;
        $payment_delivery_info->pack_dimenshn_per_unit_length= $request->pack_dimenshn_per_unit_length;
        $payment_delivery_info->pack_dimenshn_per_unit_width= $request->pack_dimenshn_per_unit_width;
        $payment_delivery_info->pack_dimenshn_per_unit_height= $request->pack_dimenshn_per_unit_height;
        $payment_delivery_info->weight_per_packging= $request->weight_per_packging;
        $payment_delivery_info->export_carton_dimension= $request->export_carton_dimension;
        $payment_delivery_info->export_carton_dimension_weight= $request->export_carton_dimension_weight;
        $payment_delivery_info->deliver_duration_with_stat= $request->deliver_duration_with_stat;
        $payment_delivery_info->duration_delivery_within_geo_range= $request->duration_delivery_within_geo_range;
        $payment_delivery_info->duration_delivery_out_geo_range= $request->duration_delivery_out_geo_range;
        $payment_delivery_info->duration_delivery_out_geo_range= $request->duration_delivery_out_geo_range;
        $payment_delivery_info->payment_mehod= $request->payment_mehod;
        $payment_delivery_info->save();
        if($request->file('image_2')){

            $image = $request->file('image_2');
            $filename = time().'-'.$image->getClientOriginalName(). '.' . $image->getClientOriginalExtension();
            $path = base_path('img/products');
            $image->move($path, $filename);
            $images2 = 'img/products/'.$filename;
            }else{
             $images2 = '';
            }

            if($request->file('image_3')){

            $image = $request->file('image_3');
            $filename = time().'-'.$image->getClientOriginalName(). '.' . $image->getClientOriginalExtension();
            $path = base_path('img/products');
            $image->move($path, $filename);
            $images3 = 'img/products/'.$filename;
            }else{
             $images3 = '';
            }

            if($request->file('image_4')){

            $image = $request->file('image_4');
            $filename = time().'-'.$image->getClientOriginalName(). '.' . $image->getClientOriginalExtension();
            $path = base_path('img/products');
            $image->move($path, $filename);
            $images4 = 'img/products/'.$filename;
            }else{
             $images4 = '';
            }

        $ispresent=productimages::where('product_id','=',$vendor_product->id)->first();
        if($ispresent){
            $ispresent->image_1 = $images;
            $ispresent->image_2 = $images2;
            $ispresent->image_3 = $images3;
            $ispresent->image_4 = $images4;
            $ispresent->save();

        }
        else{
            $product_image = new productimages();
        $product_image->product_id = $vendor_product->id;
        

            
          
            $product_image->image_1 = $images;
            $product_image->image_2 = $images2;
            $product_image->image_3 = $images3;
            $product_image->image_4 = $images4;
            $product_image->save();

        }
        

        return redirect('admin/vendorproduct')->with('status','Successfully Add Product');

    }


    public function edit($id)
    {
      $vendor = DB::table('vendors')->pluck('vendorname','user_id');
        //dd($vendor);
        $catagory = category::pluck('id','name');

        $manufacture = productmanufacturer::pluck('name','id');
        $model = productmodel::pluck('name','id');

       $condition = condition::pluck('name','id');

        $vendor_product = DB::table('vendorproduct')
                            ->select('vendorproduct.*','payment_delivery_information.*')
                           ->leftjoin('payment_delivery_information','payment_delivery_information.product_id','=','vendorproduct.id')
                            ->where('vendorproduct.id', $id)->first();
      //  dd($vendor_product);
        $subcategory = subcategory::where('category_id',$vendor_product->category)->get();
        $vendor_products = vendorproduct::where('product_status','1')->pluck('name','id');
        
        $accessories_array = $vendor_product->accessories;
        $accessories = explode(',', $accessories_array);
     
        $shipping=shipping::where('vendorproduct_id','=',$vendor_product->product_id)->first();
        return View::make('admin.product.edit' , compact('vendor','catagory','manufacture','model','vendor_product','subcategory','vendor_products','accessories','condition','shipping'));
    }



    public function update(Request $request,$id)
    {


    $this->validate($request, [
            'name'=> 'required|max:100',
            'product_generic_name'=> 'required',
            'vendor'=> 'required',
            'category'=> 'required',
            'image_1'=>'max:2000',
            'image_2'=>'max:2000',
            'image_3'=>'max:2000',
            'image_4'=>'max:2000',
            'subcategory'=> 'required',
            'instant_price'=> 'required',
            'deliveryratestate'=>'required',
            'deliveryrateoutstatewithgeo'=>'required',
            'deliveryrateoutsidegeo'=>'required',
            
         ]);
     $ccessories_array = $request->accessories;
    if($ccessories_array)
        {
           $accessories  = implode(",",$ccessories_array); 
        }else{

            $accessories='';
        }
        $product = products::find($id);
        $product->name = $product->name;
        $product->category=$request->category;
        $product->subcategory=$request->subcategory;
        $product->manufacturer=$request->manufacturer;
        $product->model=$request->model;
        $product->additional_specification=$request->specification;
       if($request->file('image_1')){

            $image = $request->file('image_1');
            $filename = time().'-'.$image->getClientOriginalName(). '.' . $image->getClientOriginalExtension();
            $path = base_path('img/products');
            $image->move($path, $filename);
            $images = 'img/products/'.$filename;
            }else{
             $images = $product->image;
            }
             $product->image  = $images;
            $product->save();
         



        $vendor_product = vendorproduct::where('product_id',$id)->first();
        $vendor_product->name=$vendor_product->name;
        $vendor_product->product_id=$product->id;
        $vendor_product->user_id=$request->vendor;
        $vendor_product->condition_id=$request->condition;
        $vendor_product->product_generic_name=$request->product_generic_name;
      //  $vendor_product->description=$request->description;
        $vendor_product->product_keyword=$request->product_keyword;
        $vendor_product->part_number=$request->part_number;
        $vendor_product->category=$request->category;
        $vendor_product->subcategory=$request->subcategory;
        $vendor_product->manufacturer_id=$request->manufacturer;
        $vendor_product->model_id=$request->model;
        $vendor_product->stock_count= $vendor_product->stock_count;
        $vendor_product->unit=$request->unit_of_measure;
        $vendor_product->accessories=$accessories;
      //  $vendor_product->other_information=$request->other_information;
        $vendor_product->key_specification=$request->key_specification;
        $vendor_product->key_specification=$request->key_specification;
        $vendor_product->supplyType=$request->supplyType;
        $vendor_product->color=$request->color;
        $vendor_product->price= $vendor_product->instant_price ;
        $vendor_product->pricewithin15days= $vendor_product->pricewithin15days ;
        $vendor_product->pricewithin30days= $vendor_product->pricewithin30days ;
        $vendor_product->instant_price= $vendor_product->instant_price;
        $vendor_product->deliveryratestate= $vendor_product->deliveryratestate;
        $vendor_product->deliveryrateoutstatewithgeo= $vendor_product->deliveryrateoutstatewithgeo;
        $vendor_product->deliveryrateoutsidegeo= $vendor_product->deliveryrateoutsidegeo;
         $vendor_product->model_number=$request->model_number;
        $vendor_product->serial_number=$request->serial_number;
        $vendor_product->availability= "yes";
        $vendor_product->edit_product_staus= "no";
        
        
        $vendor_product->save();
        $product_id = $vendor_product->id;
        //shipping update
        $shipping=shipping::where('vendorproduct_id','=',$product_id)->first();
        if($shipping){
            $shipping->shipping_type=$request->shipping;
            $shipping->save();
        }
        else{
            $shipping=new shipping;
            $shipping->vendorproduct_id=$product_id;
            $shipping->shipping_type=$request->shipping;
            $shipping->save();

        }
        $slog = str_replace([" ","/"], "_", $vendor_product->name);
        $slog_name = $slog.'_'.$product_id;

        $updatevendor = vendorproduct::where('id', $product_id)->update(array('slog' => $slog_name));

        $payment = PaymentDeliveryInformation::where('product_id',$product_id)->first();

        $payment_delivery_info = PaymentDeliveryInformation::find($payment->id);
        $payment_delivery_info->product_id= $vendor_product->id;
        $payment_delivery_info->dimension_per_unit_length= $request->dimension_per_unit_length;
        $payment_delivery_info->dimension_per_unit_width= $request->dimension_per_unit_width;
        $payment_delivery_info->dimension_per_unit_weight= $request->dimension_per_unit_weight;
        $payment_delivery_info->dimension_per_unit_volume= $request->dimension_per_unit_volume;
        $payment_delivery_info->minimum_order_quantity= $request->minimum_order_quantity;
        $payment_delivery_info->unit_of_measure= $request->unit_of_measure;
        $payment_delivery_info->price_for_optional_unit= $request->price_for_optional_unit;
        $payment_delivery_info->pack_dimenshn_per_unit_length= $request->pack_dimenshn_per_unit_length;
        $payment_delivery_info->pack_dimenshn_per_unit_width= $request->pack_dimenshn_per_unit_width;
        $payment_delivery_info->pack_dimenshn_per_unit_height= $request->pack_dimenshn_per_unit_height;
        $payment_delivery_info->weight_per_packging= $request->weight_per_packging;
        $payment_delivery_info->export_carton_dimension= $request->export_carton_dimension;
        $payment_delivery_info->export_carton_dimension_weight= $request->export_carton_dimension_weight;
        $payment_delivery_info->deliver_duration_with_stat= $request->deliver_duration_with_stat;
        $payment_delivery_info->duration_delivery_within_geo_range= $request->duration_delivery_within_geo_range;
        $payment_delivery_info->duration_delivery_out_geo_range= $request->duration_delivery_out_geo_range;
        $payment_delivery_info->duration_delivery_out_geo_range= $request->duration_delivery_out_geo_range;
        $payment_delivery_info->payment_mehod = $request->payment_mehod;
        $payment_delivery_info->save();

        $productimages = productimages::where('product_id',$vendor_product->id)->first();

        $product_image = productimages::find($productimages->id);
      
        

            if($request->file('image_2')){

            $image = $request->file('image_2');
            $filename = time().'-'.$image->getClientOriginalName(). '.' . $image->getClientOriginalExtension();
            $path = base_path('img/products');
            $image->move($path, $filename);
            $images2 = 'img/products/'.$filename;
            }else{
             $images2 = $product_image->image_2;
            }

            if($request->file('image_3')){

            $image = $request->file('image_3');
            $filename =time().'-'.$image->getClientOriginalName(). '.' . $image->getClientOriginalExtension();
            $path = base_path('img/products');
            $image->move($path, $filename);
            $images3 = 'img/products/'.$filename;
            }else{
             $images3 = $product_image->image_3;
            }

            if($request->file('image_4')){

            $image = $request->file('image_4');
            $filename = time().'-'.$image->getClientOriginalName(). '.' . $image->getClientOriginalExtension();
            $path = base_path('img/products');
            $image->move($path, $filename);
            $images4 = 'img/products/'.$filename;
            }else{
             $images4 = $product_image->image_4;
            }

          
            $product_image->image_1 = $images;
            $product_image->image_2 = $images2;
            $product_image->image_3 = $images3;
            $product_image->image_4 = $images4;
            $product_image->save();
        
       

       $editpeoducts = EditProducts::where('product_id',$id)->first();
       if($editpeoducts)
       {

            $editproudct = EditProducts::find($editpeoducts->id);
            if($editproudct->p_name !=$request->name 
                || $editproudct->quantity != $request->stock_count 
                || $editproudct->p_price != $request->instant_price 
                || $editproudct->days_15_price != $request->pricewithin15days 
                || $editproudct->days_30_price != $request->pricewithin30days
                || $editproudct->deliveryrate_state != $request->deliveryratestate
                || $editproudct->deliveryrateoutstatewith_geo != $request->deliveryrateoutstatewithgeo
                || $editproudct->deliveryrate_outsidegeo != $request->deliveryrateoutsidegeo)
            {

             $editproudct->p_name = $request->name;
             $editproudct->quantity = $request->stock_count;
             $editproudct->p_price = $request->instant_price;
             $editproudct->days_15_price = $request->pricewithin15days;
             $editproudct->days_30_price = $request->pricewithin30days;
             $editproudct->deliveryrate_state = $request->deliveryratestate;
             $editproudct->deliveryrateoutstatewith_geo = $request->deliveryrateoutstatewithgeo;
             $editproudct->deliveryrate_outsidegeo = $request->deliveryrateoutsidegeo;
            $editproudct->part=$request->part_number;
             $editproudct->cat=$request->category;
             $editproudct->subcat=$request->subcategory;
             $editproudct->manu=$request->manufacturer;
             $editproudct->models=$request->model;
                $editproudct->description_p=$request->description;
             $editproudct->key_information_p=$request->other_information;
             $editproudct->save();
            }
         

       }else{
        $editproudct = new EditProducts;
         $editproudct->p_name = $request->name;
         $editproudct->product_id = $id;
         $editproudct->quantity = $request->stock_count;
         $editproudct->p_price  = $request->instant_price;
         $editproudct->days_15_price = $request->pricewithin15days;
         $editproudct->days_30_price = $request->pricewithin30days;
         $editproudct->deliveryrate_state = $request->deliveryratestate;
         $editproudct->deliveryrateoutstatewith_geo = $request->deliveryrateoutstatewithgeo;
         $editproudct->deliveryrate_outsidegeo = $request->deliveryrateoutsidegeo;
         $editproudct->part=$request->part_number;
             $editproudct->cat=$request->category;
             $editproudct->subcat=$request->subcategory;
             $editproudct->manu=$request->manufacturer;
             $editproudct->models=$request->model;
                $editproudct->description_p=$request->description;
             $editproudct->key_information_p=$request->other_information;
         $editproudct->save();

             

       }

       





        return redirect('admin/vendorproduct')->with('status','Successfully update Product!');

    }


    public function delete($id)
    {



     try
        {
          /*  $vendor_product =  vendorproduct::find($id);
            $products =  products::find($id);

            if($vendor_product->delete())
            {
                $products->delete();
                $payment = PaymentDeliveryInformation::where('product_id',$vendor_product->id)->first();

               $payment_delivery_info = PaymentDeliveryInformation::find($payment->id);
               $payment_delivery_info->delete();
               $productimages = productimages::where('product_id',$vendor_product->id)->first();
               $product_image = productimages::find($productimages->id);
               $product_image->delete();
                Session::flash('status',  $this->delete_message);
            }
            else
            {
                Session::flash('status', 'something wrong');
            }
            return Redirect::to('admin/vendorproduct');*/
             $vendor_product =  vendorproduct::find($id);
             $vendor_product->delete_product=1;
             $vendor_product->availability='no';
             $vendor_product->save();
              Session::flash('status', 'Product deleted Successfully!');
              return Redirect::to('admin/vendorproduct');
        }
        catch(\Exception $e)
        {
            $dbCode = trim($e->getCode());
            switch ($dbCode)
            {
                case 23000:
                    $errorMessage = 'As this Product has order , so you couldn\'t delete it.';
                    break;
                default:
                    $errorMessage = 'Something wrong with query';
            }
            return redirect()->back()->with('errormsg',"$errorMessage");    
        }

    }




 public function aprove_reject_product()
 {

    $vendor_product =  vendorproduct::where('product_status','0')->get();




    return View::make('admin.product.aprove_rej_product_list' , compact('vendor_product'));

 }



 public function approve($id)
 {

    $vendor_product =  vendorproduct::find($id);
    $vendor_product->product_status='1';
    $vendor_product->availability ='yes';
    $vendor_product->save();

    
    return redirect('admin/aprove_reject_product')->with('status','Successfully Active Product');

 }

 public function deactive($id)
 {

    $vendor_product =  vendorproduct::find($id);
   // $vendor_product->product_status='0';
    $vendor_product->availability ='no';
    $vendor_product->save();

    
    return redirect('admin/vendorproduct')->with('status','Successfully Deactive Product');

 }
 public function active($id)
 {

    $vendor_product =  vendorproduct::find($id);
   // $vendor_product->product_status='0';
    $vendor_product->availability ='yes';
    $vendor_product->save();

    
    return redirect('admin/vendorproduct')->with('status','Successfully Deactive Product');

 }







    public function get_sub_catgory(Request $request)
    {

        $catagory_id = $request->catagory_id;

        $sub = DB::table('subcategories')->where('category_id',$catagory_id)->get();

       return Response::json($sub);


    }

    public function DetailProduct($id)
    {


        $vendor_product = DB::table('vendorproduct')
                            ->select('vendorproduct.*','payment_delivery_information.*','product_image.*','productmodel.name as model_name','productmanufacturer.name as manufacture_name','condition.name as condition_name')
                           ->leftjoin('payment_delivery_information','payment_delivery_information.product_id','=','vendorproduct.id')
                           ->leftjoin('product_image','product_image.product_id','=','vendorproduct.id')
                           ->leftjoin('productmodel','productmodel.id','=','vendorproduct.model_id')
                           ->leftjoin('productmanufacturer','productmanufacturer.id','=','vendorproduct.manufacturer_id')
                           ->leftjoin('condition','condition.id','=','vendorproduct.condition_id')
                            ->where('vendorproduct.id', $id)->first();
                            
        //dd($vendor_product);
        return View::make('admin.product.product_detail' , compact('vendor_product'));

    }


    public function inventory()
    {

        
                            $vendor_product=vendorproduct::all();
                    //   $vendor_product=$vendor_product->unique();     
        return View::make('admin.product.inventory' , compact('vendor_product'));
    }

    public function AddInvetory(Request $request,$id)
    {

        $product = vendorproduct::find($id);
        $product->stock_count =$product->stock_count+$request->stock;
        $product->save();


        return redirect('admin/inventory')->with('status','Successfully Add Stock');

    }



    public function editApprove()
    {

      $vendor_product =DB::table('edit_product_history')
                       ->join('vendorproduct','vendorproduct.id','=','edit_product_history.product_id')
                       ->where('vendorproduct.edit_product_staus','no')
                       ->get();
    

     return View::make('admin.product.edit_approve' , compact('vendor_product'));   
    }


   public function aproveProduct(Request $request)
   {

    $id = $request->id;

    $editproudcts = EditProducts::where('product_id',$id)->first();
    $vendor_product =  vendorproduct::find($id);
    $vendor_product->name= $editproudcts->p_name ;
    $vendor_product->price= $editproudcts->p_price ;
    $vendor_product->stock_count= $editproudcts->quantity;
    $vendor_product->pricewithin15days= $editproudcts->days_15_price  ;
    $vendor_product->pricewithin30days= $editproudcts->days_30_price  ;
    $vendor_product->instant_price= $editproudcts->p_price;
    $vendor_product->deliveryratestate= $editproudcts->deliveryrate_state;
    $vendor_product->deliveryrateoutstatewithgeo= $editproudcts->deliveryrateoutstatewith_geo;
    $vendor_product->deliveryrateoutsidegeo=$editproudcts->deliveryrate_outsidegeo;
    $vendor_product->description=$editproudcts->description_p;
    $vendor_product->other_information=$editproudcts->key_information_p;
    $vendor_product->edit_product_staus= "yes";
    $vendor_product->save();

    $product = products::find($id);
    $product->name = $editproudcts->p_name;
    $product->save();

   }
   public function rejectProduct(Request $request){
    $id=$request->id;
     $vendor_product =  vendorproduct::find($id);
     $vendor_product->edit_product_staus="yes";
     $vendor_product->save();
   }
   public function shipping(){
    $shipping=shippingInformations::all();
    $manualShipping = mannual_shipping::with('product')->get();
    return view('admin.shipping',compact('shipping', 'manualShipping'));
   }
   public function addshipping(){
    return view('admin.addshipping');
   }
   public function addcity(){
    return view('admin.city');
   }
   public function city(Request $request){

     $this->validate($request, [
            'state'=> 'required',
            'country'=>'required',
            'city'=> 'required|unique:cities,name',
            
         ]);
   
     $city=new city;
     $city->state_name=$request->state;
     $city->country_name=$request->country;
     $city->name=$request->city;
     $city->save();
     return back()->with('message','Successfully Created city');
       }
   public function addstate(){
    return view('admin.state');
   }
   public function state(Request $request){
      $this->validate($request, [
            'state'=> 'required|unique:states,name',
            'country'=>'required',

            
         ]);
      $state=new state;
      $state->name=$request->state;
      $state->country_name=$request->country;
      if($request->zone){
        $state->zone=$request->zone;
      }
      $state->save();
      return back()->with('message','Successfully state Added');
   }
   public function addcountry(){
    return view('admin.country');
   }
    public function country(Request $request){
      $this->validate($request, [
            'country'=> 'required|unique:countries,name',
            
         ]);
      $country=new country;
      $country->name=$request->country;
      $country->save();
      return back()->with('message','Successfully country Added');
   }
   public function list(Request $request){
    $state=$request->get('state');
    $city=city::where('state_name','=',$state)->get();
    $view='';
    foreach ($city as $key => $value) {
       $view .='<option value="'.$value->name.'" class="abc">'.$value->name.'</option>';
    }
   return json_encode($view);
   }
   public function getstate(Request $request){
    if($request->ajax()){
        $country=$request->get('country');
        $view='';
        $state=state::where('country_name','=',$country)->get();
        if(count($state)>0){
            foreach ($state as $key => $st) {
                $view .='<option value="'.$st->name.'" class="abc">'.$st->name.'</option>';
            }
           

        }
        return json_encode($view);
    }
   }
   public function storeshipping(Request $request){
    $this->validate($request, [
            'zone'=>'required|unique:shipping_informations,zone',
            'kg'=> 'required',
            'volumn'=> 'required',
         ]);
    $shippingInformations=new shippingInformations;
    /*$shippingInformations->state=$request->state;
    $shippingInformations->city=$request->city; */
    $shippingInformations->zone=$request->zone;
   // $shippingInformations->country=$request->country;
    $shippingInformations->ammount_per_kg=$request->kg;
    $shippingInformations->ammount_per_valume=$request->volumn;
    $shippingInformations->save();
    return redirect('admin/shipping');
      
   }
   public function editshipping($id){
    $shipping=shippingInformations::find($id);
    $zones = [
        'South East',
        'South South',
        'South West',
        'North East',
        'North West',
        'North Central'
    ];
    return view('admin.editshipping',compact('shipping', 'zones'));
   }
   public function updateshipping(Request $request,$id){
    $this->validate($request, [
            'zone'=>'required',
            'kg'=> 'required',
            'volumn'=> 'required',
         ]);
    $shippingInformations=shippingInformations::find($id);
    $shippingInformations->zone=$request->zone;
    $shippingInformations->ammount_per_kg=$request->kg;
    $shippingInformations->ammount_per_valume=$request->volumn;
    $shippingInformations->save();
    return redirect('admin/shipping'); 
   }
   public function mannual_shipping(){
    return view('admin.mannual_shipping');
   }
   public function edit_mannual_shipping(mannual_shipping $shipping){
    return view('admin.edit_mannual_shipping', compact('shipping'));
   }
   public function update_mannual_shipping(mannual_shipping $shipping, Request $request)
   {
       $shipping->city=$request->city;
       $shipping->shipping=$request->shipping;
       $shipping->vendorproduct_id=$request->product;
       $shipping->save();
       return back()->with('message','Successfully Updated!');
    }
   public function save_mannual(Request $request){
       $shipping=mannual_shipping::where('city','=',$request->city)->where('vendorproduct_id','=',$request->vendorproduct_id)->first();
    if($shipping){
        $shipping->shipping=$request->shipping;
        $shipping->save();
    }
    else{
        $shipping=new mannual_shipping;
        $shipping->city=$request->city;
        $shipping->shipping=$request->shipping;
        $shipping->vendorproduct_id=$request->product;
        $shipping->save();
    }
    return \redirect()->to('admin/shipping/manual_shipping/'.$shipping->id);
    }
public function editcity($id){
    $city=city::find($id);
    return view('admin.editcity',compact('city'));
}
public function editstate($id){
    $city=state::find($id);
    return view('admin.editstate',compact('city'));
}
public function editcountry($id){
    $city=country::find($id);
    return view('admin.editcountry',compact('city'));
}
public function updatecity(Request $request,$id){

    $this->validate(request(),[
        'city'=>'required',
        'country'=>'required',
    ]);
    $city=city::find($id);
    $vendors=vendors::where('location','=',$city->name)->get();
    foreach ($vendors as $key => $vend) {
        $vend->location=$request->city;
        $vend->save();
    }
    $customer=Customer::where('city','=',$city->name)->get();
    foreach ($customer as $key => $cus) {
       $cus->city=$request->city;
       $cus->save();
    }
     $customers=Customer::where('billing_city','=',$city->name)->get();
    foreach ($customers as $key => $cus) {
       $cus->billing_city=$request->city;
       $cus->save();
    }
    $city->name=$request->city;
    $city->state_name=$request->state;
    $city->country_name=$request->country;
    $city->save();
    return redirect('admin/shipping')->with('message','Your city is updated');
}
public function updatecountry(Request $request,$id){

    $this->validate(request(),[
        'city'=>'required'
    ]);
    $city=country::find($id);
    $ct=city::where('country_name','=',$city->name)->get();
    foreach ($ct as $key => $c) {
       $c->country_name=$request->city;
       $c->save();
    }
    $state=state::where('country_name','=',$city->name)->get();
    foreach ($state as $key => $st) {
    $st->country_name=$request->city;
    $st->save();
    }
    $city->name=$request->city;
    $city->save();
    return redirect('admin/shipping')->with('message','Your country is updated');
}
public function updatestate(Request $request,$id){
    $this->validate(request(),[
        'city'=>'required'
    ]);
    $city=state::find($id);
    $ct=city::where('state_name','=',$city->name)->get();
    foreach ($ct as $key => $c) {
       $c->state_name=$request->city;
       $c->save();
    }
    $vendors=vendors::where('state','=',$city->name)->get();
    foreach ($vendors as $key => $vend) {
        $vend->state=$request->city;
        $vend->save();
    }
    $customer=Customer::where('state','=',$city->name)->get();
    foreach ($customer as $key => $cus) {
       $cus->state=$request->city;
       $cus->save();
    }
     $customers=Customer::where('billing_state','=',$city->name)->get();
    foreach ($customers as $key => $cus) {
       $cus->billing_state=$request->city;
       $cus->save();
    }
    $city->name=$request->city;
    $city->country_name=$request->country;
    $city->zone=$request->zone;
    $city->save();
    return redirect('admin/shipping')->with('message','Your city is updated');
}

}
