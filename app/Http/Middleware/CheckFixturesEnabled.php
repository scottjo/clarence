<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckFixturesEnabled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Use cached settings from LoadSettings middleware instead of querying database
        $settings = config('settings');

        if ($settings && ! ($settings->show_fixtures_results ?? true)) {
            abort(404);
        }

        return $next($request);
    }
}
