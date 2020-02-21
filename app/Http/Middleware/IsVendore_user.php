<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Illuminate\Support\Facades\Auth;

class IsVendore_user
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$guard = null)
    {
        $user = \Auth::User();
         if($user)
         {
         $user_role = $user->roles()->first();

        if ($user_role->name=='Vendor'){
            return $next($request);
        }
    }
        return redirect('vendor/login');
    }
}
