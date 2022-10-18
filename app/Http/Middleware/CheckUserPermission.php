<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use Auth;
use Closure;
use Illuminate\Http\Request;

class CheckUserPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $perm)
    {
        if (!!Auth::user()->hasPermAnyWay($perm)) {
            abort(404);
        }
        return $next($request);
    }
}
