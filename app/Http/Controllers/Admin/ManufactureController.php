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
use App\productmanufacturer;
use App\editmanufecturer;

class ManufactureController extends Controller {

	protected $created_message = "Successfully created Manufacture!";
	protected $edit_message = "Successfully update Manufacture!";
	protected $delete_message = "Successfully deleted";
	protected $notallow = 'Sorry you are not allow to view this page';

	

	public function index(Request $request)
	{
		/*if(!\Auth::User()->can('Admin')) //only admin allow on this page
			return redirect('admin/index')->withErrors(['msg'=> $this->notallow]);*/
		$user = \Auth::User();
	    $userid = $user->id;
		$manufacture = productmanufacturer::all();

   

		return View::make('admin.manufacture.index',compact('manufacture'));
			
	}


	public function create()
	{
		$user = \Auth::User();
	    $userid = $user->id;
		return View::make('admin.manufacture.create');
	}

	
	public function store(Request $request)
	{
		/*if(!\Auth::User()->can('workstation_manage')) //only admin allow on this page
			return redirect('admin/home')->withErrors(['msg'=> $this->notallow]);*/
		$user = \Auth::User();
	    $userid = $user->id;

		$rules = array(
			
			'name'      => 'required|unique:productmanufacturer,name,',
			
		
			
		);
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return Redirect::to('admin/manufacture/create')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {

				
	
				$amanufacture = new productmanufacturer;
				$amanufacture->name = Input::get('name');
				$amanufacture->created_by=Auth::user()->name.'('.Auth::user()->email.')';
				$amanufacture->save();

					
				Session::flash('status', $this->created_message);
				return Redirect::to('admin/manufacture');
			
	


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

		$manufacture = productmanufacturer::find($id);

		

		return View::make('admin.manufacture.edit',compact('manufacture'));
			   
	}

	public function update(Request $request ,$id)
	{
	

	
		$rules = array(
			
			'name'      => 'required|unique:productmanufacturer,name,'.$id,
			
			
		);

	
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return Redirect::to('admin/manufacture/' . $id . '/edit')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {

				$manufacture =  productmanufacturer::find($id);
				$manufacture->name = Input::get('name');
				
				$manufacture->save();

					
				Session::flash('status', $this->edit_message);
				return Redirect::to('admin/manufacture');
			
				
		


		}

	
	
	}

	public function destroy($id)
	{

        try
		{
			$user = productmanufacturer::findOrFail($id);

			if($user->delete())
			{
				
				Session::flash('status',  $this->delete_message);
			}
			else
			{
				Session::flash('error', 'something wrong');
			}
			return Redirect::to('admin/manufacture');
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

	public function get_vendor_product(Request $request)
    {

        $vendor_id = $request->vendor_id;

        $vendor =DB::table('vendors')->where('id',$vendor_id)->first();



        $products = DB::table('vendorproduct')->where('user_id',$vendor->user_id)->get();

         return Response::json($products);


    }
public function approve(){
	return view('admin.manufacture.approveedit');
}
public function approveman($id){
    $editmodel=editmanufecturer::find($id);
    $model=productmanufacturer::find($editmodel->menufecturer_id);
    $model->name=$editmodel->name;
    $model->save();
    $editmodel->delete();
    return back();
}
public function reject($id){
    $editmodel=editmanufecturer::find($id);
    $editmodel->delete();
    return back();
}


}