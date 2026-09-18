<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminHasAbility
{
    public function handle(Request $request, Closure $next, string ...$abilities): Response
    {
        $user = $request->user();

        foreach ($abilities as $ability) {
            if (! $user->hasAbility($ability)) {
                abort(403, 'Anda tidak memiliki akses ke bagian ini.');
            }
        }

        return $next($request);
    }
}
