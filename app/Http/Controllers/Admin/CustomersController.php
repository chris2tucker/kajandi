<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facade;
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
use App\customersvendor;
use App\productimages;
use App\Role;
use App\carts;
use App\ordersdetail;
use App\orders;
use App\workplace;
use App\review;
use App\orderpayment;
use App\wallet;
use App\wallethistory;
use App\walletusers;
use App\outstandingpayment;
use App\customersverification;
use Cart;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Customer_QA;
use Response;
use App\Customer;
use App\Http\Controllers\Controller;
use View;
use Session;
use Illuminate\Support\Facades\Redirect;
class CustomersController extends Controller
{


	protected $created_message = "Successfully created Customer!";
    protected $edit_message = "Successfully update Customer!";
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

   

        return View::make('admin.customer.index',compact('adv_sec_1_data'));
            
    }


    public function create()
    {
        $user = \Auth::User();
        $userid = $user->id;
        
       
    

         
        return View::make('admin.customer.create');
    }

    
    public function store(Request $request)
    {
        /*if(!\Auth::User()->can('workstation_manage')) //only admin allow on this page
            return redirect('admin/home')->withErrors(['msg'=> $this->notallow]);*/
        $user = \Auth::User();
        $userid = $user->id;

                $this->validate(request(), [
                    'name' => 'required',
                    'email' => 'required|email|unique:users',
                    'password' => 'required|confirmed|min:6',
                    'company_name' => 'required',
                    


                    ]);

                $email = request('email');
                $password = request('password');
                $name = request('name');

                $role_customer = Role::where('name', 'Customer')->first();

                $user = new User;
                $user->name = $name;
                $user->email = $email;
                $user->password = Hash::make($password);
                $user->user_type = 'Customer';
                $user->status=1;
                $user->verify=1;
                if($user->save())
                 {
                    $customer = new Customer;
                    $customer->company_name = request('company_name');
                    $customer->name = $name;
                    $customer->user_id = $user->id;
                    $customer->user_type='Customer';
                    $customer->about = request('about_company');
                    $customer->website = request('website_url');
                    $customer->cac = request('cac_number');
                    $customer->businesstype = request('type_of_business');
                    $customer->yearsofexitence = request('year_of_existence');
                    $customer->mdtel = request('phone_of_MD_Chairman');
                    $customer->mdemail = request('email_of_MD_Chairman');
                    $customer->contactpersontel = request('phone_of_contact_person');
                    $customer->contactpersonemail  = request('email_of_contact_person');
                    $customer->company_rating  = request('company_rating');
                     $customer->country=request('country');
                    $customer->state=request('state');
                    $customer->city=request('city');
                     $customer->billing_country=request('billing_country');
                    $customer->billing_state=request('billing_state');
                    $customer->billing_city=request('billing_city');
                    $customer->address=request('address');
                    $customer->billing_address=request('billing_address');
                    $customer->save();


                 }

                $user->roles()->attach($role_customer);

                    
                Session::flash('status', $this->created_message);
                return Redirect::to('admin/customers');
            
    


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

        $customer = Customer::where('user_id',$id)->first();
        $user = User::where('id', $customer->user_id)->first();
//dd($user);

        

        return View::make('admin.customer.edit',compact('customer','user'));
               
    }

    public function update(Request $request ,$id)
    {
    
        $customer = Customer::where('id',$id)->first();
        $user = User::where('id', $customer->user_id)->first();
        
    
        $this->validate(request(), [
                    'name' => 'required',
                   
                    
                    'company_name' => 'required',
                    'about_company' => 'required',
                  /*  'website_url' => 'required',
                    'cac_number' => 'required',
                    'type_of_business' => 'required',
                    'year_of_existence' => 'required',
                    'phone_of_MD_Chairman' => 'required',
                    'email_of_MD_Chairman' => 'required',
                    'phone_of_contact_person' => 'required',
                    'email_of_contact_person' => 'required',
                    'company_rating' => 'required',*/


                    ]);

                $email = request('email');
                $password = request('password');
                $name = request('name');

                $role_customer = Role::where('name', 'Customer')->first();

                $user = User::find($user->id);

                $user->name = $name;
                $user->email = $email;
                $user->password = Hash::make($password);
                $user->user_type = 'Customer';
                if($user->save())
                 {
                    $customer = Customer::find($customer->id);
                    $customer->company_name = request('company_name');
                    $customer->name = $name;
                    $customer->user_id = $user->id;
                    $customer->user_type='Customer';
                    $customer->about = request('about_company');
                    $customer->website = request('website_url');
                    $customer->cac = request('cac_number');
                    $customer->businesstype = request('type_of_business');
                    $customer->yearsofexitence = request('year_of_existence');
                    $customer->mdtel = request('phone_of_MD_Chairman');
                    $customer->mdemail = request('email_of_MD_Chairman');
                    $customer->contactpersontel = request('phone_of_contact_person');
                    $customer->contactpersonemail  = request('email_of_contact_person');
                    $customer->company_rating  = request('company_rating');
                    $customer->country=request('country');
                    $customer->state=request('state');
                    $customer->city=request('city');
                     $customer->billing_country=request('billing_country');
                    $customer->billing_state=request('billing_state');
                    $customer->billing_city=request('billing_city');
                      $customer->address=request('address');
                    $customer->billing_address=request('billing_address');
                    $customer->save();


                 }


                     
                Session::flash('status', $this->edit_message);
                return Redirect::to('admin/customers');

    
    
    }

    public function destroy($id)
    {
    /*if(!\Auth::User()->can('workstation_manage')) //only admin allow on this page
            return redirect('admin/home')->withErrors(['msg'=> $this->notallow]);*/
            $customers = Customer::where('user_id',$id)->first();


           $users = User::where('id', $customers->user_id)->first();


        try
        {
            $customer = Customer::findOrFail($customers->id);

            if($customer->delete())
            {
                 $user = User::find($users->id);
                 $user->delete();
                Session::flash('status',  $this->delete_message);
            }
            else
            {
                Session::flash('error', 'something wrong');
            }
            return Redirect::to('admin/customers');
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































