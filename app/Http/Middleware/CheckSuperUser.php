<?php

namespace App\Http\Middleware;

use Closure;

class CheckSuperUser
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

      if( !$request->user()->super ){

        abort(403, 'Access denied');

      }

        return $next($request);
    }
}
