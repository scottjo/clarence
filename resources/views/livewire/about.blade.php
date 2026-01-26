<div class="container mx-auto px-4 py-12">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-4xl font-bold mb-8 text-center">About Clarence Bowls Club</h1>

        <div class="prose prose-lg dark:prose-invert mx-auto">
            <p class="text-xl text-gray-600 dark:text-gray-400 mb-8 leading-relaxed">
                Founded in 1907, Clarence Bowls Club has been a cornerstone of our local community for decades.
                Our club is more than just a place to play bowls; it's a vibrant hub for social interaction,
                personal growth, and healthy competition.
            </p>

            <h2 class="text-2xl font-bold mt-12 mb-4">Our Mission</h2>
            <p class="mb-6">
                Our mission is to promote the sport of lawn bowls in an inclusive and friendly atmosphere.
                We strive to provide excellent facilities and a supportive environment for players of all ages
                and skill levels, from beginners to seasoned veterans.
            </p>

            <h2 class="text-2xl font-bold mt-12 mb-4">Our Facilities</h2>
            <p class="mb-6">
                We take great pride in our beautifully maintained bowling greens and our modern clubhouse.
                Our facilities are designed to host competitive leagues, friendly matches, and a variety
                of social events throughout the year.
            </p>

            <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-600 p-8 my-12 rounded-r-lg">
                <h3 class="text-xl font-bold mb-2">Want to join us?</h3>
                <p>
                    We're always looking for new members! Whether you're a pro or have never held a bowl
                    in your life, you'll find a warm welcome at Clarence Bowls Club.
                </p>
                <div class="mt-4">
                    <a href="{{ route('contact') }}" class="text-blue-600 font-bold hover:underline">Contact us today to find out more &rarr;</a>
                </div>
            </div>

            <h2 class="text-2xl font-bold mt-12 mb-4">Location</h2>
            <p>
                You can find us at: <br>
            </p>
            @if($settings?->address)
                <p class="whitespace-pre-line">{{ $settings->address }}</p>
            @else
                <p>Clarence Park</p>
                <p>Clarence Road South</p>
                <p>Weston Super Mare</p>
                <p>BS23 4BN</p>
            @endif
        </div>
    </div>
</div>
