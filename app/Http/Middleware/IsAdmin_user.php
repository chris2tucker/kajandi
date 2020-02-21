<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Illuminate\Support\Facades\Auth;

use App\User;

class IsAdmin_user
{
    public function handle($request, Closure $next,$guard = null)
    {
    	 $user = \Auth::User();
    	 if($user)
    	 {
         $user_role = $user->roles()->first();

        if ($user_role->name=='Admin'){
            return $next($request);
        }
    }
        return redirect('/admin/login');
        
    }
}
