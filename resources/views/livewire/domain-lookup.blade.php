<div>
    <div class="flex flex-col sm:flex-row gap-3">
        <input
            wire:model="query"
            wire:keydown.enter="search"
            type="text"
            placeholder="google.com"
            autocomplete="off"
            spellcheck="false"
            class="flex-1 bg-white dark:bg-[#111111] border border-[#e4e4e7] dark:border-[#1f1f1f] text-[#09090b] dark:text-[#f4f4f5] placeholder-[#a1a1aa] dark:placeholder-[#3f3f46] rounded-lg px-4 py-3 font-mono text-sm focus:outline-none focus:border-indigo-400 focus:ring-1 focus:ring-indigo-400/30 transition-colors shadow-sm dark:shadow-none"
        />
        <button
            wire:click="search"
            wire:loading.attr="disabled"
            class="px-6 py-3 bg-indigo-500 hover:bg-indigo-600 disabled:opacity-60 text-white font-medium rounded-lg transition-colors text-sm whitespace-nowrap shadow-sm"
        >
            <span wire:loading.remove wire:target="search">Look up →</span>
            <span wire:loading wire:target="search" class="inline-flex items-center gap-2">
                <svg class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                </svg>
                Searching...
            </span>
        </button>
    </div>

    @if($error)
        <p class="mt-3 text-sm text-red-600 dark:text-red-400 flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M12 2a10 10 0 100 20A10 10 0 0012 2z"/>
            </svg>
            {{ $error }}
        </p>
    @endif

    {{-- Always in DOM so children receive events; invisible until first search --}}
    <div class="{{ $searched ? 'grid grid-cols-1 lg:grid-cols-2 gap-4 mt-8' : 'hidden' }}">
        <livewire:domain-info-card />
        <livewire:dns-records-card />
        <livewire:availability-card />
        <livewire:bulk-checker-card />
    </div>
</div>
