<?php

namespace App\Http\Middleware;

use Closure;

class LoginMiddleware
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
         // 未ログイン
         if(!session()->has('store_name')){
            return redirect(url('/'));
        }

        return $next($request);
    }
}
