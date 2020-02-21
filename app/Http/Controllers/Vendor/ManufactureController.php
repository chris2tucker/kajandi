<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\productmanufacturer;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\editmanufecturer;
class ManufactureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $manufacture = productmanufacturer::where('user_id',Auth::User()->id)->get();
   

        return view('vendors.manufacture.index',compact('manufacture'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('vendors.manufacture.create');
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
            'name' => 'required|unique:productmanufacturer,name',
        ]);     
    
        $manufacture = new productmanufacturer();
        $manufacture->name = Input::get('name');
        $manufacture->user_id = Auth::User()->id;
        $manufacture->created_by=Auth::user()->name.'('.Auth::user()->email.')';
        $manufacture->save();

            
        Session::flash('status', 'manufacture suessfully created');
        return redirect('vendors/manufacture');
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
        $manufacture = productmanufacturer::find($id);
        return view('vendors.manufacture.edit',compact('manufacture'));
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
            'name' => 'required|unique:productmanufacturer,name,' . $id
        ]);     
    
        $manufacture =  productmanufacturer::find($id);
       // $manufacture->name = Input::get('name');
        //$manufacture->user_id = Auth::User()->id;
        $manufacture->isedit=1;
        $manufacture->save();
         $editManufecturer=editmanufecturer::where('menufecturer_id','=',$manufacture->id)->first();
                if($editManufecturer){
                    $editManufecturer->name=$request->get('name');
                     $editManufecturer->created_by=Auth::user()->name.'('.Auth::user()->email.')';
                    $editManufecturer->save();
                }
                else{
                    $editman=new editmanufecturer;
                    $editman->name=$request->get('name');
                    $editman->menufecturer_id=$manufacture->id;
                     $editManufecturer->created_by=Auth::user()->name.'('.Auth::user()->email.')';
                    $editman->save();
                }
            
        Session::flash('status', 'manufacture suessfully updated');
        return redirect('vendors/manufacture');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        productmanufacturer::find($id)->delete();
         Session::flash('status', 'manufacture suessfully deleted');
         return back();
    }
}
