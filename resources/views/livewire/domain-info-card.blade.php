<div class="bg-white dark:bg-[#111111] border border-[#e4e4e7] dark:border-[#1f1f1f] rounded-lg p-6 min-h-[200px] shadow-sm dark:shadow-none">
    <h3 class="text-xs font-medium text-[#71717a] uppercase tracking-wider mb-5">Domain Info</h3>

    @if($loading)
        <div class="animate-pulse grid grid-cols-2 gap-6">
            <div>
                <div class="h-5 bg-[#e4e4e7] dark:bg-[#1f1f1f] rounded w-3/4 mb-2"></div>
                <div class="h-3 bg-[#e4e4e7] dark:bg-[#1f1f1f] rounded w-1/2 mb-5"></div>
                <div class="space-y-3">
                    @foreach(range(1, 4) as $_)
                        <div class="flex justify-between items-center">
                            <div class="h-3 bg-[#e4e4e7] dark:bg-[#1f1f1f] rounded w-1/3"></div>
                            <div class="h-3 bg-[#e4e4e7] dark:bg-[#1f1f1f] rounded w-1/4"></div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div>
                <div class="flex flex-wrap gap-2 mb-5">
                    <div class="h-5 bg-[#e4e4e7] dark:bg-[#1f1f1f] rounded w-20"></div>
                    <div class="h-5 bg-[#e4e4e7] dark:bg-[#1f1f1f] rounded w-24"></div>
                    <div class="h-5 bg-[#e4e4e7] dark:bg-[#1f1f1f] rounded w-16"></div>
                </div>
                <div class="space-y-2">
                    <div class="h-3 bg-[#e4e4e7] dark:bg-[#1f1f1f] rounded w-full"></div>
                    <div class="h-3 bg-[#e4e4e7] dark:bg-[#1f1f1f] rounded w-4/5"></div>
                    <div class="h-3 bg-[#e4e4e7] dark:bg-[#1f1f1f] rounded w-full"></div>
                </div>
            </div>
        </div>

    @elseif($error)
        <div class="flex items-center gap-2 text-[#71717a] text-sm py-8">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.962-.833-2.732 0L3.27 16.5c-.77.833.192 2.5 1.732 2.5z"/>
            </svg>
            {{ $error }}
        </div>

    @elseif($info)
        @php
            $expiresAt      = !empty($info['dates']['expires']) ? \Carbon\Carbon::parse($info['dates']['expires']) : null;
            $isExpiringSoon = $expiresAt && $expiresAt->lt(now()->addDays(30));
            $fmt            = fn(?string $d) => $d ? \Carbon\Carbon::parse($d)->format('M j, Y') : '—';
        @endphp
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <p class="text-base font-medium truncate">{{ $info['registrar']['name'] ?? '—' }}</p>
                @if(!empty($info['registrar']['url']))
                    <a href="{{ $info['registrar']['url'] }}" target="_blank" rel="noopener"
                       class="text-xs text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 truncate block mt-0.5 transition-colors">
                        {{ $info['registrar']['url'] }}
                    </a>
                @endif
                <dl class="mt-4 space-y-2.5">
                    <div class="flex justify-between items-center">
                        <dt class="text-xs text-[#71717a]">Registered on</dt>
                        <dd class="font-mono text-xs text-[#52525b] dark:text-[#a1a1aa]">{{ $fmt($info['dates']['registered']) }}</dd>
                    </div>
                    <div class="flex justify-between items-center">
                        <dt class="text-xs text-[#71717a]">Expires on</dt>
                        <dd class="font-mono text-xs {{ $isExpiringSoon ? 'text-red-600 dark:text-red-400' : 'text-[#52525b] dark:text-[#a1a1aa]' }}">
                            {{ $fmt($info['dates']['expires']) }}
                            @if($isExpiringSoon)
                                <span class="ml-1 text-[10px] bg-red-50 dark:bg-red-500/20 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-500/30 px-1 rounded">soon</span>
                            @endif
                        </dd>
                    </div>
                    <div class="flex justify-between items-center">
                        <dt class="text-xs text-[#71717a]">Last updated</dt>
                        <dd class="font-mono text-xs text-[#52525b] dark:text-[#a1a1aa]">{{ $fmt($info['dates']['updated']) }}</dd>
                    </div>
                    <div class="flex justify-between items-center">
                        <dt class="text-xs text-[#71717a]">DNSSEC</dt>
                        <dd>
                            @if($info['dnssec'])
                                <span class="px-2 py-0.5 text-[10px] font-medium bg-green-50 dark:bg-green-500/20 text-green-700 dark:text-green-400 border border-green-200 dark:border-green-500/30 rounded">Enabled</span>
                            @else
                                <span class="px-2 py-0.5 text-[10px] font-medium bg-[#f4f4f5] dark:bg-[#1f1f1f] text-[#71717a] rounded">Disabled</span>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>
            <div>
                @if(!empty($info['status']))
                    <div class="flex flex-wrap gap-1.5 mb-4">
                        @foreach($info['status'] as $status)
                            <span class="px-2 py-0.5 text-[10px] font-mono bg-[#f4f4f5] dark:bg-[#1f1f1f] border border-[#e4e4e7] dark:border-[#2a2a2a] text-[#52525b] dark:text-[#71717a] rounded">{{ $status }}</span>
                        @endforeach
                    </div>
                @endif
                @if(!empty($info['nameservers']))
                    <ul class="space-y-1">
                        @foreach($info['nameservers'] as $ns)
                            <li class="font-mono text-xs text-[#52525b] dark:text-[#a1a1aa] truncate">{{ $ns }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

    @else
        <div class="flex items-center justify-center py-10">
            <p class="text-sm text-[#a1a1aa]">Enter a domain above to see RDAP data</p>
        </div>
    @endif
</div>
