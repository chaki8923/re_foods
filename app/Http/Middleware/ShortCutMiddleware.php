<?php

namespace App\Http\Middleware;

use Closure;

class ShortCutMiddleware
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

        $id = $request->session()->get('id');
        if(session()->has('store_name')){
            return redirect()->route('action',$id);
        }
        return $next($request);
    }
}
