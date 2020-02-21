<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\termscondition;
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
use App\Role;
use App\carts;
use App\ordersdetail;
use App\orders;
use App\workplace;
use App\customersvendor;
use App\wishlist;
use App\review;
use App\customersverification;
use App\outstandingpayment;
use Cart;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Customer;
use Session;
use App\SocialLinks;
use App\walletusers;
class TermsconditionController extends Controller
{
	public function getcustomerterms(){
		$customerterms=termscondition::find(1);

		return view('admin.terms.customer_terms',compact('customerterms'));
	}
    public function customerterms(Request $Request){
    	$customerterms=termscondition::find(1);
    	$customerterms->terms=$Request->tex;
    	$customerterms->save();
    	return redirect()->back();
    }
    public function getvendorterms(){
    	$customerterms=termscondition::find(2);

		return view('admin.terms.vendor_terms',compact('customerterms'));
    }
    public function vendorterms(Request $Request){
    	$customerterms=termscondition::find(2);
    	$customerterms->terms=$Request->tex;
    	$customerterms->save();
    	return redirect()->back();
    }
    public function showcustomerterms(){
    	$customerterms=termscondition::find(1);
    	        $cart = app('App\Http\Controllers\HomeController')->cart();
        $banar_data = DB::table('banner')->get();
        $catagory = DB::table('categories')
                        ->select('categories.*','categories.name as cat_name','categories.slog as cat_slog','categories.id as id')
                        ->where('categories.add_menu','yes')
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
            $sub_cat[] = $subcatagory;
            
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
    	return view('TermsConditions.customerTerms',compact('customerterms','cart','banar_data','catagory','sub_cat','adv_sec_1','adv_sec_2','catagories','today_featured'));
    }
    public function showvendorterms(){
        $customerterms=termscondition::find(2);
                $cart = app('App\Http\Controllers\HomeController')->cart();
        $banar_data = DB::table('banner')->get();
        $catagory = DB::table('categories')
                        ->select('categories.*','categories.name as cat_name','categories.slog as cat_slog','categories.id as id')
                        ->where('categories.add_menu','yes')
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
            $sub_cat[] = $subcatagory;
            
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
        return view('TermsConditions.vendorTerms',compact('customerterms','cart','banar_data','catagory','sub_cat','adv_sec_1','adv_sec_2','catagories','today_featured'));
    }
    public function generalterms($id){
        $getPage=termscondition::find($id);
        return view('admin.terms.general',compact('getPage'));
    }
    public function generaltermsdelete($id){
        $getPage=termscondition::find($id);
        $getPage->delete();
        Session::flash('status', 'Successfully Deleted');
        return redirect()->back();
    }
    public function pages(){
        $pages=termscondition::all(['description', 'id']);
        return view('admin.terms.pages',compact('pages'));
    }

    public function createPage(){
        return view('admin.terms.create');
    }
    public function generaltermsupdate(Request $request,$id){
        $getpage=termscondition::find($id);
        $getpage->terms=$request->tex;
        $getpage->save();
        return redirect()->back();
    }
    public function generaltermsstore(Request $request){
	    $page = new termscondition();
        $page->terms=$request->terms;
        $page->description=$request->description;
        $page->save();
        return redirect()->to('general/terms/'.$page->id);
    }
    public function getgeneralterms($id){
        $getterms=termscondition::find($id);
        $cart = app('App\Http\Controllers\HomeController')->cart();
        $banar_data = DB::table('banner')->get();
        $catagory = DB::table('categories')
                        ->select('categories.*','categories.name as cat_name','categories.slog as cat_slog','categories.id as id')
                        ->where('categories.add_menu','yes')
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
            $sub_cat[] = $subcatagory;
            
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
        return view('TermsConditions.generalTerms',compact('getterms','cart','banar_data','catagory','sub_cat','adv_sec_1','adv_sec_2','catagories','today_featured'));
    }
    public function companyinformation(Request $request)
    {
        $information = termscondition::find(9);
        $information->terms = $request->information;
        $information->description = "company-information";
        $information->save();
        return back();
    }

    public function informations()
    {
        $information = termscondition::find(9);
        return view('admin.terms.information',compact('information'));
    }
}
