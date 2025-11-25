<?php

namespace App\Http\Middleware;

use Closure;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $user_level)
    {
        $level = auth()->user()->level->level ;
        if($user_level != $level ){
            return redirect()->back();
        } 
        return $next($request);
    }
}
