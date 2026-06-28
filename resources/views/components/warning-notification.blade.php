@php
    $warning = auth()->user()->warnings()
        ->where(function ($query) {
            $query->whereNull('expires_at')
                  ->orWhere('expires_at', '>', now());
        })
        ->latest()
        ->first();
@endphp

@if($warning)
    <div class="fixed top-4 right-4 z-50 max-w-md" x-data="{ show: true }" x-show="show" x-transition>
        <div class="rounded-2xl border-2 
            {{ $warning->type === 'ban' ? 'border-red-500 bg-red-50 dark:bg-red-900/30' : '' }}
            {{ $warning->type === 'suspend' ? 'border-orange-500 bg-orange-50 dark:bg-orange-900/30' : '' }}
            {{ $warning->type === 'warning' ? 'border-yellow-500 bg-yellow-50 dark:bg-yellow-900/30' : '' }}
            shadow-lg p-4">
            
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0">
                    @if($warning->type === 'ban')
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                    @elseif($warning->type === 'suspend')
                        <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    @else
                        <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    @endif
                </div>
                
                <div class="flex-1">
                    <h4 class="text-sm font-bold 
                        {{ $warning->type === 'ban' ? 'text-red-800 dark:text-red-200' : '' }}
                        {{ $warning->type === 'suspend' ? 'text-orange-800 dark:text-orange-200' : '' }}
                        {{ $warning->type === 'warning' ? 'text-yellow-800 dark:text-yellow-200' : '' }}">
                        @if($warning->type === 'ban')
                             Akun Anda Dibanned
                        @elseif($warning->type === 'suspend')
                            ️ Akun Anda Disuspensi
                        @else
                            ⚠️ Peringatan dari Admin
                        @endif
                    </h4>
                    
                    <p class="mt-1 text-sm 
                        {{ $warning->type === 'ban' ? 'text-red-700 dark:text-red-300' : '' }}
                        {{ $warning->type === 'suspend' ? 'text-orange-700 dark:text-orange-300' : '' }}
                        {{ $warning->type === 'warning' ? 'text-yellow-700 dark:text-yellow-300' : '' }}">
                        {{ $warning->message }}
                    </p>
                    
                    <div class="mt-2 text-xs 
                        {{ $warning->type === 'ban' ? 'text-red-600 dark:text-red-400' : '' }}
                        {{ $warning->type === 'suspend' ? 'text-orange-600 dark:text-orange-400' : '' }}
                        {{ $warning->type === 'warning' ? 'text-yellow-600 dark:text-yellow-400' : '' }}">
                        <strong>Alasan:</strong> {{ $warning->reason }}
                        @if($warning->expires_at)
                            <br>
                            <strong>Berlaku hingga:</strong> {{ $warning->expires_at->format('d M Y H:i') }}
                        @else
                            <br>
                            <strong>Status:</strong> Permanen
                        @endif
                    </div>
                </div>
                
                <button @click="show = false" class="flex-shrink-0 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
@endif