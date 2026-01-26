<?php

namespace App\Http\Middleware;

use App\Models\Hero;
use App\Models\IntroBlock;
use App\Models\Setting;
use App\Models\SocialMediaLink;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class LoadSettings
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $settings = Setting::first();
            View::share('settings', $settings);
        } catch (\Exception $e) {
            View::share('settings', null);
        }

        try {
            $socialLinks = SocialMediaLink::where('is_active', true)
                ->orderBy('sort_order')
                ->get();
            View::share('socialLinks', $socialLinks);
        } catch (\Exception $e) {
            View::share('socialLinks', collect());
        }

        try {
            $routeName = $request->route() ? $request->route()->getName() : Route::currentRouteName();

            if (! $routeName && ($request->is('/') || $request->path() === '/')) {
                $routeName = 'home';
            }

            if ($routeName) {
                $hero = Hero::where('page_identifier', $routeName)->first();
                View::share('hero', $hero);

                $intro = IntroBlock::where('page_identifier', $routeName)->first();
                View::share('intro', $intro);
            } else {
                // Fallback for pages without route names (if any)
                $path = $request->path();
                $hero = Hero::where('page_identifier', $path)->first();
                View::share('hero', $hero);

                $intro = IntroBlock::where('page_identifier', $path)->first();
                View::share('intro', $intro);
            }
        } catch (\Exception $e) {
            View::share('hero', null);
            View::share('intro', null);
        }

        return $next($request);
    }
}
