<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMatchReportsEnabled
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Use cached settings from LoadSettings middleware
        $settings = config('settings');

        if ($settings && ! ($settings->show_match_reports ?? false)) {
            abort(404);
        }

        return $next($request);
    }
}
