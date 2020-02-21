<?php

namespace App\Http\Middleware;

use Closure;
use Session;
class category
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $catagory= Session::get('catagory');
        if($catagory){
        return $next($request);
    }
    else{
         return redirect('/');
    }
    }
}
