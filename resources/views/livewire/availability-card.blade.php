<div class="bg-white dark:bg-[#111111] border border-[#e4e4e7] dark:border-[#1f1f1f] rounded-lg p-6 min-h-[200px] shadow-sm dark:shadow-none">
    <h3 class="text-xs font-medium text-[#71717a] uppercase tracking-wider mb-5">Availability</h3>

    @if($loading)
        <div class="animate-pulse flex flex-col items-center justify-center gap-4 py-8">
            <div class="h-8 bg-[#e4e4e7] dark:bg-[#1f1f1f] rounded-full w-32"></div>
            <div class="h-3 bg-[#e4e4e7] dark:bg-[#1f1f1f] rounded w-48"></div>
        </div>

    @elseif($error)
        <div class="flex items-center gap-2 text-[#71717a] text-sm py-8">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.962-.833-2.732 0L3.27 16.5c-.77.833.192 2.5 1.732 2.5z"/>
            </svg>
            {{ $error }}
        </div>

    @elseif($result)
        <div class="flex flex-col items-center justify-center py-8 gap-3">
            @if($result['registered'])
                <span class="px-5 py-1.5 text-sm font-medium bg-red-50 dark:bg-red-500/15 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-500/25 rounded-full">Registered</span>
                @if(!empty($result['expires']))
                    <p class="text-[#71717a] text-sm">Expires {{ \Carbon\Carbon::parse($result['expires'])->format('M j, Y') }}</p>
                @endif
            @else
                <span class="px-5 py-1.5 text-sm font-medium bg-green-50 dark:bg-green-500/15 text-green-700 dark:text-green-400 border border-green-200 dark:border-green-500/25 rounded-full">Available</span>
                <p class="text-[#71717a] text-sm">This domain is free to register</p>
            @endif
        </div>

    @else
        <div class="flex items-center justify-center py-10">
            <p class="text-sm text-[#a1a1aa]">Enter a domain to check availability</p>
        </div>
    @endif
</div>
