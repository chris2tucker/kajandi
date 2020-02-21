<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Role;
use Session;
use App\vendors;
use Illuminate\Support\Facades\Mail;
use App\Mail\validationMail;
use Illuminate\Support\Str;
use App\Notification;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user= User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        $notification = new Notification();
        $notification->user_id = 40;
        $notification->notification = $user->name ." is a new vendor added your website";
        $notification->vendor_id = $user->id;
        $notification->save();
    }



public function admin_register_form()
{

  return view('auth.admin.register', compact('view'));
}

public function register_admin(Request $request)
{

   

    $this->validate(request(), [

            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',

            ]);

    $role_admin = Role::where('name', 'Admin')->first();
    $user = new User;
    $user->email = $request->email;
    $user->password = bcrypt($request->password);
    $user->save();


    $user->roles()->attach($role_admin);

     
    return redirect()->to('admin/login');

}


public function admin_login_view()
{

   return view('auth.admin.login'); 
}


public function admin_login(Request $request)
{

     $this->validate($request, [

            'email' => 'required|email',

            'password' => 'required',

        ]);

     if (auth()->attempt(array('email' => $request->input('email'), 'password' => $request->input('password'))))
        {
            $user = \Auth::User();
            $userid = $user->id;
            $user_admin ='admin_user_'.$userid;
            Session::put('admin_user', $user_admin);
            return redirect()->to('admin/index');
        }else{

             return redirect()->to('admin/login');
        }

}




public function vendor_login_view()
{


     return view('auth.vendor.login');
}

public function vendor_login(Request $request)
{

    $this->validate($request, [

                'email' => 'required|email',

                'password' => 'required',

            ]);


         if (auth()->attempt(array('email' => $request->input('email'), 'password' => $request->input('password'))))
            {
                
                return redirect()->to('vendors/index');
            }else{
                $user=User::where('email','=',$request->input('email'))->first();
                if($user){
                    if($user->status==0){
                    return redirect()->to('vendor/login')->with('message','You are not able to login!Your account is under review');
                }
                else{
                    return redirect()->to('vendor/login')->with('message','Incorrect Email or password!');
                }
                }else{

                 return redirect()->to('vendor/login')->with('message','You are not able to login! You do not have an Account');
             }
            }
}

public function vender_register(Request $request){


        $this->validate(request(), [
            'image' => 'required',
            'vendorname' => 'required',
            'vendor_type' => 'required',
            'producttype' => 'required',
            'phone'=>'required',
            'location' => 'required',
            'country'=>'required',
            'state'=>'required',
            'address' => 'required',
            'personname' => 'required',
            'personphone' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed|min:6',
            'password_confirmation'=>'required',
            

            ]); 

        $role_vendor = Role::where('name', 'Vendor')->first();


        $user = new User;
        $user->email = request('email');
        $user->name = request('vendorname');
        $user->phone=request('phone');
        $user->user_type = 'Vendor';
        $user->password = bcrypt(request('password'));
        $user->verification_token=Str::random(60);
        $user->user_uniqueid=uniqid();
        $user->save();
       
        $user_id = $user->id;

        $user->roles()->attach($role_vendor);


        Mail::to($user->email)->send(new validationMail($user));
        $vendors = new vendors;
        $vendors->user_id = $user_id;
        $vendors->vendorname = request('vendorname');
        $vendors->address = request('address');
        $vendors->country = request('country');
        $vendors->state=request('state');
        $vendors->url = request('website');
        $vendors->cac = request('cac');
        $vendors->workforce = request('workforce');
        $vendors->yearsofexp = request('experience');
        $vendors->ratings = request('rating');
        $vendors->contactname = request('personname');
        $vendors->contactphone = request('personphone');
        $vendors->contactemail = request('personemail');
        $vendors->chairmanname = request('mdname');
        $vendors->chairmanemail = request('mdemail');
        $vendors->chairmanphone = request('mdphone');
        $vendors->password = bcrypt(request('password'));
        $vendors->producttype = request('producttype');
        $vendors->location = request('location');
        $vendors->vendor_type    = request('vendor_type');
        if ($request->hasFile('image')) {
                 $image = $request->file('image');
            $filename = time().'-'.$image->getClientOriginalName(). '.' . $image->getClientOriginalExtension();
            $path = base_path('img\products');
            $image->move($path, $filename);
            $images = $filename;

                $vendors->image        = $images;
                }
        $vendors->save();
         $notification = new Notification();
        $notification->user_id = 40;
        $notification->notification ="A is a new vendor added your website";
      //  $notification->vendor_id = Auth::User()->id;
        $notification->save();
        session()->flash('message', 'Vendor added successful! Application in under review');  
 
        return redirect('vendor/login');    
}



}
