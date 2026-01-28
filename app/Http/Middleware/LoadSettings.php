<?php

namespace App\Http\Middleware;

use App\Models\Hero;
use App\Models\IntroBlock;
use App\Models\Setting;
use App\Models\SocialMediaLink;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class LoadSettings
{
    private const CACHE_MISS = '__load_settings_cache_miss__';

    private const CACHE_NULL = '__load_settings_cache_null__';

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $settings = Cache::rememberForever('settings', function () {
                return Setting::first();
            });
            View::share('settings', $settings);
        } catch (\Exception $e) {
            View::share('settings', null);
        }

        try {
            $socialLinks = Cache::rememberForever('social_links', function () {
                return SocialMediaLink::where('is_active', true)
                    ->orderBy('sort_order')
                    ->get();
            });
            View::share('socialLinks', $socialLinks);
        } catch (\Exception $e) {
            View::share('socialLinks', collect());
        }

        try {
            $routeName = $request->route()?->getName();

            if (! $routeName) {
                $matched = Route::getRoutes()->match($request);
                $routeName = $matched->getName();
            }

            if (! $routeName && ($request->is('/') || $request->path() === '/')) {
                $routeName = 'home';
            }

            $pageIdentifier = $routeName ?: $request->path();

            $hero = $this->rememberNullable("hero:{$pageIdentifier}", function () use ($pageIdentifier) {
                return Hero::where('page_identifier', $pageIdentifier)->first();
            });
            View::share('hero', $hero);

            $intro = $this->rememberNullable("intro_block:{$pageIdentifier}", function () use ($pageIdentifier) {
                return IntroBlock::where('page_identifier', $pageIdentifier)->first();
            });
            View::share('intro', $intro);
        } catch (\Exception $e) {
            View::share('hero', null);
            View::share('intro', null);
        }

        return $next($request);
    }

    /**
     * Cache a value forever, including null results, to avoid repeated queries.
     *
     * Laravel's cache treats null as a miss, so we store a sentinel string
     * to distinguish "queried and found nothing" from "never queried".
     */
    private function rememberNullable(string $key, Closure $callback): mixed
    {
        $cached = Cache::get($key, self::CACHE_MISS);

        if ($cached === self::CACHE_MISS) {
            $value = $callback();
            Cache::forever($key, $value ?? self::CACHE_NULL);

            return $value;
        }

        return $cached === self::CACHE_NULL ? null : $cached;
    }
}
