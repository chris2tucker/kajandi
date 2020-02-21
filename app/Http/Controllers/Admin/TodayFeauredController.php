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


class TodayFeauredController extends Controller
{
    
    public function index()
    {


        $today_featured = DB::table('today_featured')
                            ->select('today_featured.*','vendors.*','vendorproduct.*','today_featured.id as id','today_featured.image as today_image')
                           ->leftjoin('vendors','vendors.id','=','today_featured.vendor_id')
                           ->leftjoin('vendorproduct','vendorproduct.id','=','today_featured.vendor_product_id')
                            ->get();
        //dd($today_featured);


        return View::make('admin.Today_fetured.today_fetured_list',compact('today_featured'));
    }


    public function create()
    {

        $vendor = DB::table('vendors')->pluck('vendorname','id');



        return View::make('admin.Today_fetured.add_today_fetured' , compact('vendor'));
    }


    public function store(Request $request)
    {

        $this->validate($request, [
            'product_name'=> 'required|max:100',
            'image'=> 'required|image|mimes:jpg,jpeg|max:5000',
         ]);


        $today_featured = new TodayFeatured();
        $today_featured->vendor_id = $request->vendor;
        $today_featured->vendor_product_id = $request->product_name;

       if (request()->hasFile('image')) {
                    $attachment = $request->file('image');
                    
                    $destinationPath_att = public_path('img');

                    $attachment->move($destinationPath_att,$attachment->getClientOriginalName());
                    $file_attachment = $attachment->getClientOriginalName();

                   $today_featured->image        = $file_attachment;
                 }
        $today_featured->save();

        return redirect('admin/today_fetured')->with('status','Successfully Add Today Featured');

    }


    public function edit_today_featured($id)
    {
        $today_featured =  TodayFeatured::find($id);
        $vendor_id = $today_featured->vendor_id;


        $vendors =DB::table('vendors')->where('id',$vendor_id)->first();
        $vendor_products = DB::table('vendorproduct')->where('user_id',$vendors->user_id)->get();

        //dd($vendor_products);

        $vendor = DB::table('vendors')->pluck('vendorname','id');
        return View::make('Admin.Today_fetured.edit_today_fetured' , compact('vendor','today_featured','vendor_products'));
    }



    public function today_feature_update(Request $request,$id)
    {

        $this->validate($request, [
            'product_name'=> 'required|max:100',
            
         ]);


        $today_featured =  TodayFeatured::find($id);
        
        $today_featured->vendor_id = $request->vendor;
        $today_featured->vendor_product_id = $request->product_name;

       if (request()->hasFile('image')) {
                    $attachment = $request->file('image');
                    
                    $destinationPath_att = public_path('img');
                    $attachment->move($destinationPath_att,$attachment->getClientOriginalName());
                    $file_attachment = $attachment->getClientOriginalName();

                   $today_featured->image        = $file_attachment;
                 }
        $today_featured->save();

    return redirect('admin/today_fetured')->with('status','Successfully Update Today Featured');

    }


    public function delete_today_feature($id)
    {


    $today_featured =  TodayFeatured::find($id);
    $today_featured->delete();

    return redirect('admin/today_fetured')->with('status','Successfully Delete Today Featured');

    }









    public function get_vendor_product(Request $request)
    {

        $vendor_id = $request->vendor_id;

        $products = DB::table('vendor_products')->where('vendore_user_id',$vendor_id)->get();

       return Response::json($products);


    }

}
