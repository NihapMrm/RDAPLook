@extends('layouts.app')

@section('title', 'API Reference — RDAPLook')
@section('meta_description', 'Complete API documentation for RDAPLook — RDAP lookup, DNS records, domain availability, and bulk checks.')

@section('content')
<div
    x-data="{
        active: 'introduction',
        init() {
            const io = new IntersectionObserver(entries => {
                entries.forEach(e => { if (e.isIntersecting) this.active = e.target.id; });
            }, { rootMargin: '-15% 0px -70% 0px' });
            document.querySelectorAll('section[id]').forEach(s => io.observe(s));
        }
    }"
    class="flex flex-col pt-16 min-h-screen"
>

{{-- ── Mobile nav (horizontal scroll pills, hidden on lg+) ─────────────── --}}
<div class="lg:hidden sticky top-16 z-40 bg-white/90 dark:bg-[#0a0a0a]/90 backdrop-blur-md border-b border-[#e4e4e7] dark:border-[#1f1f1f] px-4 py-2 overflow-x-auto flex items-center gap-1.5 flex-nowrap" style="scrollbar-width:none">
    @foreach([
        ['introduction',   'Introduction'],
        ['authentication', 'Authentication'],
        ['rate-limits',    'Rate Limits'],
        ['errors',         'Errors'],
        ['domain-lookup',  'Domain'],
        ['dns-records',    'DNS Records'],
        ['availability',   'Availability'],
        ['bulk-check',     'Bulk Check'],
    ] as [$id, $label])
    <a href="#{{ $id }}"
       :class="active === '{{ $id }}' ? 'bg-indigo-500 text-white' : 'bg-[#f4f4f5] dark:bg-[#1a1a1a] text-[#52525b] dark:text-[#a1a1aa] hover:bg-[#e4e4e7] dark:hover:bg-[#252525]'"
       class="shrink-0 px-3 py-1 rounded-full text-xs font-medium transition-colors whitespace-nowrap">{{ $label }}</a>
    @endforeach
</div>

{{-- ── Sidebar + Main ───────────────────────────────────────────────────── --}}
<div class="flex flex-1">

{{-- ── Sidebar ──────────────────────────────────────────────────────────── --}}
<aside class="hidden lg:flex flex-col sticky top-16 h-[calc(100vh-4rem)] w-56 xl:w-60 shrink-0 overflow-y-auto border-r border-[#e4e4e7] dark:border-[#1f1f1f] py-7 bg-white dark:bg-[#0a0a0a]">
    <div class="px-5 mb-6 flex items-center gap-2">
        <span class="text-sm font-semibold tracking-tight">API Reference</span>
        <span class="text-[10px] font-mono text-[#a1a1aa] bg-[#f4f4f5] dark:bg-[#1a1a1a] border border-[#e4e4e7] dark:border-[#2a2a2a] px-1.5 py-0.5 rounded">v1</span>
    </div>

    <div class="px-3 mb-4">
        <p class="px-2 mb-1.5 text-[10px] font-semibold uppercase tracking-widest text-[#a1a1aa]">Overview</p>
        @foreach([
            ['introduction',   'Introduction'],
            ['authentication', 'Authentication'],
            ['rate-limits',    'Rate Limits'],
            ['errors',         'Errors'],
        ] as [$id, $label])
        <a href="#{{ $id }}"
           :class="active === '{{ $id }}' ? 'bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-medium' : 'text-[#71717a] hover:text-[#09090b] dark:hover:text-[#f4f4f5] hover:bg-[#f4f4f5] dark:hover:bg-[#1a1a1a]'"
           class="flex items-center px-2 py-1.5 rounded-md text-sm transition-colors mb-0.5">{{ $label }}</a>
        @endforeach
    </div>

    <div class="px-3">
        <p class="px-2 mb-1.5 text-[10px] font-semibold uppercase tracking-widest text-[#a1a1aa]">Endpoints</p>
        @foreach([
            ['domain-lookup', 'GET',  'text-emerald-600 dark:text-emerald-400', 'Domain'],
            ['dns-records',   'GET',  'text-emerald-600 dark:text-emerald-400', 'DNS Records'],
            ['availability',  'GET',  'text-emerald-600 dark:text-emerald-400', 'Availability'],
            ['bulk-check',    'POST', 'text-amber-600 dark:text-amber-400',     'Bulk Check'],
        ] as [$id, $method, $color, $label])
        <a href="#{{ $id }}"
           :class="active === '{{ $id }}' ? 'bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-medium' : 'text-[#71717a] hover:text-[#09090b] dark:hover:text-[#f4f4f5] hover:bg-[#f4f4f5] dark:hover:bg-[#1a1a1a]'"
           class="flex items-center gap-2 px-2 py-1.5 rounded-md text-sm transition-colors mb-0.5">
            <span class="text-[10px] font-mono font-bold shrink-0 {{ $color }}">{{ $method }}</span>
            {{ $label }}
        </a>
        @endforeach
    </div>

    <div class="mt-auto px-3 pt-6">
        <div class="border-t border-[#e4e4e7] dark:border-[#1f1f1f] pt-5 px-2">
            <a href="https://rapidapi.com/rdaplook/api/rdaplook" target="_blank" rel="noopener"
               class="flex items-center justify-center gap-1.5 w-full px-3 py-2 text-xs font-medium bg-indigo-500 hover:bg-indigo-600 text-white rounded-md transition-colors">
                Get API Key
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>
        </div>
    </div>
</aside>

{{-- ── Main ─────────────────────────────────────────────────────────────── --}}
<main class="flex-1 min-w-0 divide-y divide-[#e4e4e7] dark:divide-[#1f1f1f]">

    {{-- ─── Introduction ───────────────────────────────────────────────────── --}}
    <section id="introduction" class="px-6 sm:px-10 xl:px-14 py-12">
        <div class="max-w-3xl mx-auto">
            <div class="inline-flex items-center gap-2 px-3 py-1 mb-6 text-xs font-medium bg-white dark:bg-[#111] text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-500/30 rounded-full shadow-sm">
                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 shrink-0"></span>
                REST API · JSON · v1
            </div>
            <h1 class="text-3xl font-semibold tracking-tight mb-3">API Reference</h1>
            <p class="text-[#71717a] leading-relaxed mb-8">The RDAPLook API gives you structured domain intelligence — RDAP registration data, DNS records, and availability checks — via simple HTTP. All responses are JSON.</p>

            <p class="text-xs font-semibold uppercase tracking-widest text-[#71717a] mb-2">Base URL</p>
            <div class="flex items-center font-mono text-sm bg-[#f4f4f5] dark:bg-[#0f0f0f] border border-[#e4e4e7] dark:border-[#1f1f1f] rounded-lg px-4 py-3 mb-8 overflow-x-auto">
                <span class="text-[#a1a1aa]">https://</span><span class="text-indigo-500 dark:text-indigo-400">rdaplook.p.rapidapi.com</span><span class="text-[#71717a]">/api/v1</span>
            </div>

            <div class="rounded-xl border border-[#e4e4e7] dark:border-[#1f1f1f] overflow-hidden">
                <div class="px-4 py-2.5 bg-[#fafafa] dark:bg-[#111] border-b border-[#e4e4e7] dark:border-[#1f1f1f]">
                    <p class="text-xs font-semibold text-[#71717a] uppercase tracking-widest">Endpoints</p>
                </div>
                @foreach([
                    ['GET',  '/api/v1/domain/{domain}',       'Full RDAP registration data'],
                    ['GET',  '/api/v1/dns/{domain}',          'A, AAAA, MX, NS, TXT, CNAME, SOA'],
                    ['GET',  '/api/v1/availability/{domain}', 'Is the domain registered?'],
                    ['POST', '/api/v1/bulk',                  'Check up to 20 domains at once'],
                ] as [$m, $path, $desc])
                <div class="flex items-center gap-4 px-4 py-3 border-b border-[#e4e4e7] dark:border-[#1f1f1f] last:border-0">
                    @if($m === 'GET')
                    <span class="shrink-0 px-1.5 py-0.5 text-[10px] font-mono font-bold bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20 rounded">GET</span>
                    @else
                    <span class="shrink-0 px-1.5 py-0.5 text-[10px] font-mono font-bold bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-500/20 rounded">POST</span>
                    @endif
                    <code class="text-xs font-mono text-[#52525b] dark:text-[#a1a1aa] flex-1">{{ $path }}</code>
                    <span class="text-xs text-[#71717a] hidden sm:block">{{ $desc }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ─── Authentication ─────────────────────────────────────────────────── --}}
    <section id="authentication" class="px-6 sm:px-10 xl:px-14 py-12">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-xl font-semibold tracking-tight mb-2">Authentication</h2>
            <p class="text-sm text-[#71717a] mb-6 leading-relaxed">API access is managed through <a href="https://rapidapi.com/rdaplook/api/rdaplook" target="_blank" rel="noopener" class="text-indigo-500 hover:text-indigo-600 underline underline-offset-2 transition-colors">RapidAPI</a>. Every request must include two headers from your RapidAPI subscription.</p>

            <div class="rounded-xl border border-[#e4e4e7] dark:border-[#1f1f1f] overflow-hidden mb-6">
                <div class="grid docs-cols-auth gap-4 px-4 py-2.5 bg-[#fafafa] dark:bg-[#111] border-b border-[#e4e4e7] dark:border-[#1f1f1f] text-xs font-semibold text-[#71717a] uppercase tracking-widest">
                    <span></span><span>Header</span><span>Value</span>
                </div>
                <div class="grid docs-cols-auth items-center gap-4 px-4 py-3 border-b border-[#e4e4e7] dark:border-[#1f1f1f]">
                    <span class="w-2 h-2 rounded-full bg-rose-400 shrink-0"></span>
                    <code class="text-xs font-mono text-indigo-500 dark:text-indigo-400">X-RapidAPI-Key</code>
                    <span class="text-sm text-[#71717a]">Your personal RapidAPI key</span>
                </div>
                <div class="grid docs-cols-auth items-center gap-4 px-4 py-3">
                    <span class="w-2 h-2 rounded-full bg-rose-400 shrink-0"></span>
                    <code class="text-xs font-mono text-indigo-500 dark:text-indigo-400">X-RapidAPI-Host</code>
                    <code class="text-xs font-mono text-[#71717a]">rdaplook.p.rapidapi.com</code>
                </div>
            </div>
            <p class="text-sm text-[#71717a]">Requests with a missing or invalid key return <code class="text-xs font-mono bg-[#f4f4f5] dark:bg-[#1a1a1a] px-1.5 py-0.5 rounded">403 Forbidden</code>.</p>
        </div>
    </section>

    {{-- ─── Rate Limits ─────────────────────────────────────────────────────── --}}
    <section id="rate-limits" class="px-6 sm:px-10 xl:px-14 py-12">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-xl font-semibold tracking-tight mb-2">Rate Limits</h2>
            <p class="text-sm text-[#71717a] mb-6">Limits are enforced per RapidAPI plan. Counters reset daily at midnight UTC.</p>

            <div class="rounded-xl border border-[#e4e4e7] dark:border-[#1f1f1f] overflow-hidden mb-6">
                <div class="grid grid-cols-3 gap-4 px-4 py-2.5 bg-[#fafafa] dark:bg-[#111] border-b border-[#e4e4e7] dark:border-[#1f1f1f] text-xs font-semibold text-[#71717a] uppercase tracking-widest">
                    <span>Plan</span><span>Requests / day</span><span>Price</span>
                </div>
                <div class="grid grid-cols-3 items-center gap-4 px-4 py-3 border-b border-[#e4e4e7] dark:border-[#1f1f1f]">
                    <span class="text-sm font-medium">Free</span>
                    <span class="text-sm text-[#71717a]">2,000</span>
                    <span class="text-sm text-[#71717a]">$0 / mo</span>
                </div>
                <div class="grid grid-cols-3 items-center gap-4 px-4 py-3">
                    <span class="text-sm font-medium">Pro</span>
                    <span class="text-sm text-[#71717a]">50,000</span>
                    <span class="text-sm text-[#71717a]">$4 / mo</span>
                </div>
            </div>
            <p class="text-sm text-[#71717a]">Exceeding your limit returns <code class="text-xs font-mono bg-[#f4f4f5] dark:bg-[#1a1a1a] px-1.5 py-0.5 rounded">429 Too Many Requests</code>.</p>
        </div>
    </section>

    {{-- ─── Errors ──────────────────────────────────────────────────────────── --}}
    <section id="errors" class="px-6 sm:px-10 xl:px-14 py-12">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-xl font-semibold tracking-tight mb-2">Errors</h2>
            <p class="text-sm text-[#71717a] mb-6">All error responses share the same envelope:</p>

            <div class="rounded-xl overflow-hidden border border-[#252525] shadow-xl mb-8">
                <div class="bg-[#1c1c1c] px-4 py-2.5 flex items-center gap-2.5 border-b border-[#2a2a2a]">
                    <div class="flex gap-1.5"><div class="w-3 h-3 rounded-full bg-[#ff5f57]"></div><div class="w-3 h-3 rounded-full bg-[#febc2e]"></div><div class="w-3 h-3 rounded-full bg-[#28c840]"></div></div>
                    <span class="text-xs text-[#52525b] font-mono">error response</span>
                </div>
                <pre class="bg-[#0d0d0d] px-5 py-4 text-[13px] font-mono leading-relaxed text-[#a1a1aa] overflow-x-auto whitespace-pre">{
  <span class="text-sky-400">"error"</span>:   <span class="text-amber-400">true</span>,
  <span class="text-sky-400">"code"</span>:    <span class="text-emerald-400">"DOMAIN_NOT_FOUND"</span>,
  <span class="text-sky-400">"message"</span>: <span class="text-emerald-400">"Domain not found in RDAP registry."</span>
}</pre>
            </div>

            <div class="rounded-xl border border-[#e4e4e7] dark:border-[#1f1f1f] overflow-hidden">
                <div class="grid docs-cols-errors gap-4 px-4 py-2.5 bg-[#fafafa] dark:bg-[#111] border-b border-[#e4e4e7] dark:border-[#1f1f1f] text-xs font-semibold text-[#71717a] uppercase tracking-widest">
                    <span>Code</span><span>HTTP</span><span>Meaning</span>
                </div>
                @foreach([
                    ['INVALID_DOMAIN',   '422', 'Malformed or invalid domain name'],
                    ['DOMAIN_NOT_FOUND', '404', 'Domain has no RDAP record'],
                    ['RDAP_UNAVAILABLE', '503', 'Upstream RDAP registry unreachable'],
                    ['VALIDATION_ERROR', '422', 'Invalid request body (bulk endpoint)'],
                    ['FORBIDDEN',        '403', 'Missing or invalid API key'],
                ] as [$code, $status, $meaning])
                <div class="grid docs-cols-errors items-center gap-4 px-4 py-3 border-b border-[#e4e4e7] dark:border-[#1f1f1f] last:border-0">
                    <code class="text-xs font-mono text-rose-500 dark:text-rose-400">{{ $code }}</code>
                    <span class="text-xs font-mono text-[#71717a]">{{ $status }}</span>
                    <span class="text-sm text-[#71717a]">{{ $meaning }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ─── Domain RDAP ─────────────────────────────────────────────────────── --}}
    <section id="domain-lookup" class="px-6 sm:px-10 xl:px-14 py-12">
        <div class="max-w-5xl mx-auto">
            <div class="flex flex-wrap items-center gap-3 mb-1">
                <span class="px-2 py-1 text-[11px] font-mono font-bold rounded bg-emerald-50 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20">GET</span>
                <code class="font-mono text-sm text-[#09090b] dark:text-[#e4e4e7]">/api/v1/domain/{domain}</code>
            </div>
            <h2 class="text-xl font-semibold tracking-tight mb-2">Domain RDAP Lookup</h2>
            <p class="text-sm text-[#71717a] mb-8 leading-relaxed">Returns normalized RDAP data for the given domain: registrar info, registration dates, nameservers, status flags, DNSSEC, and contact details (where disclosed by the registry).</p>

            <p class="text-xs font-semibold uppercase tracking-widest text-[#71717a] mb-3">URL Parameters</p>
            <div class="rounded-xl border border-[#e4e4e7] dark:border-[#1f1f1f] overflow-hidden mb-5">
                <div class="grid docs-cols-params gap-4 px-4 py-2.5 bg-[#fafafa] dark:bg-[#111] border-b border-[#e4e4e7] dark:border-[#1f1f1f] text-xs font-semibold text-[#71717a] uppercase tracking-widest"><span>Name</span><span>Type</span><span></span><span>Description</span></div>
                <div class="grid docs-cols-params items-center gap-4 px-4 py-3">
                    <code class="text-xs font-mono text-indigo-500 dark:text-indigo-400">domain</code>
                    <span class="text-xs text-[#71717a]">string</span>
                    <span class="text-[10px] font-medium text-rose-500 dark:text-rose-400 bg-rose-50 dark:bg-rose-500/10 px-1.5 py-0.5 rounded border border-rose-200 dark:border-rose-500/20 whitespace-nowrap">required</span>
                    <span class="text-sm text-[#71717a]">The domain name to look up</span>
                </div>
            </div>

            <p class="text-xs font-semibold uppercase tracking-widest text-[#71717a] mb-3">Query Parameters</p>
            <div class="rounded-xl border border-[#e4e4e7] dark:border-[#1f1f1f] overflow-hidden mb-8">
                <div class="grid docs-cols-params gap-4 px-4 py-2.5 bg-[#fafafa] dark:bg-[#111] border-b border-[#e4e4e7] dark:border-[#1f1f1f] text-xs font-semibold text-[#71717a] uppercase tracking-widest"><span>Name</span><span>Type</span><span></span><span>Description</span></div>
                <div class="grid docs-cols-params items-center gap-4 px-4 py-3">
                    <code class="text-xs font-mono text-indigo-500 dark:text-indigo-400">raw</code>
                    <span class="text-xs text-[#71717a]">boolean</span>
                    <span class="text-[10px] font-medium text-[#71717a] bg-[#f4f4f5] dark:bg-[#1a1a1a] px-1.5 py-0.5 rounded border border-[#e4e4e7] dark:border-[#2a2a2a] whitespace-nowrap">optional</span>
                    <span class="text-sm text-[#71717a]">Include raw RDAP response under <code class="text-xs font-mono bg-[#f4f4f5] dark:bg-[#1a1a1a] px-1 rounded">raw_rdap</code>. Default: <code class="text-xs font-mono bg-[#f4f4f5] dark:bg-[#1a1a1a] px-1 rounded">false</code></span>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
                {{-- Request --}}
                <div x-data="editor()" class="rounded-xl overflow-hidden border border-[#252525] shadow-xl flex flex-col">
                    <div class="bg-[#1c1c1c] px-4 py-3 flex items-center gap-3 border-b border-[#2a2a2a] shrink-0">
                        <div class="flex gap-1.5 shrink-0"><div class="w-3 h-3 rounded-full bg-[#ff5f57]"></div><div class="w-3 h-3 rounded-full bg-[#febc2e]"></div><div class="w-3 h-3 rounded-full bg-[#28c840]"></div></div>
                        <div class="flex gap-0.5 overflow-x-auto flex-1 min-w-0" style="scrollbar-width:none">
                            @foreach([['curl','cURL','#e97316'],['js','JavaScript','#eab308'],['php','PHP','#8b5cf6'],['python','Python','#3b82f6']] as [$k,$l,$c])
                            <button @click="tab='{{ $k }}'" :class="tab==='{{ $k }}' ? 'bg-[#2a2a2a] text-[#f4f4f5]' : 'text-[#71717a] hover:text-[#a1a1aa] hover:bg-[#222]'" class="flex items-center gap-1.5 px-3 py-1.5 text-xs rounded-md transition-colors whitespace-nowrap shrink-0">
                                <span class="w-2 h-2 rounded-full shrink-0" style="background:{{ $c }}"></span>{{ $l }}
                            </button>
                            @endforeach
                        </div>
                        <button @click="copy()" class="shrink-0 flex items-center gap-1.5 px-3 py-1.5 text-xs text-[#71717a] hover:text-[#f4f4f5] bg-[#252525] hover:bg-[#2a2a2a] border border-[#333] rounded-md transition-colors">
                            <svg x-show="!copied" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            <svg x-show="copied" style="display:none" class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span x-text="copied ? 'Copied!' : 'Copy'"></span>
                        </button>
                    </div>
                    <div class="bg-[#0d0d0d] p-5 overflow-x-auto font-mono text-[13px] leading-relaxed text-[#a1a1aa] flex-1">
                        <pre data-tab="curl" x-show="tab==='curl'" class="whitespace-pre"><code><span class="text-amber-400">curl</span> <span class="text-emerald-400">"https://rdaplook.p.rapidapi.com/api/v1/domain/example.com"</span> \
  -H <span class="text-emerald-400">"X-RapidAPI-Key: YOUR_API_KEY"</span> \
  -H <span class="text-emerald-400">"X-RapidAPI-Host: rdaplook.p.rapidapi.com"</span></code></pre>
                        <pre data-tab="js" x-show="tab==='js'" style="display:none" class="whitespace-pre"><code><span class="text-purple-400">const</span> res = <span class="text-purple-400">await</span> <span class="text-amber-400">fetch</span>(
  <span class="text-emerald-400">"https://rdaplook.p.rapidapi.com/api/v1/domain/example.com"</span>,
  {
    headers: {
      <span class="text-emerald-400">"X-RapidAPI-Key"</span>:  <span class="text-emerald-400">"YOUR_API_KEY"</span>,
      <span class="text-emerald-400">"X-RapidAPI-Host"</span>: <span class="text-emerald-400">"rdaplook.p.rapidapi.com"</span>,
    },
  }
);
<span class="text-purple-400">const</span> data = <span class="text-purple-400">await</span> res.<span class="text-amber-400">json</span>();</code></pre>
                        <pre data-tab="php" x-show="tab==='php'" style="display:none" class="whitespace-pre"><code><span class="text-sky-400">$res</span> = Http::<span class="text-amber-400">withHeaders</span>([
    <span class="text-emerald-400">'X-RapidAPI-Key'</span>  => <span class="text-emerald-400">'YOUR_API_KEY'</span>,
    <span class="text-emerald-400">'X-RapidAPI-Host'</span> => <span class="text-emerald-400">'rdaplook.p.rapidapi.com'</span>,
])-><span class="text-amber-400">get</span>(<span class="text-emerald-400">'https://rdaplook.p.rapidapi.com/api/v1/domain/example.com'</span>);

<span class="text-sky-400">$data</span> = <span class="text-sky-400">$res</span>-><span class="text-amber-400">json</span>();</code></pre>
                        <pre data-tab="python" x-show="tab==='python'" style="display:none" class="whitespace-pre"><code><span class="text-purple-400">import</span> requests

res = requests.<span class="text-amber-400">get</span>(
    <span class="text-emerald-400">"https://rdaplook.p.rapidapi.com/api/v1/domain/example.com"</span>,
    headers={
        <span class="text-emerald-400">"X-RapidAPI-Key"</span>:  <span class="text-emerald-400">"YOUR_API_KEY"</span>,
        <span class="text-emerald-400">"X-RapidAPI-Host"</span>: <span class="text-emerald-400">"rdaplook.p.rapidapi.com"</span>,
    },
)
data = res.<span class="text-amber-400">json</span>()</code></pre>
                    </div>
                </div>
                {{-- Response --}}
                <div x-data="respEditor()" class="rounded-xl overflow-hidden border border-[#252525] shadow-xl flex flex-col">
                    <div class="bg-[#1c1c1c] px-4 py-3 flex items-center gap-3 border-b border-[#2a2a2a] shrink-0">
                        <div class="flex gap-1.5 shrink-0"><div class="w-3 h-3 rounded-full bg-[#ff5f57]"></div><div class="w-3 h-3 rounded-full bg-[#febc2e]"></div><div class="w-3 h-3 rounded-full bg-[#28c840]"></div></div>
                        <div class="flex-1 min-w-0 flex items-center gap-2 px-1">
                            <span class="text-xs font-mono font-bold text-emerald-400">200</span>
                            <span class="text-xs text-[#52525b]">application/json</span>
                        </div>
                        <button @click="copy()" class="shrink-0 flex items-center gap-1.5 px-3 py-1.5 text-xs text-[#71717a] hover:text-[#f4f4f5] bg-[#252525] hover:bg-[#2a2a2a] border border-[#333] rounded-md transition-colors">
                            <svg x-show="!copied" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            <svg x-show="copied" style="display:none" class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span x-text="copied ? 'Copied!' : 'Copy'"></span>
                        </button>
                    </div>
                    <div class="bg-[#0d0d0d] p-5 overflow-x-auto overflow-y-auto font-mono text-[13px] leading-relaxed text-[#a1a1aa] flex-1" style="max-height:340px">
                        <pre class="whitespace-pre"><code>{
  <span class="text-sky-400">"domain"</span>: <span class="text-emerald-400">"example.com"</span>,
  <span class="text-sky-400">"registrar"</span>: {
    <span class="text-sky-400">"name"</span>:    <span class="text-emerald-400">"MarkMonitor Inc."</span>,
    <span class="text-sky-400">"iana_id"</span>: <span class="text-emerald-400">"292"</span>,
    <span class="text-sky-400">"url"</span>:     <span class="text-emerald-400">"http://www.markmonitor.com"</span>
  },
  <span class="text-sky-400">"dates"</span>: {
    <span class="text-sky-400">"registered"</span>: <span class="text-emerald-400">"1997-09-15T04:00:00Z"</span>,
    <span class="text-sky-400">"updated"</span>:    <span class="text-emerald-400">"2019-09-09T15:39:04Z"</span>,
    <span class="text-sky-400">"expires"</span>:    <span class="text-emerald-400">"2028-09-14T04:00:00Z"</span>
  },
  <span class="text-sky-400">"nameservers"</span>: [
    <span class="text-emerald-400">"ns1.example.com"</span>,
    <span class="text-emerald-400">"ns2.example.com"</span>
  ],
  <span class="text-sky-400">"status"</span>: [
    <span class="text-emerald-400">"client delete prohibited"</span>,
    <span class="text-emerald-400">"client transfer prohibited"</span>
  ],
  <span class="text-sky-400">"dnssec"</span>: <span class="text-amber-400">false</span>,
  <span class="text-sky-400">"contacts"</span>: {
    <span class="text-sky-400">"registrant"</span>: <span class="text-zinc-500">null</span>,
    <span class="text-sky-400">"admin"</span>:      <span class="text-zinc-500">null</span>,
    <span class="text-sky-400">"tech"</span>:       <span class="text-zinc-500">null</span>
  }
}</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ─── DNS Records ──────────────────────────────────────────────────────── --}}
    <section id="dns-records" class="px-6 sm:px-10 xl:px-14 py-12">
        <div class="max-w-5xl mx-auto">
            <div class="flex flex-wrap items-center gap-3 mb-1">
                <span class="px-2 py-1 text-[11px] font-mono font-bold rounded bg-emerald-50 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20">GET</span>
                <code class="font-mono text-sm text-[#09090b] dark:text-[#e4e4e7]">/api/v1/dns/{domain}</code>
            </div>
            <h2 class="text-xl font-semibold tracking-tight mb-2">DNS Records</h2>
            <p class="text-sm text-[#71717a] mb-8 leading-relaxed">Resolves all DNS record types for a domain in a single call: A, AAAA, MX, NS, TXT, CNAME, and SOA.</p>

            <p class="text-xs font-semibold uppercase tracking-widest text-[#71717a] mb-3">URL Parameters</p>
            <div class="rounded-xl border border-[#e4e4e7] dark:border-[#1f1f1f] overflow-hidden mb-8">
                <div class="grid docs-cols-params gap-4 px-4 py-2.5 bg-[#fafafa] dark:bg-[#111] border-b border-[#e4e4e7] dark:border-[#1f1f1f] text-xs font-semibold text-[#71717a] uppercase tracking-widest"><span>Name</span><span>Type</span><span></span><span>Description</span></div>
                <div class="grid docs-cols-params items-center gap-4 px-4 py-3">
                    <code class="text-xs font-mono text-indigo-500 dark:text-indigo-400">domain</code>
                    <span class="text-xs text-[#71717a]">string</span>
                    <span class="text-[10px] font-medium text-rose-500 dark:text-rose-400 bg-rose-50 dark:bg-rose-500/10 px-1.5 py-0.5 rounded border border-rose-200 dark:border-rose-500/20 whitespace-nowrap">required</span>
                    <span class="text-sm text-[#71717a]">The domain name to resolve</span>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
                <div x-data="editor()" class="rounded-xl overflow-hidden border border-[#252525] shadow-xl flex flex-col">
                    <div class="bg-[#1c1c1c] px-4 py-3 flex items-center gap-3 border-b border-[#2a2a2a] shrink-0">
                        <div class="flex gap-1.5 shrink-0"><div class="w-3 h-3 rounded-full bg-[#ff5f57]"></div><div class="w-3 h-3 rounded-full bg-[#febc2e]"></div><div class="w-3 h-3 rounded-full bg-[#28c840]"></div></div>
                        <div class="flex gap-0.5 overflow-x-auto flex-1 min-w-0" style="scrollbar-width:none">
                            @foreach([['curl','cURL','#e97316'],['js','JavaScript','#eab308'],['php','PHP','#8b5cf6'],['python','Python','#3b82f6']] as [$k,$l,$c])
                            <button @click="tab='{{ $k }}'" :class="tab==='{{ $k }}' ? 'bg-[#2a2a2a] text-[#f4f4f5]' : 'text-[#71717a] hover:text-[#a1a1aa] hover:bg-[#222]'" class="flex items-center gap-1.5 px-3 py-1.5 text-xs rounded-md transition-colors whitespace-nowrap shrink-0">
                                <span class="w-2 h-2 rounded-full shrink-0" style="background:{{ $c }}"></span>{{ $l }}
                            </button>
                            @endforeach
                        </div>
                        <button @click="copy()" class="shrink-0 flex items-center gap-1.5 px-3 py-1.5 text-xs text-[#71717a] hover:text-[#f4f4f5] bg-[#252525] hover:bg-[#2a2a2a] border border-[#333] rounded-md transition-colors">
                            <svg x-show="!copied" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            <svg x-show="copied" style="display:none" class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span x-text="copied ? 'Copied!' : 'Copy'"></span>
                        </button>
                    </div>
                    <div class="bg-[#0d0d0d] p-5 overflow-x-auto font-mono text-[13px] leading-relaxed text-[#a1a1aa] flex-1">
                        <pre data-tab="curl" x-show="tab==='curl'" class="whitespace-pre"><code><span class="text-amber-400">curl</span> <span class="text-emerald-400">"https://rdaplook.p.rapidapi.com/api/v1/dns/example.com"</span> \
  -H <span class="text-emerald-400">"X-RapidAPI-Key: YOUR_API_KEY"</span> \
  -H <span class="text-emerald-400">"X-RapidAPI-Host: rdaplook.p.rapidapi.com"</span></code></pre>
                        <pre data-tab="js" x-show="tab==='js'" style="display:none" class="whitespace-pre"><code><span class="text-purple-400">const</span> res = <span class="text-purple-400">await</span> <span class="text-amber-400">fetch</span>(
  <span class="text-emerald-400">"https://rdaplook.p.rapidapi.com/api/v1/dns/example.com"</span>,
  { headers: { <span class="text-emerald-400">"X-RapidAPI-Key"</span>: <span class="text-emerald-400">"YOUR_API_KEY"</span>, <span class="text-emerald-400">"X-RapidAPI-Host"</span>: <span class="text-emerald-400">"rdaplook.p.rapidapi.com"</span> } }
);
<span class="text-purple-400">const</span> data = <span class="text-purple-400">await</span> res.<span class="text-amber-400">json</span>();</code></pre>
                        <pre data-tab="php" x-show="tab==='php'" style="display:none" class="whitespace-pre"><code><span class="text-sky-400">$res</span> = Http::<span class="text-amber-400">withHeaders</span>([
    <span class="text-emerald-400">'X-RapidAPI-Key'</span>  => <span class="text-emerald-400">'YOUR_API_KEY'</span>,
    <span class="text-emerald-400">'X-RapidAPI-Host'</span> => <span class="text-emerald-400">'rdaplook.p.rapidapi.com'</span>,
])-><span class="text-amber-400">get</span>(<span class="text-emerald-400">'https://rdaplook.p.rapidapi.com/api/v1/dns/example.com'</span>);
<span class="text-sky-400">$data</span> = <span class="text-sky-400">$res</span>-><span class="text-amber-400">json</span>();</code></pre>
                        <pre data-tab="python" x-show="tab==='python'" style="display:none" class="whitespace-pre"><code><span class="text-purple-400">import</span> requests

res = requests.<span class="text-amber-400">get</span>(
    <span class="text-emerald-400">"https://rdaplook.p.rapidapi.com/api/v1/dns/example.com"</span>,
    headers={ <span class="text-emerald-400">"X-RapidAPI-Key"</span>: <span class="text-emerald-400">"YOUR_API_KEY"</span>, <span class="text-emerald-400">"X-RapidAPI-Host"</span>: <span class="text-emerald-400">"rdaplook.p.rapidapi.com"</span> },
)
data = res.<span class="text-amber-400">json</span>()</code></pre>
                    </div>
                </div>
                <div x-data="respEditor()" class="rounded-xl overflow-hidden border border-[#252525] shadow-xl flex flex-col">
                    <div class="bg-[#1c1c1c] px-4 py-3 flex items-center gap-3 border-b border-[#2a2a2a] shrink-0">
                        <div class="flex gap-1.5 shrink-0"><div class="w-3 h-3 rounded-full bg-[#ff5f57]"></div><div class="w-3 h-3 rounded-full bg-[#febc2e]"></div><div class="w-3 h-3 rounded-full bg-[#28c840]"></div></div>
                        <div class="flex-1 min-w-0 flex items-center gap-2 px-1"><span class="text-xs font-mono font-bold text-emerald-400">200</span><span class="text-xs text-[#52525b]">application/json</span></div>
                        <button @click="copy()" class="shrink-0 flex items-center gap-1.5 px-3 py-1.5 text-xs text-[#71717a] hover:text-[#f4f4f5] bg-[#252525] hover:bg-[#2a2a2a] border border-[#333] rounded-md transition-colors">
                            <svg x-show="!copied" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            <svg x-show="copied" style="display:none" class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span x-text="copied ? 'Copied!' : 'Copy'"></span>
                        </button>
                    </div>
                    <div class="bg-[#0d0d0d] p-5 overflow-x-auto overflow-y-auto font-mono text-[13px] leading-relaxed text-[#a1a1aa] flex-1" style="max-height:340px">
                        <pre class="whitespace-pre"><code>{
  <span class="text-sky-400">"domain"</span>: <span class="text-emerald-400">"example.com"</span>,
  <span class="text-sky-400">"records"</span>: {
    <span class="text-sky-400">"A"</span>: [
      { <span class="text-sky-400">"host"</span>: <span class="text-emerald-400">"example.com"</span>, <span class="text-sky-400">"ip"</span>: <span class="text-emerald-400">"93.184.216.34"</span>, <span class="text-sky-400">"ttl"</span>: <span class="text-amber-400">3600</span> }
    ],
    <span class="text-sky-400">"AAAA"</span>: [
      { <span class="text-sky-400">"host"</span>: <span class="text-emerald-400">"example.com"</span>, <span class="text-sky-400">"ipv6"</span>: <span class="text-emerald-400">"2606:2800:21f:cb07:6820:80da:af6b:8b2c"</span>, <span class="text-sky-400">"ttl"</span>: <span class="text-amber-400">3600</span> }
    ],
    <span class="text-sky-400">"MX"</span>: [
      { <span class="text-sky-400">"host"</span>: <span class="text-emerald-400">"example.com"</span>, <span class="text-sky-400">"target"</span>: <span class="text-emerald-400">"mail.example.com"</span>, <span class="text-sky-400">"priority"</span>: <span class="text-amber-400">10</span>, <span class="text-sky-400">"ttl"</span>: <span class="text-amber-400">3600</span> }
    ],
    <span class="text-sky-400">"NS"</span>: [
      { <span class="text-sky-400">"target"</span>: <span class="text-emerald-400">"ns1.example.com"</span>, <span class="text-sky-400">"ttl"</span>: <span class="text-amber-400">3600</span> }
    ],
    <span class="text-sky-400">"TXT"</span>: [
      { <span class="text-sky-400">"txt"</span>: <span class="text-emerald-400">"v=spf1 -all"</span>, <span class="text-sky-400">"ttl"</span>: <span class="text-amber-400">3600</span> }
    ],
    <span class="text-sky-400">"CNAME"</span>: [],
    <span class="text-sky-400">"SOA"</span>: [
      { <span class="text-sky-400">"mname"</span>: <span class="text-emerald-400">"ns1.example.com"</span>, <span class="text-sky-400">"rname"</span>: <span class="text-emerald-400">"hostmaster.example.com"</span>, <span class="text-sky-400">"serial"</span>: <span class="text-amber-400">2023081301</span>, <span class="text-sky-400">"ttl"</span>: <span class="text-amber-400">3600</span> }
    ]
  }
}</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ─── Availability ─────────────────────────────────────────────────────── --}}
    <section id="availability" class="px-6 sm:px-10 xl:px-14 py-12">
        <div class="max-w-5xl mx-auto">
            <div class="flex flex-wrap items-center gap-3 mb-1">
                <span class="px-2 py-1 text-[11px] font-mono font-bold rounded bg-emerald-50 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20">GET</span>
                <code class="font-mono text-sm text-[#09090b] dark:text-[#e4e4e7]">/api/v1/availability/{domain}</code>
            </div>
            <h2 class="text-xl font-semibold tracking-tight mb-2">Domain Availability</h2>
            <p class="text-sm text-[#71717a] mb-8 leading-relaxed">Fast check whether a domain is registered or available for registration. Results are cached in Redis for 1 hour.</p>

            <p class="text-xs font-semibold uppercase tracking-widest text-[#71717a] mb-3">URL Parameters</p>
            <div class="rounded-xl border border-[#e4e4e7] dark:border-[#1f1f1f] overflow-hidden mb-8">
                <div class="grid docs-cols-params gap-4 px-4 py-2.5 bg-[#fafafa] dark:bg-[#111] border-b border-[#e4e4e7] dark:border-[#1f1f1f] text-xs font-semibold text-[#71717a] uppercase tracking-widest"><span>Name</span><span>Type</span><span></span><span>Description</span></div>
                <div class="grid docs-cols-params items-center gap-4 px-4 py-3">
                    <code class="text-xs font-mono text-indigo-500 dark:text-indigo-400">domain</code>
                    <span class="text-xs text-[#71717a]">string</span>
                    <span class="text-[10px] font-medium text-rose-500 dark:text-rose-400 bg-rose-50 dark:bg-rose-500/10 px-1.5 py-0.5 rounded border border-rose-200 dark:border-rose-500/20 whitespace-nowrap">required</span>
                    <span class="text-sm text-[#71717a]">The domain name to check</span>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
                <div x-data="editor()" class="rounded-xl overflow-hidden border border-[#252525] shadow-xl flex flex-col">
                    <div class="bg-[#1c1c1c] px-4 py-3 flex items-center gap-3 border-b border-[#2a2a2a] shrink-0">
                        <div class="flex gap-1.5 shrink-0"><div class="w-3 h-3 rounded-full bg-[#ff5f57]"></div><div class="w-3 h-3 rounded-full bg-[#febc2e]"></div><div class="w-3 h-3 rounded-full bg-[#28c840]"></div></div>
                        <div class="flex gap-0.5 overflow-x-auto flex-1 min-w-0" style="scrollbar-width:none">
                            @foreach([['curl','cURL','#e97316'],['js','JavaScript','#eab308'],['php','PHP','#8b5cf6'],['python','Python','#3b82f6']] as [$k,$l,$c])
                            <button @click="tab='{{ $k }}'" :class="tab==='{{ $k }}' ? 'bg-[#2a2a2a] text-[#f4f4f5]' : 'text-[#71717a] hover:text-[#a1a1aa] hover:bg-[#222]'" class="flex items-center gap-1.5 px-3 py-1.5 text-xs rounded-md transition-colors whitespace-nowrap shrink-0">
                                <span class="w-2 h-2 rounded-full shrink-0" style="background:{{ $c }}"></span>{{ $l }}
                            </button>
                            @endforeach
                        </div>
                        <button @click="copy()" class="shrink-0 flex items-center gap-1.5 px-3 py-1.5 text-xs text-[#71717a] hover:text-[#f4f4f5] bg-[#252525] hover:bg-[#2a2a2a] border border-[#333] rounded-md transition-colors">
                            <svg x-show="!copied" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            <svg x-show="copied" style="display:none" class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span x-text="copied ? 'Copied!' : 'Copy'"></span>
                        </button>
                    </div>
                    <div class="bg-[#0d0d0d] p-5 overflow-x-auto font-mono text-[13px] leading-relaxed text-[#a1a1aa] flex-1">
                        <pre data-tab="curl" x-show="tab==='curl'" class="whitespace-pre"><code><span class="text-amber-400">curl</span> <span class="text-emerald-400">"https://rdaplook.p.rapidapi.com/api/v1/availability/example.com"</span> \
  -H <span class="text-emerald-400">"X-RapidAPI-Key: YOUR_API_KEY"</span> \
  -H <span class="text-emerald-400">"X-RapidAPI-Host: rdaplook.p.rapidapi.com"</span></code></pre>
                        <pre data-tab="js" x-show="tab==='js'" style="display:none" class="whitespace-pre"><code><span class="text-purple-400">const</span> res = <span class="text-purple-400">await</span> <span class="text-amber-400">fetch</span>(
  <span class="text-emerald-400">"https://rdaplook.p.rapidapi.com/api/v1/availability/example.com"</span>,
  { headers: { <span class="text-emerald-400">"X-RapidAPI-Key"</span>: <span class="text-emerald-400">"YOUR_API_KEY"</span>, <span class="text-emerald-400">"X-RapidAPI-Host"</span>: <span class="text-emerald-400">"rdaplook.p.rapidapi.com"</span> } }
);
<span class="text-purple-400">const</span> data = <span class="text-purple-400">await</span> res.<span class="text-amber-400">json</span>();</code></pre>
                        <pre data-tab="php" x-show="tab==='php'" style="display:none" class="whitespace-pre"><code><span class="text-sky-400">$res</span> = Http::<span class="text-amber-400">withHeaders</span>([
    <span class="text-emerald-400">'X-RapidAPI-Key'</span>  => <span class="text-emerald-400">'YOUR_API_KEY'</span>,
    <span class="text-emerald-400">'X-RapidAPI-Host'</span> => <span class="text-emerald-400">'rdaplook.p.rapidapi.com'</span>,
])-><span class="text-amber-400">get</span>(<span class="text-emerald-400">'https://rdaplook.p.rapidapi.com/api/v1/availability/example.com'</span>);
<span class="text-sky-400">$data</span> = <span class="text-sky-400">$res</span>-><span class="text-amber-400">json</span>();</code></pre>
                        <pre data-tab="python" x-show="tab==='python'" style="display:none" class="whitespace-pre"><code><span class="text-purple-400">import</span> requests

res = requests.<span class="text-amber-400">get</span>(
    <span class="text-emerald-400">"https://rdaplook.p.rapidapi.com/api/v1/availability/example.com"</span>,
    headers={ <span class="text-emerald-400">"X-RapidAPI-Key"</span>: <span class="text-emerald-400">"YOUR_API_KEY"</span>, <span class="text-emerald-400">"X-RapidAPI-Host"</span>: <span class="text-emerald-400">"rdaplook.p.rapidapi.com"</span> },
)
data = res.<span class="text-amber-400">json</span>()</code></pre>
                    </div>
                </div>
                <div x-data="respEditor()" class="rounded-xl overflow-hidden border border-[#252525] shadow-xl flex flex-col">
                    <div class="bg-[#1c1c1c] px-4 py-3 flex items-center gap-3 border-b border-[#2a2a2a] shrink-0">
                        <div class="flex gap-1.5 shrink-0"><div class="w-3 h-3 rounded-full bg-[#ff5f57]"></div><div class="w-3 h-3 rounded-full bg-[#febc2e]"></div><div class="w-3 h-3 rounded-full bg-[#28c840]"></div></div>
                        <div class="flex-1 min-w-0 flex items-center gap-2 px-1"><span class="text-xs font-mono font-bold text-emerald-400">200</span><span class="text-xs text-[#52525b]">application/json</span></div>
                        <button @click="copy()" class="shrink-0 flex items-center gap-1.5 px-3 py-1.5 text-xs text-[#71717a] hover:text-[#f4f4f5] bg-[#252525] hover:bg-[#2a2a2a] border border-[#333] rounded-md transition-colors">
                            <svg x-show="!copied" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            <svg x-show="copied" style="display:none" class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span x-text="copied ? 'Copied!' : 'Copy'"></span>
                        </button>
                    </div>
                    <div class="bg-[#0d0d0d] p-5 overflow-x-auto overflow-y-auto font-mono text-[13px] leading-relaxed text-[#a1a1aa] flex-1" style="max-height:340px">
                        <pre class="whitespace-pre"><code>{
  <span class="text-sky-400">"domain"</span>:     <span class="text-emerald-400">"example.com"</span>,
  <span class="text-sky-400">"registered"</span>: <span class="text-amber-400">true</span>,
  <span class="text-sky-400">"expires"</span>:    <span class="text-emerald-400">"2024-08-13T04:00:00Z"</span>,
  <span class="text-sky-400">"checked_at"</span>: <span class="text-emerald-400">"2025-05-18T10:00:00+00:00"</span>
}

<span class="text-zinc-600">// available domain</span>
{
  <span class="text-sky-400">"domain"</span>:     <span class="text-emerald-400">"available-xyz-123.com"</span>,
  <span class="text-sky-400">"registered"</span>: <span class="text-amber-400">false</span>,
  <span class="text-sky-400">"expires"</span>:    <span class="text-zinc-500">null</span>,
  <span class="text-sky-400">"checked_at"</span>: <span class="text-emerald-400">"2025-05-18T10:00:00+00:00"</span>
}</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ─── Bulk Check ───────────────────────────────────────────────────────── --}}
    <section id="bulk-check" class="px-6 sm:px-10 xl:px-14 py-12">
        <div class="max-w-5xl mx-auto">
            <div class="flex flex-wrap items-center gap-3 mb-1">
                <span class="px-2 py-1 text-[11px] font-mono font-bold rounded bg-amber-50 dark:bg-amber-500/15 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-500/20">POST</span>
                <code class="font-mono text-sm text-[#09090b] dark:text-[#e4e4e7]">/api/v1/bulk</code>
            </div>
            <h2 class="text-xl font-semibold tracking-tight mb-2">Bulk Availability Check</h2>
            <p class="text-sm text-[#71717a] mb-8 leading-relaxed">Check the availability of up to 20 domains in a single request. Results for previously-seen domains are served from cache.</p>

            <p class="text-xs font-semibold uppercase tracking-widest text-[#71717a] mb-3">Request Body <span class="normal-case tracking-normal font-normal ml-2 text-[#a1a1aa]">application/json</span></p>
            <div class="rounded-xl border border-[#e4e4e7] dark:border-[#1f1f1f] overflow-hidden mb-8">
                <div class="grid docs-cols-params gap-4 px-4 py-2.5 bg-[#fafafa] dark:bg-[#111] border-b border-[#e4e4e7] dark:border-[#1f1f1f] text-xs font-semibold text-[#71717a] uppercase tracking-widest"><span>Field</span><span>Type</span><span></span><span>Description</span></div>
                <div class="grid docs-cols-params items-center gap-4 px-4 py-3">
                    <code class="text-xs font-mono text-indigo-500 dark:text-indigo-400">domains</code>
                    <span class="text-xs text-[#71717a]">string[]</span>
                    <span class="text-[10px] font-medium text-rose-500 dark:text-rose-400 bg-rose-50 dark:bg-rose-500/10 px-1.5 py-0.5 rounded border border-rose-200 dark:border-rose-500/20 whitespace-nowrap">required</span>
                    <span class="text-sm text-[#71717a]">Array of domain names — max 20 per request</span>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
                <div x-data="editor()" class="rounded-xl overflow-hidden border border-[#252525] shadow-xl flex flex-col">
                    <div class="bg-[#1c1c1c] px-4 py-3 flex items-center gap-3 border-b border-[#2a2a2a] shrink-0">
                        <div class="flex gap-1.5 shrink-0"><div class="w-3 h-3 rounded-full bg-[#ff5f57]"></div><div class="w-3 h-3 rounded-full bg-[#febc2e]"></div><div class="w-3 h-3 rounded-full bg-[#28c840]"></div></div>
                        <div class="flex gap-0.5 overflow-x-auto flex-1 min-w-0" style="scrollbar-width:none">
                            @foreach([['curl','cURL','#e97316'],['js','JavaScript','#eab308'],['php','PHP','#8b5cf6'],['python','Python','#3b82f6']] as [$k,$l,$c])
                            <button @click="tab='{{ $k }}'" :class="tab==='{{ $k }}' ? 'bg-[#2a2a2a] text-[#f4f4f5]' : 'text-[#71717a] hover:text-[#a1a1aa] hover:bg-[#222]'" class="flex items-center gap-1.5 px-3 py-1.5 text-xs rounded-md transition-colors whitespace-nowrap shrink-0">
                                <span class="w-2 h-2 rounded-full shrink-0" style="background:{{ $c }}"></span>{{ $l }}
                            </button>
                            @endforeach
                        </div>
                        <button @click="copy()" class="shrink-0 flex items-center gap-1.5 px-3 py-1.5 text-xs text-[#71717a] hover:text-[#f4f4f5] bg-[#252525] hover:bg-[#2a2a2a] border border-[#333] rounded-md transition-colors">
                            <svg x-show="!copied" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            <svg x-show="copied" style="display:none" class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span x-text="copied ? 'Copied!' : 'Copy'"></span>
                        </button>
                    </div>
                    <div class="bg-[#0d0d0d] p-5 overflow-x-auto font-mono text-[13px] leading-relaxed text-[#a1a1aa] flex-1">
                        <pre data-tab="curl" x-show="tab==='curl'" class="whitespace-pre"><code><span class="text-amber-400">curl</span> -X POST <span class="text-emerald-400">"https://rdaplook.p.rapidapi.com/api/v1/bulk"</span> \
  -H <span class="text-emerald-400">"X-RapidAPI-Key: YOUR_API_KEY"</span> \
  -H <span class="text-emerald-400">"X-RapidAPI-Host: rdaplook.p.rapidapi.com"</span> \
  -H <span class="text-emerald-400">"Content-Type: application/json"</span> \
  -d <span class="text-emerald-400">'{"domains":["example.com","google.com","free-xyz.com"]}'</span></code></pre>
                        <pre data-tab="js" x-show="tab==='js'" style="display:none" class="whitespace-pre"><code><span class="text-purple-400">const</span> res = <span class="text-purple-400">await</span> <span class="text-amber-400">fetch</span>(
  <span class="text-emerald-400">"https://rdaplook.p.rapidapi.com/api/v1/bulk"</span>,
  {
    method: <span class="text-emerald-400">"POST"</span>,
    headers: {
      <span class="text-emerald-400">"X-RapidAPI-Key"</span>:  <span class="text-emerald-400">"YOUR_API_KEY"</span>,
      <span class="text-emerald-400">"X-RapidAPI-Host"</span>: <span class="text-emerald-400">"rdaplook.p.rapidapi.com"</span>,
      <span class="text-emerald-400">"Content-Type"</span>:    <span class="text-emerald-400">"application/json"</span>,
    },
    body: <span class="text-sky-400">JSON</span>.<span class="text-amber-400">stringify</span>({
      domains: [<span class="text-emerald-400">"example.com"</span>, <span class="text-emerald-400">"google.com"</span>, <span class="text-emerald-400">"free-xyz.com"</span>],
    }),
  }
);
<span class="text-purple-400">const</span> data = <span class="text-purple-400">await</span> res.<span class="text-amber-400">json</span>();</code></pre>
                        <pre data-tab="php" x-show="tab==='php'" style="display:none" class="whitespace-pre"><code><span class="text-sky-400">$res</span> = Http::<span class="text-amber-400">withHeaders</span>([
    <span class="text-emerald-400">'X-RapidAPI-Key'</span>  => <span class="text-emerald-400">'YOUR_API_KEY'</span>,
    <span class="text-emerald-400">'X-RapidAPI-Host'</span> => <span class="text-emerald-400">'rdaplook.p.rapidapi.com'</span>,
])-><span class="text-amber-400">post</span>(
    <span class="text-emerald-400">'https://rdaplook.p.rapidapi.com/api/v1/bulk'</span>,
    [<span class="text-emerald-400">'domains'</span> => [<span class="text-emerald-400">'example.com'</span>, <span class="text-emerald-400">'google.com'</span>, <span class="text-emerald-400">'free-xyz.com'</span>]]
);
<span class="text-sky-400">$data</span> = <span class="text-sky-400">$res</span>-><span class="text-amber-400">json</span>();</code></pre>
                        <pre data-tab="python" x-show="tab==='python'" style="display:none" class="whitespace-pre"><code><span class="text-purple-400">import</span> requests

res = requests.<span class="text-amber-400">post</span>(
    <span class="text-emerald-400">"https://rdaplook.p.rapidapi.com/api/v1/bulk"</span>,
    headers={
        <span class="text-emerald-400">"X-RapidAPI-Key"</span>:  <span class="text-emerald-400">"YOUR_API_KEY"</span>,
        <span class="text-emerald-400">"X-RapidAPI-Host"</span>: <span class="text-emerald-400">"rdaplook.p.rapidapi.com"</span>,
    },
    json={<span class="text-emerald-400">"domains"</span>: [<span class="text-emerald-400">"example.com"</span>, <span class="text-emerald-400">"google.com"</span>, <span class="text-emerald-400">"free-xyz.com"</span>]},
)
data = res.<span class="text-amber-400">json</span>()</code></pre>
                    </div>
                </div>
                <div x-data="respEditor()" class="rounded-xl overflow-hidden border border-[#252525] shadow-xl flex flex-col">
                    <div class="bg-[#1c1c1c] px-4 py-3 flex items-center gap-3 border-b border-[#2a2a2a] shrink-0">
                        <div class="flex gap-1.5 shrink-0"><div class="w-3 h-3 rounded-full bg-[#ff5f57]"></div><div class="w-3 h-3 rounded-full bg-[#febc2e]"></div><div class="w-3 h-3 rounded-full bg-[#28c840]"></div></div>
                        <div class="flex-1 min-w-0 flex items-center gap-2 px-1"><span class="text-xs font-mono font-bold text-emerald-400">200</span><span class="text-xs text-[#52525b]">application/json</span></div>
                        <button @click="copy()" class="shrink-0 flex items-center gap-1.5 px-3 py-1.5 text-xs text-[#71717a] hover:text-[#f4f4f5] bg-[#252525] hover:bg-[#2a2a2a] border border-[#333] rounded-md transition-colors">
                            <svg x-show="!copied" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            <svg x-show="copied" style="display:none" class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span x-text="copied ? 'Copied!' : 'Copy'"></span>
                        </button>
                    </div>
                    <div class="bg-[#0d0d0d] p-5 overflow-x-auto overflow-y-auto font-mono text-[13px] leading-relaxed text-[#a1a1aa] flex-1" style="max-height:340px">
                        <pre class="whitespace-pre"><code>{
  <span class="text-sky-400">"results"</span>: [
    {
      <span class="text-sky-400">"domain"</span>:     <span class="text-emerald-400">"example.com"</span>,
      <span class="text-sky-400">"registered"</span>: <span class="text-amber-400">true</span>,
      <span class="text-sky-400">"expires"</span>:    <span class="text-emerald-400">"2024-08-13T04:00:00Z"</span>,
      <span class="text-sky-400">"checked_at"</span>: <span class="text-emerald-400">"2025-05-18T10:00:00+00:00"</span>
    },
    {
      <span class="text-sky-400">"domain"</span>:     <span class="text-emerald-400">"google.com"</span>,
      <span class="text-sky-400">"registered"</span>: <span class="text-amber-400">true</span>,
      <span class="text-sky-400">"expires"</span>:    <span class="text-emerald-400">"2028-09-14T04:00:00Z"</span>,
      <span class="text-sky-400">"checked_at"</span>: <span class="text-emerald-400">"2025-05-18T10:00:00+00:00"</span>
    },
    {
      <span class="text-sky-400">"domain"</span>:     <span class="text-emerald-400">"free-xyz.com"</span>,
      <span class="text-sky-400">"registered"</span>: <span class="text-amber-400">false</span>,
      <span class="text-sky-400">"expires"</span>:    <span class="text-zinc-500">null</span>,
      <span class="text-sky-400">"checked_at"</span>: <span class="text-emerald-400">"2025-05-18T10:00:00+00:00"</span>
    }
  ]
}</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>
</div>{{-- /.flex --}}
</div>{{-- /outer x-data --}}

<script>
function editor() {
    return {
        tab: 'curl',
        copied: false,
        copy() {
            const pre = this.$root.querySelector('pre[data-tab=' + this.tab + ']');
            if (!pre) return;
            navigator.clipboard.writeText(pre.textContent.trim());
            this.copied = true;
            setTimeout(() => this.copied = false, 2000);
        }
    };
}
function respEditor() {
    return {
        copied: false,
        copy() {
            const pre = this.$root.querySelector('pre');
            if (!pre) return;
            navigator.clipboard.writeText(pre.textContent.trim());
            this.copied = true;
            setTimeout(() => this.copied = false, 2000);
        }
    };
}
</script>
@endsection
