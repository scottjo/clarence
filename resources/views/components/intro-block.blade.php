@props(['intro' => null])

@if($intro && $intro->is_active)
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col md:flex-row items-center gap-12">
                @if($intro->left_image)
                    <div class="w-full md:w-1/3 shrink-0">
                        <img src="{{ Storage::url($intro->left_image) }}" alt="Intro image left" class="w-full h-auto rounded-2xl shadow-xl object-cover aspect-square">
                    </div>
                @endif

                <div class="flex-1">
                    <div class="intro-block-content dark:text-gray-100" @if($intro->font_color) style="color: {{ $intro->font_color }};" @endif>
                        {!! $intro->content !!}
                    </div>
                </div>

                @if($intro->right_image)
                    <div class="w-full md:w-1/3 shrink-0">
                        <img src="{{ Storage::url($intro->right_image) }}" alt="Intro image right" class="w-full h-auto rounded-2xl shadow-xl object-cover aspect-square">
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif
