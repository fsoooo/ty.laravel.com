<?php

namespace App\Http\Middleware;

use App\Models\Agent;
use Closure;
use Illuminate\Support\Facades\Auth;
use URL;

class IsAgent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(isset($_COOKIE['agent']))
        {
            return $next($request);
        }else{
            return redirect('/agent_login?redirect='.URL::full());
        }
    }
}
