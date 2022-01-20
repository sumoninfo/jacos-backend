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
        $app_key    = $request->header('app_key');
        $app_secret = $request->header('app_secret');
        $agent      = new Agent();
        if ($agent->isMobile()) {
            if ($agent->platform() == 'iOS') {
                if ($app_key != config('devicecheck.web.key') && $app_secret != config('devicecheck.web.secret')) {
                    return response()->json(['error' => 'Unauthenticated.'], 401);
                }
            } elseif ($agent->platform() == 'AndroidOS') {
                if ($app_key != config('devicecheck.web.key') && $app_secret != config('devicecheck.web.secret')) {
                    return response()->json(['error' => 'Unauthenticated.'], 401);
                }
            }
        } elseif ($agent->isDesktop()) {
            if ($app_key != config('devicecheck.web.key') && $app_secret != config('devicecheck.web.secret')) {
                return response()->json(['error' => 'Unauthenticated.'], 401);
            }
        }
        return $next($request);
    }
}
