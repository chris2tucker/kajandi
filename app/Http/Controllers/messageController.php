<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\message;
use Auth;
use App\User;
class messageController extends Controller
{
	public function index(){
		return view('vendors.messages.index');
	}
    public function create(Request $request){
    	$message=new message;
    	$message->sent_user_id=$request->sender;
    	$message->receiver_user_id=$request->receiver;
    	$message->mesage=$request->message;
        $message->customer_id=Auth::user()->id;
    	$message->save();
    	return back();
    }
    public function user($id){
    	$sender_id=$id;
    	$receiver_id=Auth::user()->id;
    	$messages=message::where('sent_user_id','=',$sender_id)->where('receiver_user_id','=',$receiver_id)->orwhere(function($query) use ($receiver_id,$sender_id){
			$query->where('sent_user_id','=',$receiver_id)->where('receiver_user_id','=',$sender_id);
		})->get();

		$user=User::find($id);
    	return view('vendors.messages.users',compact('messages','user'));
    }
    public function reply(Request $request,$id){
    	$message=new message;
    	$message->sent_user_id=Auth::user()->id;
    	$message->receiver_user_id=$id;
    	$message->mesage=$request->message;
        $message->vendor_id=Auth::user()->id;
    	$message->save();
    	return back();
    }
    public function admin(){
        $vendors=message::where('vendor_id','!=',NULL)->groupBy('vendor_id')->get();
        

        return view('admin.messages.index',compact('vendors'));
    }
    public function customer_list($id){
        $vendors=message::where('vendor_id','!=',NULL)->groupBy('vendor_id')->get();
        $customers=message::where('customer_id','!=',NULL)->where(function($query) use($id){
            $query->orwhere('sent_user_id','=',$id)->orwhere('receiver_user_id','=',$id);
        })->groupBy('customer_id')->get();
        return view('admin.messages.customers',compact('vendors','customers'));
    }
    public function customer_message($vendor_id,$cus_id){
        $vendors=message::where('vendor_id','!=',NULL)->groupBy('vendor_id')->get();
        $customers=message::where('customer_id','!=',NULL)->where(function($query) use($cus_id){
            $query->orwhere('sent_user_id','=',$cus_id)->orwhere('receiver_user_id','=',$cus_id);
        })->groupBy('customer_id')->get();
        $messages=message::where('sent_user_id','=',$vendor_id)->where('receiver_user_id','=',$cus_id)->orwhere(function($query) use ($vendor_id,$cus_id){
            $query->where('sent_user_id','=',$cus_id)->where('receiver_user_id','=',$vendor_id);
        })->get();
        return view('admin.messages.list',compact('vendors','customers','messages','vendor_id','cus_id'));
    }
    public function unreadVendors(Request $request){
        $vendor=$request->get('user');
        $notifications='';
       $messages=message::where('vendor_id','=',NULL)->where('isread','=',0)->where(function($query) use($vendor){
            $query->orwhere('sent_user_id','=',$vendor)->orwhere('receiver_user_id','=',$vendor);
        })->get();
       if(count($messages)>0){
        foreach ($messages as $value) {
            $user=User::find($value->customer_id);
            $notifications .='<a href="'. $request->root() .'/vendor/message/'. $value->customer_id .'"><li class="bell messages">'.$user->name.' Sent a message</li></a><hr>';
        }
       }
         $data = array(
        'table_data'  => $notifications,'counts'=>count($messages)
        );
       return $data;
    }
    public function unreadcustomer(Request $request){
        $vendor=$request->get('user');
        $notifications='';
       $messages=message::where('customer_id','=',NULL)->where('isread','=',0)->where(function($query) use($vendor){
            $query->orwhere('sent_user_id','=',$vendor)->orwhere('receiver_user_id','=',$vendor);
        })->get();
       if(count($messages)>0){
        foreach ($messages as $value) {
            $user=User::find($value->vendor_id);
            $notifications .=' <li class="messages"><a href="'. $request->root() .'/vendors/'. $value->vendor_id .'"> <span class="text-left" style="padding-right: 4px"></span>'.$user->name.' Sent a message </a> </li>';
        }
       }
         $data = array(
        'table_data'  => $notifications,'counts'=>count($messages)
        );
       return $data;
    }
}
