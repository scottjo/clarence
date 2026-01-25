<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold mb-6">Club Officers</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach ($officers as $officer)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 flex flex-col items-center text-center">
                @if ($officer->avatar)
                    <img src="{{ Storage::url($officer->avatar) }}" alt="{{ $officer->name }}" class="w-24 h-24 rounded-full object-cover mb-4">
                @else
                    <div class="w-24 h-24 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mb-4">
                        @php
                            $initials = collect(explode(' ', $officer->name))
                                ->map(fn($segment) => mb_substr($segment, 0, 1))
                                ->join('');
                        @endphp
                        <span class="text-2xl text-blue-600 dark:text-blue-400 font-bold uppercase">{{ $initials }}</span>
                    </div>
                @endif
                <h3 class="text-xl font-bold">{{ $officer->name }}</h3>
                <p class="text-gray-600 dark:text-gray-400">{{ $officer->role }}</p>
            </div>
        @endforeach
    </div>
</div>
