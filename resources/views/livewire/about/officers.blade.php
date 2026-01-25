<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold mb-6">Club Officers</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @php
            $officers = [
                ['role' => 'President', 'name' => 'John Smith'],
                ['role' => 'Chairman', 'name' => 'Jane Doe'],
                ['role' => 'Secretary', 'name' => 'Robert Brown'],
                ['role' => 'Treasurer', 'name' => 'Susan White'],
                ['role' => 'Captain', 'name' => 'David Miller'],
            ];
        @endphp
        @foreach ($officers as $officer)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 flex flex-col items-center text-center">
                <div class="w-24 h-24 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mb-4">
                    <span class="text-2xl text-blue-600 dark:text-blue-400 font-bold">{{ substr($officer['name'], 0, 1) }}</span>
                </div>
                <h3 class="text-xl font-bold">{{ $officer['name'] }}</h3>
                <p class="text-gray-600 dark:text-gray-400">{{ $officer['role'] }}</p>
            </div>
        @endforeach
    </div>
</div>
