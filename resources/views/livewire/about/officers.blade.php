<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold mb-12 text-center">Club Officers</h1>

    <div class="space-y-16">
        @foreach ($groups as $classificationId => $groupOfficers)
            @php
                $classification = $groupOfficers->first()->classification;
            @endphp
            <section class="bg-gray-50/50 dark:bg-gray-900/20 rounded-2xl p-8 border border-gray-100 dark:border-gray-800">
                <h2 class="text-3xl font-bold mb-8 text-gray-800 dark:text-gray-200 border-b pb-4">
                    {{ $classification?->name ?? 'Other Officers' }}
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($groupOfficers as $officer)
                        @php
                            $bgColor = $classification?->bg_color ?? '#ffffff';
                            $textColor = $classification?->text_color ?? '#111827';
                            $bgColorDark = $classification?->bg_color_dark ?? '#1f2937';
                            $textColorDark = $classification?->text_color_dark ?? '#f9fafb';

                            if (! $classification) {
                                $textColor = 'inherit';
                                $textColorDark = 'inherit';
                            }

                            $avatarBgColor = $classification ? $textColor . '20' : 'rgba(59, 130, 246, 0.1)';
                            $avatarTextColor = $classification ? $textColor : '#2563eb';
                            $avatarBorderColor = $classification ? $textColor . '40' : 'rgba(59, 130, 246, 0.2)';
                        @endphp
                        <div id="officer-{{ $officer->id }}"
                             class="rounded-lg shadow-md p-6 flex flex-col items-center text-center scroll-mt-24 transition-colors"
                             style="background-color: {{ $bgColor }}; color: {{ $textColor }};">
                            <style>
                                @media (prefers-color-scheme: dark) {
                                    #officer-{{ $officer->id }} {
                                        background-color: {{ $bgColorDark }} !important;
                                        color: {{ $textColorDark }} !important;
                                    }
                                    #officer-{{ $officer->id }} .avatar-circle {
                                        background-color: {{ $classification ? $textColorDark . '20' : 'rgba(96, 165, 250, 0.2)' }} !important;
                                        border-color: {{ $classification ? $textColorDark . '40' : 'rgba(96, 165, 250, 0.3)' }} !important;
                                    }
                                    #officer-{{ $officer->id }} .avatar-text {
                                        color: {{ $classification ? $textColorDark : '#60a5fa' }} !important;
                                    }
                                    #officer-{{ $officer->id }} .officer-role {
                                        color: {{ $classification ? $textColorDark : '#9ca3af' }} !important;
                                    }
                                }
                            </style>
                            @if ($officer->avatar)
                                <img src="{{ Storage::url($officer->avatar) }}" alt="{{ $officer->name }}" class="w-24 h-24 rounded-full object-cover mb-4 ring-2 ring-offset-2" style="--tw-ring-color: {{ $textColor }};">
                            @else
                                <div class="avatar-circle w-24 h-24 rounded-full flex items-center justify-center mb-4 border-2"
                                     style="background-color: {{ $avatarBgColor }}; border-color: {{ $avatarBorderColor }};">
                                    @php
                                        $initials = collect(explode(' ', $officer->name))
                                            ->map(fn($segment) => mb_substr($segment, 0, 1))
                                            ->join('');
                                    @endphp
                                    <span class="avatar-text text-2xl font-bold uppercase" style="color: {{ $avatarTextColor }};">{{ $initials }}</span>
                                </div>
                            @endif
                            <h3 class="text-xl font-bold">{{ $officer->name }}</h3>
                            <p class="officer-role opacity-75">{{ $officer->role->getLabel() }}</p>
                        </div>
                    @endforeach
                </div>
            </section>
        @endforeach
    </div>
</div>
