<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\outstandingpayment;
use App\User;
use App\ordersdetail;
use App\vendorproduct;
use App\vendors;
use App\products;
class OutstandingController extends Controller
{
    public function index()
    {
    	    $num = 0;
            $view = '';
            $validwallet = '';
            $myurl =  asset('/');
           

                $getoutstandingpayment = outstandingpayment::all();

                foreach ($getoutstandingpayment as $keys) {

                    $user = User::where('id', $keys->user_id)->first();

                    $num += 1;

                    $key = ordersdetail::where('ordernumber', $keys->ordernumber)->first();

                    $outstandingpayment = outstandingpayment::where('id', $keys->id)->first();
                    $duetotal = $outstandingpayment->totalprice;
                    

                $payoptions = '';
                if ($key->payoptions != '1') {
                        if ($key->payoptions == '2') {
                            $payoptions = '<br>15 days Payment';
                        }elseif ($key->payoptions == '3') {
                            $payoptions = '<br>30 days Payment';
                        }
                    }

                $view .= "
                            <tr style='font-size: 14px'>";              
                   $getproducts = vendorproduct::where('id', $key->product_id)->first();
                   $vendorname = vendors::where('user_id', $getproducts->user_id)->first();
                $products = products::where('id', $getproducts->product_id)->first();
                   if(!empty($getproducts->image)){
                    $image = $getproducts->image;
                    }
                    else{
                        $image = $products->image;
                    }

//                    if (!empty($key->workplace_id)) {
//                        $workplace = workplace::where('user_id', Auth::user()->id)->where('id', $key->workplace_id)->first();
//
//                        $workplacename = $workplace->name;
//                    }else{
//                        $workplacename = '';
//                    }

                    $price = number_format($key->totalprice);
                $description = str_limit($getproducts->remark, 120);
                $unitprice = number_format($key->price);

                if ($key->deliverystatus != 'delivered') {
                    $delivery = "<button class='btn btn-xs btn-danger'>Pending</button>";
                }else{
                    $delivery = "<h5 class='bg-success' style='padding: 5px; text-align: center'>Delivered on ".$key->deliverydate."</h5>";
                }

                    $view .= "<td>$num</td>
                            <td>$key->ref_id</td>
                            <td><a href='$myurl/admin/viewcustomers/$user->id'>$user->name</a></td>

                            <td class='table-shopping-cart-img'>

                                <a href='$myurl/product/$getproducts->slog' style='color: #000'>
                                <div class='col-md-2'>
                                <img src='$myurl/$image' alt='Image Alternative text' title='Image Title' style='width: 40px' />
                                </div>
                                <div class='col-md-10'>
                                    <p style='font-size: 14px'><strong>$products->name</strong><br>
                                    $description</p>
                                    <p>".HomeController::converter($key->price)." X $key->quantity = ".HomeController::converter($key->totalprice)." $payoptions</p> 
                                    <p style='color: #8D8A97 !important'>Product Properties: Color $key->color</p>
                                </div>
                                </a>
                            </td>
                            <td>".HomeController::converter($key->totalprice)."</td>
                            <td>$keys->dateordered</td>
                            <td>$keys->duedate</td>
                            <td>$keys->payment</td>";
                $view .= "</tr>";

                }


            return view('vendors.outstanding',compact('view'));
    }
}
