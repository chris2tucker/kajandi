<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\category;
use App\subcategory;
use App\vendors;
use App\User;
use App\productmodel;
use App\products;
use App\condition;
use App\productmanufacturer;
use App\productaddon;
use App\source;
use App\strengthofmaterial;
use App\productimages;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

	public function index()
    {
    	return view('subadmin.index');
    }

}