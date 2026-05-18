<div class="bg-white dark:bg-[#111111] border border-[#e4e4e7] dark:border-[#1f1f1f] rounded-lg p-6 min-h-[200px] shadow-sm dark:shadow-none">
    <h3 class="text-xs font-medium text-[#71717a] uppercase tracking-wider mb-5">Extension Check</h3>

    @if($loading)
        <div class="animate-pulse space-y-2">
            @foreach(range(1, 7) as $_)
                <div class="flex items-center justify-between py-1.5">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-[#e4e4e7] dark:bg-[#1f1f1f] shrink-0"></div>
                        <div class="h-3 bg-[#e4e4e7] dark:bg-[#1f1f1f] rounded w-24"></div>
                    </div>
                    <div class="h-3 bg-[#e4e4e7] dark:bg-[#1f1f1f] rounded w-14"></div>
                </div>
            @endforeach
        </div>

    @elseif($error)
        <div class="flex items-center gap-2 text-[#71717a] text-sm py-8">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.962-.833-2.732 0L3.27 16.5c-.77.833.192 2.5 1.732 2.5z"/>
            </svg>
            {{ $error }}
        </div>

    @elseif(!empty($results))
        <ul class="divide-y divide-[#f4f4f5] dark:divide-[#1a1a1a]">
            @foreach($results as $item)
                <li class="flex items-center justify-between py-2">
                    <div class="flex items-center gap-3 min-w-0">
                        @if($item['error'])
                            <div class="w-2 h-2 rounded-full bg-[#d4d4d8] shrink-0"></div>
                        @elseif($item['registered'])
                            <div class="w-2 h-2 rounded-full bg-red-400 shrink-0"></div>
                        @else
                            <div class="w-2 h-2 rounded-full bg-green-500 shrink-0"></div>
                        @endif
                        <span class="font-mono text-sm truncate">{{ $item['domain'] }}</span>
                    </div>
                    <div class="text-xs ml-3 shrink-0">
                        @if($item['error'])
                            <span class="text-[#a1a1aa]">Unknown</span>
                        @elseif($item['registered'])
                            <span class="text-red-600 dark:text-red-400">Taken</span>
                            @if(!empty($item['expires']))
                                <span class="text-[#71717a] ml-1">exp. {{ \Carbon\Carbon::parse($item['expires'])->format('Y') }}</span>
                            @endif
                        @else
                            <span class="text-green-700 dark:text-green-400">Available</span>
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>

    @else
        <div class="flex items-center justify-center py-10">
            <p class="text-sm text-[#a1a1aa]">Enter a domain to check extensions</p>
        </div>
    @endif
</div>
