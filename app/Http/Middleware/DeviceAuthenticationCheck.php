<?php

namespace App\Http\Middleware;

use Closure;
use Jenssegers\Agent\Agent;

class DeviceAuthenticationCheck
{
    //Web Credentials
    const WEB_APP_KEY    = 'web_app_key';
    const WEB_APP_SECRET = 'web_app_secret';

    //Android Credentials
    const ANDROID_APP_KEY    = 'android_app_key';
    const ANDROID_APP_SECRET = 'android_app_secret';

    //iOS Credentials
    const IOS_APP_KEY    = 'ios_app_key';
    const IOS_APP_SECRET = 'ios_app_secret';

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
                if ($request->header('app_key') != self::IOS_APP_KEY
                    && $request->header('app_secret') != self::IOS_APP_SECRET) {
                    return response()->json(['error' => 'Unauthenticated.'], 401);
                }
            } elseif ($agent->browser() == 'AndroidOS') {
                if ($request->header('app_key') != self::ANDROID_APP_KEY
                    && $request->header('app_secret') != self::ANDROID_APP_SECRET) {
                    return response()->json(['error' => 'Unauthenticated.'], 401);
                }
            }
        } elseif ($agent->isDesktop()) {
            if ($request->header('app_key') != self::WEB_APP_KEY
                && $request->header('app_secret') != self::WEB_APP_SECRET) {
                return response()->json(['error' => 'Unauthenticated.'], 401);
            }
        }
        return $next($request);
    }
}
