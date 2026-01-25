
<div class="container mx-auto px-4 py-12">
    <h1 class="text-4xl font-bold mb-8 text-center">Fixture Information</h1>

    <div class="max-w-4xl mx-auto space-y-12">
        <section class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 border border-gray-100 dark:border-gray-700">
            <h2 class="text-2xl font-bold mb-4 text-blue-600 dark:text-blue-400">General Match Info</h2>
            <div class="prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-400 leading-relaxed">
                <p>Clarence Bowls Club participates in various leagues and friendly matches throughout the season, which typically runs from April to September. Our fixtures are categorized into Men's, Women's, and Mixed Competitions.</p>
                <p>All home matches are played at our main green located at Clarence Park. Visitors are always welcome to come and watch our teams in action.</p>
            </div>
        </section>

        <div class="grid md:grid-cols-2 gap-8">
            <section class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 border border-gray-100 dark:border-gray-700">
                <h2 class="text-2xl font-bold mb-4 text-blue-600 dark:text-blue-400">Match Dress Code</h2>
                <ul class="space-y-3 text-gray-600 dark:text-gray-400">
                    <li class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span><strong>Leagues:</strong> Club shirts with white or grey trousers/skirts as specified for the match.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span><strong>Friendly Matches:</strong> Usually whites or greys with club or white shirts.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span><strong>Shoes:</strong> Flat-soled bowling shoes must be worn on the green at all times.</span>
                    </li>
                </ul>
            </section>

            <section class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 border border-gray-100 dark:border-gray-700">
                <h2 class="text-2xl font-bold mb-4 text-blue-600 dark:text-blue-400">Match Fees</h2>
                <div class="text-gray-600 dark:text-gray-400 space-y-4">
                    <p>Match fees contribute towards the maintenance of our facilities and often include light refreshments after the game.</p>
                    <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-lg">
                        <ul class="space-y-2">
                            <li class="flex justify-between"><span>Home League Match:</span> <span class="font-bold">£3.50</span></li>
                            <li class="flex justify-between"><span>Away League Match:</span> <span class="font-bold">£2.50</span></li>
                            <li class="flex justify-between"><span>Friendly Match:</span> <span class="font-bold">£4.00</span></li>
                        </ul>
                    </div>
                </div>
            </section>
        </div>

        <section class="bg-blue-600 text-white rounded-xl shadow-lg p-8 text-center">
            <h2 class="text-2xl font-bold mb-4">Interested in playing?</h2>
            <p class="mb-6 opacity-90">Selection sheets are posted on the club noticeboard at least two weeks before each match. Please ensure you enter your name if you are available.</p>
            <a href="{{ route('contact') }}" class="inline-block px-8 py-3 bg-white text-blue-600 font-bold rounded-lg hover:bg-gray-100 transition">Contact Selection Committee</a>
        </section>
    </div>
</div>
