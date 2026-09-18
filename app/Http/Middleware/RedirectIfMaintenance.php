<?php

namespace App\Http\Middleware;

use App\Models\SiteSetting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class RedirectIfMaintenance
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('admin', 'admin/*') || $request->routeIs('login', 'logout')) {
            return $next($request);
        }

        $user = $request->user();

        if ($user && $user->hasAbility('settings.view')) {
            return $next($request);
        }

        try {
            $maintenance = SiteSetting::isMaintenanceMode();
        } catch (Throwable) {
            $maintenance = false;
        }

        if ($maintenance) {
            return response()
                ->view('maintenance')
                ->setStatusCode(503);
        }

        return $next($request);
    }
}
