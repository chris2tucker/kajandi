<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\productmodel;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\editmodel;
class ModelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $model = productmodel::where('user_id',Auth::User()->id)->get();
        return view('vendors.model.index',compact('model'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vendors.model.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $this->validate($request,[
            'name' => 'required|unique:productmodel,name'
        ]);     
    
        $model = new productmodel;
        $model->name = Input::get('name');
        $model->user_id = Auth::User()->id;
        $model->created_by=Auth::user()->name.'('.Auth::user()->email.')';
        $model->isedit=1;
        $model->save();

            
        Session::flash('status', 'model suessfully created');
        return redirect('vendors/model');

    


        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = productmodel::find($id);
        return view('vendors.model.edit',compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $this->validate($request,[
            'name' => 'required|unique:productmodel,name,'.$id,
        ]);     
    
        $model = productmodel::find($id);
       // $model->name = Input::get('name');
       // $model->user_id = Auth::User()->id;
        $model->isedit=1;
        $model->save();
            $editManufecturer=editmodel::where('model_id','=',$model->id)->first();
                if($editManufecturer){
                    $editManufecturer->name=$request->get('name');
                    $editManufecturer->created_by=Auth::user()->name.'('.Auth::user()->email.')';
                    $editManufecturer->save();
                }
                else{
                    $editman=new editmodel;
                    $editman->name=$request->get('name');
                     $editManufecturer->created_by=Auth::user()->name.'('.Auth::user()->email.')';
                    $editman->model_id=$model->id;
                    $editman->save();
                }
            
        Session::flash('status', 'model suessfully updated');
        return redirect('vendors/model');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $model = productmodel::find($id);
         $model->delete();
         Session::flash('status', 'model suessfully deleted');
         return back();
    }
}
