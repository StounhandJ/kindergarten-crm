<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PositionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param $position
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $position)
    {
        if (!auth()->user()->checkPosition($position)) {
            abort(404);
        }
        return $next($request);
    }
}
