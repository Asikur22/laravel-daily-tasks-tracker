<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('History') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl p-6">
                
                <!-- Month Navigation -->
                <div class="flex justify-between items-center mb-6">
                    <a href="{{ route('history', ['month' => $startOfMonth->copy()->subMonth()->month, 'year' => $startOfMonth->copy()->subMonth()->year]) }}" class="p-2 rounded-full hover:bg-gray-100 text-gray-500 hover:text-gray-900 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </a>
                    
                    <h3 class="text-lg font-bold text-gray-900">
                        {{ $startOfMonth->format('F Y') }}
                    </h3>
                    
                    <a href="{{ route('history', ['month' => $startOfMonth->copy()->addMonth()->month, 'year' => $startOfMonth->copy()->addMonth()->year]) }}" class="p-2 rounded-full hover:bg-gray-100 text-gray-500 hover:text-gray-900 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>

                <!-- Calendar Grid -->
                <div class="grid grid-cols-7 gap-2">
                    <!-- Days Header -->
                    @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dayName)
                        <div class="text-center text-xs font-medium text-gray-400 py-2">{{ $dayName }}</div>
                    @endforeach
                    
                    <!-- Empty cells for start of month offset -->
                    @for($i = 0; $i < $startOfMonth->dayOfWeek; $i++)
                        <div></div>
                    @endfor
                    
                    <!-- Days -->
                    @foreach($calendar as $day)
                        @php
                            $bgColor = 'bg-gray-50';
                            $textColor = 'text-gray-700';
                            $borderColor = 'border-transparent';
                            
                            if ($day['is_future']) {
                                $bgColor = 'bg-white';
                                $textColor = 'text-gray-300';
                                $borderColor = 'border-gray-100';
                            } elseif ($day['total'] > 0) {
                                if ($day['percentage'] == 100) {
                                    $bgColor = 'bg-emerald-50';
                                    $textColor = 'text-emerald-700';
                                    $borderColor = 'border-emerald-100';
                                } elseif ($day['percentage'] >= 50) {
                                    $bgColor = 'bg-amber-50';
                                    $textColor = 'text-amber-700';
                                    $borderColor = 'border-amber-100';
                                } else {
                                    $bgColor = 'bg-rose-50';
                                    $textColor = 'text-rose-700';
                                    $borderColor = 'border-rose-100';
                                }
                            }
                        @endphp
                        
                        <div class="h-24 p-2 rounded-xl border {{ $borderColor }} flex flex-col justify-between {{ $bgColor }} transition-colors relative group">
                            <span class="text-sm font-medium {{ $textColor }}">{{ $day['day'] }}</span>
                            
                            @if(!$day['is_future'] && $day['total'] > 0)
                                <div class="text-right">
                                    <span class="text-xs font-bold {{ $textColor }}">{{ $day['percentage'] }}%</span>
                                </div>
                                
                                <!-- Tooltip attempt (simple) -->
                                <div class="absolute inset-0 bg-transparent" title="{{ $day['completed'] }} / {{ $day['total'] }} tasks completed"></div>
                            @endif
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-8 text-center text-sm text-gray-400">
                    <a href="{{ route('dashboard') }}" class="hover:text-gray-600 underline">Back to Dashboard</a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
