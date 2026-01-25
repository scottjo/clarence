@props(['hero' => null])

@if($hero)
    <div class="relative h-[400px] md:h-[500px] overflow-hidden mb-12 {{ $hero->font_family }}">
        <img src="{{ str_starts_with($hero->image, 'http') ? $hero->image : Storage::url($hero->image) }}" alt="{{ $hero->title }}" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-black" style="opacity: {{ $hero->overlay_opacity / 100 }}"></div>
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center px-4 max-w-4xl">
                @if($hero->title)
                    <h1 class="{{ $hero->title_size }} font-extrabold mb-4 drop-shadow-lg" style="color: {{ $hero->title_color }}">
                        {{ $hero->title }}
                    </h1>
                @endif

                @if($hero->subtitle)
                    <p class="{{ $hero->subtitle_size }} mb-6 font-semibold drop-shadow-md" style="color: {{ $hero->subtitle_color }}">
                        {{ $hero->subtitle }}
                    </p>
                @endif

                @if($hero->intro_text)
                    <p class="{{ $hero->intro_size }} max-w-2xl mx-auto drop-shadow-md whitespace-pre-line" style="color: {{ $hero->intro_color }}">
                        {{ $hero->intro_text }}
                    </p>
                @endif
            </div>
        </div>
    </div>
@endif
