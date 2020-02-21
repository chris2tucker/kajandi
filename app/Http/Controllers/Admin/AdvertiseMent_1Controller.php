<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use Laracasts\Flash\Flash;
use View;
use Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Html\HtmlFacade;
use App\Http\Controllers\Controller;
use DB;
use AUTH;
use Session;
use \Carbon\Carbon;
use Image;
use Response;
use App\vendors;
use App\Adv_section_1;


class AdvertiseMent_1Controller extends Controller {

	protected $created_message = "Successfully created Advertisement 1!";
	protected $edit_message = "Successfully update Advertisement 1!";
	protected $delete_message = "Successfully deleted";
	protected $notallow = 'Sorry you are not allow to view this page';

	

	public function index(Request $request)
	{
		/*if(!\Auth::User()->can('Admin')) //only admin allow on this page
			return redirect('admin/index')->withErrors(['msg'=> $this->notallow]);*/
		$user = \Auth::User();
	    $userid = $user->id;
		$adv_sec_1_data = DB::table('adv_sec_1')
							->select('adv_sec_1.*','vendors.vendorname','vendorproduct.name','adv_sec_1.id as id')
                            ->leftjoin('vendors','vendors.id','=','adv_sec_1.vendor_id')
                           ->leftjoin('vendorproduct','vendorproduct.id','=','adv_sec_1.product_id')->get();

   

		return View::make('admin.adv_sec_1.index',compact('adv_sec_1_data'));
			
	}


	public function create()
	{
		$user = \Auth::User();
	    $userid = $user->id;
		
		$vendor = vendors::pluck('vendorname','id');
	

		 
		return View::make('admin.adv_sec_1.create',compact('vendor'));
	}

	
	public function store(Request $request)
	{
		/*if(!\Auth::User()->can('workstation_manage')) //only admin allow on this page
			return redirect('admin/home')->withErrors(['msg'=> $this->notallow]);*/
		$user = \Auth::User();
	    $userid = $user->id;

		$rules = array(
			
			'vendor'      => 'required',
			'product_name'      => 'required',
			'image'=> 'required|image',
		
			
		);
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return Redirect::to('admin/adv_sec_1/create')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {

				
	
				$adv_sec_1 = new Adv_section_1;
				$adv_sec_1->vendor_id = Input::get('vendor');
				$adv_sec_1->product_id = Input::get('product_name');
				if ($request->hasFile('image')) {
		            $file = $request->file('image');
		            
		            $destination = public_path('img');
		           
		            //$file_name = $file->getClientOriginalName();
		            	$file_name = time().'.'.$file->getClientOriginalExtension();
		            	 $file->move($destination,$file_name);
		            $adv_sec_1->image        = $file_name;
		            }
				$adv_sec_1->save();

					
				Session::flash('status', $this->created_message);
				return Redirect::to('admin/adv_sec_1');
			
	


		}
	}

	
	public function show($id)
	{
		if(!Auth::User()->can('workstation_manage')) //only admin allow on this page
			return redirect('admin/home')->withErrors(['msg'=> $this->notallow]);
		$nerd = Nerd::find($id);

		
		return View::make('nerds.show')
			->with('nerd', $nerd);
	}

	
	public function edit($id)
	{

		$adv_sec_1 = Adv_section_1::find($id);

		$vendor_id = $adv_sec_1->vendor_id;

		$vendor = vendors::pluck('vendorname','id');

		$vendors =DB::table('vendors')->where('id',$vendor_id)->first();

        $products = DB::table('vendorproduct')->where('user_id',$vendors->user_id)->get();

		return View::make('admin.adv_sec_1.edit',compact('vendor','adv_sec_1','products'));
			   
	}

	public function update(Request $request ,$id)
	{
	

	
		$rules = array(
			
			'vendor'      => 'required',
			'product_name'      => 'required',
			
		);

	
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return Redirect::to('admin/adv_sec_1/' . $id . '/edit')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {

				$adv_sec_1 =  Adv_section_1::find($id);
				$adv_sec_1->vendor_id = Input::get('vendor');
				$adv_sec_1->product_id = Input::get('product_name');
				if ($request->hasFile('image')) {
		            $file = $request->file('image');
		            
		            $destination = public_path('img');
		          
		          //  $file_name = $file->getClientOriginalName();
		            $file_name = time().'.'.$file->getClientOriginalExtension();
  $file->move($destination,$file_name);
		            $adv_sec_1->image        = $file_name;
		            }
				$adv_sec_1->save();

					
				Session::flash('status', $this->edit_message);
				return Redirect::to('admin/adv_sec_1');
			
				
		


		}

	
	
	}

	public function destroy($id)
	{
	/*if(!\Auth::User()->can('workstation_manage')) //only admin allow on this page
			return redirect('admin/home')->withErrors(['msg'=> $this->notallow]);*/

        try
		{
			$user = Adv_section_1::findOrFail($id);

			if($user->delete())
			{
				
				Session::flash('status',  $this->delete_message);
			}
			else
			{
				Session::flash('error', 'something wrong');
			}
			return Redirect::to('admin/adv_sec_1');
		}
		catch(\Exception $e)
		{
		   	$dbCode = trim($e->getCode());
	        switch ($dbCode)
	        {
	            case 23000:
	                $errorMessage = 'As this Component has been used  , so you couldn\'t delete it.';
	                break;
	            default:
	                $errorMessage = 'Something wrong with query';
	        }
       		return redirect()->back()->with('error',"$errorMessage");    
		}	
			
			
	}

	public function get_vendor_product(Request $request)
    {

        $vendor_id = $request->vendor_id;

        $vendor =DB::table('vendors')->where('id',$vendor_id)->first();



        $products = DB::table('vendorproduct')->where('user_id',$vendor->user_id)->get();

         return Response::json($products);


    }



}