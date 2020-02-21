<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\customersvendor;
use App\profilehistory;
use App\vendors;
use Illuminate\Support\Facades\Mail;
use App\Mail\acceptCustomerRequest;
use App\customersverification;
class SettingsController extends Controller
{
    public function settings()
    {
    	return view('vendors.settings.create');
    }

    public function update(Request $request)
    {
          $this->validate($request,[
            'email' => 'required|unique:users,email,'.Auth::User()->id,
            
        ]);
    	 $user = User::find(Auth::User()->id);

    	 if ($request->hasFile('image')) {
    	     $image = $request->file('image');
            $filename = time().'-'.$image->getClientOriginalName();
            $path = base_path('img/products');
            $image->move($path, $filename);
            $imagename = $filename;
	        }else {
	            $imagename = $user->image;
	        }
            $banner = $request->file('banner');
            if (isset($banner)) {
             $image = $request->file('banner');
            $filename = time().'-'.$image->getClientOriginalName();
            $path = base_path('img/products');
            $image->move($path, $filename);
            $bannername = $filename;
            }else {
                $bannername = $user->image;
            }
    	 
    	$user->name = $request->name;
    	$user->email = $request->email;
    	$user->phone = $request->phone;
    	$user->image = $imagename;
    	if ($request->password) {
    		$user->password = Hash::make($request->password);
    	}else{
    		$user->password = Auth::User()->password;
    	}
    	$user->user_type = Auth::User()->user_type;
    	$user->status = Auth::User()->status;
        $user->approve = null;
    	$user->save();
        $profile=vendors::where('user_id','=',Auth::user()->id)->first();
        if($profile){
           // $profile->vendor_id=$request->vendor_id;
           // $profile->user_id=Auth::user()->id;
            if($request->file('image')){
                $profile->image=$imagename;
            }
            if($request->file('banner')){
                $profile->banner=$bannername;
            }
            $profile->vendorname=$request->name;
            $profile->address=$request->address;
            $profile->country=$request->country;
            $profile->url=$request->website;
            $profile->state=$request->state;
            $profile->cac=$request->cac;
            $profile->workforce=$request->workforce;
            $profile->yearsofexp=$request->experience;
            $profile->ratings=$request->rating;
            $profile->vendor_type=$request->vendor_type;
            $profile->location=$request->location;
            $profile->producttype=$request->producttype;
            $profile->contactname=$request->contactname;
            $profile->contactphone=$request->contactphone;
            $profile->contactemail=$request->contactemail;
            $profile->chairmanname=$request->chairmanname;
            $profile->chairmanphone=$request->chairmanphone;
            $profile->chairmanemail=$request->chairmanemail;
            $profile->save();
        }
        else
        {
            $profile= new vendors;
            // $profile->vendor_id=$request->vendor_id;
            $profile->user_id=Auth::user()->id;
            $profile->vendorname=$request->name;
            $profile->address=$request->address;
            $profile->country=$request->country;
            $profile->url=$request->website;
            $profile->cac=$request->cac;
            $profile->workforce=$request->workforce;
            $profile->yearsofexp=$request->experience;
            $profile->ratings=$request->rating;
            $profile->vendor_type=$request->vendor_type;
            $profile->location=$request->location;
            $profile->producttype=$request->producttype;
            $profile->contactname=$request->contactname;
            $profile->contactphone=$request->contactphone;
            $profile->contactemail=$request->contactemail;
            $profile->chairmanname=$request->chairmanname;
            $profile->chairmanphone=$request->chairmanphone;
            $profile->chairmanemail=$request->chairmanemail;
            $profile->save();
        }
    	return back()->with('status','Your profile successfully updated');
    }
     public function customer_request()
    {
        $vendor_reject = customersvendor::where('vendor_id',Auth::User()->id)->where('status','pending')->get();

        return view('vendors.customer_reject',compact('vendor_reject'));
    }

    public function approve(Request $request,$id)
    {
        $customersvendor = customersvendor::find($id);
         $customersvendor->status = "yes";
        $customersvendor->limitted=$request->limit;
        $customersvendor->save();
         $custoemrvarification=customersverification::where('user_id','=',$customersvendor->customer_id)->first();
        $custoemrvarification->verification='yes';
        $custoemrvarification->save();
        $user=User::find($customersvendor->customer_id);
        $vendor=User::find($customersvendor->vendor_id);
         Mail::to($user->email)->send(new acceptCustomerRequest($vendor->name));
        return back()->with('status','Customer successfully approved');
    }
    public function reject(Request $request,$id){
        $customersvendor = customersvendor::find($id);
        $customersvendor->status = "declined";
        $customersvendor->reason=$request->orderstatus;
        $customersvendor->save();
       
        return back()->with('status','Customer successfully Rejected');
    }
}
