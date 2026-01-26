<div class="container mx-auto px-4 py-12">
    <div class="max-w-5xl mx-auto">
        <h1 class="text-4xl font-bold mb-12 text-center">Contact Us</h1>

        <div class="grid md:grid-cols-2 gap-12">
            <div class="bg-white dark:bg-gray-800 p-8 md:p-12 rounded-3xl shadow-lg border border-gray-100 dark:border-gray-700">
                <h2 class="text-2xl font-bold mb-8">Get in Touch</h2>

                @if($success)
                    <div class="bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 p-6 rounded-2xl mb-8 border border-green-200 dark:border-green-800">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="font-bold">Message sent successfully!</span>
                        </div>
                        <p class="mt-2">Thank you for contacting us. We will get back to you shortly.</p>
                    </div>
                @endif

                <form wire:submit.prevent="submit" class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wide">Your Name</label>
                        <input type="text" id="name" wire:model="name" class="w-full px-6 py-4 rounded-xl border-2 border-gray-100 dark:border-gray-700 dark:bg-gray-900 focus:border-blue-600 focus:outline-none transition">
                        @error('name') <span class="text-red-600 text-xs font-bold mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wide">Email Address</label>
                        <input type="email" id="email" wire:model="email" class="w-full px-6 py-4 rounded-xl border-2 border-gray-100 dark:border-gray-700 dark:bg-gray-900 focus:border-blue-600 focus:outline-none transition">
                        @error('email') <span class="text-red-600 text-xs font-bold mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="subject" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wide">Subject</label>
                        <input type="text" id="subject" wire:model="subject" class="w-full px-6 py-4 rounded-xl border-2 border-gray-100 dark:border-gray-700 dark:bg-gray-900 focus:border-blue-600 focus:outline-none transition">
                        @error('subject') <span class="text-red-600 text-xs font-bold mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wide">Message</label>
                        <textarea id="message" wire:model="message" rows="5" class="w-full px-6 py-4 rounded-xl border-2 border-gray-100 dark:border-gray-700 dark:bg-gray-900 focus:border-blue-600 focus:outline-none transition"></textarea>
                        @error('message') <span class="text-red-600 text-xs font-bold mt-1">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="w-full py-4 bg-blue-600 text-white rounded-xl font-black uppercase tracking-widest hover:bg-blue-700 transition shadow-lg shadow-blue-200 dark:shadow-none">
                        Send Message
                    </button>
                </form>
            </div>

            <div class="space-y-12">
                <section>
                    <h2 class="text-2xl font-bold mb-6">Our Location</h2>
                    <div class="aspect-video bg-gray-100 dark:bg-gray-800 rounded-3xl mb-4 overflow-hidden shadow-inner flex items-center justify-center text-gray-400">
                        @if($settings?->latitude && $settings?->longitude)
                            <iframe
                                width="100%"
                                height="100%"
                                src="https://www.openstreetmap.org/export/embed.html?bbox={{ $settings->longitude - 0.005 }}%2C{{ $settings->latitude - 0.002 }}%2C{{ $settings->longitude + 0.005 }}%2C{{ $settings->latitude + 0.002 }}&amp;layer=mapnik&amp;marker={{ $settings->latitude }}%2C{{ $settings->longitude }}"
                                style="border: 0"
                            ></iframe>
                        @else
                            <span class="font-bold uppercase tracking-widest">[ Map Placeholder ]</span>
                        @endif
                    </div>
                    <div class="text-gray-600 dark:text-gray-400">
                        <p class="font-bold">{{ $settings?->club_name ?? 'Clarence Bowls Club' }}</p>
                        @if($settings?->address)
                            <p class="whitespace-pre-line">{{ $settings->address }}</p>
                        @else
                            <p>Clarence Park</p>
                            <p>Clarence Road South</p>
                            <p>Weston Super Mare</p>
                            <p>BS23 4BN</p>
                        @endif
                    </div>
                </section>

                <section>
                    <h2 class="text-2xl font-bold mb-6">Contact Info</h2>
                    <div class="space-y-4">
                        <div class="flex items-center gap-4">
                            <div class="text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <span class="font-bold">{{ $settings?->email ?? 'info@clarencebowls.com' }}</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <span class="font-bold">{{ $settings?->phone ?? '+44 (0) 1234 567890' }}</span>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
