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
     * @param string[]|string $positions
     * @return mixed
     */
    public function handle(Request $request, Closure $next, array|string ...$positions)
    {
        if (count($positions)==0)
            $positions = ["director", "senior_tutor", "tutor", "cook"];
        if (auth()->check() && auth()->user()->checkPosition($positions)) {
            return $next($request);
        }
        elseif (auth()->check())
        {
            abort(403);
        }
        return redirect("login");
    }
}
