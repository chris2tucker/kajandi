<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Illuminate\Support\Facades\Auth;

use App\User;

class ecommerace
{
    public function handle($request, Closure $next,$guard = null)
    {
    	 $user = \Auth::User();
    	 if($user)
    	 {
         $user_role = $user->roles()->first();

        if ($user_role && $user_role->name=='Vendor'){
            return redirect('/vendors/index');
        }
        else{
            return $next($request);
        }
    }
    else{
        return $next($request);
        
    }
        
    }
}
