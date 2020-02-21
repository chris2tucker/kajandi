<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Bankdetails;
use App\User;

class ApproveController extends Controller
{
    public function approve()
    {
    	$bankdetails = Bankdetails::where('status',null)->get();
    	return view('admin.approve.bank',compact('bankdetails'));
    }

    public function user()
    {
    	$users = User::Where('approve',null)->get();
    	return view('admin.approve.user',compact('users'));
    }

    public function store($id)
    {
    	$bankdetails = Bankdetails::find($id);
    	$bankdetails->status = 'approve';
    	$bankdetails->save();
    	return back()->with('status','Bankdetails suessfully approved');
    }
    public function user_approve($id)
    {
    	$user = User::find($id);
    	$user->approve = 'approve';
    	$user->save();
    	return back()->with('status','User suessfully approveds');
    }
}
