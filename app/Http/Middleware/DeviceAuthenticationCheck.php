<?php

namespace App\Http\Middleware;

use Closure;
use Jenssegers\Agent\Agent;

class DeviceAuthenticationCheck
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $agent = new Agent();
        if ($agent->isMobile()) {
            if ($agent->browser() == 'iOS') {
                if ($request->header('app_key') != config('devicecheck.web.key')
                    && $request->header('app_secret') != config('devicecheck.web.secret')) {
                    return response()->json(['error' => 'Unauthenticated.'], 401);
                }
            } elseif ($agent->browser() == 'AndroidOS') {
                if ($request->header('app_key') != config('devicecheck.web.key')
                    && $request->header('app_secret') != config('devicecheck.web.secret')) {
                    return response()->json(['error' => 'Unauthenticated.'], 401);
                }
            }
        } elseif ($agent->isDesktop()) {
            if ($request->header('app_key') != config('devicecheck.web.key')
                && $request->header('app_secret') != config('devicecheck.web.secret')) {
                return response()->json(['error' => 'Unauthenticated.'], 401);
            }
        }
        return $next($request);
    }
}
