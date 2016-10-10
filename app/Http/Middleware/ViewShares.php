<?php

namespace Pi\Http\Middleware;

use Closure;
use Pi\Auth\User;

class ViewShares
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
        $user = \Auth::user();

        view()->share('currentUser', $user);

        return $next($request);
    }
}
