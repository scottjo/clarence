@props(['targetDate', 'message' => null, 'event' => null])

@php
    $target = \Carbon\Carbon::parse($targetDate);
@endphp

<div x-data="{
        target: new Date('{{ $target->toIso8601String() }}').getTime(),
        days: 0,
        hours: 0,
        minutes: 0,
        seconds: 0,
        isExpired: false,
        update() {
            const now = new Date().getTime();
            const distance = this.target - now;

            if (distance < 0) {
                this.isExpired = true;
                this.days = 0;
                this.hours = 0;
                this.minutes = 0;
                this.seconds = 0;
                return;
            }

            this.days = Math.floor(distance / (1000 * 60 * 60 * 24));
            this.hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            this.minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            this.seconds = Math.floor((distance % (1000 * 60)) / 1000);
        }
    }"
    x-init="update(); setInterval(() => update(), 1000)"
    x-show="!isExpired"
    class="bg-gray-900 text-white py-4 shadow-inner"
>
    <div class="container mx-auto px-4 flex flex-col md:flex-row items-center justify-center gap-6 md:gap-12">
        @if($message)
            <div class="text-xl font-bold tracking-tight text-blue-400 uppercase">
                {{ $message }}
            </div>
        @endif

        <div class="flex gap-4 md:gap-8 items-center font-mono">
            <div class="text-center">
                <div class="text-3xl md:text-5xl font-black bg-gray-800 rounded-lg px-3 py-2 border-b-4 border-blue-600 min-w-[3.5rem] md:min-w-[5rem]" x-text="days.toString().padStart(2, '0')">00</div>
                <div class="text-[10px] uppercase font-bold tracking-widest mt-1 text-gray-500">Days</div>
            </div>
            <div class="text-2xl md:text-4xl font-bold text-gray-700">:</div>
            <div class="text-center">
                <div class="text-3xl md:text-5xl font-black bg-gray-800 rounded-lg px-3 py-2 border-b-4 border-blue-600 min-w-[3.5rem] md:min-w-[5rem]" x-text="hours.toString().padStart(2, '0')">00</div>
                <div class="text-[10px] uppercase font-bold tracking-widest mt-1 text-gray-500">Hours</div>
            </div>
            <div class="text-2xl md:text-4xl font-bold text-gray-700">:</div>
            <div class="text-center">
                <div class="text-3xl md:text-5xl font-black bg-gray-800 rounded-lg px-3 py-2 border-b-4 border-blue-600 min-w-[3.5rem] md:min-w-[5rem]" x-text="minutes.toString().padStart(2, '0')">00</div>
                <div class="text-[10px] uppercase font-bold tracking-widest mt-1 text-gray-500">Minutes</div>
            </div>
            <div class="text-2xl md:text-4xl font-bold text-gray-700">:</div>
            <div class="text-center">
                <div class="text-3xl md:text-5xl font-black bg-gray-800 rounded-lg px-3 py-2 border-b-4 border-blue-600 min-w-[3.5rem] md:min-w-[5rem]" x-text="seconds.toString().padStart(2, '0')">00</div>
                <div class="text-[10px] uppercase font-bold tracking-widest mt-1 text-gray-500">Seconds</div>
            </div>
        </div>

        @if($event)
            <div>
                <a href="{{ route('events.show', $event) }}" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-full transition transform hover:scale-105 active:scale-95 shadow-lg uppercase text-sm tracking-widest">
                    View Event
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        @endif
    </div>
</div>
