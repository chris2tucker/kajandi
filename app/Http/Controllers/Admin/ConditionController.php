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
use App\condition;


class ConditionController extends Controller {

	protected $created_message = "Successfully created Condition!";
	protected $edit_message = "Successfully update Condition!";
	protected $delete_message = "Successfully deleted";
	protected $notallow = 'Sorry you are not allow to view this page';

	

	public function index(Request $request)
	{
		/*if(!\Auth::User()->can('Admin')) //only admin allow on this page
			return redirect('admin/index')->withErrors(['msg'=> $this->notallow]);*/
		$user = \Auth::User();
	    $userid = $user->id;
		$condition = condition::all();

		return View::make('admin.condition.index',compact('condition'));
			
	}


	public function create()
	{
		$user = \Auth::User();
	    $userid = $user->id;
		return View::make('admin.condition.create');
	}

	
	public function store(Request $request)
	{
		/*if(!\Auth::User()->can('workstation_manage')) //only admin allow on this page
			return redirect('admin/home')->withErrors(['msg'=> $this->notallow]);*/
		$user = \Auth::User();
	    $userid = $user->id;

		$rules = array(
			
			'name'      => 'required',
		);
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return Redirect::to('admin/condition/create')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {

				
	
				$condition = new condition;
				$condition->name = Input::get('name');
				$condition->save();

					
				Session::flash('status', $this->created_message);
				return Redirect::to('admin/condition');
			
	


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

		$condition = condition::find($id);

		

		return View::make('admin.condition.edit',compact('condition'));
			   
	}

	public function update(Request $request ,$id)
	{
	

	
		$rules = array(
			
			'name'      => 'required',
			
			
		);

	
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return Redirect::to('admin/condition/' . $id . '/edit')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {

				$condition =  condition::find($id);
				$condition->name = Input::get('name');
				
				$condition->save();

					
				Session::flash('status', $this->edit_message);
				return Redirect::to('admin/condition');
			
				
		


		}

	
	
	}

	public function destroy($id)
	{

        try
		{
			$user = condition::findOrFail($id);

			if($user->delete())
			{
				
				Session::flash('status',  $this->delete_message);
			}
			else
			{
				Session::flash('error', 'something wrong');
			}
			return Redirect::to('admin/condition');
		}
		catch(\Exception $e)
		{
		   	$dbCode = trim($e->getCode());
	        switch ($dbCode)
	        {
	            case 23000:
	                $errorMessage = 'As this Manufacture has been used  , so you couldn\'t delete it.';
	                break;
	            default:
	                $errorMessage = 'Something wrong with query';
	        }
       		return redirect()->back()->with('error',"$errorMessage");    
		}	
			
			
	}

	



}