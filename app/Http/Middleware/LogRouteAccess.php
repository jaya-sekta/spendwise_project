<?php

namespace App\Http\Middleware;

use App\Models\RouteLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LogRouteAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            RouteLog::create([
                'user_id'    => Auth::id(),
                'route_name' => optional($request->route())->getName(),
                'url'        => $request->path(),
                'method'     => $request->method(),
            ]);
        }

        return $next($request);
    }
}