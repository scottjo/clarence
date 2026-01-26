<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Bowls Club' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
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
                @if($settings?->header_gradient_start && $settings?->header_gradient_end)
                    background: linear-gradient({{ $settings->header_gradient_direction ?? 'to right' }}, {{ $settings->header_gradient_start }}, {{ $settings->header_gradient_end }});
                @else
                    background-color: {{ $settings?->menu_color ?? '#ffffff' }};
                @endif
                color: {{ $settings?->menu_text_color ?? 'inherit' }}
            ">
        <nav class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center gap-3 text-2xl font-bold" style="color: {{ $settings?->menu_text_color ?? '#2563eb' }}">
                    @if($settings?->header_logo)
                        <img src="{{ Storage::url($settings->header_logo) }}" alt="{{ $settings->club_name }} Logo" class="h-10 w-auto object-contain">
                    @else
                        <img src="{{ asset('images/logo.png') }}" alt="Clarence Bowls Club Logo" class="h-10 w-auto object-contain">
                    @endif
                    <span>{{ $settings?->club_name ?? 'Clarence Bowls Club' }}</span>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex gap-6 items-center">
                    <a href="{{ route('home') }}" class="hover:opacity-75 transition">Home</a>

                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <button @click="open = !open" class="flex items-center gap-1 hover:opacity-75 transition focus:outline-none">
                            About Us
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                            </svg>
                        </button>
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute left-0 mt-0 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-2 z-50 border border-gray-100 dark:border-gray-700"
                             style="display: none;">
                            <a href="{{ route('about') }}" class="block px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 transition text-gray-900 dark:text-gray-100">General Info</a>
                            <a href="{{ route('about.location') }}" class="block px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 transition text-gray-900 dark:text-gray-100">Location</a>
                            <a href="{{ route('about.officers') }}" class="block px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 transition text-gray-900 dark:text-gray-100">Club Officers</a>
                            <a href="{{ route('about.facilities') }}" class="block px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 transition text-gray-900 dark:text-gray-100">Facilities</a>
                            <a href="{{ route('about.play-learn') }}" class="block px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 transition text-gray-900 dark:text-gray-100">Play & Learn</a>
                            <a href="{{ route('about.membership') }}" class="block px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 transition text-gray-900 dark:text-gray-100">Membership</a>
                            <a href="{{ route('about.history') }}" class="block px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 transition text-gray-900 dark:text-gray-100">Club History</a>
                            <a href="{{ route('about.competition') }}" class="block px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 transition text-gray-900 dark:text-gray-100">Club Competition</a>
                        </div>
                    </div>

                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <button @click="open = !open" class="flex items-center gap-1 hover:opacity-75 transition focus:outline-none">
                            Fixtures
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                            </svg>
                        </button>
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute left-0 mt-0 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-2 z-50 border border-gray-100 dark:border-gray-700"
                             style="display: none;">
                            <a href="{{ route('fixtures.info') }}" class="block px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 transition text-gray-900 dark:text-gray-100">Fixture Information</a>
                            <hr class="my-1 border-gray-100 dark:border-gray-700">
                            <a href="{{ route('fixtures', ['type' => 'Clarence Men']) }}" class="block px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 transition text-gray-900 dark:text-gray-100">Clarence Men</a>
                            <a href="{{ route('fixtures', ['type' => 'Clarence Women']) }}" class="block px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 transition text-gray-900 dark:text-gray-100">Clarence Women</a>
                            <a href="{{ route('fixtures', ['type' => 'Competitions']) }}" class="block px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 transition text-gray-900 dark:text-gray-100">Competitions</a>
                        </div>
                    </div>
                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <button @click="open = !open" class="flex items-center gap-1 hover:opacity-75 transition focus:outline-none">
                            Results
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                            </svg>
                        </button>
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute left-0 mt-0 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-2 z-50 border border-gray-100 dark:border-gray-700"
                             style="display: none;">
                            <a href="{{ route('results') }}" class="block px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 transition text-gray-900 dark:text-gray-100">All Results</a>
                            <hr class="my-1 border-gray-100 dark:border-gray-700">
                            <a href="{{ route('results', ['type' => 'County League']) }}" class="block px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 transition text-gray-900 dark:text-gray-100">County League</a>
                            <a href="{{ route('results', ['type' => 'Over 55s League']) }}" class="block px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 transition text-gray-900 dark:text-gray-100">Over 55s League</a>
                            <a href="{{ route('results', ['type' => 'Ladies League']) }}" class="block px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 transition text-gray-900 dark:text-gray-100">Ladies League</a>
                        </div>
                    </div>
                    <a href="{{ route('news') }}" class="hover:opacity-75 transition">News</a>
                    <a href="{{ route('events') }}" class="hover:opacity-75 transition">Events</a>
                    <a href="{{ route('contact') }}" class="hover:opacity-75 transition">Contact</a>
                </div>

                <!-- Mobile Menu Toggle -->
                <div class="md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="hover:opacity-75 focus:outline-none p-2" style="color: {{ $settings?->menu_text_color ?? 'inherit' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="!mobileMenuOpen">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="mobileMenuOpen" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileMenuOpen"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-2"
                 class="md:hidden pt-4 pb-2 border-t border-gray-100 dark:border-gray-700"
                 style="display: none;">
                <div class="flex flex-col gap-2">
                    <a href="{{ route('home') }}" class="px-2 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 rounded transition">Home</a>

                    <div x-data="{ open: false }">
                        <button @click="open = !open" class="w-full flex items-center justify-between px-2 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 rounded transition">
                            <span>About Us</span>
                            <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="open" class="pl-4 mt-1 flex flex-col gap-1 border-l-2 border-gray-100 dark:border-gray-700 ml-2">
                            <a href="{{ route('about') }}" class="px-2 py-1.5 hover:text-blue-600 transition">General Info</a>
                            <a href="{{ route('about.location') }}" class="px-2 py-1.5 hover:text-blue-600 transition">Location</a>
                            <a href="{{ route('about.officers') }}" class="px-2 py-1.5 hover:text-blue-600 transition">Club Officers</a>
                            <a href="{{ route('about.facilities') }}" class="px-2 py-1.5 hover:text-blue-600 transition">Facilities</a>
                            <a href="{{ route('about.play-learn') }}" class="px-2 py-1.5 hover:text-blue-600 transition">Play & Learn</a>
                            <a href="{{ route('about.membership') }}" class="px-2 py-1.5 hover:text-blue-600 transition">Membership</a>
                            <a href="{{ route('about.history') }}" class="px-2 py-1.5 hover:text-blue-600 transition">Club History</a>
                            <a href="{{ route('about.competition') }}" class="px-2 py-1.5 hover:text-blue-600 transition">Club Competition</a>
                        </div>
                    </div>

                    <div x-data="{ open: false }">
                        <button @click="open = !open" class="w-full flex items-center justify-between px-2 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 rounded transition">
                            <span>Fixtures</span>
                            <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="open" class="pl-4 mt-1 flex flex-col gap-1 border-l-2 border-gray-100 dark:border-gray-700 ml-2">
                            <a href="{{ route('fixtures.info') }}" class="px-2 py-1.5 hover:text-blue-600 transition">Fixture Information</a>
                            <a href="{{ route('fixtures', ['type' => 'Clarence Men']) }}" class="px-2 py-1.5 hover:text-blue-600 transition">Clarence Men</a>
                            <a href="{{ route('fixtures', ['type' => 'Clarence Women']) }}" class="px-2 py-1.5 hover:text-blue-600 transition">Clarence Women</a>
                            <a href="{{ route('fixtures', ['type' => 'Competitions']) }}" class="px-2 py-1.5 hover:text-blue-600 transition">Competitions</a>
                        </div>
                    </div>

                    <div x-data="{ open: false }">
                        <button @click="open = !open" class="w-full flex items-center justify-between px-2 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 rounded transition">
                            <span>Results</span>
                            <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="open" class="pl-4 mt-1 flex flex-col gap-1 border-l-2 border-gray-100 dark:border-gray-700 ml-2">
                            <a href="{{ route('results') }}" class="px-2 py-1.5 hover:text-blue-600 transition">All Results</a>
                            <a href="{{ route('results', ['type' => 'County League']) }}" class="px-2 py-1.5 hover:text-blue-600 transition">County League</a>
                            <a href="{{ route('results', ['type' => 'Over 55s League']) }}" class="px-2 py-1.5 hover:text-blue-600 transition">Over 55s League</a>
                            <a href="{{ route('results', ['type' => 'Ladies League']) }}" class="px-2 py-1.5 hover:text-blue-600 transition">Ladies League</a>
                        </div>
                    </div>
                    <a href="{{ route('news') }}" class="px-2 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 rounded transition">News</a>
                    <a href="{{ route('events') }}" class="px-2 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 rounded transition">Events</a>
                    <a href="{{ route('contact') }}" class="px-2 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 rounded transition">Contact</a>
                </div>
            </div>
        </nav>
        @if($settings?->pinstripe_color)
            <div class="w-full"
                 style="
                    background-color: {{ $settings->pinstripe_color }};
                    height: {{ match($settings->pinstripe_width) { 'thin' => '1px', 'thick' => '4px', default => '2px' } }};
                    @if($settings->pinstripe_style === 'double')
                        border-bottom: 1px solid {{ $settings->pinstripe_color }};
                        padding-bottom: 2px;
                        background-clip: content-box;
                        height: 5px;
                    @endif
                 ">
            </div>
        @endif
    </header>

    <main>
        @if(isset($hero) && $hero)
            <x-hero :hero="$hero" />
        @endif

        @if(isset($intro) && $intro)
            <x-intro-block :intro="$intro" />
        @endif
        {{ $slot }}
    </main>

    <footer class="mt-12 py-12 relative"
            style="
                @if($settings?->footer_gradient_start && $settings?->footer_gradient_end)
                    background: linear-gradient({{ $settings->footer_gradient_direction ?? 'to right' }}, {{ $settings->footer_gradient_start }}, {{ $settings->footer_gradient_end }});
                @else
                    background-color: {{ $settings?->footer_color ?? '#ffffff' }};
                @endif
                color: {{ $settings?->footer_text_color ?? 'inherit' }};
                @if($settings?->pinstripe_color)
                    border-top: 1px solid {{ $settings->pinstripe_color }};
                @else
                    border-top: 1px solid rgb(229 231 235);
                @endif
            ">
        @if($settings?->pinstripe_color)
            <div class="absolute top-0 left-0 w-full"
                 style="
                    background-color: {{ $settings->pinstripe_color }};
                    height: {{ match($settings->pinstripe_width) { 'thin' => '1px', 'thick' => '4px', default => '2px' } }};
                    @if($settings->pinstripe_style === 'double')
                        border-top: 1px solid {{ $settings->pinstripe_color }};
                        padding-top: 2px;
                        background-clip: content-box;
                        height: 5px;
                    @endif
                 ">
            </div>
        @endif
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-3 items-center gap-8 mb-8">
                <div class="flex justify-center md:justify-start h-24">
                    @if($settings?->footer_logo_left)
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
                    @if($settings?->footer_logo_right)
                        <img src="{{ Storage::url($settings->footer_logo_right) }}" alt="Footer Logo Right" class="h-full w-auto object-contain">
                    @endif
                </div>
            </div>

            @if(isset($socialLinks) && $socialLinks->count() > 0)
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
                 style="
                    @if($settings?->pinstripe_color)
                        border-color: {{ $settings->pinstripe_color }};
                    @else
                        border-color: rgb(243 244 246);
                    @endif
                 ">
                <p class="text-sm opacity-75">&copy; {{ date('Y') }} {{ $settings?->club_name ?? 'Clarence Bowls Club' }}. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
