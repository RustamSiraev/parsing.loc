<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @param string $role
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!Auth::user()->hasRole($role)) {
            abort(404);
        }
        return $next($request);
    }
}
