<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold mb-6">Facilities</h1>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        @foreach($facilities as $facility)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden flex flex-col" wire:key="facility-{{ $facility->id }}">
                @if($facility->image)
                    <div @class([
                        'w-full aspect-video',
                        'order-first' => in_array($facility->image_position, ['left', 'above']),
                        'order-last' => in_array($facility->image_position, ['right', 'below']),
                    ])>
                        <img src="{{ Storage::url($facility->image) }}" alt="{{ $facility->title }}" class="w-full h-full object-cover">
                    </div>
                @endif

                <div class="p-6 flex flex-col grow">
                    <h2 class="text-2xl font-bold mb-4">{{ $facility->title }}</h2>
                    <div class="prose dark:prose-invert max-w-none text-sm">
                        {!! nl2br(e($facility->description)) !!}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
