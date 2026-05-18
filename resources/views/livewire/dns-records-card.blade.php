<div class="bg-white dark:bg-[#111111] border border-[#e4e4e7] dark:border-[#1f1f1f] rounded-lg p-6 min-h-[200px] shadow-sm dark:shadow-none">
    <h3 class="text-xs font-medium text-[#71717a] uppercase tracking-wider mb-5">DNS Records</h3>

    @if($loading)
        <div class="animate-pulse">
            <div class="flex gap-2 mb-5">
                @foreach(['A', 'MX', 'NS', 'TXT'] as $_)
                    <div class="h-6 bg-[#e4e4e7] dark:bg-[#1f1f1f] rounded w-10"></div>
                @endforeach
            </div>
            <div class="space-y-2.5">
                @foreach(range(1, 5) as $_)
                    <div class="flex gap-6">
                        <div class="h-3 bg-[#e4e4e7] dark:bg-[#1f1f1f] rounded w-1/2"></div>
                        <div class="h-3 bg-[#e4e4e7] dark:bg-[#1f1f1f] rounded w-1/5"></div>
                    </div>
                @endforeach
            </div>
        </div>

    @elseif($error)
        <div class="flex items-center gap-2 text-[#71717a] text-sm py-8">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.962-.833-2.732 0L3.27 16.5c-.77.833.192 2.5 1.732 2.5z"/>
            </svg>
            {{ $error }}
        </div>

    @elseif(!empty($records))
        @php $firstTab = array_key_first($records); @endphp
        <div x-data="{ tab: '{{ $firstTab }}' }">
            <div class="flex flex-wrap gap-1 mb-5">
                @foreach(array_keys($records) as $type)
                    <button
                        @click="tab = '{{ $type }}'"
                        :class="tab === '{{ $type }}' ? 'bg-indigo-50 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 border-indigo-200 dark:border-indigo-500/30' : 'text-[#71717a] hover:text-[#09090b] dark:hover:text-[#f4f4f5] hover:bg-[#f4f4f5] dark:hover:bg-[#1f1f1f] border-transparent'"
                        class="px-3 py-1 text-xs rounded border transition-colors font-mono"
                    >{{ $type }}</button>
                @endforeach
            </div>

            @foreach($records as $type => $typeRecords)
                <div x-show="tab === '{{ $type }}'" @if(!$loop->first) style="display:none" @endif>
                    @if($type === 'SOA' && !empty($typeRecords[0]))
                        <dl class="space-y-1.5">
                            @foreach($typeRecords[0] as $key => $val)
                                @if(!in_array($key, ['host', 'ttl']) && $val !== null)
                                    <div class="flex gap-4 text-xs">
                                        <dt class="text-[#71717a] font-mono w-20 shrink-0">{{ $key }}</dt>
                                        <dd class="text-[#52525b] dark:text-[#a1a1aa] font-mono break-all">{{ $val }}</dd>
                                    </div>
                                @endif
                            @endforeach
                        </dl>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-xs">
                                <thead>
                                    <tr class="text-left border-b border-[#e4e4e7] dark:border-[#1f1f1f]">
                                        @if($type === 'A')
                                            <th class="pb-2 pr-4 font-medium text-[#71717a]">IP</th>
                                            <th class="pb-2 font-medium text-[#71717a]">TTL</th>
                                        @elseif($type === 'AAAA')
                                            <th class="pb-2 pr-4 font-medium text-[#71717a]">IPv6</th>
                                            <th class="pb-2 font-medium text-[#71717a]">TTL</th>
                                        @elseif($type === 'MX')
                                            <th class="pb-2 pr-4 font-medium text-[#71717a]">Priority</th>
                                            <th class="pb-2 pr-4 font-medium text-[#71717a]">Mail server</th>
                                            <th class="pb-2 font-medium text-[#71717a]">TTL</th>
                                        @elseif($type === 'TXT')
                                            <th class="pb-2 pr-4 font-medium text-[#71717a]">Value</th>
                                            <th class="pb-2 font-medium text-[#71717a]">TTL</th>
                                        @elseif($type === 'NS' || $type === 'CNAME')
                                            <th class="pb-2 pr-4 font-medium text-[#71717a]">Nameserver</th>
                                            <th class="pb-2 font-medium text-[#71717a]">TTL</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#f4f4f5] dark:divide-[#1a1a1a]">
                                    @foreach($typeRecords as $record)
                                        <tr>
                                            @if($type === 'A')
                                                <td class="py-2 pr-4 font-mono">{{ $record['ip'] ?? '—' }}</td>
                                                <td class="py-2 text-[#71717a]">{{ $record['ttl'] ?? '—' }}</td>
                                            @elseif($type === 'AAAA')
                                                <td class="py-2 pr-4 font-mono break-all">{{ $record['ipv6'] ?? '—' }}</td>
                                                <td class="py-2 text-[#71717a] whitespace-nowrap">{{ $record['ttl'] ?? '—' }}</td>
                                            @elseif($type === 'MX')
                                                <td class="py-2 pr-4 text-[#71717a]">{{ $record['priority'] ?? '—' }}</td>
                                                <td class="py-2 pr-4 font-mono">{{ $record['target'] ?? '—' }}</td>
                                                <td class="py-2 text-[#71717a]">{{ $record['ttl'] ?? '—' }}</td>
                                            @elseif($type === 'TXT')
                                                @php $txt = $record['txt'] ?? ''; @endphp
                                                <td class="py-2 pr-4 font-mono text-[#52525b] dark:text-[#a1a1aa]" x-data="{ expanded: false }">
                                                    <span x-show="!expanded">{{ Str::limit($txt, 80) }}</span>
                                                    <span x-show="expanded" style="display:none" class="break-all">{{ $txt }}</span>
                                                    @if(strlen($txt) > 80)
                                                        <button @click="expanded = !expanded" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 ml-1 text-[10px]" x-text="expanded ? '↑ collapse' : '↓ expand'"></button>
                                                    @endif
                                                </td>
                                                <td class="py-2 text-[#71717a] whitespace-nowrap">{{ $record['ttl'] ?? '—' }}</td>
                                            @elseif($type === 'NS' || $type === 'CNAME')
                                                <td class="py-2 pr-4 font-mono">{{ $record['target'] ?? '—' }}</td>
                                                <td class="py-2 text-[#71717a]">{{ $record['ttl'] ?? '—' }}</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

    @else
        <div class="flex items-center justify-center py-10">
            <p class="text-sm text-[#a1a1aa]">Enter a domain above to see DNS records</p>
        </div>
    @endif
</div>
