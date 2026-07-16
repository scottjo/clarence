<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? ($settings?->club_name ?? 'Clarence Bowls Club') }}</title>
    <meta name="description" content="{{ $metaDescription ?? ($settings?->description ?? 'Clarence Bowls Club is a friendly lawn bowls club located in Clarence Park, Weston-super-Mare. Join us for competitive and social bowling.') }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $title ?? ($settings?->club_name ?? 'Clarence Bowls Club') }}">
    <meta property="og:description" content="{{ $metaDescription ?? ($settings?->description ?? 'Join Clarence Bowls Club in Weston-super-Mare.') }}">
    @if($settings?->hasMedia('header_logo'))
        <meta property="og:image" content="{{ $settings->getFirstMediaUrl('header_logo') }}">
    @elseif($settings?->header_logo)
        <meta property="og:image" content="{{ Storage::url($settings->header_logo) }}">
    @endif

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $title ?? ($settings?->club_name ?? 'Clarence Bowls Club') }}">
    <meta property="twitter:description" content="{{ $metaDescription ?? ($settings?->description ?? 'Join Clarence Bowls Club in Weston-super-Mare.') }}">
    @if($settings?->hasMedia('header_logo'))
        <meta property="twitter:image" content="{{ $settings->getFirstMediaUrl('header_logo') }}">
    @elseif($settings?->header_logo)
        <meta property="twitter:image" content="{{ Storage::url($settings->header_logo) }}">
    @endif

    <!-- Structured Data -->
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "SportsOrganization",
        "name": "{{ $settings?->club_name ?? 'Clarence Bowls Club' }}",
        "url": "{{ config('app.url') }}",
        {!! $settings?->hasMedia('header_logo') ? '"logo": "' . $settings->getFirstMediaUrl('header_logo') . '",' : ($settings?->header_logo ? '"logo": "' . Storage::url($settings->header_logo) . '",' : '') !!}
        "address": {
            "@@type": "PostalAddress",
            "streetAddress": "Clarence Park",
            "addressLocality": "Weston-super-Mare",
            "postalCode": "BS23 4BN",
            "addressCountry": "GB"
        }
        {!! ($settings?->latitude && $settings?->longitude) ? ',"geo": { "@@type": "GeoCoordinates", "latitude": "' . $settings->latitude . '", "longitude": "' . $settings->longitude . '" }' : '' !!}
    }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @cookieconsentscripts
</head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id={{ config('app.google.analytics_tag') }}"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', '{{ config('app.google.analytics_tag') }}');
</script>
<body class="text-gray-900 font-sans antialiased dark:text-gray-100"
      style="
        --page-bg: {{ $settings?->page_bg_color ?? '#f9fafb' }};
        --page-bg-dark: {{ $settings?->page_bg_color_dark ?? '#111827' }};
        background-color: var(--page-bg);
      "
      x-data="{ mobileMenuOpen: false }">
    <style>
        @media (prefers-color-scheme: dark) {
            body {
                background-color: var(--page-bg-dark) !important;
            }
        }
    </style>
    <header class="sticky top-0 z-50 shadow-sm border-b border-gray-200 dark:border-gray-700"
            style="
                background: {{ ($settings?->header_gradient_start && $settings?->header_gradient_end) ? 'linear-gradient(' . ($settings->header_gradient_direction?->value ?? 'to right') . ', ' . $settings->header_gradient_start . ', ' . $settings->header_gradient_end . ')' : ($settings?->menu_color ?? '#ffffff') }};
                color: {{ $settings?->menu_text_color ?? 'inherit' }}
            ">
        <nav class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center gap-3 text-2xl font-bold" style="color: {{ $settings?->menu_text_color ?? '#2563eb' }}">
                    @if($settings?->hasMedia('header_logo'))
                        <img src="{{ $settings->getFirstMediaUrl('header_logo') }}" alt="{{ $settings->club_name }} Logo" class="h-10 w-auto object-contain">
                    @elseif($settings?->header_logo)
                        <img src="{{ Storage::url($settings->header_logo) }}" alt="{{ $settings->club_name }} Logo" class="h-10 w-auto object-contain">
                    @else
                        <img src="{{ asset('images/logo.png') }}" alt="Clarence Bowls Club Logo" class="h-10 w-auto object-contain">
                    @endif
                    <span>{{ $settings?->club_name ?? 'Clarence Bowls Club' }}</span>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex gap-6 items-center">
                    <a href="{{ route('home') }}" class="hover:opacity-75 transition">Home</a>

                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave.debounce.100ms="open = false">
                        <button type="button" @click="open = !open" class="flex items-center gap-1 hover:opacity-75 transition focus:outline-none">
                            About Us
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                            </svg>
                        </button>
                        <div x-show="open"
                             x-cloak
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute left-0 mt-0 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-2 z-50 border border-gray-100 dark:border-gray-700">
                            <a href="{{ route('about') }}" class="block px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 transition text-gray-900 dark:text-gray-100">General Info</a>
                            <a href="{{ route('about.location') }}" class="block px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 transition text-gray-900 dark:text-gray-100">Location</a>
                            <a href="{{ route('about.officers') }}" class="block px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 transition text-gray-900 dark:text-gray-100">Club Officers</a>
                            <a href="{{ route('about.facilities') }}" class="block px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 transition text-gray-900 dark:text-gray-100">Facilities</a>
                            <a href="{{ route('about.play-learn') }}" class="block px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 transition text-gray-900 dark:text-gray-100">Play & Learn</a>
                            <a href="{{ route('about.membership') }}" class="block px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 transition text-gray-900 dark:text-gray-100">Membership</a>
                            <a href="{{ route('about.history') }}" class="block px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 transition text-gray-900 dark:text-gray-100">Club History</a>
                            <a href="{{ route('about.competition') }}" class="block px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 transition text-gray-900 dark:text-gray-100">Club Competition</a>
                            <a href="{{ route('about.competition-winners') }}" class="block px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 transition text-gray-900 dark:text-gray-100">Club Competition Winners</a>
                        </div>
                    </div>

                    @if($settings?->show_league_tables && count($navLeagues) > 0)
                        <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave.debounce.100ms="open = false">
                            <button type="button" @click="open = !open" class="flex items-center gap-1 hover:opacity-75 transition focus:outline-none">
                                Leagues
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                    <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                                </svg>
                            </button>
                            <div x-show="open"
                                 x-cloak
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute left-0 mt-0 w-56 bg-white dark:bg-gray-800 rounded-md shadow-lg py-2 z-50 border border-gray-100 dark:border-gray-700">
                                @foreach($navLeagues as $league)
                                    <a href="{{ route('league-tables.show', $league->slug) }}" class="block px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 transition text-gray-900 dark:text-gray-100">{{ $league->short_name ?: $league->name }}</a>
                                @endforeach
                                <hr class="my-1 border-gray-100 dark:border-gray-700">
                                <a href="{{ route('league-tables.index') }}" class="block px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 transition text-gray-900 dark:text-gray-100 italic">All League Tables</a>
                            </div>
                        </div>
                    @endif

                    @if($settings?->show_fixtures_results ?? true)
                        <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave.debounce.100ms="open = false">
                            <button type="button" @click="open = !open" class="flex items-center gap-1 hover:opacity-75 transition focus:outline-none">
                                Fixtures
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                    <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                                </svg>
                            </button>
                            <div x-show="open"
                                 x-cloak
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute left-0 mt-0 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-2 z-50 border border-gray-100 dark:border-gray-700">
                                <a href="{{ route('fixtures.info') }}" class="block px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 transition text-gray-900 dark:text-gray-100">Fixture Information</a>
                                <hr class="my-1 border-gray-100 dark:border-gray-700">
                                <a href="{{ route('fixtures', ['type' => 'Clarence Men']) }}" class="block px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 transition text-gray-900 dark:text-gray-100">Clarence Men</a>
                                <a href="{{ route('fixtures', ['type' => 'Clarence Women']) }}" class="block px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 transition text-gray-900 dark:text-gray-100">Clarence Women</a>
                                <a href="{{ route('fixtures', ['type' => 'Competitions']) }}" class="block px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 transition text-gray-900 dark:text-gray-100">Competitions</a>
                            </div>
                        </div>
                        <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave.debounce.100ms="open = false">
                            <button type="button" @click="open = !open" class="flex items-center gap-1 hover:opacity-75 transition focus:outline-none">
                                Results
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                    <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                                </svg>
                            </button>
                            <div x-show="open"
                                 x-cloak
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute left-0 mt-0 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-2 z-50 border border-gray-100 dark:border-gray-700">
                                <a href="{{ route('results') }}" class="block px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 transition text-gray-900 dark:text-gray-100">All Results</a>
                                <hr class="my-1 border-gray-100 dark:border-gray-700">
                                <a href="{{ route('results', ['type' => 'County League']) }}" class="block px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 transition text-gray-900 dark:text-gray-100">County League</a>
                                <a href="{{ route('results', ['type' => 'Over 55s League']) }}" class="block px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 transition text-gray-900 dark:text-gray-100">Over 55s League</a>
                                <a href="{{ route('results', ['type' => 'Ladies League']) }}" class="block px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 transition text-gray-900 dark:text-gray-100">Ladies League</a>
                            </div>
                        </div>
                    @endif
                    @if($settings?->show_match_reports ?? false)
                        <a href="{{ route('match-reports.index') }}" class="hover:opacity-75 transition">Match Reports</a>
                    @endif
                    <a href="{{ route('news') }}" class="hover:opacity-75 transition">News</a>
                    <a href="{{ route('events') }}" class="hover:opacity-75 transition">Events</a>
                    <a href="{{ route('contact') }}" class="hover:opacity-75 transition">Contact</a>
                    <livewire:search-header />
                    <a href="{{ route('members') }}"
                       class="px-4 py-2 rounded-md transition text-sm font-bold shadow-sm hover:shadow-md hover:scale-105 active:scale-95"
                       style="
                            background-color: {{ $settings?->menu_text_color ?? '#2563eb' }};
                            color: #ffffff;
                            filter: contrast(1.2);
                        ">
                        Members Area
                    </a>

                </div>

                <!-- Mobile Menu Toggle -->
                <div class="md:hidden">
                    <button type="button" @click="mobileMenuOpen = !mobileMenuOpen" class="hover:opacity-75 focus:outline-none p-2" style="color: {{ $settings?->menu_text_color ?? 'inherit' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="!mobileMenuOpen">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="mobileMenuOpen" x-cloak>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileMenuOpen"
                 x-cloak
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-2"
                 class="md:hidden pt-4 pb-2 border-t border-gray-100 dark:border-gray-700">
                <div class="flex flex-col gap-2">
                    <a href="{{ route('home') }}" class="px-2 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 rounded transition">Home</a>

                    <div x-data="{ open: false }">
                        <button type="button" @click="open = !open" class="w-full flex items-center justify-between px-2 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 rounded transition">
                            <span>About Us</span>
                            <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="open" x-cloak class="pl-4 mt-1 flex flex-col gap-1 border-l-2 border-gray-100 dark:border-gray-700 ml-2">
                            <a href="{{ route('about') }}" class="px-2 py-1.5 hover:text-blue-600 transition">General Info</a>
                            <a href="{{ route('about.location') }}" class="px-2 py-1.5 hover:text-blue-600 transition">Location</a>
                            <a href="{{ route('about.officers') }}" class="px-2 py-1.5 hover:text-blue-600 transition">Club Officers</a>
                            <a href="{{ route('about.facilities') }}" class="px-2 py-1.5 hover:text-blue-600 transition">Facilities</a>
                            <a href="{{ route('about.play-learn') }}" class="px-2 py-1.5 hover:text-blue-600 transition">Play & Learn</a>
                            <a href="{{ route('about.membership') }}" class="px-2 py-1.5 hover:text-blue-600 transition">Membership</a>
                            <a href="{{ route('about.history') }}" class="px-2 py-1.5 hover:text-blue-600 transition">Club History</a>
                            <a href="{{ route('about.competition') }}" class="px-2 py-1.5 hover:text-blue-600 transition">Club Competition</a>
                            <a href="{{ route('about.competition-winners') }}" class="px-2 py-1.5 hover:text-blue-600 transition">Club Competition Winners</a>
                        </div>
                    </div>

                    @if($settings?->show_league_tables && count($navLeagues) > 0)
                        <div x-data="{ open: false }">
                            <button type="button" @click="open = !open" class="w-full flex items-center justify-between px-2 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 rounded transition">
                                <span>Leagues</span>
                                <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="open" x-cloak class="pl-4 mt-1 flex flex-col gap-1 border-l-2 border-gray-100 dark:border-gray-700 ml-2">
                                @foreach($navLeagues as $league)
                                    <a href="{{ route('league-tables.show', $league->slug) }}" class="px-2 py-1.5 hover:text-blue-600 transition">{{ $league->short_name ?: $league->name }}</a>
                                @endforeach
                                <a href="{{ route('league-tables.index') }}" class="px-2 py-1.5 hover:text-blue-600 transition italic">All League Tables</a>
                            </div>
                        </div>
                    @endif

                    @if($settings?->show_fixtures_results ?? true)
                        <div x-data="{ open: false }">
                            <button type="button" @click="open = !open" class="w-full flex items-center justify-between px-2 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 rounded transition">
                                <span>Fixtures</span>
                                <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="open" x-cloak class="pl-4 mt-1 flex flex-col gap-1 border-l-2 border-gray-100 dark:border-gray-700 ml-2">
                                <a href="{{ route('fixtures.info') }}" class="px-2 py-1.5 hover:text-blue-600 transition">Fixture Information</a>
                                <a href="{{ route('fixtures', ['type' => 'Clarence Men']) }}" class="px-2 py-1.5 hover:text-blue-600 transition">Clarence Men</a>
                                <a href="{{ route('fixtures', ['type' => 'Clarence Women']) }}" class="px-2 py-1.5 hover:text-blue-600 transition">Clarence Women</a>
                                <a href="{{ route('fixtures', ['type' => 'Competitions']) }}" class="px-2 py-1.5 hover:text-blue-600 transition">Competitions</a>
                            </div>
                        </div>

                        <div x-data="{ open: false }">
                            <button type="button" @click="open = !open" class="w-full flex items-center justify-between px-2 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 rounded transition">
                                <span>Results</span>
                                <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="open" x-cloak class="pl-4 mt-1 flex flex-col gap-1 border-l-2 border-gray-100 dark:border-gray-700 ml-2">
                                <a href="{{ route('results') }}" class="px-2 py-1.5 hover:text-blue-600 transition">All Results</a>
                                <a href="{{ route('results', ['type' => 'County League']) }}" class="px-2 py-1.5 hover:text-blue-600 transition">County League</a>
                                <a href="{{ route('results', ['type' => 'Over 55s League']) }}" class="px-2 py-1.5 hover:text-blue-600 transition">Over 55s League</a>
                                <a href="{{ route('results', ['type' => 'Ladies League']) }}" class="px-2 py-1.5 hover:text-blue-600 transition">Ladies League</a>
                            </div>
                        </div>
                    @endif
                    <a href="{{ route('news') }}" class="px-2 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 rounded transition">News</a>
                    <a href="{{ route('events') }}" class="px-2 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 rounded transition">Events</a>
                    <a href="{{ route('contact') }}" class="px-2 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 rounded transition">Contact</a>
                    <div class="px-2 py-2">
                        <form action="{{ route('search') }}" method="GET" class="relative">
                            <input type="text" name="q" placeholder="Search..." maxlength="100" class="w-full pl-4 pr-10 py-2 border border-gray-300 dark:bg-gray-700 dark:border-gray-600 rounded-md bg-gray-50 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 hover:text-blue-500" style="color: {{ $settings?->menu_text_color ?? 'inherit' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                    <a href="{{ route('members') }}"
                       class="mx-2 my-2 block text-center px-4 py-3 rounded-md transition text-sm font-bold shadow-sm active:scale-95"
                       style="
                            background-color: {{ $settings?->menu_text_color ?? '#2563eb' }};
                            color: #ffffff;
                            filter: contrast(1.2);
                       ">
                        Members Area
                    </a>
                </div>
            </div>
        </nav>
        @if($settings?->pinstripe_color)
            <div class="w-full"
                 style="
                    background-color: {{ $settings->pinstripe_color }};
                    height: {{ $settings->pinstripe_style === 'double' ? '5px' : (match($settings->pinstripe_width) { 'thin' => '1px', 'thick' => '4px', default => '2px' }) }};
                    {{ $settings->pinstripe_style === 'double' ? 'border-bottom: 1px solid ' . $settings->pinstripe_color . '; padding-bottom: 2px; background-clip: content-box;' : '' }}
                 ">
            </div>
        @endif
    </header>

    <main>
        @if(isset($hero) && $hero)
            <x-hero :hero="$hero" />
        @endif

        @if(\Illuminate\Support\Facades\Route::currentRouteName() === 'home' && ($settings?->book_a_rink_advert_enabled ?? true))
            @php
                $bookARinkPrice = filled($settings?->book_a_rink_price) ? $settings->book_a_rink_price : '£5 per person per session';
                $bookARinkPhone = filled($settings?->book_a_rink_phone) ? $settings->book_a_rink_phone : '07895 255006';
                $bookARinkPhoneLink = preg_replace('/[^\d+]/', '', $bookARinkPhone);
            @endphp

            <div class="container mx-auto px-4">
                <section class="mb-12 overflow-hidden rounded-lg border border-emerald-200 bg-white shadow-lg dark:border-emerald-900/60 dark:bg-gray-800">
                    <div class="grid gap-0 lg:grid-cols-[1.15fr_0.85fr]">
                        <div class="relative p-6 sm:p-8">
                            <div class="absolute inset-y-0 left-0 w-1.5 bg-emerald-600"></div>
                            <div class="flex flex-col gap-5 sm:flex-row sm:items-center">
                                <div class="flex size-16 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300">
                                    <svg class="size-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3.75 17.25 20.25M17.25 3.75 6.75 20.25M4.5 12h15" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold uppercase text-emerald-700 dark:text-emerald-300">Book a rink</p>
                                    <h2 class="mt-1 text-3xl font-black text-gray-900 dark:text-white">Turn up and play</h2>
                                    <p class="mt-2 max-w-2xl text-base text-gray-600 dark:text-gray-300">
                                        Fancy a casual game? Book a rink and enjoy a session at Clarence Bowls Club.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-emerald-700 p-6 text-white sm:p-8">
                            <div class="grid h-full gap-4 sm:grid-cols-2 lg:grid-cols-1 xl:grid-cols-2">
                                <div class="rounded-md bg-white/10 p-4 ring-1 ring-white/20">
                                    <p class="text-xs font-semibold uppercase text-emerald-100">Price</p>
                                    <p class="mt-1 text-2xl font-black">{{ $bookARinkPrice }}</p>
                                </div>
                                <div class="rounded-md bg-white/10 p-4 ring-1 ring-white/20">
                                    <p class="text-xs font-semibold uppercase text-emerald-100">To book</p>
                                    <a href="tel:{{ $bookARinkPhoneLink }}" class="mt-1 inline-flex items-center gap-2 text-2xl font-black underline decoration-white/40 underline-offset-4 transition hover:decoration-white">
                                        <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106a1.125 1.125 0 0 0-1.173.417l-.97 1.293a1.125 1.125 0 0 1-1.21.38 12.035 12.035 0 0 1-7.143-7.143 1.125 1.125 0 0 1 .38-1.21l1.293-.97c.36-.27.527-.733.417-1.173L6.963 3.102A1.125 1.125 0 0 0 5.872 2.25H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                        </svg>
                                        {{ $bookARinkPhone }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        @endif

        @if(($settings?->countdown_active ?? false) && $settings?->countdown_target_date && \Illuminate\Support\Facades\Route::currentRouteName() === 'home')
            <x-countdown-clock
                :target-date="$settings->countdown_target_date"
                :message="$settings->countdown_message"
                :event="$settings->countdownEvent"
            />
        @endif

        @if(isset($activeAnnouncement) && $activeAnnouncement && request()->routeIs(['home', 'news']))
            <x-announcement :announcement="$activeAnnouncement" />
        @endif

        @if(isset($intro) && $intro)
            <x-intro-block :intro="$intro" />
        @endif
        {{ $slot }}
    </main>

    <livewire:sponsors-panel />

    <footer class="py-12 relative"
            style="
                background: {{ ($settings?->footer_gradient_start && $settings?->footer_gradient_end) ? 'linear-gradient(' . ($settings->footer_gradient_direction?->value ?? 'to right') . ', ' . $settings->footer_gradient_start . ', ' . $settings->footer_gradient_end . ')' : ($settings?->footer_color ?? '#ffffff') }};
                color: {{ $settings?->footer_text_color ?? 'inherit' }};
                border-top: 1px solid {{ $settings?->pinstripe_color ? $settings->pinstripe_color : 'rgb(229 231 235)' }};
            ">
        @if($settings?->pinstripe_color)
            <div class="absolute top-0 left-0 w-full"
                 style="
                    background-color: {{ $settings->pinstripe_color }};
                    height: {{ $settings->pinstripe_style === 'double' ? '5px' : (match($settings->pinstripe_width) { 'thin' => '1px', 'thick' => '4px', default => '2px' }) }};
                    {{ $settings->pinstripe_style === 'double' ? 'border-top: 1px solid ' . $settings->pinstripe_color . '; padding-top: 2px; background-clip: content-box;' : '' }}
                 ">
            </div>
        @endif
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-3 items-center gap-8 mb-8">
                <div class="flex justify-center md:justify-start h-24">
                    @if($settings?->hasMedia('footer_logo_left'))
                        <img src="{{ $settings->getFirstMediaUrl('footer_logo_left') }}" alt="Footer Logo Left" class="h-full w-auto object-contain">
                    @elseif($settings?->footer_logo_left)
                        <img src="{{ Storage::url($settings->footer_logo_left) }}" alt="Footer Logo Left" class="h-full w-auto object-contain">
                    @endif
                </div>
                <div class="text-center">
                    <h3 class="text-xl font-bold mb-4">{{ $settings?->club_name ?? 'Clarence Bowls Club' }}</h3>
                    @if($settings?->address)
                        <p class="whitespace-pre-line" style="color: {{ $settings?->footer_text_color ?? 'inherit' }}">{{ $settings->address }}</p>
                    @endif
                    @if($settings?->phone)
                        <p class="mt-2" style="color: {{ $settings?->footer_text_color ?? 'inherit' }}">Tel: {{ $settings->phone }}</p>
                    @endif
                </div>
                <div class="flex justify-center md:justify-end h-24">
                    @if($settings?->hasMedia('footer_logo_right'))
                        <img src="{{ $settings->getFirstMediaUrl('footer_logo_right') }}" alt="Footer Logo Right" class="h-full w-auto object-contain">
                    @elseif($settings?->footer_logo_right)
                        <img src="{{ Storage::url($settings->footer_logo_right) }}" alt="Footer Logo Right" class="h-full w-auto object-contain">
                    @endif
                </div>
            </div>

            @if(isset($socialLinks) && count($socialLinks) > 0)
                <div class="flex justify-center gap-6 mb-8">
                    @foreach($socialLinks as $link)
                        <a href="{{ $link->url }}" target="_blank" rel="noopener noreferrer" class="hover:opacity-75 transition-opacity" title="{{ $link->platform }}">
                            @if($link->icon && str_contains($link->icon, '<svg'))
                                <div class="w-6 h-6 fill-current">
                                    {!! $link->icon !!}
                                </div>
                            @elseif($link->icon)
                                <x-icon name="{{ $link->icon }}" class="w-6 h-6" />
                            @endif
                        </a>
                    @endforeach
                </div>
            @endif

            <div class="text-center pt-8 border-t"
                 style="border-color: {{ $settings?->pinstripe_color ? $settings->pinstripe_color : 'rgb(243 244 246)' }}">
                <p class="text-sm opacity-75">&copy; {{ date('Y') }} {{ $settings?->club_name ?? 'Clarence Bowls Club' }}. All rights reserved.</p>
            </div>
        </div>
    </footer>
    @cookieconsentview
    @livewireScripts
</body>
</html>
