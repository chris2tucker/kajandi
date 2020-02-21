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
use App\Adv_section_2;
use App\Banner;


class BannerController extends Controller {

	protected $created_message = "Successfully created Banner!";
	protected $edit_message = "Successfully update Banner!";
	protected $delete_message = "Successfully deleted";
	protected $notallow = 'Sorry you are not allow to view this page';

	

	public function index(Request $request)
	{
		/*if(!\Auth::User()->can('workstation_manage')) //only admin allow on this page
			return redirect('admin/home')->withErrors(['msg'=> $this->notallow]);*/
		$user = \Auth::User();
	    $userid = $user->id;
		$banner = Banner::all();

		return View::make('admin.banner.index',compact('banner'));
			
	}


	public function create()
	{
		$user = \Auth::User();
	    $userid = $user->id;
		
	
	

		 
		return View::make('admin.banner.create');
	}

	
	public function store(Request $request)
	{
		/*if(!\Auth::User()->can('workstation_manage')) //only admin allow on this page
			return redirect('admin/home')->withErrors(['msg'=> $this->notallow]);*/
		$user = \Auth::User();
	    $userid = $user->id;

		$rules = array(
			
			'banar_text'      => 'required',
			'banar_url'      => 'required',
			'banar_image'=> 'required|image',
		
			
		);
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return Redirect::to('admin/banner/create')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {

				
	
				$banner = new Banner;
				$banner->banar_text = Input::get('banar_text');
				$banner->banar_url = Input::get('banar_url');
				if ($request->hasFile('banar_image')) {
		            $file = $request->file('banar_image');
		            
		            $destination = public_path('img');
		            $file->move($destination,$file->getClientOriginalName());
		            $file_name = $file->getClientOriginalName();

		            $banner->banar_image        = $file_name;
		            }
				$banner->save();

					
				Session::flash('status', $this->created_message);
				return Redirect::to('admin/banner');
			
	


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

		$banner = Banner::find($id);

		return View::make('admin.banner.edit',compact('banner'));
			   
	}

	public function update(Request $request ,$id)
	{
	

	
		$rules = array(
			
			
			'banar_text'      => 'required',
			'banar_url'      => 'required',
            'banar_image'=> 'image',
			
		);

	
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return Redirect::to('admin/banner/' . $id . '/edit')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {

				$banner =  Banner::find($id);
				$banner->banar_text = Input::get('banar_text');
				$banner->banar_url = Input::get('banar_url');
				if ($request->hasFile('banar_image')) {
		            $file = $request->file('banar_image');
		            
		            $destination = public_path('img');
		            $file->move($destination,$file->getClientOriginalName());
		            $file_name = $file->getClientOriginalName();

		            $banner->banar_image        = $file_name;
		            }
				$banner->save();

					
				Session::flash('status', $this->edit_message);
				return Redirect::to('admin/banner');
			
				
		


		}

	
	
	}

	public function destroy($id)
	{
	/*if(!\Auth::User()->can('workstation_manage')) //only admin allow on this page
			return redirect('admin/home')->withErrors(['msg'=> $this->notallow]);*/

        try
		{
			$banner = Banner::findOrFail($id);

			if($banner->delete())
			{
				
				Session::flash('status',  $this->delete_message);
			}
			else
			{
				Session::flash('error', 'something wrong');
			}
			return Redirect::to('admin/banner');
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

	


}