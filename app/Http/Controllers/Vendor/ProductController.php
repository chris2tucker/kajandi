<?php

namespace App\Http\Controllers\Vendor;

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
use App\Notification;
use Auth;
use App\User;
class ProductController extends Controller
{
    
    public function index()
    {



        $catagory = category::pluck('id','name');


        return View::make('admin.product.create',compact('catagory'));
    }


    public function create()
    {
        $user = \Auth::User();
        $userid = $user->id;
        $vendor = DB::table('vendors')->pluck('vendorname','user_id');
        //dd($vendor);
        $catagory = category::pluck('id','name');
        $condition = condition::pluck('name','id');
        $manufacture = productmanufacturer::pluck('name','id');
        $model = productmodel::pluck('name','id');
        $vendor_products = vendorproduct::where('product_status','1')->where('user_id','=',Auth::user()->id)->pluck('name','id');


        return View::make('vendors.product.create' , compact('vendor','catagory','manufacture','model','userid','condition','vendor_products'));
    }


    public function store(Request $request)
    {

        $this->validate($request, [
            'name'=> 'required|max:100',
            'product_generic_name'=> 'required',
            'vendor'=> 'required',
            'category'=> 'required',
            'subcategory'=> 'required',
            'image_1'=> 'required|max:2000',
            'image_2'=>'max:2000',
            'image_3'=>'max:2000',
            'image_4'=>'max:2000',
            'instant_price' =>'required',
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
            $path = base_path('img\products');
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
        $acessories  = implode(",",$ccessories_array);
        }else{

            $acessories  ='';
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
        $vendor_product->accessories=$acessories;
        $vendor_product->other_information=$request->other_information;
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
        $vendor_product->availability= "no";
        
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
        $admin=User::where('user_type','=','Admin')->first();
       
 $notification = new Notification();
            $notification->user_id = $admin->id;
            $notification->notification = Auth::User()->name ." added a new product";
            $notification->save();

             $notification = new Notification();
            $notification->user_id = $admin->id;
            $notification->notification = Auth::User()->name ." added new products for approval";
            $notification->save();




        return redirect('vendors/products')->with('status','Successfully Add Product');

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
                            ->select('vendorproduct.*','payment_delivery_information.*' ,'vendorproduct.id as id' )
                           ->leftjoin('payment_delivery_information','payment_delivery_information.product_id','=','vendorproduct.id')
                            ->where('vendorproduct.id', $id)->first();
        //dd($vendor_product);
        $subcategory = subcategory::where('category_id',$vendor_product->category)->get();
        $vendor_products = vendorproduct::where('product_status','1')->where('user_id','=',Auth::user()->id)->pluck('name','id');
        $accessories_array = $vendor_product->accessories;
        $accessories = explode(',', $accessories_array);


        return View::make('vendors.product.edit' , compact('vendor','catagory','manufacture','model','vendor_product','subcategory','condition','vendor_products','accessories'));
    }



    public function update(Request $request,int $id)
    {


    $this->validate($request, [
            'name'=> 'required|max:100',
            'product_generic_name'=> 'required',
            'vendor'=> 'required',
            'image_1'=>'max:2000',
            'image_2'=>'max:2000',
            'image_3'=>'max:2000',
            'image_4'=>'max:2000',
            'category'=> 'required',
            'subcategory'=> 'required',
            'instant_price'=> 'required',
            'deliveryratestate'=>'required',
            'deliveryrateoutstatewithgeo'=>'required',
            'deliveryrateoutsidegeo'=>'required',

           
            
         ]);
      


        $product = products::find($id);
        $vendorsProductprice=vendorproduct::where('product_id','=',$product->id)->first();
        if($vendorsProductprice->instant_price!=$request->instant_price || $vendorsProductprice->pricewithin15days !=$request->pricewithin15days ||$vendorsProductprice->pricewithin30days !=$request->pricewithin30days){
            $notification = new Notification();
            $notification->user_id = 40;
            $notification->notification = Auth::User()->name ." edited his product price";
            $notification->save();
        }
        $product->name = $product->name;
        $product->category=$request->category;
        $product->subcategory=$request->subcategory;
        $product->manufacturer=$request->manufacturer;
        $product->model=$request->model;
        $product->additional_specification=$request->specification;
       if($request->file('image_1')){

            $image = $request->file('image_1');
            $filename = time().'-'.$image->getClientOriginalName(). '.' . $image->getClientOriginalExtension();
            $path = base_path('img\products');
            $image->move($path, $filename);
            $images = 'img/products/'.$filename;
            }else{
             $images = $product->image;
            }
             $product->image  = $images;
            $product->save();
        $ccessories_array = $request->accessories;
      
        if($ccessories_array)
        {
        $acessories  = implode(",",$ccessories_array);
        }else{

            $acessories  ='';
        }

        $vendor_product = vendorproduct::where('product_id',$id)->first();
        $vendor_product->name=$vendor_product->name;
        $vendor_product->product_id=$product->id;
        $vendor_product->user_id=$request->vendor;
        $vendor_product->condition_id=$request->condition;
        $vendor_product->product_generic_name=$request->product_generic_name;
       // $vendor_product->description=$request->description;
        $vendor_product->product_keyword=$request->product_keyword;
        $vendor_product->part_number=$request->part_number;
        $vendor_product->category=$request->category;
        $vendor_product->subcategory=$request->subcategory;
        $vendor_product->manufacturer_id=$request->manufacturer;
        $vendor_product->model_id=$request->model;
        $vendor_product->stock_count=$vendor_product->stock_count;
        //$vendor_product->unit=;
        $vendor_product->accessories=$acessories;
       // $vendor_product->other_information=$request->other_information;
       $vendor_product->key_specification=$request->key_specification;
        $vendor_product->key_specification=$request->key_specification;
        $vendor_product->supplyType=$request->supplyType;
        $vendor_product->color=$request->color;
        $vendor_product->price=$vendor_product->instant_price;
        $vendor_product->pricewithin15days=$vendor_product->pricewithin15days;
        $vendor_product->pricewithin30days=$vendor_product->pricewithin30days;
        $vendor_product->instant_price= $vendor_product->instant_price;
        $vendor_product->deliveryratestate= $vendor_product->deliveryratestate;
        $vendor_product->deliveryrateoutstatewithgeo= $vendor_product->deliveryrateoutstatewithgeo;
        $vendor_product->deliveryrateoutsidegeo= $vendor_product->deliveryrateoutsidegeo;
        $vendor_product->availability= $vendor_product->availability;
        $vendor_product->model_number=$request->model_number;
        $vendor_product->serial_number=$request->serial_number;
        $vendor_product->edit_product_staus= "no";
        
        $vendor_product->save();
        $product_id = $vendor_product->id;

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
        $payment_delivery_info->payment_mehod= $request->payment_mehod;
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
            $filename = time().'-'.$image->getClientOriginalName(). '.' . $image->getClientOriginalExtension();
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


 $notification = new Notification();
            $notification->user_id = 40;
            $notification->notification = Auth::User()->name ." edited his product price";
            $notification->vendor_id = Auth::User()->id;
            $notification->data_id = $id;
            $notification->save();



        return redirect('vendors/products')->with('status','Successfully update Product!');

    }


    public function delete($id)
    {

    
        try
        {
            $vendor_product =  vendorproduct::find($id);
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
            return Redirect::to('vendors/products');
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


    public function get_sub_catgory(Request $request)
    {

        $catagory_id = $request->catagory_id;

        $sub = DB::table('subcategories')->where('category_id',$catagory_id)->get();

       return Response::json($sub);


    }




public function inventory()
{
   /* $vendor_product = DB::table('vendorproduct')
                            ->select('vendorproduct.*','payment_delivery_information.*','vendorproduct.id as id')
                           ->leftjoin('payment_delivery_information','payment_delivery_information.product_id','=','vendorproduct.id')
                            ->get(); */
                            $vendor_product=vendorproduct::where('user_id','=',Auth::user()->id)->get();

 return View::make('vendors.product.inventory' , compact('vendor_product'));     
}

public function add_inventory(Request $request,$id)
{

    $unit = $request->unit;

    $vendorproduct = vendorproduct::find($id);
    $vendorproduct->stock_count =$vendorproduct->stock_count+$unit;
    $vendorproduct->save();

    return redirect('vendor/inventory')->with('status','Successfully Update Stock!');
}

}
